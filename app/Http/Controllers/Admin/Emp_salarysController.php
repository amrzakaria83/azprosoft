<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Emp_salary;
use DataTables;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Emp_salarysController extends Controller
{
    protected $viewPath = 'admin.emp_salary';
    private $route = 'admin.emp_salarys';

    public function __construct(Emp_salary $model)
    {
        $this->objectModel = $model;
    }

    public function index(Request $request)
    {
        $data = $this->objectModel::get();

        if ($request->ajax()) {
            $data = Emp_salary::query();
            $data = $data->orderBy('id', 'DESC');

            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name_ar', function($row){
                        $name_ar = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->getempsalary->name_ar ?? $row->getempsalary->name_en.'</a><div>';
                    return $name_ar;
                })
                ->addColumn('value', function($row){
                    $value = $row->value ;
                    return $value;
                })
                ->addColumn('value_befor', function($row){
                    $value_befor = $row->value_befor ;
                    return $value_befor;
                })
                ->addColumn('note', function($row){
                    $note = $row->note ;
                    return $note;
                })
                ->addColumn('created_at', function($row){
                    $created_at = $row->created_at ;
                    return $created_at;
                })

                ->addColumn('type', function($row){
                    if($row->type == 0 ) {
                        $type = '<div class="badge badge-light-success fw-bold">'.trans('lang.perhour').'</div>';
                    } else {
                        $type = '<div class="badge badge-light-danger fw-bold">'.trans('lang.total').'</div>';
                    }
                    
                    return $type;
                })
                ->addColumn('status', function($row){
                    if($row->status == 0 ) {
                        $status = '<div class="badge badge-light-success fw-bold">مفعل</div>';
                    } else {
                        $status = '<div class="badge badge-light-danger fw-bold">غير مفعل</div>';
                    }
                    
                    return $status;
                })
                ->addColumn('actions', function($row){
                    $actions = '<div class="ms-2">
                                <a href="'.route($this->route .'.show', $row->id).'" class="btn btn-sm btn-icon btn-warning btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-eye-fill fs-1x"></i>
                                </a>
                                <a href="'.route($this->route .'.edit', $row->id).'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-pencil-square fs-1x"></i>
                                </a>
                            </div>';
                    return $actions;
                })
                ->filter(function ($instance) use ($request) {
                    // if ($request->get('status') == '0' || $request->get('status') == '1') {
                    //     $instance->where('status', $request->get('status'));
                    // }
                    if ($request->get('status') != Null)
                    {
                    $instance->where(function ($query) use ($request) {
                        $query->where('status', $request->get('status'));
                    });
                    }
                    if ($request->get('type') != Null)
                    {
                    $instance->where(function ($query) use ($request) {
                        $query->where('type', $request->get('type'));
                    });
                    }
                    if (!empty($request->get('search'))) {
                            $search = $request->get('search'); // Define search string once
                            $instance->where(function($w) use($search){ // Pass $search to closure
                            // Search the 'product_name' field on the Emp_salary model itself
                            $w->orWhere('emp_salary', 'LIKE', "%$search%");
                            // Search 'emp_salary' and 'emp_salary' (Arabic) on the related Product model
                            $w->orWhereHas('getempsalary', function($query) use ($search) {
                                $query->where('name_ar', 'LIKE', "%$search%")
                                      ->orWhere('name_en', 'LIKE', "%$search%"); // Assuming 'emp_salary' in Product is Arabic
                            });
                            // If you intended to search by supplier email, you would add:
                            // $w->orWhereHas('getsupp', function($query) use ($search) { $query->where('email', 'LIKE', "%$search%"); });
                        });
                    }
                })
                ->rawColumns(['name_ar','value','type','value_befor','note','created_at','status','checkbox','actions'])
                ->make(true);
        }
        return view($this->viewPath .'.index');
    }

    public function show($id)
    {
        $data = Emp_salary::find($id);
        return view($this->viewPath .'.show', compact('data'));
    }

    public function create()
    {
        return view($this->viewPath .'.create');
    }
    public function store(Request $request)
    {

        $rule = [

        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
        $excistsal = $this->objectModel::where('emp_salary', $request->emp_salary)->first();
        if ($excistsal) {
            $oldValue = $excistsal->value;
            $excistsal = $excistsal->update([
                'status' => 1,
            ]);
            $row = $this->objectModel::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'emp_salary' => $request->emp_salary, 
            'value' => $request->value, 
            'value_befor' => $oldValue, 
            'note' => $request->note, 
            'type' => $request->type, //0 = perhour - 1 = total 
            'status' => $request->status ?? 0,
        ]);
        } else {
        $row = $this->objectModel::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'emp_salary' => $request->emp_salary, 
            'value' => $request->value, 
            'value_befor' => $request->value, 
            'note' => $request->note, 
            'type' => $request->type, //0 = perhour - 1 = total 
            'status' => $request->status ?? 0,
        ]);
        }
        
        return redirect('admin/')->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }

    public function storemodel(Request $request)
    {
        $rule = [
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
        $row = $this->objectModel::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'emp_att_overtime' => Auth::guard('admin')->user()->id,
            'attendance_in_over_from' => $request->attendance_in_over_from,
            'attendance_out_over_to' => $request->attendance_out_over_to,
            'type_emp_att_request' => $request->type_emp_att_request,//0 = normal rate - 1 = over rate 
            'noterequest' => $request->noterequest,// 0 = without salary - 1 = 50%salary - 2 = fullsalary
            'statusmangeraprove' => 0 ,// 0 = waitting - 1 = approved - 2 = rejected - 3 = delayed (manger)
            'status' => $request->status ?? 0,
        ]);
        return redirect()->back()->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    public function edit($id)
    {
        $data = Emp_salary::find($id);
        return view('admin.emp_att_overtime.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $rule = [
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        } 
        $data = Emp_salary::find($request->id);
        $data->update([
            'emp_id' => Auth::guard('admin')->user()->id,
            'emp_att_overtime' => Auth::guard('admin')->user()->id,
            'attendance_in_over_from' => $request->attendance_in_over_from,
            'attendance_out_over_to' => $request->attendance_out_over_to,
            'type_emp_att_request' => $request->type_emp_att_request,//0 = normal rate - 1 = over rate 
            'noterequest' => $request->noterequest,// 0 = without salary - 1 = 50%salary - 2 = fullsalary
            'statusmangeraprove' => 0 ,// 0 = waitting - 1 = approved - 2 = rejected - 3 = delayed (manger)
            'status' => $request->status ?? 0,
        ]);

        return redirect('admin/')->with('message', 'تم التعديل بنجاح')->with('status', 'success');
    }

    public function destroy(Request $request)
    {   

        try{
            Emp_salary::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'error']);
        }
        return response()->json(['message' => 'success']);

    }
    public function create_bymanger()
    {
        return view($this->viewPath .'.create_bymanger');
    }
    public function storemanger(Request $request)
    {

        $rule = [
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
        
            // Convert datetime format from 'Y-m-d h:i A' to 'Y-m-d H:i:s'
                $attendanceOutFrom = Carbon::createFromFormat('Y-m-d h:i A', $request->attendance_in_over_from)
                ->format('Y-m-d H:i:s');

                $attendanceInTo = Carbon::createFromFormat('Y-m-d h:i A', $request->attendance_out_over_to)
                    ->format('Y-m-d H:i:s');
        $row = $this->objectModel::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'man_att_overtime' => Auth::guard('admin')->user()->id,
            'emp_att_overtime' => $request->emp_att_overtime,
            'attendance_in_over_from' => $attendanceOutFrom,
            'attendance_out_over_to' => $attendanceInTo,
            'attendance_in_over_from_manger' => $attendanceOutFrom,
            'attendance_out_over_to_manger' => $attendanceInTo,
            'type_emp_att_request' => $request->type_emp_att_request,//0 = normal rate - 1 = over rate 
            'type_emp_att_mang' => $request->type_emp_att_request,//0 = normal rate - 1 = over rate 
            'noterequest' => $request->noterequest,// 0 = without salary - 1 = 50%salary - 2 = fullsalary
            'statusmangeraprove' => 1 ,// 0 = waitting - 1 = approved - 2 = rejected - 3 = delayed (manger)
            'status' => $request->status ?? 0,
        ]);
        return redirect('admin/')->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    

}
