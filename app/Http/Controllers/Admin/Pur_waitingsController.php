<?php

namespace App\Http\Controllers\Admin;
set_time_limit(3600);
ini_set('max_execution_time', 4800);
ini_set('memory_limit', '4096M');
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Pur_waiting;
use App\Models\Pur_request;
use App\Models\Pro_product;
use App\Models\Store_pur_request;
use App\Models\All_pur_import;
use App\Models\Pro_purchase_details;
use \Yajra\Datatables\Datatables;
use Rap2hpoutre\FastExcel\FastExcel;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Carbon;
use App\Services\DatabaseService;


use Validator;
use Auth;
class Pur_waitingsController extends Controller
{
    public function index(Request $request)
    {
        // Run the update process silently (remove if not needed)
        try {
            $this->update_pur();
        } catch (\Exception $e) {
            \Log::error('Failed to run update_pur in index: ' . $e->getMessage());
        }
        if ($request->ajax()) {
            $data = Pur_waiting::query();

            $data = $data->whereDate('created_at', '>=', Carbon::parse($request->get('from_date'))->startOfDay());
            $data = $data->whereDate('created_at','<=', Carbon::parse($request->get('to_date'))->endOfDay());
            $data = $data->orderBy('id', 'DESC');
            return Datatables::of($data)

                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name_ar', function($row){
                    $name_ar = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->getpur_request->getprod->product_name_en.'</a></div>';
                    // $name_ar .= '<br><span>'.$row->product_name.'</span>';
                    return $name_ar;
                })
                ->addColumn('quantity', function($row){

                    $quantity = '<span>'.$row->quantity ?? ''.'</span>';
                    return $quantity;
                })
                ->addColumn('pro_vendor_id', function($row){
                    $namevendor = $row->getpur_trans->getvendor->vendor_name ?? 'Unknoun';
                    $pro_vendor_id = '<span>'.$namevendor.'</span>';
                    return $pro_vendor_id;
                })
                ->addColumn('created_at', function($row){
                    $created_at = '<span>'.$row->created_at.'</span>';
                    return $created_at;
                })
                ->addColumn('purchase_date', function($row){
                    $date_pur = $row->getpurchase_d->getpurchase_h->purchase_date ?? 'Unknoun';
                    $purchase_date = '<span>'.$date_pur.'</span>';
                    return $purchase_date;
                })
                ->addColumn('status_pur', function($row){ // 0 =  waiting - 1 = done - 2 = some_done - 3 = cancell_all
                    $status_pur = $row->status_pur ?? '<span class="text-info">'.trans('lang.without').'</span>';
                    // $statusmangeraprove = $row->statusmangeraprove; // 0 = waitting - 1 = approved - 2 = rejected - 3 = delayed (manger)
                    
                    switch ($status_pur) {
                        case '0':
                            return trans('lang.waiting'). ' '. trans('lang.invoice'). ' '. trans('lang.buying');
                        case '1':
                            return '<span class="text-success">' . 
                                    ($row->getpurchase_d->getpurchase_h->getvendor->vendor_name ?? 'Unknown') .
                                    ' <span class="text-info">(' . ($row->getpurchase_d->amount ?? '0') . ')</span>' .
                                    '</span>';
                            // return '<span class="text-success">'.$row->getpurchase_d->getpurchase_h->getvendor->vendor_name .'('.$row->getpurchase_d->amount.')'. ?? 'Unknoun'.'</span>';
                        case '2':
                            return '<span class="text-danger">'.trans('lang.approved') .' '. trans('lang.buying').'</span>';
                        case '3':
                            return trans('lang.delay');
                        
                        default:
                            return $status_pur; // Fallback in case of unexpected value
                    }
                    
                })
                ->addColumn('address3', function($row){
                    $address3 = $row->cust_addr3 ?? '<span class="text-info">'.trans('lang.without').'</span>';
                    return $address3;
                })
                ->addColumn('address4', function($row){
                    $address4 = $row->cust_addr4 ?? '<span class="text-info">'.trans('lang.without').'</span>';
                    return $address4;
                })
                ->addColumn('active', function($row){
                    if($row->active == 1) {
                        $active = '<div class="badge badge-light-success fw-bold">مقعل</div>';
                    } else {
                        $active = '<div class="badge badge-light-danger fw-bold">غير مفعل</div>';
                    }
                    return $active;
                })
                // ->addColumn('actions', function($row){
                //     $actions = '<div class="ms-2">
                //                 <a href="'.route('admin.pur_waitings.show', $row->id).'" class="btn btn-sm btn-icon btn-warning btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                //                     <i class="bi bi-eye-fill fs-1x"></i>
                //                 </a>
                //                 <a href="'.route('admin.pur_waitings.edit', $row->id).'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
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
                            $w->orWhere('cust_name', 'LIKE', "%$search%")
                            ->orWhere('cust_tel1', 'LIKE', "%$search%")
                            ->orWhere('cust_tel2', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['name_ar','quantity','pro_vendor_id','created_at','purchase_date','status_pur','address3','address4','active','checkbox','actions'])
                ->make(true);
        }
        return view('admin.pur_waiting.index');
    }

    public function create()
    {
        return view('admin.pur_waiting.create');
    }

    public function store(Request $request)
    {
        $rule = [
            'pro_start_id' => 'required|string',
            'pro_prod_id' => 'required|string',
            'quantity' => 'required',
            'name_cust' =>'required',
            'phone_cust' =>'required',
            
        ];
        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');}

        $row = Pur_waiting::create([
            'pro_emp_code' => Auth::guard('admin')->user()->id,
            'pro_start_id' => $request->pro_start_id,
            'pro_prod_id' => $request->pro_prod_id,
            'quantity' => $request->quantity,
            'name_cust' => $request->name_cust,
            'phone_cust' => $request->phone_cust,
            'note' => $request->note,
            'status' => 0,//0 =  Pending - 1 = Requested - 2 = Arrived at the store - 3 = Cancelled - 4 = Executed - 5 = Cancel the execution
            'type_request' => $request->type_request,// 0 = cash - 1 = phone - 2 = whatsapp - 3 = page - 4 = instagram 
            'balance_req' => $request->balance_req ?? 0,
            'status_request' => $request->status_request ?? 0,// 0 = waitting - 1 = pur_drug_requests
            
            
        ]);
        if($request->hasFile('attach') && $request->file('attach')->isValid()){
            $row->addMediaFromRequest('attach')->toMediaCollection('profile');
        }
        // $role = Role::find($request->role_id);
        // $row->syncRoles([]);
        // $row->assignRole($role->name);

        return redirect()->back()->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    public function show($id)
    {
        $data = Pur_waiting::find($id);
        return view('admin.pur_waiting.show', compact('data'));
    }
    public function edit($id)
    {
        $data = Pur_waiting::find($id);
        return view('admin.pur_waiting.edit', compact('data'));
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
        $data = Pur_waiting::find($request->id);
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

        return redirect('admin/pur_waitings')->with('message', 'تم التعديل بنجاح')->with('status', 'success');
    }

    public function destroy(Request $request)
    {
        try{
            Pur_waiting::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'error']);
        }
        return response()->json(['message' => 'success']);
    }
    public function ProdName(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q ;
            $data = Pro_product::select("product_id","product_name_en","product_name")
            ->where('product_name_en','LIKE',"%$search%")
            ->orWhere('product_name','LIKE',"%$search%")->get();
        }
        return response()->json($data);
    }
    
   public function update_pur()
    {
        try {
            $purWaitings = Pur_waiting::query()
                ->where('status_pur', 0)
                ->whereNull('id_in_purchase_details')
                ->whereDate('created_at', '>=', Carbon::now()->subDays(15))
                ->with(['getpur_trans'])
                ->get();

            $results = [
                'updated' => 0,
                'failed' => [],
                'skipped' => 0
            ];
            foreach ($purWaitings as $item) {
                try {
                    if (!$item->getpur_trans) {
                        $results['failed'][] = [
                            'id' => $item->id,
                            'error' => 'No related pur_trans data'
                        ];
                        $results['skipped']++;
                        continue;
                    }

                    $purchaseDetail = Pro_purchase_details::query()
                    ->where('product_id', $item->getpur_trans->pro_prod_id)
                    ->whereHas('getpurchase_h', function($query) use ($item) {
                        $query->where('vendor_id', $item->getpur_trans->pro_vendor_id)
                                ->whereDate('purchase_date', '>=', Carbon::parse($item->created_at));
                        })
                        ->first();

                    if ($purchaseDetail) {
                        $item->update([
                            'id_in_purchase_details' => $purchaseDetail->id,
                            'status_pur' => 1,
                        ]);
                        $updat = Pur_request::where('id', $item->pur_requests_id)->first();
                        $updat->update([
                            'status' => 2,//0 =  Pending - 1 = Requested - 2 = Arrived at the store - 3 = Cancelled - 4 = Executed - 5 = Cancel the execution - 6 = import purshase - 7 = done - 8 = updated
                        ]);
                        $this->processTableNameId($updat->table_name_id);
                        $results['updated']++;
                    } else {
                        $results['failed'][] = [
                            'id' => $item->id,
                            'error' => 'No matching purchase detail found'
                        ];
                        $results['skipped']++;
                    }
                } catch (\Exception $e) {
                    $results['failed'][] = [
                        'id' => $item->id,
                        'error' => $e->getMessage()
                    ];
                    $results['skipped']++;
                }
            }

            \Log::info('Purchase update results', $results);
            return true;

        } catch (\Exception $e) {
            \Log::error('Failed to run update_pur: ' . $e->getMessage());
            return false;
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
                    'status' => 2,//0 =  Pending - 1 = Requested - 2 = Arrived at the store - 3 = Cancelled - 4 = Executed - 5 = Cancel the execution
                ]);
        }
    }
}
