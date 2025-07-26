<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Panel - Material Approvals') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($pendingMaterials->count() > 0)
                        <div class="space-y-6">
                            @foreach($pendingMaterials as $material)
                                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow duration-300">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mr-2">
                                                    {{ ucfirst($material->tipe) }}
                                                </span>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Pending Approval
                                                </span>
                                            </div>
                                            
                                            <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $material->judul }}</h3>
                                            
                                            <p class="text-sm text-gray-600 mb-2">
                                                <strong>Course:</strong> {{ $material->course->judul }}
                                            </p>
                                            
                                            @if($material->deskripsi)
                                                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($material->deskripsi, 200) }}</p>
                                            @endif
                                            
                                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                Submitted by {{ $material->user->name }}
                                                <span class="mx-2">•</span>
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $material->created_at->diffForHumans() }}
                                            </div>
                                            
                                            <div class="flex space-x-3">
                                                <a href="{{ route('approvals.show', $material) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                                    Review Material →
                                                </a>
                                            </div>
                                        </div>
                                        
                                        <div class="ml-6 flex flex-col space-y-2">
                                            <form action="{{ route('approvals.update', $material) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full" onclick="return confirm('Approve this material?')">
                                                    Approve
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('approvals.update', $material) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-full" onclick="return confirm('Reject this material?')">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-8">
                            {{ $pendingMaterials->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No pending materials</h3>
                            <p class="mt-1 text-sm text-gray-500">All materials have been reviewed!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 