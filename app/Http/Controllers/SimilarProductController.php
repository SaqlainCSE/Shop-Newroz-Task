<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SimilarProductController extends Controller
{
    public function all_similar_product()
    {
        $all_product_info = DB::table('similar_products')
            ->join('categorys', 'products.category_id', 'categorys.category_id')
            ->join('manufactures', 'products.manufacture_id', 'manufactures.manufacture_id')
            ->join('products', 'similar_products.product_id', 'products.product_id')
            ->select('similar_products.*', 'categorys.category_name', 'manufactures.manufacture_name')
            ->get();

        //echo $all_product_info;
        return response()->json([
            'success' => true,
            'message' => 'all similar products fetched',
            'data' => $all_product_info,
        ], 200);
    }

    public function save_similar_product(Request $request)
    {
        $data = array();
        $data['similar_product_name'] = $request->similar_product_name;
        $data['category_id'] = $request->category_id;
        $data['manufacture_id'] = $request->manufacture_id;
        $data['similar_product_description'] = $request->similar_product_description;
        $data['similar_product_price'] = $request->similar_product_price;
        $data['similar_product_weight'] = $request->similar_product_weight;

        $image = $request->file('similar_product_image');
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

                DB::table('similar_products')->insert($data);

                return response()->json([
                    'success' => true,
                    'message' => 'Added Successfully!!',
                    'data' => $data,
                ], 200);
            }
        }
    }

    public function update_similar_product(Request $request, $similar_product_id)
    {
        $data = DB::table('similar_products')->find($similar_product_id);
        //echo $data;

        if (is_null($data)) {
            return response()->json([
                'success' => false,
                'message' => 'similar product not found',
            ], 404);
        }

        $data = array();
        $data['similar_product_name'] = $request->similar_product_name;
        $data['category_id'] = $request->category_id;
        $data['manufacture_id'] = $request->manufacture_id;
        $data['similar_product_short_description'] = $request->similar_product_short_description;
        $data['similar_product_weight'] = $request->similar_product_weight;
        $data['similar_product_size'] = $request->similar_product_size;
        //echo $data;

        DB::table('similar_products')->where('similar_product_id', $similar_product_id)->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Updated Successfully!!',
            'data' => $data,
        ], 200);
    }

    public function delete_similar_product($similar_product_id)
    {
        $data = DB::table('similar_products')->find($similar_product_id);

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
}