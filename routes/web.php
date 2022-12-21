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

Route::get('/trackers', function () {
    $products = auth()->user()->products()->wherePivot('archived', 0)->paginate(10);
    $archived_count = auth()->user()->products()->wherePivot('archived', 1)->count();
    return view('dashboard', ['products' => $products, 'archived_count'=>$archived_count]);
})->middleware(['auth'])->name('dashboard');

Route::get('/trackers/archived', function () {
    $products = auth()->user()->products()->get();

    return view('trackers.archived', ['products' => $products]);
})->middleware(['auth'])->name('trackers.archived');

Route::match(['get', 'post'], '/trackers/new', [TrackerController::class, 'new'], function () {
})->middleware(['auth'])->name('trackers.new');

Route::get('/trackers/archive/{product_id}', [TrackerController::class, 'archive'])->middleware(['auth'])->name('trackers.archive');
Route::get('/trackers/unarchive/{product_id}', [TrackerController::class, 'unarchive'])->middleware(['auth'])->name('trackers.unarchive');

Route::get('/trackers/{product_id}', [TrackerController::class, 'view'])->middleware(['auth'])->name('trackers.view');

Route::get('/trackers/{product_id}/update', [TrackerController::class, 'update'])->middleware(['auth'])->name('trackers.update');
Route::patch('/trackers/{product_id}/edit', [TrackerController::class, 'edit'])->middleware(['auth'])->name('trackers.edit');

Route::get('/trackers/{product_id}/remove', [TrackerController::class, 'remove'])->middleware(['auth'])->name('trackers.remove');
Route::delete('/trackers/{product_id}/delete', [TrackerController::class, 'delete'])->middleware(['auth'])->name('trackers.delete');

Route::get('/trackers/{product_id}/listings', [TrackerController::class, 'others'])->middleware(['auth'])->name('trackers.others');

Route::post('/tracker/track/{product_id}', [TrackerController::class, 'quickTrack'])->middleware(['auth'])->name('trackers.quickTrack');

require __DIR__.'/auth.php';
