<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <?php echo e($course->judul); ?>

            </h2>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $course)): ?>
                <div class="flex space-x-2">
                    <a href="<?php echo e(route('courses.edit', $course)); ?>" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        Edit Course
                    </a>
                </div>
            <?php endif; ?>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Course Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <?php if($course->thumbnail): ?>
                        <img src="<?php echo e(asset('storage/' . $course->thumbnail)); ?>" alt="<?php echo e($course->judul); ?>" class="w-full h-64 object-cover rounded-lg mb-6">
                    <?php endif; ?>
                    
                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            <?php echo e($course->kategori ?? 'General'); ?>

                        </span>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            By <?php echo e($course->user->name); ?>

                        </div>
                    </div>
                    
                    <div class="prose max-w-none">
                        <p class="text-gray-700"><?php echo e($course->deskripsi); ?></p>
                    </div>
                </div>
            </div>

            <!-- Course Materials -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Course Materials</h3>
                        <?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(route('materials.create', ['course_id' => $course->id])); ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Add Material
                            </a>
                        <?php endif; ?>
                    </div>

                    <?php if($course->materials->count() > 0): ?>
                        <div class="space-y-4">
                            <?php $__currentLoopData = $course->materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-300">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mr-2">
                                                    <?php echo e(ucfirst($material->tipe)); ?>

                                                </span>
                                                <?php if(auth()->guard()->check()): ?>
                                                    <?php if(!auth()->user()->isAdmin() && $material->status === 'pending'): ?>
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            Pending Approval
                                                        </span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 text-xs">
                                                        Login Required
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <h4 class="text-lg font-medium text-gray-800 mb-2"><?php echo e($material->judul); ?></h4>
                                            
                                            <?php if($material->deskripsi): ?>
                                                <p class="text-gray-600 text-sm mb-2"><?php echo e(Str::limit($material->deskripsi, 150)); ?></p>
                                            <?php endif; ?>
                                            
                                            <div class="flex items-center text-sm text-gray-500">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                Created by <?php echo e($material->user->name); ?>

                                            </div>
                                        </div>
                                        
                                        <div class="ml-4">
                                            <?php if(auth()->guard()->guest()): ?>
                                                <div class="text-center">
                                                    <p class="text-sm text-gray-500 mb-2">Login to access</p>
                                                    <a href="<?php echo e(route('login')); ?>" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                                        Login →
                                                    </a>
                                                </div>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('materials.show', $material)); ?>" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                                    View Material →
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M9 8h6M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 011 1v1a1 1 0 01-1 1H3a1 1 0 01-1-1V5a1 1 0 011-1h4zm0 4v12a2 2 0 002 2h6a2 2 0 002-2V8H7z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No materials yet</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by adding the first material to this course.</p>
                            <?php if(auth()->guard()->check()): ?>
                                <div class="mt-6">
                                    <a href="<?php echo e(route('materials.create', ['course_id' => $course->id])); ?>" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                        Add Material
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4619374cef299e94fd7263111d0abc69)): ?>
<?php $attributes = $__attributesOriginal4619374cef299e94fd7263111d0abc69; ?>
<?php unset($__attributesOriginal4619374cef299e94fd7263111d0abc69); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4619374cef299e94fd7263111d0abc69)): ?>
<?php $component = $__componentOriginal4619374cef299e94fd7263111d0abc69; ?>
<?php unset($__componentOriginal4619374cef299e94fd7263111d0abc69); ?>
<?php endif; ?> <?php /**PATH /var/www/resources/views/courses/show.blade.php ENDPATH**/ ?>