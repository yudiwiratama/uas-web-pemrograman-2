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
            <?php echo e(__('Create Material')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Debug info -->
                    <?php if(count($courses) == 0): ?>
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
                            <strong>Notice:</strong> No approved courses available. You need to create and approve a course first.
                            <a href="<?php echo e(route('courses.create')); ?>" class="underline ml-2">Create Course</a>
                        </div>
                    <?php endif; ?>
                    
                    <form action="<?php echo e(route('materials.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        
                        <div class="mb-6">
                            <label for="course_id" class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                            <select id="course_id" name="course_id" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Select a course</option>
                                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($course->id); ?>" <?php echo e(request('course_id') == $course->id ? 'selected' : ''); ?>>
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

                        <div class="mb-6">
                            <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">Material Title</label>
                            <input type="text" id="judul" name="judul" value="<?php echo e(old('judul')); ?>" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
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

                        <div class="mb-6">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                            <textarea id="deskripsi" name="deskripsi" rows="3" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"><?php echo e(old('deskripsi')); ?></textarea>
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

                        <div class="mb-6">
                            <label for="tipe" class="block text-sm font-medium text-gray-700 mb-2">Material Type</label>
                            <select id="tipe" name="tipe" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required onchange="toggleContentInput()">
                                <option value="">Select material type</option>
                                <option value="article" <?php echo e(old('tipe') == 'article' ? 'selected' : ''); ?>>Article</option>
                                <option value="video" <?php echo e(old('tipe') == 'video' ? 'selected' : ''); ?>>Video</option>
                                <option value="pdf" <?php echo e(old('tipe') == 'pdf' ? 'selected' : ''); ?>>PDF</option>
                                <option value="audio" <?php echo e(old('tipe') == 'audio' ? 'selected' : ''); ?>>Audio</option>
                                <option value="image" <?php echo e(old('tipe') == 'image' ? 'selected' : ''); ?>>Image</option>
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

                        <!-- File Upload (for non-article types) -->
                        <div id="file-upload" class="mb-6" style="display: none;">
                            <label for="file" class="block text-sm font-medium text-gray-700 mb-2">Upload File</label>
                            <input type="file" id="file" name="file" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-sm text-gray-500 mt-1" id="file-size-info">Max file size: 10MB</p>
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

                        <!-- Article Content (for article type) -->
                        <div id="article-content" class="mb-6" style="display: none;">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Article Content</label>
                            <textarea id="content" name="content" rows="10" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Write your article content here... You can use HTML tags."><?php echo e(old('content')); ?></textarea>
                            <p class="text-sm text-gray-500 mt-1">You can use HTML tags for formatting.</p>
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

                        <div class="flex items-center justify-between">
                            <a href="<?php echo e(route('materials.index')); ?>" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Material
                            </button>
                        </div>
                    </form>

                    <!-- Show form submission errors -->
                    <?php if($errors->any()): ?>
                        <div class="mt-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <strong>Please fix the following errors:</strong>
                            <ul class="mt-2 list-disc list-inside">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleContentInput() {
            const tipe = document.getElementById('tipe').value;
            const fileUpload = document.getElementById('file-upload');
            const articleContent = document.getElementById('article-content');
            const fileInput = document.getElementById('file');
            const fileSizeInfo = document.getElementById('file-size-info');
            
            if (tipe === 'article') {
                fileUpload.style.display = 'none';
                articleContent.style.display = 'block';
                fileInput.required = false;
                document.getElementById('content').required = true;
                fileInput.accept = '';
            } else if (tipe) {
                fileUpload.style.display = 'block';
                articleContent.style.display = 'none';
                fileInput.required = true;
                document.getElementById('content').required = false;
                
                // Set file input attributes based on type
                switch(tipe) {
                    case 'video':
                        fileInput.accept = '.mp4,.avi,.mov,.wmv,.flv';
                        fileSizeInfo.textContent = 'Max file size: 2MB (PHP limit) | Accepted: MP4, AVI, MOV, WMV, FLV';
                        break;
                    case 'pdf':
                        fileInput.accept = '.pdf';
                        fileSizeInfo.textContent = 'Max file size: 2MB (PHP limit) | Accepted: PDF files only';
                        break;
                    case 'audio':
                        fileInput.accept = '.mp3,.wav,.aac,.ogg';
                        fileSizeInfo.textContent = 'Max file size: 2MB (PHP limit) | Accepted: MP3, WAV, AAC, OGG';
                        break;
                    case 'image':
                        fileInput.accept = '.jpeg,.jpg,.png,.gif,.webp';
                        fileSizeInfo.textContent = 'Max file size: 2MB (PHP limit) | Accepted: JPEG, PNG, GIF, WebP';
                        break;
                    default:
                        fileInput.accept = '';
                        fileSizeInfo.textContent = 'Max file size: 10MB';
                }
            } else {
                fileUpload.style.display = 'none';
                articleContent.style.display = 'none';
                fileInput.required = false;
                document.getElementById('content').required = false;
                fileInput.accept = '';
            }
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleContentInput();
        });
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
<?php endif; ?> <?php /**PATH /home/wiratama/semester-4/pemrograman-web-2/learning-dev/resources/views/materials/create.blade.php ENDPATH**/ ?>