<x-layout>

    @if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif

    <div class="container my-5">
        <h2 class="text-center mb-4">Upload Image for Comparison</h2>

        <form action="/run-image-search" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    <input type="file" name="image" class="form-control mb-3" required>
                </div>
            </div>

            {{-- Hidden inputs for each matched item --}}
            @foreach ($items as $item)
                <input type="hidden" name="matched_items[{{ $item->id }}]" value="{{ $item->photo_img }}">
            @endforeach

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Compare Image</button>
            </div>
        </form>
    </div>

    

</x-layout>
