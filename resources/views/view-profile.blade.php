<x-layout>
    <div class="container py-md-5 container--narrow">
            @if (session()->has('success'))
            <div class="container container--narrow">
                <div class="alert alert-success text-center">
                    {{session('success')}}
                </div>
            </div>
            @endif

            @if (session()->has('info'))
            <div class="container container--narrow">
                <div class="alert alert-secondary text-center">
                    {{session('info')}}
                </div>
            </div>
            @endif

            @error('profile')
            <p class="alert small alert-danger shadow-sm">{{$message}}</p>
            @enderror
        
            <div class="d-flex justify-content-between align-items-center">
                <a class="rounded" title="Go Back" href="/profile/{{auth()->user()->username}}">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> Go back to Profile
                </a>
                
                <a class="rounded" title="Go Back" href="/edit-profile">
                   Update your Profile
                </a>
            
                <a class="rounded" title="Remove Profile Photo" href="/profile/password/{{auth()->user()->id}}">
                  Change Password <i class="fa fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>

       
            <div class="upload-picture row justify-content-center">
                <label for="profile">
                    <img src="/storage/{{auth()->user()->profile}}" style="border-radius:150px" alt="Upload Picture">
                </label>
                <input type="file" id="profile" name="profile" class="form-control" style="display: none;">
            </div>
            <div class="row justify-content-center">
                
                <form action="profile/deletedp/{{auth()->user()->id}}" method="POST">
                    @csrf
                    @method('DELETE')
            
                     
                        <a href="" type='submit'>Remove Profile Photo</a>
                </form>  
            </div>
            <div class="row justify-content-center">
                <p style="font-size:25px;"> {{$user->username}}</p>

            </div>
            
            <div class="row">
                <div class="col-md-6">
                    
                    <label for="first_name" class="form-label">First name:</label>
                    <input readonly type="text" id="first_name" name="first_name" class="form-control" placeholder="Enter First Name" value="{{$user->first_name}}">
                    <label for="last_name" class="form-label">Last name:</label>
                    <input readonly type="text" id="last_name" name="last_name" class="form-control" placeholder="Enter Last Name" value="{{$user->last_name}}">
                </div>
                <div class="col-md-6">
                    <label for="address" class="form-label">Address:</label>
                    <input readonly type="text" id="address" name="address" class="form-control" placeholder="Enter Address" value="{{$user->address}}">
                    <label for="address" class="form-label">Phone:</label>
                    <input readonly type="text" id="phone" name="phone" class="form-control" placeholder="Enter Phone Number" value="{{$user->phone}}">
                </div>
            </div>
            
       
       
    </div>
   
</x-layout>