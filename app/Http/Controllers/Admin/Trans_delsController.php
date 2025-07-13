<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Models\Trans_del;
use App\Models\Employee;
use App\Models\Emangeremp;
use App\Models\Pro_store;

use DataTables;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;

class Trans_delsController extends Controller
{

    public function index(Request $request)
    {
        $data = Trans_del::get();

        if ($request->ajax()) {
            $data = Trans_del::query();
            $data = $data->orderBy('id', 'ASC');
            $data = $data->where('status_trans', 1);

            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name', function($row){
                    $currentTime = Carbon::now();
                    $timestamp = Carbon::parse($row->start_time);
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
                    
                    $name = '<div class="d-flex flex-column"><a href="javascript:;"class="text-gray-800 text-hover-primary mb-1">'
                    .$row->getemp->name_ar.'<br><span class="text-info">'
                    .$row->getstorestart->name.'</span>-'
                    .$timeString.
                    '</a></div>';
                    
                    return $name;
                })
                ->addColumn('info', function($row){
                    $type_tran = $row->type_tran;
                    if($type_tran === 0){
                    $info = '<div class="badge badge-light-dark fw-bold fs-4">تحويل</div>';
                    $azname = $row->pro_to_id;
                    if ($azname == null ){
                        $info .= '<div class="badge badge-light-dark fw-bold fs-4">لم يتم تسجيل المستلم</div>';
                    }else{
                        $info .= '<div class="badge badge-light-dark fw-bold fs-4">'.$row->getstoreend->name.'</div>';
                    }
                    } elseif ($type_tran === 1){
                        $pro_no_receit = $row->pro_no_receit;
                        if (!empty($pro_no_receit)) {

                            $info = '<a href="" data-bs-toggle="modal" data-bs-target="#kt_modal_1b" 
                            data-va="' . (!empty($row->pro_val_receit) ? $row->pro_val_receit : '0') . '"
                            data-no="' . $row->pro_no_receit . '" data-id="' . $row->id . '">
                               <div class="badge badge-light-info fw-bold fs-4">
                                   اوردر
                               </div>
                            </a>';
                   
                            $info .= '<div class="badge badge-light-info fw-bold fs-4">
                                        <a href="" data-bs-toggle="modal" data-bs-target="#kt_modal_1b" 
                                        data-va="' . (!empty($row->pro_val_receit) ? $row->pro_val_receit : '0') . '"
                                        data-no="' . $row->pro_no_receit . '" data-id="' . $row->id . '">
                                            ' . $row->pro_no_receit . ' - <span class="text-danger">(' . (!empty($row->pro_val_receit) ? $row->pro_val_receit : '0') . ')</span>
                                        </a>
                                        </div>';
                        } else {
                            $info = '<a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '""
                            data-va="' . (!empty($row->pro_val_receit) ? $row->pro_val_receit : '0') . '">
                                <div class="badge badge-light-info fw-bold fs-4">
                                    اوردر
                                </div>
                            </a>';
                            $info .= '<div class="badge badge-light-info fw-bold fs-4">
                                <a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '""
                                data-va="' . (!empty($row->pro_val_receit) ? $row->pro_val_receit : '0') . '">
                                    ' . $pro_no_receit . ' - <span class="text-danger">(' . (!empty($row->pro_val_receit) ? $row->pro_val_receit : '0') . ')</span>
                                </a>
                            </div>';
                        }
                        
                    } else{
                        $info = '<div class="badge badge-light-dark fw-bold fs-4">'.trans('lang.other').'</div>';
                    }
                    
                    return $info;
                })
                ->addColumn('description', function($row){

                    $description = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->start_time.'</a>';
                    $description .= '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->pro_note.'</a>';

                    
                    return $description;
                })
                
                ->addColumn('actions', function($row){
                    $actions = '<div class="ms-2">
                                <a href="'.url('admin/trans_dels/done'.'/'.$row->id.'/4').'" class="btn btn-sm btn-icon btn-success btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="bi bi bi-check-circle-fill fs-1x"></i>
                                </a>
                                <a href="'.url('admin/trans_dels/cancel'.'/'.$row->id.'/3').'" class="btn btn-sm btn-icon btn-danger btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="bi bi bi-x-circle-fill fs-1x"></i>
                                </a>
                            </div>';
                    return $actions;
                })
                ->filter(function ($instance) use ($request) {
                    
                    if (!empty($request->get('marital_status')) ) {
                        $instance->where('marital_status', $request->get('marital_status'));
                    }
                    
                    if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('name_en', 'LIKE', "%$search%")
                            ->orWhere('marital_status', 'LIKE', "%$search%")
                            ->orWhere('phone', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['name','info','description','actions','checkbox'])
                ->make(true);
        }
        return view('admin.trans_del.index');
    }

    public function show($id)
    {
        $dataconrate = Contact_rate::where('status' , 0)->where('contact_id', $id)->get();
        $datasoc = Social_styl::where('status' , 0)->get();
        $datacont = Contract_dr::where('status' , 0)->get();
        $dataspe = Specialty::where('status' , 0)->get();
        $databragif = Brand_gift::where('status' , 0)->get();
        $datatype = Type_contact::where('status' , 0)->get();
        $data = Trans_del::find($id);
        return view('admin.trans_del.show', compact('data','dataspe','datasoc','datacont','databragif','datatype','dataconrate'));
    }

    public function create()
    {
        $sites = Site::where('active' , 1)->get();
        $dataemp = Employee::where('is_active' , 1)
        ->whereIn('jobs_code' , [4,5,6])
        ->get();

        return view('admin.trans_del.create', compact('dataemp','sites') );
    }

    public function store(Request $request)
    {

        if($request->azaz == 5){

            $row = Trans_del::create([
                'pro_emp_code' => Auth::guard('admin')->user()->id,
                'pro_start_id' => $request->pro_start_id,
                'pro_to_id' => $request->pro_to_id,
                'status_trans' => $request->status_trans ?? 5,//0 = watting delevery - 1 = on delevery - 2 = another delevery - 3 = cancelled - 4 = done - 5 = request delevery
                'pro_del_code' => $request->pro_del_code,
                'type_tran' => $request->type_tran,//0 = transefer - 1 = order
                'urgent' => $request->urgent, //0 = unurgent - 1 = urgent
                'pro_no_receit' => $request->pro_no_receit,
                'pro_val_receit' => $request->pro_val_receit,
                'start_time' => Carbon::now(),
                'pro_note' => $request->pro_note,
                'status' => $request->status ?? 0,
                
            ]);
    
            if($request->hasFile('photo') && $request->file('photo')->isValid()){
                $row->addMediaFromRequest('photo')->toMediaCollection('trans_del');
            }
    
            // $role = Role::find($request->role_id); 
            // $row->syncRoles([]);
            // $row->assignRole($role->name);
    
            // return redirect('admin/trans_dels')->with('message', 'Added successfully')->with('status', 'success');
            $sites = Site::where('active' , 1)->get();
            $dataemp = Employee::where('is_active' , 1)
            ->whereIn('jobs_code' , [4,5,6])
            ->get();
            return redirect()->back()->with('message', 'Added successfully')->with('status', 'success');
        } else {
            $rule = [
                'pro_del_code' => 'required',
                
            ];
            $validate = Validator::make($request->all(), $rule);
            if ($validate->fails()) { 
                $sites = Site::where('active' , 1)->get();
                $dataemp = Employee::where('is_active' , 1)
                ->whereIn('jobs_code' , [4,5,6])
                ->get();
                return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
            } 
            $row = Trans_del::create([
                'pro_emp_code' => Auth::guard('admin')->user()->id,
                'pro_start_id' => $request->pro_start_id,
                'pro_to_id' => $request->pro_to_id,
                'status_trans' => $request->status_trans ?? 1,//0 = watting delevery - 1 = on delevery - 2 = another delevery - 3 = cancelled - 4 = done - 5 = request delevery
                'start_time' => Carbon::now(),
                'pro_del_code' => $request->pro_del_code,
                'type_tran' => $request->type_tran,//0 = transefer - 1 = order
                'urgent' => $request->urgent, //0 = unurgent - 1 = urgent
                'pro_no_receit' => $request->pro_no_receit,
                'pro_val_receit' => $request->pro_val_receit,
                'pro_note' => $request->pro_note,
                'status' => $request->status ?? 0,
                
            ]);
    
            if($request->hasFile('photo') && $request->file('photo')->isValid()){
                $row->addMediaFromRequest('photo')->toMediaCollection('trans_del');
            }
    
            // $role = Role::find($request->role_id);
            // $row->syncRoles([]);
            // $row->assignRole($role->name);
    
            // return redirect('admin/trans_dels')->with('message', 'Added successfully')->with('status', 'success');
            $sites = Site::where('active' , 1)->get();
            $dataemp = Employee::where('is_active' , 1)
            ->whereIn('jobs_code' , [4,5,6])
            ->get();
            return redirect()->back()->with('message', 'Added successfully')->with('status', 'success');
        }
        
    }

