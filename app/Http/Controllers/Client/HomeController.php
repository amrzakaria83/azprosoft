<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use Carbon\Carbon;
use App;
use Auth;

class HomeController extends Controller
{

    public function index() {

        $now = Carbon::now();
        $query['results'] = "[[0, 10, 20, 30, 40, 50, 30, 20, 80, 80, 70, 50, 30]]";
        $lastDay = date('m',strtotime('last month'));

        $month[] = $now ->month ;
        $year[] = $now ->year ;

        $count_user[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 0)->whereMonth('date', $now ->month)->whereYear('date', $now ->year)->get()->count();
        $count_used[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 1)->whereMonth('date', $now ->month)->whereYear('date', $now ->year)->get()->count();

        for ($i=1; $i < 12; $i++) { 
            $last_month = $now ->month - $i ;
            if ($last_month < 1) {
                if ($last_month == 0) {
                    $month[] = 12 ;
                    $year[] = $now ->year - 1 ;
                    $count_user[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 0)->whereMonth('date', 12)->whereYear('date', ($now ->year - 1))->get()->count();
                    $count_used[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 1)->whereMonth('date', 12)->whereYear('date', ($now ->year - 1))->get()->count();
                } else if ($last_month == -1) {
                    $month[] = 11 ;
                    $year[] = $now ->year - 1 ;
                    $count_user[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 0)->whereMonth('date', 11)->whereYear('date', ($now ->year - 1))->get()->count();
                    $count_used[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 1)->whereMonth('date', 11)->whereYear('date', ($now ->year - 1))->get()->count();
                } else if ($last_month == -2) {
                    $month[] = 10 ;
                    $year[] = $now ->year - 1 ;
                    $count_user[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 0)->whereMonth('date', 10)->whereYear('date', ($now ->year - 1))->get()->count();
                    $count_used[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 1)->whereMonth('date', 10)->whereYear('date', ($now ->year - 1))->get()->count();
                } else if ($last_month == -3) {
                    $month[] = 9 ;
                    $year[] = $now ->year - 1 ;
                    $count_user[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 0)->whereMonth('date', 9)->whereYear('date', ($now ->year - 1))->get()->count();
                    $count_used[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 1)->whereMonth('date', 9)->whereYear('date', ($now ->year - 1))->get()->count();
                } else if ($last_month == -4) {
                    $month[] = 8 ;
                    $year[] = $now ->year - 1 ;
                    $count_user[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 0)->whereMonth('date', 8)->whereYear('date', ($now ->year - 1))->get()->count();
                    $count_used[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 1)->whereMonth('date', 8)->whereYear('date', ($now ->year - 1))->get()->count();
                } else if ($last_month == -5) {
                    $month[] = 7 ;
                    $year[] = $now ->year - 1 ;
                    $count_user[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 0)->whereMonth('date', 7)->whereYear('date', ($now ->year - 1))->get()->count();
                    $count_used[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 1)->whereMonth('date', 7)->whereYear('date', ($now ->year - 1))->get()->count();
                } else if ($last_month == -6) {
                    $month[] = 6 ;
                    $year[] = $now ->year - 1 ;
                    $count_user[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 0)->whereMonth('date', 6)->whereYear('date', ($now ->year - 1))->get()->count();
                    $count_used[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 1)->whereMonth('date', 6)->whereYear('date', ($now ->year - 1))->get()->count();
                } else if ($last_month == -7) {
                    $month[] = 5 ;
                    $year[] = $now ->year - 1 ;
                    $count_user[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 0)->whereMonth('date', 5)->whereYear('date', ($now ->year - 1))->get()->count();
                    $count_used[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 1)->whereMonth('date', 5)->whereYear('date', ($now ->year - 1))->get()->count();
                } else if ($last_month == -8) {
                    $month[] = 4 ;
                    $year[] = $now ->year - 1 ;
                    $count_user[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 0)->whereMonth('date', 4)->whereYear('date', ($now ->year - 1))->get()->count();
                    $count_used[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 1)->whereMonth('date', 4)->whereYear('date', ($now ->year - 1))->get()->count();
                } else if ($last_month == -9) {
                    $month[] = 3 ;
                    $year[] = $now ->year - 1 ;
                    $count_user[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 0)->whereMonth('date', 3)->whereYear('date', ($now ->year - 1))->get()->count();
                    $count_used[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 1)->whereMonth('date', 3)->whereYear('date', ($now ->year - 1))->get()->count();
                } else if ($last_month == -10) {
                    $month[] = 2 ;
                    $year[] = $now ->year - 1 ;
                    $count_user[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 0)->whereMonth('date', 2)->whereYear('date', ($now ->year - 1))->get()->count();
                    $count_used[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 1)->whereMonth('date', 2)->whereYear('date', ($now ->year - 1))->get()->count();
                } else if ($last_month == -11) {
                    $month[] = 1 ;
                    $year[] = $now ->year - 1 ;
                    $count_user[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 0)->whereMonth('date', 1)->whereYear('date', ($now ->year - 1))->get()->count();
                    $count_used[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 1)->whereMonth('date', 1)->whereYear('date', ($now ->year - 1))->get()->count();
                }
            } else {
                $month[] = $last_month ;
                $year[] = $now ->year ;
                $count_user[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 0)->whereMonth('date', $last_month)->whereYear('date', $now ->year)->get()->count();
                $count_used[] = Ticket::where('user_id', Auth::user()->id)->where('bdg', 1)->whereMonth('date', $last_month)->whereYear('date', $now ->year)->get()->count();
            }
        }

        $count_used = array_reverse($count_used);
        $count_user = array_reverse($count_user);
        $month_result = array(array_reverse($month)) ;
        return view('client/dashboard', compact('month_result','count_user','count_used'));
    }

    public function changLang(Request $request) {
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);

        return redirect()->back();
    }
}
