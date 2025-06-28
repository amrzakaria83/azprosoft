<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emp_plan_att extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'emp_id', // emp_add
        'emp_plan_att', 
        'attendance_in_at',
        'attendance_out_at',
        'hours_work',
        'weekly_dayoff', // json
        'work_loct_id', // work_locations
        'note',
        'coutnt_shift', // no. of shift (tinyInteger)
        'shift_att_in_out', // No of shitf and time in and out(json)
        'status', // 0 = active - 1 = not active 
    ];
    public function getemp() 
    {
        return $this->belongsTo(Employee::class, 'emp_plan_att');
    }
    public function getwor_loc() 
    {
        return $this->belongsTo(Work_location::class, 'work_loct_id');
    }
}
