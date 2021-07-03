<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function all_product()
    {
        $all_product_info = DB::table('products')
            ->join('categorys', 'products.category_id', 'categorys.category_id')
            ->join('manufactures', 'products.manufacture_id', 'manufactures.manufacture_id')
            ->join('similar_products', 'products.similar_products_id', 'similar_products.similar_products_id')
            ->select('products.*', 'categorys.category_name', 'manufactures.manufacture_name')
            ->get();

        //echo $all_product_info;
        return response()->json([
            'success' => true,
            'message' => 'all products fetched',
            'data' => $all_product_info,
        ], 200);
    }

    public function save_product(Request $request)
    {
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['category_id'] = $request->category_id;
        $data['manufacture_id'] = $request->manufacture_id;
        $data['product_description'] = $request->product_description;
        $data['product_price'] = $request->product_price;
        $data['product_weight'] = $request->product_weight;

        $image = $request->file('product_image');
        if ($image) {
            $image_name = time();
            $ext = strtolower($image->getClientOriginalExtension());
            $image_full_name = $image_name . '.' . $ext;
            $upload_path = 'image/';
            $image_url = $upload_path . $image_full_name;
            $success = $image->move($upload_path, $image_full_name);

            if ($success) {
                $data['product_image'] = $image_url;
                //echo $data;

                DB::table('products')->insert($data);

                return response()->json([
                    'success' => true,
                    'message' => 'Added Successfully!!',
                    'data' => $data,
                ], 200);
            }
        }
    }

    // public function edit_product($product_id)
    // {
    //     $edit_product_info=DB::table('products')
    //                             ->where('product_id',$product_id)
    //                             ->first();
    //     //echo $edit_product_info;
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Edited Successfully!!',
    //         'data' => $edit_product_info,
    //     ], 200);
    // }

    public function update_product(Request $request, $product_id)
    {
        $data = DB::table('products')->find($product_id);
        //echo $data;

        if (is_null($data)) {
            return response()->json([
                'success' => false,
                'message' => 'product not found',
            ], 404);
        }

        $data = array();
        $data['product_name'] = $request->product_name;
        $data['category_id'] = $request->category_id;
        $data['manufacture_id'] = $request->manufacture_id;
        $data['product_short_description'] = $request->product_short_description;
        $data['product_weight'] = $request->product_weight;
        $data['product_size'] = $request->product_size;
        //echo $data;

        DB::table('products')->where('product_id', $product_id)->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Updated Successfully!!',
            'data' => $data,
        ], 200);
    }

    public function delete_product($product_id)
    {
        $data = DB::table('products')->find($product_id);

        if (is_null($data)) {
            return response()->json([
                'success' => false,
                'message' => 'product not found',
            ], 404);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted Successfully!!',
            'data' => $data,
        ], 200);
    }

    public function stock_manage()
    {
        $product_stock = DB::table('products')
            ->join('categorys', 'products.category_id', 'categorys.category_id')
            ->join('manufactures', 'products.manufacture_id', 'manufactures.manufacture_id')
            ->join('similar_products', 'products.similar_products_id', 'similar_products.similar_products_id')
            ->select('products.*', 'categorys.category_name', 'manufactures.manufacture_name')
            ->where('product_quantity', 0)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Products stock fetched',
            'data' => $product_stock,
        ], 200);
    }
}