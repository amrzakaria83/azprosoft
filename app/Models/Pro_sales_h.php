<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SqlServer\SqlServerModel;

class Pro_sales_h extends SqlServerModel
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sales_h';  // Replace with your actual table name
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'sales_id';  // Replace with your primary key if different
    
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
        'sales_id',
        'inv_no',
        'cust_id',
        'store_id',
        'kind', // 1 = cash - 2 = delayed - 3 = delivery - 4 = visa 
    ];
    public function getcust()
    {
        return $this->belongsTo(Pro_customer::class, 'cust_id');
    }
    public function getstore()
    {
        return $this->belongsTo(Pro_store::class, 'store_id');
    }
    
    
}

