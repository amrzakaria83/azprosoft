<?php

namespace App\Http\Controllers\Admin;
set_time_limit(3600);
ini_set('max_execution_time', 4800);
ini_set('memory_limit', '4096M');
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Pro_sales_det;
use App\Models\Pro_prod_amount;
use \Yajra\Datatables\Datatables;
use Rap2hpoutre\FastExcel\FastExcel;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Bus; // Add this import
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Validator;
use Auth;
class Pro_sales_detsController extends Controller
{
    public function index(Request $request)
    {
        set_time_limit(3600);
        ini_set('max_execution_time', 4800);
        ini_set('memory_limit', '4096M');
        // $data = Pro_sales_det::take(100)->get();
        if ($request->ajax()) {
            $data = Pro_sales_det::query();
            // $data = $data->orderBy('sales_d_id', 'DESC');
            return Datatables::of($data)

                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name_ar', function($row){
                    $name_ar = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->getprod->product_name_en.'</a></div>';
                    // $name_ar .= '<br><span>'.$row->product_name.'</span>';
                    return $name_ar;
                })
                ->addColumn('amount', function($row){
                    $amount = $row->amount;
                    return $amount;
                })
                ->addColumn('sales_d_id', function($row){
                    $sales_d_id = $row->sales_d_id;
                    return $sales_d_id;
                })
                ->addColumn('sales_id', function($row){
                    $sales_id = $row->sales_id;
                    return $sales_id;
                })
                ->addColumn('ins_date', function($row){
                    $ins_date = $row->ins_date;
                    return $ins_date;
                })
                ->addColumn('total_item', function($row){
                    $total_item = $row->total_item;
                    return $total_item;
                })
                ->addColumn('price', function($row){
                    $price = $row->price;
                    return $price;
                })
                // ->addColumn('actions', function($row){
                //     $actions = '<div class="ms-2">
                //                 <a href="'.route('admin.pro_sales_dets.show', $row->id).'" class="btn btn-sm btn-icon btn-warning btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                //                     <i class="bi bi-eye-fill fs-1x"></i>
                //                 </a>
                //                 <a href="'.route('admin.pro_sales_dets.edit', $row->id).'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                //                     <i class="bi bi-pencil-square fs-1x"></i>
                //                 </a>
                                
                //             </div>';
                //     return $actions;
                // })
                ->filter(function ($instance) use ($request) {
                    // if ($request->get('is_active') == 0 || $request->get('is_active') == 1) {
                    //     $instance->where('is_active', $request->get('is_active'));
                    // }
                    

                    if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('product_name_en', 'LIKE', "%$search%")
                            ->orWhere('sell_price', 'LIKE', "%$search%")
                            ->orWhere('product_name', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['name_ar','amount','sales_id','sales_d_id','ins_date','price','total_item','checkbox','actions'])
                ->make(true);
        }
        return view('admin.pro_sales_det.index');
    }

    public function create()
    {
        return view('admin.pro_sales_det.create');
    }

