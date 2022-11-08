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

Route::get('/comment/{userId}', [Controllers\CommentController::class, 'index'])->name('profile.index');

Route::post('/comment/{userId}', [Controllers\CommentController::class, 'store']);

Route::delete('/comment/{userId}', [Controllers\CommentController::class, 'destroy']);

Route::get('/fetch-comments/{userId}', [Controllers\CommentController::class, 'getMoreComments'])->name('fetch-comm');

Route::group([
    'prefix' => '/library',
], function (){
    Route::get('{userId}', [Controllers\BookController::class, 'index'])->middleware('library.access')->name('profile.library');

    Route::get('create/{userId}', [Controllers\BookController::class, 'create'])->name('profile.createBook');

    Route::post('create/{userId}', [Controllers\BookController::class, 'store'])->name('profile.createBook');

    Route::get('{userId}/{bookId}', [Controllers\BookController::class, 'show'])->middleware('book.access')->name('profile.readBook');

    Route::get('{userId}/edit/{bookId}', [Controllers\BookController::class, 'edit'])->middleware('bookFunctions.access')->name('profile.editBook');

    Route::post('{userId}/edit/{bookId}', [Controllers\BookController::class, 'update'])->middleware('bookFunctions.access');

    Route::delete('{userId}', [Controllers\BookController::class, 'destroy']);

    Route::put('{userId}', [Controllers\BookController::class, 'update']);

    Route::post('access', [Controllers\AccessController::class, 'store'])->name('create.access');

    Route::delete('access', [Controllers\AccessController::class, 'destroy'])->name('destroy.access');
});






