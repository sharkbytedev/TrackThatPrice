<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

Route::match(["get", "post"], "/trackers/{product_id}", function (Request $request, string $product_id) {
    /** @var App\Models\User */
    $user = Auth::user();
    $product = $user->products()->find($product_id);

    return isset($product) ? view("view-tracker", ["product" => $product]) : redirect("/dashboard");


})->middleware(["auth"]);

require __DIR__.'/auth.php';
