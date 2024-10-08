<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderBatches extends Model
{
    use HasFactory;

    use SoftDeletes;
	protected $dates = ['deleted_at'];

    protected $fillable = [
        'batch_name',
        'supplier_id',
        'supplier_name',
        'order_no',
        'ordered'
        
    ];
}
