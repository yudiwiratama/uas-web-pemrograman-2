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
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <?php echo e($material->judul); ?>

                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Course: <a href="<?php echo e(route('courses.show', $material->course)); ?>" class="text-blue-600 hover:text-blue-800"><?php echo e($material->course->judul); ?></a>
                </p>
            </div>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $material)): ?>
                <div class="flex space-x-2">
                    <a href="<?php echo e(route('materials.edit', $material)); ?>" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        Edit Material
                    </a>
                </div>
            <?php endif; ?>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Material Content -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <?php echo e(ucfirst($material->tipe)); ?>

                            </span>
                            <?php if($material->status === 'pending'): ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    Pending Approval
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Created by <?php echo e($material->user->name); ?>

                        </div>
                    </div>

                    <?php if($material->deskripsi): ?>
                        <div class="mb-6">
                            <p class="text-gray-700"><?php echo e($material->deskripsi); ?></p>
                        </div>
                    <?php endif; ?>

                    <!-- Material Content Display -->
                    <div class="border-t pt-6">
                        <?php if($material->tipe === 'article'): ?>
                            <div class="prose max-w-none">
                                <?php echo $material->file_url; ?>

                            </div>
                        <?php elseif($material->tipe === 'image'): ?>
                            <div class="text-center">
                                <img src="<?php echo e(asset('storage/' . $material->file_url)); ?>" alt="<?php echo e($material->judul); ?>" class="max-w-full h-auto rounded-lg shadow-md">
                            </div>
                        <?php elseif($material->tipe === 'video'): ?>
                            <div class="text-center">
                                <video controls class="max-w-full h-auto rounded-lg shadow-md">
                                    <source src="<?php echo e(asset('storage/' . $material->file_url)); ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        <?php elseif($material->tipe === 'audio'): ?>
                            <div class="text-center">
                                <audio controls class="w-full">
                                    <source src="<?php echo e(asset('storage/' . $material->file_url)); ?>" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>
                        <?php elseif($material->tipe === 'pdf'): ?>
                            <div class="text-center">
                                <iframe src="<?php echo e(asset('storage/' . $material->file_url)); ?>" class="w-full h-96 border rounded-lg"></iframe>
                                <div class="mt-4">
                                    <a href="<?php echo e(asset('storage/' . $material->file_url)); ?>" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Download PDF
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Comments</h3>

                    <?php if(auth()->guard()->check()): ?>
                        <!-- Add Comment Form -->
                        <form action="<?php echo e(route('comments.store')); ?>" method="POST" class="mb-8">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="material_id" value="<?php echo e($material->id); ?>">
                            <div class="mb-4">
                                <label for="body" class="block text-sm font-medium text-gray-700 mb-2">Add a comment</label>
                                <textarea id="body" name="body" rows="3" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Share your thoughts..." required></textarea>
                                <?php $__errorArgs = ['body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Post Comment
                            </button>
                        </form>
                    <?php else: ?>
                        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                            <p class="text-gray-600">
                                <a href="<?php echo e(route('login')); ?>" class="text-blue-600 hover:text-blue-800">Login</a> to post a comment.
                            </p>
                        </div>
                    <?php endif; ?>

                    <!-- Display Comments -->
                    <?php if($material->rootComments->count() > 0): ?>
                        <div class="space-y-6">
                            <?php $__currentLoopData = $material->rootComments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo $__env->make('partials.comment', ['comment' => $comment, 'material' => $material], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No comments yet</h3>
                            <p class="mt-1 text-sm text-gray-500">Be the first to share your thoughts!</p>
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
<?php endif; ?> <?php /**PATH /home/wiratama/semester-4/pemrograman-web-2/learning-dev/resources/views/materials/show.blade.php ENDPATH**/ ?>