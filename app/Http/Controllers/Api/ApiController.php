<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use App\Models\Employee;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Models\Event;
use App\Http\Resources\EventResource;
use App\Models\Type_expense;
use App\Models\Expense_request;
use App\Http\Resources\Expense_requestResource;
use App\Models\Vacationemp;
use App\Http\Resources\VacationempResource;
use App\Models\Type_visit;
use App\Models\Type_center;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Models\Center;
use App\Http\Resources\CenterResource;
use App\Models\List_contac;
use App\Models\Social_styl;
use App\Models\Cut_sale;
use App\Http\Resources\CustomerResource;
use App\Models\Sale_type;
use App\Models\Bill_sale_header;
use App\Models\Bill_sale_detail;
use App\Models\Cust_collection;
use App\Models\Trans_cust;
use App\Models\Refund_sale;
use App\Http\Resources\TransactionResource;
use App\Models\Refund_cause;

use App\Models\Contact;

use App\Http\Resources\ContactResource;
use App\Models\Area;
use App\Models\Specialty;
use App\Models\Type_contact;
use App\Models\Plan_visit;
use App\Http\Resources\PlanvisitResource;
use App\Models\Visit;
use App\Http\Resources\VisitResource;

Use Carbon\Carbon;
use Validator;


class ApiController extends Controller
{

    // #################   Student App   ####################

