<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {

            if ($guard == "admin" && Auth::guard($guard)->check()) {
                return redirect("/admin"); //name of the route to be redirected on successful admin login
            } elseif ($guard == "subadmin" && Auth::guard($guard)->check()) {
                return redirect("/subadmin"); //name of the route to be redirected on successful subadmin login
            } elseif ($guard == "superadmin" && Auth::guard($guard)->check()) {
                return redirect("/superadmin"); //name of the route to be redirected on successful superadmin login
            }
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }


        }

        return $next($request);
    }
}
