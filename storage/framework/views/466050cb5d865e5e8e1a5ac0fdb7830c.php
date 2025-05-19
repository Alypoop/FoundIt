<?php if($items->count()): ?>
<div class="row">
    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <?php if($item->photo_img): ?>
                    <img src="/storage/<?php echo e($item->photo_img); ?>" alt="Item image" class="card-img-top" style="height: 200px; object-fit: cover;">
                <?php endif; ?>
                <div class="card-body">
                    <a href="/item/<?php echo e($item->id); ?>" class="text-decoration-none">
                        <h5 class="card-title"><?php echo e($item->title); ?></h5>
                    </a>
                    <p class="card-text">
                        <strong>Author:</strong>
                        <img class="sm-profile-image" src="/storage/<?php echo e($item->user->profile ?? 'profile/default.jpg'); ?>" />
                        <?php echo e($item->user->username); ?><br>
                        <strong>Found Date:</strong> <?php echo e($item->lost_date); ?><br>
                        <strong>Category:</strong> <?php echo e($item->category->name); ?><br>
                        <strong>Type:</strong> <?php echo e($item->itemType->name); ?><br>
                        <strong>Location:</strong> <?php echo e($item->location); ?>

                    </p>
                    <p>
                        <textarea readonly class="form-control mb-2" rows="3" readonly 
                                  style="height: 50px; width: 100%; overflow-y: auto; 
                                  background-color: #e2e8f0; border: none; resize: none; 
                                  padding: 5px; border-radius: 5px;"><?php echo e($item->markings); ?></textarea>
                    </p>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php else: ?>
<div class="text-center mt-4">
    <p>No items matched your search.</p>
</div>
<?php endif; ?><?php /**PATH D:\FoundItSystem\FoundIt\resources\views/partials/search-results.blade.php ENDPATH**/ ?>