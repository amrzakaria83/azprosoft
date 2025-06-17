<?php

namespace App\Http\Controllers\Subadmin;
set_time_limit(3600);
ini_set('max_execution_time', 4800);


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Azcustomer;
use \Yajra\Datatables\Datatables;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Str;

use Validator;

class AzcustomersController extends Controller
{

    public function index(Request $request)
    {
        $data = azcustomer::get();

        if ($request->ajax()) {
            $data = azcustomer::query();
            $data = $data->orderBy('id', 'DESC');

            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('cust_name_ar', function($row){
                    $cust_name_ar = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->cust_name_ar.'</a>';
                    $cust_name_ar .= '<span>'.$row->cust_code.'</span></div>';
                    return $cust_name_ar;
                })
                ->addColumn('phone1', function($row) {
                    if (!$row->phone1) {
                        return '<span>no phone add</span>';
                    }
                    $phone1 = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->phone1.'</a>';
                    return $phone1;
                })
                ->addColumn('phone2', function($row) {
                    if (!$row->phone2) {
                        return '<span>no phone add</span>';
                    }
                    $phone2 = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->phone2.'</a>';
                    return $phone2;
                })
                ->addColumn('address1', function($row) {
                    $addresses = [];

                    if (!empty($row->address1) && !in_array($row->address1, $addresses)) {
                        $addresses[] = $row->address1;
                    }
                    if (!empty($row->address2) && !in_array($row->address2, $addresses)) {
                        $addresses[] = $row->address2;
                    }
                    if (!empty($row->address3) && !in_array($row->address3, $addresses)) {
                        $addresses[] = $row->address3;
                    }
                    if (!empty($row->address4) && !in_array($row->address4, $addresses)) {
                        $addresses[] = $row->address4;
                    }
                    if (!empty($row->address5) && !in_array($row->address5, $addresses)) {
                        $addresses[] = $row->address5;
                    }
                    $address1 = implode('<br>', $addresses);
                    return $address1;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('is_active') == '0' || $request->get('is_active') == '1') {
                        $instance->where('is_active', $request->get('is_active'));
                    }
                    if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('cust_name_ar', 'LIKE', "%$search%")
                            ->orWhere('phone1', 'LIKE', "%$search%")
                            ->orWhere('phone2', 'LIKE', "%$search%")
                            ->orWhere('address1', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['cust_name_ar','phone1','phone2','address1','checkbox'])
                ->make(true);
        }
        return view('subadmin.azcustomer.index');
    }

    public function updatephone()
    {
        $customers = azcustomer::all();

        foreach ($customers as $customer) {
            $phoneNumber = $customer->phone1;

            if (!Str::startsWith($phoneNumber, '0')) {
                $phoneNumber = '0' . $phoneNumber;
                $customer->phone1 = $phoneNumber;
                $customer->save();
            }
        }
    }
    public function updatephone2()
    {
        $customers = azcustomer::all();

        foreach ($customers as $customer) {
            $phoneNumber = $customer->phone2;

            if ($phoneNumber && !Str::startsWith($phoneNumber, '0')) {
                $phoneNumber = '0' . $phoneNumber;
                $customer->phone2 = $phoneNumber;
                $customer->save();
            }
        }
    }
    public function import () {
        return view('subadmin.azcustomer.import');
    }
    public function importfile (Request $request)
    {

        $data = (new FastExcel)->import($request->file, function ($line) {
            
            Azcustomer::create([
                'cust_id'=> $line['cust_id'],
                'name_ar'=> $line['cust_name'],
                'name_en'=> "no name add",
                'phone1'=> $line['cust_tel1'],
                'phone2'=> $line['cust_tel2'],
                'address1'=> $line['cust_addr'],
                'address2'=> $line['cust_addr1'],
                'address3'=> $line['cust_addr2'],
                'address4'=> $line['cust_addr3'],
                'address5'=> $line['cust_addr4'],
                'note'=> "no note add",
                'active'=> $line['active'],
                'emp_stat'=> $line['up_emp_id'],
                'payment'=> $line['p_type'],
                'delay_value_max'=> $line['cust_max_money'],
                'offer'=> $line['price_type'],
                
            ]);

            return $line;
        });
        return view('subadmin.azcustomer.index', compact('data'));
    }
}
