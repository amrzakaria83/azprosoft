<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unite extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'unite_code', // code_prosoft
        'name_ar',
        'name_en',
        'status',
    ];
}
