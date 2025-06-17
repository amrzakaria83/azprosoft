<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Ticket
 *
 * @property int $id
 * @property int $user_id
 * @property string $name_rd
 * @property float $price_rd
 * @property string $date
 * @property string $project
 * @property int $barcode
 * @property int $bdg
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereBdg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereNameRd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket wherePriceRd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereProject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket withoutTrashed()
 * @mixin \Eloquent
 */
class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name_rd',
        'price_rd',
        'date',
        'project',
        'barcode',
        'bdg',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
