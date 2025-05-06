<x-layout>
    <div class="container my-5">
        <h2 class="text-center mb-4">Detailed Comparison</h2>

        <div class="row justify-content-center text-center mb-4">
            <div class="col-md-5">
                <h5>Uploaded Image</h5>
                <img src="{{ $comparison['uploaded'] ?? '#' }}" alt="Uploaded" class="img-fluid rounded shadow" style="max-height: 300px;">
            </div>
            <div class="col-md-5">
                <h5>Matched Item Image</h5>
                <img src="{{ $comparison['matched'] ?? '#' }}" alt="Matched Item" class="img-fluid rounded shadow" style="max-height: 300px;">
            </div>
        </div>
        <div class="text-center mt-4">
            <h5>Result Summary</h5>
            <p><strong>SIFT Match Score:</strong> {{ $comparison['result']['sift_similarity'] ?? 'N/A' }}</p>
            <p><strong>LAB Similarity:</strong> {{ $comparison['result']['lab_similarity'] ?? 'N/A' }}</p>
            <p><strong>Final Score:</strong> {{ $comparison['result']['final_similarity_score'] ?? 'N/A' }}</p>
            <p><strong>Important:</strong> A screenshot must be taken prior to clicking the 'Claim' button. This will act as evidence and must be shown at the Dean's Office to validate your claim.</p>
        </div>

        @if (auth()->check())
        <div class="text-center mt-4">
            <form action="{{ route('item.claim', $item->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success pl-5 pr-5">Claim</button>
            </form>
        </div>
    @endif
    

    </div>
</x-layout>
