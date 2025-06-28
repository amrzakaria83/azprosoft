<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Emp_action;
use App\Models\Emp_salary;
use App\Models\Emp_plan_att;
use DataTables;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Emp_actionsController extends Controller
{
    protected $viewPath = 'admin.emp_action';
    private $route = 'admin.emp_actions';

    public function __construct(Emp_action $model)
    {
        $this->objectModel = $model;
    }

    public function index(Request $request)
    {
        $data = $this->objectModel::get();

        if ($request->ajax()) {
            $data = Emp_action::query();
            $data = $data->orderBy('id', 'DESC');

            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name_ar', function($row){
                        $name_ar = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->getemp_action->name_ar ?? $row->getemp_action->name_en.'</a><div>';
                    return $name_ar;
                })
                ->addColumn('value', function($row){
                    $value = '' ;
                    $valuerow = $row->value ;
                    if($valuerow) {
                        $value .= $valuerow;
                    } else {
                        $no_daysrow = $row->no_days ;
                        if($no_daysrow) {
                        $value .= '<span>('.$no_daysrow.')</span> <span>'.trans('lang.days').'</span>';
                    }
                    }
                    return $value;
                })
                ->addColumn('value_befor', function($row){
                        $value_befor = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->getemp->name_ar ?? $row->getemp->name_en.'</a><div>';
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
                        $type = '<div class="badge badge-light-success fw-bold">'.trans('lang.rewards').'</div>';
                    } else {
                        $type = '<div class="badge badge-light-danger fw-bold">'.trans('lang.penalties').'</div>';
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
                            // Search the 'product_name' field on the Emp_action model itself
                            $w->orWhere('product_name', 'LIKE', "%$search%");
                            // Search 'product_name_en' and 'product_name' (Arabic) on the related Product model
                            $w->orWhereHas('getprod', function($query) use ($search) {
                                $query->where('product_name_en', 'LIKE', "%$search%")
                                      ->orWhere('product_name', 'LIKE', "%$search%"); // Assuming 'product_name' in Product is Arabic
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
        $data = Emp_action::find($id);
        return view($this->viewPath .'.show', compact('data'));
    }

    public function create()
    {
        return view($this->viewPath .'.create');
    }
    public function store(Request $request)
    {

        $rule = [
            'emp_action_id' => 'required',
            'type' => 'required',

        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
        if(!empty($request->no_days)){
            $daycal = Emp_salary::where('emp_salary', $request->emp_action_id)->where('status', 0)->first();//0 = perhour - 1 = total
            if($daycal->type == 0 ){
                $emp_plan_hours_work = Emp_plan_att::where('status', 0)->where('emp_plan_att', $request->emp_action_id)->first();
                $dayvalue = round(($daycal->value * ($emp_plan_hours_work->hours_work / 26)) * $request->no_days);
            
            } elseif ($daycal->type == 1) {
                $dayvalue = round(($daycal->value / 26) * $request->no_days);
            
            }
            $row = $this->objectModel::create([
                'emp_id' => Auth::guard('admin')->user()->id,
                'emp_action_id' => $request->emp_action_id,
                'no_days' => $request->no_days ?? null,
                'value' => $dayvalue ?? null,
                'note' => $request->note,
                'type' => $request->type,// 0 = penalties - 1 = rewards
                'status' => $request->status ?? 0,// 0 = active - 1 = not active - 2 = done 
            ]);
        } else {
            $row = $this->objectModel::create([
                'emp_id' => Auth::guard('admin')->user()->id,
                'emp_action_id' => $request->emp_action_id,
                'no_days' => $request->no_days ?? null,
                'value' => $request->value ?? null,
                'note' => $request->note,
                'type' => $request->type,// 0 = penalties - 1 = rewards
                'status' => $request->status ?? 0,// 0 = active - 1 = not active - 2 = done 
            ]);
        }
       
        
        return redirect('admin/')->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }

    public function storemodel(Request $request)
    {
        $rule = [
        'emp_action_id' => 'required',

        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
        $row = $this->objectModel::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'emp_action_id' => $request->emp_action_id,
            'no_days' => $request->no_days,
            'value' => $request->value,
            'note' => $request->note,
            'type' => $request->type,// 0 = penalties - 1 = rewards
            'status' => $request->status ?? 0,// 0 = active - 1 = not active - 2 = done 
        ]);
        return redirect()->back()->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    public function edit($id)
    {
        $data = Emp_action::find($id);
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
        $data = Emp_action::find($request->id);
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
            Emp_action::whereIn('id',$request->id)->delete();
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
            'emp_action_id' => 'required',
            'type' => 'required',
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }

        $row = $this->objectModel::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'emp_action_id' => $request->emp_action_id,
            'no_days' => $request->no_days,
            'value' => $request->value,
            'note' => $request->note,
            'type' => $request->type,// 0 = penalties - 1 = rewards
            'status' => $request->status ?? 0,// 0 = active - 1 = not active - 2 = done 
            
        ]);
        return redirect('admin/')->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    

}
