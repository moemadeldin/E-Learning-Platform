<x-layouts.auth :title="'My Courses'">
    <div class="min-h-screen flex flex-col bg-gradient-to-b from-dark-900 to-dark-800 text-white">
        {{-- Header --}}
        <x-home.header />

        {{-- Main Content --}}
        <main class="flex-grow py-12 px-4 lg:px-8 max-w-7xl mx-auto w-full">
            {{-- Flash Message Component --}}
            <x-flash-message />

            {{-- Page Header --}}
            <div class="mb-10">
                <h1 class="text-3xl md:text-4xl font-bold mb-3">My Courses</h1>
                <p class="text-slate-400">
                    @if(auth()->user()->isTeacher())
                        Manage your teaching courses and learning progress
                    @else
                        Track your learning journey
                    @endif
                </p>

                <div class="mt-6">
                    <a href="{{ route('home') }}" class="text-blue-400 hover:text-blue-300 flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i> Back to Home
                    </a>
                </div>
            </div>

            {{-- For Teachers: Two Sections --}}
            @if(auth()->user()->isTeacher())
                {{-- Teaching Courses Section --}}
                <section class="mb-16">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-white mb-2">Teaching Courses</h2>
                            <p class="text-slate-400">Courses you're teaching</p>
                        </div>
                        
                        <a href="{{ route('dashboard.teacher.courses.create') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                            <i class="fas fa-plus"></i>
                            Create Course
                        </a>
                    </div>

                    @if($teachingCourses->count() > 0)
                        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($teachingCourses as $course)
                                <div class="bg-dark-800 rounded-xl overflow-hidden border border-dark-700 hover:border-blue-500/30 transition-all duration-300">
                                    {{-- Course Thumbnail --}}
                                    <div class="relative h-48 overflow-hidden">
                                        @if($course->thumbnail)
                                            <img src="{{ asset('storage/' . $course->thumbnail) }}" 
                                                 alt="{{ $course->name }}"
                                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-r from-blue-600 to-indigo-700 flex items-center justify-center">
                                                <i class="fas fa-graduation-cap text-white text-3xl"></i>
                                            </div>
                                        @endif

                                        {{-- Published/Draft Badge --}}
                                        <div class="absolute top-4 right-4">
                                            @if($course->is_published)
                                                <span class="px-3 py-1 bg-green-500/20 text-green-400 text-xs font-bold rounded-full border border-green-500/30">
                                                    Published
                                                </span>
                                            @else
                                                <span class="px-3 py-1 bg-yellow-500/20 text-yellow-400 text-xs font-bold rounded-full border border-yellow-500/30">
                                                    Draft
                                                </span>
                                            @endif
                                        </div>

                                        {{-- Category Badge --}}
                                        @if($course->category)
                                            <div class="absolute top-4 left-4">
                                                <span class="px-3 py-1 bg-dark-900/90 backdrop-blur-sm text-white text-xs font-medium rounded-full">
                                                    {{ $course->category->name }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Course Content --}}
                                    <div class="p-6">
                                        {{-- Course Title --}}
                                        <h3 class="text-lg font-bold text-white mb-2 line-clamp-1">
                                            <a href="{{ route('courses.show', $course) }}" class="hover:text-blue-400 transition">
                                                {{ $course->name }}
                                            </a>
                                        </h3>

                                        {{-- Course Description --}}
                                        <p class="text-slate-400 text-sm mb-4 line-clamp-2">
                                            {{ $course->description }}
                                        </p>

                                        {{-- Stats --}}
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center gap-4 text-sm text-slate-400">
                                                <span class="flex items-center gap-1">
                                                    <i class="fas fa-play-circle"></i>
                                                    <span>{{ $course->lessons_count }} lessons</span>
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <i class="fas fa-users"></i>
                                                    <span>{{ $course->enrollments_count }} students</span>
                                                </span>
                                            </div>
                                            <span class="px-3 py-1 bg-slate-700 text-slate-300 text-xs font-medium rounded-full">
                                                {{ $course->level->label() }}
                                            </span>
                                        </div>

                                        {{-- Action Buttons --}}
                                        <div class="flex gap-2">
                                            <a href="{{ route('courses.show', $course) }}"
                                               class="flex-1 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition flex items-center justify-center gap-2">
                                                <i class="fas fa-eye"></i>
                                                View
                                            </a>
                                            
                                            <a href="{{ route('courses.edit', $course) }}"
                                               class="flex-1 px-3 py-2 bg-dark-700 hover:bg-dark-600 text-white text-sm font-medium rounded-lg transition flex items-center justify-center gap-2 border border-dark-600">
                                                <i class="fas fa-edit"></i>
                                                Edit
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination for Teaching Courses --}}
                        @if($teachingCourses->hasPages())
                            <div class="mt-8">
                                {{ $teachingCourses->links() }}
                            </div>
                        @endif
                    @else
                        {{-- Empty Teaching Courses --}}
                        <div class="text-center py-12 bg-dark-800/50 rounded-xl border border-dashed border-dark-700">
                            <div class="mx-auto w-20 h-20 bg-dark-700 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-chalkboard-teacher text-2xl text-slate-600"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-slate-300 mb-2">No teaching courses yet</h3>
                            <p class="text-slate-500 mb-6">Start sharing your knowledge by creating a course</p>
                            <a href="{{ route('dashboard.teacher.courses.create') }}"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                                <i class="fas fa-plus"></i>
                                Create Your First Course
                            </a>
                        </div>
                    @endif
                </section>

                {{-- Enrolled Courses Section for Teachers --}}
                <section>
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-white mb-2">My Learning</h2>
                        <p class="text-slate-400">Courses you're enrolled in as a student</p>
                    </div>

                    @if($enrolledCourses->count() > 0)
                        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($enrolledCourses as $course)
                                <div class="bg-dark-800 rounded-xl overflow-hidden border border-dark-700 hover:border-blue-500/30 transition-all duration-300">
                                    {{-- Course Thumbnail --}}
                                    <div class="relative h-48 overflow-hidden">
                                        @if($course->thumbnail)
                                            <img src="{{ asset('storage/' . $course->thumbnail) }}" 
                                                 alt="{{ $course->name }}"
                                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-r from-blue-600 to-indigo-700 flex items-center justify-center">
                                                <i class="fas fa-graduation-cap text-white text-3xl"></i>
                                            </div>
                                        @endif

                                        {{-- Category Badge --}}
                                        @if($course->category)
                                            <div class="absolute top-4 left-4">
                                                <span class="px-3 py-1 bg-dark-900/90 backdrop-blur-sm text-white text-xs font-medium rounded-full">
                                                    {{ $course->category->name }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Course Content --}}
                                    <div class="p-6">
                                        {{-- Course Title --}}
                                        <h3 class="text-lg font-bold text-white mb-2 line-clamp-1">
                                            <a href="{{ route('courses.show', $course) }}" class="hover:text-blue-400 transition">
                                                {{ $course->name }}
                                            </a>
                                        </h3>

                                        {{-- Course Description --}}
                                        <p class="text-slate-400 text-sm mb-4 line-clamp-2">
                                            {{ $course->description }}
                                        </p>

                                        {{-- Instructor --}}
                                        <div class="flex items-center mb-4">
                                            @if($course->teacher && $course->teacher->profile && $course->teacher->profile->avatar)
                                                <img src="{{ asset('storage/' . $course->teacher->profile->avatar) }}" 
                                                     alt="{{ $course->teacher->name }}"
                                                     class="w-8 h-8 rounded-full mr-3">
                                            @else
                                                <div class="w-8 h-8 bg-slate-700 rounded-full flex items-center justify-center mr-3">
                                                    <i class="fas fa-user text-slate-400 text-sm"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="text-sm text-white">{{ $course->capitalized_instructor }}</p>
                                                <p class="text-xs text-slate-500">Instructor</p>
                                            </div>
                                        </div>

                                        {{-- Stats --}}
                                        <div class="flex items-center justify-between text-sm text-slate-400 mb-6">
                                            <div class="flex items-center gap-4">
                                                <span class="flex items-center gap-1">
                                                    <i class="fas fa-play-circle"></i>
                                                    <span>{{ $course->lessons_count }} lessons</span>
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <i class="fas fa-signal"></i>
                                                    <span>{{ $course->level->label() }}</span>
                                                </span>
                                            </div>
                                            <span class="text-lg font-bold text-white">
                                                {{ $course->formatted_price }}
                                            </span>
                                        </div>

                                        {{-- Action Buttons --}}
                                        <div class="flex gap-3">
                                            <a href="{{ route('courses.show', $course) }}"
                                               class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition flex items-center justify-center gap-2">
                                                <i class="fas fa-eye"></i>
                                                View Course
                                            </a>

                                            {{-- Review Button --}}
                                            @php
                                                $hasReviewed = auth()->user()->reviews()->where('course_id', $course->id)->exists();
                                            @endphp
                                            @if($hasReviewed)
                                                <a href="{{ route('reviews.edit', auth()->user()->reviews()->where('course_id', $course->id)->first()) }}"
                                                   class="px-4 py-2 bg-dark-700 hover:bg-dark-600 text-white font-medium rounded-lg transition flex items-center justify-center gap-2 border border-dark-600">
                                                    <i class="fas fa-star"></i>
                                                    Edit Review
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination for Enrolled Courses --}}
                        @if($enrolledCourses->hasPages())
                            <div class="mt-8">
                                {{ $enrolledCourses->links() }}
                            </div>
                        @endif
                    @else
                        {{-- Empty Enrolled Courses --}}
                        <div class="text-center py-12 bg-dark-800/50 rounded-xl border border-dashed border-dark-700">
                            <div class="mx-auto w-20 h-20 bg-dark-700 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-book-open text-2xl text-slate-600"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-slate-300 mb-2">No enrolled courses yet</h3>
                            <p class="text-slate-500 mb-6">Enroll in courses to start learning</p>
                            <a href="{{ route('courses.index') }}"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                                <i class="fas fa-search"></i>
                                Browse Courses
                            </a>
                        </div>
                    @endif
                </section>

            {{-- For Students: Single Section --}}
            @else
                <section>
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-white mb-2">My Learning</h2>
                        <p class="text-slate-400">Courses you're enrolled in</p>
                    </div>

                    @if($enrolledCourses->count() > 0)
                        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($enrolledCourses as $course)
                                <div class="bg-dark-800 rounded-xl overflow-hidden border border-dark-700 hover:border-blue-500/30 transition-all duration-300">
                                    {{-- Course Thumbnail --}}
                                    <div class="relative h-48 overflow-hidden">
                                        @if($course->thumbnail)
                                            <img src="{{ asset('storage/' . $course->thumbnail) }}" 
                                                 alt="{{ $course->name }}"
                                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-r from-blue-600 to-indigo-700 flex items-center justify-center">
                                                <i class="fas fa-graduation-cap text-white text-3xl"></i>
                                            </div>
                                        @endif

                                        {{-- Category Badge --}}
                                        @if($course->category)
                                            <div class="absolute top-4 left-4">
                                                <span class="px-3 py-1 bg-dark-900/90 backdrop-blur-sm text-white text-xs font-medium rounded-full">
                                                    {{ $course->category->name }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Course Content --}}
                                    <div class="p-6">
                                        {{-- Course Title --}}
                                        <h3 class="text-lg font-bold text-white mb-2 line-clamp-1">
                                            <a href="{{ route('courses.show', $course) }}" class="hover:text-blue-400 transition">
                                                {{ $course->name }}
                                            </a>
                                        </h3>

                                        {{-- Course Description --}}
                                        <p class="text-slate-400 text-sm mb-4 line-clamp-2">
                                            {{ $course->description }}
                                        </p>

                                        {{-- Instructor --}}
                                        <div class="flex items-center mb-4">
                                            @if($course->teacher && $course->teacher->profile && $course->teacher->profile->avatar)
                                                <img src="{{ asset('storage/' . $course->teacher->profile->avatar) }}" 
                                                     alt="{{ $course->teacher->name }}"
                                                     class="w-8 h-8 rounded-full mr-3">
                                            @else
                                                <div class="w-8 h-8 bg-slate-700 rounded-full flex items-center justify-center mr-3">
                                                    <i class="fas fa-user text-slate-400 text-sm"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="text-sm text-white">{{ $course->capitalized_instructor }}</p>
                                                <p class="text-xs text-slate-500">Instructor</p>
                                            </div>
                                        </div>

                                        {{-- Stats --}}
                                        <div class="flex items-center justify-between text-sm text-slate-400 mb-6">
                                            <div class="flex items-center gap-4">
                                                <span class="flex items-center gap-1">
                                                    <i class="fas fa-play-circle"></i>
                                                    <span>{{ $course->lessons_count }} lessons</span>
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <i class="fas fa-signal"></i>
                                                    <span>{{ $course->level->label() }}</span>
                                                </span>
                                            </div>
                                            <span class="text-lg font-bold text-white">
                                                {{ $course->formatted_price }}
                                            </span>
                                        </div>

                                        {{-- Action Buttons --}}
                                        <div class="flex gap-3">
                                            <a href="{{ route('courses.show', $course) }}"
                                               class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition flex items-center justify-center gap-2">
                                                <i class="fas fa-eye"></i>
                                                View Course
                                            </a>

                                            {{-- Review Button --}}
                                            @php
                                                $hasReviewed = auth()->user()->reviews()->where('course_id', $course->id)->exists();
                                            @endphp
                                            @if($hasReviewed)
                                                <a href="{{ route('reviews.edit', auth()->user()->reviews()->where('course_id', $course->id)->first()) }}"
                                                   class="px-4 py-2 bg-dark-700 hover:bg-dark-600 text-white font-medium rounded-lg transition flex items-center justify-center gap-2 border border-dark-600">
                                                    <i class="fas fa-star"></i>
                                                    Edit Review
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        @if($enrolledCourses->hasPages())
                            <div class="mt-10">
                                {{ $enrolledCourses->links() }}
                            </div>
                        @endif
                    @else
                        {{-- Empty State for Students --}}
                        <div class="text-center py-16">
                            <div class="mx-auto w-24 h-24 bg-dark-700 rounded-full flex items-center justify-center mb-6">
                                <i class="fas fa-book-open text-3xl text-slate-600"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-slate-300 mb-3">No courses enrolled yet</h3>
                            <p class="text-slate-500 mb-8 max-w-md mx-auto">
                                Start your learning journey by enrolling in courses that interest you.
                            </p>
                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                <a href="{{ route('courses.index') }}"
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                                    <i class="fas fa-search"></i>
                                    Browse Courses
                                </a>
                                <a href="{{ route('home') }}"
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-dark-700 hover:bg-dark-600 text-white font-medium rounded-lg transition border border-dark-600">
                                    <i class="fas fa-home"></i>
                                    Explore Homepage
                                </a>
                            </div>
                        </div>
                    @endif
                </section>
            @endif
        </main>

        {{-- Footer --}}
        <x-home.footer />
    </div>
</x-layouts.auth>