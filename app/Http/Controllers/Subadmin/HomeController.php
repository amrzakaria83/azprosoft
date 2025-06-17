<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Cashier;
use App;
use Illuminate\Support\Facades\Auth;
use App\Models\Site;

class HomeController extends Controller
{
    public function index() {

        $now = Carbon::now();
        $query['results'] = "[[0, 10, 20, 30, 40, 50, 30, 20, 80, 80, 70, 50, 30]]";
        $lastDay = date('m',strtotime('last month'));

        $month[] = $now ->month ;
        $year[] = $now ->year ;

        $count_user[] = User::whereMonth('created_at', $now ->month)->whereYear('created_at', $now ->year)->get()->count();

        for ($i=1; $i < 12; $i++) {
            $last_month = $now ->month - $i ;
            if ($last_month < 1) {
                if ($last_month == 0) {
                    $month[] = 12 ;
                    $year[] = $now ->year - 1 ;
                    $count_user[] = User::whereMonth('created_at', 12)->whereYear('created_at', ($now ->year - 1))->get()->count();
                } else if ($last_month == -1) {
                    $month[] = 11 ;
                    $year[] = $now ->year - 1 ;
                    $count_user[] = User::whereMonth('created_at', 11)->whereYear('created_at', ($now ->year - 1))->get()->count();
                } else if ($last_month == -2) {
                    $month[] = 10 ;
                    $year[] = $now ->year - 1 ;
                    $count_user[] = User::whereMonth('created_at', 10)->whereYear('created_at', ($now ->year - 1))->get()->count();
                } else if ($last_month == -3) {
                    $month[] = 9 ;
                    $year[] = $now ->year - 1 ;
                    $count_user[] = User::whereMonth('created_at', 9)->whereYear('created_at', ($now ->year - 1))->get()->count();
                } else if ($last_month == -4) {
                    $month[] = 8 ;
                    $year[] = $now ->year - 1 ;
                    $count_user[] = User::whereMonth('created_at', 8)->whereYear('created_at', ($now ->year - 1))->get()->count();
                } else if ($last_month == -5) {
                    $month[] = 7 ;
                    $year[] = $now ->year - 1 ;
                    $count_user[] = User::whereMonth('created_at', 7)->whereYear('created_at', ($now ->year - 1))->get()->count();
                } else if ($last_month == -6) {
                    $month[] = 6 ;
                    $year[] = $now ->year - 1 ;
                    $count_user[] = User::whereMonth('created_at', 6)->whereYear('created_at', ($now ->year - 1))->get()->count();
                } else if ($last_month == -7) {
                    $month[] = 5 ;
                    $year[] = $now ->year - 1 ;
                    $count_user[] = User::whereMonth('created_at', 5)->whereYear('created_at', ($now ->year - 1))->get()->count();
                } else if ($last_month == -8) {
                    $month[] = 4 ;
                    $year[] = $now ->year - 1 ;
                    $count_user[] = User::whereMonth('created_at', 4)->whereYear('created_at', ($now ->year - 1))->get()->count();
                } else if ($last_month == -9) {
                    $month[] = 3 ;
                    $year[] = $now ->year - 1 ;
                    $count_user[] = User::whereMonth('created_at', 3)->whereYear('created_at', ($now ->year - 1))->get()->count();
                } else if ($last_month == -10) {
                    $month[] = 2 ;
                    $year[] = $now ->year - 1 ;
                    $count_user[] = User::whereMonth('created_at', 2)->whereYear('created_at', ($now ->year - 1))->get()->count();
                } else if ($last_month == -11) {
                    $month[] = 1 ;
                    $year[] = $now ->year - 1 ;
                    $count_user[] = User::whereMonth('created_at', 1)->whereYear('created_at', ($now ->year - 1))->get()->count();
                }
            } else {
                $month[] = $last_month ;
                $year[] = $now ->year ;
                $count_user[] = User::whereMonth('created_at', $last_month)->whereYear('created_at', $now ->year)->get()->count();
            }
        }

        $count_user = array_reverse($count_user);
        $month_result = array(array_reverse($month)) ;
        return view('subadmin/dashboard', compact('month_result','count_user'));

    }

    public function changLang(Request $request) {
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);

        return redirect()->back();
    }
    public function in_attendance(Request $request)
    {
        $rule = ['emp_code_att' => 'required','start_id' => 'required','emp_code_in' => 'required',];
        $now = Carbon::now();
        $isActive = Employee::where('is_active', '1')->where('emp_code', $request->code)->exists();
        if (!$isActive) {
        return redirect()->back()
            ->with('message', 'موظف غير فعال')->with('status', 'error');}
        $count = Attendance::where('emp_code_att', $request->code)->where('status', 0)->count();
        if ($count > 0) {
            return redirect()->back()->with('message', 'تم تسجيل الحضور من قبل')->with('status', 'error');
        } else {
            $row = Attendance::create([
                'start_id' => session()->get('insite'),
                'status' => 0,
                'att_way_in' => $request->att_way_in ?? 0,
                'emp_code_att' => $request->code,
                'emp_code_in' => $request->emp_code,
                'attendance_time_in' => $now->format('H:i:s'),
                'attendance_date_in' => $now->format('Y-m-d'),
                'api_token_in' => $request->api_token_in,
            ]);
            return redirect()->back()->with('message', 'تم تسجيل الحضور بنجاح')->with('status', 'success');
        }
    }

    public function out_attendance(Request $request)
    {
        $rule = ['emp_code_out' => 'required','end_site' => 'required',];
        $now = Carbon::now();
        $data = Attendance::where('emp_code_att', $request->code_out)
            ->where('status', 0)->first();

        if ($data !== null) {
            $data->update([
                'end_site' => session()->get('insite'),
                'status' => 1,
                'att_way_out' => 0,
                'emp_code_out' => $request->emp_code,
                'attendance_time_out' => $now->format('H:i:s'),
                'attendance_date_out' => $now->format('Y-m-d'),
                'api_token_out' => $request->api_token_out,
            ]);
            if ($data->emp_code_in == Auth::guard('subadmin')->user()->emp_code) {

                Auth::guard('subadmin')->logout();
                session()->forget('insite');
                return redirect('subadmin/login')->with('message', 'تم تسجيل الانصراف بنجاح')->with('status', 'success');
            }
            return redirect()->back()->with('message', 'تم تسجيل الانصراف بنجاح')->with('status', 'success');
        } else {
            return redirect()->back()->with('message', 'برجاء التوقيع بالحضور اولا')->with('status', 'error');
        }
    }

    public function getemp(Request $request)
    {
        try{
            $data3 = Employee::where('emp_code',$request->code)->first();

        } catch (\Exception $e) {
            return response()->json(['message' => 'error']);
        }
        return response()->json(['message' => 'success', 'data' => $data3->name_ar]);
    }
    public function get_cashiar_value(Request $request)
    {
        $cashier = Cashier::find(session()->get('cashier'));
        return response()->json(['cashiervalue' => $cashier->value]);
    }

}
