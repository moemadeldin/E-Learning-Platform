<x-layouts.auth :title="'Home'">


    <div class="min-h-screen flex flex-col bg-gradient-to-b from-dark-900 to-dark-800 text-white">

        {{-- Use the same header component that includes the cart icon --}}
        <x-home.header />

        {{-- Main Content --}}
        <main class="flex-grow py-12 px-4 lg:px-8">
            {{-- Flash Message Component --}}
            <x-flash-message />

            {{-- Hero Section --}}
            <section class="text-center mb-16">
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Welcome, {{ Auth::user()->name ?? 'Guest' }}!</h1>
                <p class="text-lg text-slate-400 max-w-2xl mx-auto">
                    Discover a wide range of courses taught by industry experts. Start your learning journey today.
                </p>
            </section>

            {{-- Categories --}}
            <div class="mb-20">
                <h2 class="text-2xl font-bold mb-6 text-center">Popular Categories</h2>
                <div class="flex flex-wrap justify-center gap-3">
                    @foreach ($categories as $category)
                        <a href="{{ route('courses.index', ['slug' => $category->slug]) }}">
                            <button
                                class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-blue-400 rounded-full flex items-center cursor-pointer">
                                <i class="fas fa-laptop-code mr-2"></i> {{ $category->name }}
                            </button>
                        </a>
                    @endforeach
                </div>
                {{-- Featured Courses --}}
                <h2 class="text-2xl font-bold text-white text-center mb-10">Featured Courses</h2>
                <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($courses as $course)
                        <x-home.hero.course-card category="{{ $course->category->name }}"
                            courseThumbnail="{{ asset('storage/' . $course->thumbnail) }}" badgeText="Best Seller"
                            title="{{ $course->capitalized_title }}" description="{{ $course->description }}"
                            lessons="{{ $course->lessons_count }}" levelText="{{ $course->level->label() }}"
                            levelColorFrom="blue-900" levelColorTo="blue-200" rating=""
                            instructorName="{{ $course->capitalized_instructor}}"
                            instructorImage="{{ asset('storage/' . $course->teacher->profile->avatar) }}"
                            price="{{ $course->formatted_price }}" courseUrl="{{ route('courses.show', $course) }}" />
                    @endforeach
                </section>
            </div>
        </main>

        {{-- Footer --}}
        <x-home.footer />
    </div>
</x-layouts.auth>