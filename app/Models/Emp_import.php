<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emp_import extends Model
{
    use HasFactory, SoftDeletes;
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
    ];
}
