<?php

namespace App\Http\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileComposer
{
    public function compose(View $view)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $profileImageUrl = (new class {
                use \App\Helpers\S3UrlHelper;
            })->getTemporaryUrl($user->profile, 60);

            $view->with('profileImageUrl', $profileImageUrl);
        }
    }
}
