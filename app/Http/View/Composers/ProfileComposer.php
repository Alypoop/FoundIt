<?php

namespace App\Http\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Traits\S3UrlHelper;


class ProfileComposer
{
    public function compose(View $view)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $profileImageUrl = (new class {
                use S3UrlHelper;
            })->getTemporaryUrl($user->profile, 60);


            $view->with('profileImageUrl', $profileImageUrl);
        }
    }
}
