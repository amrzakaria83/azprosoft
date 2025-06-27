<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SqlServer\SqlServerModel;

class Pro_emp_att extends SqlServerModel
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'emp_att';  // Replace with your actual table name
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';  // Replace with your primary key if different
    
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
        'id',
        'emp_id',
        'date',
        'type', // text is in & out
        'insert_emp_id',
        'store_id',
    ];
    public function getstore()
    {
        return $this->belongsTo(Pro_store::class, 'store_id');
    }
        public function getemangeremp()
    {
        return $this->belongsTo(Emangeremp::class, 'emp_id');
    }
    public function getempadd()
    {
        return $this->belongsTo(Emangeremp::class, 'insert_emp_id');
    }
}

