<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
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
        // Force HTTPS URLs in production
        if(env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        Gate::define('userPage', function($user) {
            return $user->usertype == 'admin';
        });

        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                // Only try to get profile image if user profile is not null
                $profileImageUrl = null;
                if (!empty($user->profile)) {
                    $profileImageUrl = (new class {
                        use S3UrlHelper;
                    })->getTemporaryUrl($user->profile, 60);
                }

                $view->with('profileImageUrl', $profileImageUrl);
            }
        });
    }
}
