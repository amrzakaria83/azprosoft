<?php

namespace App\Http\Controllers\Admin;
set_time_limit(3600);
ini_set('max_execution_time', 4800);
ini_set('memory_limit', '4096M');
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Pro_purchase_details;
use \Yajra\Datatables\Datatables;
use Rap2hpoutre\FastExcel\FastExcel;
use Spatie\Permission\Models\Role;

use Validator;
use Auth;
class Pro_purchase_detailssController extends Controller
{

    public function index(Request $request)
    {
        set_time_limit(3600);
        ini_set('max_execution_time', 4800);
        ini_set('memory_limit', '4096M');
        
        if ($request->ajax()) {
            $data = Pro_purchase_details::with(['getprod','getpurchase_h']);

            return Datatables::of($data)
                ->order(function ($query) {
                        $query->orderBy('id', 'DESC');
                    })
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('product_id', function($row){
                    $product_id = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'
                    .$row->getprod->product_name_en ?? $row->getprod->product_name.'</a></div>';
                    return $product_id;
                })
                
                ->addColumn('expire_date', function($row){
                    // $expire_date = $row->expire_date ?? 'No expire';
                    $expire_date = $row->expire_date ? date('d-m-y', strtotime($row->expire_date)) : 'No expire';
                    return $expire_date;
                })
                ->addColumn('amount', function($row){
                    $amount = number_format($row->amount, 2);
                    return $amount;
                })
                ->addColumn('bouns', function($row){
                    $v_bouns = $row->bouns;
                    if ($v_bouns > 0) {

                        $bouns = '<span class="text-info">'.number_format($row->bouns, 2).'</span>';
                    } else {
                        $bouns = 'No';
                    }
                    return $bouns;
                })
                ->addColumn('sell_price', function($row){
                    $sell_price = number_format($row->sell_price, 2);
                    return $sell_price;
                })
                ->addColumn('buy_price', function($row){
                    $buy_price = number_format($row->buy_price, 2);
                    return $buy_price;
                })
                ->addColumn('profit', function($row){
                    $profit = '<span class="text-info">'.number_format($row->profit, 2).'</span>';
                    return $profit;
                })
                ->addColumn('tax', function($row){
                    $tax = number_format($row->tax, 2);
                    return $tax;
                })
                ->addColumn('purchase_id', function($row){
                    $purchase_id = $row->getpurchase_h->getvendor->vendor_name ?? $row->getpurchase_h->getvendor->vendor_name_en ?? 'No';
                    return $purchase_id;
                })
                ->addColumn('valued_date', function($row){
                    $valued_date = $row->getpurchase_h->purchase_date ?? 'No';
                    return $valued_date;
                })
                ->addColumn('buy_tax', function($row){
                    $buy_tax = number_format($row->buy_tax, 2);
                    return $buy_tax;
                })
                ->addColumn('total_buy', function($row){
                    $total_buy = number_format($row->total_buy, 2);
                    return $total_buy;
                })
                ->filter(function ($instance) use ($request) {
                    // if ($request->get('is_active') == 0 || $request->get('is_active') == 1) {
                    //     $instance->where('is_active', $request->get('is_active'));
                    // }
                    if (!empty($request->get('from_date')) || !empty($request->get('to_date'))) {
                        $instance->whereHas('getpurchase_h', function ($q) use ($request) {
                            if (!empty($request->get('from_date'))) {
                                $q->whereDate('purchase_date', '>=', $request->get('from_date'));
                            }
                            if (!empty($request->get('to_date'))) {
                                $q->whereDate('purchase_date', '<=', $request->get('to_date'));
                            }
                        });
                    }
                    if ($request->get('vendor_id') != null) {
                        $instance->whereHas('getpurchase_h.getvendor', function ($q) use ($request) {
                            $q->where('vendor_id', $request->get('vendor_id'));
                        });
                    }
                    if ($request->get('emp_id') != Null)
                    {
                    $instance->where(function ($query) use ($request) {
                        $query->where('emp_id', $request->get('emp_id'));
                    });
                    }
                    // Search logic
                    if (!empty($request->get('search'))) {
                        $search = $request->get('search'); // Define $search variable
                        $instance->whereHas('getprod', function ($q) use ($search) {
                            $q->where(function ($query) use ($search) {
                                $query->orWhere('product_name_en', 'LIKE', "%$search%")
                                      ->orWhere('product_name', 'LIKE', "%$search%")
                                      ->orWhere('product_id', 'LIKE', "%$search%"); // additional field
                            });
                        });
                    }
                    // if (!empty($request->get('search'))) {
                    //         $instance->where(function($w) use($request){
                    //         $search = $request->get('search');
                    //         $w->orWhere('product_id', 'LIKE', "%$search%")
                    //         ->orWhere('sell_price', 'LIKE', "%$search%")
                    //         ->orWhere('product_name', 'LIKE', "%$search%");
                    //     });
                    // }
                })
                ->rawColumns(['product_id','expire_date','amount','bouns','sell_price','buy_price','profit','tax','buy_tax','total_buy','store_id','purchase_id','valued_date','checkbox','actions'])
                ->make(true);
        }
        return view('admin.pro_purchase_d.index');
    }

    public function create()
    {
        return view('admin.pro_purchase_d.create');
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

        $row = Pro_purchase_details::create([
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

        return redirect('admin/pro_purchase_ds')->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    public function show($id)
    {
        $data = Pro_purchase_details::find($id);
        return view('admin.pro_purchase_d.show', compact('data'));
    }
    public function edit($id)
    {
        $data = Pro_purchase_details::find($id);
        return view('admin.pro_purchase_d.edit', compact('data'));
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
        $data = Pro_purchase_details::find($request->id);
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

        return redirect('admin/pro_purchase_ds')->with('message', 'تم التعديل بنجاح')->with('status', 'success');
    }

    public function destroy(Request $request)
    {
        try{
            Pro_purchase_details::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'error']);
        }
        return response()->json(['message' => 'success']);
    }
    

}
