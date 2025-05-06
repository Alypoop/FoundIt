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
      <div class="text-center">
        <?php if(session()->has('success')): ?>
        <div class="alert alert-success text-center">
            <?php echo e(session('success')); ?>

        </div>    
        <?php endif; ?>
        <h2>Welcome <strong><?php echo e(auth()->user()->first_name); ?></strong></h2>
      </div>
    </div>
  
    <div class="container">
      <div class="row justify-content-center">
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex align-items-stretch">
            <div class="card w-100 shadow-sm">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title text-center">
                  <a href="/item/<?php echo e($item->id); ?>"><?php echo e($item->title); ?></a>
                </h5>
  
                <h6 class="card-subtitle mb-2 text-muted text-center">
                  Author: 
                  <img title="My Profile" data-toggle="tooltip" data-placement="bottom" 
                    src="/storage/<?php echo e($item->user->profile); ?>" 
                    style="width: 20px; height: 20px; border-radius: 50%;" />
                  &nbsp;<?php echo e($item->user->username); ?>

                </h6>
  
                <p class="text-muted small text-center mb-1">Lost Date: <?php echo e($item->lost_date); ?></p>
                <p class="text-muted small text-center mb-2">Category: <?php echo e($item->category); ?></p>
  
                <textarea readonly class="form-control mb-2" rows="3"><?php echo e($item->markings); ?></textarea>
  
                <?php if($item->photo_img): ?>
                <div class="text-center mt-auto">
                  <img src="/storage/<?php echo e($item->photo_img); ?>" alt="<?php echo e($item->title); ?>" 
                    class="img-fluid rounded" style="max-height: 150px; object-fit: contain;">
                </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
  
      <!-- Pagination -->
      <div class="pagination justify-content-center">
        <?php echo e($items->links('pagination::bootstrap-4')); ?>

      </div>
    </div>
  
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $attributes = $__attributesOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__attributesOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $component = $__componentOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__componentOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
  <?php /**PATH /Users/rob/TSU_SAM/resources/views/homepage-feed.blade.php ENDPATH**/ ?>