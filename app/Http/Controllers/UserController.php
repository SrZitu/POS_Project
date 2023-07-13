<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;

use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function UserLogin(Request $request)
    {
        $result = User::where($request->input())->count();
        if ($result == 1) {
            $token = JWTToken::CreateJWTToken($request->input('email'));
            return response()->json(['data' => $token, 'msg' => 'success']);

        } else {

            return response()->json(['data' => 'unauthorized', 'msg' => 'success']);
        }
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

    public function ProfileUpdate()
    {
    }
}
