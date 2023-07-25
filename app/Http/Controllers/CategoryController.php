<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function createCategory(Request $request)
    {
        try {
            $user_id = $request->header('id');
            Category::create([
                'name' => $request->input('name'),
                'user_id' => $user_id
            ]);

            return response()->json([
                'status' => 'success!',
                'message' => 'Category Created Successfully!'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'unauthorized',
                'status' => 'failed'
            ], 401);
        }
    }

    public function CategoryList(Request $request)
    {

        try {
            $user_id = $request->header('id');

            Category::where('user_id', $user_id)->get();
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

    public function CategoryUpdate(Request $request)
    {

        try {
            $user_id = $request->header('id');
            $category_id = $request->input('id');
            Category::where('user_id', $user_id)
                ->where('id', $category_id)
                ->update([
                    'name' => $request->input('name'),
                ]);

            return response()->json([
                'status' => 'success!',
                'message' => 'Category Updated Successfully!'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Could not Update Data',
                'status' => 'failed'
            ], 401);
        }
    }

    public function CategoryDelete(Request $request)
    {
        try {
            $user_id = $request->header('id');
            $category_id = $request->input('id');
            Category::where('user_id', $user_id)
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
