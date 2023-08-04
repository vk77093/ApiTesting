<?php

use App\Http\Controllers\Authorization\UserAuthorizationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

use App\Http\Controllers\Student\ClassController;
use App\Http\Controllers\Student\SectionController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\SubjectController;

Route::controller(ClassController::class)->group(function(){
Route::get('showclass','ShowClass');
Route::post('showclass/create','CreateClass');
Route::get('showclass/edit/{id}','EditClass');
Route::post('showclass/update/{id}','UpdateClass');
Route::get('showclass/delete/{id}','DeleteClass');
});

// Route::controller(SectionController::class)->group(function(){
// Route::resource()
// });
Route::resource('/section',SectionController::class);
Route::resource('/subject',SubjectController::class);
Route::resource('/student',StudentController::class);

//User Authorization
Route::controller(UserAuthorizationController::class)->group(function(){
Route::post('/login','LoginHandle');
Route::post('/register','UserRegisteration');
Route::post('/forgotpassword','ForgotPassword');
Route::post('/resetpassword','ResetPassword');
Route::get('/user','AuthenticateUser')->middleware('auth:api');
});
