<x-layout>
    <div class="container my-5">
        @if ($errors->any())
            <div class="alert alert-danger text-center">
                @foreach ($errors->all() as $error)
                    <p class="m-0">{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <h1 class="text-center my-4">Search Items</h1>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="keyword" class="form-label">Search by Name/Markings</label>
                            <input type="text" id="keyword" name="keyword" class="form-control" 
                                   placeholder="e.g. 'hand bag', 'wallet'" 
                                   value="{{ request('keyword') }}">
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-3"><strong>Category</strong></h5>
                            @foreach ($categories as $category)
                            <div class="form-check mb-2">
                                <input class="form-check-input category-filter" type="checkbox" 
                                       name="category[]" value="{{ $category->id }}"
                                       id="category-{{ $category->id }}"
                                       {{ in_array($category->id, request()->input('category', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="category-{{ $category->id }}">
                                    {{ $category->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <div class="mb-4" id="itemTypeFilterContainer" style="display: none;">
                            <h5 class="mb-3"><strong>Item Type</strong></h5>
                            <div id="itemTypeFilters"></div>
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-3"><strong>Location</strong></h5>
                            @foreach ($locations as $loc)
                            <div class="form-check mb-2">
                                <input class="form-check-input location-filter" type="checkbox" 
                                       name="location[]" value="{{ $loc }}"
                                       id="location-{{ Str::slug($loc, '-') }}"
                                       {{ in_array($loc, request()->input('location', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="location-{{ Str::slug($loc, '-') }}">{{ $loc }}</label>
                            </div>
                            @endforeach
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-3"><strong>Image Search</strong></h5>
                            <form id="imageSearchForm" action="{{ route('items.image.compare') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="imageUpload" class="form-label">Upload image to compare</label>
                                    <input type="file" name="image" class="form-control" id="imageUpload" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Search by Image</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div id="searchResults">
                    @include('partials.search-results', ['items' => $items])
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function debounce(func, wait) {
        let timeout;
        return function() {
            const context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }

    function loadSearchResults() {
        const formData = new FormData();
        formData.append('keyword', document.getElementById('keyword').value);
        
        document.querySelectorAll('.category-filter:checked').forEach(el => 
            formData.append('category[]', el.value));
        document.querySelectorAll('.item-type-filter:checked').forEach(el => 
            formData.append('item_type[]', el.value));
        document.querySelectorAll('.location-filter:checked').forEach(el => 
            formData.append('location[]', el.value));

        fetch('{{ route("items.search") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('searchResults').innerHTML = data.html;
            updateImageSearchForm(data.items);
        })
        .catch(console.error);
    }

    function updateImageSearchForm(items) {
        const form = document.getElementById('imageSearchForm');
        form.querySelectorAll('input[name^="matched_items"], input[name^="filters"]').forEach(el => el.remove());
        
        items.forEach(item => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `matched_items[${item.id}]`;
            input.value = item.photo_img;
            form.appendChild(input);
        });

        const filters = {
            category: Array.from(document.querySelectorAll('.category-filter:checked')).map(el => el.value),
            item_type: Array.from(document.querySelectorAll('.item-type-filter:checked')).map(el => el.value),
            location: Array.from(document.querySelectorAll('.location-filter:checked')).map(el => el.value)
        };

        Object.entries(filters).forEach(([key, values]) => {
            values.forEach(value => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `filters[${key}][]`;
                input.value = value;
                form.appendChild(input);
            });
        });
    }

    function updateItemTypeFilters() {
    const selectedCategories = Array.from(document.querySelectorAll('.category-filter:checked')).map(el => el.value);
    
    if (!selectedCategories.length) {
        document.getElementById('itemTypeFilterContainer').style.display = 'none';
        return;
    }

    fetch('{{ route("items.item-types") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ 
            categories: selectedCategories 
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Received item types:', data); // Debug log
        const container = document.getElementById('itemTypeFilters');
        container.innerHTML = '';
        
        if (data.itemTypes && data.itemTypes.length) {
            document.getElementById('itemTypeFilterContainer').style.display = 'block';
            
            data.itemTypes.forEach(type => {
                const div = document.createElement('div');
                div.className = 'form-check mb-2';
                
                const input = document.createElement('input');
                input.className = 'form-check-input item-type-filter';
                input.type = 'checkbox';
                input.name = 'item_type[]';
                input.value = type.id;
                input.id = `item-type-${type.id}`;
                input.onchange = debounce(loadSearchResults, 300);
                
                const label = document.createElement('label');
                label.className = 'form-check-label';
                label.htmlFor = `item-type-${type.id}`;
                label.textContent = type.name;
                
                div.appendChild(input);
                div.appendChild(label);
                container.appendChild(div);
            });
        } else {
            document.getElementById('itemTypeFilterContainer').style.display = 'none';
        }
    })
    .catch(error => {
        console.error('Error fetching item types:', error);
        document.getElementById('itemTypeFilterContainer').style.display = 'none';
    });
}

    document.addEventListener('DOMContentLoaded', function() {
        const debouncedSearch = debounce(loadSearchResults, 300);
        document.getElementById('keyword').addEventListener('input', debouncedSearch);
        document.querySelectorAll('.category-filter, .location-filter').forEach(el => 
            el.addEventListener('change', debouncedSearch));
        document.querySelectorAll('.category-filter').forEach(el => 
            el.addEventListener('change', updateItemTypeFilters));
        
        document.getElementById('imageSearchForm').addEventListener('submit', function(e) {
            if (!document.getElementById('imageUpload').files.length) {
                e.preventDefault();
                alert('Please select an image first');
            }
        });

        if (document.querySelectorAll('.category-filter:checked').length) {
            updateItemTypeFilters();
        }
    });
</script>
</x-layout>