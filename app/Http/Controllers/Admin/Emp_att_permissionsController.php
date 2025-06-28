<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Emp_att_permission;
use DataTables;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Emp_att_permissionsController extends Controller
{
    protected $viewPath = 'admin.emp_att_permission';
    private $route = 'admin.emp_att_permissions';

    public function __construct(Emp_att_permission $model)
    {
        $this->objectModel = $model;
    }

    public function index(Request $request)
    {
        $data = $this->objectModel::get();

        if ($request->ajax()) {
            $data = Emp_att_permission::query(); 
            $data = $data->where('statusmangeraprove', 0);
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
                    $attendance_out_from = $row->attendance_out_from ;
                    return $attendance_out_from;
                })
                ->addColumn('attendance_in_to', function($row){
                    $attendance_in_to = $row->attendance_in_to ;
                    return $attendance_in_to;
                })
                ->addColumn('note', function($row){
                    $note = $row->note ;
                    return $note;
                })
                ->addColumn('duration', function($row){
                    $arrive_time = $row->attendance_in_to;
                    if($arrive_time != null){
                        $arrive_time = Carbon::parse($row->attendance_in_to);
                    } else{$arrive_time = Carbon::now();}
                    $start_time = $row->attendance_out_from;
                    if($start_time != null){
                        $start_time = Carbon::parse($row->attendance_out_from);
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
                                <a href="'.route('admin.emp_att_permissions.show', $row->id).'" class="btn btn-sm btn-icon btn-warning btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-eye-fill fs-1x"></i>
                                </a>
                                <a href="'.route('admin.emp_att_permissions.edit', $row->id).'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
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
                            // Search the 'getemp' field on the Emp_att_permission model itself
                            $w->orWhere('emp_att_permission', 'LIKE', "%$search%");
                            // Search 'name_en' and 'name_ar' (Arabic) on the related Product model
                            $w->orWhereHas('getemp', function($query) use ($search) {
                                $query->where('name_ar', 'LIKE', "%$search%")
                                      ->orWhere('name_en', 'LIKE', "%$search%"); // Assuming 'name_en' in Product is Arabic
                            });
                            // If you intended to search by supplier email, you would add:
                            // $w->orWhereHas('getsupp', function($query) use ($search) { $query->where('email', 'LIKE', "%$search%"); });
                        });
                    }
                })
                ->rawColumns(['name_ar','duration','attendance_out_from','attendance_in_to','note','status','checkbox','actions'])
                ->make(true);
        }
        return view($this->viewPath .'.index');
    }

    public function show($id)
    {
        $data = Emp_att_permission::find($id);
        return view('admin.emp_att_permission.show', compact('data'));
    }

    public function create()
    {
        return view('admin.emp_att_permission.create');
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
                $attendanceOutFrom = Carbon::createFromFormat('Y-m-d h:i A', $request->attendance_out_from)
                ->format('Y-m-d H:i:s');

                $attendanceInTo = Carbon::createFromFormat('Y-m-d h:i A', $request->attendance_in_to)
                    ->format('Y-m-d H:i:s');
        $row = $this->objectModel::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'emp_att_permission' => Auth::guard('admin')->user()->id,
            'attendance_out_from' => $attendanceOutFrom,
            'attendance_in_to' => $attendanceInTo,
            'emp_att_request' => $request->emp_att_request,
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
        $row = Emp_att_permission::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'emp_att_permission' => Auth::guard('admin')->user()->id,
            'attendance_out_from' => $request->attendance_out_from,
            'attendance_in_to' => $request->attendance_in_to,
            'emp_att_request' => $request->emp_att_request,
            'noterequest' => $request->noterequest,// 0 = without salary - 1 = 50%salary - 2 = fullsalary
            'statusmangeraprove' => 0 ,// 0 = waitting - 1 = approved - 2 = rejected - 3 = delayed (manger)
            'status' => $request->status ?? 0,
        ]);
        return redirect()->back()->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    public function edit($id)
    {
        $data = Emp_att_permission::find($id);
        return view('admin.emp_att_permission.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $rule = [
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        } 
        $data = Emp_att_permission::find($request->id);
        $data->update([
            'emp_id' => Auth::guard('admin')->user()->id,
            'emp_att_permission' => Auth::guard('admin')->user()->id,
            'attendance_out_from' => $request->attendance_out_from,
            'attendance_in_to' => $request->attendance_in_to,
            'emp_att_request' => $request->emp_att_request,
            'noterequest' => $request->noterequest,// 0 = without salary - 1 = 50%salary - 2 = fullsalary
            'statusmangeraprove' => 0 ,// 0 = waitting - 1 = approved - 2 = rejected - 3 = delayed (manger)
            'status' => $request->status ?? 0,
        ]);

        return redirect('admin/')->with('message', 'تم التعديل بنجاح')->with('status', 'success');
    }

    public function destroy(Request $request)
    {   

        try{
            Emp_att_permission::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'error']);
        }
        return response()->json(['message' => 'success']);

    }
    
    public function indexall(Request $request)
    {
        $data = $this->objectModel::get();

        if ($request->ajax()) {
            $data = Emp_att_permission::query(); 
            // $data = $data->where('statusmangeraprove', 0);
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
                    $attendance_out_from = $row->attendance_out_from ;
                    return $attendance_out_from;
                })
                ->addColumn('attendance_in_to', function($row){
                    $attendance_in_to = $row->attendance_in_to ;
                    return $attendance_in_to;
                })
                ->addColumn('note', function($row){
                    $note = $row->note ;
                    return $note;
                })
                ->addColumn('duration', function($row){
                    $arrive_time = $row->attendance_in_to;
                    if($arrive_time != null){
                        $arrive_time = Carbon::parse($row->attendance_in_to);
                    } else{$arrive_time = Carbon::now();}
                    $start_time = $row->attendance_out_from;
                    if($start_time != null){
                        $start_time = Carbon::parse($row->attendance_out_from);
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
                ->addColumn('statusmangeraprove', function($row) {
                    $statusmangeraprove = $row->statusmangeraprove; // 0 = waitting - 1 = approved - 2 = rejected - 3 = delayed (manger)
                    
                    switch ($statusmangeraprove) {
                        case '0':
                            return trans('lang.waitting'). ' '. trans('lang.approved');
                        case '1':
                            return '<span class="text-success">'.trans('lang.approved').'</span>';
                        case '2':
                            return '<span class="text-danger">'.trans('lang.reject').'</span>';
                        case '3':
                            return trans('lang.delay');
                        
                        default:
                            return $statusmangeraprove; // Fallback in case of unexpected value
                    }
                })
                ->addColumn('status', function($row){
                    if($row->status == 0 ) {
                        $status = '<div class="badge badge-light-success fw-bold">مقعل</div>';
                    } else {
                        $status = '<div class="badge badge-light-danger fw-bold">غير مفعل</div>';
                    }
                    
                    return $status;
                })
                // ->addColumn('actions', function($row){
                //     $actions = '<div class="ms-2">
                //                 <a href="'.route('admin.emp_att_permissions.show', $row->id).'" class="btn btn-sm btn-icon btn-warning btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                //                     <i class="bi bi-eye-fill fs-1x"></i>
                //                 </a>
                //                 <a href="'.route('admin.emp_att_permissions.edit', $row->id).'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                //                     <i class="bi bi-pencil-square fs-1x"></i>
                //                 </a>
                //             </div>';
                //     return $actions;
                // })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == '0' || $request->get('status') == '1') {
                        $instance->where('status', $request->get('status'));
                    }
                    if (!empty($request->get('search'))) {
                            $search = $request->get('search'); // Define search string once
                            $instance->where(function($w) use($search){ // Pass $search to closure
                            // Search the 'getemp' field on the Emp_att_permission model itself
                            $w->orWhere('emp_att_permission', 'LIKE', "%$search%");
                            // Search 'name_en' and 'name_ar' (Arabic) on the related Product model
                            $w->orWhereHas('getemp', function($query) use ($search) {
                                $query->where('name_ar', 'LIKE', "%$search%")
                                      ->orWhere('name_en', 'LIKE', "%$search%"); // Assuming 'name_en' in Product is Arabic
                            });
                            // If you intended to search by supplier email, you would add:
                            // $w->orWhereHas('getsupp', function($query) use ($search) { $query->where('email', 'LIKE', "%$search%"); });
                        });
                    }
                })
                ->rawColumns(['name_ar','duration','statusmangeraprove','attendance_out_from','attendance_in_to','note','status','checkbox'])
                ->make(true);
        }
        return view($this->viewPath .'.indexall');
    }

}
