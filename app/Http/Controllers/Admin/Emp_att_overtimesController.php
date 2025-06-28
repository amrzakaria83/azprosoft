<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Emp_att_overtime;
use DataTables;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Emp_att_overtimesController extends Controller
{
    protected $viewPath = 'admin.emp_att_overtime';
    private $route = 'admin.emp_att_overtimes';

    public function __construct(Emp_att_overtime $model)
    {
        $this->objectModel = $model;
    }

    public function index(Request $request)
    {
        $data = $this->objectModel::get();

        if ($request->ajax()) {
            $data = Emp_att_overtime::query();
            $data = $data->orderBy('id', 'DESC');

            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name_ar', function($row){
                        $name_ar = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->getemp->name_ar ?? $row->getemp->name_en.'</a><div>';
                    return $name_ar;
                })
                ->addColumn('attendance_out_from', function($row){
                    $attendance_out_from = $row->attendance_in_over_from ;
                    return $attendance_out_from;
                })
                ->addColumn('attendance_in_to', function($row){
                    $attendance_in_to = $row->attendance_out_over_to ;
                    return $attendance_in_to;
                })
                ->addColumn('note', function($row){
                    $note = $row->note ;
                    return $note;
                })
                ->addColumn('duration', function($row){
                    $arrive_time = $row->attendance_in_over_from;
                    if($arrive_time != null){
                        $arrive_time = Carbon::parse($row->attendance_in_over_from);
                    } else{$arrive_time = Carbon::now();}
                    $start_time = $row->attendance_out_over_to;
                    if($start_time != null){
                        $start_time = Carbon::parse($row->attendance_out_over_to);
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
                ->addColumn('type_emp_att_request', function($row){
                    if($row->type_emp_att_request == 0 ) {
                        $type_emp_att_request = '<div class="badge badge-light-success fw-bold">'.trans('lang.normal_rate').'</div>';
                    } else {
                        $type_emp_att_request = '<div class="badge badge-light-danger fw-bold">'.trans('lang.extra_rate').'</div>';
                    }
                    
                    return $type_emp_att_request;
                })
                ->addColumn('noterequest', function($row){
                    // $noterequest = $row->noterequest .'<br>';
                    $statusmangeraprove = $row->statusmangeraprove;
                    if($statusmangeraprove === 0){
                        $noterequest = '<br><span class="text-info">'.trans('lang.director').':'.trans('lang.waiting').trans('lang.approved').'</span>';
                    } elseif($statusmangeraprove === 1){
                        $noterequest = '<br><span class="text-success">'.trans('lang.director').':'.trans('lang.approved').'</span>';
                    } elseif($statusmangeraprove === 2){
                        $noterequest = '<br><span class="text-danger">'.trans('lang.director').':'.trans('lang.reject').'</span>';
                    }
                    else{ 
                        $noterequest = '<br><span class="text-warning">'.trans('lang.director').':'.trans('lang.delay').'</span>';
                    }
                    
                    $noterequest .= '<br>'.$row->notemanger ;

                    return $noterequest;
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
                    if (!empty($request->get('from_time') || $request->get('to_date'))) {
                        $instance->whereDate('attendance_out_over_to', '>=', $request->get('from_time'));
                        $instance->whereDate('attendance_out_over_to', '<=', $request->get('to_date'));
                    }
                    
                    if ($request->get('statusmangeraprove') != Null)
                    {
                    $instance->where(function ($query) use ($request) {
                        $query->where('statusmangeraprove', $request->get('statusmangeraprove'));
                    });
                    }
                    if ($request->get('status') == '0' || $request->get('status') == '1') {
                        $instance->where('status', $request->get('status'));
                    }
                    if (!empty($request->get('search'))) {
                            $search = $request->get('search'); // Define search string once
                            $instance->where(function($w) use($search){ // Pass $search to closure
                            // Search the 'product_name' field on the Emp_att_overtime model itself
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
                ->rawColumns(['name_ar','duration','attendance_out_from','attendance_in_to','noterequest','type_emp_att_request','note','status','checkbox','actions'])
                ->make(true);
        }
        return view($this->viewPath .'.index');
    }

    public function show($id)
    {
        $data = Emp_att_overtime::find($id);
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
        
            // Convert datetime format from 'Y-m-d h:i A' to 'Y-m-d H:i:s'
                $attendanceOutFrom = Carbon::createFromFormat('Y-m-d h:i A', $request->attendance_in_over_from)
                ->format('Y-m-d H:i:s');

                $attendanceInTo = Carbon::createFromFormat('Y-m-d h:i A', $request->attendance_out_over_to)
                    ->format('Y-m-d H:i:s');
        $row = $this->objectModel::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'emp_att_overtime' => Auth::guard('admin')->user()->id,
            'attendance_in_over_from' => $attendanceOutFrom,
            'attendance_out_over_to' => $attendanceInTo,
            'type_emp_att_request' => $request->type_emp_att_request,//0 = normal rate - 1 = over rate 
            'noterequest' => $request->noterequest,// 0 = without salary - 1 = 50%salary - 2 = fullsalary
            'statusmangeraprove' => 0 ,// 0 = waitting - 1 = approved - 2 = rejected - 3 = delayed (manger)
            'status' => $request->status ?? 0,
        ]);
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
        $data = Emp_att_overtime::find($id);
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
        // Convert datetime format from 'Y-m-d h:i A' to 'Y-m-d H:i:s'
        $attendanceOutFrom = Carbon::createFromFormat('Y-m-d h:i A', $request->attendance_in_over_from)
        ->format('Y-m-d H:i:s');

        $attendanceInTo = Carbon::createFromFormat('Y-m-d h:i A', $request->attendance_out_over_to)
            ->format('Y-m-d H:i:s');
        $data = Emp_att_overtime::find($request->id);
        $data->update([
            'emp_id' => Auth::guard('admin')->user()->id,
            'emp_att_overtime' => Auth::guard('admin')->user()->id,
            'attendance_in_over_from_manger' => $request->attendance_in_over_from,
            'attendance_out_over_to_manger' => $request->attendance_out_over_to,
            'type_emp_att_request' => $request->type_emp_att_request,//0 = normal rate - 1 = over rate 
            'noterequest' => $request->noterequest,// 0 = without salary - 1 = 50%salary - 2 = fullsalary
            'statusmangeraprove' => $request->statusmangeraprove,// 0 = waitting - 1 = approved - 2 = rejected - 3 = delayed (manger)
            'status' => $request->status ?? 0,
        ]);

        return redirect('admin/')->with('message', 'تم التعديل بنجاح')->with('status', 'success');
    }

    public function destroy(Request $request)
    {   

        try{
            Emp_att_overtime::whereIn('id',$request->id)->delete();
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
