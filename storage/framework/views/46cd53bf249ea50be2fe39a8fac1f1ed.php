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

      <div class="row">
        <a class="float-left rounded mr-3" title="Go Back" href="/">
          <i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp Return to Home
      </a>
      
      </div>
      <div class="d-flex justify-content-between align-items-center">
        <h2>
          <img class="avatar-small" src="/storage/<?php echo e($profile); ?>" /><?php echo e($username); ?>

         <?php if(auth()->user()->username === $username): ?> 
         <a class="btn btn-sm btn-master mr-2" href="/edit-profile">Edit My Profile</a>
         <?php endif; ?>
        </h2>
      </div>
      
      
        <div class="profile-nav nav nav-tabs pt-2 mb-4">
          <a href="#" class="profile-nav-link nav-item nav-link active">Items: <?php echo e($postCount); ?></a>
        </div>
  
        <div class="list-group">
          <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <a href="/item/<?php echo e($item->id); ?>" class="list-group-item list-group-item-action">
            <img class="avatar-tiny" src="/storage/<?php echo e($profile); ?>" />
            <strong><?php echo e($item->title); ?></strong> on <?php echo e($item->created_at->format('n/j/Y')); ?>

          </a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         
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
<?php endif; ?><?php /**PATH /Users/rob/TSU_SAM/resources/views/profile-post.blade.php ENDPATH**/ ?>