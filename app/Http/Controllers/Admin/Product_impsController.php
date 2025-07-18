<?php

namespace App\Http\Controllers\Admin;
set_time_limit(3600);
ini_set('max_execution_time', 4800);
ini_set('memory_limit', '4096M');
use App\Http\Controllers\Controller;
use App\Jobs\SyncProductsFromPurImportJob;
use Illuminate\Support\Facades\Redirect; // Or your preferred redirect method
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel; 
// use App\Imports\Product_imp;
use App\Models\Product_imp;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Site;
use App\Jobs\ProcessProductImportChunk; // Add this import
use App\Jobs\ProcessProductImports; // Add this import
use App\Jobs\InitiateProductImportBatchingJob; // Add this
use Illuminate\Support\Facades\Bus; // Add this import
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Auth;
use App\Models\SqlServer\SqlServerModel;
use App\Models\Emangeremp;
use App\Models\Pro_product;

class Product_impsController extends Controller
{
   
    public function import(Request $request)
    {
        set_time_limit(3600); 
        ini_set('max_execution_time', 4800); 
        ini_set('memory_limit', '4096M'); 

        $request->validate([
            'excel_file' => 'required|file|mimes:xls,xlsx|max:51200' 
        ]);

        try {
            DB::table('product_imps')->truncate();

            $path = $request->file('excel_file')->getRealPath();
            $data = (new FastExcel)->import($path);

            if ($data->count() > 0) {
                $excelHeadings = array_keys($data[0]); 
                $headingMap = [
                    'product_id' => 'product_id',
                    'product_name' => 'product_name',
                    'product_name_en' => 'product_name_en',
                    'sell_price' => 'sell_price',
                    'unit_id' => 'unit_id',
                    'unit2_id' => 'unit2_id',
                    'unit3_id' => 'unit3_id',
                    'unit2_factor' => 'unit2_factor',
                    'unit3_factor' => 'unit3_factor',
                    'drug' => 'drug', 
                ];

                $data = $data->map(function ($row) use ($excelHeadings, $headingMap) {
                    $rowData = [];
                    foreach ($excelHeadings as $excelHeading) {
                        if (isset($headingMap[$excelHeading])) {
                            $dbColumnName = $headingMap[$excelHeading];
                            if (in_array($dbColumnName, (new Product_imp)->getFillable())) {
                                $rowData[$dbColumnName] = $row[$excelHeading];
                            }
                        }
                    }
                    return $rowData;
                });

                $tableName = '`product_imps`'; 
                $columns = '`' . implode('`, `', array_keys($headingMap)) . '`'; // Use keys from $headingMap
                $placeholders = implode(', ', array_fill(0, count($headingMap), '?'));
                $sql = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";

                $batchSize = 200;

                DB::beginTransaction();
                try {
                    foreach ($data->chunk($batchSize) as $chunk) {
                        $batchData = $chunk->map(function ($row) {
                            return array_values($row); 
                        })->toArray();

                        // **Corrected part:**
                        foreach ($batchData as $bat) {
                            try {
                                // Use $headingMap to ensure correct order
                                $productData = [];
                                foreach ($headingMap as $excelHeading => $dbColumnName) {
                                    $productData[$dbColumnName] = $bat[array_search($excelHeading, $excelHeadings)];
                                }
                                // dd($productData);
                                $product = Product_imp::create($productData); 

                            } catch (\Exception $e) {
                                Log::error('Error creating product:', [
                                    'data' => $bat,
                                    'exception' => $e->getMessage()
                                ]);
                            }
                        }

                        // dd($sql, $batchData); 
                        // DB::statement($sql, $batchData); 
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect()->back()->withErrors(['error' => 'An error occurred during import: ' . $e->getMessage()]);
                }
            }

            return redirect('/admin')->with('success', 'Excel data imported successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred during import: ' . $e->getMessage()]);
        }
    }

    public function create()
    {
        
        return view('admin.product_imp.create');
    }
        public function createimport()
    {
        
        return view('admin.product_imp.import');
    }
    // public function create()
    // {
    //     $data = Product::first('updated_at');
    //     return view('admin.product_imp.create', compact('data'));
    // }


    // public function update()
    // {
    //     $prodnew = Product_imp::get();

    //     foreach ($prodnew as $prod) {
    //         $prodold = Product::where('product_code', $prod->product_id)->first();

    //         if ($prodold) {
    //             $prodold->update([
    //                 'product_name' => $prod->product_name,
    //                 'product_name_en' => $prod->product_name_en,
    //                 'sell_price' => $prod->sell_price,
    //                 'g_drug' => $prod->drug,

