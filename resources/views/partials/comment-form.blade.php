<div class="bg-dark-700 rounded-lg p-4 mb-6">
    <h3 class="text-lg font-semibold mb-3">Add a Comment</h3>
    <form action="{{ route($routeName, $model) }}" method="POST">
        @csrf
        @if(isset($parentComment))
            <input type="hidden" name="parent_comment_id" value="{{ $parentComment->id }}">
        @endif
        <textarea name="comment" rows="3"
            class="w-full bg-dark-800 border border-gray-600 rounded p-2 text-gray-300 placeholder-gray-500"
            placeholder="Write your comment..." required></textarea>
        <button type="submit" class="mt-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded transition">
            {{ isset($parentComment) ? 'Post Reply' : 'Post Comment' }}
        </button>
    </form>
</div>