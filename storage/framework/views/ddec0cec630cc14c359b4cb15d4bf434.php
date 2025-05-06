<?php if (isset($component)) { $__componentOriginal23a33f287873b564aaf305a1526eada4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23a33f287873b564aaf305a1526eada4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <link rel="stylesheet" href="/upload.css" />

   

    <form action="/post-item" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
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
                            <?php $__errorArgs = ['photo_img'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="m-0 small alert alert-danger shadow-sm">Photo is required</p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>    
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
                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="m-0 small alert alert-danger shadow-sm"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <input value="<?php echo e(old('title')); ?>" required type="text" id="title" name="title" class="form-control" placeholder="Enter Title">
                   
                    </div>
    
                    <div class="mb-3">
                        <label for="lost_date" class="form-label">Date Found:</label>
                         <?php $__errorArgs = ['lost_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="m-0 small alert alert-danger shadow-sm"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <input value="<?php echo e(old('lost_date')); ?>" required type="date" id="lost_date" name="lost_date" class="form-control" placeholder="Enter date">
                        
                    </div>
        
                    <div class="mb-3">
                        <label for="category" class="form-label">Category:</label>
                        <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="m-0 small alert alert-danger shadow-sm"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <select  id="category" name="category" class="form-control">
                            <option>Select category</option>
                            <option>Bag</option>
                            <option>Wallet</option>
                            <option>Make-up Essentials</option>
                            <option>Electronic Devices</option>
                            <option>Others</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="category" class="form-label">Location found:</label>
                        <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="m-0 small alert alert-danger shadow-sm"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <select name="location" class="form-control" required>
                            <option value="">Select location</option>
                            <option value="TSU San Isidro" <?php echo e(old('location') == 'TSU San Isidro' ? 'selected' : ''); ?>>TSU San Isidro</option>
                            <option value="TSU Main" <?php echo e(old('location') == 'TSU Main' ? 'selected' : ''); ?>>TSU Main</option>
                            <option value="TSU Lucinda" <?php echo e(old('location') == 'TSU Lucinda' ? 'selected' : ''); ?>>TSU Lucinda</option>
                        </select>
                    </div>
        
                </div>
        
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view', $user)): ?>
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
                <?php endif; ?>
            </div>
        
            <!-- New row for Body Content -->
            <div class="row g-3">
                <div class="col-md-8 offset-md-4">
                    <div class="mb-3">
                        <?php $__errorArgs = ['markings'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="m-0 small alert alert-danger shadow-sm"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <label for="markings" class="form-label">Markings / Indicators</label>
                        <textarea placeholder="Describe any identifying marks or features that make the item unique" value="<?php echo e(old('markings')); ?>" required name="markings" id="markings" class="body-content form-control" type="text" style="width:500px; height:200px;"><?php echo e(old('markings')); ?></textarea>
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


 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $attributes = $__attributesOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__attributesOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $component = $__componentOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__componentOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?><?php /**PATH C:\Users\alyza\FINAL_LNF\FINAL_LNF\resources\views/post-item.blade.php ENDPATH**/ ?>