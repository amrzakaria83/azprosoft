<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SqlServer\SqlServerModel;

class Emangeremp extends SqlServerModel
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'emp';  // Replace with your actual table name
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'emp_id';  // Replace with your primary key if different
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;  // Set to true if your table has created_at/updated_at
    
     // Disable lazy loading to prevent N+1 issues
     protected $with = [];

     // Only include frequently used columns
     protected $fillable = [
         'emp_id',
         'emp_name',
         'emp_name_en',
         'cust_id',
         'bank_id',
         'emp_kind', // 0 = active - 1 = trainer - 2 = deactivated
         'emp_job',
         'k_id',
         'emp_tell',

     ];
     public function getcust()
    {
        return $this->belongsTo(Pro_customer::class, 'cust_id');
    }
    public function getemp_k()
    {
        return $this->belongsTo(Pro_emp_k::class, 'k_id');
    }
}

