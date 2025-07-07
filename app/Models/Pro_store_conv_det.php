<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SqlServer\SqlServerModel;

class Pro_store_conv_det extends SqlServerModel
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'store_conv_det';  // Replace with your actual table name
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'sales_d_id';  // Replace with your primary key if different
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;  // Set to true if your table has created_at/updated_at

    // Disable lazy loading to prevent N+1 issues
    protected $with = [];

    // Only include frequently used columns
    protected $fillable = [
        'sales_d_id',
        'sales_id',
        'product_id',
        'amount',
        'price',
        'total_item',
        'notes',
        'return_amount',
        'total_return',
        'ins_date',
        'unit_id',
        'unit_factor',
        'back',
        'return_unit',
        'expire_date',
        'prod_amount_id',
        'buy',
        'itm_count',
        'unit_count',
        'old_price',
        
    ];
    public function getprod()
    {
        return $this->belongsTo(Pro_product::class, 'product_id');
    }
    public function getstore_conv_h()
    {
        return $this->belongsTo(Pro_store_conv_h::class, 'sales_id');
    }
    public function getprod_amount_id()
    {
        return $this->belongsTo(Pro_prod_amount::class, 'prod_amount_id');
    }
}

