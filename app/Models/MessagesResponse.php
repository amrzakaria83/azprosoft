<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MessagesResponse extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = [
        'message_id',
        'response',
        'status', // 0 = read - 1 = unread 
        'sender_type', // 0 = employee
        'sender_id',
        'receiver_type', // 0 = employee
        'receiver_id', // json('receiver_id')
        
    ];

    public function registerMediaCollections(Media $media = null): void
    {
        $this->addMediaCollection('messages')
            ->singleFile();

        // $this->addMediaConversion('thumb')
        //     ->keepOriginalImageFormat()
        //     ->crop('crop-center', 150, 150);
    }
    public function message() :BelongsTo
    {
        return $this->belongsTo(Message::class, 'message_id');
    }

}
