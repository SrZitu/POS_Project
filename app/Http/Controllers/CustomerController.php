<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function customerPage()
    {
        return view('pages.dashboard.customer');
    }

    public function createCustomer(Request $request)
    {
        $user_id = $request->header('id');
        return Customer::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
            'user_id' => $user_id
        ]);
    }

    public function customersList(Request $request)
    {
        $user_id = $request->header('id');
        return Customer::where('user_id', $user_id)->latest()->get();
    }

    public function customerUpdate(Request $request)
    {

        $user_id = $request->header('id');
        $customer_id = $request->input('id');
        return Customer::where('user_id', $user_id)
            ->where('id', $customer_id)
            ->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
            ]);
    }
    public function CustomerId(Request $request)
    {
        $user_id = $request->header('id');
        $customer_id = $request->input('id');
        return Customer::where('user_id', $user_id)
            ->where('id', $customer_id)
            ->first();
    }

    public function customerDelete(Request $request)
    {
        try {
            $user_id = $request->header('id');
            $category_id = $request->input('id');
           return  Customer::where('user_id', $user_id)
                ->where('id', $category_id)
                ->delete();

            return response()->json([
                'status' => 'success!',
                'message' => 'Deleted Successfully!'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Could not Delete Data',
                'status' => 'failed'
            ], 401);
        }
    }
}
