<x-layout>
    <div class="container text-center">
        <h2>Compare with Item: {{ $item->title }}</h2>

        <!-- Display the item image -->
        @if ($item->photo_img)
            <p><strong>Item Image:</strong></p>
            <img src="{{ asset('storage/' . $item->photo_img) }}" alt="Item Image" class="img-fluid" style="max-width: 100%; height: auto;">
        @else
            <p>No image available for this item.</p>
        @endif

        <!-- Form to upload a comparison image -->
        <form action="{{ url('/compare/' . $item->id) }}" method="POST" enctype="multipart/form-data" class="mt-4 mb-3">
            @csrf
            <div class="form-group">
                <label for="compare_img"><strong>Upload Image to Compare:</strong></label><br>
                <input type="file" name="compare_img" required class="form-control-file my-3">
            </div>
            <button type="submit" class="btn btn-primary">Compare</button>
        </form>

        <!-- Error Message -->
        @if (session('error'))
            <div class="alert alert-danger mt-3">
                {{ session('error') }}
            </div>
        @endif
    </div>
</x-layout>
