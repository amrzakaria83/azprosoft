<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Unite;
use DataTables;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UnitesController extends Controller
{

    public function index(Request $request)
    {
        $data = Unite::get();

        if ($request->ajax()) {
            $data = Unite::query();
            $data = $data->orderBy('id', 'DESC');

            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name_ar', function($row){
                    $name_ar = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->name_ar.'</a><div>';
                    $name_ar .= '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->name_en.'</a><div>';

                    return $name_ar;
                })
                ->addColumn('note', function($row){
                    $note = $row->note ;

                    return $note;
                })
                ->addColumn('description', function($row){

                    $description = $row->description;
                    
                    return $description;
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
                                <a href="'.route('admin.unites.show', $row->id).'" class="btn btn-sm btn-icon btn-warning btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-eye-fill fs-1x"></i>
                                </a>
                                <a href="'.route('admin.unites.edit', $row->id).'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
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
                ->rawColumns(['name_ar','description','note','status','checkbox','actions'])
                ->make(true);
        }
        return view('admin.unite.index');
    }

    public function show($id)
    {
        $data = Unite::find($id);
        return view('admin.unite.show', compact('data'));
    }

    public function create()
    {
        return view('admin.unite.create');
    }

    public function store(Request $request)
    {
        $rule = [
            'name_ar' => 'required|string',
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
        $row = Unite::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'type' => $request->type ?? 0,
            'note' => $request->note,
            'description' => $request->description,
            'status' => $request->status ?? 0,
        ]);
        return redirect('admin/unites')->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    public function storemodel(Request $request)
    {
        $rule = [
            'name_ar' => 'required|string',
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
        $row = Unite::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'type' => $request->type ?? 0,
            'note' => $request->note,
            'description' => $request->description,
            'status' => $request->status ?? 0,
        ]);
        return redirect()->back()->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    public function edit($id)
    {
        $data = Unite::find($id);
        return view('admin.unite.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $rule = [
            'name_ar' => 'required|string',
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        } 
        $data = Unite::find($request->id);
        $data->update([
            'emp_id' => Auth::guard('admin')->user()->id,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'type' => $request->type ?? 0,
            'note' => $request->note,
            'description' => $request->description,
            'status' => $request->status ?? 0,
        ]);

        return redirect('admin/unites')->with('message', 'تم التعديل بنجاح')->with('status', 'success');
    }

    public function destroy(Request $request)
    {   

        try{
            Unite::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'error']);
        }
        return response()->json(['message' => 'success']);

    }
}
