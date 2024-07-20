<?php

namespace App\Http\Controllers;
use App\Models\BusinessDetail;
use Illuminate\Http\Request;

class BusinessDetailsController extends Controller
{
    public function editBusinessDetails(){
        $business_details = BusinessDetail::find(1);
        return view('business_details.update_business_details', ['business_details' => $business_details]);
    }
    public function updateBusinessDetails(Request $request){
        $business_details = $request->all();
        try{
            BusinessDetail::where('id',1)
                        ->update([       
                            'company_name'=>$business_details['company_name'],
                            'head_1'=>$business_details['head_1'],
                            'head_2'=>$business_details['head_2'],
                            'head_3'=>$business_details['head_3'],
                            'kra_pin'=>$business_details['kra_pin'],
                            'signatory_name'=>$business_details['signatory_name']
                        ]);
                        return response()->json(['status' => 'success', 'message' => 'Business Details Updated']);           

        } catch (\Exception $e) {
        
            return response()->json(['status' => 'error', 'message' => [$e]]);
        } 
        
    }
}
