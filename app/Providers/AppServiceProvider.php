<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->booted(function (Carbon $carbon){
            $carbon->setLocale(App::getLocale());
        });

        Inertia::share([
            'success' => function () {
                return Session::get('success');
            }
        ]);

        Inertia::share([
            'permissions' => function () {
                return Auth::user()->getAllPermissions();
            }
        ]);
    }
}
