<x-layouts.auth :title="'Edit Review'">
    <div class="min-h-screen flex flex-col bg-gradient-to-b from-dark-900 to-dark-800 text-white">
        {{-- Header --}}
        <x-home.header />

        {{-- Main Content --}}
        <main class="flex-grow py-12 px-4 lg:px-8 max-w-4xl mx-auto w-full">
            {{-- Flash Message Component --}}
            <x-flash-message />

            {{-- Back Button --}}
            {{-- <div class="mb-8">
                <a href="{{ route('reviews.my-reviews') }}"
                    class="inline-flex items-center gap-2 text-blue-400 hover:text-blue-300 transition">
                    <i class="fas fa-arrow-left"></i>
                    Back to My Reviews
                </a>
            </div> --}}

            {{-- Page Header --}}
            <div class="mb-10">
                <h1 class="text-3xl md:text-4xl font-bold mb-3">Edit Review</h1>
                <p class="text-slate-400">Update your review for this course</p>
            </div>

            {{-- Course Card --}}
            <div class="bg-dark-800 rounded-xl p-6 mb-8 border border-dark-700">
                <div class="flex items-start gap-6">
                    {{-- Course Thumbnail --}}
                    <div class="w-32 h-20 rounded-lg overflow-hidden flex-shrink-0">
                        @if($course->thumbnail)
                            <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                alt="{{ $course->name }}" class="w-full h-full object-cover">
                        @else
                            <div
                                class="w-full h-full bg-gradient-to-r from-blue-600 to-indigo-700 flex items-center justify-center">
                                <i class="fas fa-graduation-cap text-white"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Course Info --}}
                    <div class="flex-grow">
                        <h3 class="text-xl font-semibold text-white mb-2">
                            {{ $course->name }}
                        </h3>
                        <p class="text-slate-400 text-sm mb-3">
                            by {{ $course->capitalized_instructor }}
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 bg-blue-500/10 text-blue-400 text-xs font-medium rounded-full">
                                {{ $course->category->name }}
                            </span>
                            <span class="px-3 py-1 bg-green-500/10 text-green-400 text-xs font-medium rounded-full">
                                {{ $course->level->label() }}
                            </span>
                            <span class="px-3 py-1 bg-yellow-500/10 text-yellow-400 text-xs font-medium rounded-full">
                                {{ $course->lessons_count }} lessons
                            </span>
                        </div>
                    </div>

                    {{-- Current Rating --}}
                    <div class="text-right">
                        <p class="text-sm text-slate-400 mb-2">Current Rating</p>
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                <i
                                    class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-600' }}"></i>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            {{-- Edit Review Form --}}
            <div class="bg-dark-800 rounded-xl p-8 border border-dark-700">
                <form action="{{ route('reviews.update', ['review' => $course]) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    {{-- Rating --}}
                    <div class="mb-8">
                        <label class="block text-lg font-medium text-white mb-4">
                            Update Your Rating
                        </label>
                        <div class="flex gap-2 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" onclick="setRating({{ $i }})"
                                    class="text-4xl transition-all duration-200 hover:scale-110">
                                    <i class="{{ $i <= old('rating', $review->rating) ? 'fas' : 'far' }} fa-star rating-star"
                                        data-rating="{{ $i }}" id="star-{{ $i }}"></i>
                                </button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating" value="{{ old('rating', $review->rating) }}"
                            required>

                        @error('rating')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Review Text --}}
                    <div class="mb-8">
                        <label for="review" class="block text-lg font-medium text-white mb-4">
                            Your Review
                        </label>
                        <textarea name="review" id="review" rows="6"
                            class="w-full bg-dark-700 border border-gray-600 rounded-xl p-4 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                            placeholder="Share your updated thoughts about this course..."
                            required>{{ old('review', $review->review) }}</textarea>

                        @error('review')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror

                        <div class="mt-2 text-sm text-slate-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Be honest and constructive in your feedback
                        </div>
                    </div>

                    {{-- Form Actions --}}
                    <div class="flex items-center justify-between pt-6 border-t border-dark-700">
                        <a href="{{ route('reviews.index') }}"
                            class="px-6 py-3 bg-dark-700 hover:bg-dark-600 text-slate-300 font-medium rounded-lg transition flex items-center gap-2">
                            Cancel
                        </a>

                        <div class="flex gap-4">
                            {{-- Delete Button --}}
                            <form action="{{ route('reviews.destroy', ['review' => $course]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                            <button type="button"
                                class="px-6 py-3 bg-red-600/20 hover:bg-red-600/30 text-red-400 font-medium rounded-lg transition flex items-center gap-2 border border-red-600/30">
                                <i class="fas fa-trash"></i>
                                Delete Review
                            </button>
                            </form>
                            <form action="{{ route('reviews.update', ['review' => $course]) }}" method="POST">
                                @csrf
                                @method('PATCH')
                            <button type="submit"
                                class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition flex items-center gap-2 shadow-lg shadow-blue-600/20">
                                <i class="fas fa-save"></i>
                                Update Review
                            </button>
                            </form>
                        </div>
                    </div>
                </form>
            </div>
        </main>

        {{-- Footer --}}
        <x-home.footer />
    </div>

    <script>
        // Rating stars functionality
        function setRating(rating) {
            document.getElementById('rating').value = rating;

            // Update star display
            for (let i = 1; i <= 5; i++) {
                const star = document.getElementById(`star-${i}`);
                if (i <= rating) {
                    star.classList.remove('far');
                    star.classList.add('fas');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('fas');
                    star.classList.add('far');
                    star.classList.remove('text-yellow-400');
                }
            }
        }

        // Initialize stars with current rating
        document.addEventListener('DOMContentLoaded', function () {
            const currentRating = {{ old('rating', $review->rating) }};
            setRating(currentRating);
        });

        // Delete confirmation
        function confirmDelete() {
            if (confirm('Are you sure you want to delete this review? This action cannot be undone.')) {
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
</x-layouts.auth>