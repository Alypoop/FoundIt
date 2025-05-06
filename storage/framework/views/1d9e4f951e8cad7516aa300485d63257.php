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
    <div class="container py-md-5 container--narrow">
            <?php if(session()->has('success')): ?>
            <div class="container container--narrow">
                <div class="alert alert-success text-center">
                    <?php echo e(session('success')); ?>

                </div>
            </div>
            <?php endif; ?>

            <?php if(session()->has('info')): ?>
            <div class="container container--narrow">
                <div class="alert alert-secondary text-center">
                    <?php echo e(session('info')); ?>

                </div>
            </div>
            <?php endif; ?>

            <?php $__errorArgs = ['profile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="alert small alert-danger shadow-sm"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        
            <div class="d-flex justify-content-between align-items-center">
                <a class="rounded" title="Go Back" href="/profile/<?php echo e(auth()->user()->username); ?>">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> Go back to Profile
                </a>
            
                <a class="rounded" title="Remove Profile Photo" href="/profile/password/<?php echo e(auth()->user()->id); ?>">
                  Change Password <i class="fa fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>

        <form action="/editing/<?php echo e($user->id); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
            <div class="upload-picture row justify-content-center">
                <label for="profile">
                    <img src="/storage/<?php echo e(auth()->user()->profile); ?>" style="border-radius:150px" alt="Upload Picture">
                </label>
                <input type="file" id="profile" name="profile" class="form-control" style="display: none;">
            </div>
            <div class="row justify-content-center">
                <p style="font-size:25px;"> <?php echo e($user->username); ?></p> 
             
            </div>
            <div class="row">
                <div class="col-md-6">
                    
                    <label for="first_name" class="form-label">First name:</label>
                    <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Enter First Name" value="<?php echo e($user->first_name); ?>">
                    <label for="last_name" class="form-label">Last name:</label>
                    <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Enter Last Name" value="<?php echo e($user->last_name); ?>">
                </div>
                <div class="col-md-6">
                    <label for="address" class="form-label">Address:</label>
                    <input type="text" id="address" name="address" class="form-control" placeholder="Enter Address" value="<?php echo e($user->address); ?>">
                    <label for="address" class="form-label">Phone:</label>
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter Phone Number" value="<?php echo e($user->phone); ?>">
                </div>
            </div>
            <div class="row justify-content-center">
                <button type="submit" class="upload-btn btn-master mt-3">Update Profile</button>
            </div>
        </form>
       
    </div>
   
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $attributes = $__attributesOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__attributesOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $component = $__componentOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__componentOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?><?php /**PATH C:\Users\alyza\FINAL_LNF\FINAL_LNF\resources\views/edit-profile.blade.php ENDPATH**/ ?>