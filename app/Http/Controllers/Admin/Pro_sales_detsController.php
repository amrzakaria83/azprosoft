<?php

namespace App\Http\Controllers\Admin;
set_time_limit(3600);
ini_set('max_execution_time', 4800);
ini_set('memory_limit', '4096M');
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Pro_store;
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
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Exports\CollectionExport;    // Assuming you'll create this export class
use Maatwebsite\Excel\Facades\Excel; // Add this import
use Illuminate\Support\Carbon;

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
            $data = Pro_sales_det::with(['getprod','getsale_h']);
            // $data = $data->orderBy('sales_d_id', 'DESC');
            return Datatables::of($data)
                ->order(function ($query) {
                    $query->orderBy('sales_id', 'DESC');
                })
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
        $directory = storage_path('app/');
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
                    ->with(['getsale_site:store_id,sales_id', 'getprod:product_id,product_name_en,sell_price,drug'])
                    ->select(['sales_d_id', 'amount', 'product_id', 'sales_id'])
                    ->cursor();
                    
                foreach ($salesBatch as $sale) {
                    $productName = $sale->getprod->product_name_en ?? 'Unknown';
                    $productId = $sale->getprod->product_id ?? 0; // Fixed variable assignment
                    $productdrug = $sale->getprod->drug ?? 0; //  1 drug or 0 = non drug
                    $siteId = $sale->getsale_site->store_id ?? 'Unknown';
                    $amount = (float)$sale->amount;
                    
                    // Initialize product entry if not exists
                    if (!isset($productReport[$productId])) {
                        $productReport[$productId] = [
                            'product_id' => $productId,
                            'product_name' => $productName,
                            'drug' => $productdrug,//  1 drug or 0 = non drug
                            'sell_price' => $sale->getprod->sell_price ?? 0,
                            'total_sales_amount' => 0,
                            'total_prod_amount' => 0,
                            'sites' => []
                        ];
                    }
                    
                    // Update sales totals
                    $productReport[$productId]['total_sales_amount'] += $amount;
                    
                    // Initialize site entry if not exists
                    if (!isset($productReport[$productId]['sites'][$siteId])) {
                        $productReport[$productId]['sites'][$siteId] = [
                            'sales_amount' => 0,
                            'prod_amount' => 0
                        ];
                    }
                    $productReport[$productId]['sites'][$siteId]['sales_amount'] += $amount;
                    
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
                    $productId = $amount->product_id ?? 0;
                    $productName = $amount->getprod->product_name_en ?? 'Unknown';
                    $productdrug = $amount->getprod->drug ?? 0; //  1 drug or 0 = non drug
                    $siteId = $amount->getsite->store_id ?? 'Unknown';
                    $prodAmount = (float)$amount->prod_amount;
                    
                    // Initialize product entry if not exists
                    if (!isset($productReport[$productId])) {
                        $productReport[$productId] = [
                            'product_id' => $productId,
                            'product_name' => $productName,
                            'drug' => $productdrug,//  1 drug or 0 = non drug
                            'sell_price' => $amount->getprod->sell_price ?? 0,
                            'total_sales_amount' => 0,
                            'total_prod_amount' => 0,
                            'sites' => []
                        ];
                    }
                    
                    // Update product amount totals
                    $productReport[$productId]['total_prod_amount'] += $prodAmount;
                    
                    // Initialize site entry if not exists
                    if (!isset($productReport[$productId]['sites'][$siteId])) {
                        $productReport[$productId]['sites'][$siteId] = [
                            'sales_amount' => 0,
                            'prod_amount' => 0
                        ];
                    }
                    $productReport[$productId]['sites'][$siteId]['prod_amount'] += $prodAmount;
                }
                
                unset($amountsBatch);
                gc_collect_cycles();
            }
        }

        // Format the final output
        $formattedReport = [];
        foreach ($productReport as $productId => $data) {
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
                'product_id' => $productId,
                'product_name' => $data['product_name'],
                'drug' => $data['drug'],
                'sell_price' => $data['sell_price'],
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

        return redirect('admin/pro_sales_dets/indexreportsale')
            ->with('message', 'تم الاضافة بنجاح')
            ->with('status', 'success');
    }

    
    public function export(Request $request)
    {
            $filePath = storage_path('app/temp.json');
            
            if (!file_exists($filePath)) {
                return back()->with('error', 'Export data not found. Please generate the report first.');
            }

            $data = json_decode(file_get_contents($filePath), true);

            $exportData = collect($data)->map(function($item) {
                $row = [
                    'product_id' => $item['product_id'] ?? 'N/A',
                    'Product Name' => $item['product_name'] ?? 'N/A',
                    'Sell Price' => $item['sell_price'] ?? 0,
                    'Total Sales Amount' => $item['total_sales_amount'] ?? 0,
                    'Total Product Amount' => $item['total_prod_amount'] ?? 0,
                ];

                if (!empty($item['sites'])) {
                    foreach ($item['sites'] as $site) {
                        $storeName = $site['store_name'] ?? 'Unknown';
                        $row["{$storeName} Balance"] = $site['prod_amount'] ?? 0;
                        $row["{$storeName} Sales"] = $site['sales_amount'] ?? 0;
                    }
                }

                return $row;
            });

            return Excel::download(new CollectionExport($exportData), 
                'sales_report_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
        }

        public function prepareExport(Request $request)
        {
            $data = $request->input('data');
            $filePath = storage_path('app/temp.json');
            
            file_put_contents($filePath, $data);
            
            return response()->json(['success' => true]);
    }

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
    public function exportReport(Request $request)
    {
        $filePath = storage_path('app/temp.json');
        
        if (!file_exists($filePath)) {
            return response('No data available for export', 404)
                ->header('Content-Type', 'text/plain');
        }
    
        try {
            $fileContents = file_get_contents($filePath);
            $data = json_decode($fileContents, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("Invalid JSON format");
            }
            
            $stores = Pro_store::get(['store_id', 'store_name'])
                ->keyBy('store_id');
    
            // Apply drug filter if specified
            $products = collect($data['products'] ?? []);
            if ($request->has('drug_filter') && $request->drug_filter !== '') {
                $products = $products->filter(function($item) use ($request) {
                    return isset($item['drug']) && $item['drug'] == $request->drug_filter;
                });
            }
    
            // Collect all unique store names
            $allStoreNames = collect();
            foreach ($products as $item) {
                foreach ($item['sites'] ?? [] as $site) {
                    $storeId = $site['site_id'];
                    $storeName = $stores[$storeId]->store_name ?? 'Unknown Store ' . $storeId;
                    $allStoreNames->put($storeId, $storeName);
                }
            }
    
            $exportData = $products->map(function($item) use ($stores, $allStoreNames) {
                $row = [
                    'product_id' => $item['product_id'] ?? 'N/A',
                    'Product Name' => $item['product_name'] ?? 'N/A',
                    'Drug Type' => isset($item['drug']) ? ($item['drug'] == 1 ? trans('lang.drug') : trans('lang.non_drug')) : 'N/A',
                    'Total Sales Amount' => isset($item['total_sales_amount']) ? number_format($item['total_sales_amount'], 2) : 0,
                    'Total Product Amount' => isset($item['total_prod_amount']) ? number_format($item['total_prod_amount'], 2) : 0,
                    'Sell Price' => isset($item['sell_price']) ? number_format($item['sell_price'], 2) : 0,
                ];
    
                // Initialize all store columns
                foreach ($allStoreNames as $storeName) {
                    $row[trans('lang.balance').' '.$storeName] = 0;
                    $row[trans('lang.sales').' '.$storeName] = 0;
                }
    
                // Fill actual values
                foreach ($item['sites'] ?? [] as $site) {
                    $storeId = $site['site_id'];
                    $storeName = $stores[$storeId]->store_name ?? 'Unknown Store ' . $storeId;
                    
                    $row[trans('lang.balance').' '.$storeName] = isset($site['prod_amount']) ? number_format($site['prod_amount'], 3) : 0;
                    $row[trans('lang.sales').' '.$storeName] = isset($site['sales_amount']) ? number_format($site['sales_amount'], 3) : 0;
                }
    
                return $row;
            });
    
            // Build headers
            $headers = [
                'product_id',
                'Product Name',
                'Drug Type',  // Added drug type column
                'Total Sales Amount',
                'Total Product Amount',
                'Sell Price',
            ];
    
            foreach ($allStoreNames as $storeName) {
                $headers[] = trans('lang.balance').' '.$storeName;
                $headers[] = trans('lang.sales').' '.$storeName;
            }
    
            $filename = 'sales_report_' . now()->format('Y-m-d') . '.xlsx';
            
            return Excel::download(new CollectionExport($exportData, $headers), $filename);
    
        } catch (\Exception $e) {
            return response('Export failed: ' . $e->getMessage(), 500)
                ->header('Content-Type', 'text/plain');
        }
    }

    public function getReportData(Request $request)
    {
        $filePath = storage_path('app/temp.json');
        
        if (!file_exists($filePath)) {
            if ($request->export) {
                return response('No data available for export', 404)
                    ->header('Content-Type', 'text/plain');
            }
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

            $products = $data['products'] ?? [];
            $search = $request->input('search.value');
            $drugFilter = $request->input('drug_filter'); // Get drug filter from request
            
            // Filter data based on search and drug filter
            $filteredData = array_filter($products, function($product) use ($search, $drugFilter) {
                // Apply drug filter if specified
                if ($drugFilter !== null && $drugFilter !== '') {
                    if ($product['drug'] != $drugFilter) {
                        return false;
                    }
                }
                
                // Apply search filter if specified
                if (!empty($search)) {
                    $nameMatch = stripos($product['product_name'] ?? '', $search) !== false;
                    $siteMatch = false;
                    
                    if (!$nameMatch && isset($product['sites'])) {
                        foreach ($product['sites'] as $site) {
                            if (stripos($site['site_id'] ?? '', $search) !== false) {
                                $siteMatch = true;
                                break;
                            }
                        }
                    }
                    
                    return $nameMatch || $siteMatch;
                }
                
                return true;
            });

            // Paginate the results
            $start = (int)$request->input('start', 0);
            $length = (int)$request->input('length', 25);
            $paginatedData = array_slice($filteredData, $start, $length);

            // Prepare summary
            $summary = $data['summary'] ?? [
                'total_products' => count($products),
                'total_records' => count($products),
                'generated_at' => now()->toDateTimeString()
            ];
            
            // Update summary counts with filtered data
            $summary['total_products'] = count($filteredData);
            $summary['total_records'] = count($filteredData);

            return response()->json([
                'draw' => $request->input('draw', 0),
                'recordsTotal' => count($products),
                'recordsFiltered' => count($filteredData),
                'data' => $paginatedData,
                'summary' => $summary
            ]);

        } catch (\Exception $e) {
            if ($request->export) {
                return response('Export failed: ' . $e->getMessage(), 500)
                    ->header('Content-Type', 'text/plain');
            }
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

    public function getfile(Request $request)
    {
        $filePath = storage_path('app/temp.json');
        
        if (!file_exists($filePath)) {
            if ($request->export) {
                return response('No data available for export', 404)
                    ->header('Content-Type', 'text/plain');
            }
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

            $fileContents = file_get_contents($filePath);
            $data = json_decode($fileContents, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("Invalid JSON format");
            }
            $products = $data['products'] ?? [];
            // dd($products);
            foreach ($products as $product) {
                // Check if this product has sites
                if (isset($product['sites']) && is_array($product['sites'])) {
                    foreach ($product['sites'] as $site) {
                        // Here you can work with each site for the current product
                        // $product['product_id'] will give you the product ID
                        // $site contains the site-specific data
                        dd($site);
                        // Example usage:
                        echo "Product ID: " . $product['product_id'] . "\n";
                        echo "Product Name: " . $product['product_name'] . "\n";
                        print_r($site); // Display site data
                        
                        // Your processing logic here...
                    }
                }
            }
        return view('admin.pro_sales_det.reportprodsaledet');
    }
    

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

    public function indextranssite()
    {
        return view('admin.pro_sales_det.indextranssite');
    }

    // public function transReport(Request $request)
    // {
    //     $filePath = storage_path('app/temp.json');
        
    //     if (!file_exists($filePath)) {
    //         if ($request->export) {
    //             return response('No data available for export', 404)
    //                 ->header('Content-Type', 'text/plain');
    //         }
    //         return response()->json([
    //             'draw' => $request->input('draw', 0),
    //             'recordsTotal' => 0,
    //             'recordsFiltered' => 0,
    //             'data' => [],
    //             'summary' => [
    //                 'start_from' => 0,
    //                 'end_to' => 0,
    //                 'total_products' => 0,
    //                 'total_records' => 0,
    //                 'generated_at' => now()->toDateTimeString()
    //             ]
    //         ]);
    //     }

    //     try {
    //         $fileContents = file_get_contents($filePath);
    //         $data = json_decode($fileContents, true);
            
    //         if (json_last_error() !== JSON_ERROR_NONE) {
    //             throw new \Exception("Invalid JSON format");
    //         }

    //         $products = $data['products'] ?? [];
    //         $search = $request->input('search.value');
    //         $drugFilter = $request->input('drug_filter'); // Get drug filter from request
    //         $storeFilter = $request->input('store_filter');
    //         $selectedStores = $request->input('selected_stores', []);
    //          // Apply store name filter
    //         if ($request->has('store_filter') && !empty($request->store_filter)) {
    //             $query->whereHas('stores', function($q) use ($request) {
    //                 $q->where('store_name', 'like', '%'.$request->store_filter.'%');
    //             });
    //         }
            
    //         // Apply drug filter
    //         if ($request->has('drug_filter') && !empty($request->drug_filter)) {
    //             $query->whereHas('drugs', function($q) use ($request) {
    //                 $q->where('drug_name', 'like', '%'.$request->drug_filter.'%');
    //             });
    //         }
            
    //         // Filter by selected stores (if any are selected)
    //         if ($request->has('selected_stores') && !empty($request->selected_stores)) {
    //             $query->whereIn('store_id', $request->selected_stores);
    //         }
    //         // Filter data based on search and drug filter
    //         $filteredData = array_filter($products, function($product) use ($search, $drugFilter) {
    //             // Apply drug filter if specified
    //             if ($drugFilter !== null && $drugFilter !== '') {
    //                 if ($product['drug'] != $drugFilter) {
    //                     return false;
    //                 }
    //             }
                
    //             // Apply search filter if specified
    //             if (!empty($search)) {
    //                 $nameMatch = stripos($product['product_name'] ?? '', $search) !== false;
    //                 $siteMatch = false;
                    
    //                 if (!$nameMatch && isset($product['sites'])) {
    //                     foreach ($product['sites'] as $site) {
    //                         if (stripos($site['site_id'] ?? '', $search) !== false) {
    //                             $siteMatch = true;
    //                             break;
    //                         }
    //                     }
    //                 }
                    
    //                 return $nameMatch || $siteMatch;
    //             }
                
    //             return true;
    //         });

            
                     
    //         // Paginate the results
    //         $start = (int)$request->input('start', 0);
    //         $length = (int)$request->input('length', 25);
    //         $paginatedData = array_slice($filteredData, $start, $length);

    //         // Prepare summary
    //         $summary = $data['summary'] ?? [
    //             'total_products' => count($products),
    //             'total_records' => count($products),
    //             'generated_at' => now()->toDateTimeString(),
    //             'days_diff' =>  0,
    //         ];
            
    //         // Calculate date difference if both dates exist
    //         if (!empty($summary['start_from']) && !empty($summary['end_to'])) {
    //             $startDate = Carbon::parse($summary['start_from']);
    //             $endDate = Carbon::parse($summary['end_to']);
                
    //             $summary['days_diff'] = $endDate->diffInDays($startDate);
    //             $summary['months_diff'] = $endDate->diffInMonths($startDate);
    //             $summary['years_diff'] = $endDate->diffInYears($startDate);
    //         } else {
    //             $summary['days_diff'] = 0;
    //             $summary['months_diff'] = 0;
    //             $summary['years_diff'] = 0;
    //         }
    //         // dd($summary);  

    //         // Update summary counts with filtered data
    //         $summary['total_products'] = count($filteredData);
    //         $summary['total_records'] = count($filteredData);

    //         return response()->json([
    //             'draw' => $request->input('draw', 0),
    //             'recordsTotal' => count($products),
    //             'recordsFiltered' => count($filteredData),
    //             'data' => $paginatedData,
    //             'summary' => $summary
    //         ]);


    //     } catch (\Exception $e) {
    //         if ($request->export) {
    //             return response('Export failed: ' . $e->getMessage(), 500)
    //                 ->header('Content-Type', 'text/plain');
    //         }
    //         return response()->json([
    //             'draw' => $request->input('draw', 0),
    //             'recordsTotal' => 0,
    //             'recordsFiltered' => 0,
    //             'data' => [],
    //             'summary' => [
    //                 'total_products' => 0,
    //                 'total_records' => 0,
    //                 'generated_at' => now()->toDateTimeString()
    //             ],
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }
//     public function transReport(Request $request)
// {
//     $filePath = storage_path('app/temp.json');
    
//     if (!file_exists($filePath)) {
//         if ($request->export) {
//             return response('No data available for export', 404)
//                 ->header('Content-Type', 'text/plain');
//         }
//         return response()->json([
//             'draw' => $request->input('draw', 0),
//             'recordsTotal' => 0,
//             'recordsFiltered' => 0,
//             'data' => [],
//             'summary' => [
//                 'start_from' => 0,
//                 'end_to' => 0,
//                 'total_products' => 0,
//                 'total_records' => 0,
//                 'generated_at' => now()->toDateTimeString()
//             ]
//         ]);
//     }

//     try {
//         $fileContents = file_get_contents($filePath);
//         $data = json_decode($fileContents, true);
        
//         if (json_last_error() !== JSON_ERROR_NONE) {
//             throw new \Exception("Invalid JSON format");
//         }

//         $products = $data['products'] ?? [];
//         $search = $request->input('search.value');
//         $store_id_transfer = $request->input('store_id_transfer');
//         $drugFilter = $request->input('drug_filter');
//         $storeFilter = $request->input('store_filter');
//         $selectedStores = $request->input('selected_stores', []);

//         // Filter data based on all conditions
//         $filteredData = array_filter($products, function($product) use ($search, $store_id_transfer, $drugFilter, $storeFilter, $selectedStores) {
//                 // Apply store transfer filter if specified
//                 if (!empty($store_id_transfer)) {
//                     if (!isset($product['sites']) || !is_array($product['sites'])) {
//                         return false;
//                     }
                    
//                     $storeFound = false;
//                     foreach ($product['sites'] as $store) {
//                         if (isset($store['store_id']) && $store['store_id'] == $store_id_transfer) {
//                             $storeFound = true;
//                             break;
//                         }
//                     }
//                     if (!$storeFound) return false;
                    
//                     // Additional check for prod_amount > 0 in sites
//                     if (isset($product['sites']) && is_array($product['sites'])) {
//                         $hasAvailableStock = false;
//                         foreach ($product['sites'] as $site) {
//                             if (isset($site['prod_amount']) && $site['prod_amount'] > 0) {
//                                 $hasAvailableStock = true;
//                                 break;
//                             }
//                         }
//                         if (!$hasAvailableStock) return false;
//                     } else {
//                         return false; // No sites or invalid data
//                     }
//                 }
//             // Apply drug filter if specified
//             if (!empty($drugFilter)) {
//                 if (!isset($product['drug']) || stripos($product['drug'], $drugFilter) === false) {
//                     return false;
//                 }
//             }
            
//             // Apply store filter if specified
//             if (!empty($storeFilter)) {
//                 $storeMatch = false;
//                 if (isset($product['sites'])) {
//                     foreach ($product['sites'] as $store) {
//                         if (stripos($store['store_name'] ?? '', $storeFilter) !== false) {
//                             $storeMatch = true;
//                             break;
//                         }
//                     }
//                 }
//                 if (!$storeMatch) return false;
//             }
            
//             // Filter by selected stores if specified
//             if (!empty($selectedStores) && isset($product['store_id'])) {
//                 if (!in_array($product['store_id'], $selectedStores)) {
//                     return false;
//                 }
//             }
            
//             // Apply search filter if specified
//             if (!empty($search)) {
//                 $nameMatch = isset($product['product_name']) && 
//                             stripos($product['product_name'], $search) !== false;

//                 $codeMatch = isset($product['product_code']) && 
//                    stripos($product['product_code'], $search) !== false;
                
//                 $siteMatch = false;
//                 if (isset($product['sites'])) {
//                     foreach ($product['sites'] as $site) {
//                         if (stripos($site['site_id'] ?? '', $search) !== false) {
//                             $siteMatch = true;
//                             break;
//                         }
//                     }
//                 }
//                 return $nameMatch || $codeMatch || $siteMatch;
//             }
            
//             return true;
//         });

//         // Reset array keys
//         $filteredData = array_values($filteredData);
        
//         // Paginate the results
//         $start = (int)$request->input('start', 0);
//         $length = (int)$request->input('length', 25);
//         $paginatedData = array_slice($filteredData, $start, $length);

//         // Prepare summary
//         $summary = $data['summary'] ?? [
//             'total_products' => count($products),
//             'total_records' => count($products),
//             'generated_at' => now()->toDateTimeString(),
//             'days_diff' => 0,
//         ];
        
//         // Calculate date differences if dates exist
//         if (!empty($summary['start_from']) && !empty($summary['end_to'])) {
//             $startDate = Carbon::parse($summary['start_from']);
//             $endDate = Carbon::parse($summary['end_to']);
            
//             $summary['days_diff'] = $endDate->diffInDays($startDate);
//             $summary['months_diff'] = $endDate->diffInMonths($startDate);
//             $summary['years_diff'] = $endDate->diffInYears($startDate);
//         } else {
//             $summary['days_diff'] = 0;
//             $summary['months_diff'] = 0;
//             $summary['years_diff'] = 0;
//         }

//         // Update summary counts with filtered data
//         $summary['total_products'] = count($filteredData);
//         $summary['total_records'] = count($filteredData);

//         return response()->json([
//             'draw' => $request->input('draw', 0),
//             'recordsTotal' => count($products),
//             'recordsFiltered' => count($filteredData),
//             'data' => $paginatedData,
//             'summary' => $summary
//         ]);

//     } catch (\Exception $e) {
//         if ($request->export) {
//             return response('Export failed: ' . $e->getMessage(), 500)
//                 ->header('Content-Type', 'text/plain');
//         }
//         return response()->json([
//             'draw' => $request->input('draw', 0),
//             'recordsTotal' => 0,
//             'recordsFiltered' => 0,
//             'data' => [],
//             'summary' => [
//                 'total_products' => 0,
//                 'total_records' => 0,
//                 'generated_at' => now()->toDateTimeString()
//             ],
//             'error' => $e->getMessage()
//         ]);
//     }
// }
// public function transReport(Request $request)
// {
//     $filePath = storage_path('app/temp.json');
    
//     // Initial empty response structure
//     $emptyResponse = [
//         'draw' => $request->input('draw', 0),
//         'recordsTotal' => 0,
//         'recordsFiltered' => 0,
//         'data' => [],
//         'summary' => [
//             'start_from' => null,
//             'end_to' => null,
//             'total_products' => 0,
//             'total_records' => 0,
//             'days_diff' => 0,
//             'months_diff' => 0,
//             'years_diff' => 0,
//             'generated_at' => now()->toDateTimeString()
//         ]
//     ];

//     // Handle missing file case
//     if (!file_exists($filePath)) {
//         if ($request->export) {
//             return response('No data available for export', 404)
//                 ->header('Content-Type', 'text/plain');
//         }
//         return response()->json($emptyResponse);
//     }

//     try {
//         $fileContents = file_get_contents($filePath);
//         $data = json_decode($fileContents, true);
        
//         if (json_last_error() !== JSON_ERROR_NONE) {
//             throw new \Exception("Invalid JSON format in temp file");
//         }

//         $products = $data['products'] ?? [];
//         $search = $request->input('search.value');
//         $store_id_transfer = $request->input('store_id_transfer');
//         $drugFilter = $request->input('drug_filter');
//         $storeFilter = $request->input('store_filter');
//         $selectedStores = $request->input('selected_stores', []);

//         // Filter data based on all conditions
//         $filteredData = array_filter($products, function($product) use ($search, $store_id_transfer, $drugFilter, $storeFilter, $selectedStores) {
//             // Store transfer filter with prod_amount check
//             if (!empty($store_id_transfer)) {
//                 if (!isset($product['sites']) || !is_array($product['sites'])) {
//                     return false;
//                 }
                
//                 $hasValidStoreWithStock = false;
//                 foreach ($product['sites'] as $site) {
//                     if (isset($site['store_id']) && 
//                         $site['store_id'] == $store_id_transfer && 
//                         isset($site['prod_amount']) && 
//                         $site['prod_amount'] > 0) {
//                         $hasValidStoreWithStock = true;
//                         break;
//                     }
//                 }
//                 if (!$hasValidStoreWithStock) return false;
//             }

//             // Drug filter
//             if (!empty($drugFilter)) {
//                 if (!isset($product['drug']) || stripos($product['drug'], $drugFilter) === false) {
//                     return false;
//                 }
//             }
            
//             // Store name filter
//             if (!empty($storeFilter)) {
//                 $storeMatch = false;
//                 if (isset($product['sites'])) {
//                     foreach ($product['sites'] as $site) {
//                         if (isset($site['store_name']) && stripos($site['store_name'], $storeFilter) !== false) {
//                             $storeMatch = true;
//                             break;
//                         }
//                     }
//                 }
//                 if (!$storeMatch) return false;
//             }
            
//             // Selected stores filter
//             if (!empty($selectedStores)) {
//                 $storeMatch = false;
                
//                 // Check direct store_id if exists
//                 if (isset($product['store_id']) && in_array($product['store_id'], $selectedStores)) {
//                     $storeMatch = true;
//                 }
                
//                 // Check sites array
//                 if (!$storeMatch && isset($product['sites'])) {
//                     foreach ($product['sites'] as $site) {
//                         if (isset($site['store_id']) && in_array($site['store_id'], $selectedStores)) {
//                             $storeMatch = true;
//                             break;
//                         }
//                     }
//                 }
                
//                 if (!$storeMatch) return false;
//             }
            
//             // Search filter
//             if (!empty($search)) {
//                 $searchLower = strtolower($search);
//                 $nameMatch = isset($product['product_name']) && 
//                              stripos($product['product_name'], $search) !== false;
                
//                 $codeMatch = isset($product['product_code']) && 
//                             stripos($product['product_code'], $search) !== false;
                
//                 $siteMatch = false;
//                 if (isset($product['sites'])) {
//                     foreach ($product['sites'] as $site) {
//                         if ((isset($site['site_id']) && stripos($site['site_id'], $search) !== false) ||
//                             (isset($site['site_name']) && stripos($site['site_name'], $search) !== false)) {
//                             $siteMatch = true;
//                             break;
//                         }
//                     }
//                 }
                
//                 return $nameMatch || $codeMatch || $siteMatch;
//             }
            
//             return true;
//         });

//         // Reset array keys and paginate
//         $filteredData = array_values($filteredData);
//         $start = (int)$request->input('start', 0);
//         $length = (int)$request->input('length', 25);
//         $paginatedData = array_slice($filteredData, $start, $length);

//         // Prepare summary
//         $summary = $data['summary'] ?? [
//             'start_from' => null,
//             'end_to' => null,
//             'total_products' => count($products),
//             'total_records' => count($products),
//             'generated_at' => now()->toDateTimeString(),
//         ];

//         // Calculate date differences
//         if (!empty($summary['start_from']) && !empty($summary['end_to'])) {
//             try {
//                 $startDate = Carbon::parse($summary['start_from']);
//                 $endDate = Carbon::parse($summary['end_to']);
                
//                 $summary['days_diff'] = $endDate->diffInDays($startDate);
//                 $summary['months_diff'] = $endDate->diffInMonths($startDate);
//                 $summary['years_diff'] = $endDate->diffInYears($startDate);
//             } catch (\Exception $e) {
//                 $summary['days_diff'] = 0;
//                 $summary['months_diff'] = 0;
//                 $summary['years_diff'] = 0;
//             }
//         }

//         // Update summary with filtered counts
//         $summary['total_products'] = count($filteredData);
//         $summary['total_records'] = count($filteredData);

//         return response()->json([
//             'draw' => $request->input('draw', 0),
//             'recordsTotal' => count($products),
//             'recordsFiltered' => count($filteredData),
//             'data' => $paginatedData,
//             'summary' => $summary
//         ]);

//     } catch (\Exception $e) {
//         \Log::error('Transaction report error: ' . $e->getMessage());
        
//         if ($request->export) {
//             return response('Export failed: ' . $e->getMessage(), 500)
//                 ->header('Content-Type', 'text/plain');
//         }
        
//         $emptyResponse['error'] = $e->getMessage();
//         return response()->json($emptyResponse);
//     }
// }
// public function transReport(Request $request)
// {
//     $filePath = storage_path('app/temp.json');
    
//     // Initial empty response structure
//     $emptyResponse = [
//         'draw' => $request->input('draw', 0),
//         'recordsTotal' => 0,
//         'recordsFiltered' => 0,
//         'data' => [],
//         'summary' => [
//             'start_from' => null,
//             'end_to' => null,
//             'total_products' => 0,
//             'total_records' => 0,
//             'days_diff' => 0,
//             'months_diff' => 0,
//             'years_diff' => 0,
//             'generated_at' => now()->toDateTimeString()
//         ]
//     ];

//     // Handle missing file case
//     if (!file_exists($filePath)) {
//         if ($request->export) {
//             return response('No data available for export', 404)
//                 ->header('Content-Type', 'text/plain');
//         }
//         return response()->json($emptyResponse);
//     }

//     try {
//         $fileContents = file_get_contents($filePath);
//         $data = json_decode($fileContents, true);
        
//         if (json_last_error() !== JSON_ERROR_NONE) {
//             throw new \Exception("Invalid JSON format in temp file");
//         }

//         $products = $data['products'] ?? [];
//         $search = $request->input('search.value');
//         $store_id_transfer = $request->input('store_id_transfer');
//         $drugFilter = $request->input('drug_filter');
//         $storeFilter = $request->input('store_filter');
//         $selectedStores = $request->input('selected_stores', []);

//         // Debug: Log filter values
//         \Log::debug('Filter values:', [
//             'store_id_transfer' => $store_id_transfer,
//             'drugFilter' => $drugFilter,
//             'storeFilter' => $storeFilter,
//             'selectedStores' => $selectedStores,
//             'search' => $search
//         ]);

//         // Filter data based on all conditions
//         $filteredData = array_filter($products, function($product) use ($search, $store_id_transfer, $drugFilter, $storeFilter, $selectedStores) {
//             $rejectReasons = [];
            
//             // Store transfer filter
//             if (!empty($store_id_transfer)) {
//                 if (!isset($product['sites']) || !is_array($product['sites'])) {
//                     $rejectReasons[] = 'No sites data';
//                     return false;
//                 }
                
//                 $storeFound = false;
//                 $hasStock = false;
//                 foreach ($product['sites'] as $site) {
//                     if (isset($site['store_id']) && $site['store_id'] == $store_id_transfer) {
//                         $storeFound = true;
//                         if (isset($site['prod_amount']) && $site['prod_amount'] > 0) {
//                             $hasStock = true;
//                         }
//                     }
//                 }
                
//                 if (!$storeFound) {
//                     $rejectReasons[] = 'Not in specified store';
//                     return false;
//                 }
//                 if (!$hasStock) {
//                     $rejectReasons[] = 'No stock in specified store';
//                     // return false; // Uncomment to enforce stock requirement
//                 }
//             }

//             // Drug filter
//             if (!empty($drugFilter)) {
//                 if (!isset($product['drug']) || stripos($product['drug'], $drugFilter) === false) {
//                     $rejectReasons[] = 'Drug filter mismatch';
//                     return false;
//                 }
//             }
            
//             // Store name filter
//             if (!empty($storeFilter)) {
//                 $storeMatch = false;
//                 if (isset($product['sites'])) {
//                     foreach ($product['sites'] as $site) {
//                         if (isset($site['store_name']) && stripos($site['store_name'], $storeFilter) !== false) {
//                             $storeMatch = true;
//                             break;
//                         }
//                     }
//                 }
//                 if (!$storeMatch) {
//                     $rejectReasons[] = 'Store name filter mismatch';
//                     return false;
//                 }
//             }
            
//             // Selected stores filter
//             if (!empty($selectedStores)) {
//                 $storeMatch = false;
                
//                 // Check direct store_id if exists
//                 if (isset($product['store_id']) && in_array($product['store_id'], $selectedStores)) {
//                     $storeMatch = true;
//                 }
                
//                 // Check sites array
//                 if (!$storeMatch && isset($product['sites'])) {
//                     foreach ($product['sites'] as $site) {
//                         if (isset($site['store_id']) && in_array($site['store_id'], $selectedStores)) {
//                             $storeMatch = true;
//                             break;
//                         }
//                     }
//                 }
                
//                 if (!$storeMatch) {
//                     $rejectReasons[] = 'Not in selected stores';
//                     return false;
//                 }
//             }
            
//             // Search filter
//             if (!empty($search)) {
//                 $searchLower = strtolower($search);

//                 $nameMatch = isset($product['product_name']) && 
//                              stripos($product['product_name'], $search) !== false;
                
//                 $codeMatch = isset($product['product_code']) && 
//                             stripos($product['product_code'], $search) !== false;
                
//                 $siteMatch = false;
//                 if (isset($product['sites'])) {
//                     foreach ($product['sites'] as $site) {
//                         if ((isset($site['site_id']) && stripos($site['site_id'], $search) !== false) ||
//                             (isset($site['site_name']) && stripos($site['site_name'], $search) !== false)) {
//                             $siteMatch = true;
//                             break;
//                         }
//                     }
//                 }
                
//                 if (!($nameMatch || $codeMatch || $siteMatch)) {
//                     $rejectReasons[] = 'Search term not found';
//                     return false;
//                 }
//             }
            
//             if (!empty($rejectReasons) && count($rejectReasons) > 0) {
//                 \Log::debug('Product filtered:', [
//                     'product_id' => $product['product_id'] ?? 'unknown',
//                     'reasons' => $rejectReasons
//                 ]);
//             }
            
//             return true;
//         });

//         // Reset array keys and paginate
//         $filteredData = array_values($filteredData);
//         $start = (int)$request->input('start', 0);
//         $length = (int)$request->input('length', 25);
//         $paginatedData = array_slice($filteredData, $start, $length);

//         // Prepare summary
//         $summary = $data['summary'] ?? [
//             'start_from' => null,
//             'end_to' => null,
//             'total_products' => count($products),
//             'total_records' => count($products),
//             'generated_at' => now()->toDateTimeString(),
//         ];

//         // Calculate date differences
//         if (!empty($summary['start_from']) && !empty($summary['end_to'])) {
//             try {
//                 $startDate = Carbon::parse($summary['start_from']);
//                 $endDate = Carbon::parse($summary['end_to']);
                
//                 $summary['days_diff'] = $endDate->diffInDays($startDate);
//                 $summary['months_diff'] = $endDate->diffInMonths($startDate);
//                 $summary['years_diff'] = $endDate->diffInYears($startDate);
//             } catch (\Exception $e) {
//                 $summary['days_diff'] = 0;
//                 $summary['months_diff'] = 0;
//                 $summary['years_diff'] = 0;
//             }
//         }

//         // Update summary with filtered counts
//         $summary['total_products'] = count($filteredData);
//         $summary['total_records'] = count($filteredData);

//         // Debug: Log filtering results
//         \Log::debug('Filtering results:', [
//             'total_products' => count($products),
//             'filtered_count' => count($filteredData),
//             'first_filtered_product' => $filteredData[0] ?? null
//         ]);

//         return response()->json([
//             'draw' => $request->input('draw', 0),
//             'recordsTotal' => count($products),
//             'recordsFiltered' => count($filteredData),
//             'data' => $paginatedData,
//             'summary' => $summary
//         ]);

//     } catch (\Exception $e) {
//         \Log::error('Transaction report error: ' . $e->getMessage());
//         \Log::error('Stack trace: ' . $e->getTraceAsString());
        
//         if ($request->export) {
//             return response('Export failed: ' . $e->getMessage(), 500)
//                 ->header('Content-Type', 'text/plain');
//         }
        
//         $emptyResponse['error'] = $e->getMessage();
//         return response()->json($emptyResponse);
//     }
// }
public function transReport(Request $request)
{
    $filePath = storage_path('app/temp.json');
    
    // Initial empty response structure
    $emptyResponse = [
        'draw' => $request->input('draw', 0),
        'recordsTotal' => 0,
        'recordsFiltered' => 0,
        'data' => [],
        'summary' => [
            'start_from' => null,
            'end_to' => null,
            'total_products' => 0,
            'total_records' => 0,
            'days_diff' => 0,
            'months_diff' => 0,
            'years_diff' => 0,
            'generated_at' => now()->toDateTimeString()
        ]
    ];

    // Handle missing file case
    if (!file_exists($filePath)) {
        if ($request->export) {
            return response('No data available for export', 404)
                ->header('Content-Type', 'text/plain');
        }
        return response()->json($emptyResponse);
    }

    try {
        $fileContents = file_get_contents($filePath);
        $data = json_decode($fileContents, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Invalid JSON format in temp file");
        }

        $products = $data['products'] ?? [];
        $search = $request->input('search.value');
        $store_id_transfer = $request->input('store_id_transfer');
        $drugFilter = $request->input('drug_filter');
        $storeFilter = $request->input('store_filter');
        $selectedStores = $request->input('selected_stores', []);

        // Debug: Log filter values
        \Log::debug('Filter values:', [
            'store_id_transfer' => $store_id_transfer,
            'drugFilter' => $drugFilter,
            'storeFilter' => $storeFilter,
            'selectedStores' => $selectedStores,
            'search' => $search
        ]);

        // Filter data based on all conditions
        $filteredData = array_filter($products, function($product) use ($search, $store_id_transfer, $drugFilter, $storeFilter, $selectedStores) {
            $rejectReasons = [];
            
            // Store transfer filter - requires both store match AND stock > 0
            if (!empty($store_id_transfer)) {
                if (!isset($product['sites']) || !is_array($product['sites'])) {
                    $rejectReasons[] = 'No sites data';
                    return false;
                }
                
                $storeFound = false;
                $hasStock = false;
                
                foreach ($product['sites'] as $site) {
                    // Changed from store_id to site_id to match your data structure
                    if (isset($site['site_id']) && $site['site_id'] == $store_id_transfer) {
                        $storeFound = true;
                        if (isset($site['prod_amount']) && $site['prod_amount'] > 0) {
                            $hasStock = true;
                            break; // Found what we need, no need to continue
                        }
                    }
                }
                
                if (!$storeFound) {
                    $rejectReasons[] = 'Not in specified store';
                    return false;
                }
                if (!$hasStock) {
                    $rejectReasons[] = 'No stock in specified store';
                    return false;
                }
            }

            // Drug filter
            if (!empty($drugFilter)) {
                if (!isset($product['drug']) || stripos($product['drug'], $drugFilter) === false) {
                    $rejectReasons[] = 'Drug filter mismatch';
                    return false;
                }
            }
            
            // Store name filter
            if (!empty($storeFilter)) {
                $storeMatch = false;
                if (isset($product['sites'])) {
                    foreach ($product['sites'] as $site) {
                        if (isset($site['store_name']) && stripos($site['store_name'], $storeFilter) !== false) {
                            $storeMatch = true;
                            break;
                        }
                    }
                }
                if (!$storeMatch) {
                    $rejectReasons[] = 'Store name filter mismatch';
                    return false;
                }
            }
            
            // Selected stores filter
            if (!empty($selectedStores)) {
                $storeMatch = false;
                
                // Check direct store_id if exists
                if (isset($product['store_id']) && in_array($product['store_id'], $selectedStores)) {
                    $storeMatch = true;
                }
                
                // Check sites array
                if (!$storeMatch && isset($product['sites'])) {
                    foreach ($product['sites'] as $site) {
                        if (isset($site['store_id']) && in_array($site['store_id'], $selectedStores)) {
                            $storeMatch = true;
                            break;
                        }
                    }
                }
                
                if (!$storeMatch) {
                    $rejectReasons[] = 'Not in selected stores';
                    return false;
                }
            }
            
            // Search filter
            if (!empty($search)) {
                $searchLower = strtolower($search);
                $nameMatch = isset($product['product_name']) && 
                             stripos($product['product_name'], $search) !== false;
                
                $codeMatch = isset($product['product_code']) && 
                            stripos($product['product_code'], $search) !== false;
                
                $siteMatch = false;
                if (isset($product['sites'])) {
                    foreach ($product['sites'] as $site) {
                        if ((isset($site['site_id']) && stripos($site['site_id'], $search) !== false) ||
                            (isset($site['site_name']) && stripos($site['site_name'], $search) !== false)) {
                            $siteMatch = true;
                            break;
                        }
                    }
                }
                
                if (!($nameMatch || $codeMatch || $siteMatch)) {
                    $rejectReasons[] = 'Search term not found';
                    return false;
                }
            }
            
            if (!empty($rejectReasons) && count($rejectReasons) > 0) {
                \Log::debug('Product filtered:', [
                    'product_id' => $product['product_id'] ?? 'unknown',
                    'reasons' => $rejectReasons
                ]);
            }
            
            return true;
        });

        // Reset array keys and paginate
        $filteredData = array_values($filteredData);
        $start = (int)$request->input('start', 0);
        $length = (int)$request->input('length', 25);
        $paginatedData = array_slice($filteredData, $start, $length);

        // Prepare summary
        $summary = $data['summary'] ?? [
            'start_from' => null,
            'end_to' => null,
            'total_products' => count($products),
            'total_records' => count($products),
            'generated_at' => now()->toDateTimeString(),
        ];

        // Calculate date differences
        if (!empty($summary['start_from']) && !empty($summary['end_to'])) {
            try {
                $startDate = Carbon::parse($summary['start_from']);
                $endDate = Carbon::parse($summary['end_to']);
                
                $summary['days_diff'] = $endDate->diffInDays($startDate);
                $summary['months_diff'] = $endDate->diffInMonths($startDate);
                $summary['years_diff'] = $endDate->diffInYears($startDate);
            } catch (\Exception $e) {
                $summary['days_diff'] = 0;
                $summary['months_diff'] = 0;
                $summary['years_diff'] = 0;
            }
        }

        // Update summary with filtered counts
        $summary['total_products'] = count($filteredData);
        $summary['total_records'] = count($filteredData);

        // Debug: Log filtering results
        \Log::debug('Filtering results:', [
            'total_products' => count($products),
            'filtered_count' => count($filteredData),
            'first_filtered_product' => $filteredData[0] ?? null
        ]);

        return response()->json([
            'draw' => $request->input('draw', 0),
            'recordsTotal' => count($products),
            'recordsFiltered' => count($filteredData),
            'alldata' => $filteredData,
            'data' => $paginatedData,
            'summary' => $summary
        ]);

    } catch (\Exception $e) {
        \Log::error('Transaction report error: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        
        if ($request->export) {
            return response('Export failed: ' . $e->getMessage(), 500)
                ->header('Content-Type', 'text/plain');
        }
        
        $emptyResponse['error'] = $e->getMessage();
        return response()->json($emptyResponse);
    }
}
// public function transReport(Request $request)
// {
//     $filePath = storage_path('app/temp.json');
    
//     // Initial empty response
//     $response = [
//         'draw' => (int)$request->input('draw', 1),
//         'recordsTotal' => 0,
//         'recordsFiltered' => 0,
//         'data' => [],
//         'summary' => [
//             'start_from' => null,
//             'end_to' => null,
//             'total_products' => 0,
//             'total_records' => 0,
//             'days_diff' => 0,
//             'generated_at' => now()->toDateTimeString()
//         ]
//     ];

//     if (!file_exists($filePath)) {
//         return response()->json($response);
//     }

//     try {
//         $data = json_decode(file_get_contents($filePath), true);
//         if (json_last_error() !== JSON_ERROR_NONE) {
//             throw new \Exception("Invalid JSON data");
//         }

//         $products = $data['products'] ?? [];
//         $response['recordsTotal'] = count($products);
        
//         // Apply filters (simplified version)
//         $filteredData = array_filter($products, function($product) use ($request) {
//             // Store transfer filter
//             if ($request->filled('store_id_transfer')) {
//                 if (empty($product['sites'])) return false;
                
//                 $found = false;
//                 foreach ($product['sites'] as $site) {
//                     if (($site['store_id'] ?? null) == $request->input('store_id_transfer')) {
//                         $found = true;
//                         break;
//                     }
//                 }
//                 if (!$found) return false;
//             }
            
//             // Drug filter
//             if ($request->filled('drug_filter')) {
//                 if (strpos(strtolower($product['drug'] ?? ''), strtolower($request->input('drug_filter'))) === false) {
//                     return false;
//                 }
//             }
            
//             // Search filter
//             if ($request->filled('search')) {
//                 $search = strtolower($request->input('search'));
//                 $nameMatch = strpos(strtolower($product['product_name'] ?? ''), $search) !== false;
//                 $codeMatch = strpos(strtolower($product['product_code'] ?? ''), $search) !== false;
//                 if (!$nameMatch && !$codeMatch) return false;
//             }
            
//             return true;
//         });

//         $response['recordsFiltered'] = count($filteredData);
        
//         // Pagination
//         $start = $request->input('start', 0);
//         $length = $request->input('length', 25);
//         $response['data'] = array_slice($filteredData, $start, $length);
        
//         // Summary data
//         $response['summary'] = $data['summary'] ?? [
//             'total_products' => $response['recordsFiltered'],
//             'generated_at' => now()->toDateTimeString()
//         ];
        
//         // Calculate date differences
//         if (!empty($response['summary']['start_from']) && !empty($response['summary']['end_to'])) {
//             try {
//                 $startDate = Carbon::parse($response['summary']['start_from']);
//                 $endDate = Carbon::parse($response['summary']['end_to']);
//                 $response['summary']['days_diff'] = $endDate->diffInDays($startDate);
//             } catch (\Exception $e) {
//                 $response['summary']['days_diff'] = 0;
//             }
//         }

//         return response()->json($response);

//     } catch (\Exception $e) {
//         \Log::error("Report error: " . $e->getMessage());
//         return response()->json($response);
//     }
// }
}
