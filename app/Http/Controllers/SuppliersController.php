<?php

namespace App\Http\Controllers;

use App\Models\User;

Use App\Models\Supplier;
use DataTables;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SuppliersController extends Controller
{
   public function createSupplier(Request $request){
    $supplier= $request->all();
    try{
        $validated = Validator::make($request->all(), [
            'create_supplier_name' => ['required', 'string', 'max:255', 'unique:suppliers,supplier_name'],
            'create_supplier_kra' => ['nullable', 'string', ],
            'create_supplier_phone' => ['required', 'string', 'unique:suppliers,supplier_phone'],
            'create_supplier_second_phone' => ['nullable', 'string', ],
            'create_supplier_email' => ['required', 'email', 'unique:suppliers,supplier_email'],
            'create_supplier_phy_address' => ['nullable', 'string', 'max:255'],
            'create_supplier_number' => $supplier['create_supplier_number'],
           
        ]);

        if ($validated->fails()) {
                        
            return response()->json(['status' =>'error', 'message' => $validated->errors()->all()]);
        }
        
           $created_supplier= Supplier::create([
                'supplier_name' => $supplier['create_supplier_name'],
                'supplier_phone' => $supplier['create_supplier_phone'],
                'supplier_second_phone' => $supplier['create_supplier_second_phone'],
                'supplier_email' => $supplier['create_supplier_email'],
                'supplier_phy_address' => $supplier['create_supplier_phy_address'],
                'supplier_kra_pin' => $supplier['create_supplier_kra'],
                'supplier_number' => $supplier['create_supplier_number'],
            ]);

            return response()->json(['status' =>'success', 'supplier_id' => $created_supplier['id'], 'message' => 'Supplier created']);

    }catch (\Exception $e) {
                    
        return response()->json(['status' => 'error', 'message' => ['An error occurred please try again later']]);
    }
    
   }

  public function listActiveSuppliers(Request $request){
    if ($request->ajax()) {

        $data = Supplier::select('suppliers.*')
                        ->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $encodedId = base64_encode($row->id);      
                        return
                '<div class="btn-group">
                <a type="button"  href="/suppliers/view/' . $encodedId . '" class="btn btn-success">View</a>
                <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" data-id="' . $encodedId . '" id="update_suppliers_details" href="#">Edit</a></li>
                <li><a class="dropdown-item" data-id="' . $encodedId . '" id="delete_supplier_button" href="#">Delete</a></li>
               

                </ul>
                </div>';
                                                        })
                ->rawColumns(['action'])
                ->make(true);
                    }
                    
                    return view('suppliers.list_active_suppliers');
   }

   public function listDeletedSuppliers(Request $request){
    if ($request->ajax()) {

        $data = Supplier::withTrashed()
                        ->whereNotNull('deleted_at')
                        ->get();
        

        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $encodedId = base64_encode($row->id);      
                        return
                '<div class="btn-group">
                <a type="button"  href="/suppliers/view/' . $encodedId . '" class="btn btn-success">View</a>
                <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" data-id="' . $encodedId . '" id="update_suppliers_details" href="#">Edit</a></li>
                <li><a class="dropdown-item" data-id="' . $encodedId . '" id="activate_supplier_button" href="#">Activate</a></li>
               

                </ul>
                </div>';
                                                        })
                ->rawColumns(['action'])
                ->make(true);
                    }
                    
                    return view('suppliers.list_deleted_suppliers');
   }

   public function viewSupplier($id){
    $id= base64_decode($id);
    $supplier_details= Supplier::withTrashed()
                            ->find($id);

    return view('suppliers.view_suppliers',['supplier_details'=> $supplier_details]);
}
public function editSupplier($id){
    
    $id= base64_decode($id);
    $supplier_details= Supplier::withTrashed()
                                ->find($id);         
    return response()->json($supplier_details);
}

public function updateSupplier(Request $request){
    $supplier= $request->all();
    
    try{
        $validated = Validator::make($request->all(), [
            'create_supplier_name' => ['required', 'string', 'max:255', 'unique:suppliers,supplier_name,' . $supplier['update_supplier_id']],
            'create_supplier_kra' => ['nullable', 'string', ],
            'create_supplier_phone' => ['required', 'string', 'unique:suppliers,supplier_phone,' . $supplier['update_supplier_id']],
            'create_supplier_second_phone' => ['nullable', 'string', ],
            'create_supplier_email' => ['required', 'email', 'unique:suppliers,supplier_email,' . $supplier['update_supplier_id']],
            'create_supplier_phy_address' => ['nullable', 'string', 'max:255'],
            'create_supplier_number' => $supplier['create_supplier_number'],
           
        ]);

        if ($validated->fails()) {
                        
            return response()->json(['status' =>'error', 'message' => $validated->errors()->all()]);
        }
        
            Supplier::where('id',$supplier['update_supplier_id'])
                    ->update([
                            'supplier_name' => $supplier['create_supplier_name'],
                            'supplier_phone' => $supplier['create_supplier_phone'],
                            'supplier_second_phone' => $supplier['create_supplier_second_phone'],
                            'supplier_email' => $supplier['create_supplier_email'],
                            'supplier_phy_address' => $supplier['create_supplier_phy_address'],
                            'supplier_kra_pin' => $supplier['create_supplier_kra'],
                            'supplier_number' => $supplier['create_supplier_number'],
                        ]);
                        return response()->json(['status' => 'success', 'message' => ['Supplier details updated successfully']]);           

    }catch (\Exception $e) {
                    
        return response()->json(['status' => 'error', 'message' => ['An error occurred please try again later']]);
    }
    
   }

   public function deleteSupplier($supplier_id){
    $supplier_id=base64_decode($supplier_id);
    try { 
     Supplier::where('id',$supplier_id)
            ->delete();  
            return response()->json(['status' => 'success', 'message' => 'Supplier deleted']);
        } 
        catch (\Exception $e) {
            
            return response()->json(['status' => 'error', 'message' => [$e]]);
        }                    
}

public function activateSupplier($supplier_id){
    $supplier_id=base64_decode($supplier_id);
   
    try { 
     Supplier::withTrashed()
                 ->find($supplier_id)
                 ->restore();  
        return response()->json(['status' => 'success', 'message' => 'Supplier Activated']);
    } 
    catch (\Exception $e) {
        
        return response()->json(['status' => 'error', 'message' => [$e]]);
    }                    
}

}
