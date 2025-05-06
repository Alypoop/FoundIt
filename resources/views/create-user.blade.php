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

            @error('user')
            <p class="alert small alert-danger shadow-sm">{{$message}}</p>
            @enderror

        <form action="/user/created" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="upload-picture row justify-content-center">
                <label for="profile">
                </label>
                <input type="file" id="profile" name="profile" class="form-control" style="display: none;">
            </div>
            <div class="row justify-content-center">
                <p style="font-size:25px;">Create User</p>    
            </div>
            <div class="row">
                <div class="col-md-6">
                    
                    <label for="first_name" class="form-label">First name:</label>
                    <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Enter First Name">
                    @error('first_name')
                    <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                    @enderror
                    <label for="last_name" class="form-label">Last name:</label>
                    <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Enter Last Name" >
                    @error('last_name')
                    <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                    @enderror
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Enter Username" >
                    @error('username')
                    <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                    @enderror
                    <label for="email" class="form-label">Email:</label>
                    <input type="text" id="email" name="email" class="form-control" placeholder="Enter University Email" >
                    @error('email')
                    <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                    @enderror

                </div>
                <div class="col-md-6">
                    <label for="address" class="form-label">Address:</label>
                    <input type="text" id="address" name="address" class="form-control" placeholder="Enter Address">
                    <label for="address" class="form-label">Phone:</label>
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter Phone Number" >
                    <label for="usertype" class="form-label">Usertype:</label>
                    <select id="usertype" name="usertype" class="form-control">
                        <option value="" disabled selected>Select User Type</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                    @error('usertype')
                    <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="row justify-content-center">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" >
                <label for="password_confirmation" class="form-label">Repeat Password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Repeat Password" >
                @error('password')
                <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                @enderror

            </div>

            <div class="row justify-content-center">
                <button type="submit" class="upload-btn btn-master mt-3">Create User</button>
            </div>
        </form>
        <a class="float-left rounded mr-3" title="Go Back" href="/users">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go back to users
        </a>
    </div>
   
</x-layout>