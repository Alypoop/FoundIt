<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class ProfileController extends Controller
{
    public function profile(User $user)
    {
        return view('profile-post', ['profile' => $user->profile, 'username' => $user->username, 'user' => $user, 'items' => $user->items()->latest()->get(), 'postCount' => $user->items()->count() ]);
    }

    public function editmyProfile(User $user)
    {
        $user = Auth::user();
        return view('edit-profile', compact('user'));
    }

    public function editedmyProfile(Request $request, User $user)
{
    // Validate the incoming request
    $incomingFields = $request->validate([
        'first_name' => ['required'],
        'last_name' => ['required'],
        'phone' => ['nullable', 'string', 'max:15'],
        'address' => ['nullable', 'string', 'max:255'],
        'profile' => ['nullable', 'image', 'max:3000']
    ]);

    // Check if there are changes
    $hasChanges = $incomingFields['first_name'] !== $user->first_name ||
                  $incomingFields['last_name'] !== $user->last_name ||
                  $incomingFields['phone'] !== $user->phone ||
                  $incomingFields['address'] !== $user->address ||
                  $request->hasFile('profile');

    if ($hasChanges) {
        // Handle profile image upload
        if ($request->hasFile('profile')) {
            try {
                $filename = $user->id . "-" . uniqid() . ".jpg";
                $filepath = 'profiles/' . $filename;

                $manager = new ImageManager(new Driver());
                $image = $manager->read($request->file('profile')->getRealPath());
                $imgData = $image->cover(120, 120)->toJpeg();

                // Store the image directly to B2
                $uploaded = Storage::disk('s3')->put($filepath, $imgData);

                if ($uploaded) {
                    // Log success for debugging
                    \Log::info("Profile image uploaded successfully: " . $filepath);

                    $oldProfile = $user->profile;

                    // Update user profile path
                    $user->profile = $filepath;

                    // Delete the old profile image if it exists and is not the fallback image
                    if ($oldProfile && $oldProfile !== 'profiles/fallback-profile.jpg') {
                        try {
                            Storage::disk('s3')->delete($oldProfile);
                        } catch (\Exception $e) {
                            \Log::warning("Could not delete old profile image: " . $e->getMessage());
                        }
                    }
                } else {
                    \Log::error("Failed to upload profile image to B2");
                    return redirect('/edit-profile')->with('error', 'Could not upload profile image. Please try again.');
                }
            } catch (\Exception $e) {
                \Log::error("Error uploading profile image: " . $e->getMessage());
                return redirect('/edit-profile')->with('error', 'Error uploading profile image: ' . $e->getMessage());
            }
        }

        // Update other fields
        $user->update([
            'first_name' => $incomingFields['first_name'],
            'last_name' => $incomingFields['last_name'],
            'phone' => $incomingFields['phone'],
            'address' => $incomingFields['address'],
        ]);

        // Save any profile picture changes
        $user->save();

        return redirect('/edit-profile')->with('success', 'Profile Successfully Updated.');
    }

    // If no changes, simply redirect without message
    return redirect('/edit-profile')->with('info', 'No changes have been made.');
}

    public function changeProfilePass(User $user)
    {
        return view('edit-password-self');
    }

    public function changedProfilePass(Request $request, User $user)
    {
        $user = auth()->user();
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

        return redirect('edit-profile')->with('success', 'Password updated successfully!');

    }

    public function changedp(Request $request)
    {
        // Get the authenticated user
        $user = auth()->user();

        // Validate the request, you can adjust rules as necessary
        $request->validate([
            'profile' => 'nullable', // No new profile picture is required for deletion
        ]);

        // Check if user has an existing profile picture
        if ($user->profile) {
            // Delete the profile picture from the storage (assuming stored in the 'public/profile_pictures' directory)
            $profilePath = public_path('/storage/' . $user->profile);

            if (file_exists($profilePath)) {
                unlink($profilePath); // Deletes the file from the storage
            }

            // Set the profile picture field to null
            $user->profile = null;
            $user->save(); // Save the changes
        }

        // Return a response or redirect
        return back()->with('message', 'Profile picture deleted successfully.');
    }


}
