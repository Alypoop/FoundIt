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

        <?php if(session()->has('success')): ?>
        <div class="container container--narrow">
        <div class="alert alert-success text-center">
            <?php echo e(session('success')); ?>

        </div>
        </div>
        <?php endif; ?>
        <div class="row">
          <a class="float-left rounded mr-3" title="Go Back" href="<?php echo e(url()->previous()); ?>">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp Return
        </a>
        </div>
        
        <div class="d-flex justify-content-between">
          <h2><?php echo e($item->title); ?></h2>      
          <span class="pt-2">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $item)): ?>
            <a href="/item/<?php echo e($item->id); ?>/edit" class="text-primary mr-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></a>
            
            <form class="delete-post-form d-inline" action="/item/<?php echo e($item->id); ?>" method="POST"
                onclick="checker('Are you sure you want to delete this user?');">
              <?php echo method_field('DELETE'); ?>
              <?php echo csrf_field(); ?>
              <button class="delete-post-button text-danger">
                <i class="fas fa-trash"></i></a> <!-- Delete Icon -->
              </button>
          </form>
          </span>
          <?php endif; ?>
        </div>
  
        <p class="text-muted small mb-4">
          <a href="#"><img class="avatar-tiny" src="/storage/<?php echo e($item->user->profile); ?>" /></a>
          Posted by <a href="<?php echo e(url('/profile/' . $item->user->username)); ?>"><?php echo e($item->user->first_name); ?> <?php echo e($item->user->last_name); ?></a> on <?php echo e($item->created_at->format('n/j/Y')); ?>

        </p>
  
        

        <div class="row">
            <div class="col-md-6">
                <p><strong>Lost Date:</strong> <?php echo e($item->lost_date); ?></p>
                <p><strong>Category:</strong> <?php echo e($item->category); ?></p>
                <p><strong>Location:</strong> <?php echo e($item->location); ?></p>
                <p><strong>Claimed By:</strong> <?php echo e($item->user->first_name); ?> <?php echo e($item->user->last_name); ?></p>  
                <strong>Posted by:</strong> <a href="<?php echo e(url('/profile/' . $item->user->username)); ?>"><?php echo e($item->user->username); ?></a>
               


            </div>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view', $user)): ?>
            <div class="col-md-6">
                <p><strong>Status:</strong> <?php echo e($item->status); ?></p>
                <p><strong>Bin:</strong> <?php echo e($item->bin); ?></p>
                <p><strong>Issued By:</strong> <?php echo e($item->issued_by); ?></p>
                <p><strong>Issued Date:</strong> <?php echo e($item->issued_date); ?></p>
                <p><strong>Received By: <?php echo e($item->received_by); ?></strong> </p>
                <p><strong>Received Date: <?php echo e($item->received_date); ?></strong> </p>
                
            </div>
            <?php endif; ?>
        </div>

        <div class="body-content">
            <p><strong>Markings:</strong> </p>
            <?php echo e($item->markings); ?>

        </div>

          <?php if($item->photo_img): ?>
            <div class="container d-flex justify-content-center align-items-center">
                <div class="text-center">
                    <p><strong>Item Image:</strong></p>
                    <img src="/storage/<?php echo e($item->photo_img); ?>" alt="Item Image" class="full-img">
                  </div>
            </div>
          <?php endif; ?>

    


      </div>

      <script>
        function checker()
        {
          var result = confirm('Are you sure you want to delete this Item?');
          if (result == false)
            {
              event.preventDefault();
            }
        }
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
<?php endif; ?><?php /**PATH /Users/rob/TSU_SAM/resources/views/single-item.blade.php ENDPATH**/ ?>