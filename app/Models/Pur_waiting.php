<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pur_waiting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pro_emp_code', 
        'pur_requests_id', // pur_requests
        'pur_trans_id', // pur_trans
        'quantity',
        'id_in_purchase_details',
        'status_pur', // 0 =  waiting - 1 = done - 2 = some_done - 3 = cancell_all
        'status', 
        'note', 

    ];
    public function getpur_request()
    {
        return $this->belongsTo(Pur_request::class, 'pur_requests_id');
    }
    public function getpur_trans()
    {
        return $this->belongsTo(Pur_trans::class, 'pur_trans_id');
    }
     public function getpurchase_d()
    {
        return $this->belongsTo(Pro_purchase_details::class, 'id_in_purchase_details');
    }
}
