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
  <div class="container-fluid" style="width:1220px;">
      <div class="row">
          <div class="col-md-12">
              <div class="card">
                  <div class="card-body">
                      <h5 class="card-title text-uppercase mb-0 d-inline"><strong>Users</strong></h5>
                      <a class=" float-left rounded mr-3" title="Go Back" href="/">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                      </a>
                      <a class="btn btn-master float-right rounded" href="/user/create">Create New User</a>
                  </div>
                  
                  <div class="table-responsive">
                      <table id="myTable" class="table no-wrap user-table mb-0">

                          <?php if(session()->has('success')): ?>
                          <div class="container container--narrow">
                          <div class="alert alert-success text-center">
                              <?php echo e(session('success')); ?>

                          </div>
                          </div>
                          <?php endif; ?>

                          <?php if(session()->has('failure')): ?>
                          <div class="container container--narrow">
                            <div class="alert alert-danger text-center">
                              <?php echo e(session('failure')); ?>

                            </div>
                          </div>
                          <?php endif; ?>
                          
                          <thead style="background-color:#ecdbc7;">
                          <tr>
                            <th scope="col" class="border-0 text-uppercase font-medium">First Name</th>
                            <th scope="col" class="border-0 text-uppercase font-medium">Last Name</th>
                            <th scope="col" class="border-0 text-uppercase font-medium">Username</th>
                            <th scope="col" class="border-0 text-uppercase font-medium">Email</th>
                            <th scope="col" class="border-0 text-uppercase font-medium">Role</th>
                            <th scope="col" class="border-0 text-uppercase font-medium">Address</th>
                            <th scope="col" class="border-0 text-uppercase font-medium">Phone Number</th>
                            <th scope="col" class="border-0 text-uppercase font-medium">Actions</th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $users): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <tr>
                                  <td class="pl-3"><?php echo e($users->first_name); ?></td>
                                  <td class="pl-3"><?php echo e($users->last_name); ?></td>
                                  <td class="pl-3"><?php echo e($users->username); ?></td>
                                  <td class="pl-3"><?php echo e($users->email); ?></td>
                                  <td class="pl-3"><?php echo e($users->usertype); ?></td>
                                  <td class="pl-3"><?php echo e($users->address); ?></td>
                                  <td class="pl-3"><?php echo e($users->phone); ?></td>
                                  <td>
                                    <div class="btn-group mr-2">
                                      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view', auth()->user())): ?>
                                      <a class="btn btn-master float-right rounded mr-3" href="/user/password/<?php echo e($users->id); ?>">
                                          <i class="fa fa-key"></i> <!-- Update Password Icon -->
                                      </a>
                                      <?php endif; ?>
                                      
                                      <a class="btn btn-master float-right rounded mr-3" href="/user/<?php echo e($users->id); ?>/edit">
                                          <i class="fa fa-pencil-alt"></i> <!-- Update Icon -->
                                      </a>
                                      
                                      
                                      <form class="delete-post-form d-inline" action="delete/<?php echo e($users->id); ?>" method="POST"
                                            onclick="checker('Are you sure you want to delete this user?');">
                                          <?php echo method_field('DELETE'); ?>
                                          <?php echo csrf_field(); ?>
                                          <button class="btn btn-master float-right rounded mr-3">
                                              <i class="fa fa-trash"></i> <!-- Delete Icon -->
                                          </button>
                                      </form>
                                      
                                  </div>
                                  </td>
                          </tr>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <script>
      function checker(message) {
        var result = confirm(message);
        if (result == false) {
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
<?php endif; ?>
<?php /**PATH /Users/rob/TSU_SAM/resources/views/users.blade.php ENDPATH**/ ?>