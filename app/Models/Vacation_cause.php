<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacation_cause extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'emp_id', // emp_add 
        'name_en',
        'name_ar',
        'note',
        'status',
    ];
}
