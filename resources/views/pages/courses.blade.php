<style>
    select option {
        background: #1e293b;
        color: white;
    }

    select:focus {
        outline: none;
        ring: 2px;
        ring-color: #3b82f6;
    }
</style>
<x-layouts.auth :title="'Courses'">
    <div class="min-h-screen flex flex-col bg-gradient-to-b from-dark-900 to-dark-800 text-white">

        {{-- Header --}}
        <x-home.header />

        {{-- Main Content --}}
        <main class="flex-grow py-12 px-4 lg:px-8">
            {{-- Flash Message Component --}}
            <x-flash-message />
            {{-- Filter Section --}}
            <div class="max-w-6xl mx-auto mb-8">
                <form method="GET" action="{{ route('courses.index') }}" class="bg-dark-800 rounded-lg p-6">
                    <div class="flex flex-col lg:flex-row gap-6 items-end">
                        <!-- Category Filter -->
                        <div class="flex-1">
                            <label for="slug" class="block text-sm font-medium text-gray-300 mb-2">Category</label>
                            <div class="relative">
                                <select name="slug" id="slug"
                                    class="w-full bg-dark-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none cursor-pointer">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->slug }}" {{ request('slug') == $category->slug ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Free/Paid Filter -->
                        <div class="flex-1">
                            <label for="is_free" class="block text-sm font-medium text-gray-300 mb-2">Price Type</label>
                            <div class="relative">
                                <select name="is_free" id="is_free"
                                    class="w-full bg-dark-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none cursor-pointer">
                                    <option value="">All Courses</option>
                                    <option value="1" {{ request('is_free') === '1' ? 'selected' : '' }}>Free Courses
                                    </option>
                                    <option value="0" {{ request('is_free') === '0' ? 'selected' : '' }}>Paid Courses
                                    </option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-3">
                            <button type="submit"
                                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition flex items-center gap-2">
                                <i class="fas fa-filter"></i>
                                Apply Filters
                            </button>

                            <a href="{{ route('courses.index') }}"
                                class="px-6 py-3 bg-dark-700 hover:bg-dark-600 border border-gray-600 text-gray-300 font-semibold rounded-lg transition flex items-center gap-2">
                                <i class="fas fa-refresh"></i>
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            {{-- Featured Courses --}}
            <h2 class="text-2xl font-bold text-white text-center mb-10"></h2>
            <div class="max-w-6xl mx-auto space-y-6">
                @foreach ($courses as $course)
                    <div class="bg-dark-800 rounded-lg p-6 flex gap-6 hover:bg-dark-700 transition cursor-pointer">
                        <!-- Thumbnail -->
                        <div class="w-64 h-36 bg-gray-700 rounded-lg overflow-hidden flex-shrink-0">
                            @if($course->thumbnail)
                                <a href="{{ route('courses.show', $course) }}">
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->name }}"
                                        class="w-full h-full object-cover">
                                </a>
                            @else
                                <div
                                    class="w-full h-full bg-gradient-to-r from-blue-600 to-indigo-700 flex items-center justify-center">
                                    <i class="fas fa-image text-white text-2xl"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Course Content -->
                        <div class="flex-grow">
                            <a href="{{ route('courses.show', $course) }}">
                                <h3 class="text-xl font-bold text-white mb-2">{{ $course->name }}</h3>
                                </a>
                            <p class="text-gray-300 mb-3">{{ Str::limit($course->description, 120) }}</p>

                            <div class="flex items-center text-sm text-gray-400 mb-3">
                                <span class="text-yellow-400 font-semibold">4.7 ★★★</span>
                                <span class="mx-2">•</span>
                                <span>{{ $course->capitalized_instructor }}</span>
                            </div>

                            <div class="flex items-center text-sm text-gray-400">
                                <span>{{ $course->lessons_count }} lessons • {{ $course->level->label() }}</span>
                            </div>
                        </div>

                        <!-- Price & Badge -->
                        <div class="text-right flex-shrink-0">
                            <div class="mb-2">
                                <span class="text-2xl font-bold text-white">{{ $course->formatted_price }}</span>
                                @if(!$course->is_free)
                                    <span class="line-through text-gray-400 text-sm ml-2">$119.99</span>
                                @endif
                            </div>
                            <span class="bg-yellow-500 text-slate-900 text-xs font-bold px-2 py-1 rounded-full">
                                Bestseller
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pagination">
                {{ $courses->links() }}
            </div>
        </main>
        {{-- Footer --}}
        <x-home.footer />

    </div>
</x-layouts.auth>