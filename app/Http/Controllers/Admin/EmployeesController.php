<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Employee;
use \Yajra\Datatables\Datatables;
use Rap2hpoutre\FastExcel\FastExcel;
use Spatie\Permission\Models\Role;

use Validator;
use Auth;
class EmployeesController extends Controller
{
    public function index(Request $request)
    {
        $data = Employee::get();
        if ($request->ajax()) {
            $data = Employee::query();
            $data = $data->orderBy('is_active', 'DESC')->orderBy('id', 'DESC');
            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name', function($row){
                    $name = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->name_ar.'</a>';
                    $name .= '<span>'.$row->name_en.'</span></div>';
                    $name .= '<span>'.$row->emailaz.'</span></div>';
                    return $name;
                })
                ->addColumn('phone', function($row){
                    $phone = $row->phone;
                    return $phone;
                })
                ->addColumn('is_active', function($row){
                    if($row->is_active == 1) {
                        $is_active = '<div class="badge badge-light-success fw-bold">مقعل</div>';
                    } else {
                        $is_active = '<div class="badge badge-light-danger fw-bold">غير مفعل</div>';
                    }
                    return $is_active;
                })
                ->addColumn('actions', function($row){
                    $actions = '<div class="ms-2">
                                <a href="'.route('admin.employees.show', $row->id).'" class="btn btn-sm btn-icon btn-warning btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-eye-fill fs-1x"></i>
                                </a>
                                <a href="'.route('admin.employees.edit', $row->id).'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-pencil-square fs-1x"></i>
                                </a>
                                <a href="'.route('admin.employees.editpass', $row->id).'" class="btn btn-sm btn-icon btn-danger btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="bi bi-pencil-square fs-1x">p</i>
                            </a>
                            </div>';
                    return $actions;
                })
                ->filter(function ($instance) use ($request) {
                    // if ($request->get('is_active') == 0 || $request->get('is_active') == 1) {
                    //     $instance->where('is_active', $request->get('is_active'));
                    // }
                    if ($request->get('is_active') != Null)
                    {
                    $instance->where(function ($query) use ($request) {
                        $query->where('is_active', $request->get('is_active'));
                    });
                    }

                    if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('name_ar', 'LIKE', "%$search%")
                            ->orWhere('phone', 'LIKE', "%$search%")
                            ->orWhere('emailaz', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['name','phone','is_active','checkbox','actions'])
                ->make(true);
        }
        return view('admin.employee.index');
    }

    public function create()
    {
        return view('admin.employee.create');
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

        $row = Employee::create([
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

        return redirect('admin/employees')->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    public function show($id)
    {
        $data = Employee::find($id);
        return view('admin.employee.show', compact('data'));
    }
    public function edit($id)
    {
        $data = Employee::find($id);
        return view('admin.employee.edit', compact('data'));
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
        $data = Employee::find($request->id);
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

        return redirect('admin/employees')->with('message', 'تم التعديل بنجاح')->with('status', 'success');
    }

    public function destroy(Request $request)
    {
        try{
            Employee::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'error']);
        }
        return response()->json(['message' => 'success']);
    }
    public function import () {
        return view('admin.employee.import');
    }
    public function importfile (Request $request) {

        $data = (new FastExcel)->import($request->file, function ($line) {
            return $line;
        });
        return view('admin.employee.importantdata', compact('data'));
    }
    public function importstore (Request $request) {
    $emp_code = $request->emp_code;
    $name_ar = $request->name_ar;
    $name_en = $request->name_en;
    $phone = $request->phone;
    $emailaz = $request->emailaz ?? null;
    $password = $request->password;
    $type = $request->type ?? 0; //0 = admin, 1 = no dash 3 = subadmin, 4 = superadmin
    $is_active = $request->is_active ?? 1;
    $role_id = $request->role_id ?? 1;
    
    $data = (json_decode($request->data));
        foreach ( $data as $key => $value) {
        Employee::create([
            'emp_code' => $value-> $emp_code,
            'name_ar' => $value->$name_ar,
            'name_en' => $value->$name_en,
            'phone' => $value->$phone,
            'emailaz' => $value->$emailaz,
            'password' => $value->$password,
            'type' => $value->$type ?? 0, //0 = admin, 1 = no dash 3 = subadmin, 4 = superadmin
            'is_active' => $value->$is_active ?? 1,
            'role_id' => $value->$role_id ?? 1,
            
        ]);};
        return view('admin.employee.import');
    }
    public function empcheck(Request $request) {
        $this->validate($request, [
            'emp_code'   => 'required',
            'password' => 'required',
        ]);
        $employee = Employee::where('emp_code', $request->emp_code)->first();
        if($employee){
            if($employee->is_active == '1'){
                if (Auth::guard('admin')->attempt(['name_ar' => $employee->name_ar,
                'password' => $request->password, 'emp_code' => $employee->emp_code ],
                $request->get('remember'))){
                    $request->session();

        return back()->withInput($request->only('emp_code'));
    }}}}
    
    

}
