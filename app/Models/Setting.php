<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\App;

/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string|null $name_ar
 * @property string|null $name_en
 * @property string|null $email
 * @property string|null $email2
 * @property string|null $phone
 * @property string|null $phone2
 * @property string|null $whatsapp
 * @property string|null $address
 * @property string|null $address2
 * @property string|null $location
 * @property string|null $tax_num
 * @property string|null $commercial_num
 * @property string|null $currency
 * @property string|null $facebook
 * @property string|null $twitter
 * @property string|null $youtube
 * @property string|null $linkedin
 * @property string|null $instagram
 * @property string|null $snapchat
 * @property string|null $keywords_ar
 * @property string|null $keywords_en
 * @property string|null $description_ar
 * @property string|null $description_en
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $append_description
 * @property-read mixed $append_keywords
 * @property-read mixed $append_name
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @method static \Database\Factories\SettingFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCommercialNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereDescriptionAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereDescriptionEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereEmail2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereInstagram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereKeywordsAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereKeywordsEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereLinkedin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting wherePhone2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereSnapchat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereTaxNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereTwitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereWhatsapp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereYoutube($value)
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, Media> $media
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, Media> $media
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, Media> $media
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, Media> $media
 * @mixin \Eloquent
 */
class Setting extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name_ar',
        'name_en',
        'email',
        'email2',
        'phone',
        'phone2',
        'whatsapp',
        'address',
        'address2',
        'location',
        'facebook',
        'twitter',
        'youtube',
        'linkedin',
        'instagram',
        'snapchat',
        'keywords_ar',
        'keywords_en',
        'description_ar',
        'description_en',
        'tax_num',
        'commercial_num',
        'currency',

    ];

    public function registerMediaCollections(Media $media = null): void
    {
        $this->addMediaCollection('logo')
        ->singleFile();

        $this->addMediaCollection('logoDark')
        ->singleFile();

        $this->addMediaCollection('fav')
        ->singleFile();

        $this->addMediaCollection('breadcrumb')
        ->singleFile();

        // $this->addMediaConversion('thumb')
        // ->crop('crop-center', 100, 100);
    }

    public function getAppendNameAttribute()
    {
        if ($locale = App::getLocale() == "ar") {
            return $this->name_ar;
        } else {
            return $this->name_en;
        }
    }

    public function getAppendKeywordsAttribute()
    {
        if ($locale = App::getLocale() == "ar") {
            return $this->keywords_ar;
        } else {
            return $this->keywords_en;
        }
    }

    public function getAppendDescriptionAttribute()
    {
        if ($locale = App::getLocale() == "ar") {
            return $this->description_ar;
        } else {
            return $this->description_en;
        }
    }
}
