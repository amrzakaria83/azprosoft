<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Emp_monthly_salary;
use App\Models\Employee;
use App\Models\Emp_salary;
use App\Models\Emp_plan_att;
use App\Models\Emp_att_permission;
use App\Models\Emp_att_overtime;
use App\Models\Emp_action;
use App\Models\Vacation_emp;
use App\Models\Attendance;
use DataTables;
use Validator;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Emp_monthly_salarysController extends Controller
{
    protected $viewPath = 'admin.emp_monthly_salary';
    private $route = 'admin.emp_monthly_salarys';

    public function __construct(Emp_monthly_salary $model)
    {
        $this->objectModel = $model;
    }

    public function index(Request $request)
    {
        $data = $this->objectModel::get();

        if ($request->ajax()) {
            $data = Emp_monthly_salary::query();
            $data = $data->orderBy('id', 'DESC');

            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name_ar', function($row){
                        $name_ar = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->getempsalary->name_ar ?? $row->getempsalary->name_en.'</a><div>';
                    return $name_ar;
                })
                ->addColumn('value', function($row){
                    $value = $row->value ;
                    return $value;
                })
                ->addColumn('value_befor', function($row){
                    $value_befor = $row->value_befor ;
                    return $value_befor;
                })
                ->addColumn('note', function($row){
                    $note = $row->note ;
                    return $note;
                })
                ->addColumn('created_at', function($row){
                    $created_at = $row->created_at ;
                    return $created_at;
                })

                ->addColumn('type', function($row){
                    if($row->type == 0 ) {
                        $type = '<div class="badge badge-light-success fw-bold">'.trans('lang.perhour').'</div>';
                    } else {
                        $type = '<div class="badge badge-light-danger fw-bold">'.trans('lang.total').'</div>';
                    }
                    
                    return $type;
                })
                ->addColumn('status', function($row){
                    if($row->status == 0 ) {
                        $status = '<div class="badge badge-light-success fw-bold">مفعل</div>';
                    } else {
                        $status = '<div class="badge badge-light-danger fw-bold">غير مفعل</div>';
                    }
                    
                    return $status;
                })
                ->addColumn('actions', function($row){
                    $actions = '<div class="ms-2">
                                <a href="'.route($this->route .'.show', $row->id).'" class="btn btn-sm btn-icon btn-warning btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-eye-fill fs-1x"></i>
                                </a>
                                <a href="'.route($this->route .'.edit', $row->id).'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-pencil-square fs-1x"></i>
                                </a>
                            </div>';
                    return $actions;
                })
                ->filter(function ($instance) use ($request) {
                    // if ($request->get('status') == '0' || $request->get('status') == '1') {
                    //     $instance->where('status', $request->get('status'));
                    // }
                    if ($request->get('status') != Null)
                    {
                    $instance->where(function ($query) use ($request) {
                        $query->where('status', $request->get('status'));
                    });
                    }
                    if ($request->get('type') != Null)
                    {
                    $instance->where(function ($query) use ($request) {
                        $query->where('type', $request->get('type'));
                    });
                    }
                    if (!empty($request->get('search'))) {
                            $search = $request->get('search'); // Define search string once
                            $instance->where(function($w) use($search){ // Pass $search to closure
                            // Search the 'product_name' field on the Emp_monthly_salary model itself
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
                ->rawColumns(['name_ar','value','type','value_befor','note','created_at','status','checkbox','actions'])
                ->make(true);
        }
        return view($this->viewPath .'.index');
    }

    public function show($id)
    {
        $data = Emp_monthly_salary::find($id);
        return view($this->viewPath .'.show', compact('data'));
    }

    public function create()
    {
        return view($this->viewPath .'.create');
    }
    public function store(Request $request)
    {

        $rule = [

        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
        $excistsal = $this->objectModel::where('emp_salary', $request->emp_salary)->first();
        if ($excistsal) {
            $oldValue = $excistsal->value;
            $excistsal = $excistsal->update([
                'status' => 1,
            ]);
            $row = $this->objectModel::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'emp_salary' => $request->emp_salary, 
            'value' => $request->value, 
            'value_befor' => $oldValue, 
            'note' => $request->note, 
            'type' => $request->type, //0 = perhour - 1 = total 
            'status' => $request->status ?? 0,
        ]);
        } else {
        $row = $this->objectModel::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'emp_salary' => $request->emp_salary, 
            'value' => $request->value, 
            'value_befor' => $request->value, 
            'note' => $request->note, 
            'type' => $request->type, //0 = perhour - 1 = total 
            'status' => $request->status ?? 0,
        ]);
        }
        
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
        $row = $this->objectModel::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'emp_att_overtime' => Auth::guard('admin')->user()->id,
            'attendance_in_over_from' => $request->attendance_in_over_from,
            'attendance_out_over_to' => $request->attendance_out_over_to,
            'type_emp_att_request' => $request->type_emp_att_request,//0 = normal rate - 1 = over rate 
            'noterequest' => $request->noterequest,// 0 = without salary - 1 = 50%salary - 2 = fullsalary
            'statusmangeraprove' => 0 ,// 0 = waitting - 1 = approved - 2 = rejected - 3 = delayed (manger)
            'status' => $request->status ?? 0,
        ]);
        return redirect()->back()->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    public function edit($id)
    {
        $data = Emp_monthly_salary::find($id);
        return view('admin.emp_att_overtime.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $rule = [
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        } 
        $data = Emp_monthly_salary::find($request->id);
        $data->update([
            'emp_id' => Auth::guard('admin')->user()->id,
            'emp_att_overtime' => Auth::guard('admin')->user()->id,
            'attendance_in_over_from' => $request->attendance_in_over_from,
            'attendance_out_over_to' => $request->attendance_out_over_to,
            'type_emp_att_request' => $request->type_emp_att_request,//0 = normal rate - 1 = over rate 
            'noterequest' => $request->noterequest,// 0 = without salary - 1 = 50%salary - 2 = fullsalary
            'statusmangeraprove' => 0 ,// 0 = waitting - 1 = approved - 2 = rejected - 3 = delayed (manger)
            'status' => $request->status ?? 0,
        ]);

        return redirect('admin/')->with('message', 'تم التعديل بنجاح')->with('status', 'success');
    }

    public function destroy(Request $request)
    {   

        try{
            Emp_monthly_salary::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'error']);
        }
        return response()->json(['message' => 'success']);

    }
    public function create_bymanger()
    {
        return view($this->viewPath .'.create_bymanger');
    }
    public function storemanger(Request $request)
    {

        $rule = [
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) { 
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
        
            // Convert datetime format from 'Y-m-d h:i A' to 'Y-m-d H:i:s'
                $attendanceOutFrom = Carbon::createFromFormat('Y-m-d h:i A', $request->attendance_in_over_from)
                ->format('Y-m-d H:i:s');

                $attendanceInTo = Carbon::createFromFormat('Y-m-d h:i A', $request->attendance_out_over_to)
                    ->format('Y-m-d H:i:s');
        $row = $this->objectModel::create([
            'emp_id' => Auth::guard('admin')->user()->id,
            'man_att_overtime' => Auth::guard('admin')->user()->id,
            'emp_att_overtime' => $request->emp_att_overtime,
            'attendance_in_over_from' => $attendanceOutFrom,
            'attendance_out_over_to' => $attendanceInTo,
            'attendance_in_over_from_manger' => $attendanceOutFrom,
            'attendance_out_over_to_manger' => $attendanceInTo,
            'type_emp_att_request' => $request->type_emp_att_request,//0 = normal rate - 1 = over rate 
            'type_emp_att_mang' => $request->type_emp_att_request,//0 = normal rate - 1 = over rate 
            'noterequest' => $request->noterequest,// 0 = without salary - 1 = 50%salary - 2 = fullsalary
            'statusmangeraprove' => 1 ,// 0 = waitting - 1 = approved - 2 = rejected - 3 = delayed (manger)
            'status' => $request->status ?? 0,
        ]);
        return redirect('admin/')->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }
    public function create_m_sa()
    {
        return view($this->viewPath .'.create_m_sa');
    }

    public function index_m_sa(Request $request, $from_time, $to_time, $work_days)
    {
        $from = Carbon::parse($from_time)->startOfDay();
        $to = Carbon::parse($to_time)->endOfDay();
        
        $employees = Employee::where('is_active', 1)->get();
        $emps = [];
        
        
        foreach ($employees as $emp) {
            $plan = [];
            $attendances = [];
            $attendanceids = [];
            $vacations = [];
            $overtimes = [];
            $permissions = [];
            // Get employee data
            $plan = Emp_plan_att::where('emp_plan_att', $emp->id)
                ->where('status', 0)
                ->first();
                  // Debug if needed
            if (!$plan) {
                \Log::warning("No work plan found for employee: " . $emp->id);
            }
                
            $salary = Emp_salary::where('emp_salary', $emp->id)
                ->where('status', 0)
                ->first();
                
            // Get attendances - corrected timestamp comparison
            $attendances = Attendance::where('emp_code_att', $emp->id)
                ->whereBetween('attendance_in_at', [$from, $to])
                ->get()
                ->groupBy(function($att) {
                    return Carbon::parse($att->attendance_in_at)->format('Y-m-d');
                });
            $attendanceids = Attendance::where('emp_code_att', $emp->id)
                ->whereBetween('attendance_in_at', [$from, $to])
                ->get();
                // ->groupBy(function($att) {
                //     return Carbon::parse($att->attendance_in_at)->format('Y-m-d');
                // });
                // dd($attendances);
            // Get vacations and permissions (unchanged)
            $vacations = Vacation_emp::where('emp_vacation', $emp->id)
                
                ->where('statusmangeraprove', 1)
                ->where(function($q) use ($from, $to) {
                    $q->whereBetween('vactionfrommanger', [$from, $to])
                    ->orWhereBetween('vactiontomanger', [$from, $to])
                    ->orWhere(function($q2) use ($from, $to) {
                        $q2->where('vactionfrommanger', '<=', $from)
                            ->where('vactiontomanger', '>=', $to);
                    });
                })
                ->get();
                
            $permissions = Emp_att_permission::where('emp_att_permission', $emp->id)
                ->where('status', 0)
                ->where('statusmangeraprove', 1)
                ->whereBetween('attendance_out_from_manger', [$from, $to])
                ->get();
            $overtimes = Emp_att_overtime::where('emp_att_overtime', $emp->id)
                ->where('status', 0)
                ->where('statusmangeraprove', 1)
                ->whereBetween('attendance_out_over_to_manger', [$from, $to])
                ->get();    
            $actions = Emp_action::where('emp_id', $emp->id)
                ->where('status', 0)
                ->whereBetween('created_at', [$from, $to])
                ->get();
                
            // Initialize counters
            $counters = [
                'actualWorkedHours' => 0,
                'daysWithAttendance' => 0,
                'daysWithoutAttendance' => 0,
                'daysWithvacation' => 0,
                'vacationPay' => 0,
                'overtimePay' => 0,
                'valueFromWorkedaz' => 0,
                'daysOutsidePlan' => 0,
                'hoursOutsidePlan' => 0,
                'totalLateMinutes' => 0,
                'counttimeLateMinutes' => 0,
                'totalEarlyMinutes' => 0,
                'counttimeEarlyMinutes' => 0,
                'totalpenal' => 0,
                'totalreward' => 0,
            ];
            
            // Calculate penalties and rewards first
            foreach ($actions as $action) {
                $counters[$action->type == 0 ? 'totalpenal' : 'totalreward'] += $action->value;
            }
            
            // Calculate daily attendance
            $period = CarbonPeriod::create($from, $to);
            
            foreach ($period as $date) {
                $dateKey = $date->format('Y-m-d');
                $dayAttendance = $attendances->get($dateKey) ? $attendances->get($dateKey)->first() : null;
                
                $dayOfWeek = $date->dayOfWeek;
                $isWorkDay = $this->isWorkDay($date, $plan, $vacations);
                $isVacationDay = $this->isVacationDay($date, $vacations); // Add this new method
    
                if ($isVacationDay) {
                    $counters['daysWithvacation']++;
                    continue; // Skip further checks for this day if it's a vacation
                }
                
                if ($dayAttendance) {
                    $counters['daysWithAttendance']++;
                    
                    if ($isWorkDay) {
                        $this->calculateWorkHours($dayAttendance, $plan, $counters);
                    } else {
                        $counters['daysOutsidePlan']++;
                    }
                } else {
                    if ($isWorkDay) {
                        $counters['daysWithoutAttendance']++;
                    }
                }
            }
            // dd($attendanceids);
            // Calculate salary
            // $salaryData = $this->calculateSalary($salary, $counters, $work_days);
            // Calculate salary
            // $salaryData = $this->calculateSalary($salary, $counters, $work_days, $vacations);
            // $salaryData = $this->calculateSalary($salary, $counters, $work_days, $vacations, $overtimes);
            $salaryData = $this->calculateSalary(
                $salary,
                $counters, 
                $work_days,
                $attendanceids,
                $vacations ,
                $overtimes,
                $from,
                $to,
                $attendances, 
                $plan

            );
            $emps[] = array_merge([
                'name_ar' => $emp->name_ar,
                'emp_id' => $emp->id,
            ], $counters, $salaryData);
        }
        // dd($emps);
        return view($this->viewPath .'.create_m_sa', compact('emps'));
        // return response()->json($emps);
    }
    // Helper methods
    protected function isWorkDay($date, $plan, $vacations)
    {
        // Check weekly day off
        if ($plan && $plan->weekly_dayoff) {
            $weeklyDayOff = json_decode($plan->weekly_dayoff);
            if (in_array($date->dayOfWeek, $weeklyDayOff)) {
                return false;
            }
        }
        
        // Check vacations
        foreach ($vacations as $vacation) {
            $vacFrom = Carbon::parse($vacation->vactionfrommanger)->startOfDay();
            $vacTo = Carbon::parse($vacation->vactiontomanger)->endOfDay();
            
            if ($date->between($vacFrom, $vacTo)) {
                return false;
            }
        }
        
        return true;
    }
    protected function calculateWorkHours($attendance, $plan, &$counters)
    {
        if (!$plan || !$attendance->attendance_in_at || !$attendance->attendance_out_at) {
            return;
        }
        // dd($plan);
        // Use Laravel's configured timezone
        $timezone = config('app.timezone');
        
        // Get the date from the attendance record
        $attendanceDate = Carbon::parse($attendance->attendance_in_at)
                            ->timezone($timezone)
                            ->format('Y-m-d');
        
        // Combine plan times with attendance date
        $planIn = Carbon::parse($attendanceDate . ' ' . $plan->attendance_in_at, $timezone);
        $planOut = Carbon::parse($attendanceDate . ' ' . $plan->attendance_out_at, $timezone);
        
        $actualIn = Carbon::parse($attendance->attendance_in_at, $timezone);
        $actualOut = Carbon::parse($attendance->attendance_out_at, $timezone);

        // Calculate late minutes (how late employee arrived)
        $lateMinutes = $actualIn->diffInMinutes($planIn, false); // false = negative if actual is before plan
        
        // Only count if actually late (positive difference)
        if ($lateMinutes < 0) {
            $countableLateMinutes = min($lateMinutes, 180); // Cap at 3 hours (180 minutes)
            $counters['totalLateMinutes'] += $countableLateMinutes;
            $counters['counttimeLateMinutes'] += 1;
        }
        
        // Calculate early minutes (how early employee left)
        $earlyMinutes = $planOut->diffInMinutes($actualOut, false); // false = negative if actual is after plan
        // dd($earlyMinutes);
        // Only count if actually early (positive difference)
        if ($earlyMinutes < 0) {
            $countableEarlyMinutes = min($earlyMinutes, 180); // Cap at 3 hours (180 minutes)
            $counters['totalEarlyMinutes'] += $countableEarlyMinutes;
            $counters['counttimeEarlyMinutes'] += 1;
        }
        
        // Calculate hours outside plan (overtime/undertime)
        $outsidePlanHours = 0;
        
        // Early arrival (before planned time)
        if ($actualIn < $planIn) {
            $outsidePlanHours += $planIn->diffInMinutes($actualIn) / 60;
        }
        
        // Late departure (after planned time)
        if ($actualOut > $planOut) {
            $outsidePlanHours += $actualOut->diffInMinutes($planOut) / 60;
        }
        
        $counters['hoursOutsidePlan'] += $outsidePlanHours;

        // Calculate actual worked hours (within plan)
        $workedMinutes = $actualOut->diffInMinutes($actualIn);
        $totalworkedMinutes = $workedMinutes - ($outsidePlanHours * 60);
        $workedHours = $totalworkedMinutes / 60;
        // $workedHours = $workedMinutes / 60;
        $counters['actualWorkedHours'] += $workedHours;

    }
    protected function isVacationDay($date, $vacations)
    {
        foreach ($vacations as $vacation) {
            $vacFrom = Carbon::parse($vacation->vactionfrommanger)->startOfDay();
            $vacTo = Carbon::parse($vacation->vactiontomanger)->endOfDay();
            
            if ($date->between($vacFrom, $vacTo)) {
                return true;
            }
        }
        
        return false;
    }
    protected function calculateSalary(
        $salary,
        $counters, 
        $work_days,
        $attendanceids,
        $vacations ,
        $overtimes,
        $from,
        $to,
        $attendances, 
        $plan
        )
    {
        // Handle missing salary case
        if (!$salary) {
            return $this->emptySalaryResult();
        }
        // dd($attendanceids);
        $dailyRate = $salary->value / $work_days; // value per hour
        $hourlyRate = $this->calculateHourlyRate($dailyRate, $plan);
        
        // Handle invalid work plan case
        if ($hourlyRate <= 0) {
            return $this->invalidPlanResult($salary, $dailyRate);
        }
        
        // Calculate all components
        $vacationPay = $this->calculateVacationPay($vacations, $dailyRate);
        $overtimeData = $this->calculateOvertime(
        $attendanceids,
        $attendances,
        $overtimes,
        $dailyRate,
        $from,  // Add these parameters
        $to     // from your index_m_sa method
        );
        
        // Calculate base salary based on type
        if ($salary->type == 0) { // hourly
            $baseSalary = $this->calculateHourlySalary($counters, $dailyRate);
        } else { // monthly
            $baseSalary = $this->calculateMonthlySalary($counters, $dailyRate);
        }

        // Calculate totals
        $totalSalary = $baseSalary['value'] + $vacationPay + $overtimeData['total'] 
                    + $counters['totalreward'] - $counters['totalpenal'];

        return [
            'totalmail' => round($totalSalary, 2),
            'typemail' => trans($salary->type == 0 ? 'lang.perhour' : 'lang.total'),
            'dailyRate' => round($dailyRate, 2),
            'valueFromWorkedaz' => round($baseSalary['value'], 2),
            'vacationPay' => round($vacationPay, 2),
            'overtimePay' => round($overtimeData['total'], 2),
            'standardOvertime' => round($overtimeData['standard'], 2),
            'approvedOvertime' => round($overtimeData['approved'], 2),
        ];
    }

    // Helper methods
    protected function emptySalaryResult()
    {
        return [
            'totalmail' => 0,
            'typemail' => null,
            'valueFromWorkedaz' => 0,
            'dailyRate' => 0,
            'vacationPay' => 0,
            'overtimePay' => 0,
            'standardOvertime' => 0,
            'approvedOvertime' => 0,
        ];
    }

    protected function invalidPlanResult($salary, $dailyRate)
    {
        return [
            'totalmail' => 0,
            'typemail' => trans($salary->type == 0 ? 'lang.perhour' : 'lang.total'),
            'valueFromWorkedaz' => 0,
            'dailyRate' => round($dailyRate, 2),
            'vacationPay' => 0,
            'overtimePay' => 0,
            'standardOvertime' => 0,
            'approvedOvertime' => 0,
            'error' => 'Could not calculate hourly rate - invalid work plan',
        ];
    }

    protected function calculateHourlySalary($counters, $dailyRate)
    {
        return [
            'value' => $counters['actualWorkedHours'] * $dailyRate,
            'type' => 'hourly'
        ];
    }

    protected function calculateMonthlySalary($counters, $dailyRate)
    {
        return [
            'value' => $dailyRate * $counters['daysWithAttendance'],
            'type' => 'monthly'
        ];
    }
    protected function calculateHourlyRate($dailyRate, $plan)
    {
        // Return null or 0 if no valid plan exists
        if (!$plan || !$plan->attendance_in_at || !$plan->attendance_out_at) {
            return 0; // or return null depending on how you want to handle it
        }

        // Parse planned working hours
        $start = Carbon::parse($plan->attendance_in_at);
        $end = Carbon::parse($plan->attendance_out_at);
        $dailyHours = $start->diffInHours($end);

        // Return 0 if daily hours is 0 or negative to avoid division issues
        // return $dailyHours > 0 ? $dailyRate / $dailyHours : 0;
        return $dailyHours > 0 ? $dailyHours : 0;
    }

    protected function calculateVacationPay($vacations, $dailyRate)
    {
        $vacationPay = 0;
        foreach ($vacations as $vacation) {
            $vacFrom = Carbon::parse($vacation->vactionfrommanger)->startOfDay();
            $vacTo = Carbon::parse($vacation->vactiontomanger)->endOfDay();
            $days = $vacFrom->diffInDays($vacTo) + 1;
            
            switch ($vacation->typevacation) {
                case 1: $vacationPay += $days * $dailyRate * 0.5; break;
                case 2: $vacationPay += $days * $dailyRate; break;
            }
        }
        return $vacationPay;
    }
    protected function calculateOvertime(
        $attendanceids,
        $attendances,
        $overtimes,
        $dailyRate,
        $from,
        $to
    ) {
        $standardOvertime = 0;
        $approvedOvertime = 0;
        
        // Create a map of attendance dates with their in/out times
        $attendanceMap = $attendanceids->mapWithKeys(function ($attendance) {
            return [
                Carbon::parse($attendance->attendance_in_at)->format('Y-m-d') => [
                    'in' => Carbon::parse($attendance->attendance_in_at),
                    'out' => $attendance->attendance_out_at 
                        ? Carbon::parse($attendance->attendance_out_at) 
                        : null
                ]
            ];
        });
        
        foreach ($overtimes as $overtime) {
            // Check if overtime is approved and active
            if ($overtime->statusmangeraprove != 1 || $overtime->status != 0) {
                continue;
            }
            
            try {
                // Safely parse overtime dates
                $overtimeStart = $overtime->attendance_in_over_from_manger 
                    ? Carbon::parse($overtime->attendance_in_over_from_manger) 
                    : null;
                    
                $overtimeEnd = $overtime->attendance_out_over_to_manger 
                    ? Carbon::parse($overtime->attendance_out_over_to_manger) 
                    : null;
                    
                if (!$overtimeStart || !$overtimeEnd) {
                    continue;
                }
                
                // Get the date of the overtime
                $overtimeDate = $overtimeStart->format('Y-m-d');
                
                // Check if there's matching attendance for the overtime date
                if (!isset($attendanceMap[$overtimeDate])) {
                    continue;
                }
                
                $attendance = $attendanceMap[$overtimeDate];
                
                // Skip if no clock-out time recorded
                if (!$attendance['out']) {
                    continue;
                }
                
                // Determine the effective start and end times for overtime calculation
                // Max of approved overtime start and actual attendance start
                $effectiveOvertimeStart = $overtimeStart->copy()->max($attendance['in']);
                // Min of approved overtime end and actual attendance end
                $effectiveOvertimeEnd = $overtimeEnd->copy()->min($attendance['out']);

                $hours = 0;
                // Ensure there is an actual positive overlap
                if ($effectiveOvertimeEnd->gt($effectiveOvertimeStart)) {
                    $actualOvertimeMinutes = $effectiveOvertimeEnd->diffInMinutes($effectiveOvertimeStart);
                    if ($actualOvertimeMinutes > 0) {
                        // Calculate hours, rounding up, and ensure it's at least 1 if any overtime is worked.
                        // Ensure float division for ceil by dividing by 60.0
                        $hours = max(1, (int)ceil($actualOvertimeMinutes / 60.0));
                    }
                }
                
                // If no valid overtime hours were calculated, skip this overtime record
                if ($hours == 0) {
                    continue;
                }
                
                // Calculate pay based on type
                $rateMultiplier = $overtime->type_emp_att_mang == 0 ? 1.0 : 1.5;
                $approvedOvertime += $hours * ($dailyRate) * $rateMultiplier;
                
            } catch (\Exception $e) {
                // Log error if needed
                continue;
            }
        }
        
        // Calculate standard overtime from attendance records
        foreach ($attendances as $date => $attendanceRecords) {
            foreach ($attendanceRecords as $attendance) {
                if ($attendance->overtime_hours > 0) {
                    $standardOvertime += $attendance->overtime_hours * ($dailyRate) * 1.5;
                }
            }
        }
        
        return [
            'total' => $standardOvertime + $approvedOvertime,
            'standard' => $standardOvertime,
            'approved' => $approvedOvertime
        ];
    }
    // protected function calculateOvertime($attendances, $overtimes, $dailyRate, $from, $to)
    // {
    //     $standardOvertime = 0;
    //     $approvedOvertime = 0;
        
    //     // Convert attendance dates to Y-m-d format for comparison
    //     $attendanceDates = array_keys($attendances->toArray());
        
    //     foreach ($overtimes as $overtime) {
    //         // Check if overtime is approved and active
    //         if ($overtime->statusmangeraprove != 1 || $overtime->status != 0) {
    //             continue;
    //         }
            
    //         $overtimeStart = Carbon::parse($overtime->attendance_in_over_from_manger);
    //         $overtimeEnd = Carbon::parse($overtime->attendance_out_over_to_manger);
            
    //         // 1. Validate overtime period falls within the report range
    //         if ($overtimeStart->lt($from) || $overtimeEnd->gt($to)) {
    //             continue;
    //         }
            
    //         // 2. Check if there's matching attendance for the overtime date
    //         $overtimeDate = $overtimeStart->format('Y-m-d');
    //         if (!in_array($overtimeDate, $attendanceDates)) {
    //             continue;
    //         }
            
    //         // 3. Calculate hours (with minimum 1 hour)
    //         $hours = max(1, $overtimeEnd->diffInHours($overtimeStart));
            
    //         // 4. Calculate pay based on type
    //         $rateMultiplier = $overtime->type_emp_att_mang == 0 ? 1.0 : 1.5;
    //         $approvedOvertime += $hours * ($dailyRate) * $rateMultiplier; // Using hourly rate
    //     }
        
    //     // Calculate standard overtime from attendance records
    //     foreach ($attendances as $date => $attendanceRecords) {
    //         foreach ($attendanceRecords as $attendance) {
    //             if ($attendance->overtime_hours > 0) {
    //                 $standardOvertime += $attendance->overtime_hours * ($dailyRate) * 1.5;
    //             }
    //         }
    //     }
        
    //     return [
    //         'total' => $standardOvertime + $approvedOvertime,
    //         'standard' => $standardOvertime,
    //         'approved' => $approvedOvertime
    //     ];
    // }
    // protected function calculateOvertime($attendances, $overtimes, $dailyRate)
    // {
    //     $standardOvertime = 0;
    //     $approvedOvertime = 0;
        
    //     // 2. Approved overtime requests
    //     foreach ($overtimes as $overtime) {
    //         if ($overtime->statusmangeraprove == 1 && $overtime->status == 0) {
    //             $hours = Carbon::parse($overtime->attendance_out_over_to_manger)
    //                 ->diffInHours(Carbon::parse($overtime->attendance_in_over_from_manger));
                    
    //             $rateMultiplier = $overtime->type_emp_att_mang == 0 ? 1.0 : 1.5;
    //             $approvedOvertime += $hours * $dailyRate * $rateMultiplier;
    //         }
    //     }
        
    //     return [
    //         'total' => $standardOvertime + $approvedOvertime,
    //         'standard' => $standardOvertime,
    //         'approved' => $approvedOvertime
    //     ];
    // }
    

}

