<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class WebpageController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('webpage');
    }

    public function store(Request $request) {
        try {
            $product_name = $request['product_name'];
            $quantity_in_stock = $request['quantity_in_stock'];
            $price_per_item = $request['price_per_item'];
            $created_at = $request['created_at'];
            $data = ["product_name" => $product_name,"quantity_in_stock" => $quantity_in_stock,"price_per_item" => $price_per_item,"created_at" => $created_at];
            $additionalArray = array('product_name' => $product_name,'quantity_in_stock' => $quantity_in_stock,'price_per_item' => $price_per_item,'created_at' => $created_at);
            $data_results = file_get_contents(base_path('storage/app/public/data.json'));
            $tempArray = json_decode($data_results);
            $tempArray[] = $additionalArray ;
            $jsonData = json_encode($tempArray);
            $result = [ 'success' => 0];
            $save = Storage::disk('local')->put("public/data.json",$jsonData);
            if ($save) {
                $result = [ 'success' => 1];
            }
            return Response::json($result);
        } catch(Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function api(){
        $jsonString = file_get_contents(base_path('storage/app/public/data.json'));
        $data = json_decode($jsonString, true);
        return $data;
    }

}