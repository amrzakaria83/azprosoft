<?php

namespace App\Http\Controllers\Admin;

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
    public function index() 
    {

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
        return view('admin/dashboard', compact('month_result','count_user'));

    }

    public function changLang(Request $request) 
    {
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);

        return redirect()->back();
    }
    

}
