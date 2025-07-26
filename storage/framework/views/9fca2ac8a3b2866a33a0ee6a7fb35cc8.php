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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Edit Material')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="<?php echo e(route('materials.update', $material)); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>

                        <!-- Course -->
                        <div class="mb-6">
                            <label for="course_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <?php echo e(__('Course')); ?>

                            </label>
                            <select name="course_id" 
                                    id="course_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required>
                                <option value="">Pilih Course</option>
                                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($course->id); ?>" <?php echo e(old('course_id', $material->course_id) == $course->id ? 'selected' : ''); ?>>
                                        <?php echo e($course->judul); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['course_id'];
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

                        <!-- Judul -->
                        <div class="mb-6">
                            <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                                <?php echo e(__('Judul Material')); ?>

                            </label>
                            <input type="text" 
                                   name="judul" 
                                   id="judul" 
                                   value="<?php echo e(old('judul', $material->judul)); ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   required>
                            <?php $__errorArgs = ['judul'];
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

                        <!-- Deskripsi -->
                        <div class="mb-6">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                                <?php echo e(__('Deskripsi')); ?>

                            </label>
                            <textarea name="deskripsi" 
                                      id="deskripsi" 
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?php echo e(old('deskripsi', $material->deskripsi)); ?></textarea>
                            <?php $__errorArgs = ['deskripsi'];
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

                        <!-- Tipe -->
                        <div class="mb-6">
                            <label for="tipe" class="block text-sm font-medium text-gray-700 mb-2">
                                <?php echo e(__('Tipe Material')); ?>

                            </label>
                            <select name="tipe" 
                                    id="tipe"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required
                                    onchange="toggleContentInput()">
                                <option value="">Pilih Tipe</option>
                                <option value="article" <?php echo e(old('tipe', $material->tipe) == 'article' ? 'selected' : ''); ?>>Article</option>
                                <option value="video" <?php echo e(old('tipe', $material->tipe) == 'video' ? 'selected' : ''); ?>>Video</option>
                                <option value="pdf" <?php echo e(old('tipe', $material->tipe) == 'pdf' ? 'selected' : ''); ?>>PDF</option>
                                <option value="audio" <?php echo e(old('tipe', $material->tipe) == 'audio' ? 'selected' : ''); ?>>Audio</option>
                                <option value="image" <?php echo e(old('tipe', $material->tipe) == 'image' ? 'selected' : ''); ?>>Image</option>
                            </select>
                            <?php $__errorArgs = ['tipe'];
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

                        <!-- File Upload (for non-article) -->
                        <div id="file-input" class="mb-6" style="<?php echo e(old('tipe', $material->tipe) == 'article' ? 'display: none;' : ''); ?>">
                            <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                                <?php echo e(__('Upload File')); ?>

                            </label>
                            <?php if($material->tipe != 'article' && $material->file_url): ?>
                                <div class="mb-3 p-3 bg-gray-100 rounded-lg">
                                    <p class="text-sm text-gray-700">File saat ini:</p>
                                    <a href="<?php echo e(Storage::url($material->file_url)); ?>" 
                                       target="_blank" 
                                       class="text-blue-600 hover:text-blue-800 text-sm">
                                        <?php echo e(basename($material->file_url)); ?>

                                    </a>
                                </div>
                            <?php endif; ?>
                            <input type="file" 
                                   name="file" 
                                   id="file"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="text-sm text-gray-600 mt-1">Kosongkan jika tidak ingin mengubah file</p>
                            <?php $__errorArgs = ['file'];
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

                        <!-- Article Content (for article) -->
                        <div id="content-input" class="mb-6" style="<?php echo e(old('tipe', $material->tipe) != 'article' ? 'display: none;' : ''); ?>">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                <?php echo e(__('Content (HTML)')); ?>

                            </label>
                            <textarea name="content" 
                                      id="content" 
                                      rows="10"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?php echo e(old('content', $material->tipe == 'article' ? $material->file_url : '')); ?></textarea>
                            <p class="text-sm text-gray-600 mt-1">Gunakan HTML tags untuk formatting</p>
                            <?php $__errorArgs = ['content'];
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

                        <!-- Status (admin only) -->
                        <?php if(auth()->user()->isAdmin()): ?>
                            <div class="mb-6">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    <?php echo e(__('Status')); ?>

                                </label>
                                <select name="status" 
                                        id="status"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="pending" <?php echo e(old('status', $material->status) == 'pending' ? 'selected' : ''); ?>>Pending</option>
                                    <option value="approved" <?php echo e(old('status', $material->status) == 'approved' ? 'selected' : ''); ?>>Approved</option>
                                </select>
                                <?php $__errorArgs = ['status'];
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
                        <?php endif; ?>

                        <div class="flex items-center justify-between">
                            <a href="<?php echo e(route('materials.show', $material)); ?>" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                                <?php echo e(__('Batal')); ?>

                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                                <?php echo e(__('Update Material')); ?>

                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleContentInput() {
            const tipe = document.getElementById('tipe').value;
            const fileInput = document.getElementById('file-input');
            const contentInput = document.getElementById('content-input');
            
            if (tipe === 'article') {
                fileInput.style.display = 'none';
                contentInput.style.display = 'block';
            } else {
                fileInput.style.display = 'block';
                contentInput.style.display = 'none';
            }
        }
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4619374cef299e94fd7263111d0abc69)): ?>
<?php $attributes = $__attributesOriginal4619374cef299e94fd7263111d0abc69; ?>
<?php unset($__attributesOriginal4619374cef299e94fd7263111d0abc69); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4619374cef299e94fd7263111d0abc69)): ?>
<?php $component = $__componentOriginal4619374cef299e94fd7263111d0abc69; ?>
<?php unset($__componentOriginal4619374cef299e94fd7263111d0abc69); ?>
<?php endif; ?> <?php /**PATH /home/wiratama/semester-4/pemrograman-web-2/learning-dev/resources/views/materials/edit.blade.php ENDPATH**/ ?>