<x-layouts.auth :title="'My Reviews'">
    <div class="min-h-screen flex flex-col bg-gradient-to-b from-dark-900 to-dark-800 text-white">
        {{-- Header --}}
        <x-home.header />

        {{-- Main Content --}}
        <main class="flex-grow py-12 px-4 lg:px-8 max-w-7xl mx-auto w-full">
            {{-- Flash Message Component --}}
            <x-flash-message />

            {{-- Page Header --}}
            <div class="mb-10">
                <h1 class="text-3xl md:text-4xl font-bold mb-3">My Reviews</h1>
                <p class="text-slate-400">Manage and edit your course reviews here</p>

                <div class="mt-6 flex items-center gap-4">
                    <a href="{{ route('home') }}" class="text-blue-400 hover:text-blue-300 flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i> Back to Home
                    </a>
                    <span class="text-slate-600">|</span>
                    <span class="text-slate-400">
                        {{ $reviews_count }}
                    </span>
                </div>
            </div>

            {{-- Reviews List --}}
            @if($reviews_count > 0)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($reviews as $review)
                        <div
                            class="bg-dark-800 rounded-xl p-6 border border-dark-700 hover:border-blue-500/30 transition-all duration-300">
                            {{-- Course Info --}}
                            <div class="mb-4 pb-4 border-b border-dark-700">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <a href="{{ route('courses.show', $review->course) }}"
                                            class="text-lg font-semibold text-white hover:text-blue-400 transition">
                                            {{ $review->course->name }}
                                        </a>
                                        <p class="text-sm text-slate-400 mt-1">
                                            {{ $review->course->capitalized_instructor }}
                                        </p>
                                    </div>
                                    <span class="px-3 py-1 bg-blue-500/10 text-blue-400 text-xs font-medium rounded-full">
                                        {{ $review->course->category->name }}
                                    </span>
                                </div>
                            </div>

                            {{-- Review Content --}}
                            <div class="mb-4">
                                {{-- Rating --}}
                                <div class="flex items-center mb-3">
                                    <div class="flex text-yellow-400 mr-3">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i
                                                class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-600' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="text-sm text-slate-400">
                                        {{ $review->created_at->format('M d, Y') }}
                                    </span>
                                </div>

                                {{-- Review Text --}}
                                <p class="text-slate-300 leading-relaxed">
                                    {{ $review->review }}
                                </p>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center justify-between pt-4 border-t border-dark-700">
                                <div class="text-sm text-slate-500">
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ $review->created_at->diffForHumans() }}
                                </div>

                                <div class="flex gap-3">
                                    {{-- Edit Button --}}
                                    <a href="{{ route('reviews.edit', $review) }}"
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition flex items-center gap-2">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </a>

                                    {{-- Delete Form --}}
                                    <form action="{{ route('reviews.destroy', $review) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this review?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-600/20 hover:bg-red-600/30 text-red-400 hover:text-red-300 text-sm font-medium rounded-lg transition flex items-center gap-2 border border-red-600/30">
                                            <i class="fas fa-trash"></i>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-10">
                    {{ $reviews->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-16">
                    <div class="mx-auto w-24 h-24 bg-dark-700 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-comment-slash text-3xl text-slate-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-300 mb-3">No reviews yet</h3>
                    <p class="text-slate-500 mb-8 max-w-md mx-auto">
                        You haven't reviewed any courses yet. Go explore courses and share your thoughts!
                    </p>
                    <a href="{{ route('courses.index') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                        <i class="fas fa-search"></i>
                        Browse Courses
                    </a>
                </div>
            @endif
        </main>

        {{-- Footer --}}
        <x-home.footer />
    </div>
</x-layouts.auth>