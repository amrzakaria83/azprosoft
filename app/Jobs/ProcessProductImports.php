<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\Product_imp;
use App\Models\Pro_product;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessProductImports implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $chunkSize;
    public $offset;
    public $tries = 3;
    public $maxExceptions = 5;
    public $timeout = 120;

    public function __construct($chunkSize = 100, $offset = 0)
    {
        $this->chunkSize = min($chunkSize, 100);
        $this->offset = $offset;
    }

    public function handle()
    {
        if ($this->batch() && $this->batch()->cancelled()) {
            return;
        }

        DB::disableQueryLog();
        DB::connection()->unsetEventDispatcher();

        try {
            Pro_product::orderBy('product_id')
                ->skip($this->offset)
                ->take($this->chunkSize)
                ->select(['product_id', 'product_name', 'product_name_en', 'sell_price'])
                ->lazy()
                ->each(function ($prod) {
                    $this->updateOrCreateProduct($prod);
                });

        } catch (\Throwable $e) {
            Log::error("Product import failed", [
                'offset' => $this->offset,
                'chunkSize' => $this->chunkSize,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
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
                    ]
                );

                if ($this->batch()) {
                    
                }

            } catch (\Exception $e) {
                Log::error("Product processing failed", [
                    'product_id' => $prod->product_id,
                    'error' => $e->getMessage()
                ]);
                throw $e;
            }
        });
    }

    public function failed(\Throwable $exception)
    {
        Log::critical("Import job failed", [
            'exception' => $exception->getMessage(),
            'job' => $this->job?->getJobId() ?? 'unknown',
            'trace' => $exception->getTraceAsString()
        ]);
    }
}

    // public function handle()
    // {
       
    //     Pro_product::orderBy('product_id')
            
    //         ->skip($this->offset)
    //         ->take($this->chunkSize)
    //         ->get()
    //         ->each(function ($prod) {
    //             \DB::transaction(function () use ($prod) {
    //                 $prodold = Product::updateOrCreate(['product_code' => $prod->product_id]);
                    
    //                 $productData = [
    //                     'product_code' => $prod->product_id ?? '',
    //                     'name_ar' => $prod->product_name ?? '',
    //                     'name_en' => $prod->product_name_en ?? '',
    //                     'sell_price_pub' => $prod->sell_price ?? 0,
                        
    //                 ];
                    
    //                 if ($prodold->exists) {
    //                     $prodold->update($productData);
    //                 } else {
    //                     $productData['product_code'] = $prod->product_id;
                        
    //                     Product::create($productData);
    //                 }
                    
    //             });
    //         });
    // }
// }