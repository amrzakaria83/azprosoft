<?php

namespace App\Http\Controllers\Admin;
set_time_limit(3600);
ini_set('max_execution_time', 4800);
ini_set('memory_limit', '4096M');
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Pro_emp_att;
use \Yajra\Datatables\Datatables;
use Rap2hpoutre\FastExcel\FastExcel;
use Spatie\Permission\Models\Role;

use Illuminate\Support\Carbon;

use Validator;
use Auth;

class Pro_emp_attsController extends Controller
{
    // public function index(Request $request)
    // {
    //     set_time_limit(3600);
    //     ini_set('max_execution_time', 4800);
    //     ini_set('memory_limit', '4096M');
    //     // $data = Pro_emp_att::take(100)->get();
    //     if ($request->ajax()) {
    //         $data = Pro_emp_att::query();

            
            

    //         return Datatables::of($data)

    //             ->addColumn('checkbox', function($row){
    //                 $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
    //                                 <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
    //                             </div>';
    //                 return $checkbox;
    //             })
    //             ->addColumn('name_ar', function($row){
    //                 $name_ar = $row->getemangeremp->emp_name ?? ($row->getemangeremp->emp_name_en ?? '<span class="text-info">'.trans('lang.without').'</span>');
    //                 // $name_ar = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">' . ($row->getemangeremp->emp_name_en ? $row->getemangeremp->emp_name_en : 0) . '</a></div>';
    //                 // $name_ar .= '<br><span>'.$row->product_name.'</span>';
    //                 return $name_ar;
    //             })
    //             ->addColumn('date', function($row){
    //                 $date = $row->date ?? '';
    //                 return $date;
    //             })
    //             ->addColumn('type', function($row) {
    //                 $type = $row->type ?? '';
                    
    //                 if ($type == 'out') {
    //                     // Find the previous 'in' record for the same employee
    //                     $previousIn = Pro_emp_att::where('emp_id', $row->emp_id)
    //                         ->where('type', 'in')
    //                         ->where('date', '<=', $row->date)
    //                         ->orderBy('date', 'desc')
    //                         ->first();
                            
    //                     if ($previousIn) {
    //                         $inTime = Carbon::parse($previousIn->date);
    //                         $outTime = Carbon::parse($row->date);
    //                         $duration = $outTime->diff($inTime);
                            
    //                         return sprintf(
    //                             "%s (%dh %02dm)", 
    //                             $type, 
    //                             $duration->h, 
    //                             $duration->i
    //                         );
    //                     }
    //                 }
                    
    //                 return $type;
    //             })
    //             // ->addColumn('type', function($row){
    //             //     $type = $row->type ?? ''; // text is in & out
    //             //     return $type;
    //             // })
    //             ->addColumn('insert_emp_id', function($row){
    //                 $insert_emp_id = $row->getempadd->emp_name ?? $row->getempadd->emp_name_en ?? '<span class="text-info">'.trans('lang.without').'</span>';
    //                 return $insert_emp_id;
    //             })
    //             ->addColumn('store_id', function($row){
    //                 $store_id = $row->getstore->store_name ?? '<span class="text-info">'.trans('lang.without').'</span>';
    //                 return $store_id;
    //             })
                
                
    //             ->filter(function ($instance) use ($request) {
    //                 if (!empty($request->get('from_time') || $request->get('to_date'))) {
    //                     $instance->whereDate('date', '>=', $request->get('from_time'));
    //                     $instance->whereDate('date', '<=', $request->get('to_date'));
    //                 }
                    
    //                 if (!empty($request->get('search'))) {
    //                     $instance->where(function($query) use($request) {
    //                         $search = $request->get('search');
    //                         $query->whereHas('getemangeremp', function($q) use($search) {
    //                             $q->where('emp_name', 'LIKE', "%$search%")
    //                             ->orWhere('emp_name_en', 'LIKE', "%$search%");
    //                         });
    //                     });
    //                 }
    //             })
    //             ->rawColumns(['name_ar','date','type','insert_emp_id','store_id','checkbox'])
    //             ->make(true);
    //     }
    //     return view('admin.pro_emp_att.index');
    // }
    public function index(Request $request)
    {
        set_time_limit(3600);
        ini_set('max_execution_time', 4800);
        ini_set('memory_limit', '4096M');
    
        if ($request->ajax()) {
            $data = Pro_emp_att::with(['getemangeremp', 'getempadd', 'getstore']);

            return Datatables::of($data)
                ->order(function ($query) {
                    $query->orderBy('id', 'DESC');
                })
                ->addColumn('checkbox', function($row){
                    return '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                            </div>';
                })
                ->addColumn('name_ar', function($row){
                    return $row->getemangeremp->emp_name ?? ($row->getemangeremp->emp_name_en ?? '<span class="text-info">'.trans('lang.without').'</span>');
                })
                ->addColumn('date', function($row){
                    return $row->date ?? '';
                })
                ->addColumn('type', function($row) {
                    $type = $row->type ?? '';
                    
                    if ($type == 'out') {
                        // Find the previous 'in' record for the same employee
                        $previousIn = Pro_emp_att::where('emp_id', $row->emp_id)
                            ->where('type', 'in')
                            ->where('date', '<=', $row->date)
                            ->orderBy('date', 'desc')
                            ->first();
                            
                        if ($previousIn) {
                            $inTime = Carbon::parse($previousIn->date);
                            $outTime = Carbon::parse($row->date);
                            $duration = $outTime->diff($inTime);
                            
                            return sprintf(
                                "%s (%dh %02dm)", 
                                $type, 
                                $duration->h, 
                                $duration->i
                            );
                        }
                    }
                    
                    return $type;
                })
                ->addColumn('insert_emp_id', function($row){
                    return $row->getempadd->emp_name ?? $row->getempadd->emp_name_en ?? '<span class="text-info">'.trans('lang.without').'</span>';
                })
                ->addColumn('store_id', function($row){
                    return $row->getstore->store_name ?? '<span class="text-info">'.trans('lang.without').'</span>';
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('from_time') || $request->get('to_date'))) {
                        $instance->whereDate('date', '>=', $request->get('from_time'))
                                 ->whereDate('date', '<=', $request->get('to_date'));
                    }
                    
                    if (!empty($request->get('search'))) {
                        $instance->whereHas('getemangeremp', function($q) use($request) {
                            $search = $request->get('search');
                            $q->where('emp_name', 'LIKE', "%$search%")
                              ->orWhere('emp_name_en', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['name_ar','date','type','insert_emp_id','store_id','checkbox'])
                ->make(true);
        }
        return view('admin.pro_emp_att.index');
    }
    public function create()
    {
        return view('admin.pro_emp_att.create');
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

        $row = Pro_emp_att::create([
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

        return redirect('admin/pro_emp_atts')->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    public function show($id)
    {
        $data = Pro_emp_att::find($id);
        return view('admin.pro_emp_att.show', compact('data'));
    }
    public function edit($id)
    {
        $data = Pro_emp_att::find($id);
        return view('admin.pro_emp_att.edit', compact('data'));
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
        $data = Pro_emp_att::find($request->id);
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

        return redirect('admin/pro_emp_atts')->with('message', 'تم التعديل بنجاح')->with('status', 'success');
    }

    public function destroy(Request $request)
    {
        try{
            Pro_emp_att::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'error']);
        }
        return response()->json(['message' => 'success']);
    }
    

}
