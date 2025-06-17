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

class ProcessProductImportChunk implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $chunkIds;

    public function __construct(array $chunkIds)
    {
        $this->chunkIds = $chunkIds;
    }

    public function handle()
    {
        Product_imp::whereIn('id', $this->chunkIds)->each(function ($prod) {
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
            
            $prodold = Product::updateOrCreate(
                ['product_code' => $prod->product_id],
                $productData
            );
            
            if (!$prodold->exists) {
                $prodold->view_front = 0;
                $prodold->save();
            }
        });
    }
}