    public function store(Request $request)
    {
        $rule = [
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'emailaz' => 'nullable',
            'password' =>'required',
            
        ];
        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');}

        $row = Pro_sales_det::create([
            'emp_code' => $request->emp_code,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'phone' => $request->phone,
            'emailaz' => $request->emailaz,
            'password' => Hash::make($request->password),
            'type' => $request->type , //0 = admin, 1 = no dash 3 = subadmin, 4 = superadmin
            'is_active' => $request->is_active ?? 1,
            'role_id' => $request->role_id,
            
        ]);
        if($request->hasFile('attach') && $request->file('attach')->isValid()){
            $row->addMediaFromRequest('attach')->toMediaCollection('profile');
        }
        $role = Role::find($request->role_id);
        $row->syncRoles([]);
        $row->assignRole($role->name);

        return redirect('admin/pro_sales_dets')->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    public function show($id)
    {
        $data = Pro_sales_det::find($id);
        return view('admin.pro_sales_det.show', compact('data'));
    }
    public function edit($id)
    {
        $data = Pro_sales_det::find($id);
        return view('admin.pro_sales_det.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $rule = [
            'name_ar' => 'required|string',
            
        ];
        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
        $data = Pro_sales_det::find($request->id);
        $data->update([
            'emp_code' => $request->emp_code,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'phone' => $request->phone,
            'emailaz' => $request->emailaz,
            'password' => Hash::make($request->password),
            'type' => $request->type , //0 = admin, 1 = no dash 3 = subadmin, 4 = superadmin
            'is_active' => $request->is_active ?? 1,
            'role_id' => $request->role_id,

        ]);

        if($request->hasFile('photo') && $request->file('photo')->isValid()){
            $data->addMediaFromRequest('photo')->toMediaCollection('profile');
        }

        return redirect('admin/pro_sales_dets')->with('message', 'تم التعديل بنجاح')->with('status', 'success');
    }

    public function destroy(Request $request)
    {
        try{
            Pro_sales_det::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'error']);
        }
        return response()->json(['message' => 'success']);
    }
    public function reportprodsaledet()
    {
        return view('admin.pro_sales_det.reportprodsaledet');
    }
    public function indexprodsaledet($from_time, $to_date)
{
    // Set execution limits
    set_time_limit(0);
    ini_set('memory_limit', '-1');
    
    // Define file path
    $directory = storage_path('debugbar/');
    $filename = 'temp.json';
    $filepath = $directory . $filename;
    
    // Ensure directory exists
    if (!file_exists($directory)) {
        mkdir($directory, 0755, true);
    }

    // Initialize data aggregators
    $productReport = [];
    $batchSize = 2000;
    $totalProcessed = 0;

    // 1. First process sales data
    $salesMinMax = Pro_sales_det::whereBetween('ins_date', [$from_time, $to_date])
        ->selectRaw('MIN(sales_d_id) as min_id, MAX(sales_d_id) as max_id')
        ->first();

    if ($salesMinMax) {
        for ($id = $salesMinMax->min_id; $id <= $salesMinMax->max_id; $id += $batchSize) {
            $batchEnd = $id + $batchSize - 1;
            
            $salesBatch = Pro_sales_det::whereBetween('ins_date', [$from_time, $to_date])
                ->whereBetween('sales_d_id', [$id, $batchEnd])
                ->with(['getsale_site:store_id,sales_id', 'getprod:product_id,product_name_en'])
                ->select(['sales_d_id', 'amount', 'product_id', 'sales_id'])
                ->cursor();
                
            foreach ($salesBatch as $sale) {
                $productName = $sale->getprod->product_name_en ?? 'Unknown';
                $siteId = $sale->getsale_site->store_id ?? 'Unknown';
                $amount = (float)$sale->amount;
                
                // Initialize product entry if not exists
                if (!isset($productReport[$productName])) {
                    $productReport[$productName] = [
                        'total_sales_amount' => 0,
                        'total_prod_amount' => 0,
                        'sites' => []
                    ];
                }
                
                // Update sales totals
                $productReport[$productName]['total_sales_amount'] += $amount;
                
                // Initialize site entry if not exists
                if (!isset($productReport[$productName]['sites'][$siteId])) {
                    $productReport[$productName]['sites'][$siteId] = [
                        'sales_amount' => 0,
                        'prod_amount' => 0
                    ];
                }
                $productReport[$productName]['sites'][$siteId]['sales_amount'] += $amount;
                
                $totalProcessed++;
            }
            
            unset($salesBatch);
            gc_collect_cycles();
        }
    }

    // 2. Then process product amounts data
    $amountsMinMax = Pro_prod_amount::whereBetween('ins_date', [$from_time, $to_date])
        ->selectRaw('MIN(id) as min_id, MAX(id) as max_id')
        ->first();

    if ($amountsMinMax) {
        for ($id = $amountsMinMax->min_id; $id <= $amountsMinMax->max_id; $id += $batchSize) {
            $batchEnd = $id + $batchSize - 1;
            
            $amountsBatch = Pro_prod_amount::whereBetween('ins_date', [$from_time, $to_date])
                ->whereBetween('id', [$id, $batchEnd])
                ->with(['getprod:product_id,product_name_en,sell_price', 'getsite:store_id,store_name'])
                ->select(['id', 'prod_amount', 'product_id', 'store_id'])
                ->cursor();
                
            foreach ($amountsBatch as $amount) {
                $productName = $amount->getprod->product_name_en ?? 'Unknown';
                $productsell_price = $amount->getprod->sell_price ?? 'Unknown';
                $siteId = $amount->getsite->store_id ?? 'Unknown';
                $prodAmount = (float)$amount->prod_amount;
                
                // Initialize product entry if not exists
                if (!isset($productReport[$productName])) {
                    $productReport[$productName] = [
                        'total_sales_amount' => 0,
                        'total_prod_amount' => 0,
                        'sites' => []
                    ];
                }
                
                // Update product amount totals
                $productReport[$productName]['total_prod_amount'] += $prodAmount;
                
                // Initialize site entry if not exists
                if (!isset($productReport[$productName]['sites'][$siteId])) {
                    $productReport[$productName]['sites'][$siteId] = [
                        'sales_amount' => 0,
                        'prod_amount' => 0
                    ];
                }
                $productReport[$productName]['sites'][$siteId]['prod_amount'] += $prodAmount;
            }
            
            unset($amountsBatch);
            gc_collect_cycles();
        }
    }

    // Format the final output
    $formattedReport = [];
    foreach ($productReport as $productName => $data) {
        // Format site data for this product
        $siteData = [];
        foreach ($data['sites'] as $siteId => $amounts) {
            $siteData[] = [
                'site_id' => $siteId,
                'sales_amount' => $amounts['sales_amount'],
                'prod_amount' => $amounts['prod_amount']
            ];
        }
        
        $formattedReport[] = [
            'product_name' => $productName,
            'sell_price' => $productsell_price,
            'total_sales_amount' => $data['total_sales_amount'],
            'total_prod_amount' => $data['total_prod_amount'],
            'sites' => $siteData
        ];
    }

    // Save to file
    file_put_contents($filepath, json_encode([
        'products' => $formattedReport,
        'summary' => [
            'start_from' => $from_time,
            'end_to' => $to_date,
            'total_products' => count($formattedReport),
            'total_records' => $totalProcessed,
            'generated_at' => now()->toDateTimeString()
        ]
    ], JSON_PRETTY_PRINT));
    return redirect('admin/pro_sales_dets/indexreportsale')->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    // return view('admin.pro_sales_det.indexreportsale');
    // return response()->json([
    //     'success' => true,
    //     'file_path' => $filepath,
    //     'stats' => [
    //         'unique_products' => count($formattedReport),
    //         'total_records' => $totalProcessed,
    //         'time_elapsed' => microtime(true) - LARAVEL_START . ' seconds'
    //     ]
    // ]);
}
//     public function indexprodsaledet($from_time, $to_date, $status_visit)
// {
//     // Set execution limits
//     set_time_limit(0);
//     ini_set('memory_limit', '-1');
    
