<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProspectsController;

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

Route::get('/thhs/prospect_personal_info', function () {
    return view('prospect_personal_info');
});
 
Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/thhs/app/prospects', 'ProspectsController@index')->name('prospects');
Route::get('/thhs/app/prospects/demographics', 'ProspectsController@demographics')->name('prospects.demographics');
