<x-layout>
    <div class="container my-5">
        <h2 class="text-center mb-4">Comparison Results</h2>

        @if ($errors->any())
            <div class="alert alert-danger text-center mt-4">
                @foreach ($errors->all() as $error)
                    <p class="m-0">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if($items->isEmpty())
            <div class="alert alert-info text-center">
                No matching items found with similarity score above 60%
            </div>
        @else
            <div class="row justify-content-center">
                @foreach($items as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="{{ asset('storage/' . $item->photo_img) }}" class="card-img-top" alt="{{ $item->title }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('items.compare.view', ['id' => $item->id]) }}">
                                        {{ $item->title }}
                                    </a>
                                </h5>
                                <p class="card-text">
                                    <strong>Author:</strong> {{ $item->user->username }}<br>
                                    <strong>Found Date:</strong> {{ $item->lost_date }}<br>
                                    <strong>Category:</strong> {{ $item->category->name }}<br>
                                    <strong>Item Type:</strong> {{ $item->itemType->name }}<br>
                                    <strong>Location:</strong> {{ $item->location }}<br>
                                    <strong>Markings:</strong> {{ $item->markings }}<br>
                                    <strong>Status:</strong> {{ $item->status }}<br>
                                </p>

                                @if (isset($results[$item->id]['error']))
                                    <p class="text-danger">Comparison failed: {{ $results[$item->id]['error'] }}</p>
                                @elseif (isset($results[$item->id]))
                                    <div class="similarity-results mt-3 p-3 bg-light rounded">
                                        <h6>Similarity Results:</h6>
                                        <p class="mb-1"><strong>SIFT:</strong> {{ $results[$item->id]['sift_similarity'] ?? 'N/A' }}%</p>
                                        <p class="mb-1"><strong>LAB:</strong> {{ $results[$item->id]['lab_similarity'] ?? 'N/A' }}%</p>
                                        <p class="mb-0"><strong>Final Score:</strong> 
                                            <span class="fw-bold {{ $results[$item->id]['final_similarity_score'] >= 75 ? 'text-success' : ($results[$item->id]['final_similarity_score'] >= 60 ? 'text-warning' : 'text-danger') }}">
                                                {{ $results[$item->id]['final_similarity_score'] ?? 'N/A' }}%
                                            </span>
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if ($relatedItems->isNotEmpty())
            <hr class="my-5">
            <h4 class="text-center mb-4">Other Items of Type: {{ $topItemType }}</h4>
            <div class="row justify-content-center">
                @foreach ($relatedItems as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="{{ asset('storage/' . $item->photo_img) }}" class="card-img-top" alt="{{ $item->title }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('items.compare.view', ['id' => $item->id]) }}">
                                        {{ $item->title }}
                                    </a>
                                </h5>
                                <p class="card-text">
                                    <strong>Author:</strong> {{ $item->user->username }}<br>
                                    <strong>Found Date:</strong> {{ $item->lost_date }}<br>
                                    <strong>Category:</strong> {{ $item->category->name }}<br>
                                    <strong>Item Type:</strong> {{ $item->itemType->name }}<br>
                                    <strong>Location:</strong> {{ $item->location }}<br>
                                    <strong>Markings:</strong> {{ $item->markings }}<br>
                                    <strong>Status:</strong> {{ $item->status }}<br>
                                </p>
                                @if (isset($results[$item->id]))
                                    <div class="similarity-results mt-3 p-3 bg-light rounded">
                                        <h6>Similarity Results:</h6>
                                        <p class="mb-1"><strong>SIFT:</strong> {{ $results[$item->id]['sift_similarity'] ?? 'N/A' }}%</p>
                                        <p class="mb-1"><strong>LAB:</strong> {{ $results[$item->id]['lab_similarity'] ?? 'N/A' }}%</p>
                                        <p class="mb-0"><strong>Final Score:</strong> 
                                            <span class="fw-bold {{ $results[$item->id]['final_similarity_score'] >= 75 ? 'text-success' : ($results[$item->id]['final_similarity_score'] >= 60 ? 'text-warning' : 'text-danger') }}">
                                                {{ $results[$item->id]['final_similarity_score'] ?? 'N/A' }}%
                                            </span>
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if (!empty($appliedFilters))
            <hr class="my-5">
            <h4 class="text-center mb-4">Applied Filters</h4>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            @if (!empty($appliedFilters['category']))
                                <p><strong>Categories:</strong> 
                                    {{ implode(', ', array_map(function($id) {
                                        return \App\Models\Category::find($id)->name;
                                    }, $appliedFilters['category'])) }}
                                </p>
                            @endif
                            @if (!empty($appliedFilters['item_type']))
                                <p><strong>Item Types:</strong> 
                                    {{ implode(', ', array_map(function($id) {
                                        return \App\Models\ItemType::find($id)->name;
                                    }, $appliedFilters['item_type'])) }}
                                </p>
                            @endif
                            @if (!empty($appliedFilters['location']))
                                <p><strong>Locations:</strong> {{ implode(', ', $appliedFilters['location']) }}</p>
                            @endif
                        </div>
                    </div>

                    <h5 class="text-center mb-4">All Filtered Items</h5>
                    <div class="row">
                        @foreach($filteredItems as $item)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <img src="{{ asset('storage/' . $item->photo_img) }}" class="card-img-top" alt="{{ $item->title }}" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                          <a href="{{ route('items.compare.view', ['id' => $item->id]) }}">
                                                {{ $item->title }}
                                            </a>
                                        </h5>
                                        <p class="card-text">
                                            <strong>Item Type:</strong> {{ $item->itemType->name }}<br>
                                            <strong>Category:</strong> {{ $item->category->name }}<br>
                                            <strong>Location:</strong> {{ $item->location }}
                                        </p>
                                        @if(isset($results[$item->id]))
                                            <div class="similarity-results mt-3 p-3 bg-light rounded">
                                                <h6>Similarity Results:</h6>
                                                <p class="mb-1"><strong>SIFT:</strong> {{ $results[$item->id]['sift_similarity'] ?? 'N/A' }}%</p>
                                                <p class="mb-1"><strong>LAB:</strong> {{ $results[$item->id]['lab_similarity'] ?? 'N/A' }}%</p>
                                                <p class="mb-0"><strong>Final Score:</strong> 
                                                    <span class="fw-bold {{ $results[$item->id]['final_similarity_score'] >= 75 ? 'text-success' : ($results[$item->id]['final_similarity_score'] >= 60 ? 'text-warning' : 'text-danger') }}">
                                                        {{ $results[$item->id]['final_similarity_score'] ?? 'N/A' }}%
                                                    </span>
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layout>