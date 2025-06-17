<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product_non_coded extends Model  implements HasMedia
{
    use HasFactory , InteractsWithMedia;
    protected $fillable = [
        'emp_code',
        'start_id',
        'name_cust',
        'phone_cust',
        'note',
        'product_name_en',
        'product_name_ar',
        'quantity',
        'status', //  قيد الانتظار=  0  تم التنفيذ =4-- تم الطلب =1 - وصول للصيدلية= 2 - 3= الغاء الطلب  -  5= الغاء التنفيذ
        'type_request',
    ];
    public function getstore() {

        return $this->belongsTo(Site::class, 'start_id' )->select('name');
    }
    public function getemp() {

        return $this->belongsTo(Employee::class, 'emp_code');
    }
    public function registerMediaCollections(Media $media = null): void
    {
        $this->addMediaCollection('product')
        ->singleFile();

        // $this->addMediaConversion('thumb')
        // ->crop('crop-center', 100, 100);
    }

}
