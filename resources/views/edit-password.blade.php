<x-layout>
    <link rel="stylesheet" href="/register.css">

    
    <div class="container">
       
        <h1>Change Password</h1>
        <div class="registration-box">
                  
                <form action="/user/updatepass/{{$user->id}}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Display error message for old_password -->
                    @if($errors->has('old_password'))
                    <div class="m-0 small alert alert-danger shadow-sm">{{ $errors->first('old_password') }}</div>
                    @endif

                    <label for="old_password">Old Password:</label>
                    <input type="password" name="old_password" required>
                
                    @if($errors->has('new_password_confirmation'))
                    <div class="error">{{ $errors->first('new_password_confirmation') }}</div>
                    @endif

                    <label for="new_password">New Password:</label>
                    <input type="password" name="new_password" required>
                
                    <label for="new_password_confirmation">Confirm New Password:</label>
                    <input type="password" name="new_password_confirmation" required>
                
                    <button class="btn btn-primary" type="submit">Save Changes</button>
                    <p style="font-size:15px; display:inline-block;"><small><strong><a href="/users" class="primary">&laquo Return to Users</a></strong></small></p>
                </form>

            
        </div>
        
    </div>
   

</x-layout>