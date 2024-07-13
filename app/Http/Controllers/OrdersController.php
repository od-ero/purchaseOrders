<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\JsonResponse;
use App\Imports\PurchaseOrderImport;
use App\Http\Requests\PurchaseOrdersRequest;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Log;

class OrdersController extends Controller
{
    public function import(PurchaseOrdersRequest $request) 
    { 
        Excel::import(new PurchaseOrderImport, $request->file('file_name'));
        // try{

        //   //  Excel::import(new PurchaseOrderImport, $request->file('file'));
        //     return response()->json(['status' => 'success', 'message' => ['Order updated successfully']]);
        // }catch(\Exception $ex){
        //     Log::info($ex);
        //     return response()->json(['status' => 'error', 'message' => ['An error occured']]);
           

        // }
        return response()->json(['status' => 'error', 'message' => ['An error occured']]);
           
        
    }
  public function importAndView(){
    dd('yes');
  }  
}
