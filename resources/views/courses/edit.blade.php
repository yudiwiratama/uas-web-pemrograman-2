<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('courses.update', $course) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- Judul -->
                        <div class="mb-6">
                            <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Judul Course') }}
                            </label>
                            <input type="text" 
                                   name="judul" 
                                   id="judul" 
                                   value="{{ old('judul', $course->judul) }}"
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
                                      rows="5"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      required>{{ old('deskripsi', $course->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="mb-6">
                            <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Kategori') }}
                            </label>
                            <select name="kategori" 
                                    id="kategori"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih Kategori</option>
                                <option value="Pemrograman" {{ old('kategori', $course->kategori) == 'Pemrograman' ? 'selected' : '' }}>Pemrograman</option>
                                <option value="Design" {{ old('kategori', $course->kategori) == 'Design' ? 'selected' : '' }}>Design</option>
                                <option value="Marketing" {{ old('kategori', $course->kategori) == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                <option value="Business" {{ old('kategori', $course->kategori) == 'Business' ? 'selected' : '' }}>Business</option>
                                <option value="Data Science" {{ old('kategori', $course->kategori) == 'Data Science' ? 'selected' : '' }}>Data Science</option>
                                <option value="Lainnya" {{ old('kategori', $course->kategori) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('kategori')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Thumbnail -->
                        <div class="mb-6">
                            <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Thumbnail') }}
                            </label>
                            @if($course->thumbnail)
                                <div class="mb-3">
                                    <img src="{{ Storage::url($course->thumbnail) }}" 
                                         alt="Current thumbnail" 
                                         class="w-32 h-24 object-cover rounded-lg">
                                    <p class="text-sm text-gray-600 mt-1">Thumbnail saat ini</p>
                                </div>
                            @endif
                            <input type="file" 
                                   name="thumbnail" 
                                   id="thumbnail"
                                   accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="text-sm text-gray-600 mt-1">Kosongkan jika tidak ingin mengubah thumbnail</p>
                            @error('thumbnail')
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
                                    <option value="pending" {{ old('status', $course->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ old('status', $course->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <div class="flex items-center justify-between">
                            <a href="{{ route('courses.show', $course) }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                                {{ __('Batal') }}
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                                {{ __('Update Course') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 