//     // Define file path
//     $directory = storage_path('debugbar/');
//     $filename = 'temp.json';
//     $filepath = $directory . $filename;
    
//     // Ensure directory exists
//     if (!file_exists($directory)) {
//         mkdir($directory, 0755, true);
//     }

//     // Initialize data aggregators
//     $productReport = [];
//     $batchSize = 2000;
//     $totalProcessed = 0;

//     // Get min and max IDs first for efficient chunking
//     $minMax = Pro_sales_det::whereBetween('ins_date', [$from_time, $to_date])
//         ->selectRaw('MIN(sales_d_id) as min_id, MAX(sales_d_id) as max_id')
//         ->first();

//     if (!$minMax) {
//         return response()->json(['message' => 'No records found'], 404);
//     }

//     // Process in batches to avoid memory issues
//     for ($id = $minMax->min_id; $id <= $minMax->max_id; $id += $batchSize) {
//         $batchEnd = $id + $batchSize - 1;
        
//         $salesBatch = Pro_sales_det::whereBetween('ins_date', [$from_time, $to_date])
//             ->whereBetween('sales_d_id', [$id, $batchEnd])
//             ->with(['getsale_site:store_id,sales_id', 'getprod:product_id,product_name_en'])
//             ->select(['sales_d_id', 'amount', 'product_id', 'sales_id'])
//             ->cursor();
            
//         foreach ($salesBatch as $sale) {
//             $productName = $sale->getprod->product_name_en ?? 'Unknown';
//             $siteId = $sale->getsale_site->store_id ?? 'Unknown';
//             $amount = (float)$sale->amount;
            
