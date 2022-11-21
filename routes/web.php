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

Route::get('/trackers/{product_id}/update', [TrackerController::class, 'update'])->middleware(['auth'])->name('trackers.update');
Route::patch('/trackers/{product_id}/edit', [TrackerController::class, 'edit'])->middleware(['auth'])->name('trackers.edit');

Route::get('/trackers/{product_id}/remove', [TrackerController::class, 'remove'])->middleware(['auth'])->name('trackers.remove');
Route::delete('/trackers/{product_id}/delete', [TrackerController::class, 'delete'])->middleware(['auth'])->name('trackers.delete');

require __DIR__.'/auth.php';
