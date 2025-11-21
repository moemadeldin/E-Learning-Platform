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
        }

        .course-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
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
        }

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
                <div class="lg:w-2/3">
                    <!-- Category and Course Header -->
                    <div class="mb-6">
                        <span
                            class="inline-block bg-indigo-900 text-indigo-200 text-sm font-medium px-3 py-1 rounded-full mb-2">
                            {{ $course->category->name }}
                        </span>
                        <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $course->capitalized_title }}</h1>
                        <p class="text-lg text-gray-300 mb-6">
                            {{ $course->description}}
                        </p>

                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400">
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400 mr-1"></i>
                                <span> (12,548 ratings)</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-user-graduate mr-1"></i>
                                <span>84,295 students</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-1"></i>
                                <span>52 total hours</span>
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
                        <h2 class="text-xl font-bold mb-4">Created by {{ $course->user->name }}</h2>
                        <div class="flex items-center">
                            <img src="{{ asset('/storage/' . $course->user->profile->avatar) }}" alt="Instructor"
                                class="w-16 h-16 rounded-full mr-4">
                            <div>
                                <h3 class="font-bold text-lg">{{ $course->capitalized_instructor }}</h3>
                                <p class="text-gray-400 mb-2">Senior Web Developer & Instructor</p>
                                <div class="flex items-center text-sm text-gray-400">
                                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                                    <span class="mr-4">{{ $course->user->teacher->avg_rating }} Instructor Rating</span>
                                    <i class="fas fa-user-graduate mr-1"></i>
                                    <span class="mr-4">{{ $course->user->teacher->reviews_count }} Reviews</span>
                                    <i class="fas fa-users mr-1"></i>
                                    <span>{{ $course->user->teacher->students_count }} Students</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Course Content Sections -->
                    <div class="bg-dark-800 rounded-lg p-6">
                        <h2 class="text-2xl font-bold mb-6">Course Content</h2>

                        <div class="mb-4 flex justify-between items-center">
                            <div>
                                <span class="text-gray-400">12 sections • 156 lectures • 52h 15m total length</span>
                            </div>
                            <button class="text-indigo-400 hover:text-indigo-300 text-sm font-medium">
                                Expand all sections
                            </button>
                        </div>

                        <div class="accordion">
                            <!-- Section 1 -->
                            <div class="accordion-item">
                                <div class="accordion-header flex justify-between items-center py-4 cursor-pointer">
                                    <div>
                                        <h3 class="font-semibold">Introduction to Web Development</h3>
                                        <p class="text-sm text-gray-400 mt-1">5 lectures • 25 min</p>
                                    </div>
                                    <i class="fas fa-chevron-down transition-transform"></i>
                                </div>
                                <div class="accordion-content pl-4">
                                    <ul class="pb-4 space-y-2">
                                        <li class="flex justify-between items-center py-2">
                                            <div class="flex items-center">
                                                <i class="far fa-play-circle text-gray-500 mr-3"></i>
                                                <span>Welcome to the Course</span>
                                            </div>
                                            <span class="text-gray-400 text-sm">5:20</span>
                                        </li>
                                        <li class="flex justify-between items-center py-2">
                                            <div class="flex items-center">
                                                <i class="far fa-play-circle text-gray-500 mr-3"></i>
                                                <span>What is Web Development?</span>
                                            </div>
                                            <span class="text-gray-400 text-sm">7:45</span>
                                        </li>
                                        <li class="flex justify-between items-center py-2">
                                            <div class="flex items-center">
                                                <i class="far fa-play-circle text-gray-500 mr-3"></i>
                                                <span>Setting Up Your Development Environment</span>
                                            </div>
                                            <span class="text-gray-400 text-sm">8:30</span>
                                        </li>
                                        <li class="flex justify-between items-center py-2">
                                            <div class="flex items-center">
                                                <i class="far fa-play-circle text-gray-500 mr-3"></i>
                                                <span>How the Internet Works</span>
                                            </div>
                                            <span class="text-gray-400 text-sm">10:15</span>
                                        </li>
                                        <li class="flex justify-between items-center py-2">
                                            <div class="flex items-center">
                                                <i class="far fa-file-alt text-gray-500 mr-3"></i>
                                                <span>Course Resources</span>
                                            </div>
                                            <span class="text-gray-400 text-sm">Article</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Section 2 -->
                            <div class="accordion-item">
                                <div class="accordion-header flex justify-between items-center py-4 cursor-pointer">
                                    <div>
                                        <h3 class="font-semibold">HTML5 Fundamentals</h3>
                                        <p class="text-sm text-gray-400 mt-1">12 lectures • 2h 45 min</p>
                                    </div>
                                    <i class="fas fa-chevron-down transition-transform"></i>
                                </div>
                                <div class="accordion-content pl-4">
                                    <ul class="pb-4 space-y-2">
                                        <li class="flex justify-between items-center py-2">
                                            <div class="flex items-center">
                                                <i class="far fa-play-circle text-gray-500 mr-3"></i>
                                                <span>HTML Document Structure</span>
                                            </div>
                                            <span class="text-gray-400 text-sm">15:20</span>
                                        </li>
                                        <li class="flex justify-between items-center py-2">
                                            <div class="flex items-center">
                                                <i class="far fa-play-circle text-gray-500 mr-3"></i>
                                                <span>Text Elements and Headings</span>
                                            </div>
                                            <span class="text-gray-400 text-sm">18:45</span>
                                        </li>
                                        <li class="flex justify-between items-center py-2">
                                            <div class="flex items-center">
                                                <i class="far fa-play-circle text-gray-500 mr-3"></i>
                                                <span>Lists, Links, and Images</span>
                                            </div>
                                            <span class="text-gray-400 text-sm">22:30</span>
                                        </li>
                                        <!-- More lectures would go here -->
                                    </ul>
                                </div>
                            </div>

                            <!-- Section 3 -->
                            <div class="accordion-item">
                                <div class="accordion-header flex justify-between items-center py-4 cursor-pointer">
                                    <div>
                                        <h3 class="font-semibold">CSS3 and Styling</h3>
                                        <p class="text-sm text-gray-400 mt-1">18 lectures • 4h 20 min</p>
                                    </div>
                                    <i class="fas fa-chevron-down transition-transform"></i>
                                </div>
                                <div class="accordion-content pl-4">
                                    <ul class="pb-4 space-y-2">
                                        <li class="flex justify-between items-center py-2">
                                            <div class="flex items-center">
                                                <i class="far fa-play-circle text-gray-500 mr-3"></i>
                                                <span>Introduction to CSS</span>
                                            </div>
                                            <span class="text-gray-400 text-sm">12:20</span>
                                        </li>
                                        <li class="flex justify-between items-center py-2">
                                            <div class="flex items-center">
                                                <i class="far fa-play-circle text-gray-500 mr-3"></i>
                                                <span>Selectors and Specificity</span>
                                            </div>
                                            <span class="text-gray-400 text-sm">20:15</span>
                                        </li>
                                        <!-- More lectures would go here -->
                                    </ul>
                                </div>
                            </div>

                            <!-- More sections would go here -->
                        </div>
                    </div>

                    <!-- Requirements -->
                    <div class="bg-dark-800 rounded-lg p-6 mt-8">
                        <h2 class="text-2xl font-bold mb-4">Requirements</h2>
                        <ul class="list-disc list-inside space-y-2 text-gray-300">
                            <li>No programming experience needed. You will learn everything you need to know</li>
                            <li>A computer with internet access</li>
                            <li>No paid software required. All coding will be done in free editors</li>
                            <li>Willingness to learn and excitement about web development</li>
                        </ul>
                    </div>
                </div>

                <!-- Right Sidebar - Course Card -->
                <div class="lg:w-1/3">
                    <div class="sticky top-24 course-card bg-dark-800 rounded-xl overflow-hidden shadow-lg">
                        <!-- Replace the gradient div with thumbnail -->
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
                            <div class="flex items-center justify-between mb-4">
                                <span
                                    class="text-3xl font-bold text-white">{{ $course->formatted_price === 0 ? 'Free' : $course->formatted_price}}</span>
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

                            <div class="mt-6 space-y-3">
                                <h3 class="font-semibold text-lg mb-2">This course includes:</h3>
                                <div class="flex items-center text-sm text-gray-300">
                                    <i class="far fa-play-circle text-gray-500 mr-3"></i>
                                    <span>52 hours on-demand video</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-300">
                                    <i class="far fa-file-alt text-gray-500 mr-3"></i>
                                    <span>48 articles</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-300">
                                    <i class="fas fa-download text-gray-500 mr-3"></i>
                                    <span>156 downloadable resources</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-300">
                                    <i class="far fa-life-ring text-gray-500 mr-3"></i>
                                    <span>Full lifetime access</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-300">
                                    <i class="fas fa-mobile-alt text-gray-500 mr-3"></i>
                                    <span>Access on mobile and TV</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-300">
                                    <i class="fas fa-trophy text-gray-500 mr-3"></i>
                                    <span>Certificate of completion</span>
                                </div>
                            </div>

                            <div class="mt-6">
                                <h3 class="font-semibold text-lg mb-2">Share this course</h3>
                                <div class="flex space-x-3">
                                    <button
                                        class="flex-1 bg-blue-800 hover:bg-blue-700 text-white py-2 px-3 rounded text-sm">
                                        <i class="fab fa-facebook-f mr-1"></i> Facebook
                                    </button>
                                    <button
                                        class="flex-1 bg-blue-400 hover:bg-blue-500 text-white py-2 px-3 rounded text-sm">
                                        <i class="fab fa-twitter mr-1"></i> Twitter
                                    </button>
                                    <button
                                        class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 px-3 rounded text-sm">
                                        <i class="fab fa-linkedin-in mr-1"></i> LinkedIn
                                    </button>
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
                        <li><a href="#" class="text-slate-400 hover:text-white transition">Courses</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition">About Us</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Categories</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-slate-400 hover:text-white transition">Programming</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition">Design</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition">Business</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition">Photography</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Connect With Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-slate-400 hover:text-white transition">
                            <i class="fab fa-facebook-f text-lg"></i>
                        </a>
                        <a href="#" class="text-slate-400 hover:text-white transition">
                            <i class="fab fa-twitter text-lg"></i>
                        </a>
                        <a href="#" class="text-slate-400 hover:text-white transition">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                        <a href="#" class="text-slate-400 hover:text-white transition">
                            <i class="fab fa-linkedin-in text-lg"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-700 mt-8 pt-8 text-center text-slate-500">
                <p>&copy; 2023 E-Learning Platform. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Accordion functionality
        document.querySelectorAll('.accordion-header').forEach(header => {
            header.addEventListener('click', () => {
                const content = header.nextElementSibling;
                const icon = header.querySelector('i');

                content.classList.toggle('active');
                icon.classList.toggle('fa-chevron-down');
                icon.classList.toggle('fa-chevron-up');
            });
        });
    </script>
</body>

</html>