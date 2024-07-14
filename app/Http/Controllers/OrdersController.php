<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\JsonResponse;
use App\Imports\PurchaseOrderImport;
use App\Http\Requests\PurchaseOrdersRequest;
use App\Models\OrderBatches;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Log;
use DataTables;

class OrdersController extends Controller
{
    public function import(Request $request)
{ $batch_name= $request->all();

    try {
        $filePath = $request->file('file_name')->getPathname();
        $data = Excel::toCollection(new PurchaseOrderImport, $filePath)->first(); // Assuming single sheet

        // Transform data into array
        $transformedData = $data->map(function ($item) {
            return $item->toArray();
        });

       

        // Store the data in the session
        $request->session()->put(['data'=>$transformedData, 'total_price'=>0, 'batch_name'=>$batch_name['batch_name']]);

        return response()->json(['status' => 'success']);
    } catch (\Exception $ex) {
        Log::error($ex);
        return response()->json(['status' => 'error', 'message' => 'An error occurred']);
    }
}
    
  public function importAndView(Request $request){
    
    $batch_name= session('batch_name');
   $order_batches=OrderBatches::create([
                'batche_name' => $batch_name
                  ]);
    $data = $request->input('data');
    foreach ($data as $row) {
        if($row['product_name']){
        PurchaseOrder::create([
            'order_batch_id' => $order_batches['id'],
            'product_name' => $row['product_name'],
            'quantity' => $row['quantity'],
            'price_quantity' => $row['price'],
            'description' => $row['description']
        ]);}
    }
    $encoded_batch_id= base64_encode($order_batches['id']);
    return response()->json(['status' => 'success', 'message' => 'Data submitted successfully!' , 'batch_id'=>$encoded_batch_id]);
  } 
  
  public function saveAndView(){


  }
  public function saved(Request $request, $encoded_batch_id){
    $batch_id= base64_decode($encoded_batch_id);
    
    if ($request->ajax()) {
        // Fetch purchase orders based on the decoded batch ID
        $data = PurchaseOrder::where('order_batch_id', $batch_id)->get();
       $data= DataTables::of($data)->addIndexColumn()->toJson();
       
        // Return data as JSON using DataTables plugin with index column
        return $data;
    }
    
    // If not AJAX, render the 'orders.saved' view with encoded batch ID
    return view('orders.saved', ['encoded_batch_id' => $encoded_batch_id]);
}

}
