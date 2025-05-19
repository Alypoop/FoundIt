<x-layout>
    <div class="container py-md-5">
        <div class="row align-items-center">
          <div class="col-lg-7 py-3 py-md-5">
            <h1 class="display-3">Lost Something?</h1>
            <p class="lead text-muted">"Lost an item? We’ve got you covered! Whether it’s a misplaced gadget, accessory, or a personal belonging, we’re here to help you reconnect with what matters. Search, report, and get your lost items back in no time."</p>
          </div>
          <div class="col-lg-5 pl-lg-5 pb-3 py-lg-5">
            <form action="/register" method="POST" id="registration-form">
                @csrf

                <div class="form-group">
                  <label for="username-register" class="text-muted mb-1"><small>First Name</small></label>
                  <input value="{{old('first_name')}}" name="first_name" id="first_name" class="form-control" type="text" placeholder="First Name" autocomplete="off" />
                </div>

                <div class="form-group">
                  <label for="username-register" class="text-muted mb-1"><small>Last Name</small></label>
                  <input value="{{old('last_name')}}" name="last_name" id="last_name" class="form-control" type="text" placeholder="Last Name" autocomplete="off" />
                </div>

                <div class="form-group">
                    <label for="username-register" class="text-muted mb-1"><small>Username</small></label>
                    <input name="username" id="username" class="form-control" type="text" placeholder="Username" autocomplete="off" />
                    @error('username')
                    <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                    @enderror
                </div>
  
              <div class="form-group">
                    <label for="email-register" class="text-muted mb-1"><small>Email</small></label>
                    <input name="email" id="email" class="form-control" type="text" placeholder="University email" autocomplete="off" />
                    @error('email')
                    <p class="m-0 small alert alert-danger shdawos-sm">{{$message}}</p>
                    @enderror
                </div>
  
              <div class="form-group">
                <label for="password-register" class="text-muted mb-1"><small>Password</small></label>
                <input name="password" id="password" class="form-control" type="password" placeholder="Create a password" />
                @error('password')
                <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                @enderror
            </div>
  
              <div class="form-group">
                <label for="password_confirmation" class="text-muted mb-1"><small>Confirm Password</small></label>
                <input name="password_confirmation" id="password_confirmation" class="form-control" type="password" placeholder="Confirm password" />
               
               </div>
  
              <button type="submit" class="py-3 mt-4 btn btn-lg btn-master btn-block">Sign Up</button>

            </form>

            <div class="text-right mt-2">
                <a href="#" data-toggle="modal" data-target="#resendVerificationModal">Resend Verification Link</a>
              </div>

              <div class="modal fade" id="resendVerificationModal" tabindex="-1" role="dialog" aria-labelledby="resendModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="resendModalLabel">Resend Verification Email</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p>Enter your email to receive a new verification link.</p>
                        <input type="email" name="email" class="form-control" placeholder="Your email" required>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Send Verification</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
          </div>
        </div>
      </div>
</x-layout>