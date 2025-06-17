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

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessProductImports implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $chunkSize;
    public $offset;

    public function __construct($chunkSize = 100, $offset = 0)
    {
        $this->chunkSize = $chunkSize;
        $this->offset = $offset;
    }

    public function handle()
    {
        Product_imp::orderBy('id')
            ->where('status_update' , 0)
            ->skip($this->offset)
            ->take($this->chunkSize)
            ->get()
            ->each(function ($prod) {
                \DB::transaction(function () use ($prod) {
                    $prodold = Product::firstOrNew(['product_code' => $prod->product_id]);
                    
                    $productData = [
                        'product_name' => $prod->product_name ?? '',
                        'product_name_en' => $prod->product_name_en ?? '',
                        'sell_price' => $prod->sell_price ?? 0,
                        'g_drug' => $prod->drug ?? 0,
                        'unit_id' => $prod->unit_id ?? null,
                        'unit2_id' => $prod->unit2_id ?? null,
                        'unit3_id' => $prod->unit3_id ?? null,
                        'unit2_factor' => $prod->unit2_factor ?? 1,
                        'unit3_factor' => $prod->unit3_factor ?? 1,
                    ];
                    
                    if ($prodold->exists) {
                        $prodold->update($productData);
                    } else {
                        $productData['product_code'] = $prod->product_id;
                        $productData['view_front'] = 0;
                        $productData['status_update'] = 1;
                        Product::create($productData);
                    }
                    $productData->update(['status_update' =>  1,]);
                });
            });
    }
}