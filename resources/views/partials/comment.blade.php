<div class="bg-dark-700 rounded-lg p-4 mb-4">
    <div class="flex justify-between items-start mb-2">
        <div class="flex items-center">
            <img src="{{ asset('storage/' . $comment->user->profile->avatar) }}" 
                 class="w-8 h-8 rounded-full mr-3">
            <span class="font-semibold">{{ $comment->user->name }}</span>
        </div>
        <div class="flex items-center space-x-2">
            <span class="text-sm text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
            
            {{-- Edit/Delete buttons for comment owner or course owner --}}
            @if(auth()->id() === $comment->user_id || auth()->id() === $course->user_id)
                <div class="flex space-x-1 ml-2">
                    {{-- Edit Button --}}
                    <button onclick="toggleEditForm({{ $comment->id }})" 
                            class="text-blue-400 hover:text-blue-300 transition text-sm">
                        <i class="fas fa-edit"></i>
                    </button>
                    
                    {{-- Delete Button --}}
                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this comment?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-300 transition text-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    {{-- Display comment content --}}
    <div id="comment-content-{{ $comment->id }}">
        <p class="text-gray-300 mb-3">{{ $comment->comment }}</p>
    </div>

    {{-- Edit Form (hidden by default) --}}
    <div id="edit-form-{{ $comment->id }}" class="hidden mb-3">
        <form action="{{ route('comments.update', $comment) }}" method="POST">
            @csrf
            @method('PUT')
            <textarea name="comment" rows="3"
                class="w-full bg-dark-800 border border-gray-600 rounded p-2 text-gray-300 placeholder-gray-500"
                required>{{ $comment->comment }}</textarea>
            <div class="flex space-x-2 mt-2">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition">
                    Update
                </button>
                <button type="button" onclick="toggleEditForm({{ $comment->id }})" 
                        class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm transition">
                    Cancel
                </button>
            </div>
        </form>
    </div>
    
    {{-- Reply Button --}}
    <button onclick="toggleReplyForm({{ $comment->id }})" 
            class="text-sm text-indigo-400 hover:text-indigo-300 transition">
        <i class="fas fa-reply mr-1"></i>Reply
    </button>

    {{-- Reply Form --}}
    <div id="replyForm-{{ $comment->id }}" class="mt-3 hidden">
        @include('partials.comment-form', [
            'routeName' => $routeName,
            'model' => $model,
            'parentComment' => $comment
        ])
    </div>

    {{-- Replies Section --}}
    @if($comment->replies && $comment->replies->isNotEmpty())
        <div class="ml-6 mt-3 space-y-3 border-l-2 border-gray-600 pl-4">
            @foreach($comment->replies as $reply)
                {{-- Include the same partial for replies --}}
                <div class="bg-dark-600 rounded-lg p-3">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('storage/' . $reply->user->profile->avatar) }}" 
                                 class="w-6 h-6 rounded-full mr-2">
                            <span class="font-semibold text-sm">{{ $reply->user->name }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-xs text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                            
                            {{-- Edit/Delete buttons for reply owner or course owner --}}
                            @if(auth()->id() === $reply->user_id || auth()->id() === $course->user_id)
                                <div class="flex space-x-1 ml-2">
                                    {{-- Edit Button for Reply --}}
                                    <button onclick="toggleEditForm({{ $reply->id }})" 
                                            class="text-blue-400 hover:text-blue-300 transition text-xs">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    {{-- Delete Button for Reply --}}
                                    <form action="{{ route('comments.destroy', $reply) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this reply?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 transition text-xs">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Display reply content --}}
                    <div id="comment-content-{{ $reply->id }}">
                        <p class="text-gray-300 text-sm">{{ $reply->comment }}</p>
                    </div>

                    {{-- Edit Form for Reply (hidden by default) --}}
                    <div id="edit-form-{{ $reply->id }}" class="hidden mt-2">
                        <form action="{{ route('comments.update', $reply) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <textarea name="comment" rows="2"
                                class="w-full bg-dark-700 border border-gray-600 rounded p-2 text-gray-300 placeholder-gray-500 text-sm"
                                required>{{ $reply->comment }}</textarea>
                            <div class="flex space-x-2 mt-1">
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded text-xs transition">
                                    Update
                                </button>
                                <button type="button" onclick="toggleEditForm({{ $reply->id }})" 
                                        class="bg-gray-600 hover:bg-gray-700 text-white px-2 py-1 rounded text-xs transition">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
function toggleReplyForm(commentId) {
    const form = document.getElementById('replyForm-' + commentId);
    form.classList.toggle('hidden');
}

function toggleEditForm(commentId) {
    const content = document.getElementById('comment-content-' + commentId);
    const form = document.getElementById('edit-form-' + commentId);
    
    content.classList.toggle('hidden');
    form.classList.toggle('hidden');
}
</script>