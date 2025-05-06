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
                        <input value="{{old('date', $item->lost_date)}}" required type="date" id="lost_date" name="lost_date" class="form-control" placeholder="Enter date">
                        
                    </div>
        
                    <div class="mb-3">
                        <label for="category" class="form-label">Category:</label>
                        <select  id="category" name="category" class="form-control" value="">
                            <option selected>{{$item->category}}</option>
                            <option value="Bag" {{ old('category', $item->location) == 'Bag' ? 'selected' : '' }}>Bag</option>
                            <option value="Wallet" {{ old('category', $item->location) == 'Wallet' ? 'selected' : '' }}>Wallet</option>
                            <option value="Make-up Essentials" {{ old('category', $item->location) == 'Make-up Essentials' ? 'selected' : '' }}>Make-up Essentials</option>
                            <option value="Electronic Devices" {{ old('category', $item->location) == 'Electronic Devices' ? 'selected' : '' }}>Electronic Devices</option>
                            <option value="Others" {{ old('category', $item->location) == 'Others' ? 'selected' : '' }}>Others</option>

                        </select>
                    </div>
        
                    <div class="mb-3">
                        <label for="category" class="form-label">Location:</label>
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
                        <input type="text" id="bin" name="bin" class="form-control" value="{{old('bin' , $item->bin)}}" placeholder="Enter bin">
                    </div>
        
                    <div class="mb-3">
                        <label for="issued_by" class="form-label">Issued By:</label>
                        <input type="text" id="issued_by" name="issued_by" value="{{old('issued_by' , $item->issued_by)}}" class="form-control" placeholder="Enter issuer">
                    </div>
        
                    <div class="mb-3">
                        <label for="issued_date" class="form-label">Issued Date:</label>
                        <input type="date" id="issued_date" name="issued_date" class="form-control" value="{{old('issued_date' , $item->issued_date)}}" placeholder="Enter issue date">
                    </div>
        
                    <div class="mb-3">
                        <label for="received_by" class="form-label">Received By:</label>
                        <input type="text" id="received_by" name="received_by" class="form-control" value="{{old('received_by', $item->received_by)}}" placeholder="Enter receiver">
                    </div>
        
                    <div class="mb-3">
                        <label for="received_date" class="form-label">Receive Date:</label>
                        <input type="date" id="received_date" name="received_date" class="form-control" value="{{old('received_date', $item->received_date)}}" placeholder="Enter receive date">
                    </div>
                </div>
                @endcan
            </div>
        
            <!-- New row for Body Content -->
            
            <div class="mt-4">
                @error('markings')
                <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
                @enderror
                <label for="markings" class="form-label">Markings / Indicators</label>
                <textarea required name="markings" id="markings" class="body-content form-control" type="text" style="width:100%; height:200px;">{{$item->markings}}</textarea>
            </div>
                 
            
           <!-- ✅ Center the button -->
           <div class="text-center">
            <button type="submit" class="upload-btn mt-3">Upload Changes</button>
        </div>
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

</x-layout>