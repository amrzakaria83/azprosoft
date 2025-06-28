<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Emp_plan_att;
use DataTables;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Emp_plan_attsController extends Controller
{
    protected $viewPath = 'admin.emp_plan_att';
    private $route = 'admin.emp_plan_atts';

    public function __construct(Emp_plan_att $model)
    {
        $this->objectModel = $model;
    }

    public function index(Request $request)
    {
        $data = $this->objectModel::get();

        if ($request->ajax()) {
            $data = Emp_plan_att::query();
            $data = $data->orderBy('id', 'DESC');

            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name_ar', function($row){
                    $prod_name = $row->getemp->name_ar ?? $row->getemp->name_en;
                    if ($prod_name){

                        $name_ar = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$prod_name.'</a><div>';
                    } 

                    return $name_ar;
                })
                ->addColumn('attendance_in_at', function($row){
                    $attendance_in_at = $row->attendance_in_at ;

                    return $attendance_in_at;
                })
                ->addColumn('attendance_out_at', function($row){
                    $attendance_out_at = $row->attendance_out_at ;

                    return $attendance_out_at;
                })
                ->addColumn('work_loct_id', function($row){
                    $work_loct_id = $row->getwor_loc->name_ar ?? $row->getwor_loc->name_en ;

                    return $work_loct_id;
                })
                ->addColumn('hours_work', function($row){
                    $hours_work = $row->hours_work .' '. trans('lang.hour') ?? '' ;

                    return $hours_work;
                })
                ->addColumn('weekly_dayoff', function($row) {
                    $weekly_dayoff = json_decode($row->weekly_dayoff);
                    
                    if (empty($weekly_dayoff)) {
                        return [
                            'display' => '-',
                            'sort' => ''
                        ];
                    }
                    
                    $dayNames = [
                        0 => trans('lang.sunday'),
                        1 => trans('lang.monday'),
                        2 => trans('lang.tuesday'),
                        3 => trans('lang.wednesday'),
                        4 => trans('lang.thursday'),
                        5 => trans('lang.friday'),
                        6 => trans('lang.saturday'),
                    ];
                    
                    $formattedDays = array_map(function($day) use ($dayNames) {
                        return $dayNames[$day] ?? $day;
                    }, $weekly_dayoff);
                    
                    return implode(', ', $formattedDays);
                })
                
                
                ->addColumn('status', function($row){
                    if($row->status == 0 ) {
                        $status = '<div class="badge badge-light-success fw-bold">مقعل</div>';
                    } else {
                        $status = '<div class="badge badge-light-danger fw-bold">غير مفعل</div>';
                    }
                    
                    return $status;
                })
                ->addColumn('actions', function($row){
                    $actions = '<div class="ms-2">
                                <a href="'.route('admin.emp_plan_atts.show', $row->id).'" class="btn btn-sm btn-icon btn-warning btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-eye-fill fs-1x"></i>
                                </a>
                                <a href="'.route('admin.emp_plan_atts.edit', $row->id).'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-pencil-square fs-1x"></i>
                                </a>
                            </div>';
                    return $actions;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == '0' || $request->get('status') == '1') {
                        $instance->where('status', $request->get('status'));
                    }
                    if (!empty($request->get('search'))) {
                            $search = $request->get('search'); // Define search string once
                            $instance->where(function($w) use($search){ // Pass $search to closure
                            // Search the 'product_name' field on the Emp_plan_att model itself
                            $w->orWhere('emp_plan_att', 'LIKE', "%$search%");
                            // Search 'product_name_en' and 'product_name' (Arabic) on the related Product model
                            $w->orWhereHas('getemp', function($query) use ($search) {
                                $query->where('name_ar', 'LIKE', "%$search%")
                                      ->orWhere('name_en', 'LIKE', "%$search%"); // Assuming 'product_name' in Product is Arabic
                            });
                            // If you intended to search by supplier email, you would add:
                            // $w->orWhereHas('getsupp', function($query) use ($search) { $query->where('email', 'LIKE', "%$search%"); });
                        });
                    }
                })
                ->rawColumns(['name_ar','attendance_in_at','attendance_out_at','work_loct_id','hours_work','weekly_dayoff','status','checkbox','actions'])
                ->make(true);
        }
        return view($this->viewPath .'.index');
    }

    public function show($id)
    {
        $data = Emp_plan_att::find($id);
        return view('admin.emp_plan_att.show', compact('data'));
    }

    public function create()
    {
        return view('admin.emp_plan_att.create');
    }

    public function store(Request $request)
    {

        $rule = [
        'emp_plan_att' => 'required|numeric',
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
        $hoursWork_day = Carbon::parse($request->attendance_out_at)->diffInHours(Carbon::parse($request->attendance_in_at));

        $row = $this->objectModel::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'emp_plan_att' => $request->emp_plan_att,
            'attendance_in_at' => $request->attendance_in_at,
            'attendance_out_at' => $request->attendance_out_at,
            'hours_work' => $hoursWork_day,
            'work_loct_id' => $request->work_loct_id,
            'weekly_dayoff' => json_encode($request->weekly_dayoff),  
            'status' => $request->status ?? 0,
        ]);
        return redirect(route($this->route . '.index'))->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    public function storemodel(Request $request)
    {
        $rule = [
            'emp_plan_att' => 'required|numeric',
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
        // Calculate the difference in hours
        $hoursWork_day = Carbon::parse($request->attendance_out_at)->diffInHours(Carbon::parse($request->attendance_in_at));
        $row = Emp_plan_att::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'emp_plan_att' => $request->emp_plan_att,
            'attendance_in_at' => $request->attendance_in_at,
            'attendance_out_at' => $request->attendance_out_at,
            'hours_work' => $hoursWork_day,
            'work_loct_id' => $request->work_loct_id,
            'weekly_dayoff' => json_encode($request->weekly_dayoff), 
            'status' => $request->status ?? 0,
        ]);
        return redirect()->back()->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    public function edit($id)
    {
        $data = Emp_plan_att::find($id);
        return view('admin.emp_plan_att.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $rule = [
            'emp_plan_att' => 'required|numeric',
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        } 
        $data = Emp_plan_att::find($request->id);
        $hoursWork_day = Carbon::parse($request->attendance_out_at)->diffInHours(Carbon::parse($request->attendance_in_at));

        $data->update([
            'emp_id' => Auth::guard('admin')->user()->id,
            'emp_plan_att' => $request->emp_plan_att,
            'attendance_in_at' => $request->attendance_in_at,
            'attendance_out_at' => $request->attendance_out_at,
            'hours_work' => $hoursWork_day,
            'work_loct_id' => $request->work_loct_id,
            'weekly_dayoff' => json_encode($request->weekly_dayoff), 
            'status' => $request->status ?? 0,
        ]);

        return redirect('admin/emp_plan_atts')->with('message', 'تم التعديل بنجاح')->with('status', 'success');
    }

    public function destroy(Request $request)
    {

        try{
            Emp_plan_att::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'error']);
        }
        return response()->json(['message' => 'success']);

    }
    

}
