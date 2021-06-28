<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{

    public function all_category()
    {
        $all_category_info=DB::table('categorys')->get();
        //echo $all_product_info;

        return response()->json([
            'success' => true,
            'message' => 'all category fetched',
            'data' => $all_category_info,
        ], 200);
    }

    public function save_category(Request $request)
    {
        $data=array();
        $data['category_id']=$request->category_id;
        $data['category_name']=$request->category_name;
        $data['category_description']=$request->category_description;
        //echo $data;

        DB::table('categorys')->insert($data);

        return response()->json([
            'success' => true,
            'message' => 'Category Added Successfully!!',
            'data' => $data,
        ], 200);
    }

    public function update_category(Request $request, $category_id)
    {
        $data = DB::table('categorys')->find($category_id);
        //echo $data;

        if (is_null($data)) {
            return response()->json([
                'success' => false,
                'message' => 'category not found',
            ], 404);
        }

        $data=array();
        $data['category_name']=$request->category_name;
        $data['category_description']=$request->category_description;

        DB::table('categorys')->where('category_id', $category_id)->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Category Updated Successfully!!',
                'data' => $data,
            ], 200);
        
    }

    public function delete_category($category_id)
    {
        $data = DB::table('categorys')->find($category_id);

        if (is_null($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
            ], 404);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category Deleted Successfully!!',
            'data' => $data,
        ], 200);
    }
}
