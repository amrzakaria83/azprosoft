<?php

namespace App\Http\Controllers\Admin;
set_time_limit(3600);
ini_set('max_execution_time', 4800);
ini_set('memory_limit', '4096M');
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Pro_store_conv_h;
use \Yajra\Datatables\Datatables;
use Rap2hpoutre\FastExcel\FastExcel;
use Spatie\Permission\Models\Role;

use Validator;
use Auth;
class Pro_store_conv_hsController extends Controller
{

    public function index(Request $request)
    {
        set_time_limit(3600);
        ini_set('max_execution_time', 4800);
        ini_set('memory_limit', '4096M');
        
        if ($request->ajax()) {
            $data = Pro_store_conv_h::with(['getstorefrom','getemp_id_send']);

            return Datatables::of($data)
                ->order(function ($query) {
                        $query->orderBy('sales_id', 'DESC');
                    })
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->sales_id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('sales_id', function($row){
                    $sales_id = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->sales_id.'</a></div>';
                    return $sales_id;
                })
                ->addColumn('store_id', function($row){
                    $store_id = $row->getstorefrom->store_name;
                    return $store_id;
                })
                ->addColumn('date', function($row){
                    $date = $row->date;
                    return $date;
                })
                ->addColumn('inv_total', function($row){
                    $inv_total = number_format($row->inv_total, 2);
                    return $inv_total;
                })
                ->addColumn('to_store_id', function($row){
                    $to_store_id = $row->getstoreto->store_name ?? '<span class="text-info">'.trans('lang.without').'</span>';
                    return $to_store_id;
                })
                ->addColumn('emp_id', function($row){
                    $emp_id = $row->getemp_id_send->emp_name ?? $row->getemp_id_send->emp_name_en ?? '' ;
                    return $emp_id;
                })
                ->addColumn('r_emp_id', function($row){
                    $r_emp_id = $row->getemp_id_rece->emp_name ?? $row->getemp_id_rece->emp_name_en ?? '' ;
                    return $r_emp_id;
                })
                // ->addColumn('actions', function($row){
                //     $actions = '<div class="ms-2">
                //                 <a href="'.route('admin.pro_store_conv_hs.show', $row->id).'" class="btn btn-sm btn-icon btn-warning btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                //                     <i class="bi bi-eye-fill fs-1x"></i>
                //                 </a>
                //                 <a href="'.route('admin.pro_store_conv_hs.edit', $row->id).'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
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
                        $query->where('store_id', $request->get('store_id'));
                    });
                    }
                    if ($request->get('vendor_id') != Null)
                    {
                    $instance->where(function ($query) use ($request) {
                        $query->where('vendor_id', $request->get('vendor_id'));
                    });
                    }
                    if ($request->get('emp_id') != Null)
                    {
                    $instance->where(function ($query) use ($request) {
                        $query->where('emp_id', $request->get('emp_id'));
                    });
                    }

                    if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('sales_id', 'LIKE', "%$search%")
                            ->orWhere('sell_price', 'LIKE', "%$search%")
                            ->orWhere('product_name', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['sales_id','store_id','vendor_id','p_total_after','p_total','p_discount_p','purchase_date','emp_id','store_id','checkbox','actions'])
                ->make(true);
        }
        return view('admin.pro_store_conv_h.index');
    }

    public function create()
    {
        return view('admin.pro_store_conv_h.create');
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

        $row = Pro_store_conv_h::create([
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

        return redirect('admin/pro_store_conv_hs')->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    public function show($id)
    {
        $data = Pro_store_conv_h::find($id);
        return view('admin.pro_store_conv_h.show', compact('data'));
    }
    public function edit($id)
    {
        $data = Pro_store_conv_h::find($id);
        return view('admin.pro_store_conv_h.edit', compact('data'));
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
        $data = Pro_store_conv_h::find($request->id);
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

        return redirect('admin/pro_store_conv_hs')->with('message', 'تم التعديل بنجاح')->with('status', 'success');
    }

    public function destroy(Request $request)
    {
        try{
            Pro_store_conv_h::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'error']);
        }
        return response()->json(['message' => 'success']);
    }
    
    public function indexh_d(Request $request)
    {
        set_time_limit(3600);
        ini_set('max_execution_time', 4800);
        ini_set('memory_limit', '4096M');
        
        if ($request->ajax()) {
            $data = Pro_store_conv_h::with(['getstore','getvendor']);

            return Datatables::of($data)
                ->order(function ($query) {
                        $query->orderBy('purchase_serial', 'DESC');
                    })
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->purchase_serial.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('purchase_no', function($row){
                    $purchase_no = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->purchase_no.'</a></div>';
                    // $purchase_no .= '<br><span>'.$row->product_name.'</span>';
                    return $purchase_no;
                })
                
                ->addColumn('store_id', function($row){
                    $store_id = $row->getstore->store_name;
                    return $store_id;
                })
                ->addColumn('vendor_id', function($row){
                    $vendor_id = $row->getvendor->vendor_name ?? $row->getvendor->vendor_name_en ?? 'null';
                    return $vendor_id;
                })
                ->addColumn('p_total_after', function($row){
                    $p_total_after = number_format($row->p_total_after, 2);
                    return $p_total_after;
                })
                ->addColumn('p_total', function($row){
                    $p_total = number_format($row->p_total, 2);
                    return $p_total;
                })
                ->addColumn('p_discount_p', function($row){
                    $p_discount_p = number_format($row->p_discount_p, 3) ?? 0;
                    return $p_discount_p;
                })
                ->addColumn('store_id', function($row){
                    $store_id = $row->getstore->store_name ?? '<span class="text-info">'.trans('lang.without').'</span>';
                    return $store_id;
                })
                ->addColumn('purchase_date', function($row){
                    $purchase_date = $row->purchase_date;
                    return $purchase_date;
                })
                ->addColumn('emp_id', function($row){
                    $emp_id = $row->getemp_id->emp_name ?? $row->getemp_id->emp_name_en ;
                    return $emp_id;
                })
                // ->addColumn('actions', function($row){
                //     $actions = '<div class="ms-2">
                //                 <a href="'.route('admin.pro_store_conv_hs.show', $row->id).'" class="btn btn-sm btn-icon btn-warning btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                //                     <i class="bi bi-eye-fill fs-1x"></i>
                //                 </a>
                //                 <a href="'.route('admin.pro_store_conv_hs.edit', $row->id).'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
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
                        $query->where('store_id', $request->get('store_id'));
                    });
                    }
                    if ($request->get('vendor_id') != Null)
                    {
                    $instance->where(function ($query) use ($request) {
                        $query->where('vendor_id', $request->get('vendor_id'));
                    });
                    }
                    if ($request->get('emp_id') != Null)
                    {
                    $instance->where(function ($query) use ($request) {
                        $query->where('emp_id', $request->get('emp_id'));
                    });
                    }

                    if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('purchase_no', 'LIKE', "%$search%")
                            ->orWhere('sell_price', 'LIKE', "%$search%")
                            ->orWhere('product_name', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['purchase_no','store_id','vendor_id','p_total_after','p_total','p_discount_p','purchase_date','emp_id','store_id','checkbox','actions'])
                ->make(true);
        }
        return view('admin.pro_store_conv_h.indexh_d');
    }
    

}
