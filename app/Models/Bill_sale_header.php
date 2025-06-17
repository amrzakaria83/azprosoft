<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill_sale_header extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'emp_id', 
        'emp_code', 
        'total_price', // decimal 8,2
        'total_tax', // decimal 8,2
        'total_extra_discount', // decimal 8,2
        'sale_type_prosoft', // 0 = cash - 1 = delayed - 2 = delivery
        'cust_id', //azcustomers
        'cust_code', // code prosoft
        'status', // 0 = oredred - 1 = done - 3 = cancelled - 4 = paied
    ];
    public function getcust()
    {
        return $this->belongsTo(Azcustomer::class, 'cust_id');
    }
}
