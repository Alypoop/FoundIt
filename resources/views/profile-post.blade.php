<x-layout>
    <div class="container py-md-5 container--narrow">

      @if (session()->has('success'))
        <div class="container container--narrow">
        <div class="alert alert-success text-center">
            {{session('success')}}
        </div>
        </div>
        @endif

      <div class="row">
        <a class="float-left rounded mr-3" title="Go Back" href="/">
          <i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp Return to Home
      </a>
      
      </div>
      <div class="d-flex justify-content-between align-items-center">
        <h2>
          <img class="avatar-small" src="/storage/{{$profile}}" />{{$username}}
         @if(auth()->user()->username === $username) 
         <a class="btn btn-sm btn-master mr-2" href="/edit-profile">Edit My Profile</a>
         @endif
        </h2>
      </div>
      
      
        <div class="profile-nav nav nav-tabs pt-2 mb-4">
          <a href="#" class="profile-nav-link nav-item nav-link active">Items: {{$postCount}}</a>
        </div>
  
        <div class="list-group">
          @foreach($items as $item)
          <a href="/item/{{$item->id}}" class="list-group-item list-group-item-action">
            <img class="avatar-tiny" src="/storage/{{$profile}}" />
            <strong>{{$item->title}}</strong> on {{$item->created_at->format('n/j/Y')}}
          </a>
          @endforeach
         
        </div>
      </div>
</x-layout>