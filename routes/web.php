<?php

use App\Http\Controllers\TrackerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/trackers/{product_id}', [TrackerController::class, 'view'])->middleware(['auth'])->name('trackers.view');

Route::match(['get', 'post'], '/trackers/new', function () {
    $product = new App\Models\Product();
    if (isset($_POST['Submitted'])) {
        $product->store = $_POST['store'];
        $product->product_url = $_POST['productURL'];

        $handler = App\ProductHandlers\ProductHandlerFactory::new($product);
        $product_details = $handler::crawl($product);

        if ($product_details->name != null) {
            $product->product_name = $product_details->name;
        } else {
            $product->product_name = 'Product';
        }

        if ($product_details->image_url != null) {
            $product->image_url = $product_details->image_url;
        } else {
            $product->image_url = 'https://cdn.discordapp.com/attachments/620091571521454082/1027339673225396285/unknown.png'; //this is a placeholder
        }

        $product->price = $product_details->price;
        $product->save();
        $lastid = $product->id;
        Auth::user()->products()->attach($lastid);

        $productCreated = true;
    } else {
        $productCreated = false;
    }

    return view('trackers/new', ['productCreated' => $productCreated], ['product' => $product]);
})->middleware(['auth'])->name('trackers/new');

Route::get('/trackers', function () {
    $products = auth()->user()->products()->get();

    return view('trackers', ['products' => $products]);
})->middleware(['auth'])->name('trackers');

require __DIR__.'/auth.php';
