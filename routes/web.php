<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\mustbeLoggedIn;
use App\Http\Controllers\ItemController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
//use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;



//USER RELATED ROUTES
// REGISTER USER
Route::get('/', [UserController::class, 'showCorrectHomePage'])->name('login');
Route::post('/register', [UserController::class, 'register']);
Route::post('/resend-verification', [UserController::class, 'resendVerification'])->name('verification.resend');
// LOGIN LOGOUT USER
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware(mustbeLoggedIn::Class);



//ITEM RELATED ROUTES
// CREATE LOST ITEM RECORD
Route::get('/create-item', [ItemController::class, 'showCreateItem'])->middleware(mustbeLoggedIn::Class);
Route::post('/post-item', [ItemController::class, 'postItem'])->middleware(mustbeLoggedIn::Class);

// READ SPECIFIC LOST ITEM RECORD
Route::get('/item/{item}', [ItemController::class, 'viewsingleItem'])->middleware(mustbeLoggedIn::Class);
Route::delete('/item/{item}', [ItemController::class, 'deleteItem'])->middleware(mustbeLoggedIn::class);

// UPDATE SPECIFIC LOST ITEM RECORD
Route::get('/item/{item}/edit', [ItemController::class, 'updateItem'])->middleware(mustbeLoggedIn::class);
Route::put('/item/{item}', [ItemController::class, 'updatedItem'])->middleware(mustbeLoggedIn::class);

// Profile Related Routes
Route::get('/profile/{user:username}',[ProfileController::class, 'profile'])->middleware(mustbeLoggedIn::class);
Route::get('/edit-profile', [ProfileController::class, 'editmyProfile'])->middleware(mustbeLoggedIn::class);
Route::put('editing/{user}', [ProfileController::class, 'editedmyProfile'])->middleware('can:update,user');
Route::get('/manage-profile', [ProfileController::class, 'showProfileForm'])->middleware(mustbeLoggedIn::class);
Route::post('/manage-profile', [ProfileController::class, 'storeProfile'])->middleware(mustbeLoggedIn::class);
Route::get('/profile/password/{id}', [ProfileController::class, 'changeProfilePass'])->middleware(mustbeLoggedIn::class);
Route::put('profile/changepass/{id}', [ProfileController::class, 'changedProfilePass'])->middleware(mustbeLoggedIn::class);
Route::delete('profile/deletedp/{id}', [ProfileController::class, 'changedp'])->middleware(mustbeLoggedIn::class);

// USER RELATED ROUTES
    // USER CRUD
Route::get('/users', [UserController::class, 'users'])->middleware('can:userPage');
// CREATE
Route::get('/user/create', [UserController::class, 'createUser'])->middleware('can:userPage');
Route::post('/user/created', [UserController::class, 'newUser'])->middleware(mustbeLoggedIn::class);
// READ UPDATE
Route::get('/user/{user}/edit', [UserController::class, 'updateUser'])->middleware('can:userPage');
Route::put('update/{user}/user', [UserController::class, 'editedUser']);
Route::get('/user/password/{user}', [UserController::class, 'updatePassword'])->middleware('can:userPage');
Route::put('/user/updatepass/{user}', [UserController::class, 'updatedPassword'])->middleware('can:update,user');;
// DELETE
Route::delete('/delete/{user}', [UserController::class, 'deleteUser'])->middleware('can:delete,user');

// SEARCH
Route::get('/items/search', [ItemController::class, 'search'])->name('items.search');
Route::post('/items/image-compare', [ItemController::class, 'compareWithImage'])->middleware(mustbeLoggedIn::class)->name('items.image.compare');
Route::get('/image-search', [ItemController::class, 'imageSearch']);
Route::post('/run-image-search', [ItemController::class, 'compareWithImage'])->middleware(mustbeLoggedIn::class);
Route::get('/items/compare/{id}', [ItemController::class, 'viewComparison'])->name('items.compare.view');


//compare
Route::get('/compare/{item}', [CompareController::class, 'viewCompare']);
Route::post('/compare/{item}', [CompareController::class, 'compareItem']);
Route::get('/compare-result/{item}', [CompareController::class, 'compareResult']);
Route::post('/item/{item}/claim', [ItemController::class, 'claimItem'])->name('item.claim');


//verification

// Show verification notice
Route::get('/email/verify', function () {
    return view('auth.verify-email'); // Make sure this view exists
})->middleware('auth')->name('verification.notice');

// Handle verification link
Route::get('/email/verify/{id}/{hash}', function ($id, $hash) {
    $user = User::findOrFail($id);

    // Security check
    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(403, 'Invalid verification link.');
    }

    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new Verified($user));
    }

    return redirect('/')->with('success', 'Your email has been verified!');
})->middleware(['signed'])->name('verification.verify');

// Resend link
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::get('/item/{item}/history', [ItemController::class, 'viewHistory'])->name('item.history');

Route::get('/itemhistory', [ItemController::class, 'viewAllHistory']);
