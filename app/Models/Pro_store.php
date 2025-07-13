<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\SqlServer\SqlServerModel;

class Pro_store extends SqlServerModel
{
    use HasFactory;

    protected $table = 'stores';
    protected $primaryKey = 'store_id';
    public $timestamps = false;
    protected $with = [];

    protected $fillable = [
        'store_id',
        'store_name',
        'active',
        'deleted',
        'b1',
        'b2',
        'r1',
        'r2',
        'r3',
        'logo_s',
    ];

    /**
     * Special store IDs that should always be considered active
     */
    protected static $alwaysActiveStoreIds = [
        // Add your special store_ids here [1, 2, 3, 4, 6, 7, 8, 9, 12, 13, 14, 21]
        1, 2, 3, 4, 6, 7, 8, 9, 12, 13, 14, 21
    ];

    /**
     * Accessor to get the effective active status
     * Returns true if store is in always-active list or active=1
     */
    public function getEffectiveActiveAttribute()
    {
        return in_array($this->store_id, self::$alwaysActiveStoreIds) || $this->active;
    }

    /**
     * Scope for active stores (including special always-active stores)
     */
    public function scopeActive($query)
    {
        return $query->where(function($q) {
            $q->whereIn('store_id', self::$alwaysActiveStoreIds)
              ->orWhere('active', 1);
        });
    }

    /**
     * Scope for inactive stores (excluding special always-active stores)
     */
    public function scopeInactive($query)
    {
        return $query->whereNotIn('store_id', self::$alwaysActiveStoreIds)
                     ->where('active', 0)
                     ->orwhere('active', Null);
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Prevent deactivation of special stores
        static::updating(function($model) {
            if (in_array($model->store_id, self::$alwaysActiveStoreIds)) {
                $model->active = 1; // Force active status
            }
        });
    }
}

// Get all effectively active stores
// $activeStores = Pro_store::active()->get();

// // Check if a specific store is effectively active
// $store = Pro_store::find(1);
// if ($store->effective_active) {
//     // This store is active (either by flag or special status)
// }

// // Get only truly inactive stores (excluding special stores)
// $inactiveStores = Pro_store::inactive()->get();