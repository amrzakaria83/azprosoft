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

    // public function executeWithRetry(callable $callback)
    // {
    //     $attempts = 0;

    //     while ($attempts < $this->maxRetries) {
    //         try {
    //             return $callback();
    //         } catch (QueryException | PDOException $e) {
    //             if ($this->shouldRetry($e)) {
    //                 $attempts++;
    //                 if ($attempts >= $this->maxRetries) {
    //                     throw $e;
    //                 }
    //                 usleep($this->retryDelay * 1000); // Convert to microseconds
    //                 DB::reconnect('sqlsrv');
    //                 continue;
    //             }
    //             throw $e;
    //         }
    //     }
    // }

    // /**
    //  * Determine if the operation should be retried
    //  *
    //  * @param \Exception $e
    //  * @return bool
    //  */
    // protected function shouldRetry(\Exception $e): bool
    // {
    //     // Retry on connection issues or deadlocks
    //     return $e instanceof PDOException 
    //         || $e instanceof QueryException
    //         || str_contains($e->getMessage(), 'deadlock')
    //         || str_contains($e->getMessage(), 'connection');
    // }
    public function executeWithRetry(callable $callback)
{
    $attempts = 0;
    $lastError = null;

    while ($attempts < $this->maxRetries) {
        try {
            return $callback();
        } catch (QueryException | PDOException $e) {
            $lastError = $e;
            if ($this->shouldRetry($e)) {
                $attempts++;
                if ($attempts >= $this->maxRetries) {
                    $this->logFinalFailure($e);
                    throw new \Exception("Database operation failed after {$this->maxRetries} attempts. Last error: ".$e->getMessage());
                }
                sleep($this->retryDelay);
                DB::reconnect('sqlsrv');
                continue;
            }
            throw $e;
        }
    }
}

protected function shouldRetry(\Exception $e): bool
{
    $message = strtolower($e->getMessage());
    
    $retryableErrors = [
        'login failed',
        'connection',
        'timeout',
        'deadlock',
        'transport-level error'
    ];

    foreach ($retryableErrors as $error) {
        if (str_contains($message, $error)) {
            return true;
        }
    }
    
    return false;
}

protected function logFinalFailure(\Exception $e)
{
    \Log::error('Database operation failed permanently', [
        'error' => $e->getMessage(),
        'code' => $e->getCode(),
        'trace' => $e->getTraceAsString()
    ]);
}
}