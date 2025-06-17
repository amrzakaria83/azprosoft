<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Azcustomer extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'cust_id',
        'name_ar',
        'name_en',
        'balance', // decimal 8,2
        'sell_price_type', // 0 = sell_price_pub - 1 =sell_price1 - 2 = sell_price2 - 3 = sell_price3
        'lat',
        'lng',
        'map_location',
        'status', // 0 = active - 1 = not active 
        'sale_type_prosoft', // 0 = cash - 1 = delayed - 2 = delivery
        'note',
        'status',
        'sale_type_id', // sale_types table 1 = cash - 2 = delayed - 3 = delivery - 4 = visa
    ];
    // public function getsale_type()
    // {
    //     return $this->belongsTo(Sale_type::class, 'sale_type_id');
    // }

}
