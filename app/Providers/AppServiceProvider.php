<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            $Setting = Setting::find(1);
            view()->share('settings', $Setting);
        } catch (\Throwable $th) {
            //throw $th;
        }

        if (!session()->get('locale')) {
            session()->put('locale', 'en');
        }

        $lang = "";
        $languages = ['ar', 'en'];
        $lang = request()->header('lang');
        if ($lang) {
            if (in_array($lang, $languages)) {
                App::setLocale($lang);
            }
        }
    }
}