    public function settings()
    {
        $data = Setting::find(1);
        
        $results = new SettingResource($data);
        return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $results]);
    }

    public function getAllNotification($employee_id)
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $data = Notification::where('employee_id', $employee_id)->orderBy('id', 'DESC')->paginate(10);

        $results = NotificationResource::collection($data)->response()->getData();

        if(count($data) == 0) {
            return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
        } else {
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $results]);
        }
        
    }

    public function getEvents()
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $data = Event::orderBy('id', 'DESC')->paginate(10);

        $results = EventResource::collection($data)->response()->getData();

        if(count($data) == 0) {
            return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
        } else {
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $results]);
        }
        
    }

    public function getEventDetails($id)
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $data = Event::orderBy('id', 'DESC')->find($id);

        if(!$data) {
            return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
        } else {
            $results = new EventResource($data);

            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $results]);
        }
        
    }

    public function getHomeNotification($employee_id)
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $data = Notification::where('employee_id', $employee_id)->orderBy('id', 'DESC')->take(5)->paginate(5);

        $results = NotificationResource::collection($data)->response()->getData();

        if(count($data) == 0) {
            return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
        } else {
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $results]);
        }
        
    }

    public function getExpenses($employee_id)
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $data = Expense_request::where('emp_id', $employee_id)->orderBy('id', 'DESC')->paginate(10);

        $results = Expense_requestResource::collection($data)->response()->getData();

        if(count($data) == 0) {
            return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
        } else {
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $results]);
        }
        
    }

    public function getExpenseDetails($id)
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $data = Expense_request::orderBy('id', 'DESC')->find($id);

        if(!$data) {
            return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
        } else {
            $results = new Expense_requestResource($data);

            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $results]);
        }
        
    }
    
    public function requestExpense(Request $request)
    {

        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $rule = [
            'value' => 'required',
            'type_id' => 'required|numeric',
            'emp_id' => 'required',
        ];
        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {

            return response(['status' => 401, 'msg' => $validate->messages()->first(), 'data' => NULL]);
        } else {

            $row = Expense_request::create([
                'emp_id' => $request->emp_id,
                'type_id' => $request->type_id,
                'value' => $request->value,
                'note' => $request->note,
                'status' => 0,
                'statusresponse' => 0, // "0 = waitting - 1 = approved - 2 = rejected - 3 = delayed 
            ]);

            if($request->hasFile('attach') && $request->file('attach')->isValid()){
                $row->addMediaFromRequest('attach')->toMediaCollection('attach');
            }
            
            $results = new Expense_requestResource($row);
                    
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $results]);

        }

    }

    public function getExpenseTypes()
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $data = Type_expense::orderBy('id', 'DESC')->get();

        if(count($data) == 0) {
            return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
        } else {
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $data]);
        }
        
    }

    public function getVacations($employee_id)
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $data = Vacationemp::where('emp_id', $employee_id)->orderBy('id', 'DESC')->paginate(10);

        $results = VacationempResource::collection($data)->response()->getData();

        if(count($data) == 0) {
            return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
        } else {
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $results]);
        }
        
    }

    public function getVacationDetails($id)
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $data = Vacationemp::orderBy('id', 'DESC')->find($id);

        if(!$data) {
            return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
        } else {
            $results = new VacationempResource($data);

            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $results]);
        }
        
    }
    
    public function requestVacation(Request $request)
    {

        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $rule = [
            'vfrom' => 'required',
            'vto' => 'required',
            'emp_id' => 'required',
            'type' => 'required',
            'note' => 'nullable',
        ];
        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {

            return response(['status' => 401, 'msg' => $validate->messages()->first(), 'data' => NULL]);
        } else {

            $row = Vacationemp::create([
                'emp_id' => $request->emp_id,
                'emp_vacation' => $request->emp_id,
                'vactionfrom' => $request->vfrom,
                'vactionto' => $request->vto,
                'vacationrequesttype' => $request->type, // 0 =  general leave - 1 = sick leave 
                'vacationrequest' => 0, // "0 = without salary - 1 = 50%salary - 2 = fullsalary
                'typevacation' => 0,
                'statusmangeraprove' => 0, // 0 = waitting - 1 = approved - 2 = rejected - 3 = delayed
                'noterequest' => $request->note,
                'status' => 0,
                
            ]);

            if($request->hasFile('attach') && $request->file('attach')->isValid()){
                $row->addMediaFromRequest('attach')->toMediaCollection('attach');
            }

            $results = new VacationempResource($row);
                    
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $results]);

        }

    }

    public function getArea()
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $data = Area::where('status' , 0)->orderBy('id', 'DESC')->get();

        if(count($data) == 0) {
            return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
        } else {
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $data]);
        }
        
    }

    public function getSpecialty()
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $data = Specialty::where('status' , 0)->orderBy('id', 'DESC')->get();

        if(count($data) == 0) {
            return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
        } else {
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $data]);
        }
        
    }

    public function getSocialStyle()
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $data = Social_styl::where('status' , 0)->orderBy('id', 'DESC')->get();

        if(count($data) == 0) {
            return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
        } else {
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $data]);
        }
        
    }
    public function getTypeContact()
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $data = Type_contact::where('status' , 0)->orderBy('id', 'DESC')->get();

        if(count($data) == 0) {
            return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
        } else {
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $data]);
        }
        
    }

    public function getCenterTypes()
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $data = Type_center::orderBy('id', 'DESC')->get();

        if(count($data) == 0) {
            return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
        } else {
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $data]);
        }
        
    }

    public function requestCenter(Request $request)
    {

        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $rule = [
            'emp_id' => 'required',
            'name' => 'required',
            'type_id' => 'required|numeric',
            'area_id' => 'required|numeric',
            'phone' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'address' => 'required'
        ];
        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {

            return response(['status' => 401, 'msg' => $validate->messages()->first(), 'data' => NULL]);
        } else {

            $row = Center::create([
                'emp_id' => $request->emp_id,
                'name_en' => $request->name,
                'type_id' => $request->type_id,
                'area_id' => $request->area_id ?? null,
                'phone' => $request->phone,
                'address' => $request->address,
                'lat' => $request->lat,
                'lng' => $request->lng,
                'status' => $request->status ?? 0,
            ]);

            // $results = new VacationempResource($row);
                    
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $row]);

        }

    }

    public function requestContact(Request $request)
    {

        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $rule = [
            'emp_id' => 'required',
            'name' => 'required',
            'phone' => 'required|unique:contacts',
            'gender' => 'required',
            'address' => 'required',
            'specialties' => 'required',
            'socialstyle' => 'required',
            'note' => 'nullable',
            'type' => 'required'
        ];
        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {

            return response(['status' => 401, 'msg' => $validate->messages()->first(), 'data' => NULL]);
        } else {

            $row = Contact::create([
                'emp_id' => $request->emp_id,
                'name_en' => $request->name,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'address' => $request->address,
                'speciality_id' => json_encode(array($request->specialties)),
                'social_id' => $request->socialstyle,
                'note' => $request->note ?? null,
                'typecont_id' => $request->type,
                'status' => $request->status ?? 0,
            ]);

            // $results = new VacationempResource($row);
                    
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $row]);

        }

    }

    public function getTypeVisit()
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $data = Type_visit::where('status' , 0)->orderBy('id', 'DESC')->get();

        if(count($data) == 0) {
            return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
        } else {
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $data]);
        }
        
    }

    public function getVisitPlan(Request $request)
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $rule = [
            'emp_id' => 'required',
            'date' => 'required'
        ];
        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {

            return response(['status' => 401, 'msg' => $validate->messages()->first(), 'data' => NULL]);
        } else {

            $data = Plan_visit::whereDate('from_time', $request->date)->where('emphplan_id', $request->emp_id)->orderBy('id', 'DESC')->get();

            $results = PlanvisitResource::collection($data)->response()->getData();

            if(count($data) == 0) {
                return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
            } else {
                return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $results]);
            }

        }

        
        
    }

    public function getCenter(Request $request)
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $data = Center::where('status' , 0)->orderBy('id', 'DESC');

        if ($request->search) {
            $data = $data->where('name_en', 'LIKE', "%{$request->search}%");
        }
        
        $data = $data->paginate(10);

        $results = CenterResource::collection($data)->response()->getData();

        if(count($data) == 0) {
            return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
        } else {
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $results]);
        }
        
    }

    public function getContact(Request $request)
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $data = Contact::where('status' , 0)->orderBy('id', 'DESC');

        if ($request->search) {
            $data = $data->where('name_en', 'LIKE', "%{$request->search}%");
        }
        
        $data = $data->paginate(10);

        $results = ContactResource::collection($data)->response()->getData();

        if(count($data) == 0) {
            return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
        } else {
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $results]);
        }
        
    }

    public function getProduct()
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $data = Product::where('status' , 0)->orderBy('id', 'DESC')->paginate(10);
        $results = ProductResource::collection($data)->response()->getData();

        if(count($data) == 0) {
            return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
        } else {
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $results]);
        }
        
    }

    public function getEmployee()
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $data = Employee::orderBy('id', 'DESC')->paginate(10);
        $results = EmployeeResource::collection($data)->response()->getData();

        if(count($data) == 0) {
            return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
        } else {
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $results]);
        }
        
    }

    public function addVisit(Request $request)
    {

        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $rule = [
            'emp_id' => 'required',
            'type_id' => 'required',
            'center_id' => 'required',
            'contact_id' => 'required',
            'status_visit' => 'required',
            'employee' => 'nullable',
            'status_return' => 'nullable',
            'description' => 'nullable',
            'note' => 'nullable',
            'checkin_time' => 'required',
            'checkout_time' => 'required',
            'checkin_location' => 'required',
            'checkout_location' => 'required',
            'firstprodstep_id' => 'required',
            'first_type' => 'required',
            'secondprodstep_id' => 'nullable',
            'second_type' => 'nullable',
            'thirdprodstep_id' => 'nullable',
            'third_type' => 'nullable'
        ];
        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {

            return response(['status' => 401, 'msg' => $validate->messages()->first(), 'data' => NULL]);
        } else {

            $row = Visit::create([
                'emp_id' => $request->emp_id,
                'empvisit_id' => $request->emp_id,
                'typevist_id' => $request->type_id,
                'center_id' => $request->center_id,
                'contact_id' => $request->contact_id,
                'status_visit' => $request->status_visit,
                'visit_emp_ass' => $request->status_visit != 0 ? json_encode($request->employee) : null,
                'status_return' => $request->status_return,
                'description' => $request->description ?? null,
                'note' => $request->note ?? null,
                'from_time' => $request->checkin_time,
                'end_time' => $request->checkout_time,
                'checkin_location' => $request->checkin_location,
                'checkout_location' => $request->checkout_location,
                'status' => $request->status ?? 0,
                'firstprodstep_id' => $request->firstprodstep_id,
                'first_type' => $request->first_type,//0 = details - 1 = reminder
                'secondprodstep_id' => $request->secondprodstep_id,
                'second_type' => $request->second_type,//0 = details - 1 = reminder
                'thirdprodstep_id' => $request->thirdprodstep_id,
                'third_type' => $request->third_type,//0 = details - 1 = reminder
            ]);

            $listcont = List_contac::where('status' , 0)
            ->where('emplist_id', $row->empvisit_id)
            ->where('contact_id',$row->contact_id)
            ->first(); // Assuming you want the first result
            
            if($listcont != null){
            // 0 = listed contact - 1 = listed center - 2 = both - 3 = out list

            // Check if $row->contact_id is in the $conlist array
            if ($row->contact_id === $listcont->contact_id)  {
                $visit = Visit::where('id', $row->id)->update([
                    'status_visit_list' => 0 ,
                ]);
                
                } else{
                    $visit = Visit::where('id', $row->id)->update([
                        'status_visit_list' => 3 ,
                    ]);
                }
            } else{
                $visit = Visit::where('id', $row->id)->update([
                    'status_visit_list' => 3 ,
                ]);
            }

            // $results = new VacationempResource($row);
                    
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $row]);

        }

    }


    public function getVisit(Request $request)
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $rule = [
            'emp_id' => 'required',
            'date' => 'required'
        ];
        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {

            return response(['status' => 401, 'msg' => $validate->messages()->first(), 'data' => NULL]);
        } else {

            $data = Visit::whereDate('from_time', $request->date)->where('empvisit_id', $request->emp_id)->orderBy('id', 'DESC')->get();

            $results = VisitResource::collection($data)->response()->getData();

            if(count($data) == 0) {
                return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
            } else {
                return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $results]);
            }

        }

        
        
    }

    public function getCustomerSale()
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $data = Cut_sale::where('status' , 0)->orderBy('id', 'DESC')->get();

        $results = CustomerResource::collection($data)->response()->getData();

        if(count($data) == 0) {
            return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
        } else {
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $results]);
        }
        
    }

    public function getTypeSale()
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $data = Sale_type::where('status' , 0)->orderBy('id', 'DESC')->get();

        if(count($data) == 0) {
            return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
        } else {
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $data]);
        }
        
    }

    public function requestInvoice(Request $request)
    {

        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $rule = [
            'sale_type_id' => 'required|numeric'
        ];
        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {

            return response(['status' => 401, 'msg' => $validate->messages()->first(), 'data' => NULL]);
        } else {

            $row = Bill_sale_header::create([
                'emp_id' => $request->emp_id,
                'cut_sale_id' => $request->cut_sale_id,
                'sale_type_id' => $request->sale_type_id,
                'valued_time' => $request->valued_time,
                'note' => $request->note,
                'status_order' => $request->status_order,
            ]);
            
            $totalsellprice = 0 ;
            foreach ( $request->product_id as $index => $product_id) {
                $product = Product::find($product_id);

                $per  = $request->percent[$index] / 100 ;
                $sellpriceph = $product->sell_price * (1 - $per);

                $azrow = Bill_sale_detail::create([
                    'emp_id' => $request->emp_id,
                    'product_id' => $product_id,
                    'bill_sale_header_id' => $row->id,
                    'quantityproduc' => $request->qty[$index],
                    'sellpriceproduct' => $product->sell_price,
                    'sellpriceph' => $sellpriceph,
                    'percent' => $request->percent[$index],
                    'status_requ' => 0,
                ]);
                $totalsellprice += $request->qty[$index] * $sellpriceph;
            }

            $row->update([
                'totalsellprice' => $totalsellprice,
            ]);

            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $row]);

        }

    }

    public function requestCutomerCollection(Request $request)
    {

        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $rule = [
            'emp_id' => 'required',
            'cust_id' => 'required',
            'value' => 'required',
        ];
        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {

            return response(['status' => 401, 'msg' => $validate->messages()->first(), 'data' => NULL]);
        } else {

            $row = Cust_collection::create([
                'emp_id' => $request->emp_id,
                'cust_id' => $request->cust_id,
                'value' => $request->value,
                'note' => $request->note,
                'status' => 0 ,
            ]);

            
            $trans_cust = Trans_cust::create([
                'emp_id' => $request->emp_id,
                'cust_id' => $row->cust_id,
                'model_name' => 'Cust_collection',
                'id_model' => $row->id,
                'total_value' => $row->value,
                'status_trans' => 1, // 0 = increased creadite - 1 = decreased creadite 
                'note' => $request->note,
                'status' => 0 ,
            ]);
            $custsal = Cut_sale::find($row->cust_id);
            $custsal->update([
                'value' => $custsal->value - $row->value,
            ]);
                    
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $row]);

        }

    }

    public function getTransaction($employee_id)
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $data = Trans_cust::where('emp_id' , $employee_id)->orderBy('id', 'DESC')->paginate(10);

        $results = TransactionResource::collection($data)->response()->getData();

        if(count($data) == 0) {
            return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
        } else {
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $results]);
        }
        
    }

    public function requestRefund(Request $request)
    {

        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $rule = [
            'emp_id' => 'required',
            'cut_sale_id' => 'required',
            'refund_causes_id' => 'required'
        ];
        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {

            return response(['status' => 401, 'msg' => $validate->messages()->first(), 'data' => NULL]);
        } else {

            $parentId = null;
            $totalValue = 0;
            $isSingleItem = count($request->product_id) === 1;

            foreach ( $request->product_id as $index => $product_id) {

                $currentParentId = ($index === 0) ? null : $parentId;
                $product = Product::find($product_id);

                $refundSale = Refund_sale::create([
                    'emp_id' => $request->emp_id,
                    'cust_id' => $request->cut_sale_id,
                    'refund_causes_id' => $request->refund_causes_id,
                    'note' => $request->note,
                    'prod_id' => $product_id,
                    'approv_quantity_ref' => $request->qty[$index],
                    'approv_sellpriceproduct_ref' => $product->sellpriceph - ($product->sellpriceph * ($request->price[$index] / 100 )),
                    'bill_sale_header_id' => null,
                    'value' => $request->price[$index],
                    'parent_id' => $currentParentId,
                    'status_requ_ref' => 1,
                    'status_requ' => 0,
                ]);
                $totalValue = $totalValue + $refundSale->value;

                // Set parent ID for first item
                if ($index === 0) {
                    $parentId = $refundSale->id;
                    $refundSale->update(['parent_id' => $parentId]);
                    // For single item, set parent to itself
                    if ($isSingleItem) {
                        $refundSale->update(['parent_id' => $parentId]);
                    }
                }
            }

            // Get customer record
            $customer = Cut_sale::findOrFail($request->cut_sale_id);

            $trans_cust = Trans_cust::create([
                'emp_id' => $request->emp_id,
                'cust_id' => $customer->id,
                'model_name' => 'Refund_sale',
                'id_model' => $refundSale->id,
                'total_value' => $totalValue,
                'status_trans' => 1, // 0 = increased creadite - 1 = decreased creadite 
                'note' => $request->note,
                'value_befor' => $customer->value,
                'status' => 0 ,
            ]);

            // Update customer balance
            $customer->update([
                'value' => $customer->value - $totalValue,
            ]);
                    
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $refundSale]);

        }

    }

    public function getReasons()
    {
        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        $data = Refund_cause::where('status' , 0)->orderBy('id', 'DESC')->get();

        if(count($data) == 0) {
            return response(['status' => 401, 'msg' => trans('lang.nodata'), 'data' => null]);
        } else {
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $data]);
        }
        
    }
}
