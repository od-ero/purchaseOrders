<?php

namespace App\Http\Controllers;

use App\Models\User;

Use App\Models\Supplier;

use Illuminate\Http\Request;

class SuppliersController extends Controller
{
   public function createSupplier(Request $request){
    $suppier= $request->all();
        Supplier::create([
            'supplier_name' => $suppier['supplier_name'],
            'supplier_phone' => $suppier['supplier_phone'],
            'supplier_second_phone' => $suppier['supplier_second_phone'],
            'supplier_email' => $suppier['supplier_email'],
            'supplier_phy_address' => $suppier['supplier_phy_address'],
            'supplier_kra' => $suppier['supplier_kra'],
        ]);
   }
}
