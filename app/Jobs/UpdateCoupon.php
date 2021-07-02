<?php

namespace App\Jobs;

use App\Coupon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateCoupon implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $coupon;

    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    public function handle()
    {
        if (Cart::currentInstance() === 'default') {
            session()->put('coupon', [
                'name' => $this->coupon->code,
                'discount' => $this->coupon->discount(Cart::subtotal()),
            ]);
        }
    }
}