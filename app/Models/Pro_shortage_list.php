<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SqlServer\SqlServerModel;

class Pro_shortage_list extends SqlServerModel
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shortage_list';  // Replace with your actual table name
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';  // Replace with your primary key if different
    
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
        'id',
      'class',
      'product_id',
      'general',
      'notes',
      'store_id',
      'insert_uid',
      'insert_date',
      'update_uid',
      'update_date',
      'vendor_id',
      'amount',
        
    ];
    public function getprod()
    {
        return $this->belongsTo(Pro_product::class, 'product_id');
    }
    public function getstore()
    {
        return $this->belongsTo(Pro_store::class, 'store_id');
    }
    public function getemp_id()
    {
        return $this->belongsTo(Emangeremp::class, 'insert_uid', 'emp_id');
    }
}

