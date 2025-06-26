<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\App;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\Employee
 *
 * @property int $id
 * @property string $name_ar
 * @property string|null $name_en
 * @property string|null $phone
 * @property string|null $email
 * @property string $password
 * @property string $is_active 0 => not active, 1 => active, 2 => suspended , 3 => terminated
 * @property int $role_id
 * @property string $type
 * @property string|null $token
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $append_name
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\EmployeeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withoutTrashed()
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, Media> $media
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, Media> $media
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, Media> $media
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, Media> $media
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property int $emp_code
 * @property int $national_no
 * @property string $birth_date
 * @property string $work_date
 * @property string $address1
 * @property string|null $address2
 * @property string|null $address3
 * @property int $phone2
 * @property int $phone3
 * @property string $gender 0 = male, 1 = female
 * @property string $method_for_payment 0 = cash, 1 = bank_transefer
 * @property string|null $acc_bank_no
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAccBankNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAddress3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEmpCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereMethodForPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereNationalNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePhone2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePhone3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereWorkDate($value)
 * @mixin \Eloquent
 */
class Employee extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasRoles,HasFactory, Notifiable, InteractsWithMedia, SoftDeletes;

    protected $guard = "admin";

    protected $fillable = [
        'emp_code', // unsignedBigInteger
        'name_ar',
        'name_en',
        'phone',
        'emailaz',
        'role_id',
        'is_active',// 0 = not active, 1 = active, 2 = suspended , 3 = terminated
        'type', //0 = admin, 1 = no dash 3 = subadmin, 4 = superadmin
        'password',
        'emangeremp_id',
    ];



    public function registerMediaCollections(Media $media = null): void
    {
        $this->addMediaCollection('profile')
        ->singleFile();

        // $this->addMediaConversion('thumb')
        // ->crop('crop-center', 100, 100);
    }
    public function getjob() {

        return $this->belongsTo(Job::class, 'jobs_code' )->select('id', 'name_ar');
    }

    public function getAppendNameAttribute()
    {
        if ($locale = App::getLocale() == "ar") {
            return $this->name_ar;
        } else {
            return $this->name_en;
        }
    }
}
