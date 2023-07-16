<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Mail\OTPEmail;

use App\Helper\JWTToken;
use Exception;
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

    public function VerifyOtp(Request $request)
    {
        // $result = User::where($request->input())->count();
        $email = $request->input('email');
        $otp = $request->input('otp');
        $count = User::where('email', $email)
            ->where('otp', $otp)
            ->count();

        if ($count == 1) {
            //Database OTP Update
            User::where('email', $email)->update(['otp' => 0]);

            //Password Reset Token Issue
            $token = JWTToken::CreateJWTForResetPassword($request->input('email'));

            return response()->json(
                [
                    'data' => 'Verified',
                    'msg' => 'success',
                    'token' => $token
                ],
                200
            );
        } else {
            return response()->json([
                'data' => 'Could not Verify',
                'msg' => 'Failed'
            ], 401);
        }
    }
    
    public function ResetPassword(Request $request)
    {
        try {

            $email = $request->header('email');
            $password = $request->input('password');

            User::where('email', $email)->update(['password' => $password]);
            return response()->json(
                [
                    'data' => 'Verified',
                    'msg' => 'Request Successful',
                ],
                200
            );
        } catch (Exception $e) {
            return response()->json([
                'data' => 'Could not Verify',
                'msg' => 'Something Went Wrong!'
            ], 401);
        }
    }

    //after login

    public function ProfileUpdate()
    {
    }
}
