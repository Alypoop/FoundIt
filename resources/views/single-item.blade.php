<x-layout>
    <div class="container py-md-5">
        @if (session()->has('success'))
        <div class="container container--narrow">
            <div class="alert alert-success text-center">
                {{session('success')}}
            </div>
        </div>
        @endif
        
        <div class="row">
            <a class="float-left rounded mr-3" title="Go Back" href="{{ url()->previous() }}">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp Return
            </a>
        </div>
        
        <div class="d-flex justify-content-between">
            <h2>{{$item->title}}</h2>      
            <span class="pt-2">
                @can('update', $item)
                <a href="{{ route('item.history', $item->id) }}" class="btn btn-outline-info">View History</a>
                <a href="/item/{{$item->id}}/edit" class="text-primary mr-2" data-toggle="tooltip" data-placement="top" title="Edit">
                    <i class="fas fa-edit"></i>
                </a>      
                <form class="delete-post-form d-inline" action="/item/{{$item->id}}" method="POST"
                    onclick="checker('Are you sure you want to delete this user?');">
                    @method('DELETE')
                    @csrf
                    <button class="delete-post-button text-danger">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
                @endcan
            </span>
        </div>
        
        <p class="text-muted small mb-4">
            <a href="#"><img class="avatar-tiny" src="/storage/{{$item->user->profile}}" /></a>
            Posted by <a href="{{ url('/profile/' . $item->user->username) }}">{{$item->user->first_name}} {{$item->user->last_name}}</a> on {{$item->created_at->format('n/j/Y')}}
        </p>

        <div class="row">
            <div class="col-md-6">
                <p><strong>Found Date:</strong> {{$item->lost_date->format('F j, Y')}}</p>
                <p><strong>Category:</strong> {{$item->category->name}}</p>
                @if($item->itemType)
                    <p><strong>Item Type:</strong> {{$item->itemType->name}}</p>
                @endif
                <p><strong>Location:</strong> {{$item->location}}</p>
                <p style="margin-bottom: 4px;"><strong>Claimed By:</strong> {{ $item->claimed_by ?? 'Not claimed' }}</p>
                
                @if (
                    $item->status !== 'Claimed' &&
                    $item->status !== 'To Be Claimed' &&
                    $item->status !== 'Disposed' &&
                    $item->user_id !== auth()->id()
                )
                <form action="{{ route('item.claim', $item->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="btn btn-success btn-sm"
                        style="margin-top: 4px; background-color: green; color: white; padding: 6px 12px; border: none; border-radius: 5px;">
                        Claim
                    </button>
                </form>
                @endif
                <p><strong>Posted by:</strong> <a href="{{ url('/profile/' . $item->user->username) }}">{{ $item->user->username }}</a></p>
            </div>
            
            @can('view', $user)
            <div class="col-md-6">
                <p><strong>Status:</strong> {{$item->status}}</p>
                <p><strong>Storage Bin:</strong> {{$item->bin ?? 'N/A'}}</p>
                <p><strong>Issued By:</strong> {{$item->issued_by ?? 'N/A'}}</p>
                <p><strong>Issued Date:</strong> {{$item->issued_date ? $item->issued_date->format('F j, Y') : 'N/A'}}</p>
                <p><strong>Received By:</strong> {{$item->received_by ?? 'N/A'}}</p>
                <p><strong>Received Date:</strong> {{$item->received_date ? $item->received_date->format('F j, Y') : 'N/A'}}</p>
            </div>
            @endcan
        </div>

        <div class="body-content">
            <p><strong>Markings:</strong></p>
            <textarea readonly class="form-control mb-2" rows="3" style="height: 50px; width: 100%; overflow-y: auto; background-color: #e2e8f0; border: none; resize: none; padding: 5px; border-radius: 5px;">{{ $item->markings }}</textarea>
        </div>

        @if ($item->photo_img)
        <div class="container d-flex justify-content-center align-items-center">
            <div class="text-center">
                <p><strong>Item Image:</strong></p>
                <img src="/storage/{{$item->photo_img}}" alt="Image" style="max-width: 500px; height: auto;">
            </div>
        </div>
        @endif
    </div>

    <script>
        function checker() {
            var result = confirm('Are you sure you want to delete this Item?');
            if (result == false) {
                event.preventDefault();
            }
        }
    </script>
</x-layout>