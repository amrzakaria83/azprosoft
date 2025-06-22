<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SqlServer\SqlServerModel;

class Pro_sales_det extends SqlServerModel
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sales_det';  // Replace with your actual table name
    
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
        'product_id',
        'sales_d_id',
        'sales_id',
        'amount',
        'ins_date',
        'price',
        'total_item',
    ];
    public function getprod()
    {
        return $this->belongsTo(Pro_product::class, 'product_id');
    }
    public function getsale_h()
    {
        return $this->belongsTo(Pro_sales_h::class, 'sales_id');
    }
    
}

