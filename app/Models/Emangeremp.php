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
    protected $primaryKey = 'id';  // Replace with your primary key if different
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;  // Set to true if your table has created_at/updated_at
}

