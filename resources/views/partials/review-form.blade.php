<div class="bg-dark-700 rounded-lg p-4 mb-6">
    <h3 class="text-lg font-semibold mb-3">Write a Review</h3>
    <form action="{{ route('reviews.store', $course) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Rating</label>
            <div class="flex space-x-1">
                @for($i = 1; $i <= 5; $i++)
                    <button type="button" onclick="setRating({{ $i }})" class="text-2xl">
                        <i class="far fa-star rating-star" data-rating="{{ $i }}"></i>
                    </button>
                @endfor
            </div>
            <input type="hidden" name="rating" id="rating" value="0" required>
        </div>
        <div class="mb-4">
            <textarea name="review" rows="3"
                class="w-full bg-dark-800 border border-gray-600 rounded p-2 text-gray-300 placeholder-gray-500"
                placeholder="Share your experience..." required></textarea>
        </div>
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded transition">
            Submit Review
        </button>
    </form>
</div>

<script>
    function setRating(rating) {
        document.getElementById('rating').value = rating;
        document.querySelectorAll('.rating-star').forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('far');
                star.classList.add('fas');
            } else {
                star.classList.remove('fas');
                star.classList.add('far');
            }
        });
    }
</script>