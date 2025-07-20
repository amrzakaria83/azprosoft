<?php

namespace App\Http\Controllers\Admin;
set_time_limit(3600);
ini_set('max_execution_time', 4800);
ini_set('memory_limit', '4096M');
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Store_pur_request;
use App\Models\Pro_product;
use \Yajra\Datatables\Datatables;
use Rap2hpoutre\FastExcel\FastExcel;
use Spatie\Permission\Models\Role;


use Validator;
use Auth;
class Store_pur_requestsController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Store_pur_request::query();
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
                    .$row->getprod->product_name_en. ' <span>('.$row->getprod->sell_price.')</span>'.
                    '</a></div>';
                    // $name_ar .= '<br><span>'.$row->product_name.'</span>';
                    return $name_ar;
                })
                ->addColumn('pro_start_id', function($row){
                    
                    $pro_start_id = '<span>'.$row->getstore->store_name ?? ''.'</span>';
                    return $pro_start_id;
                })
                ->addColumn('status', function($row){ //0 =  Pending - 1 = Requested - 2 = Arrived at the store - 3 = Cancelled - 4 = Executed - 5 = Cancel the execution
                    $status = $row->status ?? '<span class="text-info">'.trans('lang.without').'</span>';
                    switch ($status) {
                        case '0':
                            return '<span class="text-danger">'.trans('lang.waiting'). ' '. trans('lang.buying').'</span>';
                        case '1':
                            return '<span class="text-info">'.trans('lang.requested_done').'</span>';
                        case '2':
                            return '<span class="text-success">'.trans('lang.arrived_store') .'</span>';
                        case '3':
                            return trans('lang.delay');
                        
                        default:
                            return $status; // Fallback in case of unexpected value
                    }
                    
                })
                ->addColumn('name_cust', function($row){
                    $name_cust = $row->name_cust;
                    return $name_cust;
                })
                ->addColumn('phone_cust', function($row){
                    $phone_cust = $row->phone_cust;
                    return $phone_cust;
                })
                ->addColumn('quantity', function($row){
                    $quantity = $row->quantity;
                    return $quantity;
                })
                ->addColumn('type_request', function($row){ // 0 = cash - 1 = phone - 2 = whatsapp - 3 = page - 4 = instagram
                    $type_request = $row->type_request ?? '<span class="text-info">'.trans('lang.without').'</span>';
                    switch ($type_request) {
                        case '0':
                            return '<span class="text-danger">Cash</span>';
                        case '1':
                            return '<span class="text-info">'.trans('lang.phone').'</span>';
                        case '2':
                            return '<span class="text-success">whatsapp</span>';
                        case '3':
                            return '<span class="text-success">page</span>';
                         case '4':
                            return '<span class="text-success">instagram</span>';
                        
                        default:
                            return $type_request; // Fallback in case of unexpected value
                    }
                    
                })
                ->addColumn('pro_emp_code', function($row){
                    $pro_emp_code = $row->getemp->emp_name ?? 'Unknowen';
                    return $pro_emp_code;
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
                //                 <a href="'.route('admin.store_pur_requests.show', $row->id).'" class="btn btn-sm btn-icon btn-warning btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                //                     <i class="bi bi-eye-fill fs-1x"></i>
                //                 </a>
                //                 <a href="'.route('admin.store_pur_requests.edit', $row->id).'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                //                     <i class="bi bi-pencil-square fs-1x"></i>
                //                 </a>
                                
                //             </div>';
                //     return $actions;
                // })
                ->filter(function ($instance) use ($request) {
                    // if ($request->get('is_active') == 0 || $request->get('is_active') == 1) {
                    //     $instance->where('is_active', $request->get('is_active'));
                    // }
                    if ($request->get('store_id') != Null)
                    {
                    $instance->where(function ($query) use ($request) {
                        $query->where('pro_start_id', $request->get('store_id'));
                    });
                    }

                    if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('cust_name', 'LIKE', "%$search%")
                            ->orWhere('cust_tel1', 'LIKE', "%$search%")
                            ->orWhere('cust_tel2', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['name_ar','pro_start_id','status','name_cust','phone_cust','quantity','type_request','pro_emp_code','active','checkbox','actions'])
                ->make(true);
        }
        return view('admin.store_pur_request.index');
    }

    public function create()
    {
        return view('admin.store_pur_request.create');
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

        $row = Store_pur_request::create([
            'pro_emp_code' => Auth::guard('admin')->user()->id,
            'pro_start_id' => $request->pro_start_id,
            'pro_prod_id' => $request->pro_prod_id,
            'quantity' => $request->quantity,
            'name_cust' => $request->name_cust,
            'phone_cust' => $request->phone_cust,
            'note' => $request->note,
            'status' => 0,//0 =  Pending - 1 = Requested - 2 = Arrived at the pharmacy - 3 = Cancelled - 4 = Executed - 5 = Cancel the execution
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
        $data = Store_pur_request::find($id);
        return view('admin.store_pur_request.show', compact('data'));
    }
    public function edit($id)
    {
        $data = Store_pur_request::find($id);
        return view('admin.store_pur_request.edit', compact('data'));
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
        $data = Store_pur_request::find($request->id);
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

        return redirect('admin/store_pur_requests')->with('message', 'تم التعديل بنجاح')->with('status', 'success');
    }

    public function destroy(Request $request)
    {
        try{
            Store_pur_request::whereIn('id',$request->id)->delete();
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
    

}
