<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Plan_att_mission;
use App\Models\Plan_att_emp_vacation;
use App\Models\Emp_plan_att_mission;
use App\Models\Employee;
use App\Models\Site;
use Carbon\Carbon;
use DataTables;
use Validator;
use Auth;

class AttendanceController extends Controller
{
    protected $viewPath = 'admin.attendance';
    private $route = 'admin.attendances';

    public function __construct(Attendance $model)
    {
        $this->objectModel = $model;
    }

    public function index(Request $request)
    {

        $data = $this->objectModel::get();

        if ($request->ajax()) {
            $data = $this->objectModel::query();
            $data = $data->orderBy('id', 'asc');
            $data = $data->where('status_done', 0);// 0 = done - 1 = updated_in - 2 = updated_out - 3 = not approved

            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('emp_code_att', function($row){
                    $emp_code_att = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->att_getemp->name_ar.'</a></div>';
                    
                    return $emp_code_att;
                })
                ->addColumn('attendance_in_at', function($row){
                    $attendance_in_at = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->attendance_in_at.'</a></div>';

                    return $attendance_in_at;
                })
                ->addColumn('attendance_out_at', function($row){
                    $attendance_out_at = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->attendance_out_at.'</a></div>';

                    return $attendance_out_at;
                })
                ->addColumn('duration', function($row){
                    $arrive_time = $row->attendance_out_at;
                    if($arrive_time != null){
                        $arrive_time = Carbon::parse($row->attendance_out_at);
                    } else{$arrive_time = Carbon::now();}
                    $start_time = $row->attendance_in_at;
                    if($start_time != null){
                        $start_time = Carbon::parse($row->attendance_in_at);
                    } else{$start_time = Carbon::now();}

                    $currentTime = $arrive_time;
                    $timestamp = $start_time;
                    $timeDifference = $currentTime->diff($timestamp);
                    $days = $timeDifference->d;
                    $hours = $timeDifference->h;
                    $minutes = $timeDifference->i;
                    $timeString = '';
                    if ($days > 0)
                    {
                        $timeString .= $days . ' يوم ';
                    }if ($hours > 0) 
                    {
                        $timeString .= $hours . ' ساعة ';
                    }
                    $timeString .= $minutes . ' دقيقة';

                    $duration = '<div class="d-flex flex-column"><a href="javascript:;"class="text-gray-800 text-hover-primary mb-1">'
                    .$timeString.
                    '</a></div>';
                    return $duration;
                })
                ->addColumn('emp_code_in', function($row){
                    $emp_code_in = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->getemp_in->name_ar.'</a></div>';
                    return $emp_code_in;
                })
                ->addColumn('actions', function($row){
                    $actions = '<div class="ms-2">
                                <a href="'.route($this->route.'.out_attendance', $row->id).'" class="btn btn-sm btn-icon btn-danger btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-pencil-square fs-1x">out</i>
                                </a>
                            </div>';
                    return $actions;
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('from_time') || $request->get('to_date'))) {
                        $instance->whereDate('attendance_in_at', '>=', $request->get('from_time'));
                        $instance->whereDate('attendance_in_at', '<=', $request->get('to_date'));
                    }
                    
                    if ($request->get('emp_code') != Null)
                    {
                    $instance->where(function ($query) use ($request) {
                        $query->where('emp_code_att', $request->get('emp_code'));
                    });
                    }
                    if (!empty($request->get('search'))) {
                        $search = $request->get('search'); // Define search string once
                        $instance->where(function($w) use($search){ // Pass $search to closure
                        // Search the 'product_name' field on the Emp_plan_att model itself
                        $w->orWhere('emp_code_att', 'LIKE', "%$search%");
                        // Search 'product_name_en' and 'product_name' (Arabic) on the related Product model
                        $w->orWhereHas('att_getemp', function($query) use ($search) {
                            $query->where('name_ar', 'LIKE', "%$search%")
                                  ->orWhere('name_en', 'LIKE', "%$search%"); // Assuming 'product_name' in Product is Arabic
                        });
                        // If you intended to search by supplier email, you would add:
                        // $w->orWhereHas('getsupp', function($query) use ($search) { $query->where('email', 'LIKE', "%$search%"); });
                    });
                }
                })
                ->rawColumns(['emp_code_att', 'attendance_in_at', 'attendance_out_at', 'duration','checkbox','actions'])
                ->make(true);
        }
        return view($this->viewPath .'.index');
    }

    public function show($id)
    {
        $data = $this->objectModel::find($id);
        return view($this->viewPath .'.show', compact('data'));
    }

    public function destroy(Request $request)
    {

        try{
            $this->objectModel::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'error']);
        }
        return response()->json(['message' => 'success']);

    }
    public function attend()
    {
        return view($this->viewPath .'.attall');
    }
    

    public function index_all(Request $request)
    {

        $data = $this->objectModel::get();

        if ($request->ajax()) {
            $data = $this->objectModel::query();
            $data = $data->orderBy('created_at', 'asc');
            $data = $data->whereNot('status', '0');
            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('emp_code_att', function($row){
                    $emp_code_att = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->att_getemp->name_ar.'</a></div>';
                    $created_at = $row->created_at;$updated_at = $row->updated_at;$createdTimestamp = Carbon::parse($created_at);$updatedTimestamp = Carbon::parse($updated_at);$timeDifference = $createdTimestamp->diff($updatedTimestamp);$days = $timeDifference->d;$hours = $timeDifference->h;$minutes = $timeDifference->i;$timeString = '';if ($days > 0) {$timeString .= $days . ' يوم ';}if ($hours > 0) {$timeString .= $hours . ' ساعة ';}$timeString .= $minutes . ' دقيقة';
                    $emp_code_att   .= '<span>   مدة العمل: ' . $timeString. '</span></div>';

                    return $emp_code_att;
                })
                ->addColumn('emp_code_in', function($row){
                    $emp_code_in = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->attendance_time_in.'</a></div>';
                    $emp_code_in .= '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->attendance_date_in.'</a></div>';
                    $emp_code_in  .= '<span> مكان الحضور: ' . $row->getstore->name. '</span><br>';
                    $emp_code_in   .= '<span>  موظف الحضور: ' . $row->getemp_in->name_ar . '</span>';
                    return $emp_code_in;
                })
                ->addColumn('emp_code_out', function($row){
                    $emp_code_out = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->attendance_time_out.'</a></div>';
                    $emp_code_out .= '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->attendance_date_out.'</a></div>';
                    $emp_code_out  .= '<span> مكان الانصراف: ' . $row->getstore_out->name. '</span><br>';
                    if ($row->getemp_out && $row->getemp_out->name_ar)
                    {$emp_code_out .= '<span>  موظف الانصراف: ' . $row->getemp_out->name_ar  . '</span>';
                    } else
                    {$emp_code_out .= '<span>  موظف الانصراف: لم يتم تسجيل موظف الانصراف </span>'; }
                    return $emp_code_out;
                })

                ->filter(function ($instance) use ($request) {
                    if ($request->get('from_date') && $request->get('to_date')) {
                        $instance->whereDate('created_at', '>=', $request->get('from_date'));
                        $instance->whereDate('created_at', '<=', $request->get('to_date'));}
                    if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->where('name_ar', 'LIKE', "%$search%");

                        });
                    }
                })
                ->rawColumns(['emp_code_att', 'emp_code_in', 'emp_code_out', 'checkbox'])
                ->make(true);
        }
        return view($this->viewPath .'.attall');
    }
    public function plan_att()
    {
        return view($this->viewPath .'.plan_att');
    }
    public function getempdelselect(Request $request)
    {

        $data = [];
        if($request->has('q')){
            $search = $request->q ;
            $data = Employee::where('is_active', 1)
            ->select("name_ar","name_en","emp_code","id","is_active")
            // ->Where('name_ar','LIKE',"%$search%")
            // ->orWhere('name_en','LIKE',"%$search%")
            ->Where('emp_code','LIKE',"%$search%")->get();
        }
        
        return response()->json($data);
    }
    public function plan_att_emp_vacation()
    {
        return view($this->viewPath .'.plan_att_emp_vacation');
    }
    public function store_plan_att(Request $request)
    {

        $rule = [
            'name' => 'required|string','type_plan' => 'required','type_att' => 'required',
            'attendance_time_in' => 'required','attendance_time_out' =>'required'];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');}

        $row = Plan_att_mission::create([
            'emp_code' => Auth::guard('admin')->user()->emp_code,
            'name' => $request->name,
            'type_plan' => $request->type_plan,
            'type_att' => $request->type_att,
            'attendance_time_in' => $request->attendance_time_in,
            'attendance_time_out' => $request->attendance_time_out,
            'note' => $request->note,
        ]);
        return redirect('admin/')->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    public function store_plan_att_emp_vacation(Request $request)
    {

        $rule = [
            'name_ar' => 'required','type_plan_att_emp_vacation' => 'required',
            'attendance_datetime_in' => 'required','attendance_datetime_out' =>'required'];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');}

        $row = Plan_att_emp_vacation::create([
            'emp_code' => Auth::guard('admin')->user()->emp_code,
            'name_ar' => $request->name_ar,
            'type_plan_att_emp_vacation' => $request->type_plan_att_emp_vacation,
            'status_for_approved' => $request->status_for_approved ?? 1,
            'percentage_value' => $request->percentage_value,
            'emp_code_approved' => $request->emp_code_approved ?? 1004,
            'attendance_datetime_in' => $request->attendance_datetime_in,
            'attendance_datetime_out' => $request->attendance_datetime_out,
        ]);

        return redirect('admin/')->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }

    public function emp_index_all_notready(Request $request)
    {
        // $fromDate = $request->input('start_date');
        $fromDate = 01-10-2023;
        $toDate = $request->input('end_date');
        $data = [
            $this->objectModel::where('emp_code_att', 11643)->whereDate('created_at', '>=', $fromDate)->get(),
            Plan_att_emp_vacation::where('name_ar', 11643)->whereDate('created_at', '>=', $fromDate)->get(),
            Emp_plan_att_mission::where('emp_code_att', 11643)->get()
        ];
        if ($data !== null) {
            dd($data);
        }
        if ($request->ajax()) {
            $data = $this->objectModel::query();
            $data = $data->orderBy('created_at', 'asc');
            $data = $data->whereNot('status', '0');


            return Datatables::of($data)

                ->addColumn('startDate', function($row) use ($request) {
                        $fromDate = $request->input('start_date');
                        $toDate = $request->input('end_date');
                        $startDate = Carbon::parse($fromDate);
                        $endDate = Carbon::parse($toDate);

                        while ($startDate <= $endDate) {
                            // Create a new row or perform any desired operations for each day
                            $model = new YourModel();
                            $model->date = $startDate->format('Y-m-d');
                            // Add other columns and their values as needed
                            // $model->column_name = $value;
                            $model->save();

                            // Move to the next day
                            $startDate->addDay();
                        }
                        return $startDate;
                    })


                ->addColumn('emp_code_att', function($row){
                    $emp_code_att = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->att_getemp->name_ar.'</a></div>';
                    $created_at = $row->created_at;$updated_at = $row->updated_at;$createdTimestamp = Carbon::parse($created_at);$updatedTimestamp = Carbon::parse($updated_at);$timeDifference = $createdTimestamp->diff($updatedTimestamp);$days = $timeDifference->d;$hours = $timeDifference->h;$minutes = $timeDifference->i;$timeString = '';if ($days > 0) {$timeString .= $days . ' يوم ';}if ($hours > 0) {$timeString .= $hours . ' ساعة ';}$timeString .= $minutes . ' دقيقة';
                    $emp_code_att   .= '<span>   مدة العمل: ' . $timeString. '</span></div>';

                    return $emp_code_att;
                })
                ->addColumn('emp_code_in', function($row){
                    $emp_code_in = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->attendance_time_in.'</a></div>';
                    $emp_code_in .= '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->attendance_date_in.'</a></div>';
                    $emp_code_in  .= '<span> مكان الحضور: ' . $row->getstore->name. '</span><br>';
                    $emp_code_in   .= '<span>  موظف الحضور: ' . $row->getemp_in->name_ar . '</span>';
                    return $emp_code_in;
                })
                ->addColumn('emp_code_out', function($row){
                    $emp_code_out = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->attendance_time_out.'</a></div>';
                    $emp_code_out .= '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->attendance_date_out.'</a></div>';
                    $emp_code_out  .= '<span> مكان الانصراف: ' . $row->getstore_out->name. '</span><br>';
                    if ($row->getemp_out && $row->getemp_out->name_ar)
                    {$emp_code_out .= '<span>  موظف الانصراف: ' . $row->getemp_out->name_ar  . '</span>';
                    } else
                    {$emp_code_out .= '<span>  موظف الانصراف: لم يتم تسجيل موظف الانصراف </span>'; }
                    return $emp_code_out;
                })

                ->filter(function ($instance) use ($request) {
                    if ($request->get('from_date') && $request->get('to_date')) {
                        $instance->whereDate('created_at', '>=', $request->get('from_date'));
                        $instance->whereDate('created_at', '<=', $request->get('to_date'));}
                    if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->where('name_ar', 'LIKE', "%$search%");

                        });
                    }
                })
                ->rawColumns(['emp_code_att', 'emp_code_in', 'emp_code_out', 'startDate'])
                ->make(true);
        }
        return view($this->viewPath .'.emp_index_all');
    }
    public function emp_index_all()
    {
        return view($this->viewPath .'.emp_index_all');
    }
    public function pay_emp_vacation()
    {
        return view($this->viewPath .'.pay_emp_vacation');
    }
    public function getplan_att_emp_vacation(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q ;
            $data = Plan_att_mission::select("name","id","attendance_time_in","attendance_time_out")->where('name','LIKE',"%$search%")
            ->orWhere('id','LIKE',"%$search%")
            ->get();
        }

        return response()->json($data);
    }
    public function store_emp_index_plan(Request $request)
    {
        {
            $rule = [
                'name_ar' => 'required',
                'plan_att_mission_id' => 'required',
                ];
            $validate = Validator::make($request->all(), $rule);
            if ($validate->fails()) {
                return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');}
            $row = Emp_plan_att_mission::create([
                'emp_code' => Auth::guard('admin')->user()->emp_code,
                'emp_code_att' => $request->name_ar,
                'plan_att_mission_id' => $request->plan_att_mission_id,
            ]);
            return redirect('admin/')->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
        }
    }
    public function createin()
    {
        return view($this->viewPath .'.createin');
    }
    public function in_attendance(Request $request)
    {
        $rule = [
            'start_id' => 'required',
            'emp_code_att' => 'required',
        ];
        $emp_code = Employee::find($request->code);
        $isActive = Employee::where('is_active', 1)->where('id', $emp_code->id)->exists();
        if (!$isActive) {
        return redirect()->back()
            ->with('message', 'موظف غير فعال')->with('status', 'error');}
        $count = Attendance::where('emp_code_att', $emp_code->id)->where('status', 0)->count();
        if ($count > 0) {
            return redirect()->back()->with('message', 'تم تسجيل الحضور من قبل')->with('status', 'error');
        } else {
            $row = Attendance::create([
                'start_id' => session()->get('store_sell'),
                'status' => 0, //0 =in - 1 =out - 2 =outexcuse - 3 =returnexcuse - 4 =outno excuse - 5 =returnno excuse
                'att_way_in' => $request->att_way_in ?? 0,
                'emp_code_in' => Auth::guard('admin')->user()->id,
                'emp_code_att' => $emp_code->id,
                'attendance_in_at' => Carbon::now(),
                'lat_in' => $request->lat ?? null,
                'lng_in' => $request->lng ?? null,
                'api_token_in' => $request->api_token_in ?? null,
            ]);
            return redirect()->back()->with('message', 'تم تسجيل الحضور بنجاح')->with('status', 'success');
        }
    }
    public function createout()
    {
        return view($this->viewPath .'.createout');
    }
    public function out_attendance(Request $request)
    {
        $rule = [
        'emp_code_att' => 'required',
        'end_site' => 'required',
        ];
        $emp_code = Employee::find($request->code);
        $data = Attendance::where('emp_code_att', $emp_code->id)
            ->where('status', 0)->first();
        if ($data !== null) {
            $data->update([
                'end_site' => session()->get('store_sell'),
                'status' => 1, //0 =in - 1 =out - 2 =outexcuse - 3 =returnexcuse - 4 =outno excuse - 5 =returnno excuse
                'att_way_in' => $request->att_way_in ?? 0,
                'emp_code_out' => Auth::guard('admin')->user()->id,
                'attendance_out_at' => Carbon::now(),
                'lat_out' => $request->lat ?? null,
                'lng_out' => $request->lng ?? null,
                'status_done' => 0, // 0 = done - 1 = updated_in - 2 = updated_out
                'api_token_out' => $request->api_token_out ?? null,
            ]);
            return redirect()->back()->with('message', 'تم تسجيل الانصراف بنجاح')->with('status', 'success');
        } else {
            return redirect()->back()->with('message', 'برجاء التوقيع بالحضور اولا')->with('status', 'error');
        }
    }
    
    


}

