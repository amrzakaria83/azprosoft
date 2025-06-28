<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emp_att_permission extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'emp_id', // emp_add
        'emp_att_permission', 
        'man_att_permission', // manger
        'attendance_out_from',
        'attendance_in_to',
        'attendance_out_from_manger',
        'attendance_in_to_manger',
        'type_emp_att_request', // 0 = Late attendance - 1 = in work day - 2 = Early departure
        'emp_att_request', // 0 = without salary - 1 = 50%salary - 2 = fullsalary
        'type_emp_att_mang', // 0 = without salary - 1 = 50%salary - 2 = fullsalary (manger)
        'statusmangeraprove', // 0 = waitting - 1 = approved - 2 = rejected - 3 = delayed (manger)
        'noterequest', 
        'notemanger', // (manger)
        'status', // 0 = active - 1 = not active 
    ];
    public function getemp() 
    {
        return $this->belongsTo(Employee::class, 'emp_att_permission');
    }
    public function getemp_manger() 
    {
        return $this->belongsTo(Employee::class, 'man_att_permission');
    }
}
