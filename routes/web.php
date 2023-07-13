<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::Post('/UserLogin',[UserController::class,'UserLogin']);
Route::Post('/UserRegistration',[UserController::class,'UserRegistration']);
Route::Post('/SendOtpToEmail',[UserController::class,'SendOtpToEmail']);
Route::Post('/VerifyOtp',[UserController::class,'VerifyOtp']);
Route::Post('/SetPassword',[UserController::class,'SetPassword']);
Route::Post('/ProfileUpdate',[UserController::class,'ProfileUpdate']);

