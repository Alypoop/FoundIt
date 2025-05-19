<x-layout>
    <link rel="stylesheet" href="/upload.css" />

   

    <form action="/post-item" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="upload-container">   
            <a class="justify-content-center rounded mr-5" title="Go Back" href="/">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> Go back to Home
            </a>
            <br><br>
            <div class="row g-3">
                <!-- Left side: Upload Picture -->
                <div class="col-md-4">
                    <div class="upload-picture">
                        <label for="photo_img">
                            @error('photo_img')
                            <p class="m-0 small alert alert-danger shadow-sm">Photo is required</p>
                            @enderror    
                            <img src="https://img.icons8.com/ios-filled/50/ffffff/camera--v1.png" alt="Upload Picture">
                            <p>Upload Picture</p>
                        </label>
                        <input type="file" id="photo_img" name="photo_img" class="form-control" style="display: none;">
                        <p id="file-name" style="margin-top: 10px; font-size: 0.9em; color: #555;"></p> <!-- File name display -->
                    </div>
                </div>
                
                <!-- Middle column: Form Inputs -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="title" class="form-label">Item Title:</label>
                        @error('title')
                        <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                        @enderror
                        <input value="{{old('title')}}" required type="text" id="title" name="title" class="form-control" placeholder="Enter Title">
                   
                    </div>
    
                    <div class="mb-3">
                        <label for="lost_date" class="form-label">Date Found:</label>
                         @error('lost_date')
                        <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                        @enderror
                        <input value="{{old('lost_date')}}" required type="date" id="lost_date" name="lost_date" class="form-control" placeholder="Enter date">
                        
                    </div>
        
                    <div class="mb-3">
                        <label for="category" class="form-label">Category:</label>
                        @error('category')
                        <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                        @enderror
                        <select id="category" name="category_id" class="form-control" required>
                            <option value="">Select category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                            <option value="">Select category first</option>
                            @if(old('category_id'))
                                @foreach(ItemType::where('category_id', old('category_id'))->get() as $itemType)
                                    <option value="{{ $itemType->id }}" {{ old('item_type_id') == $itemType->id ? 'selected' : '' }}>
                                        {{ $itemType->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="category" class="form-label">Location found:</label>
                        @error('location')
                        <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                        @enderror
                        <select name="location" class="form-control" required>
                            <option value="">Select location</option>
                            <option value="TSU San Isidro" {{ old('location') == 'TSU San Isidro' ? 'selected' : '' }}>TSU San Isidro</option>
                            <option value="TSU Main" {{ old('location') == 'TSU Main' ? 'selected' : '' }}>TSU Main</option>
                            <option value="TSU Lucinda" {{ old('location') == 'TSU Lucinda' ? 'selected' : '' }}>TSU Lucinda</option>
                        </select>
                    </div>
        
                </div>
        
                @can('view', $user)
                <!-- Right column: Additional Form Inputs -->
                <div class="col-md-4">

                    <div class="mb-3">
                        <label for="status" class="form-label">Status:</label>
                        <select id="status" name="status" class="form-control">
                            <option selected disabled >Select Status</option>
                            <option>Claimed</option>
                            <option>To Be Claimed</option>
                            <option>Unclaimed</option>
                            <option>Disposed</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="bin" class="form-label">Storage Bin:</label>
                        <input type="text" id="bin" name="bin" class="form-control" placeholder="Enter bin">
                    </div>
        
                    <div class="mb-3">
                        <label for="issuedBy" class="form-label">Issued By:</label>
                        <input type="text" id="issuedBy" name="issuedBy" class="form-control" placeholder="Enter issuer">
                    </div>
        
                    <div class="mb-3">
                        <label for="issued_date" class="form-label">Issued Date:</label>
                        <input type="date" id="issued_date" name="issued_date" class="form-control" placeholder="Enter issue date">
                    </div>
        
                    <div class="mb-3">
                        <label for="received_by" class="form-label">Received By:</label>
                        <input type="text" id="received_by" name="received_by" class="form-control" placeholder="Enter receiver">
                    </div>
        
                    <div class="mb-3">
                        <label for="received_date" class="form-label">Receive Date:</label>
                        <input type="date" id="received_date" name="received_date" class="form-control" placeholder="Enter receive date">
                    </div>
                </div>
                @endcan
            </div>
        
            <!-- New row for Body Content -->
            <div class="row g-3">
                <div class="col-md-8 offset-md-4">
                    <div class="mb-3">
                        @error('markings')
                        <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                        @enderror
                        <label for="markings" class="form-label">Markings / Indicators</label>
                        <textarea placeholder="Describe any identifying marks or features that make the item unique" value="{{old('markings')}}" required name="markings" id="markings" class="body-content form-control" type="text" style="width:500px; height:200px;">{{old('markings')}}</textarea>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="upload-btn mt-3">Upload</button>
        </div>
    </form>
    
    <script>
        // Get today's date in YYYY-MM-DD format
        const today = new Date().toISOString().split('T')[0];
        
        // Set the max attribute to today for both date inputs
        document.getElementById('issued_date').setAttribute('max', today);
        document.getElementById('received_date').setAttribute('max', today);
        document.getElementById('lost_date').setAttribute('max', today);
    </script>

    <script>
        // Existing date-related code...

        // File input name display
        document.getElementById('photo_img').addEventListener('change', function(){
            const fileName = this.files[0] ? this.files[0].name : '';
            document.getElementById('file-name').textContent = fileName;
        });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('category');
        const itemTypeSelect = document.getElementById('item_type');

        // Handle category change
        categorySelect.addEventListener('change', function() {
            const categoryId = this.value;
            
            // Reset item type select
            itemTypeSelect.innerHTML = '<option value="">Loading...</option>';
            itemTypeSelect.disabled = true;

            if (!categoryId) {
                itemTypeSelect.innerHTML = '<option value="">Select category first</option>';
                itemTypeSelect.disabled = true;
                return;
            }

            // Fetch item types
            fetch(`/get-item-types?category_id=${categoryId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    itemTypeSelect.innerHTML = '<option value="">Select item type</option>';
                    
                    if (data.length === 0) {
                        itemTypeSelect.innerHTML += '<option value="">No item types found</option>';
                    } else {
                        data.forEach(itemType => {
                            itemTypeSelect.innerHTML += `
                                <option value="${itemType.id}">${itemType.name}</option>
                            `;
                        });
                    }
                    
                    itemTypeSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error fetching item types:', error);
                    itemTypeSelect.innerHTML = '<option value="">Error loading types</option>';
                });
        });

        // If editing and category is already selected, load its item types
        @if(old('category_id'))
            // Trigger change event to load item types
            categorySelect.dispatchEvent(new Event('change'));
            
            // After a short delay, set the selected item type
            setTimeout(() => {
                document.getElementById('item_type').value = "{{ old('item_type_id') }}";
            }, 500);
        @endif
    });
    </script>


</x-layout>