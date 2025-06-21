<?php

namespace App\Models\SqlServer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SqlServerModel extends Model
{
    use HasFactory;
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'sqlsrv';
    
    /**
     * Disable Laravel's mass assignment protection
     * 
     * @var bool
     */
    protected $guarded = [];
}

