<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trans_del extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'pro_emp_code', // emp_add
        'pro_start_id',
        'pro_to_id',
        'status_trans', //0 = watting delevery - 1 = on delevery - 2 = another delevery - 3 = cancelled - 4 = done - 5 = request delevery
        'pro_del_code',
        'start_time',
        'arrive_time',
        'type_tran', //0 = transefer - 1 = order - 2 = other
        'urgent', //0 = unurgent - 1 = urgent
        'pro_no_receit',
        'pro_val_receit',
        'pro_note',
        'pro_empreturn',
        'status',

        
    ];
    public function getstorestart() 
    {

        return $this->belongsTo(Pro_store::class, 'pro_start_id')->select('name');
    }
    public function getstoreend() 
    {

        return $this->belongsTo(Pro_store::class, 'pro_to_id')->select('name');
    }
    public function getemp() 
    {

        return $this->belongsTo(Emangeremp::class, 'pro_del_code');
    }

    public function getempreturn() {

        return $this->belongsTo(Emangeremp::class, 'pro_empreturn');
    }
    // Add this to your model to prevent N+1 queries
    protected $with = ['getemp'];

}
