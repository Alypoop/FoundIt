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

            <form action="/update/{{$user->id}}/user" method="POST">
                @csrf
        @method('PUT')
            <div class="row justify-content-center">
                <p style="font-size:25px;"> {{$user->username}}</p>    
            </div>
            <div class="row">
                <div class="col-md-6">
                    
                    <label for="first_name" class="form-label">First name:</label>
                    <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Enter First Name" value="{{$user->first_name}}">
                    <label for="last_name" class="form-label">Last name:</label>
                    <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Enter Last Name" value="{{$user->last_name}}">
                </div>
                <div class="col-md-6">
                    <label for="address" class="form-label">Address:</label>
                    <input type="text" id="address" name="address" class="form-control" placeholder="Enter Address" value="{{$user->address}}">
                    <label for="address" class="form-label">Phone:</label>
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter Phone Number" value="{{$user->phone}}">
                </div>
            </div>

            <label for="usertype" >User Type:</label>
                <select id="usertype" class="form-control" name="usertype">
                    <option value="admin" {{ $user->usertype == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ $user->usertype == 'user' ? 'selected' : '' }}>User</option>
                </select>

            <div class="row justify-content-center">
                <button type="submit" class="upload-btn btn-master mt-3">Update Profile</button>
            </div>
        </form>
        <a class="float-left rounded mr-3" title="Go Back" href="/users">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go back to User
        </a>
    </div>
   
</x-layout>