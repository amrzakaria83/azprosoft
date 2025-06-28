<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Vacation_emp;
use App\Models\Account_tree;
use DataTables;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Helper;

class Vacation_empsController extends Controller
{

    public function index(Request $request)
    {
        $data = Vacation_emp::get();

        if ($request->ajax()) {
            $data = Vacation_emp::query();
            $data = $data->where('statusmangeraprove', 0);

            $data = $data->orderBy('id', 'DESC');

            
            // $helper = new Helper;
            // $ids = $helper->emp_ids();
            // if (auth()->user()->role_id != 1) {
            //     $data = $data->whereIn('emp_vacation', $ids);
            // }
            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name_ar', function($row){
                    $name_ar = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->getemp->name_ar.'</a>';
                    $vacationrequest = $row->vacationrequest; // "0 = without salary - 1 = 50%salary - 2 = fullsalary
                    if($vacationrequest === 0){
                        $name_ar .= '<span class="text-info">'.trans('lang.no_salary').'</span>';
                    }elseif($vacationrequest === 1){
                        $name_ar .= '<span class="text-warning">'.trans('lang.half_salary').'</span>';
                    }else{ $name_ar .= '<span class="text-danger">'.trans('lang.full_salary').'</span>';}
                    return $name_ar;
                })
                ->addColumn('vactionfrom', function($row){
                    // $vactionfrom = $row->vactionfrom ;
                    $vactionfrom = date('Y-m-d', strtotime($row->vactionfrom));
                    return $vactionfrom;
                })
                ->addColumn('vactionto', function($row){
                    // $vactionto = $row->vactionto ;
                    $vactionto = date('Y-m-d', strtotime($row->vactionto));

                    return $vactionto;
                })
                ->addColumn('duration', function($row){
                    $arrive_time = $row->vactionfrom;
                    if($arrive_time != null){
                        $arrive_time = Carbon::parse($row->vactionfrom);
                    } else{$arrive_time = Carbon::now();}
                    $start_time = $row->vactionto;
                    if($start_time != null){
                        $start_time = Carbon::parse($row->vactionto);
                    } else{$start_time = Carbon::now();}

                    $currentTime = $arrive_time;
                    $timestamp = $start_time;
                    $timeDifference = $currentTime->diff($timestamp);
                    $days = $timeDifference->d;
                    $hours = $timeDifference->h;
                    $minutes = $timeDifference->i;
                    $timeString = '';
                    // if ($days > 0)
                    // {
                        $timeString .= $days . ' يوم ';
                    // }if ($hours > 0) 
                    // {
                    //     $timeString .= $hours . ' ساعة ';
                    // }
                    // $timeString .= $minutes . ' دقيقة';

                    $duration = '<div class="d-flex flex-column"><a href="javascript:;"class="text-gray-800 text-hover-primary mb-1">'
                    .$timeString.
                    '</a></div>';
                    return $duration;
                })
                ->addColumn('noterequest', function($row){
                    $noterequest = '';
                    if ($row->getMedia('attach')->count()) {
                        $noterequest .= ' <a href="'.$row->getFirstMediaUrl('attach').'" target="_blank" > '.trans('lang.attach').' </a><br>';
                    }
                           
                    $noterequest .= $row->noterequest .'<br>';
                    return $noterequest;
                })
                ->addColumn('vacation_couse', function($row){
                    $vacation_couse = $row->getvaccouse->name_ar ;

                    return $vacation_couse;
                })
                ->addColumn('actions', function($row){
                    $actions = '<div class="ms-2">
                                <a href="'.route('admin.vacationemps.edit', $row->id).'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-pencil-square fs-1x"></i>
                                </a>
                                
                            </div>';
                    return $actions;
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('from_time') || $request->get('to_date'))) {
                        $instance->whereDate('vactionfrom', '>=', $request->get('from_time'));
                        $instance->whereDate('vactionfrom', '<=', $request->get('to_date'));
                    }
                    if ($request->get('is_active') == '0' || $request->get('is_active') == '1') {
                        $instance->where('is_active', $request->get('is_active'));
                    }
                    // Search logic
                    if (!empty($request->get('search'))) {
                        $search = $request->get('search'); // Define $search variable
                        $instance->where(function ($query) use ($search) {
                            $query->whereHas('getemp', function ($q) use ($search) {
                                $q->where('name_en', 'LIKE', "%$search%");
                            });
                        });
                    }
                    // if (!empty($request->get('search'))) {
                    //         $instance->where(function($w) use($request){
                    //         $search = $request->get('search');
                    //         $w->orWhere('name_ar', 'LIKE', "%$search%")
                    //         ->orWhere('phone', 'LIKE', "%$search%")
                    //         ->orWhere('email', 'LIKE', "%$search%");
                    //     });
                    // }
                })
                ->rawColumns(['name_ar','duration','vactionfrom','vacation_couse','vactionto','noterequest','checkbox','actions'])
                ->make(true);
        }
        return view('admin.vacationemp.index');
    }

    public function show($id)
    {
        $data = Vacation_emp::find($id);
        return view('admin.vacationemp.show', compact('data'));
    }

    public function create()
    {
        return view('admin.vacationemp.create');

    }

    public function store(Request $request)
    {
        $rule = [
            
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
        // $planexist = Plan_att_mission::where('emp_plan',  $request->id);

        $row = Vacation_emp::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'emp_vacation' => $request->id,
            'vactionfrom' => $request->vactionfrom,
            'vactionto' => $request->vactionto,
            'vacation_couse' => $request->vacation_couse, 
            'vacationrequest' => $request->vacationrequest, // "0 = without salary - 1 = 50%salary - 2 = fullsalary
            'typevacation' => 0 , //0 = without salary - 1 = 50%salary - 2 = fullsalary
            'statusmangeraprove' => 0, // 0 = waitting - 1 = approved - 2 = rejected - 3 = delayed
            'noterequest' => $request->noterequest,
            'status' => 0,
            
        ]);

        if($request->hasFile('attach') && $request->file('attach')->isValid()){
            $row->addMediaFromRequest('attach')->toMediaCollection('attach');
        }

        return redirect('admin/')->with('message', 'Added successfully')->with('status', 'success');
    }

    public function edit($id)
    {
        $data = Vacation_emp::find($id);
        return view('admin.vacationemp.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $rule = [
           
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        } 
        
        $vacation = Vacation_emp::find($request->id);
        $vacation->update([
            'emp_id' => Auth::guard('admin')->user()->id,
            'emp_vacation' => $vacation->emp_vacation,
            'vactionfrommanger' => $request->vactionfrommanger,
            'vactiontomanger' => $request->vactiontomanger,
            'vacation_couse' => $vacation->vacation_couse, 
            'typevacation' => $request->typevacation,  // "0 = without salary - 1 = 50%salary - 2 = fullsalary 
            'statusmangeraprove' => $request->statusmangeraprove, // 0 = waitting - 1 = approved - 2 = rejected - 3 = delayed
            'notemanger' => $request->notemanger,
            'status' => 0,
            
        ]);

        if($request->hasFile('attach') && $request->file('attach')->isValid()){
            $vacation->addMediaFromRequest('attach')->toMediaCollection('attach');
        }

        return redirect('admin/vacationemps')->with('message', 'Modified successfully')->with('status', 'success');
    }

    public function destroy(Request $request)
    {   

        try{
            Vacation_emp::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'error']);
        }
        return response()->json(['message' => 'success']);

    }
    public function indexall(Request $request)
    {
        $data = Vacation_emp::get();

        if ($request->ajax()) {
            $data = Vacation_emp::query();

            $data = $data->orderBy('id', 'DESC');

                        
            // $helper = new Helper;
            // $ids = $helper->emp_ids();
            // if (auth()->user()->role_id != 1) {
            //     $data = $data->whereIn('emp_vacation', $ids);
            // }
            
            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name_ar', function($row){
                    $name_ar = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->getemp->name_en.'</a>';
                    $vacationrequest = $row->vacationrequest; // "0 = without salary - 1 = 50%salary - 2 = fullsalary
                    if($vacationrequest === 0){
                        $name_ar .= '<span class="text-info">'.trans('lang.no_salary').'</span>';
                    }elseif($vacationrequest === 1){
                        $name_ar .= '<span class="text-warning">'.trans('lang.half_salary').'</span>';
                    }else{ $name_ar .= '<span class="text-danger">'.trans('lang.full_salary').'</span>';}
                    $typevacation = $row->typevacation; // "0 = without salary - 1 = 50%salary - 2 = fullsalary
                    if($typevacation == 0){
                        $name_ar .= '<br><span class="text-info">'.trans('lang.director').':'.trans('lang.no_salary').'</span>';
                    }elseif($typevacation == 1){
                        $name_ar .= '<br><span class="text-warning">'.trans('lang.director').':'.trans('lang.half_salary').'</span>';
                    }else{ $name_ar .= '<br><span class="text-danger">'.trans('lang.director').':'.trans('lang.full_salary').'</span>';}
                    return $name_ar;
                })
                ->addColumn('vactionfrom', function($row){
                    // $vactionfrom = $row->vactionfrom ;
                    $vactionfrom = date('Y-m-d', strtotime($row->vactionfrom));
                    return $vactionfrom;
                })
                ->addColumn('vactionto', function($row){
                    // $vactionto = $row->vactionto ;
                    $vactionto = date('Y-m-d', strtotime($row->vactionto));

                    return $vactionto;
                })
                ->addColumn('countdays', function($row){
                        $currentTime = Carbon::parse($row->vactionto);
                        $timestamp = Carbon::parse($row->vactionfrom);
                        $timeDifference = $currentTime->diff($timestamp);
                        $years = $timeDifference->y;
                        $months = $timeDifference->m;
                        $days = $timeDifference->d;
                        $timeString = '';
                        if ($years > 0) {
                            $timeString .= $years .trans('lang.year').'-';
                        }
                        if ($months > 0) {
                            $timeString .= $months .trans('lang.month').'-';
                        }
                        $timeString .= $days . trans('lang.day');
                        $countdays = '<span>'.$timeString.'</span>';
                    // $countdays = $row->countdays ;
                    // $countdays = date('Y-m-d', strtotime($row->countdays));

                    return $countdays;
                })
                ->addColumn('vacation_couse', function($row){
                    $vacation_couse = $row->getvaccouse->name_ar ;

                    return $vacation_couse;
                })
                ->addColumn('noterequest', function($row){
                    $noterequest = $row->noterequest .'<br>';
                    $statusmangeraprove = $row->statusmangeraprove;
                    if($statusmangeraprove === 0){
                        $noterequest .= '<br><span class="text-info">'.trans('lang.director').':'.trans('lang.waiting').trans('lang.approved').'</span>';
                    } elseif($statusmangeraprove === 1){
                        $noterequest .= '<br><span class="text-success">'.trans('lang.director').':'.trans('lang.approved').'</span>';
                    } elseif($statusmangeraprove === 2){
                        $noterequest .= '<br><span class="text-danger">'.trans('lang.director').':'.trans('lang.reject').'</span>';
                    }
                    else{ 
                        $noterequest .= '<br><span class="text-warning">'.trans('lang.director').':'.trans('lang.delay').'</span>';
                    }
                    
                    if ($row->getMedia('attach')->count()) {
                        $noterequest .= '<br>'.'<a href="'.$row->getFirstMediaUrl('attach').'" target="_blank">'.trans('lang.attach').'</a>' ;
                    }
                       

                    $noterequest .= '<br>'.$row->notemanger ;

                    return $noterequest;
                })
                ->addColumn('actions', function($row){
                    $actions = '<div class="ms-2">
                                <a href="'.route('admin.vacationemps.edit', $row->id).'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-pencil-square fs-1x"></i>
                                </a>
                                
                            </div>';
                    return $actions;
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('from_time') || $request->get('to_date'))) {
                        $instance->whereDate('vactionfrom', '>=', $request->get('from_time'));
                        $instance->whereDate('vactionfrom', '<=', $request->get('to_date'));
                    }
                    if (!empty($request->get('emp_vacation')))
                    {
                    $instance->where(function ($query) use ($request) {
                        $query->where('emp_vacation', $request->get('emp_vacation'));
                    });
                    }
                    if ($request->get('is_active') == '0' || $request->get('is_active') == '1') {
                        $instance->where('is_active', $request->get('is_active'));
                    }
                    // Search logic
                    if (!empty($request->get('search'))) {
                        $search = $request->get('search'); // Define $search variable
                        $instance->where(function ($query) use ($search) {
                            $query->whereHas('getemp', function ($q) use ($search) {
                                $q->where('name_en', 'LIKE', "%$search%");
                            });
                        });
                    }
                    // if (!empty($request->get('search'))) {
                    //         $instance->where(function($w) use($request){
                    //         $search = $request->get('search');
                    //         $w->orWhere('name_ar', 'LIKE', "%$search%")
                    //         ->orWhere('phone', 'LIKE', "%$search%")
                    //         ->orWhere('email', 'LIKE', "%$search%");
                    //     });
                    // }
                })
                ->rawColumns(['name_ar','vactionfrom','vacation_couse','vactionto','countdays','noterequest','checkbox','actions'])
                ->make(true);
        }
        return view('admin.vacationemp.indexall');
    }
   
}
