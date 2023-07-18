<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('/UserLogin',[UserController::class,'UserLogin']);
Route::post('/UserRegistration',[UserController::class,'UserRegistration']);
Route::post('/sendOtpToUserEmail',[UserController::class,'sendOtpToUserEmail']);
Route::post('/OtpVerify',[UserController::class,'OtpVerify']);
Route::post('/SetPassword',[UserController::class,'SetPassword'])
->middleware([TokenVerificationMiddleware::class]);
Route::post('/ProfileUpdate',[UserController::class,'ProfileUpdate']);
