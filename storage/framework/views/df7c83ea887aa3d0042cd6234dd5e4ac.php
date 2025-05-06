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
        <h2 class="text-center mb-4">Detailed Comparison</h2>

        <div class="row justify-content-center text-center mb-4">
            <div class="col-md-5">
                <h5>Uploaded Image</h5>
                <img src="<?php echo e($comparison['uploaded'] ?? '#'); ?>" alt="Uploaded" class="img-fluid rounded shadow" style="max-height: 300px;">
            </div>
            <div class="col-md-5">
                <h5>Matched Item Image</h5>
                <img src="<?php echo e($comparison['matched'] ?? '#'); ?>" alt="Matched Item" class="img-fluid rounded shadow" style="max-height: 300px;">
            </div>
        </div>
        <div class="text-center mt-4">
            <h5>Result Summary</h5>
            <p><strong>SIFT Match Score:</strong> <?php echo e($comparison['result']['sift_similarity'] ?? 'N/A'); ?></p>
            <p><strong>LAB Similarity:</strong> <?php echo e($comparison['result']['lab_similarity'] ?? 'N/A'); ?></p>
            <p><strong>Final Score:</strong> <?php echo e($comparison['result']['final_similarity_score'] ?? 'N/A'); ?></p>
        </div>

        <?php if(auth()->check()): ?>
        <div class="text-center mt-4">
            <form action="<?php echo e(route('item.claim', $item->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-success pl-5 pr-5">Claim</button>
            </form>
        </div>
    <?php endif; ?>
    

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
<?php /**PATH /Users/rob/TSU_SAM/resources/views/compare-view.blade.php ENDPATH**/ ?>