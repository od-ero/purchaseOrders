<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SendBatch extends Model
{
    use HasFactory;

    use SoftDeletes;
	protected $dates = ['deleted_at'];

    protected $fillable = [
        'batch_id',
        'email_subject',
        'email_body'
    ];
}
