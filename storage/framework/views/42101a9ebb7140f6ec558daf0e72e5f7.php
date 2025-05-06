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

    <div class="container my-5">
        <h2 class="text-center mb-4">Comparison Results</h2>

        <?php if($items->isEmpty()): ?>
            <p class="text-center text-muted">No best match found or API did not return scores.</p>
        <?php endif; ?>


        <div class="row justify-content-center">


            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card m-2" style="width: 18rem;">
                    <img src="<?php echo e(asset('storage/' . $item->photo_img)); ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="<?php echo e(route('items.compare.view', ['id' => $item->id])); ?>">
                                <h5 class="card-title"><?php echo e($item->title); ?></h5>
                            </a>
                            
                          </h5>
                                                  <p class="card-text">
                            <strong>Author:</strong> <?php echo e($item->user->username); ?><br>
                            <strong>Lost Date:</strong> <?php echo e($item->lost_date); ?><br>
                            <strong>Category:</strong> <?php echo e($item->category); ?><br>
                            <strong>Location:</strong> <?php echo e($item->location); ?><br>
                            <strong>Markings:</strong> <?php echo e($item->markings); ?><br>
                        </p>

                        <?php if(isset($results[$item->id]['error'])): ?>
                            <p class="text-danger">Comparison failed: <?php echo e($results[$item->id]['error']); ?></p>
                        <?php elseif(isset($results[$item->id])): ?>
                            <p class="text-success">
                                Match Score: <?php echo e($results[$item->id]['sift_similarity'] ?? 'N/A'); ?><br>
                                LAB Similarity: <?php echo e($results[$item->id]['lab_similarity'] ?? 'N/A'); ?>

                                
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
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
<?php endif; ?>
<?php /**PATH /Users/rob/TSU_SAM/resources/views/search-comparison-results.blade.php ENDPATH**/ ?>