<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use PDOException;

class DatabaseService
{
    protected $maxRetries;
    protected $retryDelay;

    public function __construct()
    {
        $this->maxRetries = config('database.connections.sqlsrv.retries.max', 3);
        $this->retryDelay = config('database.connections.sqlsrv.retries.delay', 2000);
    }

    public function executeWithRetry(callable $callback)
    {
        $attempts = 0;

        while ($attempts < $this->maxRetries) {
            try {
                return $callback();
            } catch (QueryException | PDOException $e) {
                if (str_contains($e->getMessage(), 'The wait operation timed out')) {
                    $attempts++;
                    if ($attempts >= $this->maxRetries) {
                        throw $e;
                    }
                    usleep($this->retryDelay * 1000);
                    DB::reconnect();
                    continue;
                }
                throw $e;
            }
        }
    }
}