<?php

namespace App\Http\Controllers\Admin;
        set_time_limit(3600);
        ini_set('max_execution_time', 4800);
        ini_set('memory_limit', '4096M');
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Pur_request;
use App\Models\All_pur_import;
use App\Models\Store_pur_request;
use App\Models\Pro_prod_amount;
use App\Models\Pur_trans;
use DataTables;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus; // Add this import
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\DatabaseService;

class Pur_requestsController extends Controller
{
    protected $databaseService;
     public function __construct(DatabaseService $databaseService)
    {
        $this->databaseService = $databaseService;
        $this->initializeSqlServerConnection();


        // Now you can use the service throughout your controller:
        //             return $this->databaseService->executeWithRetry(function() {
        //         return DB::connection('sqlsrv')->table('your_table')->get();
        // });
    }

    protected function initializeSqlServerConnection()
    {
        try {
            $this->databaseService->executeWithRetry(function() {
                return DB::connection('sqlsrv')->select('SELECT 1 AS test');
            });
        } catch (\Exception $e) {
            Log::error('SQL Server connection failed: ' . $e->getMessage());
            abort(503, 'Database connection unavailable');
        }
    }

    public function index(Request $request)
    {
        
        
        if ($request->ajax()) {
            // $data = Pur_request::query();
            $data = Pur_request::where('status_pur', 0)->with(['getprod']);
            $data = $data->orderBy('id', 'DESC');

            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name_ar', function($row){
                    $name_ar = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'
                    .$row->getprod->product_name_en ?? $row->getprod->product_name.'</a><div>';

                    return $name_ar;
                })
                ->addColumn('quantity', function($row){
                    $quantity = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->quantity ?? '1'.'</a><div>';

                    return $quantity;
                })
                ->addColumn('reqquantity', function($row){
                    $display_quantity = $row->quantity ?? 1; // Default to current row's quantity

                    $reqquantity =  '<div ><input type="number" id="'.$row->id.'" class="text-center" name="reqquantity" value="'.$display_quantity.'" /></div>';
                    return $reqquantity;
                })
                ->addColumn('sell_price', function($row){
                    $sell_price = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'
                    .$row->getprod->sell_price ?? 'Unknowen'.'</a><div>';

                    return $sell_price;
                })
                ->addColumn('factory_name', function($row){
                    $factory_name = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'
                    .$row->getprod->getfactory->factory_name ?? 'Unknowen'.'</a></div>';
                    return $factory_name;
                })
                 ->addColumn('created_at', function($row){
                    $created_at = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->updated_at.'</a>';
                    $timestamp = $row->updated_at; // Get the timestamp from the $row object
                    $currentTime = Carbon::now();
                    $timestamp = Carbon::parse($timestamp);
                    $timeDifference = $currentTime->diff($timestamp);
                    $days = $timeDifference->days;
                    $hours = $timeDifference->h;
                    $minutes = $timeDifference->i;
                    $timeString = '';
                    if ($days > 0) {
                        $timeString .= $days .' يوم '.'-';
                    }
                    if ($hours > 0) {
                        $timeString .= $hours .' ساعة '.'-';
                    }
                    $timeString .= $minutes .' دقيقة ';
                    // $created_at .= '<span>مطلوب منذ: '.$days.' يوم '.$hours.' ساعة '.$minutes.' دقيقة</span></div>';
                    $created_at .= '<span></span> <span>'.$timeString.'</span></div>';
                    return $created_at;
                })
                ->orderColumn('created_at', 'updated_at $1')
                ->addColumn('balance', function($row){
                    $balance = Pro_prod_amount::where([
                        ['product_id', $row->getprod->product_id],
                        ['prod_amount', '>', 0]
                    ])->sum('prod_amount') ?? 0;

                    return $balance;
                })
                

                ->addColumn('note', function($row){
                    $note = $row->note ;

                    return $note;
                })
                