    public function edit($id)
    {
        $data = Trans_del::find($id);

        return view('admin.trans_del.edit', compact('data'));
    }

    public function update(Request $request)
    {

        $rule = [
            'pro_del_code' => 'required'
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        } 
        
        $center = Trans_del::find($request->id);
        $data = Trans_del::where('id', $request->id)->update([
            'pro_emp_code' => Auth::guard('admin')->user()->id,
            'pro_start_id' => $request->pro_start_id,
            'pro_to_id' => $request->pro_to_id,
            'status_trans' => $request->status_trans ?? 1,// 0 = watting - 1 = on delevery - 2 = another delevery - 3 = cancelled - 4 = done
            'pro_del_code' => $request->pro_del_code,
            'type_tran' => $request->type_tran,//0 = transefer - 1 = order
            'urgent' => $request->urgent, //0 = unurgent - 1 = urgent
            'pro_no_receit' => $request->pro_no_receit,
            'pro_val_receit' => $request->pro_val_receit,
            'pro_note' => $request->pro_note,
            'status' => $request->status ?? 0,
        ]);

        if($request->hasFile('photo') && $request->file('photo')->isValid()){
            $employee->addMediaFromRequest('photo')->toMediaCollection('trans_del');
        }

        // $role = Role::find($request->role_id);
        // $employee->syncRoles([]);
        // $employee->assignRole($role->name);

        return redirect('admin/trans_dels')->with('message', 'Modified successfully')->with('status', 'success');
    }

