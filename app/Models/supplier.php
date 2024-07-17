<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class supplier extends Model
{
    use HasFactory, SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        
        'supplier_name',
        'supplier_phone',
        'supplier_second_phone',
        'supplier_email',
        'supplier_phy_address',
        'supplier_kra_pin',
       
    ];
    protected $dates = ['deleted_at'];
}