                ->addColumn('status', function($row){
                    if($row->status == 0 ) {
                        $status = '<div class="badge badge-light-success fw-bold">مقعل</div>';
                    } else {
                        $status = '<div class="badge badge-light-danger fw-bold">غير مفعل</div>';
                    }
                    
                    return $status;
                })
                ->addColumn('actions', function($row){
                   
                        $actions = '<div class="ms-2" id="div'.$row->id.'">
                        <a href="javascript:void(0);" onclick="pur_done('.$row->id.')" class="btn btn-sm btn-success btn-active-dark me-2">
                            <i class="bi bi bi-check-circle-fill fs-1x"></i>
                        <a href="javascript:;void(0);" onclick="pur_some_done('.$row->id.')" class="btn btn-sm btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <i class="bi bi-pencil-square fs-1x"></i>
                        </a>
                        <a href="javascript:void(0);" onclick="pur_unavilable('.$row->id.')" class="btn btn-sm btn-danger btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <i class="bi bi bi-x-circle-fill fs-1x"></i>
                        </a>
                    </div>';
                   
                    
                    return $actions;
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                        $search = $request->get('search');
                        
                        $instance->whereHas('getprod', function($q) use ($search) {
                            $q->where(function($query) use ($search) {
                                $query->where('product_name_en', 'LIKE', "%$search%")
                                    ->orWhere('product_name', 'LIKE', "%$search%");
                            });
                        });
                    }
                })
                // ->filter(function ($instance) use ($request) {
                    
                //     if (!empty($request->get('search'))) {
                //         $instance->whereHas('getprod', function($q) use($request) {
                //             $search = $request->get('search');
                //             $q->where('product_name_en', 'LIKE', "%$search%")
                //             // ->orWhere('sell_price', 'LIKE', "%$search%")
                //             ->orWhere('product_name', 'LIKE', "%$search%");
                //         });
                //     }
                // })
                ->rawColumns(['name_ar','quantity','sell_price','reqquantity','factory_name','balance'
                ,'created_at','note','status','checkbox','actions'
                ])
                ->make(true);
        }
        return view('admin.pur_request.index');
    }

    public function show($id)
    {
        $data = Pur_request::find($id);
        return view('admin.pur_request.show', compact('data'));
    }

    public function create()
    {
        return view('admin.pur_request.create');
    }

    public function store(Request $request)
    {
        $rule = [
            'name_en' => 'required|string',
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
        $row = Pur_request::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'note' => $request->note,
            'status' => $request->status ?? 0,
        ]);
        return redirect('admin/pur_requests')->with('message', 'Added successfully')->with('status', 'success');
    }
    public function storemodel(Request $request)
    {
        $rule = [
            'name_en' => 'required|string',
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
        $row = Pur_request::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'note' => $request->note,
            'status' => $request->status ?? 0,
        ]);
        return redirect()->back()->with('message', 'Added successfully')->with('status', 'success');
    }
    public function edit($id)
    {
        $data = Pur_request::find($id);
        return view('admin.pur_request.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $rule = [
            'name_en' => 'required|string',
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        } 
        $data = Pur_request::find($request->id);
        $data->update([
            'emp_id' => Auth::guard('admin')->user()->id,
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'note' => $request->note,
            'status' => $request->status ?? 0,
        ]);

        return redirect('admin/pur_requests')->with('message', 'Modified successfully')->with('status', 'success');
    }

    public function destroy(Request $request)
    {   

        try{
            Pur_request::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'error']);
        }
        return response()->json(['message' => 'success']);

    }
    public function updaterequest(Request $request)
    {   
        Artisan::call('optimize:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        $dataallpur = All_pur_import::where('status_request', 0)
            ->select(['id', 'product_id', 'quantity'])
            ->get();
            
        $datastreq = Store_pur_request::where('status_request', 0)
            ->select(['id', 'pro_prod_id', 'quantity'])
            ->get();

        // Combine and transform the collections
        $combined = $dataallpur->map(function ($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'quantity' => (int)$item->quantity,
                'table' => '0' // 0 for all_pur_imports
            ];
        })->concat($datastreq->map(function ($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->pro_prod_id,
                'quantity' => (int)$item->quantity,
                'table' => '1' // 1 for store_pur_requests
            ];
        }));

        $summedQuantities = $combined->groupBy('product_id')->map(function ($group, $productId) {
            return [
                'product_id' => $productId,
                'total_quantity' => $group->sum('quantity'),
                'sources' => $group->map(function ($item) {
                    return [
                        'id' => $item['id'],
                        'table' => $item['table']
                    ];
                })->toArray()
            ];
        })->values();

        $data = Pur_request::where('status_pur', 0)->get();
        $results = [];

        foreach($summedQuantities as $item) {
            $oldItems = $data->whereIn('status', [0, 6])
                            ->where('pro_prod_id', $item['product_id']);
            
            $totalExistingQuantity = $oldItems->sum('quantity');
            $totalNeededQuantity = $item['total_quantity'];
            
            $results[] = [
                'product_id' => $item['product_id'],
                'total_quantity' => $totalNeededQuantity,
                'sources' => $item['sources'],
                'existing_requests' => $oldItems->values()->toArray()
            ];

            if ($oldItems->isNotEmpty()) {
                if ($totalExistingQuantity < $totalNeededQuantity) {
                    // Update existing requests to status 8
                    $oldItems->each(function ($oldItem) {
                        $oldItem->update(['status' => 8]);
                    });
                    
                    // Create new request
                    Pur_request::create([
                        'pro_emp_code' => Auth::guard('admin')->user()->id,
                        'table_name_id' => json_encode($item['sources']), // Fixed typo: json_encode
                        'pro_prod_id' => $item['product_id'],
                        'quantity' => $totalNeededQuantity,
                        'status' => 0,
                        'status_pur' => 0,
                    ]);
                }
                // No action needed if existing quantity is sufficient
            } else {
                // Create new request if no existing requests
                Pur_request::create([
                    'pro_emp_code' => Auth::guard('admin')->user()->id,
                    'table_name_id' => json_encode($item['sources']), // Fixed typo: json_encode
                    'pro_prod_id' => $item['product_id'],
                    'quantity' => $totalNeededQuantity,
                    'status' => 0,
                    'status_pur' => 0,
                ]);
            }
        }
        // dd($results);
        // Return or process the results
        // return $results;
        return redirect('/admin')
        // ->route('admin.pur_requests.index')
        ->with('message', 'Modified successfully')->with('status', 'success');

    }
    // public function pur_done($id,$suppl_id)
    // {
    //     $databefor = Pur_request::find($id);

    //     if (!$databefor) {
    //         return response()->json(['status' => 'error', 'message' => 'Request not found.'], 404);
    //     }
    //     // Validate the structure first
    //     $databeforreq = json_decode($databefor->table_name_id ?? '[]', true);

    //     if (!is_array($databeforreq)) {
    //         throw new \RuntimeException('Invalid table_name_id JSON format');
    //     }

    //     foreach($databeforreq as $item) {
    //         if (!isset($item['table'], $item['id'])) {
    //             continue; // Skip invalid items
    //         }
            
    //         if ($item['table'] === '0') {
    //             All_pur_import::where('id', $item['id'])
    //                 ->update(['status_request' => 1]);
    //         } elseif($item['table'] === '1') {
    //             Store_pur_request::where('id', $item['id'])
    //                 ->update(['status_request' => 1]);
    //         }
    //     }
    //     $databefor->update([
    //         'status_pur' => 1, //0 =  Pending - 1 = done - 2 = some_done - 3 = cancell_all
    //         'status' => 1,//0 =  Pending - 1 = Requested - 2 = Arrived at the pharmacy - 3 = Cancelled - 4 = Executed - 5 = Cancel the execution - 6 = import purshase - 7 = done - 8 = updated
    //     ]);
    //      Pur_trans::create([
    //             'pro_emp_code' => Auth::guard('admin')->user()->id,
    //             'id_in_pur_requests' => $databefor->id,
    //             'pro_prod_id' => $databefor->pro_prod_id ?? null,
    //             'note' => $databefor->note ?? null,
    //             'quantity' => $databefor->quantity ?? null,
    //             'type_action' => 0,//0 = done_pur - 1 = unavilable - 2 = cancell_pur - 3 = some_pur - 4 = udatequnt
    //             'quantity_befor' => $databefor->quantity ?? null,
    //             'quantity_after' => $databefor->quantity ?? null,
    //             'status' => $databefor->status ?? 0,
                
    //         ]);

    //     // Return response *after* the loop.
    //     return response()->json(['status' => 'success', 'message' => 'All relevant requests processed successfully.']);
    // }
    public function pur_done($id, $suppl_id)
    {
        DB::beginTransaction();
        
        try {
            $databefor = Pur_request::find($id);
            
            if (!$databefor) {
                return response()->json(['status' => 'error', 'message' => 'Request not found.'], 404);
            }

            // Validate and process the table_name_id JSON
            $this->processTableNameId($databefor->table_name_id);

            // Update the main request
            $databefor->update([
                'status_pur' => 1, // 0 = Pending, 1 = done, 2 = some_done, 3 = cancell_all
                'status' => 1,      // 0 = Pending, 1 = Requested, etc.
            ]);

            // Create transaction record
            $this->createPurTransaction($databefor);

            DB::commit();

            return response()->json([
                'status' => 'success', 
                'message' => 'All relevant requests processed successfully.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Purchase completion failed: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process requests: ' . $e->getMessage()
            ], 500);
        }
    }

    protected function processTableNameId($tableNameId)
    {
        $databeforreq = json_decode($tableNameId ?? '[]', true);

        if (!is_array($databeforreq)) {
            throw new \RuntimeException('Invalid table_name_id JSON format');
        }

        $allPurImportIds = [];
        $storePurRequestIds = [];

        foreach ($databeforreq as $item) {
            if (!isset($item['table'], $item['id'])) {
                continue;
            }

            match ($item['table']) {
                '0' => $allPurImportIds[] = $item['id'],
                '1' => $storePurRequestIds[] = $item['id'],
                default => null,
            };
        }

        // Bulk updates for better performance
        if (!empty($allPurImportIds)) {
            All_pur_import::whereIn('id', $allPurImportIds)
                ->update(['status_request' => 1]);
        }

        if (!empty($storePurRequestIds)) {
            Store_pur_request::whereIn('id', $storePurRequestIds)
                ->update([
                    'status_request' => 1,
                    'status' => 1,//0 =  Pending - 1 = Requested - 2 = Arrived at the pharmacy - 3 = Cancelled - 4 = Executed - 5 = Cancel the execution
                ]);
        }
    }

    protected function createPurTransaction(Pur_request $purRequest)
    {
        return Pur_trans::create([
            'pro_emp_code' => Auth::guard('admin')->user()->id,
            'id_in_pur_requests' => $purRequest->id,
            'pro_prod_id' => $purRequest->pro_prod_id,
            'note' => $purRequest->note,
            'quantity' => $purRequest->quantity,
            'type_action' => 0, // 0 = done_pur
            'quantity_befor' => $purRequest->quantity ?? null,
            'quantity_after' => $purRequest->quantity ?? null,
            'status' => $purRequest->status ?? 0,
        ]);
    }
    public function pur_unavilable($id,$suppl_id)
    {
       
        $data = Pur_request::find($id);

        $rowupdate = Pur_trans::create([
            'pro_emp_code' => Auth::guard('admin')->user()->id,
            'id_in_pur_requests' => $data->id,
            'pro_prod_id' => $data->pro_prod_id,
            'note' => $data->note,
            'quantity' => $data->quantity,
            'type_action' => 1, //0 = done_pur - 1 = unavilable - 2 = cancell_pur - 3 = some_pur - 4 = udatequnt
            'quantity_befor' => $data->quantity ?? null,
            'quantity_after' => $data->quantity ?? null,
            'status' => $data->status ?? 0,
            ]);
        return response()->json(['status' => 'success', 'message' => 'Modified successfully']);

       
    }
}
