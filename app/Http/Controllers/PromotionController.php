<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Mail\PromotionalEmail;
use Illuminate\Support\Facades\Mail;

class PromotionController extends Controller
{
    public function promotionMailPage(){
        return view('pages.dashboard.promotion');
        }

      public function promotionMailSend(Request $request){
        $customers = Customer::where( 'user_id', $request->header( 'id' ) )->select( 'email' )->get();
        try {
            foreach ( $customers as $customer ) {
                Mail::to( $customer->email )->send( new PromotionalEmail( $request->subject, $request->message ) );
            }
            return response()->json( ['status' => 'success', 'message' => 'message send successfully'], 200 );
        } catch ( Exception $e ) {
            return response()->json( ['status' => 'failed', 'message' => 'message send failed'], 400 );
        }
        }
}
