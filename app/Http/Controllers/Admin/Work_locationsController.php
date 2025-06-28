<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Work_location;
use DataTables;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Work_locationsController extends Controller
{
    protected $viewPath = 'admin.work_location';
    private $route = 'admin.work_locations';

    public function __construct(Work_location $model)
    {
        $this->objectModel = $model;
    }

    public function index(Request $request)
    {
        $data = $this->objectModel::get();

        if ($request->ajax()) {
            $data = Work_location::query();
            $data = $data->orderBy('id', 'DESC');

            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name_ar', function($row){


                        $name_ar = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->name_ar ?? $row->name_en.'</a><div>';


                    return $name_ar;
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
                                <a href="'.route('admin.work_locations.show', $row->id).'" class="btn btn-sm btn-icon btn-warning btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-eye-fill fs-1x"></i>
                                </a>
                                <a href="'.route('admin.work_locations.edit', $row->id).'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
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
                            // Search the 'product_name' field on the Work_location model itself
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
                ->rawColumns(['name_ar','note','status','checkbox','actions'])
                ->make(true);
        }
        return view($this->viewPath .'.index');
    }

    public function show($id)
    {
        $data = Work_location::find($id);
        return view('admin.work_location.show', compact('data'));
    }

    public function create()
    {
        return view('admin.work_location.create');
    }

    public function store(Request $request)
    {

        $rule = [
        'name_ar' => 'required',
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
        
        $row = $this->objectModel::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'note' => $request->note,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'status' => $request->status ?? 0,
        ]);
        return redirect(route($this->route . '.index'))->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    public function storemodel(Request $request)
    {
        $rule = [
            'name_ar' => 'required',
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
        $row = Work_location::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'note' => $request->note,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'status' => $request->status ?? 0,
        ]);
        return redirect()->back()->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    public function edit($id)
    {
        $data = Work_location::find($id);
        return view('admin.work_location.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $rule = [
            'name_ar' => 'required',
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        } 
        $data = Work_location::find($request->id);
        $data->update([
            'emp_id' => Auth::guard('admin')->user()->id,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'note' => $request->note,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'status' => $request->status ?? 0,
        ]);

        return redirect('admin/work_locations')->with('message', 'تم التعديل بنجاح')->with('status', 'success');
    }

    public function destroy(Request $request)
    {   

        try{
            Work_location::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'error']);
        }
        return response()->json(['message' => 'success']);

    }
    

}
