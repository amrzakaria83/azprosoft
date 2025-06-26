<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Emangeremp;
use App\Models\Employee;
use \Yajra\Datatables\Datatables;
use Rap2hpoutre\FastExcel\FastExcel;
use Spatie\Permission\Models\Role;

use Validator;
use Auth;
class EmangerempsController extends Controller
{
    public function index(Request $request)
    {
        $data = Emangeremp::get();
        if ($request->ajax()) {
            $data = Emangeremp::query();
            // $data = $data->orderBy('id', 'DESC');
            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name', function($row){
                    $name = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->emp_name.'</a></div>';
                    $name .= '<br><span>'.$row->emp_name_en ?? 'null'.'</span>';
                    return $name;
                })
                ->addColumn('phone', function($row){
                    $phone = $row->emp_tell;
                    return $phone;
                })
                ->addColumn('emp_kind', function($row){
                    $emp_kind = $row->emp_kind;
                    return $emp_kind;
                })
                ->addColumn('emp_pass', function($row){
                    $emp_pass = $row->emp_pass;
                    return $emp_pass;
                })
                ->addColumn('emp_id', function($row){
                    $emp_id = $row->emp_id;
                    return $emp_id;
                })
                ->addColumn('emangeremp_id', function($row){
                    $emangeremp_id = '<span>no emp_code add</span>';
                    $emp_code = Employee::where('emangeremp_id',$row->emp_id)->first();

                    if (!$emp_code) {
                        $emangeremp_id = '<div class="ms-2">
                                <a href="'.route('admin.employees.show', $row->emp_id).'" class="btn btn-lg btn-icon btn-success btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-plus-square fs-1x"></i> 
                                </a>
                                
                            <br><span>'.trans('lang.addnew').' '.trans('lang.administrators').'</span>
                            </div>';
                    } else {
                        $emangeremp_id .= $emp_code->emailaz;
                    }

                   
                    return $emangeremp_id;
                })
                // ->addColumn('actions', function($row){
                //     $actions = '<div class="ms-2">
                //                 <a href="'.route('admin.emangeremps.show', $row->id).'" class="btn btn-sm btn-icon btn-warning btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                //                     <i class="bi bi-eye-fill fs-1x"></i>
                //                 </a>
                //                 <a href="'.route('admin.emangeremps.edit', $row->id).'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
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
                            $w->orWhere('name_ar', 'LIKE', "%$search%")
                            ->orWhere('phone', 'LIKE', "%$search%")
                            ->orWhere('emailaz', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['name','phone','emp_kind','emp_pass','emp_id','emangeremp_id','checkbox','actions'])
                ->make(true);
        }
        return view('admin.emangeremp.index');
    }

    public function create()
    {
        return view('admin.emangeremp.create');
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

        $row = Emangeremp::create([
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

        return redirect('admin/emangeremps')->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    public function show($id)
    {
        $data = Emangeremp::find($id);
        return view('admin.emangeremp.show', compact('data'));
    }
    public function edit($id)
    {
        $data = Emangeremp::find($id);
        return view('admin.emangeremp.edit', compact('data'));
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
        $data = Emangeremp::find($request->id);
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

        return redirect('admin/emangeremps')->with('message', 'تم التعديل بنجاح')->with('status', 'success');
    }

    public function destroy(Request $request)
    {
        try{
            Emangeremp::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'error']);
        }
        return response()->json(['message' => 'success']);
    }
    

}
