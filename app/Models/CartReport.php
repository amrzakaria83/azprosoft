<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CartReport
 *
 * @property int $id
 * @property int $user_id
 * @property string $project
 * @property string $name_rd
 * @property int $qty
 * @property float $price_rd
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CartReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|CartReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartReport whereNameRd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartReport wherePriceRd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartReport whereProject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartReport whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartReport whereUserId($value)
 * @mixin \Eloquent
 */
class CartReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_rd',
        'price_rd',
        'qty',
        'project',
        'user_id',
    ];
}
