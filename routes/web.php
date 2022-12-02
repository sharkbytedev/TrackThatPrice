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
    $products = auth()->user()->products()->get();
    return view('dashboard', ['products' => $products]);
})->middleware(['auth'])->name('dashboard');

Route::get('/trackers/archived', function () {
    $products = auth()->user()->products()->get();
    return view('trackers.archived', ['products' => $products]);
})->middleware(['auth'])->name('trackers.archived');

Route::match(['get', 'post'], '/trackers/new', [TrackerController::class, 'new'], function () {
})->middleware(['auth'])->name('trackers.new');

Route::get('/trackers/{product_id}', [TrackerController::class, 'view'])->middleware(['auth'])->name('trackers.view');

require __DIR__.'/auth.php';
