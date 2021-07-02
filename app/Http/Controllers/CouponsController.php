<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Jobs\UpdateCoupon;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    public function store(Request $request)
    {
        $coupon = Coupon::where('code', $request->coupon_code)->first();

        //   echo '<pre>';
        //   print_r($coupon);
        //   echo '<pre>';
        //   exit;

        if (!$coupon) {

            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code. Please try again.',
                'data' => $coupon,
            ], 404);
        }

        dispatch_now(new UpdateCoupon($coupon));

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!!',
            'data' => $coupon,
        ], 200);
    }

    public function destroy()
    {
        session()->forget('coupon');

        return response()->json([
            'success' => true,
            'message' => 'Coupon has been removed.',
        ], 200);
    }
}