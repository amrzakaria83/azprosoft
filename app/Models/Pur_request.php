<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pur_request extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pro_emp_code', 
        'table_name_id', // 0 =  all_pur_imports - 1 = store_pur_requests - 2 = unknowen (json)
        'pro_prod_id',
        'quantity',
        'note', 
        'status', //0 =  Pending - 1 = Requested - 2 = Arrived at the store - 3 = Cancelled - 4 = Executed - 5 = Cancel the execution - 6 = import purshase - 7 = done - 8 = updated
        'status_pur', //0 =  Pending - 1 = done - 2 = some_done - 3 = cancell_all
        
    ];
    public function getprod()
    {
        return $this->belongsTo(Pro_product::class, 'pro_prod_id', 'product_id');
    }
}
