<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//Product route....................
Route::get('/all-product', 'App\Http\Controllers\ProductController@all_product');
Route::post('/save-product', 'App\Http\Controllers\ProductController@save_product');
Route::put('/update-product/{product_id}', 'App\Http\Controllers\ProductController@update_product');
Route::get('/delete-product/{product_id}', 'App\Http\Controllers\ProductController@delete_product');

//Category Route...........
Route::get('/all-category', 'App\Http\Controllers\CategoryController@all_category');
Route::post('/save-category', 'App\Http\Controllers\CategoryController@save_category');
Route::put('/update-category/{category_id}', 'App\Http\Controllers\CategoryController@update_category');
Route::get('/delete-category/{category_id}', 'App\Http\Controllers\CategoryController@delete_category');

//Manufature or Brands route.......
Route::get('/all-manufacture', 'App\Http\Controllers\ManufactureController@all_manufacture');
Route::post('/save-manufacture', 'App\Http\Controllers\ManufactureController@save_manufacture');
Route::put('/update-manufacture/{manufacture_id}', 'App\Http\Controllers\ManufactureController@update_manufacture');
Route::get('/delete-manufacture/{manufacture_id}', 'App\Http\Controllers\ManufactureController@delete_manufacture');

//Cart Route.........................
Route::post('/add-to-cart', 'App\Http\Controllers\CartController@add_to_cart');
Route::put('/update-cart', 'App\Http\Controllers\CartController@update_to_cart');
Route::get('/delete-to-cart/{rowId}', 'App\Http\Controllers\CartController@delete_to_cart');

//Order Place Route..........................
Route::post('/order-place', 'App\Http\Controllers\CheckoutController@order_place');
 
//Manage Order...............................
Route::get('/manage-order', 'App\Http\Controllers\CheckoutController@manage_order');
Route::get('/order-delete/{order_id}', 'App\Http\Controllers\CheckoutController@order_delete');
Route::get('/order-pending/{order_id}', 'App\Http\Controllers\CheckoutController@order_pending');
Route::get('/order-paid/{order_id}', 'App\Http\Controllers\CheckoutController@order_paid');
Route::get('/order-delivery/{order_id}', 'App\Http\Controllers\CheckoutController@deliveryOrder');

//Stock Manage................................
Route::get('/stock', 'App\Http\Controllers\ProductController@stock_manage');

//Customer Login, Registration Route Here.......
Route::post('/customer_registration', 'App\Http\Controllers\CheckoutController@customer_registration');
Route::post('/customer_login', 'App\Http\Controllers\CheckoutController@customer_login');

//Shipping Information...................
Route::post('/save-shipping-info', 'App\Http\Controllers\CheckoutController@save_shipping_info');

//Invoice System.........................
Route::get('/billReciept','App\Http\Controllers\RecieptController@index');
Route::get('/getPrice/{id}', 'App\Http\Controllers\RecieptController@getPrice');
