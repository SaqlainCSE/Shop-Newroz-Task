<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManufactureController extends Controller
{

    public function all_manufacture()
    {

        $all_category_info=DB::table('manufactures')->get();
        //echo $all_product_info;

        return response()->json([
            'success' => true,
            'message' => 'all category fetched',
            'data' => $all_category_info,
        ], 200);
    }

    public function save_manufacture(Request $request)
    {
        $data=array();
        $data['manufacture_id']=$request->manufacture_id;
        $data['manufacture_name']=$request->manufacture_name;
        $data['manufacture_description']=$request->manufacture_description;
        $data['publication_status']=$request->publication_status;
        //echo $data;

        DB::table('manufactures')->insert($data);

        return response()->json([
            'success' => true,
            'message' => 'Manufacture Added Successfully!!',
            'data' => $data,
        ], 200);

    }

    public function update_manufacture(Request $request, $manufacture_id)
    {
        $data = DB::table('manufactures')->find($manufacture_id);
        //echo $data;

        if (is_null($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Manufacture not found',
            ], 404);
        }

        $data=array();
        $data['manufacture_name']=$request->manufacture_name;
        $data['manufacture_description']=$request->manufacture_description;

        DB::table('manufactures')->where('manufacture_id', $manufacture_id)->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Manufacture Updated Successfully!!',
                'data' => $data,
            ], 200);
    }

    public function delete_manufacture($manufacture_id)
    {
        $data = DB::table('manufactures')->find($manufacture_id);

        if (is_null($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Manufacture not found',
            ], 404);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Manufacture Deleted Successfully!!',
            'data' => $data,
        ], 200);
    }
    
}
