<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\JsonResponse;
use App\Imports\PurchaseOrderImport;
use App\Http\Requests\PurchaseOrdersRequest;
use App\Models\OrderBatches;
use App\Models\OrderBatchItem;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use setasign\Fpdi\Fpdi;
use DataTables;
use Log;

class OrdersController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file_name' => 'required|mimes:csv,txt'
        ]);

        $batch_name = $request->input('batch_name');
        $filePath = $request->file('file_name')->getPathname();
        $data = array_map('str_getcsv', file($filePath));
       
       
        
        try {
            $filePath = $request->file('file_name')->getPathname();
            $data = array_map('str_getcsv', file($filePath));
           
                $batch_details[] = [
                    'batch_name' => $batch_name,
                    'supplier_name' => $data[0][2],
                    'order_no' => $data[0][4],
                     ];
            $transformedData = [];
            foreach ($data as $row) {
                if (isset($row[19]) && isset($row[21]) && isset($row[24])) {
                    $transformedData[] = [
                        'product_name' => $row[19],
                        'quantity' => (int) $row[21],
                        'price' => (float) $row[24],
                    ];
                }
            }

            // Store the data in the session
            $request->session()->put(['data' => $transformedData, 'batch_details' => $batch_details]);

            return response()->json(['status' => 'success']);
        } catch (\Exception $ex) {
            Log::error($ex);
            return response()->json(['status' => 'error', 'message' => 'An error occurred']);
        }
    }
    
    public function importAndView(Request $request)
    {   $imported_data =$request->all();
        $batch_details =  $imported_data['batch_details'];
       
        $order_batches = OrderBatches::create([
            'batch_name' => $batch_details['batch_name'],
            'supplier_name' => $batch_details['supplier_name'],
            'order_no' => $batch_details['order_no'],
        ]);
        $data = $imported_data['data'];

        foreach ($data as $row) {
            if ($row['product_name'] && $row['quantity'] && $row['price']) {
                OrderBatchItem::create([
                    'order_batch_id' => $order_batches->id,
                    'product_name' => $row['product_name'],
                    'quantity' => $row['quantity'],
                    'price_quantity' => $row['price']
                ]);
            }
        }

        $encoded_batch_id = base64_encode($order_batches->id);
        return response()->json(['status' => 'success', 'message' => 'Data submitted successfully!', 'batch_id' => $encoded_batch_id]);
    }

    public function saveAndView() {}

    public function saved(Request $request, $encoded_batch_id)
    {
        $batch_id = base64_decode($encoded_batch_id);

$order_batch= OrderBatches::find($batch_id);
        if ($request->ajax()) {
            $order_batch= OrderBatches::find($batch_id);
            $data = OrderBatchItem::where('order_batch_id', $batch_id)->get();
            $subTotalSum = collect($data)->reduce(function ($carry, $item) {
                return $carry + ($item->price_quantity * $item->quantity);
            }, 0);

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('sub_total', function($row) {
                return $row->price_quantity * $row->quantity;
            })
            ->with(['sub_total_sum'=>$subTotalSum, 'order_batch'=>$order_batch])
            ->toJson();
        }

        return view('orders.saved', ['encoded_batch_id' => $encoded_batch_id]);
    }
}

