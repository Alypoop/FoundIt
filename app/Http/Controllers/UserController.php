<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Auth\Events\Registered;


class UserController extends Controller
{
    public function register(Request $request)
{
    $incomingFields = $request->validate([
        'first_name' => ['required'],
        'last_name' => ['required'],
        'username' => ['required', 'unique:users,username'],
        'email' => [
            'required',
            'unique:users,email',
            'email',
            'regex:/^[a-zA-Z0-9._%+-]+@(student\.)?tsu\.edu\.ph$/'
        ],
        'password' => ['required', 'confirmed']
    ]);

    $incomingFields['password'] = bcrypt($incomingFields['password']);

    $user = User::create($incomingFields);

    // 🚀 Send email verification
    event(new Registered($user));

    return redirect('/')->with('success', 'Account created! Please check your email to verify.');
}

    public function login(Request $request)
    {
        $incomingFields = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (auth()->attempt(['username' => $incomingFields['username'], 'password' => $incomingFields['password']])) {
            // User is authenticated, now check if email is verified
            if (auth()->user()->email_verified_at === null) {
                auth()->logout(); // log them back out
                return redirect('/')->with('failure', 'Please verify your email first.');
            }

            // Email is verified
            $request->session()->regenerate();
            return redirect('/');
        }

        return redirect('/')->with('failure', 'Invalid Username or Password');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }

    public function showCorrectHomePage()
    {
        if (auth()->check()) {
            $items = Item::latest()->paginate(8); // Fetch all items from the database
            return view('homepage-feed', ['items' => $items]);
        } else {
            return view('home');
        }
    }

    public function users(User $user)
    {
        return view('users', ['user' => $user->get()]);
    }

    public function updateUser(User $user, )
    {
        return view('edit-user', ['user' => $user, 'profile' => $user->profile]);
    }

    public function editedUser(Request $request, User $user)
    {
    // Validate the incoming request
    $incomingFields = $request->validate(
    [
        'first_name' => ['required'],
        'last_name' => ['required'],
        'phone' => ['nullable', 'string', 'max:15'], // Adjust phone validation
        'address' => ['nullable', 'string', 'max:255'], // Adjust address validation
        'usertype' => ['required', 'in:admin,user']
    ]);

    // Compare the incoming fields with the existing user's data
    $hasChanges = false;

    if (
        $incomingFields['first_name'] !== $user->first_name ||
        $incomingFields['last_name'] !== $user->last_name ||
        $incomingFields['phone'] !== $user->phone || // Check for changes in phone
        $incomingFields['address'] !== $user->address || // Check for changes in address
        $incomingFields['usertype'] !== $user->usertype
        ) {
        $hasChanges = true;
    }

    // If there are changes, update the user
    if ($hasChanges) {
        

        $user->update($incomingFields);
        return redirect('/users')->with('success', 'User Successfully Updated.');
    }

    // If no changes, simply redirect without message
    return redirect('/users')->with('info', 'No changes have been made.');
    }

    public function deleteUser(User $user)
    {
        $user->delete();

        return redirect('users')->with('success', 'User Successfully Deleted');
    }

    public function createUser(User $user)
    {
        return  view('create-user');
    }

    public function newUser(Request $request)
    {
       
            $incomingFields = $request->validate
            (
                [
                    'first_name' => ['required'],
                    'last_name' => ['required'],
                    'username' => ['required', 'unique:users,username'],
                    'email' => ['required', 'unique:users,email', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@tsu\.edu\.ph$/'],
                    
                    'address' => 'nullable',
                    'phone' => 'nullable',
                    'password' => 'confirmed',
                    'usertype' => ['required', 'in:admin,user']
                ]
            );
    
            User::create($incomingFields);
            return redirect('users')->with('success', 'User Created');
    }

    public function updatePassword(User $user)
    {
        $user = User::find($user->id);
        return view('edit-password', compact('user'));
    }
    
    public function updatedPassword(Request $request, User $user)
    {
        $incomingFields = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed', // 'confirmed' checks if new_password matches new_password_confirmation
        ]);

        // Check if the old password is correct
        if (!Hash::check($incomingFields['old_password'], $user->password)) {
            return back()->withErrors(['old_password' => 'The Old Password is incorrect.']);
        }

        // Update the user's password
        $user->password = Hash::make($incomingFields['new_password']);
        $user->save();

        return redirect('users')->with('success', 'Password updated successfully!');
        
    }

}
