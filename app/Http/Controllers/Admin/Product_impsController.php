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
    public function newdb()
{
    try {
        // Clear system caches
        Artisan::call('optimize:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('queue:restart');

        $totalProducts = Pro_product::count();
        $chunkSize = $this->calculateOptimalChunkSize($totalProducts);
        $batches = ceil($totalProducts / $chunkSize);
        // Debug: Log before job creation
        Log::info("Preparing to dispatch {$batches} jobs");

        $jobs = [];
        for ($i = 0; $i < $batches; $i++) {
            $job = new ProcessProductImports($chunkSize, $i * $chunkSize);
            $job->delay(now()->addSeconds($i * 2));
            $jobs[] = $job;
            
            // Debug: Log each job
            Log::debug("Created job", [
                'offset' => $i * $chunkSize,
                'chunk' => $chunkSize
            ]);
        }

        $batch = Bus::batch($jobs)
            ->name('product-import-'.now()->format('Ymd-His'))
            ->allowFailures(5)
            ->dispatch();

        // Debug: Verify batch creation
        Log::info("Batch created", [
            'id' => $batch->id,
            'total_jobs' => count($jobs)
        ]);

        // Verify jobs were queued
        $queuedJobs = DB::table('jobs')->count();
        Log::info("Total jobs in queue: {$queuedJobs}");

        return redirect()->back()->with([
            'success' => "Processing started",
            'batch_id' => $batch->id,
            'queued_jobs' => $queuedJobs // Add this to response
        ]);

        } catch (\Exception $e) {
        Log::error("Initiation failed", ['error' => $e->getMessage()]);
        return redirect()->back()->with('error', $e->getMessage());
        }
}

    protected function calculateOptimalChunkSize($totalRecords)
    {
        // More sophisticated calculation considering memory limits
        $memoryLimit = ini_get('memory_limit');
        $memoryInBytes = $this->convertToBytes($memoryLimit);
        $safeMemory = $memoryInBytes * 0.3; // Use 30% of available memory
        
        // Estimate 2KB per record (adjust based on your actual data size)
        $perRecordMemory = 2048; 
        $calculatedChunk = floor($safeMemory / $perRecordMemory);
        
        // Keep between 50-200 records per chunk
        return min(max($calculatedChunk, 50), 200);
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

    // protected function calculateOptimalChunkSize($totalRecords)
    // {
    //     $memoryLimit = ini_get('memory_limit');
    //     $available = $this->convertToBytes($memoryLimit) * 0.3; // Use 30% of memory limit
        
    //     // Estimate 2KB per record (adjust based on your data)
    //     $perRecord = 2048;
    //     $calculated = floor($available / $perRecord);
        
    //     return min(max($calculated, 50), 200); // Keep between 50-200
    // }

    // protected function convertToBytes($memoryLimit)
    // {
    //     if (preg_match('/^(\d+)(.)$/', $memoryLimit, $matches)) {
    //         switch (strtoupper($matches[2])) {
    //             case 'G': return $matches[1] * 1024 * 1024 * 1024;
    //             case 'M': return $matches[1] * 1024 * 1024;
    //             case 'K': return $matches[1] * 1024;
    //         }
    //     }
    //     return 128 * 1024 * 1024; // Default 128MB
    // }
    // public function newdb()
    // {

    //     $datapro = Pro_product::get();

    //     $totalProducts = Pro_product::count();
    //     $chunkSize = 200; // Adjust based on your server capacity
    //     $batches = ceil($totalProducts / $chunkSize);
        
    //     $batch = \Bus::batch([])->dispatch();
        
    //     for ($i = 0; $i < $batches; $i++) {
    //         $batch->add(new ProcessProductImports($chunkSize, $i * $chunkSize));
    //         // In your job dispatch
    //         ProcessProductImports::dispatch($chunkSize, $offset)->delay(now()->addSeconds(10));
    //     }
        
    //     return redirect()->back()
    //         ->with('success', "Started processing {$totalProducts} products in {$batches} batches"); 
        
    // }
    // public function newdb()
    // {
    //     // $datapro = Emangeremp::get();
    //     // $datapro = Emangeremp::all();
    //     $datapro = Emangeremp::where('emp_id', 1005)->get();
    //     // $datapro = DB::connection('sqlsrv')->table('emp')->where('emp_id', 1004)->get();
    //     return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $datapro]);
    //     dd($datapro);
    //     return view('admin.product_imp.create');
    // }
    // public function getHomeNotification($employee_id)
    // {
    //     $token = request()->header('token');
    //     $user = $this->check_api_token($token);
    //     if (!$user) {
    //         return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
    //     }

    //     $data = Notification::where('employee_id', $employee_id)->orderBy('id', 'DESC')->take(5)->paginate(5);

    //     $results = NotificationResource::collection($data)->response()->getData();

    //     if(count($data) == 0) {
    //         return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
    //     } else {
    //         return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $results]);
    //     }
        
    // }
}
