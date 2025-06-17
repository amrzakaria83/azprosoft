<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property int $prod_id
 * @property string $name_en
 * @property string $name_ar
 * @property string $price
 * @property int $is_sale
 * @property string $sale
 * @property int $cat_id
 * @property int $is_show
 * @property int $itm_unit1
 * @property int $itm_unit2
 * @property int $itm_unit3
 * @property int $mid
 * @property int $sm
 * @property int $type
 * @property int $state
 * @property string $decription
 * @property string $photo
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDecription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsShow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereItmUnit1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereItmUnit2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereItmUnit3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereType($value)
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'product_code',
        'name_ar',
        'name_en', 
        'sell_price_pub', // decimal 8,2
        'sell_price1', // decimal 8,2
        'sell_price2', // decimal 8,2
        'sell_price3', // decimal 8,2
        'unite_id', 
        'unite_id2', 
        'unite_id2_factor', // decimal 8,0
        'unite_id2_price', // decimal 8,2
        'unite_id3', 
        'unite_id3_factor', // decimal 8,0
        'unite_id3_price', // decimal 8,2
        'status', // 0 = active - 1 = not active


    ];
    public function registerMediaCollections(Media $media = null): void
    {
        $this->addMediaCollection('imgprod')

        ->singleFile();

        $this->addMediaCollection('imgprodoffer')

        ->singleFile();

        $this->addMediaConversion('imgprodofferthumb')
        ->crop('crop-center', 300, 100);
    }
    public function getunit()
    {
        return $this->belongsTo(Unite::class, 'unite_id');
    }
    public function getunit2()
    {
        return $this->belongsTo(Unite::class, 'unite_id2');
    }
    public function getunit3()
    {
        return $this->belongsTo(Unite::class, 'unite_id3');
    }
}
