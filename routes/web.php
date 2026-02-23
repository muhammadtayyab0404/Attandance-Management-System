<?php

use App\Http\Controllers\Attendance;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Login;

Route::middleware(['guest'])->group(function (){

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('login/login');
})->name('login');

Route::get('/register', function () {
    return view('login/register');
})->name('register');


Route::post('/register', [Login::class, 'register'])->name('regis');
Route::post('/loginn', [Login::class, 'loginn'])->name('loginn');


});



Route::middleware(['auth'])->group(function (){
Route::post('/logout', [Login::class, 'logout'])->name('logout');

   // Student routes
Route::middleware(['StudentMiddleware'])->group(function (){

Route::get('/dashboard',[Attendance::class,'dashboardstats']) 
->name('dashboard');

Route::post('/newatten', [Attendance::class, 'newattendance'])->name('newattendance');

Route::get('/studentrecord',[Attendance::class,'studentstats']) 
->name('studentstats');

Route::get('/leaverequest',[Attendance::class,'showleave']) 
->name('showleave');

Route::post('/leaverequest', [Attendance::class, 'leaverequest'])->name('leaverequest');

Route::get('/studenttask',[Attendance::class,'studenttask']) 
->name('studenttask');

Route::get('/studenttask/{id}',[Attendance::class,'studenttaskshow']) 
->name('studenttask.show');

//profile
Route::get('/showprofilss',[Attendance::class,'showprofile']) 
->name('showprofilss');

Route::post('/updateprofiless', [Attendance::class, 'updateprofile'])->name('updateprofiless');

Route::post('/submittask/{id}', [Attendance::class, 'submitTask'])->name('submittask');


});

// Admin Routes
Route::middleware(['AdminMiddleware'])->group(function (){

Route::get('/admindashboard',[AdminController::class,'admindashboardstats']) 
->name('admindashboard');

Route::get('/stuattend',[AdminController::class,'stuAttend']) 
->name('stuattend');

Route::get('/stuattend/{id}',[AdminController::class,'stuShowatten']) 
->name('showattend');

Route::post('/deleteattend/{id}',[AdminController::class,'deleteAttend']) 
->name('deleteattend');

Route::post('/removeattend/{id}',[AdminController::class,'removeAttend']) 
->name('removeattend');

Route::post('/updateattend/{id}',[AdminController::class,'updateAttend']) 
->name('updateattend');

Route::get('/adminleave',[AdminController::class,'adminLeave']) 
->name('adminleave');

Route::get('/showleave/{id}',[AdminController::class,'showLeave']) 
->name('adminshowleave');

Route::post('/deleteleave/{id}',[AdminController::class,'deleteLeave']) 
->name('deleteleave');

Route::post( '/adminleavereq/{id}',[AdminController::class,'adminLeavereq']) 
->name('adminleavereq');

// Admin profile

Route::get('/showprofile',[AdminController::class,'showprofile']) 
->name('showprofile');
Route::post('/updateprofile', [AdminController::class, 'updateprofile'])->name('updateprofile');

//student Summary

Route::get('/attensummary',[AdminController::class,'attenSummary']) 
->name('attensummary');

Route::get('/selecteddates',[AdminController::class,'selectedDates']) 
->name('selecteddates');

Route::get('/checkgrades',[AdminController::class,'checkGrades']) 
->name('checkgrades');

Route::get('/viewadmintask',[AdminController::class,'viewadminTask']) 
->name('viewadmintask');

Route::get('/addtaskadmin',[AdminController::class,'addtaskAdmin']) 
->name('addtaskadmin');

Route::post('/taskadeed', [AdminController::class, 'taskAdeed'])->name('taskadeed');

Route::post( '/aprrovestatus/{id}',[AdminController::class,'aprroveStatus']) 
->name('aprrovestatus');

Route::post( '/rejectstatus/{id}',[AdminController::class,'rejectStatus']) 
->name('rejectstatus');

Route::get( '/viewusertask/{usr}/{tsk}',[AdminController::class,'viewuserTask']) 
->name('viewusertask');

Route::post( '/updateuserstask',[AdminController::class,'updateusersTask']) 
->name('updateuserstask');



});



});



