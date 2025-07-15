<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use PDOException;

class RetryDatabaseQueries
{
    public function handle($request, Closure $next)
    {
        $maxRetries = config('database.connections.sqlsrv.retries.max', 3);
        $attempts = 0;

        while ($attempts < $maxRetries) {
            try {
                return $next($request);
            } catch (QueryException | PDOException $e) {
                if (str_contains($e->getMessage(), 'The wait operation timed out')) {
                    $attempts++;
                    if ($attempts >= $maxRetries) {
                        throw $e;
                    }
                    usleep(config('database.connections.sqlsrv.retries.delay', 2000) * 1000);
                    DB::reconnect();
                    continue;
                }
                throw $e;
            }
        }
    }
}