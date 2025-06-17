<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Cart
 *
 * @property int $id
 * @property int $user_id
 * @property string $name_rd
 * @property float $price_rd
 * @property string $date
 * @property string $project
 * @property string $barcode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereNameRd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart wherePriceRd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereProject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereUserId($value)
 * @mixin \Eloquent
 */
class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_rd',
        'price_rd',
        'date',
        'project',
        'barcode',
        'user_id',
    ];
}
