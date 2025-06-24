<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SqlServer\SqlServerModel;

class Pro_prod_amount extends SqlServerModel
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prod_amount';  // Replace with your actual table name
    
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
        'product_id',
        'prod_amount',
        'store_id',
        'ins_date',

    ];




    public function getprod()
    {
        return $this->belongsTo(Pro_product::class, 'product_id');
    }

    public function getsite()
    {
        return $this->belongsTo(Pro_store::class, 'store_id');
    }
 
    
}

