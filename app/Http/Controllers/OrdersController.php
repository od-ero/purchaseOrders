<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\supplier;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\JsonResponse;
use App\Imports\PurchaseOrderImport;
use App\Http\Requests\PurchaseOrdersRequest;
use App\Mail\MakeOrdersMail;
use App\Models\CcSendBatch;
use App\Models\OrderBatches;
use App\Models\OrderBatchItem;
use App\OrderPDF;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use setasign\Fpdi\Fpdi;
use DataTables;
use Log;
use Mail;
use DB;
use App\Models\EmailBody;
use App\Models\SendBatch;

use function PHPUnit\Framework\isEmpty;

class OrdersController extends Controller
{   public function importView(){
    $suppliers = Supplier::all();
    return view('orders.import_and_view', ['suppliers' => $suppliers]);
}


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
            $supplier_name=$data[0][2];
            $supplier= supplier::where('supplier_name',$supplier_name)
                                    ->first();
             $order_no_present =  OrderBatches::where('order_no',$data[0][4]) 
                                                ->first();  

            if ($supplier== null){
                return response()->json(['status' => 'error', 'message' => 'Upload file with an active supplier']);
            }
            // else if($order_no_present==null) {
            //     return response()->json(['status' => 'error', 'message' => 'The order number already exists']);
            // }
           else { 
                $batch_details[] = [
                    'batch_name' => $batch_name,
                    'supplier_id' =>  $supplier['id'],
                    'supplier_name' => $supplier['supplier_name'],
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

            
            $request->session()->put(['data' => $transformedData, 'batch_details' => $batch_details]);

            return response()->json(['status' => 'success']);
        }
           
        } catch (\Exception $ex) {
            Log::error($ex);
            return response()->json(['status' => 'error', 'message' => 'An error occurred']);
        }
    }
    
    public function importAndView(Request $request): JsonResponse
    {  
         $imported_data =$request->all();
        $batch_details =  $imported_data['batch_details'];
       $supplier_id = base64_decode($batch_details['supplier_id']);
       
        $order_batches = OrderBatches::create([
            'batch_name' => $batch_details['batch_name'],
            'supplier_id' => $supplier_id,
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

    public function viewBatch(Request $request, $encoded_batch_id)
    {
        $batch_id = base64_decode($encoded_batch_id);
        $batch_details= OrderBatches::leftJoin('suppliers','suppliers.id','=','order_batches.supplier_id')
                                    ->select('order_batches.*', 'suppliers.supplier_name')
                                    ->where('order_batches.id', $batch_id)
                                    ->first();
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

        return view('orders.view_batch', ['encoded_batch_id' => $encoded_batch_id, 'batch_details'=> $batch_details]);
    }

    Public function previewOrderasPdf(Request $request, $encoded_batch_id){
        $batch_id = base64_decode($encoded_batch_id);
       
        $batch_items = OrderBatchItem::where('order_batch_id', $batch_id)->get();
        $batch_details= OrderBatches::leftJoin('suppliers','suppliers.id','=','order_batches.supplier_id')
                                    ->select('order_batches.order_no','suppliers.supplier_name')
                                    ->where('order_batches.id',$batch_id)
                                    ->first();
        $pdfContent = OrderPDF::createPDF($batch_items, $batch_details);
        $pdfContent = base64_encode($pdfContent);
        return view('orders.view_pdf',['pdfContent'=> $pdfContent,
        'encoded_product_batch_id'=>$batch_id]);

    }

    Public function noCostPdf(Request $request, $encoded_batch_id){
        $batch_id = base64_decode($encoded_batch_id);
       
        $batch_items = OrderBatchItem::where('order_batch_id', $batch_id)->get();
        $batch_details= OrderBatches::leftJoin('suppliers','suppliers.id','=','order_batches.supplier_id')
                                    ->select('order_batches.order_no','suppliers.supplier_name')
                                    ->where('order_batches.id',$batch_id)
                                    ->first();
        $pdfContent = OrderPDF::noCostPDF($batch_items, $batch_details);
        $pdfContent = base64_encode($pdfContent);
        return view('orders.view_pdf',['pdfContent'=> $pdfContent,
        'encoded_product_batch_id'=>$batch_id]);

    }

    public function makeOrder($encoded_batch_id){
        $batch_id = base64_decode($encoded_batch_id);
        $batch_details= OrderBatches::leftJoin('suppliers','suppliers.id','=','order_batches.supplier_id')
                                    ->select('order_batches.id as order_id','order_batches.order_no','suppliers.supplier_name')
                                    ->where('order_batches.id',$batch_id)
                                    ->first();
        $mail= EmailBody::find(1);
        return view('orders.make_order',['mail'=>$mail, 'batch_details'=>$batch_details]);
    }

    public function sendOrder(Request $request){
        $mail_content = $request->all();
        $batch_id = $mail_content['batch_id'];
        DB::beginTransaction();
        try{
           
        $batch_items = OrderBatchItem::where('order_batch_id', $batch_id)->get();
        $batch_details= OrderBatches::leftJoin('suppliers','suppliers.id','=','order_batches.supplier_id')
                                    ->select('order_batches.order_no','suppliers.supplier_name','suppliers.supplier_email')
                                    ->where('order_batches.id',$batch_id)
                                    ->first();
        if($mail_content['with_prices']=="Yes") {                           
        $pdfContent = OrderPDF::createPDF($batch_items, $batch_details);
            }
            else{
                $pdfContent = OrderPDF::noCostPDF($batch_items, $batch_details);     
            }
        $mailData = [
            'title' => $mail_content['email_subject'],
            'body' => $mail_content['email_body'],
             'files' => [
            //     public_path('images/stamp.png'),
            //     public_path('images/signature.png'),
                [
                    'content' => $pdfContent,
                    'name' =>  $batch_details['order_no'] . '_order.pdf'
                ]
            ]
        ];
        
            OrderBatches::where('id', $batch_id)->update(['ordered' => 1]);   
        
            // Create the send batch entry
           $send_batch= SendBatch::create([
                'batch_id' => $batch_id,
                'email_subject' => $mail_content['email_subject'],
                'email_body' => $mail_content['email_body'], 
            ]);
        
            // Initialize an array to hold CC email addresses
            $cc_emails = [];
        
            // Check if there are CC email addresses
            if ($mail_content['people_cc'] > 0) {
                // Collect all CC email addresses
                for ($i = 1; $i <= $mail_content['people_cc']; $i++) {
                    $user_email_key = "cc_email_" . $i;
                    if (isset($mail_content[$user_email_key])) {
                        $cc_emails[] = $mail_content[$user_email_key];
                        CcSendBatch::create([
                            'send_batch_id'=>$send_batch['id'],
                            'cc_email' => $mail_content[$user_email_key],
                        ]);
                    }
                }
            }
        
            // Send the email with optional CC addresses
            Mail::to($batch_details['supplier_email'])
                ->cc($cc_emails)
                ->send(new MakeOrdersMail($mailData));
        
            DB::commit();
             
 return response()->json(['status' => 'success', 'message' => 'Order send']);

    } catch (\Exception $ex) {
        DB::rollBack();
        Log::error($ex);
        return response()->json(['status' => 'error', 'message' => 'An error occurred']);
    }
        
    }

    public function listImportedOrders(Request $request)
    {
        if ($request->ajax()) {
    
            $data = OrderBatches::leftJoin('suppliers', 'suppliers.id', '=', 'order_batches.supplier_id')
                                    ->select('order_batches.*', 'suppliers.supplier_name')
                                    ->whereNot('ordered',1)
                                    ->orderBy('order_batches.id', 'desc')
                                    ->get();
            return DataTables::of($data)
                ->addColumn('created_date', function($row) {
                    return Carbon::parse($row->created_at)->toDateTimeString();
                })
                ->addColumn('order_count', function($row) {
                    return OrderBatchItem::where('order_batch_id', $row->id)->count();
                })
                ->addColumn('action', function($row) {
                    $encodedId = base64_encode($row->id);
                    return '
    <div class="btn-group">
        <a type="button" href="/view/batch/' . $encodedId . '" class="btn btn-success">View</a>
        <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu">
             <li><a class="dropdown-item" data-id="' . $encodedId . '" id="update_batch_button" href="/make-orders/'. $encodedId . '">Make Order</a></li>
            <li><a class="dropdown-item" data-id="' . $encodedId . '" id="order_price" href="/orders/pdf/'. $encodedId . '">PDF with Prices</a></li>
            <li><a class="dropdown-item" data-id="' . $encodedId . '" id="order_no_preice" href="/orders/no-cost-pdf/'. $encodedId . '">PDF No Prices</a></li>
            <li><a class="dropdown-item" data-id="' . $encodedId . '" id="update_batch_button" href="/update/batch/'. $encodedId . '">Edit</a></li>
            <li><a class="dropdown-item" data-id="' . $encodedId . '" id="delete_batch_order_button" href="#">Delete</a></li>
        </ul>
    </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    
        return view('orders.list_imported_batches');
    }

    public function listOrderedOrders(Request $request)
    {
        if ($request->ajax()) {
    
            $data = OrderBatches::leftJoin('suppliers', 'suppliers.id', '=', 'order_batches.supplier_id')
                                ->where('ordered',1)
                                ->select('order_batches.*', 'suppliers.supplier_name')
                                ->orderBy('order_batches.id', 'desc')
                                ->get();
    
            return DataTables::of($data)
                ->addColumn('created_date', function($row) {
                    return Carbon::parse($row->createds_at)->toDateTimeString();
                })
                ->addColumn('order_count', function($row) {
                    return OrderBatchItem::where('order_batch_id', $row->id)->count();
                })
                ->addColumn('action', function($row) {
                    $encodedId = base64_encode($row->id);
                    return '
    <div class="btn-group">
        <a type="button" href="/view/batch/' . $encodedId . '" class="btn btn-success">View</a>
        <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu">
             <li><a class="dropdown-item" data-id="' . $encodedId . '" id="update_batch_button" href="/make-orders/'. $encodedId . '">Make Order</a></li>
            <li><a class="dropdown-item" data-id="' . $encodedId . '" id="order_price" href="/orders/pdf/'. $encodedId . '">PDF with Prices</a></li>
            <li><a class="dropdown-item" data-id="' . $encodedId . '" id="order_no_preice" href="/orders/no-cost-pdf/'. $encodedId . '">PDF No Prices</a></li>
            <li><a class="dropdown-item" data-id="' . $encodedId . '" id="update_batch_button" href="/update/batch/'. $encodedId . '">Edit</a></li>
            <li><a class="dropdown-item" data-id="' . $encodedId . '" id="delete_batch_order_button" href="#">Delete</a></li>
        </ul>
    </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    
        return view('orders.list_ordered_orders');
    }

    public function editBatch($encoded_batch_id){
        
        $suppliers = Supplier::all();
        $batch_id= base64_decode($encoded_batch_id);
        $batch_details= OrderBatches::withTrashed()
                                     ->find($batch_id);
        $batch_items = OrderBatchItem::withTrashed()
                                     ->where('order_batch_id',$batch_id)
                                    ->get();
                                    
    return view('orders.update_orders', ['suppliers' => $suppliers, 'batch_details'=>$batch_details, 'batch_items'=>$batch_items]);
    }
    public function updateBatch(Request $request){
       $data = $request->all();
        $batch_id = $data['batch_details']['batch_id'];
       $supplier_id=base64_decode($data['batch_details']['supplier_id']);
       $order_no = $data['batch_details']['order_no'];
       $batch_name=$data['batch_details']['batch_name'];
       
        try{
        //     $validated = Validator::make($request->all(), [
        //         $batch_name => ['nullable', 'string', 'max:255'],
        //         $supplier_id => ['required', 'string', 'max:255'],
        //         $order_n0 => ['required', 'string', 'max:255'],
                
        //     ]);
        //    // 'email' => ['nullable', 'email', 'unique:users,email,' . $validated_details['user_id']],
        
        //     if ($validated->fails()) {
                
        //         return response()->json(['status' =>'error', 'message' => $validated->errors()->all()]);
        //     }
        DB::beginTransaction();
        $order_batches = OrderBatches::withTrashed()
                                    ->where('id', $batch_id)
                                      ->update([
                                            'batch_name' => $batch_name,
                                            'supplier_id' => $supplier_id,
                                            'order_no' => $order_no,
                                        ]);
        $batch_items = $data['data'];

        foreach ($batch_items as $row) {
            if ($row['product_name'] && $row['quantity'] && $row['price']) {
                OrderBatchItem::where('order_batch_id', $batch_id)
                              ->update([
                                    'product_name' => $row['product_name'],
                                    'quantity' => $row['quantity'],
                                    'price_quantity' => $row['price']
                                ]);
            }
        }
        DB::commit();
        return response()->json(['status' => 'success', 'batch_id' => base64_encode($batch_id),'message' => 'Batch Updated']);
    }
    catch (\Exception $ex) {
        Log::error($ex);
        DB::rollBack();
        return response()->json(['status' => 'error', 'message' => 'An error occurred']);
    }
       
    
    }

    public function deleteOrderBatch($encoded_batch_id){
      $batch_id=  base64_decode($encoded_batch_id);
      try{
        DB::beginTransaction();
        OrderBatchItem::where('order_batch_id',$batch_id)
                        ->delete();
        OrderBatches::where('id',$batch_id)
                    ->delete(); 
        DB::commit();            
        return response()->json(['status' => 'success', 'message' => 'Order deleted succesfully']);

    } catch (\Exception $ex) {
        Log::error($ex);
        DB::rollBack();
        return response()->json(['status' => 'error', 'message' => 'An error occurred']);
    }                          
    }
    
}
