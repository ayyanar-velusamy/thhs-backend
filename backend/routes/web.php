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


 

Auth::routes();
Route::get('/verify/email/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'verifyEmail']);
Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout');
 
Route::group(['middleware'=>'auth'], function(){	
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/thhs/prospect_personal_info/{id}',[App\Http\Controllers\PersonalInformationController::class, 'personal_info'])->name('personal_info');
    Route::post('update_personal_info/{id}',[App\Http\Controllers\PersonalInformationController::class, 'update_personal_info'])->name('update_personal_info');
  
 

    Route::get('/thhs/app/prospects', [App\Http\Controllers\ProspectsController::class, 'index'])->name('prospects');
    Route::get('/thhs/app/prospects2', [App\Http\Controllers\ProspectsController::class, 'table'])->name('prospects_table');
    Route::get('/thhs/app/prospects/demographics/{id}', [App\Http\Controllers\ProspectsController::class, 'demographics'])->name('prospects.demographics'); 
    Route::post('/thhs/app/prospects/schedule_interview/{id}', [App\Http\Controllers\ProspectsController::class, 'schedule_interview'])->name('prospects.schedule_interview'); 
    Route::post('/thhs/app/prospects/confirm_interview/{id}', [App\Http\Controllers\ProspectsController::class, 'confirm_interview'])->name('prospects.confirm_interview'); 
    Route::post('add_prospect',[App\Http\Controllers\ProspectsController::class, 'add_prospect'])->name('add_prospect');
    
});
	





 
 