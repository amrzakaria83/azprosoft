<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Pur_request;
use App\Models\All_pur_import;
use App\Models\Store_pur_request;
use DataTables;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus; // Add this import
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Pur_requestsController extends Controller
{

    public function index(Request $request)
    {
        // Artisan::call('optimize:clear');
        // Artisan::call('cache:clear');
        // Artisan::call('view:clear');
        // Artisan::call('config:clear');
        $dataallpur = All_pur_import::where('status_request', 0)
        ->select(['id','product_id','quantity'])
        ->get();
        
        $datastreq = Store_pur_request::where('status_request', 0)
        ->select(['id','pro_prod_id','quantity'])
        ->get();

        // Combine and transform the collections
        $combined = $dataallpur->map(function ($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'quantity' => (int)$item->quantity,
                'table' => '0' // Add table identifier
            ];
        })->concat($datastreq->map(function ($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->pro_prod_id,
                'quantity' => (int)$item->quantity,
                'table' => '1' // Add table identifier
            ];
        }));

        $summedQuantities = $combined->groupBy('product_id')->map(function ($group, $productId) {
            return [
                'product_id' => $productId,
                'total_quantity' => $group->sum('quantity'),
                'sources' => $group->map(function ($item) {
                    return [
                        'id' => $item['id'],
                        'table' => $item['table']
                    ];
                })->toArray()
                // 'sources' => $group->count()
            ];
        })->values(); // to reset keys to 0, 1, 2...
        dd($summedQuantities);
        
        dd($datastreq);
        $data = Pur_request::where('status_pur', 0)->get();
        if ($request->ajax()) {
            $data = Pur_request::query();
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
                                <a href="'.route('admin.pur_requests.show', $row->id).'" class="btn btn-sm btn-icon btn-warning btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-eye-fill fs-1x"></i>
                                </a>
                                <a href="'.route('admin.pur_requests.edit', $row->id).'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
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
        return view('admin.pur_request.index');
    }

    public function show($id)
    {
        $data = Pur_request::find($id);
        return view('admin.pur_request.show', compact('data'));
    }

    public function create()
    {
        return view('admin.pur_request.create');
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
        $row = Pur_request::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'note' => $request->note,
            'status' => $request->status ?? 0,
        ]);
        return redirect('admin/pur_requests')->with('message', 'Added successfully')->with('status', 'success');
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
        $row = Pur_request::create([
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
        $data = Pur_request::find($id);
        return view('admin.pur_request.edit', compact('data'));
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
        $data = Pur_request::find($request->id);
        $data->update([
            'emp_id' => Auth::guard('admin')->user()->id,
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'note' => $request->note,
            'status' => $request->status ?? 0,
        ]);

        return redirect('admin/pur_requests')->with('message', 'Modified successfully')->with('status', 'success');
    }

    public function destroy(Request $request)
    {   

        try{
            Pur_request::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'error']);
        }
        return response()->json(['message' => 'success']);

    }
}
