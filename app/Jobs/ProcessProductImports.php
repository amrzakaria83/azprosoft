<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\Pro_product;

class ProcessProductImports implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $chunkSize;
    public $offset;
    public $tries = 3;
    public $maxExceptions = 2;
    public $timeout = 300;
    public $backoff = [30, 60, 120];

    public function __construct($chunkSize = 100, $offset = 0)
    {
        $this->chunkSize = min($chunkSize, 500);
        $this->offset = $offset;
    }

    public function handle()
    {
        if ($this->batch() && $this->batch()->cancelled()) {
            Log::info("Job cancelled by batch", ['job_id' => $this->job->getJobId()]);
            return;
        }
        
        $this->optimizeDatabaseConnection();

        try {
            $processedCount = 0;
            
            Pro_product::orderBy('product_id')
                ->skip($this->offset)
                ->take($this->chunkSize)
                ->select(['product_id', 'product_name', 'product_name_en', 'sell_price'])
                ->lazyById()
                ->each(function ($prod) use (&$processedCount) {
                    $this->updateOrCreateProduct($prod);
                    $processedCount++;
                    
                    // Report progress every 10 records
                    if ($processedCount % 10 === 0 && $this->batch()) {
                        $this->batch()->add([
                            'processed' => $processedCount,
                            'offset' => $this->offset,
                            'chunkSize' => $this->chunkSize
                        ]);
                    }
                });

            Log::info("Successfully processed chunk", [
                'offset' => $this->offset,
                'chunk_size' => $this->chunkSize,
                'processed_count' => $processedCount
            ]);

        } catch (\Throwable $e) {
            Log::error("Product import chunk failed", [
                'offset' => $this->offset,
                'chunkSize' => $this->chunkSize,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    protected function optimizeDatabaseConnection()
    {
        DB::disableQueryLog();
        DB::connection()->unsetEventDispatcher();
        DB::connection()->setReadPdo(null); // Force reconnection
    }

    protected function updateOrCreateProduct($prod)
    {
        DB::transaction(function () use ($prod) {
            try {
                Product::updateOrCreate(
                    ['product_code' => $prod->product_id],
                    [
                        'name_ar' => $prod->product_name ?? '',
                        'name_en' => $prod->product_name_en ?? '',
                        'sell_price_pub' => $prod->sell_price ?? 0,
                        'last_imported_at' => now(),
                    ]
                );

            } catch (\Exception $e) {
                Log::error("Product processing failed", [
                    'product_id' => $prod->product_id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw $e;
            }
        });
    }

    public function failed(\Throwable $exception)
    {
        Log::critical("Import job failed after retries", [
            'exception' => $exception->getMessage(),
            'job_id' => $this->job?->getJobId() ?? 'unknown',
            'offset' => $this->offset,
            'chunk_size' => $this->chunkSize,
            'trace' => $exception->getTraceAsString()
        ]);
        
        if ($this->batch()) {
            $this->batch()->addFailures([$this]);
        }
    }
}