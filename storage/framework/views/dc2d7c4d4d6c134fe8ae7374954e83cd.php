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
                <?php echo e(__('Learning Materials')); ?>

            </h2>
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('materials.create')); ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Upload Material
                </a>
            <?php endif; ?>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <?php if($materials->count() > 0): ?>
                        <div class="space-y-6">
                            <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow duration-300">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2">
                                                    <?php echo e(ucfirst($material->tipe)); ?>

                                                </span>
                                                <span class="text-sm text-gray-500">
                                                    <?php echo e($material->course->judul); ?>

                                                </span>
                                            </div>
                                            
                                            <h3 class="text-lg font-semibold text-gray-800 mb-2"><?php echo e($material->judul); ?></h3>
                                            
                                            <?php if($material->deskripsi): ?>
                                                <p class="text-gray-600 text-sm mb-4"><?php echo e(Str::limit($material->deskripsi, 200)); ?></p>
                                            <?php endif; ?>
                                            
                                            <div class="flex items-center text-sm text-gray-500">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                Created by <?php echo e($material->user->name); ?>

                                                <span class="mx-2">•</span>
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <?php echo e($material->created_at->diffForHumans()); ?>

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
                        
                        <div class="mt-8">
                            <?php echo e($materials->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M9 8h6M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 011 1v1a1 1 0 01-1 1H3a1 1 0 01-1-1V5a1 1 0 011-1h4z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No materials found</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by uploading the first material.</p>
                            <?php if(auth()->guard()->check()): ?>
                                <div class="mt-6">
                                    <a href="<?php echo e(route('materials.create')); ?>" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                        Upload Material
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
<?php endif; ?> <?php /**PATH /home/wiratama/semester-4/pemrograman-web-2/learning-dev/resources/views/materials/index.blade.php ENDPATH**/ ?>