//             // Initialize product entry if not exists
//             if (!isset($productReport[$productName])) {
//                 $productReport[$productName] = [
//                     'total_amount' => 0,
//                     'sites' => []
//                 ];
//             }
            
//             // Update product totals
//             $productReport[$productName]['total_amount'] += $amount;
            
//             // Update site totals for this product
//             if (!isset($productReport[$productName]['sites'][$siteId])) {
//                 $productReport[$productName]['sites'][$siteId] = 0;
//             }
//             $productReport[$productName]['sites'][$siteId] += $amount;
            
//             $totalProcessed++;
//         }
        
//         unset($salesBatch);
//         gc_collect_cycles();
//     }

//     // Format the final output
//     $formattedReport = [];
//     foreach ($productReport as $productName => $data) {
//         // Format site data for this product
//         $siteData = [];
//         foreach ($data['sites'] as $siteId => $amount) {
//             $siteData[] = [
//                 'site_id' => $siteId,
//                 'amount' => $amount
//             ];
//         }
        
//         $formattedReport[] = [
//             'product_name' => $productName,
//             'total_amount' => $data['total_amount'],
//             'sites' => $siteData
//         ];
//     }

//     // Save to file
//     file_put_contents($filepath, json_encode([
//         'products' => $formattedReport,
//         'summary' => [
//             'total_products' => count($formattedReport),
//             'total_records' => $totalProcessed,
//             'generated_at' => now()->toDateTimeString()
//         ]
//     ], JSON_PRETTY_PRINT));

