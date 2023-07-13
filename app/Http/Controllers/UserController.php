<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function UserLogin()
    {
    }
    public function UserRegistration(Request $request)
    {
        return User::create($request->input());
    }
    public function SendOtpToEmail()
    {

    }
    public function VerifyOtp()
    {

    }
    public function SetPassword()
    {

    }

    //after login

    public function ProfileUpdate(){

    }
}
