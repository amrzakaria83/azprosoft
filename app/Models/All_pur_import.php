<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class All_pur_import extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id', // product_id
        'quantity',
        'balance_req',
        'note', 
        'status',
        'pro_emp_code',
        'status_request', //0 = waitting - 1 = pur_drug_requests
    ];
}
