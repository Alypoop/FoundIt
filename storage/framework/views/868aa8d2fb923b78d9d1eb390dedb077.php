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

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="keyword" class="form-label">Search by Name/Markings</label>
                            <input type="text" id="keyword" name="keyword" class="form-control" 
                                   placeholder="e.g. 'hand bag', 'wallet'" 
                                   value="<?php echo e(request('keyword')); ?>">
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-3"><strong>Category</strong></h5>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-check mb-2">
                                <input class="form-check-input category-filter" type="checkbox" 
                                       name="category[]" value="<?php echo e($category->id); ?>"
                                       id="category-<?php echo e($category->id); ?>"
                                       <?php echo e(in_array($category->id, request()->input('category', [])) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="category-<?php echo e($category->id); ?>">
                                    <?php echo e($category->name); ?>

                                </label>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div class="mb-4" id="itemTypeFilterContainer" style="display: none;">
                            <h5 class="mb-3"><strong>Item Type</strong></h5>
                            <div id="itemTypeFilters"></div>
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-3"><strong>Location</strong></h5>
                            <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-check mb-2">
                                <input class="form-check-input location-filter" type="checkbox" 
                                       name="location[]" value="<?php echo e($loc); ?>"
                                       id="location-<?php echo e(Str::slug($loc, '-')); ?>"
                                       <?php echo e(in_array($loc, request()->input('location', [])) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="location-<?php echo e(Str::slug($loc, '-')); ?>"><?php echo e($loc); ?></label>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-3"><strong>Image Search</strong></h5>
                            <form id="imageSearchForm" action="<?php echo e(route('items.image.compare')); ?>" method="POST" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="mb-3">
                                    <label for="imageUpload" class="form-label">Upload image to compare</label>
                                    <input type="file" name="image" class="form-control" id="imageUpload" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Search by Image</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div id="searchResults">
                    <?php echo $__env->make('partials.search-results', ['items' => $items], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function debounce(func, wait) {
        let timeout;
        return function() {
            const context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }

    function loadSearchResults() {
        const formData = new FormData();
        formData.append('keyword', document.getElementById('keyword').value);
        
        document.querySelectorAll('.category-filter:checked').forEach(el => 
            formData.append('category[]', el.value));
        document.querySelectorAll('.item-type-filter:checked').forEach(el => 
            formData.append('item_type[]', el.value));
        document.querySelectorAll('.location-filter:checked').forEach(el => 
            formData.append('location[]', el.value));

        fetch('<?php echo e(route("items.search")); ?>', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('searchResults').innerHTML = data.html;
            updateImageSearchForm(data.items);
        })
        .catch(console.error);
    }

    function updateImageSearchForm(items) {
        const form = document.getElementById('imageSearchForm');
        form.querySelectorAll('input[name^="matched_items"], input[name^="filters"]').forEach(el => el.remove());
        
        items.forEach(item => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `matched_items[${item.id}]`;
            input.value = item.photo_img;
            form.appendChild(input);
        });

        const filters = {
            category: Array.from(document.querySelectorAll('.category-filter:checked')).map(el => el.value),
            item_type: Array.from(document.querySelectorAll('.item-type-filter:checked')).map(el => el.value),
            location: Array.from(document.querySelectorAll('.location-filter:checked')).map(el => el.value)
        };

        Object.entries(filters).forEach(([key, values]) => {
            values.forEach(value => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `filters[${key}][]`;
                input.value = value;
                form.appendChild(input);
            });
        });
    }

    function updateItemTypeFilters() {
        const selectedCategories = Array.from(document.querySelectorAll('.category-filter:checked')).map(el => el.value);
        
        if (!selectedCategories.length) {
            document.getElementById('itemTypeFilterContainer').style.display = 'none';
            return;
        }

        fetch('<?php echo e(route("items.item-types")); ?>', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ categories: selectedCategories })
        })
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('itemTypeFilters');
            container.innerHTML = '';
            
            if (data.itemTypes.length) {
                container.style.display = 'block';
                data.itemTypes.forEach(type => {
                    container.innerHTML += `
                        <div class="form-check mb-2">
                            <input class="form-check-input item-type-filter" type="checkbox" 
                                   name="item_type[]" value="${type.id}" id="item-type-${type.id}">
                            <label class="form-check-label" for="item-type-${type.id}">
                                ${type.name}
                            </label>
                        </div>
                    `;
                });
                document.querySelectorAll('.item-type-filter').forEach(el => 
                    el.addEventListener('change', debounce(loadSearchResults, 300)));
            } else {
                container.style.display = 'none';
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const debouncedSearch = debounce(loadSearchResults, 300);
        document.getElementById('keyword').addEventListener('input', debouncedSearch);
        document.querySelectorAll('.category-filter, .location-filter').forEach(el => 
            el.addEventListener('change', debouncedSearch));
        document.querySelectorAll('.category-filter').forEach(el => 
            el.addEventListener('change', updateItemTypeFilters));
        
        document.getElementById('imageSearchForm').addEventListener('submit', function(e) {
            if (!document.getElementById('imageUpload').files.length) {
                e.preventDefault();
                alert('Please select an image first');
            }
        });

        if (document.querySelectorAll('.category-filter:checked').length) {
            updateItemTypeFilters();
        }
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
<?php endif; ?><?php /**PATH D:\FoundItSystem\FoundIt\resources\views/search.blade.php ENDPATH**/ ?>