<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Material') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('materials.update', $material) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- Course -->
                        <div class="mb-6">
                            <label for="course_id" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Course') }}
                            </label>
                            <select name="course_id" 
                                    id="course_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required>
                                <option value="">Pilih Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id', $material->course_id) == $course->id ? 'selected' : '' }}>
                                        {{ $course->judul }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Judul -->
                        <div class="mb-6">
                            <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Judul Material') }}
                            </label>
                            <input type="text" 
                                   name="judul" 
                                   id="judul" 
                                   value="{{ old('judul', $material->judul) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   required>
                            @error('judul')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-6">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Deskripsi') }}
                            </label>
                            <textarea name="deskripsi" 
                                      id="deskripsi" 
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('deskripsi', $material->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipe -->
                        <div class="mb-6">
                            <label for="tipe" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Tipe Material') }}
                            </label>
                            <select name="tipe" 
                                    id="tipe"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required
                                    onchange="toggleContentInput()">
                                <option value="">Pilih Tipe</option>
                                <option value="article" {{ old('tipe', $material->tipe) == 'article' ? 'selected' : '' }}>Article</option>
                                <option value="video" {{ old('tipe', $material->tipe) == 'video' ? 'selected' : '' }}>Video</option>
                                <option value="pdf" {{ old('tipe', $material->tipe) == 'pdf' ? 'selected' : '' }}>PDF</option>
                                <option value="audio" {{ old('tipe', $material->tipe) == 'audio' ? 'selected' : '' }}>Audio</option>
                                <option value="image" {{ old('tipe', $material->tipe) == 'image' ? 'selected' : '' }}>Image</option>
                            </select>
                            @error('tipe')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- File Upload (for non-article) -->
                        <div id="file-input" class="mb-6" style="{{ old('tipe', $material->tipe) == 'article' ? 'display: none;' : '' }}">
                            <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Upload File') }}
                            </label>
                            @if($material->tipe != 'article' && $material->file_url)
                                <div class="mb-3 p-3 bg-gray-100 rounded-lg">
                                    <p class="text-sm text-gray-700">File saat ini:</p>
                                    <a href="{{ Storage::url($material->file_url) }}" 
                                       target="_blank" 
                                       class="text-blue-600 hover:text-blue-800 text-sm">
                                        {{ basename($material->file_url) }}
                                    </a>
                                </div>
                            @endif
                            <input type="file" 
                                   name="file" 
                                   id="file"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="text-sm text-gray-600 mt-1">Kosongkan jika tidak ingin mengubah file</p>
                            @error('file')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Article Content (for article) -->
                        <div id="content-input" class="mb-6" style="{{ old('tipe', $material->tipe) != 'article' ? 'display: none;' : '' }}">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Content (HTML)') }}
                            </label>
                            <textarea name="content" 
                                      id="content" 
                                      rows="10"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('content', $material->tipe == 'article' ? $material->file_url : '') }}</textarea>
                            <p class="text-sm text-gray-600 mt-1">Gunakan HTML tags untuk formatting</p>
                            @error('content')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status (admin only) -->
                        @if(auth()->user()->isAdmin())
                            <div class="mb-6">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Status') }}
                                </label>
                                <select name="status" 
                                        id="status"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="pending" {{ old('status', $material->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ old('status', $material->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <div class="flex items-center justify-between">
                            <a href="{{ route('materials.show', $material) }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                                {{ __('Batal') }}
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                                {{ __('Update Material') }}
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
</x-app-layout> 