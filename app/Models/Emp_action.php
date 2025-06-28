<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emp_action extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'emp_id', // emp_add (manger)
        'emp_action_id', 
        'no_days', // tinyInteger
        'value',
        'value_befor',
        'note', 
        'type', // 0 = penalties - 1 = rewards
        'status', // 0 = active - 1 = not active - 2 = done 
        
    ];
    public function getemp() 
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }
    public function getemp_action() 
    {
        return $this->belongsTo(Employee::class, 'emp_action_id');
    }
}
