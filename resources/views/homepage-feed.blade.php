<x-layout>
    <div class="container py-md-5 container--narrow">
      <div class="text-center">
        @if (session()->has('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
        @endif
        <h2>Welcome <strong>{{ auth()->user()->first_name }}</strong></h2>
      </div>
    </div>

    <div class="container">
      <div class="row justify-content-center">
        @foreach($items as $item)
          <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex align-items-stretch">
            <div class="card w-100 shadow-sm">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title text-center">
                 {{ $item->title }}
                </h5>

                <h6 class="card-subtitle mb-2 text-muted text-center">
                  Author:
                  <img title="My Profile" data-toggle="tooltip" data-placement="bottom"
                    src="{{ $profileImageUrl }}"
                    style="width: 20px; height: 20px; border-radius: 50%;" />
                  &nbsp;{{ $item->user->username }}
                </h6>

                <p class="text-muted small text-center mb-1">Date Found: {{ $item->lost_date }}</p>
                <p class="text-muted small text-center mb-2">Category: {{ $item->category }}</p>
                <p class="text-center mb-2">
                  Status:
                  <span class="badge
                    @if($item->status === 'Claimed' || $item->status === 'To Be Claimed')
                      bg-success
                    @elseif($item->status === 'Disposed' || $item->status === 'Unclaimed')
                      bg-danger
                    @else
                      bg-secondary
                    @endif">
                    {{ $item->status }}
                  </span>
                </p>

                <textarea readonly class="form-control mb-2" rows="3" readonly style="height: 50px; width: 100%; overflow-y: auto; background-color: #e2e8f0; border: none; resize: none; padding: 5px; border-radius: 5px;">{{ $item->markings }}</textarea>

                @if ($item->photo_img)
                <div class="text-center mt-auto">
                  <img src="/storage/{{ $item->photo_img }}" alt="{{ $item->title }}"
                    class="img-fluid rounded" style="max-height: 250px; object-fit: contain;">
                </div>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Pagination -->
      <div class="pagination justify-content-center">
        {{ $items->links('pagination::bootstrap-4') }}
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </x-layout>
