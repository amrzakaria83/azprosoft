<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Vacation_cause;
use DataTables;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Vacation_causesController extends Controller
{

    public function index(Request $request)
    {
        $data = Vacation_cause::get();

        if ($request->ajax()) {
            $data = Vacation_cause::query();
            $data = $data->orderBy('id', 'DESC');

            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name_ar', function($row){
                    $name_ar = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->name_ar ?? ''.'</a><div>';

                    return $name_ar;
                })
                ->addColumn('name_en', function($row){
                    $name_en = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->name_en ?? ''.'</a><div>';

                    return $name_en;
                })
                ->addColumn('note', function($row){
                    $note = $row->note ;

                    return $note;
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
                                <a href="'.route('admin.vacation_causes.show', $row->id).'" class="btn btn-sm btn-icon btn-warning btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-eye-fill fs-1x"></i>
                                </a>
                                <a href="'.route('admin.vacation_causes.edit', $row->id).'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
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
                            $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('name_ar', 'LIKE', "%$search%")
                            ->orWhere('phone', 'LIKE', "%$search%")
                            ->orWhere('email', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['name_ar','name_en','description','note','status','checkbox','actions'])
                ->make(true);
        }
        return view('admin.vacation_cause.index');
    }

    public function show($id)
    {
        $data = Vacation_cause::find($id);
        return view('admin.vacation_cause.show', compact('data'));
    }

    public function create()
    {
        return view('admin.vacation_cause.create');
    }

    public function store(Request $request)
    {
        $rule = [
            'name_en' => 'required|string',
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
        $row = Vacation_cause::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'note' => $request->note,
            'status' => $request->status ?? 0,
        ]);
        return redirect('admin/vacation_causes')->with('message', 'Added successfully')->with('status', 'success');
    }
    public function storemodel(Request $request)
    {
        $rule = [
            'name_en' => 'required|string',
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
        $row = Vacation_cause::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'note' => $request->note,
            'status' => $request->status ?? 0,
        ]);
        return redirect()->back()->with('message', 'Added successfully')->with('status', 'success');
    }
    public function edit($id)
    {
        $data = Vacation_cause::find($id);
        return view('admin.vacation_cause.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $rule = [
            'name_en' => 'required|string',
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        } 
        $data = Vacation_cause::find($request->id);
        $data->update([
            'emp_id' => Auth::guard('admin')->user()->id,
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'note' => $request->note,
            'status' => $request->status ?? 0,
        ]);

        return redirect('admin/vacation_causes')->with('message', 'Modified successfully')->with('status', 'success');
    }

    public function destroy(Request $request)
    {   

        try{
            Vacation_cause::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'error']);
        }
        return response()->json(['message' => 'success']);

    }
}
