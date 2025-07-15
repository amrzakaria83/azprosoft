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
        set_time_limit(3600);
        ini_set('max_execution_time', 4800);
        ini_set('memory_limit', '4096M');
        // $data = Store_pur_request::take(100)->get();
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
                    $name_ar = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->cust_name.'</a></div>';
                    // $name_ar .= '<br><span>'.$row->product_name.'</span>';
                    return $name_ar;
                })
                ->addColumn('phone', function($row){
                    $phone = $row->cust_tel1 ?? '';
                    $phone .= '<br><span>'.$row->cust_tel2 ?? ''.'</span>';
                    return $phone;
                })
                ->addColumn('address', function($row){
                    $address = $row->cust_addr;
                    return $address;
                })
                ->addColumn('cust_current_money', function($row){
                    $cust_current_money = $row->cust_current_money;
                    return $cust_current_money;
                })
                ->addColumn('address1', function($row){
                    $address1 = $row->cust_addr1 ?? '<span class="text-info">'.trans('lang.without').'</span>';
                    return $address1;
                })
                ->addColumn('address2', function($row){
                    $address2 = $row->cust_addr2 ?? '<span class="text-info">'.trans('lang.without').'</span>';
                    return $address2;
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
                    

                    if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('cust_name', 'LIKE', "%$search%")
                            ->orWhere('cust_tel1', 'LIKE', "%$search%")
                            ->orWhere('cust_tel2', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['name_ar','phone','address','cust_current_money','address1','address2','address3','address4','active','checkbox','actions'])
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
        $role = Role::find($request->role_id);
        $row->syncRoles([]);
        $row->assignRole($role->name);

        return redirect('admin/store_pur_requests')->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
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
