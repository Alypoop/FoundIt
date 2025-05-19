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

        <?php if($errors->any()): ?>
            <div class="alert alert-danger text-center mt-4">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p class="m-0"><?php echo e($error); ?></p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        <?php if($items->isEmpty()): ?>
            <div class="alert alert-info text-center">
                No matching items found with similarity score above 60%
            </div>
        <?php else: ?>
            <div class="row justify-content-center">
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="<?php echo e(asset('storage/' . $item->photo_img)); ?>" class="card-img-top" alt="<?php echo e($item->title); ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="<?php echo e(route('items.compare.view', ['id' => $item->id])); ?>">
                                        <?php echo e($item->title); ?>

                                    </a>
                                </h5>
                                <p class="card-text">
                                    <strong>Author:</strong> <?php echo e($item->user->username); ?><br>
                                    <strong>Found Date:</strong> <?php echo e($item->lost_date); ?><br>
                                    <strong>Category:</strong> <?php echo e($item->category->name); ?><br>
                                    <strong>Item Type:</strong> <?php echo e($item->itemType->name); ?><br>
                                    <strong>Location:</strong> <?php echo e($item->location); ?><br>
                                    <strong>Markings:</strong> <?php echo e($item->markings); ?><br>
                                    <strong>Status:</strong> <?php echo e($item->status); ?><br>
                                </p>

                                <?php if(isset($results[$item->id]['error'])): ?>
                                    <p class="text-danger">Comparison failed: <?php echo e($results[$item->id]['error']); ?></p>
                                <?php elseif(isset($results[$item->id])): ?>
                                    <div class="similarity-results mt-3 p-3 bg-light rounded">
                                        <h6>Similarity Results:</h6>
                                        <p class="mb-1"><strong>SIFT:</strong> <?php echo e($results[$item->id]['sift_similarity'] ?? 'N/A'); ?>%</p>
                                        <p class="mb-1"><strong>LAB:</strong> <?php echo e($results[$item->id]['lab_similarity'] ?? 'N/A'); ?>%</p>
                                        <p class="mb-0"><strong>Final Score:</strong> 
                                            <span class="fw-bold <?php echo e($results[$item->id]['final_similarity_score'] >= 75 ? 'text-success' : ($results[$item->id]['final_similarity_score'] >= 60 ? 'text-warning' : 'text-danger')); ?>">
                                                <?php echo e($results[$item->id]['final_similarity_score'] ?? 'N/A'); ?>%
                                            </span>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        <?php if($relatedItems->isNotEmpty()): ?>
            <hr class="my-5">
            <h4 class="text-center mb-4">Other Items of Type: <?php echo e($topItemType); ?></h4>
            <div class="row justify-content-center">
                <?php $__currentLoopData = $relatedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="<?php echo e(asset('storage/' . $item->photo_img)); ?>" class="card-img-top" alt="<?php echo e($item->title); ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="<?php echo e(route('items.compare.view', ['id' => $item->id])); ?>">
                                        <?php echo e($item->title); ?>

                                    </a>
                                </h5>
                                <p class="card-text">
                                    <strong>Author:</strong> <?php echo e($item->user->username); ?><br>
                                    <strong>Found Date:</strong> <?php echo e($item->lost_date); ?><br>
                                    <strong>Category:</strong> <?php echo e($item->category->name); ?><br>
                                    <strong>Item Type:</strong> <?php echo e($item->itemType->name); ?><br>
                                    <strong>Location:</strong> <?php echo e($item->location); ?><br>
                                    <strong>Markings:</strong> <?php echo e($item->markings); ?><br>
                                    <strong>Status:</strong> <?php echo e($item->status); ?><br>
                                </p>
                                <?php if(isset($results[$item->id])): ?>
                                    <div class="similarity-results mt-3 p-3 bg-light rounded">
                                        <h6>Similarity Results:</h6>
                                        <p class="mb-1"><strong>SIFT:</strong> <?php echo e($results[$item->id]['sift_similarity'] ?? 'N/A'); ?>%</p>
                                        <p class="mb-1"><strong>LAB:</strong> <?php echo e($results[$item->id]['lab_similarity'] ?? 'N/A'); ?>%</p>
                                        <p class="mb-0"><strong>Final Score:</strong> 
                                            <span class="fw-bold <?php echo e($results[$item->id]['final_similarity_score'] >= 75 ? 'text-success' : ($results[$item->id]['final_similarity_score'] >= 60 ? 'text-warning' : 'text-danger')); ?>">
                                                <?php echo e($results[$item->id]['final_similarity_score'] ?? 'N/A'); ?>%
                                            </span>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        <?php if(!empty($appliedFilters)): ?>
            <hr class="my-5">
            <h4 class="text-center mb-4">Applied Filters</h4>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <?php if(!empty($appliedFilters['category'])): ?>
                                <p><strong>Categories:</strong> 
                                    <?php echo e(implode(', ', array_map(function($id) {
                                        return \App\Models\Category::find($id)->name;
                                    }, $appliedFilters['category']))); ?>

                                </p>
                            <?php endif; ?>
                            <?php if(!empty($appliedFilters['item_type'])): ?>
                                <p><strong>Item Types:</strong> 
                                    <?php echo e(implode(', ', array_map(function($id) {
                                        return \App\Models\ItemType::find($id)->name;
                                    }, $appliedFilters['item_type']))); ?>

                                </p>
                            <?php endif; ?>
                            <?php if(!empty($appliedFilters['location'])): ?>
                                <p><strong>Locations:</strong> <?php echo e(implode(', ', $appliedFilters['location'])); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <h5 class="text-center mb-4">All Filtered Items</h5>
                    <div class="row">
                        <?php $__currentLoopData = $filteredItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <img src="<?php echo e(asset('storage/' . $item->photo_img)); ?>" class="card-img-top" alt="<?php echo e($item->title); ?>" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                          <a href="<?php echo e(route('items.compare.view', ['id' => $item->id])); ?>">
                                                <?php echo e($item->title); ?>

                                            </a>
                                        </h5>
                                        <p class="card-text">
                                            <strong>Item Type:</strong> <?php echo e($item->itemType->name); ?><br>
                                            <strong>Category:</strong> <?php echo e($item->category->name); ?><br>
                                            <strong>Location:</strong> <?php echo e($item->location); ?>

                                        </p>
                                        <?php if(isset($results[$item->id])): ?>
                                            <div class="similarity-results mt-3 p-3 bg-light rounded">
                                                <h6>Similarity Results:</h6>
                                                <p class="mb-1"><strong>SIFT:</strong> <?php echo e($results[$item->id]['sift_similarity'] ?? 'N/A'); ?>%</p>
                                                <p class="mb-1"><strong>LAB:</strong> <?php echo e($results[$item->id]['lab_similarity'] ?? 'N/A'); ?>%</p>
                                                <p class="mb-0"><strong>Final Score:</strong> 
                                                    <span class="fw-bold <?php echo e($results[$item->id]['final_similarity_score'] >= 75 ? 'text-success' : ($results[$item->id]['final_similarity_score'] >= 60 ? 'text-warning' : 'text-danger')); ?>">
                                                        <?php echo e($results[$item->id]['final_similarity_score'] ?? 'N/A'); ?>%
                                                    </span>
                                                </p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
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
<?php endif; ?><?php /**PATH D:\FoundItSystem\FoundIt\resources\views/search-comparison-results.blade.php ENDPATH**/ ?>