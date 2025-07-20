<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Site;
use App\Models\Cashier;
use Auth;

class AdminLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['guest:admin','guest:superadmin','guest:subadmin'])->except('logout');
    }

    public function showAdminLoginForm()
    {
        
        return view('admin.auth.login');
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'emp_code'   => 'required',
            'password' => 'required',
            
        ]);

        $employee = Employee::where('emp_code', $request->emp_code)->first();

        if ($employee) {
            if ($employee->is_active == 1) {
                if ($employee->type == '0') {
                    if (Auth::guard('admin')->attempt(['emailaz' => $employee->emailaz,'password' => $request->password, 'type' => '0', 'emp_code' => $employee->emp_code ], $request->get('remember'))) {
                        $request->session()->put('locale', 'ar');
                        return redirect()->intended('/admin');
                    }
                } else if ($employee->type == '2') {
                    if (Auth::guard('subadmin')->attempt(['emailaz' => $employee->emailaz,'password' => $request->password, 'type' => '2', 'emp_code' => $employee->emp_code ], $request->get('remember'))) {
                        $request->session()->put('locale', 'ar');
                        return Redirect::to('/subadmin');
                    }
                } else if ($employee->type == '3') {
                    if (Auth::guard('superadmin')->attempt(['emailaz' => $employee->emailaz,'password' => $request->password, 'type' => '3', 'emp_code' => $employee->emp_code ], $request->get('remember'))) {
                        $request->session()->put('locale', 'ar');
                        return Redirect::to('/superadmin');
                    }
                } else {
                    return back()->withErrors(['password' => trans('auth.error_password') ])->withInput($request->only('emailaz'));
                }
            } else {
                return back()->withErrors(['emailaz' => trans('auth.error_is_active')])->withInput($request->only('emailaz'));
            }
        } else {
            return back()->withErrors(['emailaz' => trans('auth.error_email')])->withInput($request->only('emailaz'));
        }
        return back()->withInput($request->only('emailaz','insite','emp_code','cashier'));
    }
    public function logout() {
        Auth::guard('admin')->logout();
        session()->forget('insite','cashier');
        return redirect('admin/login');
    }

}
