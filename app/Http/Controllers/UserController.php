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

    function LoginPage()
    {
        return view('pages.auth.login-page');
    }
    function RegistrationPage()
    {
        return view('pages.auth.registration-page');
    }
    function SendOtpPage()
    {
        return view('pages.auth.send-otp-page');
    }
    function VerifyOTPPage()
    {
        return view('pages.auth.verify-otp-page');
    }
    function ResetPasswordPage()
    {
        return view('pages.auth.reset-pass-page');
    }

    function ProfilePage()
    {
        return view('pages.dashboard.profile-page');
    }


    public function UserLogin(Request $request)
    {
        $count = User::where('email', '=', $request->input('email'))
            ->where('password', '=', $request->input('password'))
            ->select('id')->first();

        if ($count !== null) {
            // User Login-> JWT Token Issue
            //as count is an object so extracting id from the count object and passing it as 2nd parameter
            $token = JWTToken::CreateJWTToken($request->input('email'), $count->id);

            return response()->json([
                'status' => 'success!',
                'message' => 'User Login Successfully!'
            ], 200)
                ->cookie('token', $token, 60 * 60 * 24);
        } else {
            return response()->json([
                'message' => 'unauthorized',
                'status' => 'failed'
            ], 401);
        }
    }

    public function UserRegistration(Request $request)
    {
        // return User::create($request->input());
        try {
            User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' => $request->input('password'),
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'User Registration Successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User Registration Failed ! From Back-End'
            ], 400);
        }
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
            return response()->json([
                'status' => 'Otp Has Sent To Your Email',
                'message' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'Otp Failed To Send',
                'message' => 'Failed'
            ]);
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
                    'status' => 'Verified',
                    'message' => 'success',
                    'token' => $token
                ],
                200
            )->cookie('token', $token, 60 * 60 * 24);;
        } else {
            return response()->json([
                'status' => 'Could not Verify',
                'message' => 'Failed'
            ], 401);
        }
    }

    public function ResetPassword(Request $request)
    {
        try {

            $email = $request->header('email');
            $password = $request->input('password');

            User::where('email', $email)->update(['password' => $password]);
            // Remove Cookie...
            return response()->json(
                [
                    'status' => 'Verified',
                    'message' => 'Request Successful',
                ],
                200
            );
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Could not Verify',
                'message' => 'Something Went Wrong!'
            ], 401);
        }
    }


    //after login
    function UserLogout()
    {
        //cookie parameters and their discription below
        //cookie name,cookie value('' means its assigning null value), cookie time(here -1 means cookie will have no time)
        return redirect('/userLogin')->cookie('token', '', -1);
    }

    public function userProfile(Request $request)
    {
        try {
            $email = $request->header('email');
            $user = User::where('email', $email)->first();
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Request Successful',
                    'data' => $user
                ],
                200
            );
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Something Went Wrong!'
            ], 401);
        }
    }
    public function updateProfile(Request $request)
    {
        try {
            $email = $request->header('email');
            $firstName = $request->input('firstName');
            $lastName = $request->input('lastName');
            $mobile = $request->input('mobile');
            $password = $request->input('password');

            User::where('email', $email)->update([
                'firstName' => $firstName,
                'lastName' => $lastName,
                'mobile' => $mobile,
                'password' => $password,

            ]);
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Request Successful',

                ],
                200
            );
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Something Went Wrong!'
            ], 401);
        }
    }
}
