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
        <?php if($errors->any()): ?>
            <div class="alert alert-danger text-center">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p class="m-0"><?php echo e($error); ?></p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
        <h1 class="text-center my-4">Search Items</h1>

        <form id="searchForm" action="<?php echo e(route('items.search')); ?>" method="GET" class="container">

            
            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    <input type="text" name="keyword" class="form-control" placeholder="Search by title, markings, or lost date" value="<?php echo e(request('keyword')); ?>">
                </div>
            </div>


            
            <div class="d-flex justify-content-center gap-4 mb-3 flex-wrap">
                <div class="form-check mr-3 border rounded px-5 py-3">
                    <input class="form-check-input" type="checkbox" name="category[]" value="bag"
                    <?php echo e(in_array('bag', request()->input('category', [])) ? 'checked' : ''); ?>>
                <label class="form-check-label" for="bag">Bag</label>
                </div>

                <div class="form-check mr-3 border rounded px-5 py-3">
                    <input class="form-check-input" type="checkbox" name="category[]" value="wallet" id="wallet"
                    <?php echo e(in_array('wallet', request()->input('category', [])) ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="wallet">Wallet</label>
                </div>

                <div class="form-check mr-3 border rounded px-5 py-3">
                    <input class="form-check-input" type="checkbox" name="category[]" value="make up" id="make up"
                    <?php echo e(in_array('make up', request()->input('category', [])) ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="makeup">Makeup</label>
                </div>

                <div class="form-check mr-3 border rounded px-5 py-3">
                    <input class="form-check-input" type="checkbox" name="category[]" value="electronics" id="electronics"
                    <?php echo e(in_array('electronics', request()->input('category', [])) ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="electronic">Electronic</label>
                </div>

                <div class="form-check mr-3 border rounded px-5 py-3">
                    <input class="form-check-input" type="checkbox" name="category[]" value="Others" id="Others"
                    <?php echo e(in_array('Others', request()->input('category', [])) ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="Others">Others</label>
                </div>
            </div>

            
            <div class="d-flex justify-content-center gap-4 mb-3 flex-wrap">
                <div class="form-check mr-3 border rounded px-5 py-3">
                    <input class="form-check-input" type="checkbox" name="location[]" value="TSU San Isidro" id="TSU San Isidro"
                    <?php echo e(in_array('TSU San Isidro', request()->input('location', [])) ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="clothing">TSU San Isidro</label>
                </div>

                <div class="form-check mr-3 border rounded px-5 py-3">
                    <input class="form-check-input" type="checkbox" name="location[]" value="TSU Main" id="TSU Main"
                    <?php echo e(in_array('TSU Main', request()->input('location', [])) ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="documents">TSU Main</label>
                </div>

                <div class="form-check mr-3 border rounded px-5 py-3">
                    <input class="form-check-input" type="checkbox" name="location[]" value="TSU Lucinda" id="TSU Lucinda"
                    <?php echo e(in_array('TSU Lucinda', request()->input('location', [])) ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="others">TSU Lucinda</label>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary px-4">Search</button>
            </div>
        </form>

        <?php if($items->count()): ?>
        <form id="imageSearchForm" action="<?php echo e(route('items.image.compare')); ?>" method="POST" enctype="multipart/form-data" class="d-none">
            <?php echo csrf_field(); ?>
            <div class="text-center mt-3">
                <input type="file" name="image" class="form-control mb-2" required>
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="hidden" name="matched_items[<?php echo e($item->id); ?>]" value="<?php echo e($item->photo_img); ?>">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <button type="submit" class="btn btn-primary">Image Search</button>
            </div>
        </form>
    <?php endif; ?>
    



        <?php if($items->count()): ?>
        <div class="container mt-4">
            <div class="row justify-content-center">
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 mb-4 d-flex justify-content-center">
                        <div class="card" style="width: 18rem;">                
                            <div class="card-body">
                                <a href="/item/<?php echo e($item->id); ?>"><h5 class="card-title"><?php echo e($item->title); ?></h5></a>
                                <p class="card-text">
                                    <strong>Author:</strong> 
                                    <img class="avatar-tiny" src="/storage/<?php echo e($item->user->profile ?? 'profile/default.jpg'); ?>" />
                                    <?php echo e($item->user->username); ?><br>
                                    <strong>Lost Date:</strong> <?php echo e($item->lost_date); ?><br>
                                    <strong>Category:</strong> <?php echo e($item->category); ?><br>
                                    <strong>Location:</strong> <?php echo e($item->location); ?>

                                </p>
                                <p><?php echo e($item->markings); ?></p>
                                <?php if($item->photo_img): ?>
                                    <img src="/storage/<?php echo e($item->photo_img); ?>" alt="Item image" class="img-fluid">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center mt-4">
            <p>No items matched your search.</p>
        </div>
    <?php endif; ?>

   



    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("searchForm");
            const checkboxes = form.querySelectorAll("input[type='checkbox']");
            const imageSearchForm = document.getElementById("imageSearchForm");
    
            function toggleImageSearchForm() {
                const isAnyChecked = Array.from(checkboxes).some(cb => cb.checked);
                const hasResults = <?php echo e($items->count() > 0 ? 'true' : 'false'); ?>;
    
                if (isAnyChecked && hasResults) {
                    imageSearchForm.classList.remove("d-none");
                } else {
                    imageSearchForm.classList.add("d-none");
                }
            }
    
            toggleImageSearchForm(); // on page load
    
            checkboxes.forEach(cb => cb.addEventListener("change", toggleImageSearchForm));
        });
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
<?php endif; ?>
<?php /**PATH /Users/rob/Desktop/TSU_SAM/resources/views/search.blade.php ENDPATH**/ ?>