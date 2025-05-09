<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>FoundIt</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <script defer src="https://use.fontawesome.com/releases/v5.5.0/js/all.js" integrity="sha384-GqVMZRt5Gn7tB9D9q7ONtcp4gtHIUEW/yG7h98J7IpE3kpi+srfFyyB/04OV6pG0" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css'])
  </head>
  <body>


        @auth

        <header class="header-bar mb-3" style="background-color:#b5b58b;">
          <div class="container d-flex flex-column flex-md-row align-items-center p-3">
            <h4 class="my-0 mr-md-auto font-weight-normal"><a href="/" style="color:white">FoundIt</a></h4>
            <div class="flex-row my-3 my-md-0">
              <a href="items/search" class="text-white mr-2 header-search-icon" title="Search" data-toggle="tooltip" data-placement="bottom"><i class="fas fa-search"></i></a>
              @can('view', auth()->user())
              <a href="/users" class="text-white mr-2 header-search-icon" title="Users" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-users" aria-hidden="true"></i></a>
              <a href="/itemhistory" class="text-white mr-2 header-search-icon" title="History Log" data-toggle="tooltip" data-placement="bottom"><i  class="bi bi-clipboard-minus-fill" aria-hidden="true"></i></a>
              @endcan
              <a href="/profile/{{auth()->user()->username}}" class="mr-2"><img title="My Profile" data-toggle="tooltip" data-placement="bottom" style="width: 32px; height: 32px; border-radius: 16px" src="{{ $profileImageUrl }}" /></a>

              <a class="btn btn-sm btn-master mr-2" href="/create-item">Post a Found Item</a>
              <form action="/logout" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-sm btn-danger">Sign Out</button>
              </form>
            </div>
          </div>
        </header>
        <!-- header ends here -->


        @else

        <header class="header-bar mb-3" style="background-color:#b5b58b;">
        <div class="container d-flex flex-column flex-md-row align-items-center p-3">
        <h4 class="my-0 mr-md-auto font-weight-normal"><a href="/" style="color:white">FoundIt</a></h4>
        <form action="/login" method="POST" class="mb-0 pt-2 pt-md-0">
          @csrf
          <div class="row align-items-center">
            <div class="col-md mr-0 pr-md-0 mb-3 mb-md-0">
              <input name="username" class="form-control form-control-sm input-dark" type="text" placeholder="Username" autocomplete="off" />
            </div>
            <div class="col-md mr-0 pr-md-0 mb-3 mb-md-0">
              <input name="password" class="form-control form-control-sm input-dark" type="password" placeholder="Password" />
            </div>
            <div class="col-md-auto">
              <button class="btn btn-sm" style="background-color:#fce3c2;">Sign In</button>
            </div>
          </div>
        </form>
      </div>
    </header>

    @if (session()->has('success'))
    <div class="container container-narrow">
      <div class="alert alert-success text-center">
        {{session('success')}}
      </div>
    </div>
    @endif

    @if (session()->has('failure'))
    <div class="container container-narrow">
      <div class="alert alert-danger text-center">
        {{session('failure')}}
      </div>
    </div>
    @endif

        @endauth
    <!-- header ends here -->

    {{ $slot }}


  <!-- footer begins -->
  <footer class="border-top text-center small text-muted py-3">
    <p class="m-0">Copyright &copy; 2024 <a href="/" class="text-muted">OurApp</a>. All rights reserved.</p>
  </footer>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script>
      $('[data-toggle="tooltip"]').tooltip()
    </script>
</body>
</html>
