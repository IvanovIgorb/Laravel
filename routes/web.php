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

Route::get('/home/{username}', [Controllers\ProfileController::class, 'getProfile'])->name('profile.index');

Route::get('/fetch-comments/{username}', [Controllers\ProfileController::class, 'getMoreComments'])->name('fetch');

Route::post('/home/{username}', [Controllers\ProfileController::class, 'postComment']);


