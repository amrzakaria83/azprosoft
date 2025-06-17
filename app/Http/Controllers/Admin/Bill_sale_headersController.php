<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Models\Employee;
use App\Models\Bill_sale_header;
use App\Models\Bill_sale_detail;

use DataTables;
use Validator;
use Auth;

class Bill_sale_headersController extends Controller
{
    protected $viewPath = 'admin.bill_sale_header';
    private $route = 'admin.bill_sale_headers';

    public function __construct(Bill_sale_header $model)
    {
        $this->objectModel = $model;
    }

    public function index(Request $request)
    {
        $data = $this->objectModel::get();

        if ($request->ajax()) {
            $data = $this->objectModel::query();
            // $data = $data->where('id' ,'>', 1);
            $data = $data->orderBy('id', 'DESC');

            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('actions', function($row){
                    $actions = '<div class="ms-2">
                                <a href="'.route($this->route.'.edit', $row->id).'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-pencil-square fs-1x"></i>
                                </a>
                            </div>';
                    return $actions;
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->where('name', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['checkbox','actions'])
                ->make(true);
        }

        return view($this->viewPath .'.index');
    }

    public function show($id)
    {
        $data = $this->objectModel::find($id);
        return view($this->viewPath .'.show', compact('data'));
    }

    public function create()
    {
        return view($this->viewPath .'.create');
    }

    public function store(RoleRequest $request)
    {
        $rule = [
            
            
        ];
        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');}
        $emp_code = Employee::find(Auth::guard('admin')->user()->id)->emp_code;
        $data = $request->validated();
        $row = $this->objectModel::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'emp_code' => $emp_code,
            'total_price' =>  $request->type_emp_att_request,
            'total_tax' => $request->type_emp_att_request,
            'total_extra_discount' => $request->type_emp_att_request,
            'sale_type_prosoft' => $request->type_emp_att_request, // 0 = cash - 1 = delayed - 2 = delivery
            'cust_id' => $request->type_emp_att_request,//azcustomers
            'cust_code' => $request->type_emp_att_request,// code prosoft
            'status' => $request->noterequest,  // 0 = oredred - 1 = done - 3 = cancelled - 4 = paied
            
        ]);
        return redirect(route($this->route . '.index'))->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }

    public function edit($id)
    {
        $data = $this->objectModel::find($id);
        return view($this->viewPath .'.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $rule = [
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        } 
        
        $data = Bill_sale_header::find($request->id);
        $data->update([
            'emp_id' => Auth::guard('admin')->user()->id,
            'total_price' => $request->total_tax,
            'total_tax' => $request->total_tax,
            'total_extra_discount' => $request->total_tax,
            'sale_type_prosoft' => $request->total_tax, // 0 = cash - 1 = delayed - 2 = delivery
            'cust_id' => $request->total_tax,//azcustomers
            'cust_code' => $request->total_tax,// code prosoft
            'status' => $request->noterequest,  // 0 = oredred - 1 = done - 3 = cancelled - 4 = paied
        ]);

        return redirect('admin/')->with('message', 'تم التعديل بنجاح')->with('status', 'success');
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
}
