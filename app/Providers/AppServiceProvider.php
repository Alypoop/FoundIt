<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\ProfileComposer;
use App\Traits\S3UrlHelper;


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
        Gate::define('userPage', function($user) {
            return $user->usertype == 'admin';
        });

        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $profileImageUrl = (new class {
                    use S3UrlHelper;
                })->getTemporaryUrl($user->profile, 60);

                $view->with('profileImageUrl', $profileImageUrl);
            }
        });
    }
}
