<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SqlServer\SqlServerModel;

class Pro_purchase_header extends SqlServerModel
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'purchase_header';  // Replace with your actual table name
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'purchase_serial';  // Replace with your primary key if different
    
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
        'purchase_serial',
        'purchase_id',
        'store_id',
        'purchase_no',
        'vendor_id',
        'purchase_note',
        'p_total',
        'p_discount_p',
        'p_discount',
        'p_total_after',
        'tax',
        'back',
        'total_back',
        'total_back_after',
        'emp_id',
        'type',
        'expenses',
        'sell_return',
        'cust_id',
        'return_date',
        'return_kind',
        'total_sell',
        'total_gain',
        'total_tax',
        'pay',
        'rest',
        
    ];
    public function getstore()
    {
        return $this->belongsTo(Pro_store::class, 'store_id');
    }
    public function getvendor()
    {
        return $this->belongsTo(Pro_vendor::class, 'vendor_id');
    }
}

