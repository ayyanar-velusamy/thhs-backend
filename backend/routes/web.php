<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProspectsController;
use App\Http\Controllers\MailController;

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
Route::get('/thhs/app/prospects', [App\Http\Controllers\ProspectsController::class, 'index'])->name('prospects');
Route::get('/thhs/app/prospects2', [App\Http\Controllers\ProspectsController::class, 'table'])->name('prospects_table');
Route::get('/thhs/app/prospects/demographics', [App\Http\Controllers\ProspectsController::class, 'demographics'])->name('prospects.demographics');

// Route::get('/sendhtmlmail', [App\Http\Controllers\MailController::class, 'html_mail'])->name('html_mail');
 