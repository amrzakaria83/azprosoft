<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emp_att_overtime extends Model
{
    use HasFactory, SoftDeletes;
    protected $casts = [
        'attendance_in_over_from_manger' => 'datetime',
        'attendance_out_over_to_manger' => 'datetime',
    ];
    protected $fillable = [
        'emp_id', // emp_add
        'emp_att_overtime', 
        'man_att_overtime', // manger
        'attendance_in_over_from',
        'attendance_out_over_to',
        'attendance_in_over_from_manger',
        'attendance_out_over_to_manger',
        'type_emp_att_request', //0 = normal rate - 1 = over rate 
        'type_emp_att_mang', // 0 = normal rate - 1 = over rate (manger)
        'statusmangeraprove', // 0 = waitting - 1 = approved - 2 = rejected - 3 = delayed (manger)
        'noterequest', 
        'notemanger', // (manger)
        'status', // 0 = active - 1 = not active
    ];
    public function getemp() 
    {
        return $this->belongsTo(Employee::class, 'emp_att_overtime');
    }
    public function getemp_manger() 
    {
        return $this->belongsTo(Employee::class, 'man_att_overtime');
    }
}
