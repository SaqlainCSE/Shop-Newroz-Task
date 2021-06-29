<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{

    public function customer_login(Request $request)
    {
        $customer_email = $request->customer_email;
        $password = md5($request->password);

        $result = DB::table('customers')
                    ->where('customer_email', $customer_email)
                    ->where('password', $password)
                    ->first();
        //echo $result;
                    return response()->json([
                        'success' => true,
                        'message' => 'Login Successfully!!!',
                        'data' => $result,
                    ], 200);
    }

    public function customer_registration(Request $request)
    {
        $data=array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] = $request->customer_email;
        $data['mobile_number'] = $request->mobile_number;
        $data['password'] = md5($request->password);

        $result = DB::table('customers')->insertGetId($data);

        //echo $result;
        return response()->json([
            'success' => true,
            'message' => 'Customer Registration Successfully!',
            'data' => $result,
        ], 200);
    }

    public function save_shipping_info(Request $request)
    {
        $data=array();
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_first_name'] = $request->shipping_first_name;
        $data['shipping_last_name'] = $request->shipping_last_name;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_mobile_number'] = $request->shipping_mobile_number;
        $data['shipping_city'] = $request->shipping_city;

        $result = DB::table('Shippings')->insertGetId($data);

        //echo $result;
        return response()->json([
            'success' => true,
            'message' => 'Shipping Info Saved',
            'data' => $result,
        ], 200);
    
    }

    public function order_place(Request $request)
    {
        $payment_gateway = $request->payment_method;
        
        $payment_data = array();
        $payment_data['payment_method'] = $payment_gateway;
        $payment_data['payment_status'] = 'pending';

        $payment_id = DB::table('payments')->insertGetId($payment_data);

        $order_data = array();
        $order_data['payment_id'] = $payment_id;
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['order_total'] = Cart::total();
        $order_data['order_status'] = 'pending';

        $order_id = DB::table('orders')->insertGetId($order_data);

        $order_details_data = array();
        $contents = Cart::content();

        foreach($contents as $data)
        {
            $order_details_data['order_id'] = $order_id;
            $order_details_data['product_id'] = $data->id;
            $order_details_data['product_name'] = $data->name;
            $order_details_data['product_price'] = $data->price;
            $order_details_data['shipping_charge'] = $data->charge;
            $order_details_data['product_sales_quantity'] = $data->qty;

            DB::table('order_details')->insert($order_details_data);
        }

        if($payment_gateway == 'handcash')
        {
            Cart::destroy();
            return response()->json([
                'success' => true,
                'message' => 'Handcash Payment',
            ], 200);
        }
        elseif($payment_gateway == 'cart')
        {
            return response()->json([
                'success' => true,
                'message' => 'Cart Payment',
            ], 200);
        }
        elseif($payment_gateway == 'bkash')
        {
            return response()->json([
                'success' => true,
                'message' => 'Bkash Payment',
            ], 200);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Not Selected Payment Method',
            ], 404);
        }

    }

    public function manage_order()
    {
        $all_order_info=DB::table('orders')
                            ->join('customers','orders.customer_id','customers.customer_id')
                            ->select('orders.*','customers.customer_name')
                            ->get();
        
        //echo $result;
        return response()->json([
            'success' => true,
            'message' => 'All order Info',
            'data' => $all_order_info,
        ], 200);
    }

    public function order_pending($order_id)
    {  
        $data = DB::table('orders')->where('order_id',$order_id)->update(['order_status' => 'pending']);

        //echo $result;
        return response()->json([
            'success' => true,
            'message' => 'Order Pending!!',
            'data' => $data,
        ], 200);
    }

    public function order_paid($order_id)
    {
        $data = DB::table('orders')->where('order_id',$order_id)->update(['order_status' => 'paid']);

        //echo $result;
        return response()->json([
            'success' => true,
            'message' => 'Order Paid Successfully!!',
            'data' => $data,
        ], 200);
    }

    public function order_delete($order_id)
    {
        $data = DB::table('orders')->where('order_id', $order_id)->delete();

        //echo $result;
        return response()->json([
            'success' => true,
            'message' => 'Order Deleted Successfully!!',
            'data' => $data,
        ], 200);
    }
}
