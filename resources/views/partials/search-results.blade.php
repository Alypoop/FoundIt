@if ($items->count())
<div class="row">
    @foreach ($items as $item)
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                @if ($item->photo_img)
                    <img src="/storage/{{ $item->photo_img }}" alt="Item image" class="card-img-top" style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <a href="/item/{{ $item->id }}" class="text-decoration-none">
                        <h5 class="card-title">{{ $item->title }}</h5>
                    </a>
                    <p class="card-text">
                        <strong>Author:</strong>
                        <img class="sm-profile-image" src="/storage/{{ $item->user->profile ?? 'profile/default.jpg' }}" />
                        {{ $item->user->username }}<br>
                        <strong>Found Date:</strong> {{ $item->lost_date }}<br>
                        <strong>Category:</strong> {{ $item->category->name }}<br>
                        <strong>Type:</strong> {{ $item->itemType->name }}<br>
                        <strong>Location:</strong> {{ $item->location }}
                    </p>
                    <p>
                        <textarea readonly class="form-control mb-2" rows="3" readonly 
                                  style="height: 50px; width: 100%; overflow-y: auto; 
                                  background-color: #e2e8f0; border: none; resize: none; 
                                  padding: 5px; border-radius: 5px;">{{ $item->markings }}</textarea>
                    </p>
                </div>
            </div>
        </div>
    @endforeach
</div>
@else
<div class="text-center mt-4">
    <p>No items matched your search.</p>
</div>
@endif