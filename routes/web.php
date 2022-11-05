<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home/{userId}', [Controllers\CommentController::class, 'index'])->name('profile.index');

Route::post('/home/{userId}', [Controllers\CommentController::class, 'store']);

Route::delete('/home/{userId}', [Controllers\CommentController::class, 'destroy']);

Route::get('/fetch-comments/{userId}', [Controllers\CommentController::class, 'getMoreComments'])->name('fetch-comm');

Route::get('home/{userId}/lib', [Controllers\BookController::class, 'index'])->middleware('library.access')->name('profile.library');

Route::get('home/{userId}/lib/create', [Controllers\BookController::class, 'create'])->name('profile.createBook');

Route::post('home/{userId}/lib/create', [Controllers\BookController::class, 'store'])->name('profile.createBook');

Route::get('home/{userId}/lib/{bookId}', [Controllers\BookController::class, 'show'])->middleware('book.access')->name('profile.readBook');

Route::get('home/{userId}/lib/edit/{bookId}', [Controllers\BookController::class, 'edit'])->name('profile.editBook');

Route::post('home/{userId}/lib/edit/{bookId}', [Controllers\BookController::class, 'update']);

Route::delete('home/{userId}/lib', [Controllers\BookController::class, 'destroy']);

Route::put('home/{userId}/lib', [Controllers\BookController::class, 'update']);

Route::post('home/lib/access', [Controllers\AccessController::class, 'store'])->name('create.access');

Route::delete('home/lib/access', [Controllers\AccessController::class, 'destroy'])->name('destroy.access');




