<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function createCustomer(Request $request)
    {
        try {
            $user_id = $request->header('id');
            Customer::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'user_id' => $user_id
            ]);

            return response()->json([
                'status' => 'success!',
                'message' => 'Customer Created Successfully!'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'unauthorized',
                'status' => 'failed'
            ], 401);
        }
    }

    public function customersList(Request $request)
    {

        try {
            $user_id = $request->header('id');

            Customer::where('user_id', $user_id)->get();
            return response()->json([
                'status' => 'success!',
                'message' => 'Your Customer List!'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'unauthorized',
                'status' => 'failed'
            ], 401);
        }
    }

    public function customerUpdate(Request $request)
    {

        try {
            $user_id = $request->header('id');
            $category_id = $request->input('id');
            Customer::where('user_id', $user_id)
                ->where('id', $category_id)
                ->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'mobile' => $request->input('mobile'),
                ]);

            return response()->json([
                'status' => 'success!',
                'message' => 'Customer Updated Successfully!'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Could not Update Data',
                'status' => 'failed'
            ], 401);
        }
    }

    public function customerDelete(Request $request)
    {
        try {
            $user_id = $request->header('id');
            $category_id = $request->input('id');
            Customer::where('user_id', $user_id)
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
