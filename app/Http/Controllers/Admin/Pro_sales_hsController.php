<?php

namespace App\Http\Controllers\Admin;
set_time_limit(3600);
ini_set('max_execution_time', 4800);
ini_set('memory_limit', '4096M');
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Pro_sales_h;
use \Yajra\Datatables\Datatables;
use Rap2hpoutre\FastExcel\FastExcel;
use Spatie\Permission\Models\Role;

use Validator;
use Auth;
class Pro_sales_hsController extends Controller
{
//     public function index(Request $request)
    // {
    //     set_time_limit(3600);
    //     ini_set('max_execution_time', 4800);
    //     ini_set('memory_limit', '4096M');

    //     if ($request->ajax()) {
    //         $data = Pro_sales_h::query()
    //             ->with(['getcust', 'getstore']); // Eager load relationships

    //         return DataTables::eloquent($data)
    //             ->orderColumn('sales_id', 'sales_id $1') // SQL Server specific syntax
    //             ->addColumn('checkbox', function($row) {
    //                 return '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
    //                     <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
    //                 </div>';
    //             })
    //             ->addColumn('name_ar', function($row) {
    //                 return '<div class="d-flex flex-column">
    //                     <a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->inv_no.'</a>
    //                 </div>';
    //             })
    //             ->addColumn('inv_total', function($row) {
    //                 return $row->inv_total;
    //             })
    //             ->addColumn('date', function($row) {
    //                 return $row->date;
    //             })
    //             ->addColumn('cust_id', function($row) {
    //                 return $row->getcust->cust_name ?? '<span class="text-info">'.trans('lang.without').'</span>';
    //             })
    //             ->addColumn('store_id', function($row) {
    //                 return $row->getstore->store_name ?? '<span class="text-info">'.trans('lang.without').'</span>';
    //             })
    //             ->filter(function ($query) use ($request) {
    //                 if (!empty($request->search['value'])) {
    //                     $search = $request->search['value'];
    //                     $query->where(function($q) use ($search) {
    //                         $q->where('inv_no', 'LIKE', "%$search%")
    //                           ->orWhere('inv_total', 'LIKE', "%$search%")
    //                           ->orWhere('date', 'LIKE', "%$search%")
    //                           ->orWhereHas('getcust', function($q) use ($search) {
    //                               $q->where('cust_name', 'LIKE', "%$search%");
    //                           })
    //                           ->orWhereHas('getstore', function($q) use ($search) {
    //                               $q->where('store_name', 'LIKE', "%$search%");
    //                           });
    //                     });
    //                 }
    //             })
    //             ->rawColumns(['checkbox', 'name_ar', 'cust_id', 'store_id'])
    //             ->toJson(); // Use either make(true) OR toJson(), not both
    //     }

    //     return view('admin.pro_sales_h.index');
    // }
    public function index(Request $request)
    {
        set_time_limit(3600);
        ini_set('max_execution_time', 4800);
        ini_set('memory_limit', '4096M');
        
        // $data = Pro_sales_h::take(100)->get();
        if ($request->ajax()) {
            $data = Pro_sales_h::with(['getcust']);

            // $data = $data->sortby('sales_id', 'DESC');
            return Datatables::of($data)
            ->order(function ($query) {
                    $query->orderBy('inv_no', 'DESC');
                })
            ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name_ar', function($row){
                    $name_ar = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->inv_no.'</a></div>';
                    // $name_ar .= '<br><span>'.$row->product_name.'</span>';
                    return $name_ar;
                })
                
                ->addColumn('inv_total', function($row){
                    $inv_total = $row->inv_total;
                    return $inv_total;
                })
                ->addColumn('date', function($row){
                    $date = $row->date;
                    return $date;
                })
                ->addColumn('cust_id', function($row){
                    $cust_id = $row->getcust->cust_name ?? '<span class="text-info">'.trans('lang.without').'</span>';
                    return $cust_id;
                })
                ->addColumn('store_id', function($row){
                    $store_id = $row->getstore->store_name ?? '<span class="text-info">'.trans('lang.without').'</span>';
                    return $store_id;
                })
                
                ->addColumn('kind', function($row){// 1 = cash - 2 = delayed - 3 = delivery - 4 = visa 
                    $kind_t = $row->kind;
                    if ($kind_t == 1) {
                        $kind = '<span class="text-success">'.trans('lang.cash').'</span>';
                    } elseif ($kind_t == 2) {
                        $kind = '<span class="text-danger">'.trans('lang.delayed').'</span>';
                    } elseif ($kind_t == 3) {
                        $kind = '<span class="text-info">'.trans('lang.delivry').'</span>';
                    } elseif ($kind_t == 4) {
                        $kind = '<span class="text-dark">'.trans('lang.visa').'</span>';
                    } else {
                        $kind = '<span class="text-info">'.trans('lang.without').'</span>';
                    }
                    return $kind;
                })
                // ->addColumn('actions', function($row){
                //     $actions = '<div class="ms-2">
                //                 <a href="'.route('admin.pro_sales_hs.show', $row->id).'" class="btn btn-sm btn-icon btn-warning btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                //                     <i class="bi bi-eye-fill fs-1x"></i>
                //                 </a>
                //                 <a href="'.route('admin.pro_sales_hs.edit', $row->id).'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
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
                ->rawColumns(['name_ar','inv_total','cust_id','date','kind','store_id','checkbox','actions'])
                ->make(true);
        }
        return view('admin.pro_sales_h.index');
    }

    public function create()
    {
        return view('admin.pro_sales_h.create');
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

        $row = Pro_sales_h::create([
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

        return redirect('admin/pro_sales_hs')->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    public function show($id)
    {
        $data = Pro_sales_h::find($id);
        return view('admin.pro_sales_h.show', compact('data'));
    }
    public function edit($id)
    {
        $data = Pro_sales_h::find($id);
        return view('admin.pro_sales_h.edit', compact('data'));
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
        $data = Pro_sales_h::find($request->id);
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

        return redirect('admin/pro_sales_hs')->with('message', 'تم التعديل بنجاح')->with('status', 'success');
    }

    public function destroy(Request $request)
    {
        try{
            Pro_sales_h::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'error']);
        }
        return response()->json(['message' => 'success']);
    }
    

}