    //                 'unit_id' => $prod->unit_id,
    //                 'unit2_id' => $prod->unit2_id,
    //                 'unit3_id' => $prod->unit3_id,
    //                 'unit2_factor' => $prod->unit2_factor,
    //                 'unit3_factor' => $prod->unit3_factor,

    //             ]);
    //         } else {
    //             // Use Product::create instead of $prodold->create()
    //             Product::create([ 
    //                 'product_code' => $prod->product_id,
    //                 'product_name' => $prod->product_name,
    //                 'product_name_en' => $prod->product_name_en,
    //                 'sell_price' => $prod->sell_price,
    //                 'g_drug' => $prod->drug,
    //                 // 'prod_id' => $prod->product_id,
    //                 'unit_id' => $prod->unit_id,
    //                 'unit2_id' => $prod->unit2_id,
    //                 'unit3_id' => $prod->unit3_id,
    //                 'unit2_factor' => $prod->unit2_factor,
    //                 'unit3_factor' => $prod->unit3_factor,
    //                 'view_front' => 0,
    //             ]);
    //         }
    //     }
    //     $sites = Site::where('active', 1)->get();
    //     return view('admin.pur_drug_request.create', compact('sites'));
    // }   


    // public function update()
    // {
    //     // Process products in chunks of 100 (adjust based on your server capacity)
    //     Product_imp::chunk(200, function ($prodnew) {
    //         foreach ($prodnew as $prod) {
    //             $prodold = Product::where('product_code', $prod->product_id)->first();

    //             if ($prodold) {
    //                 $prodold->update([
    //                     'product_name' => $prod->product_name,
    //                     'product_name_en' => $prod->product_name_en,
    //                     'sell_price' => $prod->sell_price,
    //                     'g_drug' => $prod->drug,
    //                     'unit_id' => $prod->unit_id,
    //                     'unit2_id' => $prod->unit2_id,
    //                     'unit3_id' => $prod->unit3_id,
    //                     'unit2_factor' => $prod->unit2_factor,
    //                     'unit3_factor' => $prod->unit3_factor,
    //                 ]);
    //             } else {
    //                 Product::create([
    //                     'product_code' => $prod->product_id,
    //                     'product_name' => $prod->product_name,
    //                     'product_name_en' => $prod->product_name_en,
    //                     'sell_price' => $prod->sell_price,
    //                     'g_drug' => $prod->drug,
    //                     'unit_id' => $prod->unit_id,
    //                     'unit2_id' => $prod->unit2_id,
    //                     'unit3_id' => $prod->unit3_id,
    //                     'unit2_factor' => $prod->unit2_factor,
    //                     'unit3_factor' => $prod->unit3_factor,
    //                     'view_front' => 0,
    //                 ]);
    //             }
    //         }
    //     });

    //     $sites = Site::where('active', 1)->get();
    //     return view('admin.pur_drug_request.create', compact('sites'));
    // }
    // public function update()
    // {
    //     // Process products in chunks with explicit order for MySQL consistency
    //     $newimp = Product_imp::where('status_update' , 0)->orderBy('id')->chunk(200, function ($prodnew) {
    //         foreach ($prodnew as $prod) {
    //             // Use firstOrNew to reduce queries
    //             $prodold = Product::firstOrNew(['product_code' => $prod->product_id]);

    //             // Prepare the data array
    //             $productData = [
    //                 'product_name' => $prod->product_name ?? '',
    //                 'product_name_en' => $prod->product_name_en ?? '',
    //                 'sell_price' => $prod->sell_price ?? 0,
    //                 'g_drug' => $prod->drug ?? 0,
    //                 'unit_id' => $prod->unit_id ?? null,
    //                 'unit2_id' => $prod->unit2_id ?? null,
    //                 'unit3_id' => $prod->unit3_id ?? null,
    //                 'unit2_factor' => $prod->unit2_factor ?? 1, // Default to 1 for factors
    //                 'unit3_factor' => $prod->unit3_factor ?? 1,
    //                 'status_update' => 1 ,
    //             ];
                
    //             if ($prodold->exists) {
    //                 $prodold->update($productData);
    //             } else {
    //                 // Add additional fields only for new records
    //                 $productData['product_code'] = $prod->product_id;
    //                 $productData['view_front'] = 0;
    //                 $productData['status_update'] = 1;
    //                 Product::create($productData);
    //             }
    //         }
    //     });