//     return response()->json([
//         'success' => true,
//         'file_path' => $filepath,
//         'stats' => [
//             'unique_products' => count($formattedReport),
//             'total_records' => $totalProcessed
//         ]
//     ]);
// }
    // public function indexprodsaledet($from_time, $to_date, $status_visit)
    // {
    //     // Set execution limits
    //     set_time_limit(0);
    //     ini_set('memory_limit', '-1');
        
    //     // Define file path
    //     $directory = storage_path('debugbar/'); // Uses forward slash which works on both Windows and Linux
    //     $filename = 'temp.json';
    //     $filepath = $directory . $filename;
        
    //     // Ensure directory exists
    //     if (!file_exists($directory)) {
    //         mkdir($directory, 0755, true);
    //     }

    //     // Open file for writing
    //     $file = fopen($filepath, 'w');
    //     if (!$file) {
    //         return response()->json(['error' => 'Could not create file'], 500);
    //     }
        
    //     // Write initial JSON array bracket
    //     fwrite($file, "[\n");
        
    //     $batchSize = 2000;
    //     $firstRecord = true;
    //     $totalProcessed = 0;

    //     // Get min and max IDs first to chunk efficiently
    //     $minMax = Pro_sales_det::whereBetween('ins_date', [$from_time, $to_date])
    //         ->selectRaw('MIN(sales_d_id) as min_id, MAX(sales_d_id) as max_id')
    //         ->first();

    //     if (!$minMax) {
    //         fclose($file);
    //         unlink($filepath);
    //         return response()->json(['message' => 'No records found'], 404);
    //     }

    //     // Process in ranges
    //     for ($id = $minMax->min_id; $id <= $minMax->max_id; $id += $batchSize) {
    //         $batchEnd = $id + $batchSize - 1;
            
    //         $salesBatch = Pro_sales_det::whereBetween('ins_date', [$from_time, $to_date])
    //             ->whereBetween('sales_d_id', [$id, $batchEnd])
    //             ->with([
    //                 'getsale_site:store_id,sales_id',
    //                 'getprod:product_id,product_name_en'
    //             ])
    //             ->select(['sales_d_id', 'amount', 'product_id', 'sales_id'])
    //             ->cursor();
                
    //         foreach ($salesBatch as $sale) {
    //             $record = [
    //                 'amount' => $sale->amount,
    //                 'product_name' => $sale->getprod->product_name_en ?? null,
    //                 'site_id' => $sale->getsale_site->store_id ?? null,
    //             ];
                
    //             // Add comma for previous record if not first
    //             if (!$firstRecord) {
    //                 fwrite($file, ",\n");
    //             } else {
    //                 $firstRecord = false;
    //             }
                
    //             fwrite($file, json_encode($record, JSON_UNESCAPED_UNICODE));
    //             $totalProcessed++;
                
    //             // Log progress every 1000 records
    //             if ($totalProcessed % 1000 === 0) {
    //                 Log::info("Processed {$totalProcessed} records");
    //             }
    //         }
            
    //         unset($salesBatch);
    //         gc_collect_cycles();
    //     }
        
    //     // Close JSON array
    //     fwrite($file, "\n]");
    //     fclose($file);
        
    //     // Return success response with file info
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Export completed successfully',
    //         'total_records' => $totalProcessed,
    //         'file_path' => $filepath,
    //         'file_size' => filesize($filepath) . ' bytes',
    //         'created_at' => date('Y-m-d H:i:s')
    //     ]);
    // }
    // public function indexprodsaledet($from_time, $to_date, $status_visit)
    // {
    //     // Set execution limits
    //     set_time_limit(0);
    //     ini_set('memory_limit', '-1');
        
    //     $filename = 'sales_export_'.date('Ymd_His').'.json';
    //     $filepath = storage_path('app/'.$filename);
    //     $file = fopen($filepath, 'w');
        
    //     // Write initial array bracket
    //     fwrite($file, "[\n");
        
    //     $batchSize = 2000;
    //     $firstRecord = true;
    //     $totalProcessed = 0;

    //     // Get min and max IDs first to chunk efficiently
    //     $minMax = Pro_sales_det::whereBetween('ins_date', [$from_time, $to_date])
    //         ->selectRaw('MIN(sales_d_id) as min_id, MAX(sales_d_id) as max_id')
    //         ->first();

    //     if (!$minMax) {
    //         fclose($file);
    //         unlink($filepath);
    //         return response()->json(['message' => 'No records found'], 404);
    //     }

    //     // Process in ranges
    //     for ($id = $minMax->min_id; $id <= $minMax->max_id; $id += $batchSize) {
    //         $batchEnd = $id + $batchSize - 1;
            
    //         $salesBatch = Pro_sales_det::whereBetween('ins_date', [$from_time, $to_date])
    //             ->whereBetween('sales_d_id', [$id, $batchEnd])
    //             ->with([
    //                 'getsale_site:store_id,sales_id',
    //                 'getprod:product_id,product_name_en'
    //             ])
    //             ->select(['sales_d_id', 'amount', 'product_id', 'sales_id'])
    //             ->cursor();
                
    //         foreach ($salesBatch as $sale) {
    //             $record = [
    //                 'amount' => $sale->amount,
    //                 'product_name' => $sale->getprod->product_name_en ?? null,
    //                 'site_id' => $sale->getsale_site->store_id ?? null,
    //             ];
                
    //             // Add comma for previous record if not first
    //             if (!$firstRecord) {
    //                 fwrite($file, ",\n");
    //             } else {
    //                 $firstRecord = false;
    //             }
                
    //             fwrite($file, json_encode($record, JSON_UNESCAPED_UNICODE));
    //             $totalProcessed++;
                
    //             // Log progress every 1000 records
    //             if ($totalProcessed % 1000 === 0) {
    //                 Log::info("Processed {$totalProcessed} records");
    //             }
    //         }
            
    //         unset($salesBatch);
    //         gc_collect_cycles();
    //     }
        
    //     // Close JSON array
    //     fwrite($file, "\n]");
    //     fclose($file);
        
    //     // Return download response
    //     return response()->download($filepath)->deleteFileAfterSend(true);
    // }
    // public function indexprodsaledet($from_time, $to_date, $status_visit)
    // {
    //     // Set higher limits for large processing
    //     set_time_limit(0); // Unlimited time
    //     ini_set('memory_limit', '-1'); // Unlimited memory (temporarily)
    //     ini_set('mysql.connect_timeout', 300);
    //     ini_set('default_socket_timeout', 300);

    //     $results = [];
    //     $processed = 0;
    //     $batchSize = 2000; // Adjust based on your server capacity

    //      // Get min and max IDs first to chunk efficiently
    //     $minMax = Pro_sales_det::whereBetween('ins_date', [$from_time, $to_date])
    //     ->selectRaw('MIN(sales_d_id) as min_id, MAX(sales_d_id) as max_id')
    //     ->first();

    //     if (!$minMax) {
    //         return response()->json(['message' => 'No records found'], 404);
    //     }

    //     // Process in ranges instead of whereIn to avoid parameter limit
    //     for ($id = $minMax->min_id; $id <= $minMax->max_id; $id += $batchSize) {
    //         $batchEnd = $id + $batchSize - 1;
            
    //         $salesBatch = Pro_sales_det::whereBetween('ins_date', [$from_time, $to_date])
    //             ->whereBetween('sales_d_id', [$id, $batchEnd])
    //             ->with([
    //                 'getsale_site' => function($q) {
    //                     $q->select('store_id', 'sales_id'); // Adjusted for your schema
    //                 },
    //                 'getprod' => function($q) {
    //                     $q->select('product_id', 'product_name_en');
    //                 }
    //             ])
    //             ->select(['sales_d_id', 'amount', 'product_id', 'sales_id'])
    //             ->cursor()
    //             ->each(function ($sale) use (&$results) {
    //                 $results[] = [
    //                     'amount' => $sale->amount,
    //                     'product_name' => $sale->getprod->product_name_en ?? null,
    //                     'site_id' => $sale->getsale_site->store_id ?? null,
    //                     // Add other fields as needed
    //                 ];
    //             });
    //             dd($results);
    //         // Free memory
    //         unset($salesBatch);
    //         gc_collect_cycles();
            
    //         // Optional: Log progress
    //         Log::info("Processed IDs {$id} to {$batchEnd}");
    //     }

    //     return response()->json([
    //         'total_records' => count($results),
    //         'data' => $results
    //     ]);
    // }
    // public function indexprodsaledet($from_time,$to_date,$status_visit)
    // {
    //     set_time_limit(3600);
    //     ini_set('max_execution_time', 4800);
    //     ini_set('memory_limit', '4096M');

    //     $data = Pro_sales_det::whereBetween('ins_date', [$from_time, $to_date])
    //     ->with(['getsale_site', 'getprod'])
    //     ->cursor()
    //     ->map(function ($sale) {
    //         return [
    //             'amount' => $sale->amount,
    //             'product_name' => $sale->getprod->product_name_en ?? null,
    //             'site_id' => $sale->getsale_site->store_id ?? null,
    //             // ... other fields
    //         ];
    //     })
    //     ->all();
    //     dd($data);
    //     $results = collect();

    //     Pro_sales_det::whereBetween('ins_date', [$from_time, $to_date])
    //         // ->select(['id', 'sale_id', 'product_id', 'quantity', 'price', 'ins_date'])
    //         ->chunk(1000, function ($sales) use ($results) {
    //             $sales->load([
    //                 'getsale_site',
    //                 'getprod'
    //             ]);
                
    //             foreach ($sales as $sale) {
    //                 $results->push([
    //                     'id' => $sale->id,
    //                     'getprod' => $getprod->product_name_en,
    //                     'getsale_site' => $getsale_site->id,
    //                     // ... same mapping as before
    //                 ]);
    //             }
    //         });

    //     $data = $results;
        
    //     $data = Pro_sales_det::whereBetween('ins_date', [$from_time, $to_date])
    //     ->with('getsale_site','getprod')
    //     ->get();

    //         // $helper = new Helper;
    //         // $ids = $helper->emp_ids();
    //         // if (auth()->user()->role_id != 1) {
    //         //     $data = $data->whereIn('id', $ids);
    //         // }
    //         $totalemp = []; // Initialize the array

    //     foreach ($data as $dataemp) {
    //         $nameemp = $dataemp->name_en;
    //         $dataemp = Pro_sales_det::where('status', 0)
    //         ->where('empvisit_id', $dataemp->id)
    //         ->whereBetween('from_time', [$from_time, $to_date])
    //         ->get();
    //         if ($dataemp->count() > 0) {
    //             $totalvisit = 0;
    //             $totalamvisit = 0;
    //             $totalpmvisit = 0;
    //             $totalsingle = 0;
    //             $totaldouble = 0;
    //             $totalvisit = $dataemp->count();
    //             $totalamvisit = $dataemp->where('typevist_id' , 1 )->count();// 1 = am visits - 2 = pm visits
    //             $totalpmvisit = $dataemp->where('typevist_id' , 2 )->count();// 1 = am visits - 2 = pm visits
    //             $totalsingle = $dataemp->where('status_visit' , 0 )->count();//  0 = single visit - 1 = double visit - 2 = triple visit
    //             $totaldouble = $dataemp->where('status_visit' , 1 )->count();//  0 = single visit - 1 = double visit - 2 = triple visit
    //             $totalcompleted = $dataemp->where('status_completed' , 0 )->count();// 0 = completed - 1 = not completed
    //             $totaluncompleted = $dataemp->where('status_completed' , 1 )->count();// 0 = completed - 1 = not completed
    //             $totalemp[] = [$totalvisit,$totalamvisit,$totalpmvisit,$totalsingle,$totaldouble,$nameemp,$totalcompleted,$totaluncompleted];

    //         }
            
    //     }
      
    //     $searched = [$from_time, $to_date];
    //     return view('admin.visit.reportprodsaledet',compact('totalemp','searched'));
    // }

