<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_imp extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id', // product_id
        'product_name',
        'product_name_en', 
        'sell_price',
        'unit_id',
        'unit2_id',
        'unit3_id',
        'unit2_factor',
        'unit3_factor',
        'drug', // 0 - 1 drug or non drug
        'status_update', // 0 = waitting - 1 = done
    ];
}
