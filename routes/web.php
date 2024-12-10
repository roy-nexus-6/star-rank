<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CelebrityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome')->name('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/ranking', [CelebrityController::class, 'ranking'])->name('ranking');
Route::get('/unpopular', [CelebrityController::class, 'unpopular'])->name('unpopular');
Route::get('/trending/{period}', [CelebrityController::class, 'trending'])->name('trending');
Route::get('/celebrity/{id}', [CelebrityController::class, 'show'])->name('celebrity.show');
Route::post('/celebrity/{id}/vote', [CelebrityController::class, 'vote'])->name('celebrity.vote');
Route::post('/celebrity/{id}/comment', [CommentController::class, 'store'])->name('comment.store');
Route::get('/search', [SearchController::class, 'search'])->name('search');



require __DIR__.'/auth.php';