    public function destroy(Request $request)
    {   

        try{
            Trans_del::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'error']);
        }
        return response()->json(['message' => 'success']);

    }

    public function done($id,$status)
    {
        $data = Trans_del::where('id',$id);
        $data->update([
            'status_trans' => $status,
            'arrive_time' => carbon::now(),
            'pro_empreturn' => Auth::guard('admin')->user()->id,

        ]);
        $sites = Site::where('active' , 1)->get();
        $dataemp = Employee::where('is_active' , 1)
        ->whereIn('jobs_code' , [4,5,6])
        ->get();
        // return response()->json(['message' => 'success']);

        // return redirect()->route('admin.trans_dels.create', compact('dataemp','sites'))->with('message', 'تم التعديل بنجاح')->with('success');
        // return redirect()->back()->with('message', 'تم التعديل بنجاح')->with('success');
        return redirect()->back()->with('message', 'تم التعديل بنجاح')->with('success');
    }
    public function cancel($id,$status)
    {
        $data = Trans_del::where('id',$id);
        $data->update([
            'status_trans' => $status,
            'arrive_time' => carbon::now(),
            'pro_empreturn' => Auth::guard('admin')->user()->id,
        ]);
        $sites = Site::where('active' , 1)->get();
        $dataemp = Employee::where('is_active' ,1)
        ->whereIn('jobs_code' , [4,5,6])
        ->get();
        return redirect()->back()->with('message', 'تم الالغاء بنجاح')->with('danger');
    }
    public function edit_status($id,$status)
    {
        $data = Trans_del::where('id',$id);
        $data->update([
            'status_trans' => $status,
            'start_time' => carbon::now(),
            'pro_empreturn' => Auth::guard('admin')->user()->id,

        ]);
        $sites = Site::where('active' , 1)->get();
        $dataemp = Employee::where('is_active' , 1)
        ->whereIn('jobs_code' , [4,5,6])
        ->get();
        // return redirect()->route('admin.trans_dels.create', compact('dataemp','sites'))->with('message', 'تم التعديل بنجاح')->with('success');
        return redirect()->back()->with('message', 'تم التعديل بنجاح')->with('success');
    }
    public function edit_to_id($id,$pro_to_id)
    {
        $data = Trans_del::where('id',$id);
        $data->update([
            'pro_to_id' => $pro_to_id,
            'pro_empreturn' => Auth::guard('admin')->user()->id,

        ]);
        $sites = Site::where('active' , 1)->get();
        $dataemp = Employee::where('is_active' , 1)
        ->whereIn('jobs_code' , [4,5,6])
        ->get();
        return redirect()->back()->with('message', 'تم التعديل بنجاح')->with('success');
    }
    public function edit_del($id,$pro_del_code)
    {
        $data = Trans_del::where('id',$id);
        $data->update([
            'pro_del_code' => $pro_del_code,
            'status_trans' => 1, //0 = watting delevery - 1 = on delevery - 2 = another delevery - 3 = cancelled - 4 = done - 5 = request delevery
            'start_time' => Carbon::now(),
            'pro_empreturn' => Auth::guard('admin')->user()->id,

        ]);
        $sites = Site::where('active' , 1)->get();
        $dataemp = Employee::where('is_active' , 1)
        ->whereIn('jobs_code' , [4,5,6])
        ->get();
        return redirect()->back()->with('message', 'تم التعديل بنجاح')->with('success');
    }
  
    public function editno_receit(Request $request)
    {
        $data = Trans_del::find($request->id);
        if (!$data) {
            // Handle case where data is not found
            return redirect()->back()->withErrors(['message' => 'Invalid transaction ID']);
        }
    
        $data->update([
            'pro_no_receit' => $request->pro_no_receit,
            'pro_val_receit' => $request->pro_val_receit,
            'pro_empreturn' => Auth::guard('admin')->user()->id,
        ]);
    
        $sites = Site::where('active', 1)->get();
        $dataemp = Employee::where('is_active', 1)
            ->whereIn('jobs_code', [4, 5, 6])
            ->get();
    
        return redirect()->back()->with('message', 'تم التعديل بنجاح')->with('success');
    }
    public function createmang()
    {
        $sites = Site::where('active' , 1)->get();
        $dataemp = Employee::where('is_active' , 1)
        ->whereIn('jobs_code' , [4,5,6])
        ->get();

        return view('admin.trans_del.createmang', compact('dataemp','sites') );
    }
    public function storemang(Request $request)
    {
        // Skip validation if azaz == 5
        if ($request->azaz != 5) {
            $rule = [
                'pro_del_code' => 'required',
                'pro_start_id' => 'required',
            ];
            $validate = Validator::make($request->all(), $rule);
            
            if ($validate->fails()) { 
                $sites = Site::where('active', 1)->get();
                $dataemp = Employee::where('is_active', 1)
                    ->whereIn('jobs_code', [4,5,6])
                    ->get();
                return redirect()->back()
                    ->with('message', $validate->messages()->first())
                    ->with('status', 'error');
            }
        }

        // Prepare common data
        $commonData = [
            'pro_emp_code' => Auth::guard('admin')->user()->id,
            'pro_start_id' => $request->pro_start_id,
            'pro_to_id' => $request->pro_to_id,
            'pro_del_code' => $request->pro_del_code,
            'type_tran' => $request->type_tran, //0 = transfer - 1 = order
            'urgent' => $request->urgent, //0 = non-urgent - 1 = urgent
            'pro_no_receit' => $request->pro_no_receit,
            'pro_val_receit' => $request->pro_val_receit,
            'start_time' => Carbon::now(),
            'pro_note' => $request->pro_note,
            'status' => $request->status ?? 0,
        ];

        // Handle different azaz cases
        if ($request->azaz == 5) {
            $transData = array_merge($commonData, [
                'status_trans' => $request->status_trans ?? 5, // request delivery
            ]);
        } 
        elseif ($request->azaz == 2) {
            $transData = array_merge($commonData, [
                'status_trans' => $request->status_trans ?? 1, // on delivery
                'start_time' => Carbon::now(),
            ]);
        } 
        else {
            $transData = array_merge($commonData, [
                'status_trans' => $request->status_trans ?? 1, // on delivery
            ]);
        }

        // Create the record
        $row = Trans_del::create($transData);

        // Handle file upload if present
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $row->addMediaFromRequest('photo')->toMediaCollection('trans_del');
        }

        // Get common data for view (if needed)
        $sites = Site::where('active', 1)->get();
        $dataemp = Employee::where('is_active', 1)
            ->whereIn('jobs_code', [4,5,6])
            ->get();

        return redirect()->back()
            ->with('message', 'Added successfully')
            ->with('status', 'success');
    }
    public function indexmang(Request $request)
    {
        $data = Trans_del::get();

        if ($request->ajax()) {
            $data = Trans_del::query();
            $data = $data->orderBy('id', 'ASC');
            $data = $data->where('status_trans', 0);

            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name', function($row){
                    
                    $currentTime = Carbon::now();
                    $timestamp = Carbon::parse($row->created_at);
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
                    
                    // $name .= '<div class="d-flex flex-column"><a href="javascript:edit_status(' . $row->id . ');"class="text-gray-800 text-hover-primary mb-1">'.$timeString.'</a>';
                    $name = '<div class="d-flex flex-column"><a href="javascript:edit_status(' . $row->id . ');"class="text-gray-800 text-hover-primary mb-1">'
                    .$row->getemp->name_ar.'-'
                    .$row->getstorestart->name.'-'
                    .$timeString.
                    '</a>';
                    
                    return $name;
                })
                ->addColumn('info', function($row){
                    $type_tran = $row->type_tran;
                    if($type_tran === 0){
                    $info = '<div class="badge badge-light-dark fw-bold fs-4">تحويل</div>';
                    $azname = $row->pro_to_id;
                    if ($azname == null ){
                        $info .= '<div class="badge badge-light-dark fw-bold fs-4">لم يتم تسجيل المستلم</div>';
                    }else{
                        $info .= '<div class="badge badge-light-dark fw-bold fs-4">'.$row->getstoreend->name.'</div>';
                    }
                    } elseif ($type_tran === 1){
                        $pro_no_receit = $row->pro_no_receit;
                        if (!empty($pro_no_receit)) {
                           
                            $info = '<a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '"">
                                <div class="badge badge-light-info fw-bold fs-4">
                                    اوردر
                                </div>
                            </a>';
                            $info .= '<div class="badge badge-light-info fw-bold fs-4">
                                <a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '"">
                                    ' . $row->pro_no_receit . '
                                </a>
                            </div>';
                        } else {
                            $info = '<a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '"">
                                <div class="badge badge-light-info fw-bold fs-4">
                                    اوردر
                                </div>
                            </a>';
                            $info .= '<div class="badge badge-light-info fw-bold fs-4">
                                <a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '"">
                                    ' . $pro_no_receit . '
                                </a>
                            </div>';
                        }
                        
                    } else{
                        $info = '<div class="badge badge-light-dark fw-bold fs-4">'.trans('lang.other').'</div>';
                    }
                    return $info;
                })
                ->addColumn('description', function($row){

                    $description = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->start_time.'</a>';
                    $description .= '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->pro_note.'</a>';

                    
                    return $description;
                })
                
                ->addColumn('actions', function($row){
                    $actions = '<div class="ms-2">
                                <a href="'.url('admin/trans_dels/done'.'/'.$row->id.'/4').'" class="btn btn-sm btn-icon btn-success btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="bi bi bi-check-circle-fill fs-1x"></i>
                                </a>
                                <a href="'.url('admin/trans_dels/cancel'.'/'.$row->id.'/3').'" class="btn btn-sm btn-icon btn-danger btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="bi bi bi-x-circle-fill fs-1x"></i>
                                </a>
                            </div>';
                    return $actions;
                })
                ->filter(function ($instance) use ($request) {
                    
                    if (!empty($request->get('marital_status')) ) {
                        $instance->where('marital_status', $request->get('marital_status'));
                    }
                    
                    if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('name_en', 'LIKE', "%$search%")
                            ->orWhere('marital_status', 'LIKE', "%$search%")
                            ->orWhere('phone', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['name','info','description','actions','checkbox'])
                ->make(true);
        }
        return view('admin.trans_del.index');
    }
    public function storemangwait(Request $request)
    {
        dd($formData->all());
        $rule = [
            'pro_del_code' => 'required',
            'pro_start_id' => 'required',
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        } 

        $row = Trans_del::create([
            'pro_emp_code' => Auth::guard('admin')->user()->id,
            'pro_start_id' => $request->pro_start_id,
            'pro_to_id' => $request->pro_to_id,
            'status_trans' => $request->status_trans ?? 0,//0 = watting delevery - 1 = on delevery - 2 = another delevery - 3 = cancelled - 4 = done - 5 = request delevery
            'pro_del_code' => $request->pro_del_code,
            'type_tran' => $request->type_tran,//0 = transefer - 1 = order
            'urgent' => $request->urgent, //0 = unurgent - 1 = urgent
            'pro_no_receit' => $request->pro_no_receit,
            'pro_val_receit' => $request->pro_val_receit,
            'pro_note' => $request->pro_note,
            'status' => $request->status ?? 0,
            
        ]);

        if($request->hasFile('photo') && $request->file('photo')->isValid()){
            $row->addMediaFromRequest('photo')->toMediaCollection('trans_del');
        }

        // $role = Role::find($request->role_id);
        // $row->syncRoles([]);
        // $row->assignRole($role->name);

        // return redirect('admin/trans_dels')->with('message', 'Added successfully')->with('status', 'success');
        $sites = Site::where('active' , 1)->get();
        $dataemp = Employee::where('is_active' , 1)
        ->whereIn('jobs_code' , [4,5,6])
        ->get();
        return redirect()->back()->with('message', 'Added successfully')->with('status', 'success');
    }
    public function indexreq(Request $request)
    {
        $data = Trans_del::get();

        if ($request->ajax()) {
            $data = Trans_del::query();
            $data = $data->orderBy('id', 'ASC');
            $data = $data->where('status_trans', 5);

            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name', function($row){
                   
                    $currentTime = Carbon::now();
                    $timestamp = Carbon::parse($row->created_at);
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
                    
                    // $name .= '<div class="d-flex flex-column"><a href="javascript:edit_status(' . $row->id . ');"class="text-gray-800 text-hover-primary mb-1">'.$timeString.'</a>';
                    $name = '<div class="d-flex flex-column"><a href="javascript:edit_del(' . $row->id . ');"class="text-gray-800 text-hover-primary mb-1">'
                    .$row->getstorestart->name ?? ' '.'-'
                    .$timeString.
                    '</a>';
                    
                    return $name;
                })
                ->addColumn('info', function($row){
                    $type_tran = $row->type_tran;
                    if($type_tran === 0){
                    $info = '<div class="badge badge-light-dark fw-bold fs-4">تحويل</div>';
                    $azname = $row->pro_to_id;
                    if ($azname == null ){
                        $info .= '<div class="badge badge-light-dark fw-bold fs-4">لم يتم تسجيل المستلم</div>';
                    }else{
                        $info .= '<div class="badge badge-light-dark fw-bold fs-4">'.$row->getstoreend->name.'</div>';
                    }
                    } elseif ($type_tran === 1){
                        $pro_no_receit = $row->pro_no_receit;
                        if (!empty($pro_no_receit)) {

                            $info = '<a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '""
                            data-va="' . (!empty($row->pro_val_receit) ? $row->pro_val_receit : '0') . '"
                                        data-no="' . $row->pro_no_receit . '" data-id="' . $row->id . '">
                                <div class="badge badge-light-info fw-bold fs-4">
                                    اوردر
                                </div>
                            </a>';
                            $info .= '<div class="badge badge-light-info fw-bold fs-4">
                                <a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '""
                                data-va="' . (!empty($row->pro_val_receit) ? $row->pro_val_receit : '0') . '"
                                        data-no="' . $row->pro_no_receit . '" data-id="' . $row->id . '">
                                    ' . $row->pro_no_receit . '  - <span class="text-danger">(' . (!empty($row->pro_val_receit) ? $row->pro_val_receit : '0') . ')</span>
                                </a>
                            </div>';
                        } else {
                            $info = '<a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '""
                            data-va="' . (!empty($row->pro_val_receit) ? $row->pro_val_receit : '0') . '"
                                        data-no="' . $row->pro_no_receit . '" data-id="' . $row->id . '">
                                <div class="badge badge-light-info fw-bold fs-4">
                                    اوردر
                                </div>
                            </a>';
                            $info .= '<div class="badge badge-light-info fw-bold fs-4">
                                <a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '""
                                data-va="' . (!empty($row->pro_val_receit) ? $row->pro_val_receit : '0') . '"
                                        data-no="' . $row->pro_no_receit . '" data-id="' . $row->id . '">
                                    ' . $pro_no_receit . '  - <span class="text-danger">(' . (!empty($row->pro_val_receit) ? $row->pro_val_receit : '0') . ')</span>
                                </a>
                            </div>';
                        }
                        
                    } else{
                        $info = '<div class="badge badge-light-dark fw-bold fs-4">'.trans('lang.other').'</div>';
                    }
                    return $info;
                })
                ->addColumn('description', function($row){

                    $description = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->start_time.'</a>';
                    $description .= '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->pro_note.'</a>';

                    
                    return $description;
                })
                
                ->addColumn('actions', function($row){
                    $actions = '<div class="ms-2">
                                <a href="'.url('admin/trans_dels/done'.'/'.$row->id.'/4').'" class="btn btn-sm btn-icon btn-success btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="bi bi bi-check-circle-fill fs-1x"></i>
                                </a>
                                <a href="'.url('admin/trans_dels/cancel'.'/'.$row->id.'/3').'" class="btn btn-sm btn-icon btn-danger btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="bi bi bi-x-circle-fill fs-1x"></i>
                                </a>
                            </div>';
                    return $actions;
                })
                ->filter(function ($instance) use ($request) {
                    // if ($request->get('is_active') == '0' || $request->get('is_active') == '1') {
                    //     $instance->where('is_active', $request->get('is_active'));
                    // }
                    if (!empty($request->get('marital_status')) ) {
                        $instance->where('marital_status', $request->get('marital_status'));
                    }
                    
                    if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('name_en', 'LIKE', "%$search%")
                            ->orWhere('marital_status', 'LIKE', "%$search%")
                            ->orWhere('phone', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['name','info','description','actions','checkbox'])
                ->make(true);
        }
        return view('admin.trans_del.index');
    }
    public function indexsite(Request $request)
    {
 
        $data = Trans_del::get();

        if ($request->ajax()) {
            $query1 = Trans_del::query()
                ->where('status_trans', 1)
                ->where('pro_start_id', session()->get('insite'))
                ->orderBy('id', 'ASC');
            $query2 = Trans_del::query()
                ->where('status_trans', 1)
                ->where('pro_to_id', session()->get('insite'))
                ->orderBy('id', 'ASC');
            $query3 = Trans_del::query()
            ->where('status_trans', 5)
            ->where('pro_start_id', session()->get('insite'))
            ->orderBy('id', 'ASC');
            $query4 = Trans_del::query()
            ->where('status_trans', 5)
            ->where('pro_to_id', session()->get('insite'))
            ->orderBy('id', 'ASC');
            // $query5 = Trans_del::query()
            // ->where('status_trans', 0)
            // ->where('pro_to_id', session()->get('insite'))
            // ->orderBy('id', 'ASC');
            // $query6 = Trans_del::query()
            // ->where('status_trans', 0)
            // ->where('pro_start_id', session()->get('insite'))
            // ->orderBy('id', 'ASC');
    
            $data = $query1->union($query2)
            ->union($query3)
            ->union($query4)
            // ->union($query5)
            // ->union($query6)
            ;
            
            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name', function($row){
                    $del = $row->pro_del_code;
                    if($del != null) {
                        $pro_del_code = $row->getemp->name_ar;
                    } else {
                        $pro_del_code = '<span class="text-danger">طلب طيار</span>';
                    }
                    $currentTime = Carbon::now();
                    $timestamp = Carbon::parse($row->start_time);
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
                    
                    $name = '<div class="d-flex flex-column"><a href="javascript:;"class="text-gray-800 text-hover-primary mb-1">'
                    .$pro_del_code.'-'
                    .$row->getstorestart->name.'-'
                    .$timeString.
                    '</a></div>';
                    $status_trans = $row->status_trans;
                    if ($status_trans === 0){
                        $name .= '<div class="ms-2">
                                <a href="'.url('admin/trans_dels/edit_status'.'/'.$row->id.'/1').'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="bi bi bi-check-circle-fill fs-1x"></i>
                                </a>
                                
                            </div>';
                    } 
                    
                    return $name;
                })
                ->addColumn('info', function($row){
                    $type_tran = $row->type_tran;
                    if($type_tran === 0){
                    $info = '<div class="badge badge-light-dark fw-bold fs-4">تحويل</div>'; 
                    $azname = $row->pro_to_id;
                    if ($azname == null ){
                        $info .= '<div class="badge badge-light-dark fw-bold fs-4">لم يتم تسجيل المستلم</div>';
                    }else{
                        $info .= '<div class="badge badge-light-dark fw-bold fs-4">'.$row->getstoreend->name.'</div>';
                    }
                    } elseif ($type_tran === 1){
                        $pro_no_receit = $row->pro_no_receit;
                        if (!empty($pro_no_receit)) {
                           
                            $info = '<a href="" data-bs-toggle="modal" data-bs-target="#kt_modal_1b" 
                            data-va="' . (!empty($row->pro_val_receit) ? $row->pro_val_receit : '0') . '"
                            data-no="' . $row->pro_no_receit . '" data-id="' . $row->id . '">
                               <div class="badge badge-light-info fw-bold fs-4">
                                   اوردر
                               </div>
                            </a>';
                   
                            $info .= '<div class="badge badge-light-info fw-bold fs-4">
                                        <a href="" data-bs-toggle="modal" data-bs-target="#kt_modal_1b" 
                                        data-va="' . (!empty($row->pro_val_receit) ? $row->pro_val_receit : '0') . '"
                                        data-no="' . $row->pro_no_receit . '" data-id="' . $row->id . '">
                                            ' . $row->pro_no_receit . ' - <span class="text-danger">(' . (!empty($row->pro_val_receit) ? $row->pro_val_receit : '0') . ')</span>
                                        </a>
                                        </div>';
                        } else {
                            $info = '<a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '""
                            data-va="' . (!empty($row->pro_val_receit) ? $row->pro_val_receit : '0') . '">
                                <div class="badge badge-light-info fw-bold fs-4">
                                    اوردر
                                </div>
                            </a>';
                            $info .= '<div class="badge badge-light-info fw-bold fs-4">
                                <a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '""
                                data-va="' . (!empty($row->pro_val_receit) ? $row->pro_val_receit : '0') . '">
                                    ' . $pro_no_receit . ' - <span class="text-danger">(' . (!empty($row->pro_val_receit) ? $row->pro_val_receit : '0') . ')</span>
                                </a>
                            </div>';
                        }
                        
                    } else {
                        $info = '<div class="badge badge-light-dark fw-bold fs-4">لم يتم تسجيل نوع الحركة</div>';
                    }
                    return $info;
                })
                ->addColumn('description', function($row){

                    $description = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->start_time.'</a>';
                    $description .= '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->pro_note.'</a>';

                    
                    return $description;
                })
                
                ->addColumn('actions', function($row){
                    $status_trans = $row->status_trans;
                    if ($status_trans === 1){
                        $actions = '<div class="ms-2">
                                <a href="'.url('admin/trans_dels/done'.'/'.$row->id.'/4').'" class="btn btn-sm btn-icon btn-success btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="bi bi bi-check-circle-fill fs-1x"></i>
                                </a>
                                <a href="'.url('admin/trans_dels/cancel'.'/'.$row->id.'/3').'" class="btn btn-sm btn-icon btn-danger btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="bi bi bi-x-circle-fill fs-1x"></i>
                                </a>
                            </div>';
                    } elseif($status_trans === 0) {
                        $actions = '<div class="ms-2">
                                <a href="'.url('admin/trans_dels/edit_status'.'/'.$row->id.'/1').'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="bi bi bi-check-circle-fill fs-1x"></i>
                                </a>
                                <a href="'.url('admin/trans_dels/cancel'.'/'.$row->id.'/3').'" class="btn btn-sm btn-icon btn-danger btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="bi bi bi-x-circle-fill fs-1x"></i>
                                </a>
                            </div>';
                    }elseif($status_trans === 5) {
                        $actions = '<div class="ms-2">

                                <a href="'.url('admin/trans_dels/cancel'.'/'.$row->id.'/3').'" class="btn btn-sm btn-icon btn-danger btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="bi bi bi-x-circle-fill fs-1x"></i>
                                </a>
                            </div>';
                    }else {
                        $actions = '';
                    }
                    
                    return $actions;
                })
                ->filter(function ($instance) use ($request) {
                    // if ($request->get('is_active') == '0' || $request->get('is_active') == '1') {
                    //     $instance->where('is_active', $request->get('is_active'));
                    // }
                    if (!empty($request->get('marital_status')) ) {
                        $instance->where('marital_status', $request->get('marital_status'));
                    }
                    
                    if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('name_en', 'LIKE', "%$search%")
                            ->orWhere('marital_status', 'LIKE', "%$search%")
                            ->orWhere('phone', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['name','info','description','actions','checkbox'])
                ->make(true);
        }
        return view('admin.trans_del.index');
    }
    public function indexsiteondel(Request $request)
    {
 
        $data = Trans_del::get();

        if ($request->ajax()) {
            $query1 = Trans_del::query()
                ->where('status_trans', 0)
                ->where('pro_start_id', session()->get('insite'))
                ->orderBy('id', 'ASC');
            $query2 = Trans_del::query()
                ->where('status_trans', 0)
                ->where('pro_to_id', session()->get('insite'))
                ->orderBy('id', 'ASC');      
    
            $data = $query1->union($query2)
            ;
            
            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name', function($row){
                    $del = $row->pro_del_code;
                    if($del != null) {
                        $pro_del_code = $row->getemp->name_ar;
                    } else {
                        $pro_del_code = '<span class="text-danger">طلب طيار</span>';
                    }
                    $currentTime = Carbon::now();
                    $timestamp = Carbon::parse($row->start_time);
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
                    
                    $name = '<div class="d-flex flex-column"><a href="javascript:;"class="text-gray-800 text-hover-primary mb-1">'
                    .$pro_del_code.'-'
                    .$row->getstorestart->name.'-'
                    .$timeString.
                    '</a></div>';
                    $status_trans = $row->status_trans;
                    if ($status_trans === 0 ){
                        $name .= '<div class="ms-2">
                                <a href="'.url('admin/trans_dels/edit_status'.'/'.$row->id.'/1').'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="bi bi bi-check-circle-fill fs-1x"></i>
                                </a>
                                
                            </div>';
                    } 
                    
                    return $name;
                })
                ->addColumn('info', function($row){
                    $type_tran = $row->type_tran;
                    if($type_tran === 0){
                    $info = '<div class="badge badge-light-dark fw-bold fs-4">تحويل</div>';
                    $azname = $row->pro_to_id;
                    if ($azname == null ){
                        $info .= '<div class="badge badge-light-dark fw-bold fs-4">لم يتم تسجيل المستلم</div>';
                    }else{
                        $info .= '<div class="badge badge-light-dark fw-bold fs-4">'.$row->getstoreend->name.'</div>';
                    }
                    } elseif ($type_tran === 1){
                        $pro_no_receit = $row->pro_no_receit;
                        if (!empty($pro_no_receit)) {
                           
                            $info = '<a href="" data-bs-toggle="modal" data-bs-target="#kt_modal_1b" 
                            data-va="' . (!empty($row->pro_val_receit) ? $row->pro_val_receit : '0') . '"
                            data-no="' . $row->pro_no_receit . '" data-id="' . $row->id . '">
                               <div class="badge badge-light-info fw-bold fs-4">
                                   اوردر
                               </div>
                            </a>';
                   
                            $info .= '<div class="badge badge-light-info fw-bold fs-4">
                                        <a href="" data-bs-toggle="modal" data-bs-target="#kt_modal_1b" 
                                        data-va="' . (!empty($row->pro_val_receit) ? $row->pro_val_receit : '0') . '"
                                        data-no="' . $row->pro_no_receit . '" data-id="' . $row->id . '">
                                            ' . $row->pro_no_receit . ' - <span class="text-danger">(' . (!empty($row->pro_val_receit) ? $row->pro_val_receit : '0') . ')</span>
                                        </a>
                                        </div>';
                        } else {
                            $info = '<a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '""
                            data-va="' . (!empty($row->pro_val_receit) ? $row->pro_val_receit : '0') . '">
                                <div class="badge badge-light-info fw-bold fs-4">
                                    اوردر
                                </div>
                            </a>';
                            $info .= '<div class="badge badge-light-info fw-bold fs-4">
                                <a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '""
                                data-va="' . (!empty($row->pro_val_receit) ? $row->pro_val_receit : '0') . '">
                                    ' . $pro_no_receit . ' - <span class="text-danger">(' . (!empty($row->pro_val_receit) ? $row->pro_val_receit : '0') . ')</span>
                                </a>
                            </div>';
                        }
                        
                    }
                    
                    return $info;
                })
                ->addColumn('description', function($row){

                    $description = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->start_time.'</a>';
                    $description .= '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->pro_note.'</a>';

                    
                    return $description;
                })
                
                ->addColumn('actions', function($row){
                    $status_trans = $row->status_trans;
                    if ($status_trans === 1){
                        $actions = '<div class="ms-2">
                                <a href="'.url('admin/trans_dels/done'.'/'.$row->id.'/4').'" class="btn btn-sm btn-icon btn-success btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="bi bi bi-check-circle-fill fs-1x"></i>
                                </a>
                                <a href="'.url('admin/trans_dels/cancel'.'/'.$row->id.'/3').'" class="btn btn-sm btn-icon btn-danger btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="bi bi bi-x-circle-fill fs-1x"></i>
                                </a>
                            </div>';
                    } elseif($status_trans === 0) {
                        $actions = '<div class="ms-2">
                                <a href="'.url('admin/trans_dels/edit_status'.'/'.$row->id.'/1').'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="bi bi bi-check-circle-fill fs-1x"></i>
                                </a>
                                <a href="'.url('admin/trans_dels/cancel'.'/'.$row->id.'/3').'" class="btn btn-sm btn-icon btn-danger btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="bi bi bi-x-circle-fill fs-1x"></i>
                                </a>
                            </div>';
                    }elseif($status_trans === 5) {
                        $actions = '<div class="ms-2">

                                <a href="'.url('admin/trans_dels/cancel'.'/'.$row->id.'/3').'" class="btn btn-sm btn-icon btn-danger btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="bi bi bi-x-circle-fill fs-1x"></i>
                                </a>
                            </div>';
                    }else {
                        $actions = '';
                    }
                    
                    return $actions;
                })
                ->filter(function ($instance) use ($request) {
                    
                    if (!empty($request->get('marital_status')) ) {
                        $instance->where('marital_status', $request->get('marital_status'));
                    }
                    
                    if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('name_en', 'LIKE', "%$search%")
                            ->orWhere('marital_status', 'LIKE', "%$search%")
                            ->orWhere('phone', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['name','info','description','actions','checkbox'])
                ->make(true);
        }
        return view('admin.trans_del.index');
    }
    public function indexalldelrep(Request $request)
    {
        if ($request->ajax()) {
            $from_time = Carbon::parse($request->get('from_time'))->format('Y-m-d H:i');
            $to_time = Carbon::parse($request->get('to_time'))->format('Y-m-d H:i');
            $az = [$from_time, $to_time];
            $data = Trans_del::orderBy('id', 'DESC')
            ->whereBetween('created_at', [$from_time, $to_time])
            ->whereNotNull('pro_del_code')
            ->get()->groupBy('pro_del_code');

        return Datatables::of($data)
            ->addColumn('checkbox', function($row){
                $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="'.$row[0].'" />
                            </div>';
                return $checkbox;
            })
            ->addColumn('name', function($row) use ($az){
                    $name = '<div class="d-flex flex-column">
                            <a href="'.url('admin/trans_dels/indexreport1/'.$row[0]->pro_del_code.'/'.$az[0].'/'.$az[1]).'" class="" data-kt-menu-trigger="click" data-kt-menu-placement="">
                                '.$row[0]->getemp->name_ar.'
                            </a>
                        </div>';
                
                return $name;
            })
            ->addColumn('info', function($row){
                $total_trans = $row->where('type_tran', 0)->count();
                $total_transcancel = $row->where('type_tran', 0)->where('status_trans', 3)->count();
                $total_trans = $total_trans - $total_transcancel;
                $info = '<div class="badge badge-light-info fw-bold fs-4">'. $total_trans.'</div';
                $info .= '<br><div class="badge badge-light-danger fw-bold fs-4">('. $total_transcancel.')</div';
                return $info;
            })
            ->addColumn('description', function($row){
                $total_order = $row->where('type_tran', 1)->count();
                $total_ordercancel = $row->where('type_tran', 1)->where('status_trans', 3)->count();
                $description = '<div class="badge badge-light-info fw-bold fs-4">'. $total_order.'</div';
                $description .= '<br><div class="badge badge-light-danger fw-bold fs-4">('. $total_ordercancel.')</div';
                
                return $description;
            })
            ->filter(function ($instance) use ($request) {
            if (!empty($request->get('search'))) {
                    $instance->where(function($w) use($request){
                    $search = $request->get('search');
                    $w->orWhere('id', 'LIKE', "%$search%")
                    ;
                });
                }
                })
                ->rawColumns(['name','info','description','checkbox'])
                ->make(true);
        }
        return view('admin.trans_del.index');
    }
    public function indexdel_view($pro_del_code,$fromdate ,$todate)
    {
        $data = Employee::where('is_active' , 1)
        ->whereIn('jobs_code' , [4,5,6])
        ->get();
        $dataname = Employee::find($pro_del_code);
        $fromdatecarb = date('Y-m-d H:i', strtotime($fromdate));
        $todatecarb = date('Y-m-d H:i', strtotime($todate));
        $data1 = Trans_del::where('pro_del_code' , $pro_del_code)
        ->whereDate('created_at', '>=' ,$fromdatecarb)
        ->whereDate('created_at', '<=' ,$todatecarb)
        ->get();
        $total_trans = $data1->where('type_tran', 0)->count();
        $total_order = $data1->where('type_tran', 1)->count();
        $total_canceltrans = $data1->where('type_tran', 0)->where('status_trans', 3)->count();
        $total_cancelorder = $data1->where('type_tran', 1)->where('status_trans', 3)->count();
        $dataall = [$data1];
        return response()->json([
            'data' => $data,
            'data1' => $data1,
            'dataname' => $dataname,
            'fromdatecarb' => $fromdatecarb,
            'todatecarb' => $todatecarb,
            'total_trans' => $total_trans,
            'total_order' => $total_order,
            'total_cancelorder' => $total_cancelorder,
            'total_canceltrans' => $total_canceltrans,
            'dataall' => $dataall,
        ]);
    }
    public function indexdel(Request $request)
    {
        $data = Employee::where('is_active' , 1)
        ->whereIn('jobs_code' , [4,5,6])
        ->get();
        return view('admin.trans_del.report_del', compact('data'));
    }
    public function indexdelreport(Request $request)
    {
        $data = Trans_del::get();
        if ($request->ajax()) {
            $from_time = Carbon::parse($request->get('from_time'))->format('Y-m-d H:i');
            $to_time = Carbon::parse($request->get('to_time'))->format('Y-m-d H:i');
            $data = Trans_del::query();
            $data = $data->orderBy('id', 'ASC');
            $data = $data->whereBetween('created_at', [$from_time, $to_time]);
            $data = $data->where('pro_del_code', $request->get('pro_del_code'));
            return Datatables::of($data)
            ->addColumn('checkbox', function($row){
                $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                            </div>';
                return $checkbox;
            })
            ->addColumn('name', function($row){
                
                $name = '<div class="d-flex flex-column"><a href="javascript:edit_status(' . $row->id . ');"class="text-gray-800 text-hover-primary mb-1">
                <span class="text-danger">'.$row->getstorestart->name.'</span></a>';
                return $name;
            })
            ->addColumn('info', function($row){
                $type_tran = $row->type_tran;
                if($type_tran === 0){
                $info = '<div class="badge badge-light-dark fw-bold fs-4">تحويل</div>';
                $azname = $row->pro_to_id;
                if ($azname == null ){
                    $info .= '<div class="badge badge-light-dark fw-bold fs-4">لم يتم تسجيل المستلم</div>';
                }else{
                    $info .= '<div class="badge badge-light-dark fw-bold fs-4">'.$row->getstoreend->name.'</div>';
                }
                } elseif ($type_tran === 1){
                    $pro_no_receit = $row->pro_no_receit;
                    if (!empty($pro_no_receit)) {
                    $info = '<a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '"">
                        <div class="badge badge-light-info fw-bold fs-4">
                            اوردر
                        </div>
                    </a>';
                    $info .= '<div class="badge badge-light-info fw-bold fs-4">
                        <a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '"">
                            ' . $row->pro_no_receit . '
                        </a>
                    </div>';
                    } else {
                    $info = '<a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '"">
                        <div class="badge badge-light-info fw-bold fs-4">
                            اوردر
                        </div>
                    </a>';
                    $info .= '<div class="badge badge-light-info fw-bold fs-4">
                        <a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '"">
                            ' . $pro_no_receit . '
                        </a>
                    </div>';
                    }
                } elseif($type_tran === 2){
                    $info = '<div class="badge badge-light-dark fw-bold fs-4">اخرى</div>';
                }
                return $info;
            })
            ->addColumn('description', function($row){
            $currentTime = Carbon::parse($row->arrive_time);
            $timestamp = Carbon::parse($row->start_time);
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
            
            $description = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$timeString.'</a>';
                
                return $description;
            })
            ->addColumn('empreturne', function($row){
                $pro_empreturn = Employee::where('pro_emp_code',$row->pro_empreturn)->first();
                $empreturne = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$pro_empreturn->name_ar.'</a>';
                
                return $empreturne;
            })
            ->addColumn('pro_note', function($row){
                $pro_note = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->pro_note.'</a>';
                
                return $pro_note;
            })
            ->addColumn('actions', function($row){
                $actions = '<div class="ms-2">
                        <a href="'.url('admin/trans_dels/done'.'/'.$row->id.'/4').'" class="btn btn-sm btn-icon btn-success btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        <i class="bi bi bi-check-circle-fill fs-1x"></i>
                        </a>
                        <a href="'.url('admin/trans_dels/cancel'.'/'.$row->id.'/3').'" class="btn btn-sm btn-icon btn-danger btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        <i class="bi bi bi-x-circle-fill fs-1x"></i>
                        </a>
                    </div>';
                return $actions;
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('marital_status')) ) {
                    $instance->where('marital_status', $request->get('marital_status'));
                }
                if (!empty($request->get('search'))) {
                        $instance->where(function($w) use($request){
                        $search = $request->get('search');
                        $w->orWhere('name_en', 'LIKE', "%$search%")
                        ->orWhere('marital_status', 'LIKE', "%$search%")
                        ->orWhere('phone', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['name','info','description','pro_note','empreturne','actions','checkbox'])
            ->make(true);
        }
        return view('admin.trans_del.index');
    }
    public function indexreport1($pro_del_code, $fromdate, $todate)
    {
        $pro_del_code = $pro_del_code;
        $name_del = Employee::where('id' ,$pro_del_code)->first();
        $fromdate = $fromdate;
        $todate = $todate;
        return view('admin.trans_del.report_del_det',compact('pro_del_code','fromdate','todate','name_del'));
    }
    public function indexreport(Request $request)
    {
        
        $data = Trans_del::get();
            if ($request->ajax()) {
                
                $from_time = date('Y-m-d H:i',strtotime($request->get('from_time')));
                $to_time = date('Y-m-d H:i',strtotime($request->get('to_time')));
                $data = Trans_del::query()
                ->where('pro_del_code', $request->get('pro_del_code'))
                ->whereBetween('created_at', [$from_time, $to_time]);

            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name', function($row){

                    
                    $name = '<div class="d-flex flex-column"><a href="javascript:edit_status(' . $row->id . ');"class="text-gray-800 text-hover-primary mb-1">
                    <span class="text-info">'.$row->getstorestart->name.'</span></a>';

                    return $name;
                })
                ->addColumn('info', function($row){
                    $type_tran = $row->type_tran ;
                    if($type_tran === 0){
                    $info = '<div class="badge badge-light-dark fw-bold fs-4">تحويل</div>';
                    $azname = $row->pro_to_id;
                    if ($azname == null ){
                        $info .= '<div class="badge badge-light-dark fw-bold fs-4">لم يتم تسجيل المستلم</div>';
                    }else{
                        $info .= '<div class="badge badge-light-dark fw-bold fs-4">'.$row->getstoreend->name.'</div>';
                    }
                    } elseif ($type_tran === 1){
                        $pro_no_receit = $row->pro_no_receit;
                        if (!empty($pro_no_receit)) {
                            $info = '<a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '"">
                                <div class="badge badge-light-info fw-bold fs-4">
                                    اوردر
                                </div>
                            </a>';
                            $info .= '<div class="badge badge-light-info fw-bold fs-4">
                                <a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '"">
                                    ' . $row->pro_no_receit . '
                                </a>
                            </div>';
                        } else {
                            $info = '<a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '"">
                                <div class="badge badge-light-info fw-bold fs-4">
                                    اوردر
                                </div>
                            </a>';
                            $info .= '<div class="badge badge-light-info fw-bold fs-4">
                                <a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '"">
                                    ' . $pro_no_receit . '
                                </a>
                            </div>';
                        }
                        
                    } else {
                        $info = '<div class="badge badge-light-danger fw-bold fs-4">لم يتم تسجيل نوع الحركة</div>';
                    }
                    $status_trans = $row->status_trans;
                    if($status_trans == 3){
                        $info .= '<span class="fs-2 text-danger">cancel</span>';
                    }

                    return $info;
                })
                ->addColumn('description', function($row){
                    $currentTime = Carbon::parse($row->arrive_time);
                    $timestamp = Carbon::parse($row->start_time);
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
                    
                    $description = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$timeString.'</a>';

                    return $description;
                })
                ->addColumn('pro_note', function($row){
                    $pro_empreturn = Employee::where('pro_emp_code',$row->pro_empreturn)->first();
                    if($pro_empreturn){

                        $pro_note = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$pro_empreturn->name_ar.'</a>';
                    } else {
                        
                        $pro_note = '<div class="d-flex flex-column"><a href="javascript:;" class="text-danger text-hover-primary mb-1">بدون</a></div>';
                    }

                    $pro_note .= '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->pro_note.'</a>';

                    
                    return $pro_note;
                })
                ->addColumn('start_time', function($row){
                    $start_time = $row->start_time ?? $row->created_at;

                    return $start_time;
                })
                
                ->addColumn('actions', function($row){
                    $actions = '<div class="ms-2">
                                <a href="'.url('admin/trans_dels/done'.'/'.$row->id.'/4').'" class="btn btn-sm btn-icon btn-success btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="bi bi bi-check-circle-fill fs-1x"></i>
                                </a>
                                <a href="'.url('admin/trans_dels/cancel'.'/'.$row->id.'/3').'" class="btn btn-sm btn-icon btn-danger btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="bi bi bi-x-circle-fill fs-1x"></i>
                                </a>
                            </div>';
                    return $actions;
                })
                ->filter(function ($instance) use ($request) {
                    // if ($request->get('is_active') == '0' || $request->get('is_active') == '1') {
                    //     $instance->where('is_active', $request->get('is_active'));
                    // }
                    if (!empty($request->get('marital_status')) ) {
                        $instance->where('marital_status', $request->get('marital_status'));
                    }
                    
                    if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('name_en', 'LIKE', "%$search%")
                            ->orWhere('marital_status', 'LIKE', "%$search%")
                            ->orWhere('phone', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['name','info','description','start_time','pro_note','actions','checkbox'])
                ->make(true);
        }        
        return view('admin.trans_del.report_del_det');
    }
    

    public function indexall(Request $request)
    {
        $data = Trans_del::get();

        if ($request->ajax()) {
            $data = Trans_del::query();
            $data = $data->orderBy('id', 'ASC');
            // $data = $data->where('status_trans', 4);

            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name', function($row){
                    
                    if($row->pro_del_code){
                        $pro_del_code = $row->getemp->name_ar;
                    } else{$pro_del_code = '';}
                    if($row->pro_start_id){
                        $pro_start_id = $row->getstorestart->name;
                    } else{$pro_start_id = '';}

                    $name = '<div class="d-flex flex-column"><a href="javascript:;"class="text-gray-800 text-hover-primary mb-1">'
                    .$pro_del_code.'<span class="text-info">-'
                    .$pro_start_id.'</span>'.
                    '</a></div>';
                    return $name;
                })
                ->addColumn('duration', function($row){
                    $arrive_time = $row->arrive_time;
                    if($arrive_time != null){
                        $arrive_time = Carbon::parse($row->arrive_time);
                    } else{$arrive_time = Carbon::now();}
                    $start_time = $row->start_time;
                    if($start_time != null){
                        $start_time = Carbon::parse($row->start_time);
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

                ->addColumn('typetran', function($row){
                    $type_tranrow = $row->type_tran;
                    if($type_tranrow == 0){
                    $typetran = '<div class="badge badge-light-dark fw-bold fs-4">تحويل</div>';
                    $azname = $row->pro_to_id;
                    if ($azname == null ){
                        $typetran .= '<div class="badge badge-light-dark fw-bold fs-4">لم يتم تسجيل المستلم</div>';
                    }else{
                        $typetran .= '<div class="badge badge-light-dark fw-bold fs-4">'.$row->getstoreend->name.'</div>';
                    }
                    } elseif ($type_tranrow == 1){
                        $pro_no_receit = $row->pro_no_receit;
                        if (!empty($pro_no_receit)) {
                           
                            $typetran = '<a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '"">
                                <div class="badge badge-light-info fw-bold fs-4">
                                    اوردر
                                </div>
                            </a>';
                            $typetran .= '<div class="badge badge-light-info fw-bold fs-4">
                                <a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '"">
                                    ' . $row->pro_no_receit . '
                                </a>
                            </div>';
                        } else {
                            $typetran = '<a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '"">
                                <div class="badge badge-light-info fw-bold fs-4">
                                    اوردر
                                </div>
                            </a>';
                            $typetran .= '<div class="badge badge-light-info fw-bold fs-4">
                                <a href=""  data-bs-toggle="modal" data-bs-target="#kt_modal_1b" data-id="' . $row->id . '"">
                                    ' . $pro_no_receit . '
                                </a>
                            </div>';
                        }
                        
                    } else {
                        $typetran = '<div class="badge badge-light-dark fw-bold fs-4">لم يتم تسجيل نوع الحركة</div>';
                    }
                    
                    return $typetran;
                })
                ->addColumn('status_trans', function($row){ //2 = another delevery - 3 = cancelled - 4 = done - 5 = request delevery
                    $status_transvalue = $row->status_trans;
                    if($status_transvalue == 0){
                        $status_trans = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">انتظار استلام الطيار</a></div>';
                        
                    } elseif($status_transvalue == 1){
                        $status_trans = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">مع الطيار </a></div>';

                    }elseif($status_transvalue == 2){
                        $status_trans = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">نقل الى طيار لآخر </a></div>';

                    }elseif($status_transvalue == 3){
                        $status_trans = '<div class="d-flex flex-column"><a href="javascript:;" class="text-danger text-hover-primary mb-1">تم الالغاء</a></div>';

                    }elseif($status_transvalue == 4){
                        $status_trans = '<div class="d-flex flex-column"><a href="javascript:;" class="text-success text-hover-primary mb-1">تم</a></div>';

                    }elseif($status_transvalue == 4){
                        $status_trans = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">طلب طيار</a></div>';

                    }

                    return $status_trans;
                })
                ->addColumn('start_time', function($row){
                    $start_time = $row->start_time ?? $row->created_at;

                    return $start_time;
                })
                ->addColumn('description', function($row){

                    // $description = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->start_time.'</a>';
                    $description = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->pro_note.'</a>';

                    
                    return $description;
                })
                ->addColumn('value_order', function($row) {
                    $value_order = '';
                    $pro_val_receit = $row->pro_val_receit;
                    
                    if (!empty($pro_val_receit)) {
                        $value_order = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$pro_val_receit.'</a></div>';
                    }
                    
                    return $value_order;
                })
                
                
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('from_time') || $request->get('to_date'))) {
                            $instance->whereDate('created_at', '>=', $request->get('from_time'));
                            $instance->whereDate('created_at', '<=', $request->get('to_date'));
                        }
                    // if ($request->get('is_active') == '0' || $request->get('is_active') == '1') {
                    //     $instance->where('is_active', $request->get('is_active'));
                    // }
                    // if (!empty($request->get('type_tran')) && NotNull($request->get('type_tran'))  ) {
                    //     $instance->where('type_tran', $request->get('type_tran'));
                    // }
                    if (!empty($request->get('type_tran')) && $request->has('type_tran')) {
                        $instance->where('type_tran', $request->get('type_tran'));
                    }
                    if (!empty($request->get('pro_no_receit')) ) {
                        $instance->where('pro_no_receit', $request->get('pro_no_receit'));
                    }
                    if (!empty($request->get('pro_val_receit'))) {
                        $instance->where('pro_val_receit', 'LIKE', '%' . $request->get('pro_val_receit') . '%');
                    }
                    if (!empty($request->get('pro_start_id')) && $request->has('pro_start_id')) {
                        $instance->where('pro_start_id', $request->get('pro_start_id'));
                    }
                    
                    if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('pro_no_receit', 'LIKE', "%$search%")
                            ->orWhere('status_trans', 'LIKE', "%$search%")
                            ->orWhere('type_tran', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['name','typetran','description','value_order','start_time','duration','status_trans','checkbox'])
                ->make(true);
        }
        return view('admin.trans_del.indexallaz');
    }
    public function indexalldelrepdura(Request $request, $from_time, $to_time, $duration)
    {
            // Decode the duration array
        $duration = json_decode(urldecode($duration), true);
        // $serches = [$from_time, $to_time, $duration];
        $serches = [
            $from_time,
            $to_time,
            implode(', ', $duration) // Convert array to string for display
        ];
        
        $query = Trans_del::with('getemp')
            ->whereBetween('created_at', [$from_time, $to_time])
            ->whereNotNull('pro_del_code')
            ->orderBy('id', 'DESC');

        // Get all data first
        $allData = $query->get();

        // Filter records by duration and calculate remaining
        $filteredData = $allData->filter(function($del) use ($duration) {
            if (!$del->start_time || !$del->arrive_time) {
                return false;
            }

            $differenceInMinutes = Carbon::parse($del->start_time)
                ->diffInMinutes(Carbon::parse($del->arrive_time));
                
            // Store the comparison result for later use
            $del->meets_duration = match($del->type_tran) {
                0 => $differenceInMinutes <= $duration[0],
                1 => $differenceInMinutes <= $duration[1],
                2 => $differenceInMinutes <= $duration[2],
                default => false,
            };
            
            return $del->meets_duration;
        });

        // Calculate remaining records (those that don't meet duration)
        $remainingData = $allData->reject(function($del) {
            return $del->meets_duration ?? false;
        });
         // Group remaining data by pro_del_code for exceeded counts
        $remainingGrouped = $remainingData->groupBy('pro_del_code');
        
        // Group by pro_del_code and compute counts
        $groupedData = $filteredData->groupBy('pro_del_code')->map(function ($group, $delCode) use ($remainingGrouped) {
            // Get corresponding remaining group if exists
            $remainingGroup = $remainingGrouped->get($delCode, collect());
            
            return [
                'items' => $group,
                'transfers_done' => $group->where('type_tran', 0)->where('status_trans', 4)->count(),
                'orders_done' => $group->where('type_tran', 1)->where('status_trans', 4)->count(),
                'others_done' => $group->where('type_tran', 2)->where('status_trans', 4)->count(),
                'transfers_cancelled' => $group->where('type_tran', 0)->where('status_trans', 3)->count(),
                'orders_cancelled' => $group->where('type_tran', 1)->where('status_trans', 3)->count(),
                'others_cancelled' => $group->where('type_tran', 2)->where('status_trans', 3)->count(),
                'transfers_exceeded' => $remainingGroup->where('type_tran', 0)->where('status_trans', 4)->count(),
                'orders_exceeded' => $remainingGroup->where('type_tran', 1)->where('status_trans', 4)->count(),
                'others_exceeded' => $remainingGroup->where('type_tran', 2)->where('status_trans', 4)->count(),
            ];
        });

        // Calculate remaining counts by type
        $remainingCounts = [
            'transfers' => $remainingData->where('type_tran', 0)->count(),
            'orders' => $remainingData->where('type_tran', 1)->count(),
            'others' => $remainingData->where('type_tran', 2)->count(),
        ];

        // Total counts
        $totalCounts = [
            'transfers' => $allData->where('type_tran', 0)->count(),
            'orders' => $allData->where('type_tran', 1)->count(),
            'others' => $allData->where('type_tran', 2)->count(),
        ];

        return view('admin.trans_del.indexalldelrepdura', compact(
            'serches',
            'groupedData',
            'remainingCounts',
            'totalCounts'
        ));
    }
   
    public function delrepdura()
    {
        
        return view('admin.trans_del.indexalldelrepdura' );
    }

}
