<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Material') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Debug info -->
                    @if(count($courses) == 0)
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
                            <strong>Notice:</strong> No approved courses available. You need to create and approve a course first.
                            <a href="{{ route('courses.create') }}" class="underline ml-2">Create Course</a>
                        </div>
                    @endif
                    
                    <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-6">
                            <label for="course_id" class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                            <select id="course_id" name="course_id" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Select a course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->judul }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">Material Title</label>
                            <input type="text" id="judul" name="judul" value="{{ old('judul') }}" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            @error('judul')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                            <textarea id="deskripsi" name="deskripsi" rows="3" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="tipe" class="block text-sm font-medium text-gray-700 mb-2">Material Type</label>
                            <select id="tipe" name="tipe" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required onchange="toggleContentInput()">
                                <option value="">Select material type</option>
                                <option value="article" {{ old('tipe') == 'article' ? 'selected' : '' }}>Article</option>
                                <option value="video" {{ old('tipe') == 'video' ? 'selected' : '' }}>Video</option>
                                <option value="pdf" {{ old('tipe') == 'pdf' ? 'selected' : '' }}>PDF</option>
                                <option value="audio" {{ old('tipe') == 'audio' ? 'selected' : '' }}>Audio</option>
                                <option value="image" {{ old('tipe') == 'image' ? 'selected' : '' }}>Image</option>
                            </select>
                            @error('tipe')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- File Upload (for non-article types) -->
                        <div id="file-upload" class="mb-6" style="display: none;">
                            <label for="file" class="block text-sm font-medium text-gray-700 mb-2">Upload File</label>
                            <input type="file" id="file" name="file" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-sm text-gray-500 mt-1" id="file-size-info">Max file size: 10MB</p>
                            @error('file')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Article Content (for article type) -->
                        <div id="article-content" class="mb-6" style="display: none;">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Article Content</label>
                            <textarea id="content" name="content" rows="10" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Write your article content here... You can use HTML tags.">{{ old('content') }}</textarea>
                            <p class="text-sm text-gray-500 mt-1">You can use HTML tags for formatting.</p>
                            @error('content')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('materials.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Material
                            </button>
                        </div>
                    </form>

                    <!-- Show form submission errors -->
                    @if ($errors->any())
                        <div class="mt-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <strong>Please fix the following errors:</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
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
                        fileInput.accept = '.mp4,.avi,.mov,.wmv,.flv,.mkv';
                        fileSizeInfo.textContent = 'Max file size: 10MB (limited by PHP 2MB) | Accepted: MP4, AVI, MOV, WMV, FLV, MKV';
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
</x-app-layout> 