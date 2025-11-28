<x-layouts.auth :title="'Cart course'">
    <div class="min-h-screen flex flex-col bg-gradient-to-b from-dark-900 to-dark-800 text-white">

        {{-- Header --}}
        <x-home.header />
        {{-- Main Content --}}
        <main class="flex-grow py-12 px-4 lg:px-8">
            <div class="container mx-auto max-w-4xl">
                {{-- Page Header --}}
                <div class="text-center mb-12">
                    <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Cart course</h1>
                    <p class="text-lg text-slate-400 max-w-2xl mx-auto">
                        Review the selected course in your cart.
                    </p>
                </div>

                {{-- Cart course Details --}}
                <div class="bg-dark-800 rounded-xl p-6 shadow-lg">
                    <div class="flex flex-col md:flex-row gap-6">
                        {{-- Course Image --}}
                        <div class="flex-shrink-0">
                            <div class="w-40 h-24 rounded-lg overflow-hidden bg-gray-700">
                                @if($course->thumbnail)
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                        alt="{{ $course->name }}" class="w-full h-full object-cover">
                                @else
                                    <div
                                        class="w-full h-full bg-gradient-to-r from-blue-600 to-indigo-700 flex items-center justify-center">
                                        <i class="fas fa-image text-white text-2xl"></i>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Course Details --}}
                        <div class="flex-grow">
                            <div>
                                <span
                                    class="inline-block bg-indigo-900 text-indigo-200 text-sm font-medium px-3 py-1 rounded-full mb-2">
                                    {{ $course->category->name }}
                                </span>
                                <h3 class="text-xl font-bold text-white mb-2">
                                    {{ $course->capitalized_title }}
                                </h3>
                                <p class="text-gray-400 text-sm mb-3 line-clamp-2">
                                    {{ Str::limit($course->description, 120) }}
                                </p>
                            </div>

                            {{-- Course Stats --}}
                            <div class="flex items-center text-sm text-gray-400 space-x-4 mb-4">
                                <div class="flex items-center">
                                    <i class="fas fa-user-graduate mr-1"></i>
                                    <span>{{ $course->enrollments_count }} students</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-clock mr-1"></i>
                                    <span>{{ $course->lessons_count }} lessons</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-signal mr-1"></i>
                                    <span>{{ $course->level->label() }}</span>
                                </div>
                            </div>

                            {{-- Instructor --}}
                            <div class="flex items-center">
                                <img src="{{ asset('storage/' . $course->teacher->profile->avatar) }}"
                                    alt="Instructor" class="w-8 h-8 rounded-full mr-3">
                                <span class="text-gray-300 text-sm">
                                    {{ $course->capitalized_instructor }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex justify-between items-center mt-6 pt-6 border-t border-gray-700">

                        {{-- Remove course Form --}}
                        <form action="{{ route('carts.destroy', ['cart' => $cart, 'course' => $course]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-400 hover:text-red-300 transition flex items-center"
                                onclick="return confirm('Are you sure you want to remove this course from your cart?')">
                                <i class="fas fa-trash mr-2"></i>
                                Remove Course
                            </button>
                        </form>

                        {{-- View Course --}}
                        <a href="{{ route('courses.show', $course) }}"
                            class="text-indigo-400 hover:text-indigo-300 transition flex items-center">
                            <i class="fas fa-eye mr-2"></i>
                            View Course
                        </a>
                        <a href="{{ route('checkout') }}"
                            class="text-indigo-400 hover:text-indigo-300 transition flex items-center">
                            <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
                            Checkout
                        </a>
                    </div>
                </div>
            </div>
        </main>

        {{-- Footer --}}
        <x-home.footer />
    </div>
</x-layouts.auth>