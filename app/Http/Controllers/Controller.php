<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Spatie\Permission\Models\Role;
use App\Models\Employee;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus; // Add this import
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\DatabaseService;

use Helper;
use Illuminate\Routing\Controller as BaseController;






class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

protected $databaseService;
     public function __construct(DatabaseService $databaseService)
    {
        $this->databaseService = $databaseService;
        $this->initializeSqlServerConnection();


        // Now you can use the service throughout your controller:
        //             return $this->databaseService->executeWithRetry(function() {
        //         return DB::connection('sqlsrv')->table('your_table')->get();
        // });
    }

    protected function initializeSqlServerConnection()
    {
        try {
            $this->databaseService->executeWithRetry(function() {
                return DB::connection('sqlsrv')->select('SELECT 1 AS test');
            });
        } catch (\Exception $e) {
            Log::error('SQL Server connection failed: ' . $e->getMessage());
            abort(503, 'Database connection unavailable');
        }
    }

}


