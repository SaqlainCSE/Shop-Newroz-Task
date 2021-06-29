<?php
 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
 
class RecieptController extends Controller
{
   public function index()
   {
      $data['orders'] = DB::table('order_details')->get();
    //   echo '<pre>';
    //   print_r($data);
    //   echo '<pre>';
    //   exit;
    return response()->json([
        'success' => true,
        'message' => 'Bill',
        'data' => $data,
    ], 200);
   }
 
   public function getPrice($id)
   {
      $price  = DB::table('order_details')->where('id', $id)->get();

     return response()->json([
        'success' => true,
        'message' => 'Get Price',
        'data' => $price,
    ], 200);
   }   
  
}