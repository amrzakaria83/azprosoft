<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\Product_imp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class SyncProductsFromPurImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public int $tries = 1; // Or set to a higher number if you want retries on failure

    /**
     * The maximum number of seconds the job can run before timing out.
     *
     * @var int
     */
    public int $timeout = 7200; // 2 hours, adjust as needed

    protected int $chunkSize;

    /**
     * Create a new job instance.
     *
     * @param int $chunkSize The number of Product_imp records to process in each batch.
     */
    public function __construct(int $chunkSize = 200)
    {
        $this->chunkSize = $chunkSize;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $unprocessedCount = Product_imp::where('status_update', 0)->count();

        if ($unprocessedCount === 0) {
            Log::info('No unprocessed records found');
            return;
        }

        Log::info('[SyncProductsFromPurImportJob] Starting product synchronization from Product_imp.');
        $startTime = microtime(true);
        $totalProcessed = 0;
        $totalCreated = 0;
        $totalUpdated = 0;

        Product_imp::where('status_update', 0)
                ->orderBy('id')
                ->chunkById($this->chunkSize, function ($purImportsChunk) use (&$totalProcessed, &$totalCreated, &$totalUpdated) {
                    $currentChunkProductCodes = $purImportsChunk
                        ->pluck('product_id')
                        ->filter()
                        ->unique()
                        ->toArray();

                    if (empty($currentChunkProductCodes)) {
                        Log::info('[SyncProductsFromPurImportJob] Chunk has no valid product_ids to process.');
                        return true;
                    }

                    $existingProducts = Product::whereIn('product_code', $currentChunkProductCodes)
                        ->get()
                        ->keyBy('product_code');

                    foreach ($purImportsChunk as $purImportItem) {
                        $totalProcessed++;
                        
                        if (empty($purImportItem->product_id)) {
                            Log::warning('[SyncProductsFromPurImportJob] Skipped Product_imp item due to missing product_id.', 
                                ['Product_imp_id' => $purImportItem->id]);
                            continue;
                        }

                        $productData = [
                            'product_code' => $purImportItem->product_id,
                            'product_name' => $purImportItem->product_name,
                            'product_name_en' => $purImportItem->product_name_en ?: $purImportItem->product_name,
                            'sell_price' => $purImportItem->sell_price,
                            'unit_id' => $purImportItem->unit_id,
                            'unit2_id' => $purImportItem->unit2_id,
                            'unit3_id' => $purImportItem->unit3_id,
                            'unit2_factor' => $purImportItem->unit2_factor,
                            'unit3_factor' => $purImportItem->unit3_factor,
                            'g_drug' => $purImportItem->drug,
                        ];

                        $productData = array_filter($productData, function ($value) {
                            return !is_null($value);
                        });

                        try {
                            if (isset($existingProducts[$purImportItem->product_id])) {
                                $product = $existingProducts[$purImportItem->product_id];
                                $product->fill($productData);

                                if ($product->isDirty()) {
                                    $product->save();
                                    $totalUpdated++;
                                }
                                $purImportItem->update(['status_update' => 1]);
                            } else {
                                Product::create($productData);
                                $totalCreated++;
                                Product_imp::where('product_id', $purImportItem->product_id)
                                        ->update(['status_update' => 1]);
                            }
                        } catch (Throwable $e) {
                            Log::error('[SyncProductsFromPurImportJob] Error processing product.', [
                                'product_code' => $purImportItem->product_id,
                                'Product_imp_id' => $purImportItem->id,
                                'error' => $e->getMessage(),
                                'data_sent' => $productData,
                            ]);
                        }
                    }

                    unset($existingProducts, $purImportsChunk, $currentChunkProductCodes);
                    gc_collect_cycles();
                    Log::info("[SyncProductsFromPurImportJob] Processed a chunk. So far: Total Processed: $totalProcessed, Created: $totalCreated, Updated: $totalUpdated");
                });

        $duration = microtime(true) - $startTime;
        Log::info("[SyncProductsFromPurImportJob] Finished. Total Processed: $totalProcessed, Created: $totalCreated, Updated: $totalUpdated. Duration: " . round($duration, 2) . " seconds.");
    }
    // public function handle(): void
    // {
    //     $unprocessedCount = Product_imp::where('status_update', 0)->count();
    
    //     if ($unprocessedCount === 0) {
    //         Log::info('No unprocessed records found');
    //         return; // Exit gracefully
    //     }
    //     Log::info('[SyncProductsFromPurImportJob] Starting product synchronization from Product_imp.');
    //     $startTime = microtime(true);
    //     $totalProcessed = 0;
    //     $totalCreated = 0;
    //     $totalUpdated = 0;
        
    //     // Ensure your QUEUE_CONNECTION in .env is set to 'database' or another async driver.
    //     // And that your queue worker is running: php artisan queue:work

    //     Product_imp::where('status_update' , 0)->orderBy('id')->chunkById($this->chunkSize, function ($purImportsChunk) use (&$totalProcessed, &$totalCreated, &$totalUpdated) {
    //         $currentChunkProductCodes = $purImportsChunk
    //             ->pluck('product_id')
    //             ->filter() // Remove null or empty product_ids
    //             ->unique()
    //             ->toArray();
    //         // dd($currentChunkProductCodes);
    //         if (empty($currentChunkProductCodes)) {
    //             Log::info('[SyncProductsFromPurImportJob] Chunk has no valid product_ids to process.');
    //             return true; // Continue to the next chunk
    //         }

    //         // Fetch existing products for this chunk in one query
    //         // Assuming Product_imp.product_id maps to Product.product_code
    //         $existingProducts = Product::whereIn('product_code', $currentChunkProductCodes)
    //             ->get()
    //             ->keyBy('product_code');

    //         foreach ($purImportsChunk as $purImportItem) {
    //             $totalProcessed++;
    //             if (empty($purImportItem->product_id)) {
    //                 Log::warning('[SyncProductsFromPurImportJob] Skipped Product_imp item due to missing product_id.', ['Product_imp_id' => $purImportItem->id]);
    //                 continue;
    //             }

    //             $productData = [
    //                 // --- Core Mappings ---
    //                 'product_code'      => $purImportItem->product_id, // This is the key for matching
    //                 'product_name'      => $purImportItem->product_name,
    //                 'product_name_en'   => $purImportItem->product_name_en ?: $purImportItem->product_name, // Fallback if product_name_en is empty
    //                 'sell_price'        => $purImportItem->sell_price,
    //                 'unit_id'           => $purImportItem->unit_id,
    //                 'unit2_id'          => $purImportItem->unit2_id,
    //                 'unit3_id'          => $purImportItem->unit3_id,
    //                 'unit2_factor'      => $purImportItem->unit2_factor,
    //                 'unit3_factor'      => $purImportItem->unit3_factor,
    //                 'g_drug'            => $purImportItem->drug, // Maps to 'g_drug' in Product model

    //                 // --- Optional Mappings & Defaults (Review and adjust as needed) ---
    //                 // 'notes'             => $purImportItem->note,
    //                 // 'factory_id'        => $this->getFactoryIdFromName($purImportItem->factory_name), // Requires a helper method if factory_name needs conversion to ID

    //                 // --- Fields from Product model that might need default values if not in Product_imp ---
    //                 // 'emp_code'          => 'SYSTEM_IMPORT', // Or a specific user/system identifier
    //                 // 'cat_id'            => 1, // Example: Default category ID
    //                 // 'drug_undrug'       => $purImportItem->drug == 1 ? 1 : 0, // Example if drug_undrug is different from g_drug
    //                 // 'print_b'           => 1, // Example default
    //                 // 'no_stock'          => $purImportItem->stock <= 0 ? 1 : 0, // Example logic for no_stock flag
    //                 // 'buy_unit'          => $purImportItem->unit_id, // Assuming buy_unit is same as primary unit
    //                 // 'sell_unit'         => $purImportItem->unit_id, // Assuming sell_unit is same as primary unit
    //             ];
                
    //             // Remove null values from $productData to prevent overriding existing valid data with nulls
    //             // unless explicitly intended. If nulls from Product_imp should overwrite, remove this filter.
    //             $productData = array_filter($productData, function ($value) {
    //                 return !is_null($value);
    //             });


    //             try {
    //                 if (isset($existingProducts[$purImportItem->product_id])) {
    //                     // Product exists, update it
    //                     $product = $existingProducts[$purImportItem->product_id];
    //                     $product->fill($productData);

    //                     if ($product->isDirty()) {
    //                         $product->save();
    //                         $totalUpdated++;
    //                     }
    //                     $purImportItem->status_update->update(['status_update' =>  1,]);
    //                 } else {
    //                     // Product does not exist, create it
    //                     // Ensure all non-nullable fields in 'products' table without defaults are in $productData
    //                     $existeprod_imp = Product_imp::where('product_id', $productData->product_id)->first();
    //                     Product::create($productData);
    //                     $totalCreated++;

    //                     $existeprod_imp->update(['status_update' =>  1,]);
    //                 }
    //             } catch (Throwable $e) {
    //                 Log::error('[SyncProductsFromPurImportJob] Error processing product.', [
    //                     'product_code'  => $purImportItem->product_id,
    //                     'Product_imp_id' => $purImportItem->id,
    //                     'error'         => $e->getMessage(),
    //                     'data_sent'     => $productData, // Be cautious logging full data in production
    //                     // 'trace'      => $e->getTraceAsString() // Very verbose, use for debugging
    //                 ]);
    //             }
    //         }
    //         // Optional: release memory if dealing with extremely large datasets and long run times
    //         unset($existingProducts, $purImportsChunk, $currentChunkProductCodes);
    //         if (function_exists('gc_collect_cycles')) {
    //             gc_collect_cycles();
    //         }
    //         Log::info("[SyncProductsFromPurImportJob] Processed a chunk. So far: Total Processed: $totalProcessed, Created: $totalCreated, Updated: $totalUpdated");
    //     });

    //     $duration = microtime(true) - $startTime;
    //     Log::info("[SyncProductsFromPurImportJob] Finished. Total Processed: $totalProcessed, Created: $totalCreated, Updated: $totalUpdated. Duration: " . round($duration, 2) . " seconds.");
    // }

    /**
     * Handle a job failure.
     */
    public function failed(Throwable $exception): void
    {
        Log::critical('[SyncProductsFromPurImportJob] Job failed.', [
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(), // Log full trace on critical failure
        ]);
    }

    /**
     * Example helper function if you need to convert factory_name to an ID.
     * You would need to implement the actual lookup logic.
     */
    // private function getFactoryIdFromName(?string $factoryName): ?int
    // {
    //     if (empty($factoryName)) {
    //         return null;
    //     }
    //     // $factory = \App\Models\Factory::where('name', $factoryName)->first();
    //     // return $factory ? $factory->id : null;
    //     return null; // Placeholder
    // }
}
