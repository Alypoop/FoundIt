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
    <div class="container py-md-5">
        <div class="row align-items-center">
          <div class="col-lg-7 py-3 py-md-5">
            <h1 class="display-3">Lost Something?</h1>
            <p class="lead text-muted">"Lost an item? We’ve got you covered! Whether it’s a misplaced gadget, accessory, or a personal belonging, we’re here to help you reconnect with what matters. Search, report, and get your lost items back in no time."</p>
          </div>
          <div class="col-lg-5 pl-lg-5 pb-3 py-lg-5">
            <form action="/register" method="POST" id="registration-form">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                  <label for="username-register" class="text-muted mb-1"><small>First Name</small></label>
                  <input value="<?php echo e(old('first_name')); ?>" name="first_name" id="first_name" class="form-control" type="text" placeholder="First Name" autocomplete="off" />
                </div>

                <div class="form-group">
                  <label for="username-register" class="text-muted mb-1"><small>Last Name</small></label>
                  <input value="<?php echo e(old('last_name')); ?>" name="last_name" id="last_name" class="form-control" type="text" placeholder="Last Name" autocomplete="off" />
                </div>

                <div class="form-group">
                    <label for="username-register" class="text-muted mb-1"><small>Username</small></label>
                    <input name="username" id="username" class="form-control" type="text" placeholder="Username" autocomplete="off" />
                    <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="m-0 small alert alert-danger shadow-sm"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
  
              <div class="form-group">
                    <label for="email-register" class="text-muted mb-1"><small>Email</small></label>
                    <input name="email" id="email" class="form-control" type="text" placeholder="you@example.com" autocomplete="off" />
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="m-0 small alert alert-danger shdawos-sm"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
  
              <div class="form-group">
                <label for="password-register" class="text-muted mb-1"><small>Password</small></label>
                <input name="password" id="password" class="form-control" type="password" placeholder="Create a password" />
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="m-0 small alert alert-danger shadow-sm"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
  
              <div class="form-group">
                <label for="password_confirmation" class="text-muted mb-1"><small>Confirm Password</small></label>
                <input name="password_confirmation" id="password_confirmation" class="form-control" type="password" placeholder="Confirm password" />
               
               </div>
  
              <button type="submit" class="py-3 mt-4 btn btn-lg btn-master btn-block">Sign Up</button>
            </form>
          </div>
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
<?php endif; ?><?php /**PATH /Users/rob/Desktop/TSU_SAM/resources/views/home.blade.php ENDPATH**/ ?>