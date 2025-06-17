<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class ClientLoginController extends Controller
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
        $this->middleware('guest')->except('logout');
    }

    public function showClientLoginForm(Request $request)
    {
        return view('client.auth.login');
    }

    public function clientLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required'
        ]);

        $User = User::whereEmail($request->email)->first();

        if ($User->ipcheck == NULL) {
            User::where('id', $User->id)->update([
                'ipcheck' => request()->ip(),
            ]);
        } else {
            if ($User->ipcheck != request()->ip()) {
                return back()->withErrors(['email' => "عفوا .. الحساب غير مخصص لهذا الجهاز" ])->withInput($request->only('email', 'remember'));
            }
        }

        if($User){
            if($User->is_active == 1){
                if (Auth::attempt(['email' => $request->email,'password' => $request->password], $request->get('remember'))){
                    return redirect()->intended('/dashboard');
                } else {
                    return back()->withErrors(['password' => trans('auth.error_password') ])->withInput($request->only('email', 'remember'));
                }
            } else {
                return back()->withErrors(['email' => trans('auth.error_is_active')])->withInput($request->only('email', 'remember'));
            }
        } else {
            return back()->withErrors(['email' => trans('auth.error_email')])->withInput($request->only('email', 'remember'));
        }

        return back()->withInput($request->only('email', 'remember'));
    }

    public function logout() {
        Auth::logout();
        return redirect('login');
    }

}
