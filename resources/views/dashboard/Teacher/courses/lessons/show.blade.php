<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $lesson->title }} - E-Learning Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        dark: {
                            900: '#0f172a',
                            800: '#1e293b',
                            700: '#334155',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            color: #f1f5f9;
        }

        .bg-dark-800 {
            background-color: #1e293b;
        }

        .lesson-content {
            line-height: 1.8;
        }

        .lesson-content h1,
        .lesson-content h2,
        .lesson-content h3 {
            margin-top: 1.5em;
            margin-bottom: 0.5em;
            font-weight: 600;
        }

        .lesson-content p {
            margin-bottom: 1em;
        }

        .lesson-content ul,
        .lesson-content ol {
            margin-left: 1.5em;
            margin-bottom: 1em;
        }

        .attachment-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .attachment-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body class="antialiased text-gray-100">
    <x-home.header />

    <main class="py-8">
        <div class="container mx-auto px-4">
            <!-- Breadcrumb -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-400 hover:text-white">
                            <i class="fas fa-home mr-2"></i>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-500 mx-2"></i>
                            <a href="{{ route('courses.index') }}"
                                class="ml-1 text-sm font-medium text-gray-400 hover:text-white md:ml-2">Courses</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-500 mx-2"></i>
                            <a href="{{ route('courses.show', $course) }}"
                                class="ml-1 text-sm font-medium text-gray-400 hover:text-white md:ml-2">{{ $course->name }}</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-500 mx-2"></i>
                            <span class="ml-1 text-sm font-medium text-gray-200 md:ml-2">{{ $lesson->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left Content - Lesson Details -->
                <div class="lg:w-2/3 space-y-8">
                    <!-- Lesson Header -->
                    <div class="bg-dark-800 rounded-lg p-6">
                        <span
                            class="inline-block bg-indigo-900 text-indigo-200 text-sm font-medium px-3 py-1 rounded-full mb-4">
                            {{ $course->category->name }}
                        </span>
                        <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $lesson->title }}</h1>

                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400 mb-6">
                            <div class="flex items-center">
                                <i class="fas fa-book-open mr-2"></i>
                                <span>Lesson {{ $lesson->order + 1 }} of {{ $section->lessons_count }} in
                                    {{ $section->title }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-2"></i>
                                {{-- <span>Last updated {{ $lesson->updated_at->diffForHumans() }}</span> --}}
                            </div>
                        </div>
                        <!-- Lesson Content -->
                        <div class="lesson-content text-gray-300">
                            {!! nl2br(e($lesson->content)) !!}
                        </div>
                    </div>

                    @if($lesson->attachments_count > 0)
                        <div class="bg-dark-800 rounded-lg p-6">
                            <h2 class="text-2xl font-bold mb-6">Lesson Attachments</h2>
                            <div class="space-y-6">
                                @foreach($lesson->attachments as $attachment)
                                    <div class="attachment-card bg-dark-700 rounded-lg p-4 border border-gray-600">
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="flex items-center">
                                                @if($attachment->type === \App\Enums\LessonType::VIDEO)
                                                    <i class="fas fa-video text-red-400 text-xl mr-3"></i>
                                                @elseif($attachment->type === \App\Enums\LessonType::PDF)
                                                    <i class="fas fa-file-pdf text-red-400 text-xl mr-3"></i>
                                                @else
                                                    <i class="fas fa-file text-blue-400 text-xl mr-3"></i>
                                                @endif
                                                <div>
                                                    <h3 class="font-semibold text-lg">{{ $attachment->name }}</h3>
                                                    <p class="text-sm text-gray-400">
                                                        {{ number_format($attachment->size / 1024, 1) }} KB
                                                    </p>
                                                </div>
                                            </div>
                                            <a href="{{ asset('storage/' . $attachment->url) }}"
                                                download="{{ $attachment->name }}"
                                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded transition">
                                                <i class="fas fa-download mr-2"></i>Download
                                            </a>
                                        </div>

                                        <!-- Video Player for Video Attachments -->
                                        @if($attachment->type === \App\Enums\LessonType::VIDEO)
                                            <div class="mt-4">
                                                <div class="bg-black rounded-lg overflow-hidden">
                                                    <video controls class="w-full rounded-lg" preload="metadata">
                                                        <source src="{{ asset('storage/' . $attachment->url) }}" type="video/mp4">
                                                        <source src="{{ asset('storage/' . $attachment->url) }}" type="video/webm">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </div>
                                                <div class="mt-2 text-sm text-gray-400 flex justify-between">
                                                    <span>Click to play/pause • Double-click for fullscreen</span>
                                                    <span>Use arrow keys to seek</span>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- PDF Preview Link -->
                                        @if($attachment->type === \App\Enums\LessonType::PDF)
                                            <div class="mt-3">
                                                <a href="{{ asset('storage/' . $attachment->url) }}" target="_blank"
                                                    class="inline-flex items-center text-indigo-400 hover:text-indigo-300 transition">
                                                    <i class="fas fa-external-link-alt mr-2"></i>
                                                    Open PDF in new tab
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Navigation Between Lessons -->
                    <div class="bg-dark-800 rounded-lg p-6">
                        <div class="flex justify-between items-center">
                            @php
                                $prevLesson = $section->lessons->where('order', '<', $lesson->order)->sortByDesc('order')->first();
                                $nextLesson = $section->lessons->where('order', '>', $lesson->order)->sortBy('order')->first();
                            @endphp

                            @if($prevLesson)
                                <a href="{{ route('lessons.show', ['course' => $course, 'section' => $section, 'lesson' => $prevLesson]) }}"
                                    class="flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg transition">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Previous Lesson
                                </a>
                            @else
                                <div></div>
                            @endif

                            @if($nextLesson)
                                <a href="{{ route('lessons.show', ['course' => $course, 'section' => $section, 'lesson' => $nextLesson]) }}"
                                    class="flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg transition">
                                    Next Lesson
                                    <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar - Course Progress & Navigation -->
                <div class="lg:w-1/3">
                    <div class="sticky top-24 space-y-6">
                        <!-- Course Card -->
                        <div class="course-card bg-dark-800 rounded-xl overflow-hidden shadow-lg">
                            <div class="h-32 bg-gray-700 relative overflow-hidden">
                                @if($course->thumbnail)
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Thumbnail"
                                        class="w-full h-full object-cover">
                                @else
                                    <div
                                        class="w-full h-full bg-gradient-to-r from-blue-600 to-indigo-700 flex items-center justify-center">
                                        <i class="fas fa-image text-white text-2xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-lg mb-2">{{ $course->name }}</h3>
                                <p class="text-sm text-gray-400 mb-4">{{ $course->description }}</p>
                                <a href="{{ route('courses.show', $course) }}"
                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-center font-semibold py-2 px-4 rounded-lg transition block">
                                    Back to Course
                                </a>
                            </div>
                        </div>

                        <!-- Course Navigation -->
                        <div class="bg-dark-800 rounded-lg p-4">
                            <h3 class="font-bold text-lg mb-4">Course Content</h3>
                            <div class="space-y-2 max-h-96 overflow-y-auto">
                                @foreach($course->sections as $courseSection)
                                    <div class="border-b border-gray-700 pb-2">
                                        <h4 class="font-semibold text-gray-300 mb-2">{{ $courseSection->title }}</h4>
                                        <div class="space-y-1">
                                            @foreach($courseSection->lessons as $courseLesson)
                                                <a href="{{ route('lessons.show', ['course' => $course, 'section' => $section, 'lesson' => $courseLesson]) }}"
                                                    class="flex items-center text-sm py-1 px-2 rounded hover:bg-gray-700 transition {{ $lesson->id === $courseLesson->id ? 'bg-indigo-900 text-white' : 'text-gray-400' }}">
                                                    <i class="far fa-play-circle mr-2 text-xs"></i>
                                                    <span class="truncate">{{ $courseLesson->title }}</span>
                                                    @if($lesson->id === $courseLesson->id)
                                                        <i class="fas fa-play ml-auto text-xs"></i>
                                                    @endif
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
              <!-- Comments Section -->
                    <div class="bg-dark-800 rounded-lg p-6 mt-8">
                        <h2 class="text-2xl font-bold mb-6">Comments</h2>

                        @php
                            $isEnrolled = $course->relationLoaded('enrollments') 
                                ? $course->enrollments->contains('user_id', auth()->id())
                                : auth()->user()->enrolledCourses->contains($course);
                        @endphp

                        @if($isEnrolled || $course->teacher()->is(auth()->user()))
                            @include('partials.comment-form', [
                                'routeName' => 'courses.comments.store',
                                'model' => $course
                            ])
                        @else
                            <p class="text-gray-400 mb-4">You must be enrolled in the course or be the course owner to post a comment.</p>
                        @endif
                        
                        <div class="space-y-4">
                            @foreach($course->comments->where('parent_comment_id', null) as $comment)
                                @include('partials.comment', [
                                    'comment' => $comment,
                                    'routeName' => 'courses.comments.store', 
                                    'model' => $course
                                ])
                            @endforeach
                        </div>
                    </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark-900 border-t border-slate-700 py-12 mt-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">E-Learning Platform</h3>
                    <p class="text-slate-400">Learn from industry experts and enhance your skills with our wide range of
                        courses.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-slate-400 hover:text-white transition">Home</a>
                        </li>
                        <li><a href="{{ route('courses.index') }}"
                                class="text-slate-400 hover:text-white transition">Courses</a></li>
                        <li><a href="{{ route('about') }}" class="text-slate-400 hover:text-white transition">About
                                Us</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-700 mt-8 pt-8 text-center text-slate-500">
                <p>&copy; 2023 E-Learning Platform. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>