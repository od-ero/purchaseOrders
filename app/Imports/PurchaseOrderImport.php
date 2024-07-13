<?php

namespace App\Imports;

use App\Models\PurchaseOrder;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PurchaseOrderImport implements ToModel, WithHeadingRow ,WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    //protected $product_batch_id;

    // public function __construct($product_batch_id)
    // {
    //     $this->product_batch_id = $product_batch_id;
       
    // }

    public function model(array $row)
    {   
          
        return new PurchaseOrder([
            //
        ]);
    }

    public function rules(): array
    {
        return [
        ];
    }
}

