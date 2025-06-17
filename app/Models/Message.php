<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Message extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = [
        'emp_id',
        'description',
        'status', // 0 = unread - 1 = read 
        'sender_type',
        'sender_id',
        'receiver_type',
        'receiver_id',
        'report_to',
        
    ];

    public function registerMediaCollections(Media $media = null): void
    {
        $this->addMediaCollection('messages')
            ->singleFile();

        // $this->addMediaConversion('thumb')
        //     ->keepOriginalImageFormat()
        //     ->crop('crop-center', 150, 150);
    }
    public function responses(): HasMany
    {
        return $this->hasMany(MessagesResponse::class);
    }

    public function supervisorReciver(): BelongsTo
    {
        return $this->belongsTo(Supervisor::class, 'receiver_id');
    }

    public function userReciver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function supervisorSender(): BelongsTo
    {
        return $this->belongsTo(Supervisor::class, 'sender_id');
    }

    public function userSender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function getemp() {

        return $this->belongsTo(Employee::class, 'sender_id');
    }
    public function getemprecive() {

        return $this->belongsTo(Employee::class, 'receiver_id');
    }
    public function getempreport() {

        return $this->belongsTo(Employee::class, 'report_to');
    }
}