//     public function indexprodsaledet($from_time, $to_date, $status_visit)
// {
//     // Stream results directly to a file
//     $filename = 'sales_export_'.date('Ymd_His').'.csv';
//     $file = fopen(storage_path('app/'.$filename), 'w');
    
//     // Write CSV headers
//     fputcsv($file, ['Amount', 'Product Name', 'Site ID']);
    
//     Pro_sales_det::whereBetween('ins_date', [$from_time, $to_date])
//         ->select(['id', 'amount', 'product_id', 'site_id'])
//         ->chunkById(5000, function ($sales) use ($file) {
//             $sales->load([
//                 'getsale_site:store_id,id',
//                 'getprod:product_name_en,id'
//             ]);
            
//             foreach ($sales as $sale) {
//                 fputcsv($file, [
//                     $sale->amount,
//                     $sale->getprod->product_name_en ?? '',
//                     $sale->getsale_site->store_id ?? ''
//                 ]);
//             }
            
//             unset($sales);
//             gc_collect_cycles();
//         });
    
//     fclose($file);
    
//     return response()->download(storage_path('app/'.$filename))->deleteFileAfterSend(true);
// }
    public function indexreportsale()
    {
        return view('admin.pro_sales_det.indexreportsale');
    }
    private function streamJsonProducts($filePath)
{
    $stream = fopen($filePath, 'r');
    $buffer = '';
    
    while (!feof($stream)) {
        $buffer .= fread($stream, 8192);
        
        while (($newlinePos = strpos($buffer, "\n")) !== false) {
            $line = substr($buffer, 0, $newlinePos);
            $buffer = substr($buffer, $newlinePos + 1);
            
            $decoded = json_decode(trim($line), true);
            if ($decoded && isset($decoded['products'])) {
                yield from $decoded['products'];
            }
        }
    }
    
    fclose($stream);
}
    public function getReportData(Request $request)
    {
        $filePath = storage_path('debugbar/temp.json');
        
        if (!file_exists($filePath)) {
            return response()->json([
                'draw' => $request->input('draw', 0),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'summary' => [
                    'start_from' => 0,
                    'end_to' => 0,
                    'total_products' => 0,
                    'total_records' => 0,
                    'generated_at' => now()->toDateTimeString()
                ]
            ]);
        }

        try {
            $fileContents = file_get_contents($filePath);
            $data = json_decode($fileContents, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("Invalid JSON format");
            }

            // Ensure summary data exists
            $summary = $data['summary'] ?? [
                'total_products' => count($data['products'] ?? []),
                'total_records' => count($data['products'] ?? []),
                'generated_at' => now()->toDateTimeString()
            ];

            $products = $data['products'] ?? [];
            $search = $request->input('search.value');
            
            // Filter data if search is present
            $filteredData = $products;
            if (!empty($search)) {
                $filteredData = array_filter($products, function($product) use ($search) {
                    $match = stripos($product['product_name'] ?? '', $search) !== false;
                    if (!$match && isset($product['sites'])) {
                        foreach ($product['sites'] as $site) {
                            if (stripos($site['site_id'] ?? '', $search) !== false) {
                                return true;
                            }
                        }
                    }
                    return $match;
                });
            }

            // Paginate the results
            $start = (int)$request->input('start', 0);
            $length = (int)$request->input('length', 25);
            $paginatedData = array_slice($filteredData, $start, $length);

            return response()->json([
                'draw' => $request->input('draw', 0),
                'recordsTotal' => count($products),
                'recordsFiltered' => count($filteredData),
                'data' => $paginatedData,
                'summary' => $summary
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'draw' => $request->input('draw', 0),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'summary' => [
                    'total_products' => 0,
                    'total_records' => 0,
                    'generated_at' => now()->toDateTimeString()
                ],
                'error' => $e->getMessage()
            ]);
        }
    }

