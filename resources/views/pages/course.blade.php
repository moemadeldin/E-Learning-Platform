<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details - E-Learning Platform</title>
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

        .accordion-item {
            border-bottom: 1px solid #334155;
        }

        .accordion-header {
            cursor: pointer;
            padding: 1rem 0;
            transition: background-color 0.3s;
        }

        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
            padding-left: 1rem;
        }

        .accordion-content.show {
            max-height: 1000px;
        }

        .course-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
        }

        .bg-dark-800 {
            background-color: #1e293b;
        }

        .accordion-header i {
            transition: transform 0.3s;
        }

        .accordion-header i.rotate {
            transform: rotate(180deg);
        }

        /* Remove the old .active class */
        .accordion-content.active {
            max-height: 500px;
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
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-500 mx-2"></i>
                            <a href="{{ route('courses.index', ['slug' => $course->category->slug]) }}"
                                class="ml-1 text-sm font-medium text-gray-200 md:ml-2">{{ $course->category->name }}
                            </a>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left Content -->
                <div class="lg:w-2/3 space-y-8">
                    <!-- Category and Course Header -->
                    <div>
                        <span
                            class="inline-block bg-indigo-900 text-indigo-200 text-sm font-medium px-3 py-1 rounded-full mb-2">
                            {{ $course->category->name }}
                        </span>
                        <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $course->capitalized_title }}</h1>
                        <p class="text-lg text-gray-300 mb-6">{{ $course->description }}</p>

                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400">
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400 mr-1"></i>
                                <span> ({{ $course->reviews_count }} ratings)</span>
                            </div>
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
                            <div class="flex items-center">
                                <i class="fas fa-globe mr-1"></i>
                                <span>{{ $course->upper_case_language }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-calendar mr-1"></i>
                                <span>Last updated {{ $course->formatted_created_at }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Instructor Info -->
                    <div class="bg-dark-800 rounded-lg p-6 mb-8">
                        <h2 class="text-xl font-bold mb-4">Created by {{ $course->teacher->name }}</h2>
                        <div class="flex items-center">
                            <img src="{{ asset('/storage/' . $course->teacher->profile->avatar) }}" alt="Instructor"
                                class="w-16 h-16 rounded-full mr-4">
                            <div>
                                <h3 class="font-bold text-lg">{{ $course->capitalized_instructor }}</h3>
                                <p class="text-gray-400 mb-2">{{ $course->teacher->teacher->title }}</p>
                                <div class="flex items-center text-sm text-gray-400">
                                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                                    <span class="mr-4">{{ $course->teacher->teacher->avg_rating }} Instructor
                                        Rating</span>
                                    <i class="fas fa-user-graduate mr-1"></i>
                                    <span class="mr-4">{{ $course->teacher->teacher->reviews_count }} Reviews</span>
                                    <i class="fas fa-users mr-1"></i>
                                    <span>{{ $course->teacher->teacher->students_count }} Students</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Course Content Sections -->
                    <div class="bg-dark-800 rounded-lg p-6">
                        <h2 class="text-2xl font-bold mb-6">Course Content</h2>

                        <div class="mb-4 flex justify-between items-center">
                            <div>
                                <span class="text-gray-400">{{ $course->sections_count }} Sections •
                                    {{ $course->lessons_count }} lessons</span>
                            </div>
                            <button id="expandAll" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium">
                                Expand all sections
                            </button>
                        </div>

                        <div class="accordion">
                            @foreach ($course->sections as $section)
                                <div class="accordion-item">
                                    <div class="accordion-header flex justify-between items-center py-4 cursor-pointer">
                                        <div>
                                            <h3 class="font-semibold">{{ $section->title }}</h3>
                                            <p class="text-sm text-gray-400 mt-1">{{ $section->lessons_count }} Lessons
                                            </p>
                                        </div>
                                        <i class="fas fa-chevron-down transition-transform"></i>
                                    </div>
                                    <div class="accordion-content">
                                        <ul class="pb-4 space-y-2">
                                            @foreach ($section->lessons as $lesson)
                                                <li class="flex justify-between items-center py-2">
                                                    <div class="flex items-center">
                                                        <i class="far fa-play-circle text-gray-500 mr-3"></i>
                                                        <a
                                                            href="{{ route('lessons.show', ['course' => $course, 'section' => $section, 'lesson' => $lesson]) }}">{{ $lesson->title }}</a>
                                                    </div>
                                                    <span class="text-sm text-gray-400">
                                                        @if($lesson->duration)
                                                            {{ $lesson->duration }}
                                                        @endif
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Requirements -->
                    @if(count($course->requirements) > 0)
                        <div class="bg-dark-800 rounded-lg p-6 mt-8">
                            <h2 class="text-2xl font-bold mb-4">Requirements</h2>
                            <ul class="list-disc list-inside space-y-2 text-gray-300">
                                @foreach($course->requirements as $requirement)
                                    <li>{{ $requirement }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- Right Sidebar - Course Card -->
                <div class="lg:w-1/3">
                    <div class="sticky top-24 course-card bg-dark-800 rounded-xl overflow-hidden shadow-lg">
                        <div class="h-48 bg-gray-700 relative overflow-hidden">
                            @if($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Thumbnail"
                                    class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full bg-gradient-to-r from-blue-600 to-indigo-700 flex items-center justify-center">
                                    <i class="fas fa-image text-white text-4xl"></i>
                                </div>
                            @endif

                            <span
                                class="absolute top-4 right-4 bg-yellow-500 text-slate-900 text-xs font-bold px-2 py-1 rounded-full">
                                Best Seller
                            </span>
                            <div class="absolute bottom-4 left-4">
                                <span class="bg-dark-900 text-white text-sm px-3 py-1 rounded-full">
                                    {{ $course->category->name }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            @if ($course->teacher()->is(auth()->user()))
                                <div class="flex items-center justify-between mb-4">
                                    <span
                                        class="text-3xl font-bold text-white">{{ $course->formatted_price === 0 ? 'Free' : $course->formatted_price}}</span>
                                </div>
                                <div class="space-y-4">
                                    <a href="{{ route('dashboard.teacher.courses.edit', $course) }}"
                                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-lg transition">
                                        Edit Course
                                    </a>
                                </div>
                            @else
                                                    <div class="flex items-center justify-between mb-4">
                                                        <span class="text-3xl font-bold text-white">{{ $course->formatted_price === 0 ? 'Free' :
                                $course->formatted_price}}</span>
                                                    </div>
                                                    <div class="space-y-4">
                                                        <button
                                                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-lg transition">
                                                            Add to Cart
                                                        </button>
                                                        <button
                                                            class="w-full bg-transparent border border-indigo-500 hover:bg-indigo-900 text-white font-semibold py-3 px-4 rounded-lg transition">
                                                            Buy Now
                                                        </button>
                                                    </div>
                                                    <div class="mt-6 text-center">
                                                        <p class="text-gray-400 text-sm">30-Day Money-Back Guarantee</p>
                                                    </div>
                            @endif
                            <div class="mt-6 space-y-3">
                                <h3 class="font-semibold text-lg mb-2">This course includes:</h3>
                                <div class="flex items-center text-sm text-gray-300">
                                    <i class="far fa-play-circle text-gray-500 mr-3"></i>
                                    <span>{{ $course->lessons_count }} lessons on-demand videos</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-300">
                                    <i class="far fa-file-alt text-gray-500 mr-3"></i>
                                    <span>{{ $course->pdf_and_document_attachments}} articles</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-300">
                                    <i class="far fa-life-ring text-gray-500 mr-3"></i>
                                    <span>Full lifetime access</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-300">
                                    <i class="fas fa-mobile-alt text-gray-500 mr-3"></i>
                                    <span>Access on mobile and TV</span>
                                </div>
                            </div>
                        </div>
                    </div>
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

                <div>
                    <h4 class="text-lg font-semibold mb-4">Categories</h4>
                    <ul class="space-y-2">
                        @foreach ($categories as $category)
                            <li><a href="{{ route('courses.index', ['slug' => $category->slug]) }}"
                                    class="text-slate-400 hover:text-white transition">{{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-700 mt-8 pt-8 text-center text-slate-500">
                <p>&copy; 2023 E-Learning Platform. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Accordion Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Accordion functionality
            document.querySelectorAll('.accordion-header').forEach(header => {
                header.addEventListener('click', () => {
                    const content = header.nextElementSibling;
                    const icon = header.querySelector('i');

                    // Toggle current section
                    content.classList.toggle('show');
                    icon.classList.toggle('rotate');
                });
            });

            // Expand all sections button
            document.getElementById('expandAll').addEventListener('click', function () {
                const allContents = document.querySelectorAll('.accordion-content');
                const allIcons = document.querySelectorAll('.accordion-header i');
                const isExpanded = allContents[0]?.classList.contains('show');

                allContents.forEach(content => {
                    if (isExpanded) {
                        content.classList.remove('show');
                    } else {
                        content.classList.add('show');
                    }
                });

                allIcons.forEach(icon => {
                    if (isExpanded) {
                        icon.classList.remove('rotate');
                    } else {
                        icon.classList.add('rotate');
                    }
                });

                // Update button text
                this.textContent = isExpanded ? 'Expand all sections' : 'Collapse all sections';
            });
        });
    </script>
</body>

</html>