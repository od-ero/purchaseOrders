<?php

namespace App\Http\Controllers;
use App\Models\BusinessDetail;
use App\Models\EmailBody;
use Illuminate\Http\Request;

class BusinessDetailsController extends Controller
{
    public function businessDetails(){
        $business_details = BusinessDetail::find(1);
        return view('business_details.business_details', ['business_details' => $business_details]);
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
    public function systemBusinessName(){
        $system_name = BusinessDetail::where('id',1)
                                            ->value('system_name');
        return view('business_details.view_system_name', ['system_name' => $system_name]);
    }

    public function updateSystemBusinessName(Request $request){
        $system_name= $request->all();
        $system_name = $request['system_name'];
        try{
         BusinessDetail::where('id',1)
                        ->update(['system_name'=>$system_name]);
        $request->session()->put('system_name', $system_name);                               
        return response()->json(['status' => 'success', 'message' => 'System Name Updated']);
    } catch (\Exception $e) {
        
        return response()->json(['status' => 'error', 'message' => $e]);
    } 
    }

    public function emailContent(){
        $email_content = EmailBody::find(1);
        return view('business_details.email_content', ['email_content' => $email_content]);
    }

    public function updateEmailContent(Request $request){
        $email_content= $request->all();
        
        try{
            EmailBody::where('id',1)
                        ->update(['email_subject'=>$email_content['email_subject'],
                                    'email_body'=>$email_content['email_body'],
                                    'email_cc'=>$email_content['email_cc'],
                            ]);

        return response()->json(['status' => 'success', 'message' => 'Default Email Content Updated']);
    } catch (\Exception $e) {
        
        return response()->json(['status' => 'error', 'message' => ['An error Occurred']]);
    } 
    }

    
}
