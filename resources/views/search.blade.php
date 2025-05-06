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

        <form id="searchForm" action="{{ route('items.search') }}" method="GET" class="container">

            {{-- 🔍 Search Bar --}}
            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    <input type="text" name="keyword" class="form-control" placeholder="Search by title and markings" value="{{ request('keyword') }}">
                </div>
            </div>


            {{-- First Row --}}
            @php
            $categories = [
            'Bag' => 'Bag',
            'Wallet' => 'Wallet',
            'Make-up Essentials'=>'Make-up Essentials',
            'Electronic Devices' => 'Electronic Devices',
            'Others' => 'Others'
            ];
            @endphp

            <h5 class="text-center mt-4"><strong>Category</strong></h5>
            <div class="d-flex justify-content-center gap-4 mb-3 flex-wrap">
                @foreach ($categories as $value => $label)
                <div class="form-check mr-3 border rounded px-5 py-3">
                    <input class="form-check-input" type="checkbox" name="category[]" value="{{ $label }}"
                        onclick="onlyOneCheckbox('category', this)"
                        id="category-{{ $value }}"
                        {{ in_array($label, request()->input('category', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="category-{{ $value }}">{{ $label }}</label>
                </div>
                @endforeach
            </div>

            {{-- Second Row --}}
            @php
            $locations = [
            'TSU San Isidro',
            'TSU Main',
            'TSU Lucinda'
            ];
            @endphp

            <h5 class="text-center mt-4"><strong>Location</strong></h5>
            <div class="d-flex justify-content-center gap-4 mb-3 flex-wrap">
            @foreach ($locations as $loc)
                <div class="form-check mr-3 border rounded px-5 py-3">
                    <input class="form-check-input" type="checkbox" name="location[]" value="{{ $loc }}"
                    onclick="onlyOneCheckbox('location', this)"
                    id="location-{{ Str::slug($loc, '-') }}"
                    {{ in_array($loc, request()->input('location', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="location-{{ Str::slug($loc, '-') }}">{{ $loc }}</label>
                </div>
            @endforeach 
            </div>


            <div class="text-center">
                <button type="submit" class="btn btn-primary px-4">Search</button>
            </div>
        </form>

        @if ($items->count())
        <form id="imageSearchForm" action="{{ route('items.image.compare') }}" method="POST" enctype="multipart/form-data" class="d-none">
            @csrf
            <div class="text-center mt-3">
                <input type="file" name="image" class="form-control mb-2" required>
                @foreach ($items as $item)
                    <input type="hidden" name="matched_items[{{ $item->id }}]" value="{{ $item->photo_img }}">
                @endforeach
                <button type="submit" class="btn btn-primary">Image Search</button>
            </div>
        </form>
    @endif
    



        @if ($items->count())
        <div class="container mt-4">
            <div class="row justify-content-center">
                @foreach ($items as $item)
                    <div class="col-md-4 mb-4 d-flex justify-content-center">
                        <div class="card" style="width: 18rem;">                
                            <div class="card-body">
                                <a href="/item/{{ $item->id }}"><h5 class="card-title">{{ $item->title }}</h5></a>
                                <p class="card-text">
                                    <strong>Author:</strong> 
                                    <img class="avatar-tiny" src="/storage/{{ $item->user->profile ?? 'profile/default.jpg' }}" />
                                    {{ $item->user->username }}<br>
                                    <strong>Found Date:</strong> {{ $item->lost_date }}<br>
                                    <strong>Category:</strong> {{ $item->category }}<br>
                                    <strong>Location:</strong> {{ $item->location }}
                                </p>
                                <p><textarea readonly class="form-control mb-2" rows="3" readonly style="height: 50px; width: 100%; overflow-y: auto; background-color: #e2e8f0; border: none; resize: none; padding: 5px; border-radius: 5px;">{{ $item->markings }}</textarea></p>
                                @if ($item->photo_img)
                                    <img src="/storage/{{ $item->photo_img }}" alt="Item image" class="img-fluid">
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center mt-4">
            <p>No items matched your search.</p>
        </div>
    @endif

   



    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("searchForm");
            const checkboxes = form.querySelectorAll("input[type='checkbox']");
            const imageSearchForm = document.getElementById("imageSearchForm");
    
            function toggleImageSearchForm() {
                const isAnyChecked = Array.from(checkboxes).some(cb => cb.checked);
                const hasResults = {{ $items->count() > 0 ? 'true' : 'false' }};
    
                if (isAnyChecked && hasResults) {
                    imageSearchForm.classList.remove("d-none");
                } else {
                    imageSearchForm.classList.add("d-none");
                }
            }
    
            toggleImageSearchForm(); // on page load
    
            checkboxes.forEach(cb => cb.addEventListener("change", toggleImageSearchForm));
        });
    </script>

    <script>
        function onlyOneCheckbox(groupName, clicked) {
        const checkboxes = document.querySelectorAll(`input[name="${groupName}[]"]`);

        checkboxes.forEach(cb => {
            if (cb !== clicked) cb.checked = false;
        });
    }
    </script>
    
</x-layout>