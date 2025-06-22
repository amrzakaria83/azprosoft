<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SqlServer\SqlServerModel;

class Pro_product extends SqlServerModel
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';  // Replace with your actual table name
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'product_id';  // Replace with your primary key if different
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;  // Set to true if your table has created_at/updated_at
    protected $fillable = [
        'product_id',
        'product_name_en',
        'product_name',
        'sell_price',
        'factory_id',
        // Add other frequently used columns
    ];
}

