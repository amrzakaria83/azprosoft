<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SqlServer\SqlServerModel;

class Pro_purchase_details extends SqlServerModel
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'purchase_details';  // Replace with your actual table name
    
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
      'expire_date',
      'amount',
      'bouns',
      'sell_price',
      'buy_price',
      'profit',
      'tax',
      'back',
      'back_amount',
      'back_price',
      'back_bounce',
      'purchase_id',
      'disc_n',
      'p_index',
      'buy_tax',
      'total_buy',
      'profit_n',
      'tax_n',
      'class_id',
    ];
    public function getprod()
    {
        return $this->belongsTo(Pro_product::class, 'product_id');
    }
    public function getpurchase_h()
    {
        return $this->belongsTo(Pro_purchase_header::class, 'purchase_id');
    }
    
}

