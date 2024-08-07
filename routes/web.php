<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProspectsController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DWTUploadController;



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
    return redirect('/login');
});
Route::get('/thhs/register', function () { 
    return view('auth/register');
});
Route::get('/thhs/login', function () {
    return view('auth/login');
});


// Route::get('/viewer', function () { 
//     return view('viewer');
// });
// Route::get('/designer', function () {
//     return view('designer');
// });
Route::get('/designer', [App\Http\Controllers\ReportController::class, 'designer'])->name('designer');
Route::get('/viewer', [App\Http\Controllers\ReportController::class, 'viewer'])->name('viewer');
Route::get('/export', [App\Http\Controllers\ReportController::class, 'export'])->name('export');

Route::any('/handler', [App\Http\Controllers\HandlerController::class, 'process']);

//dynamsoft routes
Route::get('/dwt_upload', 'App\Http\Controllers\DWTUploadController@page');
Route::post('/dwt_upload/upload', [App\Http\Controllers\DWTUploadController::class, 'upload'])->name('dwtupload_upload'); 
//dynamsoft routes

Auth::routes();
Route::get('/verify/email/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'verifyEmail']); 
Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout');
 
Route::group(['middleware'=>'auth'], function(){	
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/thhs/prospect_personal_info/{id}',[App\Http\Controllers\PersonalInformationController::class, 'personal_info'])->name('personal_info');
    Route::post('update_personal_info/{id}',[App\Http\Controllers\PersonalInformationController::class, 'update_personal_info'])->name('update_personal_info');
  
 

    Route::get('/thhs/app/prospects', [App\Http\Controllers\ProspectsController::class, 'index'])->name('prospects');
    // Route::get('/thhs/app/prospects2', [App\Http\Controllers\ProspectsController::class, 'table'])->name('prospects_table');
    Route::get('/thhs/app/prospects/demographics/{id}', [App\Http\Controllers\ProspectsController::class, 'demographics'])->name('prospects.demographics'); 
    Route::post('/thhs/app/prospects/update_demographics/{id}',[App\Http\Controllers\ProspectsController::class, 'update_demographics'])->name('update_demographics');
    Route::post('/thhs/app/prospects/schedule_interview/{id}', [App\Http\Controllers\ProspectsController::class, 'schedule_interview'])->name('prospects.schedule_interview'); 
    Route::post('/thhs/app/prospects/confirm_interview/{id}', [App\Http\Controllers\ProspectsController::class, 'confirm_interview'])->name('prospects.confirm_interview'); 
    Route::post('/thhs/app/prospects/cancel_interview/{id}', [App\Http\Controllers\ProspectsController::class, 'cancel_interview'])->name('prospects.cancel_interview'); 
    Route::get('/thhs/app/prospects/reject_prospect/{id}', [App\Http\Controllers\ProspectsController::class, 'reject_prospect'])->name('prospects.reject_prospect'); 
    Route::get('/thhs/app/prospects/reapply_prospect/{id}', [App\Http\Controllers\ProspectsController::class, 'reapply_prospect'])->name('prospects.reapply_prospect'); 
    Route::get('/thhs/app/prospects/archive_prospect/{id}', [App\Http\Controllers\ProspectsController::class, 'archive_prospect'])->name('prospects.archive_prospect'); 
    Route::post('/thhs/app/prospects/hire_prospect', [App\Http\Controllers\ProspectsController::class, 'hire_prospect'])->name('prospects.hire_prospect'); 
    Route::post('/thhs/app/prospects/add_prospect',[App\Http\Controllers\ProspectsController::class, 'add_prospect'])->name('add_prospect');


    /*Prospects HR Routing */
    Route::get('/thhs/app/prospects/hr/{id}', [App\Http\Controllers\DocumentController::class, 'hr'])->name('prospects.hr'); 
    Route::post('/thhs/app/upload_document', [App\Http\Controllers\DocumentController::class, 'upload_document'])->name('upload_document'); 
    Route::post('/thhs/app/document/update_details', [App\Http\Controllers\DocumentController::class, 'update_details'])->name('document.update_details'); 
    Route::post('/thhs/app/document/delete_document', [App\Http\Controllers\DocumentController::class, 'delete_document'])->name('document.delete_document'); 
    Route::get('/thhs/app/document/get_deleted_documents', [App\Http\Controllers\DocumentController::class, 'get_deleted_documents'])->name('document.get_deleted_documents'); 


    /* Staff Routing */
    /*Staffs Routing */
    Route::get('/thhs/app/staffs', [App\Http\Controllers\StaffController::class, 'index'])->name('staffs');
    Route::get('/thhs/app/staffs/demographics/{id}', [App\Http\Controllers\StaffController::class, 'demographics'])->name('staffs.demographics'); 
    Route::post('/thhs/app/staffs/update_demographics/{id}',[App\Http\Controllers\StaffController::class, 'update_demographics'])->name('staffs.update_demographics');
    Route::post('/thhs/app/staffs/save_staff',[App\Http\Controllers\StaffController::class, 'save_staff'])->name('save_staff');
    Route::get('/thhs/app/staffs/get_staff/{id}',[App\Http\Controllers\StaffController::class, 'get_staff'])->name('get_staff'); 
    Route::get('/thhs/app/staffs/delete_staff/{id}',[App\Http\Controllers\StaffController::class, 'delete_staff'])->name('delete_staff'); 
    Route::get('/thhs/app/staffs/contact_information/{id}', [App\Http\Controllers\StaffController::class, 'contact_information'])->name('staffs.contact_information'); 
   
    // Staff - Emergency Contact
    Route::post('/thhs/app/staffs/add_emergency_contact',[App\Http\Controllers\StaffController::class, 'add_emergency_contact'])->name('staffs.add_emergency_contact');
    Route::get('/thhs/app/staffs/get_emergency_contact/{id}',[App\Http\Controllers\StaffController::class, 'get_emergency_contact'])->name('staffs.get_emergency_contact'); 
    Route::get('/thhs/app/staffs/delete_emergency_contact/{id}',[App\Http\Controllers\StaffController::class, 'delete_emergency_contact'])->name('staffs.delete_emergency_contact'); 
    // Staff - Address
    Route::post('/thhs/app/staffs/add_address',[App\Http\Controllers\StaffController::class, 'add_address'])->name('staffs.add_address');
    Route::get('/thhs/app/staffs/get_address/{id}',[App\Http\Controllers\StaffController::class, 'get_address'])->name('staffs.get_address'); 
    Route::get('/thhs/app/staffs/delete_address/{id}',[App\Http\Controllers\StaffController::class, 'delete_address'])->name('staffs.delete_address'); 

    // Staff - Phone
    Route::post('/thhs/app/staffs/add_phone',[App\Http\Controllers\StaffController::class, 'add_phone'])->name('staffs.add_phone');
    Route::get('/thhs/app/staffs/get_phone/{id}',[App\Http\Controllers\StaffController::class, 'get_phone'])->name('staffs.get_phone'); 
    Route::get('/thhs/app/staffs/delete_phone/{id}',[App\Http\Controllers\StaffController::class, 'delete_phone'])->name('staffs.delete_phone'); 
    
    // Staff - Email
    Route::post('/thhs/app/staffs/add_email',[App\Http\Controllers\StaffController::class, 'add_email'])->name('staffs.add_email');
    Route::get('/thhs/app/staffs/get_email/{id}',[App\Http\Controllers\StaffController::class, 'get_email'])->name('staffs.get_email'); 
    Route::get('/thhs/app/staffs/delete_email/{id}',[App\Http\Controllers\StaffController::class, 'delete_email'])->name('staffs.delete_email'); 
    

     /*Charts Routing */
     Route::get('/thhs/app/charts', [App\Http\Controllers\ChartController::class, 'index'])->name('charts');
     Route::post('/thhs/app/charts/save_chart',[App\Http\Controllers\ChartController::class, 'save_chart'])->name('save_chart');
     Route::get('/thhs/app/charts/get_chart/{id}',[App\Http\Controllers\ChartController::class, 'get_chart'])->name('get_chart');  
     Route::get('/thhs/app/charts/delete_chart/{id}',[App\Http\Controllers\ChartController::class, 'delete_chart'])->name('delete_chart');  
     Route::post('/thhs/app/charts/save_chart_category',[App\Http\Controllers\ChartController::class, 'save_chart_category'])->name('save_chart_category');

      /*User Role Routing */
      Route::get('/thhs/app/roles', [App\Http\Controllers\UserRoleController::class, 'index'])->name('roles');
      Route::post('/thhs/app/roles/save_role',[App\Http\Controllers\UserRoleController::class, 'save_role'])->name('save_role');
      Route::get('/thhs/app/roles/get_role/{id}',[App\Http\Controllers\UserRoleController::class, 'get_role'])->name('get_role');  
      Route::get('/thhs/app/roles/delete_role/{id}',[App\Http\Controllers\UserRoleController::class, 'delete_role'])->name('delete_role');   

     /*User Routing */
     Route::get('/thhs/app/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
     Route::post('/thhs/app/users/save_user',[App\Http\Controllers\UserController::class, 'save_user'])->name('save_user');
     Route::get('/thhs/app/users/get_user/{id}',[App\Http\Controllers\UserController::class, 'get_user'])->name('get_user');  
     Route::get('/thhs/app/users/delete_user/{id}',[App\Http\Controllers\UserController::class, 'delete_user'])->name('delete_user');   

    /*HR Routing */
     Route::get('/thhs/app/staffs/hr/{id}', [App\Http\Controllers\DocumentController::class, 'hr'])->name('staffs.hr'); 
     Route::post('/thhs/app/upload_document', [App\Http\Controllers\DocumentController::class, 'upload_document'])->name('upload_document'); 
     Route::post('/thhs/app/document/update_details', [App\Http\Controllers\DocumentController::class, 'update_details'])->name('document.update_details'); 
     Route::post('/thhs/app/document/delete_document', [App\Http\Controllers\DocumentController::class, 'delete_document'])->name('document.delete_document'); 
     Route::get('/thhs/app/document/get_deleted_documents', [App\Http\Controllers\DocumentController::class, 'get_deleted_documents'])->name('document.get_deleted_documents'); 
     Route::get('/thhs/app/document/recover_deleted_document/{id}', [App\Http\Controllers\DocumentController::class, 'recover_deleted_document'])->name('document.recover_deleted_document'); 

       /*Report Routing */
       Route::get('/thhs/app/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports'); 
       Route::post('/thhs/app/reports/save_report',[App\Http\Controllers\ReportController::class, 'save_report'])->name('save_report');
       Route::get('/thhs/app/reports/get_report/{id}',[App\Http\Controllers\ReportController::class, 'get_report'])->name('get_report');  
    //    Route::get('/thhs/app/charts/delete_chart/{id}',[App\Http\Controllers\ChartController::class, 'delete_chart'])->name('delete_chart');  
    //    Route::post('/thhs/app/charts/save_chart_category',[App\Http\Controllers\ChartController::class, 'save_chart_category'])->name('save_chart_category');
  
});
	





 
 