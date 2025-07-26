<div class="comment">
    <div class="flex space-x-3">
        <div class="flex-shrink-0">
            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                <span class="text-white text-sm font-medium">{{ substr($comment->user->name, 0, 1) }}</span>
            </div>
        </div>
        <div class="flex-1">
            <div class="bg-gray-50 rounded-lg px-4 py-3">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="font-medium text-gray-900">{{ $comment->user->name }}</span>
                            <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-700">{{ $comment->body }}</p>
                    </div>
                    @can('update', $comment)
                        <div class="ml-2">
                            <button onclick="toggleEditComment({{ $comment->id }})" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                        </div>
                    @endcan
                </div>
            </div>

            <!-- Edit Comment Form (Hidden by default) -->
            @can('update', $comment)
                <div id="edit-comment-{{ $comment->id }}" class="hidden mt-3">
                    <form action="{{ route('comments.update', $comment) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <textarea name="body" rows="2" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>{{ $comment->body }}</textarea>
                        <div class="mt-2 flex space-x-2">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-1 px-3 rounded">
                                Update
                            </button>
                            <button type="button" onclick="toggleEditComment({{ $comment->id }})" class="bg-gray-500 hover:bg-gray-700 text-white text-sm font-bold py-1 px-3 rounded">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            @endcan

            <!-- Reply Actions -->
            @auth
                <div class="mt-3 flex items-center space-x-4 text-sm">
                    <button onclick="toggleReplyForm({{ $comment->id }})" class="text-gray-500 hover:text-gray-700 font-medium">
                        Reply
                    </button>
                    @can('delete', $comment)
                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 font-medium">
                                Delete
                            </button>
                        </form>
                    @endcan
                </div>

                <!-- Reply Form (Hidden by default) -->
                <div id="reply-form-{{ $comment->id }}" class="hidden mt-3">
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="material_id" value="{{ $material->id }}">
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <textarea name="body" rows="2" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Write a reply..." required></textarea>
                        <div class="mt-2 flex space-x-2">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-1 px-3 rounded">
                                Reply
                            </button>
                            <button type="button" onclick="toggleReplyForm({{ $comment->id }})" class="bg-gray-500 hover:bg-gray-700 text-white text-sm font-bold py-1 px-3 rounded">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            @endauth

            <!-- Nested Replies -->
            @if($comment->children->count() > 0)
                <div class="mt-4 ml-4 space-y-4">
                    @foreach($comment->children as $reply)
                        @include('partials.comment', ['comment' => $reply, 'material' => $material])
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function toggleReplyForm(commentId) {
    const form = document.getElementById('reply-form-' + commentId);
    form.classList.toggle('hidden');
}

function toggleEditComment(commentId) {
    const form = document.getElementById('edit-comment-' + commentId);
    form.classList.toggle('hidden');
}
</script> 