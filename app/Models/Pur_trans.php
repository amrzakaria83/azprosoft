<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pur_trans extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pro_emp_code', 
        'id_in_pur_requests',
        'pro_prod_id',
        'pro_vendor_id',
        'note', 
        'quantity', 
        'type_action', //0 = done_pur - 1 = unavilable - 2 = cancell_pur - 3 = some_pur - 4 = udatequnt
        'quantity_befor', 
        'quantity_after', 
        'status', 

    ];
    public function getprod()
    {
        return $this->belongsTo(Pro_product::class, 'pro_prod_id', 'product_id');
    }
    public function getvendor()
    {
        return $this->belongsTo(Pro_vendor::class, 'pro_vendor_id', 'vendor_id');
    }
}
