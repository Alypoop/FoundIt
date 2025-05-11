<x-layout>

    <div class="container my-5">
        <h2 class="text-center mb-4">Comparison Results</h2>

        @if ($errors->any())
            <div class="alert alert-danger text-center mt-4">
                {{ $errors->first('image') }}
            </div>
        @endif

        <div class="row justify-content-center">

            @foreach ($items as $item)

            @if ($errors->any())
                <div class="alert alert-danger text-center">
                    @foreach ($errors->all() as $error)
                        <p class="m-0">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

                <div class="card m-2" style="width: 18rem;">
                    <img src="{{ session("comparison_{$item->id}.matched") }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('items.compare.view', ['id' => $item->id]) }}">
                                <h5 class="card-title">{{ $item->title }}</h5>
                            </a>

                          </h5>
                                                  <p class="card-text">
                            <strong>Author:</strong> {{ $item->user->username }}<br>
                            <strong>Found Date:</strong> {{ $item->lost_date }}<br>
                            <strong>Category:</strong> {{ $item->category }}<br>
                            <strong>Location:</strong> {{ $item->location }}<br>
                            <strong>Markings:</strong> {{ $item->markings }}<br>
                            <strong>Status:</strong> {{ $item->status }}<br>

                        </p>

                        @if (isset($results[$item->id]['error']))
                            <p class="text-danger">Comparison failed: {{ $results[$item->id]['error'] }}</p>
                        @elseif (isset($results[$item->id]))
                        <p class="text-success mb-0">
                            <strong>SIFT Similarity:</strong> {{ $results[$item->id]['sift_similarity'] ?? 'N/A' }}%<br>
                            <strong>LAB Similarity:</strong> {{ $results[$item->id]['lab_similarity'] ?? 'N/A' }}%<br>
                            <strong>Final Similarity Score:</strong> {{ $results[$item->id]['final_similarity_score'] ?? 'N/A' }}%
                        </p>
                        @endif
                    </div>
                </div>
            @endforeach


        </div>
    </div>

</x-layout>
