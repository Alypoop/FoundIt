<x-layout>
  <div class="container-fluid" style="width:1220px;">
      <div class="row">
          <div class="col-md-12">
              <div class="card">
                  <div class="card-body">
                      <h5 class="card-title text-uppercase mb-0 d-inline"><strong>Users</strong></h5>
                      <a class=" float-left rounded mr-3" title="Go Back" href="/">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                      </a>
                      <a class="btn btn-master float-right rounded" href="/user/create">Create New User</a>
                  </div>
                  
                  <div class="table-responsive">
                      <table id="myTable" class="table no-wrap user-table mb-0">

                          @if (session()->has('success'))
                          <div class="container container--narrow">
                          <div class="alert alert-success text-center">
                              {{ session('success') }}
                          </div>
                          </div>
                          @endif

                          @if (session()->has('failure'))
                          <div class="container container--narrow">
                            <div class="alert alert-danger text-center">
                              {{ session('failure') }}
                            </div>
                          </div>
                          @endif
                          
                          <thead style="background-color:#ecdbc7;">
                          <tr>
                            <th scope="col" class="border-0 text-uppercase font-medium">First Name</th>
                            <th scope="col" class="border-0 text-uppercase font-medium">Last Name</th>
                            <th scope="col" class="border-0 text-uppercase font-medium">Username</th>
                            <th scope="col" class="border-0 text-uppercase font-medium">University Email</th>
                            <th scope="col" class="border-0 text-uppercase font-medium">Role</th>
                            <th scope="col" class="border-0 text-uppercase font-medium">Address</th>
                            <th scope="col" class="border-0 text-uppercase font-medium">Phone Number</th>
                            <th scope="col" class="border-0 text-uppercase font-medium">Actions</th>
                          </tr>
                          </thead>
                          <tbody>
                          @foreach($user as $users)
                          <tr>
                                  <td class="pl-3">{{ $users->first_name }}</td>
                                  <td class="pl-3">{{ $users->last_name }}</td>
                                  <td class="pl-3">{{ $users->username }}</td>
                                  <td class="pl-3">{{ $users->email }}</td>
                                  <td class="pl-3">{{ $users->usertype }}</td>
                                  <td class="pl-3">{{ $users->address }}</td>
                                  <td class="pl-3">{{ $users->phone }}</td>
                                  <td>
                                    <div class="btn-group mr-2">
                                      @can('view', auth()->user())
                                      <a class="btn btn-master float-right rounded mr-3" href="/user/password/{{ $users->id }}">
                                          <i class="fa fa-key"></i> <!-- Update Password Icon -->
                                      </a>
                                      @endcan
                                      
                                      <a class="btn btn-master float-right rounded mr-3" href="/user/{{ $users->id }}/edit">
                                          <i class="fa fa-pencil-alt"></i> <!-- Update Icon -->
                                      </a>
                                      
                                      
                                      <form class="delete-post-form d-inline" action="delete/{{ $users->id }}" method="POST"
                                            onclick="checker('Are you sure you want to delete this user?');">
                                          @method('DELETE')
                                          @csrf
                                          <button class="btn btn-master float-right rounded mr-3">
                                              <i class="fa fa-trash"></i> <!-- Delete Icon -->
                                          </button>
                                      </form>
                                      
                                  </div>
                                  </td>
                          </tr>
                          @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <script>
      function checker(message) {
        var result = confirm(message);
        if (result == false) {
            event.preventDefault();
        }
      }
    </script>
</x-layout>
