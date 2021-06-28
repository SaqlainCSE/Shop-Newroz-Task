<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    public function add_to_cart(Request $request)
    {
        $qty = $request->qty;
        $weight = $request->weight;
        $product_id = $request->product_id;
        $product_info = DB::table('products')
                        ->where('product_id', $product_id)
                        ->first();

        $data['qty'] = $qty;
        $data['weight'] = $weight;
        $data['id'] = $product_info->product_id;
        $data['name'] = $product_info->product_name;
        $data['price'] = $product_info->product_price;
        $data['options']['image'] = $product_info->product_image;
        //echo $data;

        Cart::add($data);

        return response()->json([
            'success' => true,
            'message' => 'Cart Added',
            'data' => $data,
        ], 200);
    }

    public function update_to_cart(Request $request)
    {
        $qty = $request->qty;
        $rowId = $request->rowId;

        $data = Cart::find($rowId);
        //echo $data;

        if (is_null($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Cart not found',
            ], 404);
        }

        $data = Cart::update($rowId,$qty);
        
        return response()->json([
            'success' => true,
            'message' => 'Cart Updated Successfully!!',
            'data' => $data,
        ], 200);
    }

    public function delete_to_cart($rowId)
    {
        $data = Cart::find($rowId);
        //echo $data;

        if (is_null($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Cart not found',
            ], 404);
        }

        $data = Cart::update($rowId,0);

        return response()->json([
            'success' => true,
            'message' => 'Cart Show',
            'data' => $data,
        ], 200);
    }

}
