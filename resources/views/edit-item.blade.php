<x-layout>
    <link rel="stylesheet" href="/upload.css" />

    @if (session()->has('success'))
        <div class="container container--narrow">
            <div class="alert alert-success text-center">
                {{session('success')}}
            </div>
        </div>
    @endif
    
    <form action="/item/{{$item->id}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="upload-container">   
            <a class="float-left rounded mr-3" title="Go Back" href="/">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> Return
            </a>
            <br><br>
            <div class="d-flex justify-content-center">
                
                <!-- Middle column: Form Inputs -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="title" class="form-label">Item Title:</label>
                        @error('title')
                        <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                        @enderror
                        <input value="{{old('title', $item->title)}}" required type="text" id="title" name="title" class="form-control" placeholder="Enter Title">
                    </div>
    
                    <div class="mb-3">
                        <label for="lost_date" class="form-label">Date Found:</label>
                        @error('lost_date')
                        <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                        @enderror
                        <input value="{{old('lost_date', $item->lost_date->format('Y-m-d'))}}" required type="date" id="lost_date" name="lost_date" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Category:</label>
                        @error('category_id')
                        <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                        @enderror
                        <select id="category" name="category_id" class="form-control" required>
                            <option value="">Select category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="item_type" class="form-label">Item Type:</label>
                        @error('item_type_id')
                        <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                        @enderror
                        <select id="item_type" name="item_type_id" class="form-control" required>
                            <option value="">Select item type</option>
                            @if(old('category_id', $item->category_id))
                                @foreach(App\Models\ItemType::where('category_id', old('category_id', $item->category_id))->get() as $itemType)
                                    <option value="{{ $itemType->id }}" 
                                        {{ old('item_type_id', $item->item_type_id) == $itemType->id ? 'selected' : '' }}>
                                        {{ $itemType->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
        
                    <div class="mb-3">
                        <label for="location" class="form-label">Location:</label>
                        @error('location')
                        <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                        @enderror
                        <select name="location" class="form-control" required>
                            <option value="">Select location</option>
                            <option value="TSU San Isidro" {{ old('location', $item->location) == 'TSU San Isidro' ? 'selected' : '' }}>TSU San Isidro</option>
                            <option value="TSU Main" {{ old('location', $item->location) == 'TSU Main' ? 'selected' : '' }}>TSU Main</option>
                            <option value="TSU Lucinda" {{ old('location', $item->location) == 'TSU Lucinda' ? 'selected' : '' }}>TSU Lucinda</option>
                        </select>
                    </div>
                </div>
        
                @can('view', $user)
                <!-- Right column: Additional Form Inputs -->
                <div class="col-md-5">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status:</label>
                        <select id="status" name="status" class="form-control" required>
                            <option disabled {{ old('status', $item->status) ? '' : 'selected' }}>Select Status</option>
                            <option value="Claimed" {{ old('status', $item->status) == 'Claimed' ? 'selected' : '' }}>Claimed</option>
                            <option value="To Be Claimed" {{ old('status', $item->status) == 'To Be Claimed' ? 'selected' : '' }}>To Be Claimed</option>
                            <option value="Unclaimed" {{ old('status', $item->status) == 'Unclaimed' ? 'selected' : '' }}>Unclaimed</option>
                            <option value="Disposed" {{ old('status', $item->status) == 'Disposed' ? 'selected' : '' }}>Disposed</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="bin" class="form-label">Storage Bin:</label>
                        <input type="text" id="bin" name="bin" class="form-control" value="{{old('bin', $item->bin)}}" placeholder="Enter bin">
                    </div>
        
                    <div class="mb-3">
                        <label for="issued_by" class="form-label">Issued By:</label>
                        <input type="text" id="issued_by" name="issued_by" value="{{old('issued_by', $item->issued_by)}}" class="form-control" placeholder="Enter issuer">
                    </div>
        
                    <div class="mb-3">
                        <label for="issued_date" class="form-label">Issued Date:</label>
                        <input type="date" id="issued_date" name="issued_date" class="form-control" value="{{old('issued_date', $item->issued_date ? $item->issued_date->format('Y-m-d') : '')}}">
                    </div>
        
                    <div class="mb-3">
                        <label for="received_by" class="form-label">Received By:</label>
                        <input type="text" id="received_by" name="received_by" class="form-control" value="{{old('received_by', $item->received_by)}}" placeholder="Enter receiver">
                    </div>
        
                    <div class="mb-3">
                        <label for="received_date" class="form-label">Receive Date:</label>
                        <input type="date" id="received_date" name="received_date" class="form-control" value="{{old('received_date', $item->received_date ? $item->received_date->format('Y-m-d') : '')}}">
                    </div>
                </div>
                @endcan
            </div>
        
            <!-- Markings Textarea -->
            <div class="mt-4">
                @error('markings')
                <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                @enderror
                <label for="markings" class="form-label">Markings / Indicators</label>
                <textarea required name="markings" id="markings" class="body-content form-control" style="width:100%; height:200px;">{{old('markings', $item->markings)}}</textarea>
            </div>
                 
            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="upload-btn mt-3">Update Item</button>
            </div>
        </div>
    </form>
    
    <script>
        // Date restrictions
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('issued_date').setAttribute('max', today);
            document.getElementById('received_date').setAttribute('max', today);
            document.getElementById('lost_date').setAttribute('max', today);

            // Dynamic item type loading
            const categorySelect = document.getElementById('category');
            const itemTypeSelect = document.getElementById('item_type');

            categorySelect.addEventListener('change', function() {
                const categoryId = this.value;
                
                itemTypeSelect.innerHTML = '<option value="">Loading...</option>';
                itemTypeSelect.disabled = true;

                if (!categoryId) {
                    itemTypeSelect.innerHTML = '<option value="">Select category first</option>';
                    return;
                }

                fetch(`/get-item-types?category_id=${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        itemTypeSelect.innerHTML = '<option value="">Select item type</option>';
                        data.forEach(itemType => {
                            itemTypeSelect.innerHTML += `
                                <option value="${itemType.id}">${itemType.name}</option>
                            `;
                        });
                        itemTypeSelect.disabled = false;
                        
                        // Set previously selected item type if available
                        @if(old('item_type_id', $item->item_type_id))
                            const oldItemTypeId = "{{ old('item_type_id', $item->item_type_id) }}";
                            if (oldItemTypeId) {
                                itemTypeSelect.value = oldItemTypeId;
                            }
                        @endif
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        itemTypeSelect.innerHTML = '<option value="">Error loading types</option>';
                    });
            });

            // Trigger change if category is already selected
            @if(old('category_id', $item->category_id))
                categorySelect.dispatchEvent(new Event('change'));
            @endif
        });
    </script>
</x-layout>