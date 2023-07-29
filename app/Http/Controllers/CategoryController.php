<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function categoryPage()
    {
        return view('pages.dashboard.category');
    }
    public function createCategory(Request $request)
    {

        $user_id = $request->header('id');
        return Category::create([
            'name' => $request->input('name'),
            'user_id' => $user_id
        ]);
    }

    public function CategoryList(Request $request)
    {
        $user_id = $request->header('id');
        return Category::where('user_id', $user_id)->latest()->get();
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

        $user_id = $request->header('id');
        $category_id = $request->input('id');
        return Category::where('user_id', $user_id)
            ->where('id', $category_id)
            ->delete();
    }
}
