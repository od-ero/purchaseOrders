<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use HasFactory;

    use SoftDeletes;
	protected $dates = ['deleted_at'];

    protected $fillable = [
        'order_batch_id',
        'product_name',
        'quantity',
         'price_quantity',
        'description',
    ];

}
