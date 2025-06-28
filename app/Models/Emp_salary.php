<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emp_salary extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'emp_id', // emp_add
        'emp_salary', // emp_salary
        'value',
        'value_befor',
        'note',
        'type', //0 = perhour-mounthly trans('lang.perhour') - 1 = total-mounthly trans('lang.total') 
        'status', // 0 = active - 1 = not active
    ];
    public function getempsalary() 
    {
        return $this->belongsTo(Employee::class, 'emp_salary');
    }
}
