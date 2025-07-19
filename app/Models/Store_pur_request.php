<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store_pur_request extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pro_emp_code', 
        'pro_start_id',
        'pro_prod_id',
        'name_cust',
        'phone_cust', 
        'note', 
        'status', //0 =  Pending - 1 = Requested - 2 = Arrived at the store - 3 = Cancelled - 4 = Executed - 5 = Cancel the execution
        'quantity', 
        'type_request', // 0 = cash - 1 = phone - 2 = whatsapp - 3 = page - 4 = instagram 
        'balance_req', 
        'status_request',// 0 = waitting - 1 = pur_drug_requests
        
    ];
    public function getprod()
    {
        return $this->belongsTo(Pro_product::class, 'pro_prod_id', 'product_id');
    }
    public function getstore()
    {
        return $this->belongsTo(Pro_store::class, 'pro_start_id');
    }
}
