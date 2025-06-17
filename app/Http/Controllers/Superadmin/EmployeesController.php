<?php

namespace App\Http\Controllers\Supersuperadmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Bank;
use App\Models\Job;
use App\Models\Salary;
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
                    $name = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->append_name.'</a>';
                    $name .= '<span>'.$row->name_en.'</span></div>';
                    $name .= '<span>'.$row->email.'</span></div>';
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
                                <a href="'.route('superadmin.employees.show', $row->id).'" class="btn btn-sm btn-icon btn-warning btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-eye-fill fs-1x"></i>
                                </a>
                                <a href="'.route('superadmin.employees.edit', $row->id).'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-pencil-square fs-1x"></i>
                                </a>
                                <a href="'.route('superadmin.employees.editpass', $row->id).'" class="btn btn-sm btn-icon btn-danger btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
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
        return view('superadmin.employee.index');
    }

    public function create()
    {
        $banks = Bank::get();$jobs = Job::get();$salaries = Salary::get();
        return view('superadmin.employee.create', compact('banks','jobs','salaries'));
    }

    public function store(Request $request)
    {
        $rule = [
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'emailaz' => 'nullable',
            'phone' => 'required',
            'password' =>'required',
            'national_no' =>'nullable',
            'address1' =>'nullable',
            'emp_code' => 'required',
            'del_code' => 'nullable',
        ];
        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');}
            $jobs = $request->jobs_code;
            if (in_array($jobs, [4, 5, 6])) {
                $del_cod = $request->emp_code;
            } else {
                $del_cod = null;
            }

        $row = Employee::create([
            'emp_code' => $request->emp_code,
            'del_code' => $del_cod,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'phone' => $request->phone,
            'phone1' => $request->phone1,
            'phone2' => $request->phone2,
            'emailaz' => $request->emailaz,
            'password' => Hash::make($request->password),
            'national_no' => $request->national_no,
            'work_date' => $request->work_date,
            'birth_date' => $request->birth_date,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'address3' => $request->address3,
            'gender' => $request->gender,
            'is_active' => $request->is_active ?? 1,
            'collect_m' => $request->collect_m,
            'type' => $request->type ,
            'acc_bank_no' => $request->acc_bank_no,
            'role_code' => $request->role_code,
            'role_id' => $request->role_id,
            'salary_code' =>  $request->salary_code ?? null,
            'jobs_code' => $request->jobs_code,
            'bank_code' => $request->bank_code,
            'method_for_payment' => $request->method_for_payment,
            'note' => $request->note,
        ]);
        if($request->hasFile('attach') && $request->file('attach')->isValid()){
            $row->addMediaFromRequest('attach')->toMediaCollection('profile');
        }
        $role = Role::find($request->role_id);
        $row->syncRoles([]);
        $row->assignRole($role->name);

        return redirect('superadmin/employees')->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    public function show($id)
    {
        $banks = Bank::get();$jobs = Job::get();$salaries = Salary::get();$data = Employee::find($id);
        return view('superadmin.employee.show', compact('banks','jobs','salaries','data'));
    }
    public function edit($id)
    {
        $banks = Bank::get();$jobs = Job::get();$salaries = Salary::get();$data = Employee::find($id);
        return view('superadmin.employee.edit', compact('banks','jobs','salaries','data'));
    }

    public function update(Request $request)
    {
        $rule = [
            'name_ar' => 'required|string','password' => 'nullable','photo' => 'image|mimes:png,jpg,jpeg|max:2048'];
        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
        $data = Employee::find($request->id);
        $data->update([
            'emp_code' => $request->emp_code,
            'del_code' => $request->del_code,
            'name_ar' => $request->name_ar,'name_en' => $request->name_en,
            'phone' => $request->phone,'phone1' => $request->phone1,'phone2' => $request->phone2,
            'emailaz' => $request->emailaz,
            // 'password' => ($request->password) ? Hash::make($request->password): $data->password,
            'national_no' => $request->national_no,
            'work_date' => $request->work_date,
            'birth_date' => $request->birth_date,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'address3' => $request->address3,
            'gender' => $request->gender,
            'is_active' => $request->is_active ?? 1,
            'collect_m' => $request->collect_m,
            'type' => $request->type ,
            'acc_bank_no' => $request->acc_bank_no,
            'role_code' => $request->role_code,
            'role_id' => $request->role_id,
            'salary_code' =>  $request->salary_code ,
            'jobs_code' => $request->jobs_code,
            'bank_code' => $request->bank_code,
            'method_for_payment' => $request->method_for_payment,
            'note' => $request->note,

        ]);

        if($request->hasFile('photo') && $request->file('photo')->isValid()){
            $data->addMediaFromRequest('photo')->toMediaCollection('profile');
        }

        return redirect('superadmin/employees')->with('message', 'تم التعديل بنجاح')->with('status', 'success');
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
        return view('superadmin.employee.import');
    }
    public function importfile (Request $request) {

        $data = (new FastExcel)->import($request->file, function ($line) {
            return $line;
        });
        return view('superadmin.employee.importantdata', compact('data'));
    }
    public function importstore (Request $request) {
    $emp_code = $request->emp_code;$del_code = $request->del_code;
    $name_ar = $request->name_ar;$name_en = $request->name_en;
    $phone = $request->phone;$phone1 = $request->phone1;$phone2 = $request->phone2;
    $emailaz = $request->emailaz;$password = $request->password;// csrf
    $national_no = $request->national_no;
    // $birth_date = $request->birth_date;$work_date = $request->work_date;
    $address1 = $request->address1;$address2 = $request->address2;$address3 = $request->address3;
    $is_active = $request->is_active;$acc_bank_no = $request->acc_bank_no;
    $gender = $request->gender;
    $bank_code = $request->bank_code;$jobs_code = $request->jobs_code;$salary_code = $request->salary_code;
    $collect_m = $request->collect_m;
    $type = $request->type;
    $role_code = $request->role_code;
    $method_for_payment = $request->method_for_payment;
    $azcustomers_id_old = $request->azcustomers_id_old;
    $data = (json_decode($request->data));
        foreach ( $data as $key => $value) {
        Employee::create([
            'emp_code' => $value-> $emp_code,'del_code' => $value-> $del_code,
            'name_ar' => $value->$name_ar,'name_en' => $value->$name_en,
            'phone' => $value->$phone,'phone1' => $value->$phone1?? 0,'phone2' => $value->$phone2?? 0,
            'emailaz' => $value->$emailaz ?? fake()->unique(),
            'password' => Hash::make($value->$password),// csrf
            'national_no' => is_numeric($value->$national_no) ? $value->$national_no : fake()->unique()->numerify('##############'),
            // 'national_no' => $value->$national_no ?? fake()->unique()->numerify('##############'),
            'birth_date' =>  fake()->date(),'work_date' => fake()->date(),
            'address1' => $value->$address1,'address2' => $value->$address2,'address3' => $value->$address3,
            'is_active' => 1,
            'acc_bank_no' => $value->$acc_bank_no,
            'salary_code' => '1','bank_code' => 1,'jobs_code' => 1,'gender' => 1,
            'type' => '0',
            'role_code' => '1',
            'collect_m' => '1',
            'method_for_payment' => $value->$method_for_payment,'azcustomers_id_old' => $value->$azcustomers_id_old,
        ]);};
        return view('superadmin.employee.import');
    }
    public function empcheck(Request $request) {
        $this->validate($request, [
            'emp_code'   => 'required',
            'password' => 'required',
        ]);
        $employee = Employee::where('emp_code', $request->emp_code)->first();
        if($employee){
            if($employee->is_active == '1'){
                if (Auth::guard('superadmin')->attempt(['name_ar' => $employee->name_ar,
                'password' => $request->password, 'emp_code' => $employee->emp_code ],
                $request->get('remember'))){
                    $request->session();

        return back()->withInput($request->only('emp_code'));
    }}}}
    public function jobadd(Request $request)
    {
        $rule = [
            'name_ar' => 'required|string',
            'name_en' => 'required',
            'description' => 'nullable',
            ];
        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
        $row = Job::create([
            'emp_code' => Auth::guard('superadmin')->id(),
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'description' => $request->description,

        ]);
        return redirect('superadmin/employees/create')->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    public function bankadd(Request $request)
    {
        $rule = [
            'name_ar' => 'required|string',
            'name_en' => 'required',
            'acc_no' => 'nullable',
            ];
        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
        $row = Bank::create([
            'emp_code' => Auth::guard('superadmin')->id(),
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'branch' => $request->branch,
            'acc_no' => $request->acc_no,
        ]);
        return redirect('superadmin/employees/create')->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    public function editpass($id)
    {
        $banks = Bank::get();$jobs = Job::get();$salaries = Salary::get();$data = Employee::find($id);
        return view('superadmin.employee.editpass', compact('banks','jobs','salaries','data'));
    }
    public function updatepass(Request $request)
    {
        $rule = [];
        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
        $data = Employee::find($request->id);
        $data->update([
            'password' => ($request->password) ? Hash::make($request->password): $data->password,
            'role_id' => $request->role_id,

        ]);
            
        $role = Role::find($request->role_id);
        $data->syncRoles([]);
        $data->assignRole($role->name);


        return redirect('superadmin/employees')->with('message', 'تم التعديل بنجاح')->with('status', 'success');
    }

}
