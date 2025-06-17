<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\Product_imp;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Bus\Batch; // For type hinting in callbacks
use Illuminate\Support\Facades\Log; // For logging

class InitiateProductImportBatchingJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $chunkIds;
    public int $chunkSize; // Declare the chunkSize property

    public function __construct(int $chunkSize = 200)
    {
        $this->chunkSize = $chunkSize;
    }

    public function handle()
    {
        $jobs = [];

        Product_imp::orderBy('id')->chunkById($this->chunkSize, function ($chunk) use (&$jobs) {
            $chunkIds = $chunk->pluck('id')->toArray();
            $jobs[] = new ProcessProductImportChunk($chunkIds);
        });

        if (!empty($jobs)) {
            Bus::batch($jobs)
                ->name('Product Import - ' . now()->toDateTimeString()) // Optional: Give the batch a name
                ->then(function (Batch $batch) {
                    Log::info('Product import batch ' . $batch->id . ' completed successfully.');
                })
                ->catch(function (Batch $batch, \Throwable $e) {
                    Log::error('Product import batch ' . $batch->id . ' failed. Error: ' . $e->getMessage());
                })
                ->finally(function (Batch $batch) {
                    Log::info('Product import batch ' . $batch->id . ' has finished processing.');
                })
                ->dispatch();
            Log::info('Dispatched product import batch with ' . count($jobs) . ' chunk jobs.');
        } else {
            Log::info('No products found in Product_imp to import.');
        }
    }
}