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

Route::get('/fetch-comments/{userId}', [Controllers\CommentController::class, 'getMoreComments'])->name('fetch-comm');

Route::get('home/{userId}/lib', [Controllers\BookController::class, 'index'])->name('profile.library');

Route::get('home/{userId}/read/{bookname}', [Controllers\BookController::class, 'show'])->name('profile.readbook');

Route::get('home/{userId}/edit/{bookname}', [Controllers\BookController::class, 'edit'])->name('profile.editbook');

Route::post('home/{userId}/edit/{bookname}', [Controllers\BookController::class, 'update']);

Route::post('/home/{userId}', [Controllers\CommentController::class, 'store']);

Route::delete('/home/{userId}', [Controllers\CommentController::class, 'destroy']);


