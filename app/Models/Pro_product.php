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
        'unit_id',
        'unit2_id',
        'unit3_id',
        'unit2_factor',
        'unit3_factor',
        'unit2_price',
        'unit3_price',
        'drug', // 0 - 1 drug or non drug
        // Add other frequently used columns
    ];
        public function getfactory()
    {
        return $this->belongsTo(Pro_factory::class, 'factory_id');
    }
        public function getunit()
    {
        return $this->belongsTo(Pro_units::class, 'unit_id');
    }
}