    //     $sites = Site::where('active', 1)->get();
    //     return view('admin.pur_drug_request.create', compact('sites'));
    // }
    public function update()
    {
        $totalProducts = Product_imp::count();
        $chunkSize = 200; // Adjust based on your server capacity
        $batches = ceil($totalProducts / $chunkSize);
        
        $batch = \Bus::batch([])->dispatch();
        
        for ($i = 0; $i < $batches; $i++) {
            $batch->add(new ProcessProductImports($chunkSize, $i * $chunkSize));
        }
        
        return redirect()->back()
            ->with('success', "Started processing {$totalProducts} products in {$batches} batches"); 
    }
    // public function update()
    // {
        
    //     InitiateProductImportBatchingJob::dispatch();
    
    //     $sites = Site::where('active', 1)->get();
    //     return view('admin.pur_drug_request.create', compact('sites'))
    //     ->with('success', 'Product import process has been initiated and will run in the background.');
    // }
    // public function update()
    // {
    //     $chunkSize = 100;
    //     $productIds = Product_imp::orderBy('id')->pluck('id');
        
    //     foreach ($productIds->chunk($chunkSize) as $chunk) {
    //         ProcessProductImportChunk::dispatch($chunk->toArray());
    //     }
        
    //     $sites = Site::where('active', 1)->get();
    //     return view('admin.pur_drug_request.create', compact('sites'))
    //         ->with('success', 'Product import jobs have been dispatched');
    // }
    public function importsupplier(Request $request)
    {
        set_time_limit(3600); 
        ini_set('max_execution_time', 4800); 
        ini_set('memory_limit', '4096M'); 

        $request->validate([
            'excel_file' => 'required|file|mimes:xls,xlsx|max:51200' 
        ]);

        try {
            DB::table('suppliers')->truncate();

            $path = $request->file('excel_file')->getRealPath();
            $data = (new FastExcel)->import($path);

            if ($data->count() > 0) {
                $excelHeadings = array_keys($data[0]); 
                $headingMap = [
                    'name_en' => 'name_en',

                ];

                $data = $data->map(function ($row) use ($excelHeadings, $headingMap) {
                    $rowData = [];
                    foreach ($excelHeadings as $excelHeading) {
                        if (isset($headingMap[$excelHeading])) {
                            $dbColumnName = $headingMap[$excelHeading];
                            if (in_array($dbColumnName, (new Supplier)->getFillable())) {
                                $rowData[$dbColumnName] = $row[$excelHeading];
                            }
                        }
                    }
                    return $rowData;
                });

                $tableName = '`suppliers`'; 
                $columns = '`' . implode('`, `', array_keys($headingMap)) . '`'; // Use keys from $headingMap
                $placeholders = implode(', ', array_fill(0, count($headingMap), '?'));
                $sql = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";

                $batchSize = 200;

                DB::beginTransaction();
                try {
                    foreach ($data->chunk($batchSize) as $chunk) {
                        $batchData = $chunk->map(function ($row) {
                            return array_values($row); 
                        })->toArray();

                        // **Corrected part:**
                        foreach ($batchData as $bat) {
                            try {
                                // Use $headingMap to ensure correct order
                                $productData = [];
                                foreach ($headingMap as $excelHeading => $dbColumnName) {
                                    $productData[$dbColumnName] = $bat[array_search($excelHeading, $excelHeadings)];
                                }
                                // dd($productData);
                                $product = Supplier::create($productData); 

                            } catch (\Exception $e) {
                                Log::error('Error creating product:', [
                                    'data' => $bat,
                                    'exception' => $e->getMessage()
                                ]);
                            }
                        }

                        // dd($sql, $batchData); 
                        // DB::statement($sql, $batchData); 
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect()->back()->withErrors(['error' => 'An error occurred during import: ' . $e->getMessage()]);
                }
            }

            return redirect('/admin')->with('success', 'Excel data imported successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred during import: ' . $e->getMessage()]);
        }
    }
    public function startSync()
    {
        Artisan::call('optimize:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        
        // Restart queue
        Artisan::call('queue:restart');
        // Dispatch the job to the queue
        // You can specify a particular queue if you have one for long-running tasks
        $new_impo = dispatch(new SyncProductsFromPurImportJob())->onQueue('product-syncs');
        // dd($new_impo);

        return Redirect::back()->with('success', 'Product synchronization from Pur_import has been initiated. It will run in the background.');
    }

    // public function newdb()
    // {
    //     try {
    //         $this->clearSystemCaches();
            
    //         $totalProducts = Pro_product::count();
    //         if ($totalProducts === 0) {
    //             return redirect()->back()->with('warning', 'No products found');
    //         }

    //         $chunkSize = $this->calculateOptimalChunkSize($totalProducts);
    //         $processed = 0;
    //         $errors = [];
    //         $batchStart = microtime(true);

    //         // Use cursor() for memory-efficient iteration
    //         Pro_product::orderBy('product_id')->chunk($chunkSize, 
    //             function ($products) use (&$processed, &$errors, $chunkSize, $batchStart) {
    //                 $result = $this->processOptimizedChunk($products);
    //                 $processed += $result['processed'];
    //                 $errors = array_merge($errors, $result['errors']);
                    
    //                 // Progress logging
    //                 $this->logProgress($processed, $totalProducts, $chunkSize, $batchStart);
    //             });

    //         return $this->finalizeImport($processed, $totalProducts, $errors);

    //     } catch (\Exception $e) {
    //         Log::error("Import failed", ['error' => $e->getMessage()]);
    //         return redirect()->back()->with('error', "Import failed: " . $e->getMessage());
    //     }
    // }
    // protected function processOptimizedChunk($products)
    // {
    //     $processed = 0;
    //     $errors = [];
    //     $batchData = [];
        
    //     // Prepare batch data
    //     foreach ($products as $prod) {
    //         try {
    //             $batchData[] = [
    //                 'product_code' => $prod->product_id,
    //                 'name_ar' => $prod->product_name ?? '',
    //                 'name_en' => $prod->product_name_en ?? '',
    //                 'sell_price_pub' => $prod->sell_price ?? 0,
    //                 'last_imported_at' => now(),
    //             ];
    //             $processed++;
    //         } catch (\Exception $e) {
    //             $errors[] = ['product_id' => $prod->product_id, 'error' => $e->getMessage()];
    //         }
    //     }
        
    //     // Bulk insert/update
    //     if (!empty($batchData)) {
    //         try {
    //             DB::transaction(function () use ($batchData) {
    //                 Product::upsert(
    //                     $batchData,
    //                     ['product_code'], // Unique key
    //                     ['name_ar', 'name_en', 'sell_price_pub', 'last_imported_at'] // Update columns
    //                 );
    //             });
    //         } catch (\Exception $e) {
    //             Log::error("Batch upsert failed", ['error' => $e->getMessage()]);
    //             throw $e;
    //         }
    //     }
        
    //     return compact('processed', 'errors');
    // }
    // protected function calculateOptimalChunkSize($totalRecords)
    // {
    //     // Dynamic calculation based on actual memory usage
    //     static $optimalChunk = null;
        
    //     if ($optimalChunk === null) {
    //         $memoryLimit = $this->convertToBytes(ini_get('memory_limit'));
    //         $usedMemory = memory_get_usage(true);
    //         $availableMemory = $memoryLimit - $usedMemory;
            
    //         // Conservative estimate: 2KB per record including overhead
    //         $perRecordMemory = 2048; 
    //         $optimalChunk = min(
    //             max(floor($availableMemory / $perRecordMemory), 100), // Min 100
    //             1000 // Max 1000 records per chunk
    //         );
    //     }
        
    //     return $optimalChunk;
    // }

    // protected function logProgress($processed, $total, $chunkSize, $startTime)
    // {
    //     if ($processed % ($chunkSize * 10) === 0 || $processed === $total) {
    //         $percentage = round(($processed / $total) * 100, 2);
    //         $elapsed = microtime(true) - $startTime;
    //         $recordsPerSec = round($processed / max($elapsed, 1));
    //         $memory = memory_get_usage(true) / 1024 / 1024;
            
    //         Log::info("Import progress", [
    //             'processed' => "$processed/$total ($percentage%)",
    //             'speed' => "$recordsPerSec records/sec",
    //             'memory' => round($memory, 2) . "MB",
    //             'chunk_size' => $chunkSize
    //         ]);
    //     }
    // }
    // protected function clearSystemCaches()
    // {
    //     // Parallel cache clearing
    //     $commands = ['cache:clear', 'view:clear', 'config:clear'];
    //     foreach ($commands as $cmd) {
    //         shell_exec("php artisan $cmd > /dev/null 2>&1 &");
    //     }
        
    //     // Optimize DB before import
    //     if (DB::connection() instanceof \Illuminate\Database\MySqlConnection) {
    //         DB::statement('SET FOREIGN_KEY_CHECKS=0');
    //         DB::statement('SET UNIQUE_CHECKS=0');
    //         DB::statement('SET AUTOCOMMIT=0');
    //     }
    // }

    // // Add this at the end of your import
    // protected function finalizeImport($processed, $total, $errors)
    // {
    //     // Re-enable DB optimizations
    //     if (DB::connection() instanceof \Illuminate\Database\MySqlConnection) {
    //         DB::statement('SET FOREIGN_KEY_CHECKS=1');
    //         DB::statement('SET UNIQUE_CHECKS=1');
    //         DB::statement('SET AUTOCOMMIT=1');
    //     }
        
    //     // Additional cleanup
    //     DB::connection()->unprepared('FLUSH TABLES');
    //     DB::connection()->unprepared('RESET QUERY CACHE');
        
    //     $message = "Imported $processed/$total products";
    //     if (!empty($errors)) {
    //         $message .= ". Failed: " . count($errors);
    //     }
        
    //     return redirect()->back()->with(
    //         empty($errors) ? 'success' : 'warning',
    //         $message
    //     );
    // }


    public function newdb()
    {
        try {
            // Clear system caches
            $this->clearSystemCaches();
            
            $totalProducts = Pro_product::count();
            
            if ($totalProducts === 0) {
                return redirect()->back()->with('warning', 'No products found to import');
            }

            $chunkSize = $this->calculateOptimalChunkSize($totalProducts);
            $processed = 0;
            $errors = [];

            Log::info("Starting direct product import for {$totalProducts} products");

            Pro_product::orderBy('product_id')
                ->chunk($chunkSize, function ($products) use (&$processed, &$errors, $chunkSize) {
                    $result = $this->processChunk($products);
                    $processed += $result['processed'];
                    
                    if (!empty($result['errors'])) {
                        $errors = array_merge($errors, $result['errors']);
                    }
                    
                    // Free memory
                    unset($products);
                    gc_collect_cycles();
                    
                    Log::debug("Processed chunk", [
                        'processed' => $processed,
                        'chunk_size' => $chunkSize,
                        'memory_usage' => memory_get_usage(true) / 1024 / 1024 . 'MB'
                    ]);
                });

            $message = "Completed importing {$processed} of {$totalProducts} products";
            
            if (!empty($errors)) {
                Log::warning("Import completed with errors", [
                    'total_errors' => count($errors),
                    'sample_errors' => array_slice($errors, 0, 5)
                ]);
                $message .= ". " . count($errors) . " products failed to import";
            }

            return redirect()->back()->with(
                empty($errors) ? 'success' : 'warning',
                $message
            );

        } catch (\Exception $e) {
            Log::error("Import failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', "Import failed: " . $e->getMessage());
        }
    }

    protected function clearSystemCaches()
    {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
    }

    protected function processChunk($products)
    {
        $processed = 0;
        $errors = [];
        
        DB::beginTransaction();
        
        try {
            foreach ($products as $prod) {
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
                    $processed++;
                } catch (\Exception $e) {
                    $errors[] = [
                        'product_id' => $prod->product_id,
                        'error' => $e->getMessage()
                    ];
                    Log::error("Failed to process product", [
                        'product_id' => $prod->product_id,
                        'error' => $e->getMessage()
                    ]);
                }
            }
            
            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Chunk processing failed", [
                'error' => $e->getMessage(),
                'chunk_size' => count($products)
            ]);
            throw $e;
        }
        
        return [
            'processed' => $processed,
            'errors' => $errors
        ];
    }

    protected function calculateOptimalChunkSize($totalRecords)
    {
        $memoryLimit = ini_get('memory_limit');
        $memoryInBytes = $this->convertToBytes($memoryLimit);
        $safeMemory = $memoryInBytes * 0.5; // Use 20% of available memory
        
        // Estimate memory usage per record (adjust based on your actual data size)
        $perRecordMemory = 4096; // 4KB per record (conservative estimate)
        $calculatedChunk = floor($safeMemory / $perRecordMemory);
        
        // Keep between 50-300 records per chunk (adjust based on your DB performance)
        return min(max($calculatedChunk, 50), 300);
    }

    protected function convertToBytes($memoryLimit)
    {
        if (preg_match('/^(\d+)(.)$/', $memoryLimit, $matches)) {
            switch (strtoupper($matches[2])) {
                case 'G': return $matches[1] * 1024 * 1024 * 1024;
                case 'M': return $matches[1] * 1024 * 1024;
                case 'K': return $matches[1] * 1024;
            }
        }
        return 128 * 1024 * 1024; // Default 128MB if can't parse
    }
    
}
