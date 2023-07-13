<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Mail\OTPEmail;

use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    public function SendOtpToEmail(Request $request)
    {
        $userMail = $request->input('email');
        $otp = rand(1000, 9999);
        $result = User::where($request->input())->count();

        if ($result == 1) {
            //sending mail
            Mail::to($userMail)->send(new OTPEmail($otp));
            //
            User::where($request->input())->update(['otp' => $otp]);
            return response()->json(['data' => 'Otp Has Sent To Your Email', 'msg' => 'success']);
        } else {
            return response()->json(['data' => 'Otp Failed To Send', 'msg' => 'Failed']);
        }
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