// public function getReportData(Request $request)
// {
//     $filePath = storage_path('debugbar/temp.json');
    
//     if (!file_exists($filePath)) {
//         return response()->json(['error' => 'Report not found'], 404);
//     }

//     // DataTables parameters
//     $draw = $request->input('draw');
//     $start = (int)$request->input('start');
//     $length = (int)$request->input('length');
//     $search = $request->input('search.value');

//     $filteredData = [];
//     $totalRecords = 0;
//     $summary = null;

//     // First pass to get summary and count
//     $summaryStream = fopen($filePath, 'r');
//     $firstLine = fgets($summaryStream);
//     $secondLine = fgets($summaryStream);
//     $summary = json_decode($secondLine, true)['summary'] ?? null;
//     fclose($summaryStream);

//     // Second pass to process data
//     foreach ($this->streamJsonProducts($filePath) as $product) {
//         $totalRecords++;
        
//         if (empty($search) || $this->productMatchesSearch($product, $search)) {
//             $filteredData[] = $product;
//         }
//     }

//     $paginatedData = array_slice($filteredData, $start, $length);

//     return response()->json([
//         'draw' => $draw,
//         'recordsTotal' => $totalRecords,
//         'recordsFiltered' => count($filteredData),
//         'data' => $paginatedData,
//         'summary' => $summary
//     ]);
// }

