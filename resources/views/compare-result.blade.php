<x-layout>
    <div class="container text-center">
        <h2>Comparison Results for {{ $item->title }}</h2>

        @if ($result)
            <p><strong>SIFT Similarity:</strong> {{ $result['sift_similarity'] ?? 'N/A' }}%</p>

            @if (isset($result['lab_similarity']))
                <p><strong>LAB Color Similarity:</strong> {{ $result['lab_similarity'] }}%</p>
            @endif

            <p><strong>Final Similarity Score:</strong> {{ $result['final_similarity_score'] ?? 'N/A' }}%</p>

            {{-- @if (isset($result['good_matches']))
                <p><strong>Good Matches:</strong> {{ $result['good_matches'] }}</p>
            @endif --}}

            @if (isset($result['match_image_url']))
            <div class="mt-4">
                <h4>Matched Keypoints</h4>
                <img src="http://127.0.0.1:5050{{ $result['match_image_url'] }}"
                alt="Matched Keypoints"
                class="img-fluid"
                style="max-width: 100%;">


            </div>
        @endif
        @else
            <p>No comparison result available.</p>
        @endif

        <a href="{{ url('/compare/' . $item->id) }}" class="btn btn-secondary mt-3 mb-3">Compare Another Image</a>
    </div>
</x-layout>
