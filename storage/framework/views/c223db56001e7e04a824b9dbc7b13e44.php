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

   
    <?php if(session()->has('success')): ?>
            <div class="container container--narrow">
                <div class="alert alert-success text-center">
                    <?php echo e(session('success')); ?>

                </div>
            </div>
            <?php endif; ?>
    <form action="/item/<?php echo e($item->id); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="upload-container">   
            <a class="float-left rounded mr-3" title="Go Back" href="/">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> Return
            </a>
            <br><br>
            <div class="d-flex justify-content-center">
                
                <!-- Middle column: Form Inputs -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="title" class="form-label">List Item Title:</label>
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
                        <input value="<?php echo e(old('title', $item->title)); ?>" required type="text" id="title" name="title" class="form-control" placeholder="Enter Title">
                   
                    </div>
    
                    <div class="mb-3">
                        <label for="lost_date" class="form-label">Date Lost:</label>
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
                        <input value="<?php echo e(old('date', $item->lost_date)); ?>" required type="date" id="lost_date" name="lost_date" class="form-control" placeholder="Enter date">
                        
                    </div>
        
                    <div class="mb-3">
                        <label for="category" class="form-label">Category:</label>
                        <select  id="category" name="category" class="form-control" value="">
                            <option selected><?php echo e($item->category); ?></option>
                            <option value="Bag" <?php echo e(old('category', $item->location) == 'Bag' ? 'selected' : ''); ?>>Bag</option>
                            <option value="Wallet" <?php echo e(old('category', $item->location) == 'Wallet' ? 'selected' : ''); ?>>Wallet</option>
                            <option value="Make Up" <?php echo e(old('category', $item->location) == 'Make Up' ? 'selected' : ''); ?>>Make Up</option>
                            <option value="Electronics" <?php echo e(old('category', $item->location) == 'Electronics' ? 'selected' : ''); ?>>Electronics</option>
                            <option value="Others" <?php echo e(old('category', $item->location) == 'Others' ? 'selected' : ''); ?>>Others</option>

                        </select>
                    </div>
        
                    <div class="mb-3">
                        <label for="category" class="form-label">Location:</label>
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
                            <option value="TSU San Isidro" <?php echo e(old('location', $item->location) == 'TSU San Isidro' ? 'selected' : ''); ?>>TSU San Isidro</option>
                            <option value="TSU Main" <?php echo e(old('location', $item->location) == 'TSU Main' ? 'selected' : ''); ?>>TSU Main</option>
                            <option value="TSU Lucinda" <?php echo e(old('location', $item->location) == 'TSU Lucinda' ? 'selected' : ''); ?>>TSU Lucinda</option>
                        </select>
                    </div>
                </div>
        
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view', $user)): ?>
                <!-- Right column: Additional Form Inputs -->
                <div class="col-md-5">

                    <div class="mb-3">
                        <label for="status" class="form-label">Status:</label>
                        <select id="status" name="status" class="form-control" required>
                            <option disabled <?php echo e(old('status', $item->status) ? '' : 'selected'); ?>>Select Status</option>
                            <option value="Claimed" <?php echo e(old('status', $item->status) == 'Claimed' ? 'selected' : ''); ?>>Claimed</option>
                            <option value="To Be Claimed" <?php echo e(old('status', $item->status) == 'To Be Claimed' ? 'selected' : ''); ?>>To Be Claimed</option>
                            <option value="Unclaimed" <?php echo e(old('status', $item->status) == 'Unclaimed' ? 'selected' : ''); ?>>Unclaimed</option>
                            <option value="Disposed" <?php echo e(old('status', $item->status) == 'Disposed' ? 'selected' : ''); ?>>Disposed</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="bin" class="form-label">Bin:</label>
                        <input type="text" id="bin" name="bin" class="form-control" value="<?php echo e(old('bin' , $item->bin)); ?>" placeholder="Enter bin">
                    </div>
        
                    <div class="mb-3">
                        <label for="issued_by" class="form-label">Issued By:</label>
                        <input type="text" id="issued_by" name="issued_by" value="<?php echo e(old('issued_by' , $item->issued_by)); ?>" class="form-control" placeholder="Enter issuer">
                    </div>
        
                    <div class="mb-3">
                        <label for="issued_date" class="form-label">Issued Date:</label>
                        <input type="date" id="issued_date" name="issued_date" class="form-control" value="<?php echo e(old('issued_date' , $item->issued_date)); ?>" placeholder="Enter issue date">
                    </div>
        
                    <div class="mb-3">
                        <label for="received_by" class="form-label">Received By:</label>
                        <input type="text" id="received_by" name="received_by" class="form-control" value="<?php echo e(old('received_by', $item->received_by)); ?>" placeholder="Enter receiver">
                    </div>
        
                    <div class="mb-3">
                        <label for="received_date" class="form-label">Receive Date:</label>
                        <input type="date" id="received_date" name="received_date" class="form-control" value="<?php echo e(old('received_date', $item->received_date)); ?>" placeholder="Enter receive date">
                    </div>
                </div>
                <?php endif; ?>
            </div>
        
            <!-- New row for Body Content -->
            
            <div class="mt-4">
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
                <textarea required name="markings" id="markings" class="body-content form-control" type="text" style="width:100%; height:200px;"><?php echo e($item->markings); ?></textarea>
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

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $attributes = $__attributesOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__attributesOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $component = $__componentOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__componentOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?><?php /**PATH /Users/rob/Desktop/TSU_SAM/resources/views/edit-item.blade.php ENDPATH**/ ?>