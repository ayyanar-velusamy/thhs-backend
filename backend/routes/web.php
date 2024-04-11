<?php

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

Route::get('/thhs/register', function () { 
    return view('auth/register');
});
Route::get('/thhs/login', function () {
    return view('auth/login');
});

Route::get('/thhs/app/prospects', function () {
    return view('prospects/prospect');
});
Route::get('/thhs/app/prospects/demographics', function () {
    return view('prospects/demographics');
});
Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
