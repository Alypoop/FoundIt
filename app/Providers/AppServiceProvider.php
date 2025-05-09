<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\ProfileComposer;

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
                    use \App\Helpers\S3UrlHelper;
                })->getTemporaryUrl($user->profile, 60);

                $view->with('profileImageUrl', $profileImageUrl);
            }
        });
    }
}
