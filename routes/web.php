<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\TokenVarificationMiddleware;

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
    return view('pages.auth.login-page');
});

Route::Post('/User-Login', [UserController::class, 'UserLogin']);
Route::Post('/User-Registration', [UserController::class, 'UserRegistration']);
Route::Post('/Send-OtpToEmail', [UserController::class, 'SendOtpToEmail']);
Route::Post('/Verify-Otp', [UserController::class, 'VerifyOtp']);
//verify Token
Route::Post('/Reset-Password', [UserController::class, 'ResetPassword'])
    ->middleware([TokenVarificationMiddleware::class]);
Route::Post('/ProfileUpdate', [UserController::class, 'ProfileUpdate']);


Route::get('/user-profile', [UserController::class, 'userProfile'])->middleware([TokenVarificationMiddleware::class]);

Route::post('/update-Profile', [UserController::class, 'updateProfile'])->middleware([TokenVarificationMiddleware::class]);

// Page Routes
Route::get('/userLogin', [UserController::class, 'LoginPage']);
Route::get('/userRegistration', [UserController::class, 'RegistrationPage']);
Route::get('/sendOtp', [UserController::class, 'SendOtpPage']);
Route::get('/verifyOtp', [UserController::class, 'VerifyOTPPage']);
Route::get('/resetPassword', [UserController::class, 'ResetPasswordPage'])->middleware([TokenVarificationMiddleware::class]);

//logout

Route::get('/logout', [UserController::class, 'UserLogout']);
//Dashboard After Authentication
Route::get('/dashboard', [DashboardController::class, 'DashboardPage'])->middleware([TokenVarificationMiddleware::class]);
Route::get('/userProfile', [UserController::class, 'ProfilePage'])->middleware([TokenVarificationMiddleware::class]);


//Cutomer Api Route

Route::post('create-Customers', [CustomerController::class, 'createCustomer'])->middleware([TokenVarificationMiddleware::class]);
Route::get('customersList', [CustomerController::class, 'customersList'])->middleware([TokenVarificationMiddleware::class]);
Route::post('customerUpdate', [CustomerController::class, 'customerUpdate'])->middleware([TokenVarificationMiddleware::class]);
Route::post('customerDelete', [CustomerController::class, 'customerDelete'])->middleware([TokenVarificationMiddleware::class]);
