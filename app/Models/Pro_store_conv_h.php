<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SqlServer\SqlServerModel;

class Pro_store_conv_h extends SqlServerModel
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'store_conv_h';  // Replace with your actual table name
    
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
      'inv_total',
      'discount',
      'discount_per',
      'delivery_id',
      'table_id',
      'date',
      'emp_id',
      'capt_id',
      'total_return',
      'delev_collect',
      'kind',
      'notes',
      'back',
      'store_id',
      'to_store_id',
      'is_open', // 0 = received  - 1 = under delivery
      'r_emp_id',
      'erg',
        
    ];
    public function getstorefrom()
    {
        return $this->belongsTo(Pro_store::class, 'store_id');
    }
    public function getstoreto()
    {
        return $this->belongsTo(Pro_store::class, 'to_store_id');
    }
    
    public function getemp_id_send()
    {
        return $this->belongsTo(Emangeremp::class, 'emp_id');
    }
    public function getemp_id_rece()
    {
        return $this->belongsTo(Emangeremp::class, 'r_emp_id');
    }
}

