<div class="col-md-4 mb-4">
    <div class="card h-100">
        <img src="<?php echo e(asset('storage/' . $item->photo_img)); ?>" class="card-img-top" alt="<?php echo e($item->title); ?>">
        <div class="card-body">
            <h5 class="card-title"><?php echo e($item->title); ?></h5>
            <p class="card-text">
                <strong>Type:</strong> <?php echo e($item->itemType->name); ?><br>
                <strong>Category:</strong> <?php echo e($item->category->name); ?><br>
                <strong>Location:</strong> <?php echo e($item->location); ?>

            </p>
            
            <?php if(isset($results[$item->id])): ?>
            <div class="similarity-results">
                <h6>Similarity Results:</h6>
                <p>SIFT: <?php echo e($results[$item->id]['sift_similarity'] ?? 'N/A'); ?>%</p>
                <p>LAB: <?php echo e($results[$item->id]['lab_similarity'] ?? 'N/A'); ?>%</p>
                <p>Final: 
                    <span class="<?php echo e($results[$item->id]['final_similarity_score'] >= 60 ? 'text-success' : 'text-muted'); ?>">
                        <?php echo e($results[$item->id]['final_similarity_score'] ?? 'N/A'); ?>%
                    </span>
                </p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div><?php /**PATH D:\FoundItSystem\FoundIt\resources\views/partials/item-card.blade.php ENDPATH**/ ?>