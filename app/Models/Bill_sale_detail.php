<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill_sale_detail extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'emp_id', 
        'bill_sale_header_id', 
        'prod_id', // products
        'product_code', // code prosoft
        'unite_id', // unites
        'quantity', // decimal 8,2
        'factor_unit', // decimal 8,0
        'amount', // decimal 8,2
        'sellprice_actuel_item', // decimal 8,2
        'unite_tax', // decimal 8,2
        'extra_discount', // decimal 8,2
        'totalitem_price', // decimal 8,2
        'totalitem_tax', // decimal 8,2
        'note', 
        'status_temporary', // 0 = temporary - 1 = permanent - 2 = cancel
        'status', //0 = active - 1 = not active 
        'expiry_date', 
    ];
    public function getheader()
    {
        return $this->belongsTo(Bill_sale_header::class, 'bill_sale_header_id');
    }
    public function getprod()
    {
        return $this->belongsTo(Product::class, 'prod_id');
    }
    public function getunit()
    {
        return $this->belongsTo(Unite::class, 'unite_id');
    }

}