private function productMatchesSearch($product, $search)
{
    if (stripos($product['product_name'], $search) !== false) {
        return true;
    }
    
    foreach ($product['sites'] as $site) {
        if (stripos($site['site_id'], $search) !== false) {
            return true;
        }
    }
    
    return false;
}
    // public function getReportData(Request $request)
    // {
    //     $filePath = storage_path('debugbar/temp.json');
        
    //     if (!file_exists($filePath)) {
    //         return response()->json(['error' => 'Report not found'], 404);
    //     }

    //     // Read the file in chunks to avoid memory issues
    //     $file = fopen($filePath, 'r');
    //     $products = json_decode(stream_get_contents($file), true);
    //     fclose($file);

    //     // DataTables parameters
    //     $draw = $request->input('draw');
    //     $start = $request->input('start');
    //     $length = $request->input('length');
    //     $search = $request->input('search.value');

    //     // Filter data if search is present
    //     $filteredData = $products['products'];
    //     if (!empty($search)) {
    //         $filteredData = array_filter($products['products'], function($product) use ($search) {
    //             return stripos($product['product_name'], $search) !== false ||
    //                    array_reduce($product['sites'], function($carry, $site) use ($search) {
    //                        return $carry || stripos($site['site_id'], $search) !== false;
    //                    }, false);
    //         });
    //     }

    //     // Paginate the results
    //     $paginatedData = array_slice($filteredData, $start, $length);
    //     $stream = fopen($filePath, 'r');
    //     $buffer = '';
    //     $products = [];
        
    //     while (!feof($stream)) {
    //         $buffer .= fread($stream, 8192);
    //         if (strpos($buffer, "\n") !== false) {
    //             $lines = explode("\n", $buffer);
    //             $buffer = array_pop($lines);
    //             foreach ($lines as $line) {
    //                 $products[] = json_decode($line, true);
    //             }
    //         }
    //     }
    //     fclose($stream);
    //     return response()->json([
    //         'draw' => $draw,
    //         'recordsTotal' => count($products['products']),
    //         'recordsFiltered' => count($filteredData),
    //         'data' => $paginatedData,
    //         'summary' => $products['summary'] // Include summary data
    //     ]);
    // }
}
