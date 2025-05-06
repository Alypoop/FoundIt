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
    <link rel="stylesheet" href="/register.css">

    
    <div class="container">
       
        <h1>Change Password</h1>
        <div class="registration-box">
                  
                <form action="/user/updatepass/<?php echo e($user->id); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <!-- Display error message for old_password -->
                    <?php if($errors->has('old_password')): ?>
                    <div class="m-0 small alert alert-danger shadow-sm"><?php echo e($errors->first('old_password')); ?></div>
                    <?php endif; ?>

                    <label for="old_password">Old Password:</label>
                    <input type="password" name="old_password" required>
                
                    <?php if($errors->has('new_password_confirmation')): ?>
                    <div class="error"><?php echo e($errors->first('new_password_confirmation')); ?></div>
                    <?php endif; ?>

                    <label for="new_password">New Password:</label>
                    <input type="password" name="new_password" required>
                
                    <label for="new_password_confirmation">Confirm New Password:</label>
                    <input type="password" name="new_password_confirmation" required>
                
                    <button class="btn btn-primary" type="submit">Save Changes</button>
                    <p style="font-size:15px; display:inline-block;"><small><strong><a href="/users" class="primary">&laquo Return to Users</a></strong></small></p>
                </form>

            
        </div>
        
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
<?php endif; ?><?php /**PATH C:\Users\alyza\FINAL_LNF\FINAL_LNF\resources\views/edit-password.blade.php ENDPATH**/ ?>