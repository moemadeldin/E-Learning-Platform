@extends('dashboard.layout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow rounded-lg">
            <!-- Course Header -->
            <div class="p-6 border-b">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">{{ $course->name }}</h1>
                        <p class="text-gray-600 mt-2">{{ $course->description }}</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('dashboard.teacher.courses.edit', $course) }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Edit Course
                        </a>
                        <a href="{{ route('dashboard.teacher.courses.index') }}"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                            Back to Courses
                        </a>
                    </div>
                </div>
            </div>

            <!-- Course Stats -->
            <div class="p-6 border-b bg-gray-50">
                <div class="grid grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-800">{{ $course->sections_count }}</div>
                        <div class="text-gray-600">Sections</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-800">{{ $course->lessons_count }}</div>
                        <div class="text-gray-600">Lessons</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-800">{{ $course->enrollments_count ?? 0 }}</div>
                        <div class="text-gray-600">Students</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-800">{{ $course->reviews_avg_rating ?? 0 }}/5</div>
                        <div class="text-gray-600">Rating</div>
                    </div>
                </div>
            </div>

            <!-- Sections & Lessons Management -->
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Course Content</h2>
                    <button onclick="toggleSectionForm()"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Add Section
                    </button>
                </div>

                <!-- Add Section Form (Hidden by Default) -->
                <div id="sectionForm" class="mb-6 p-4 border rounded-lg bg-gray-50 hidden">
                    <h3 class="text-lg font-semibold mb-3">Add New Section</h3>
                    <form action="{{ route('sections.store', $course) }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Title</label>
                                <input type="text" name="title" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Order</label>
                                <input type="number" name="order"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                    placeholder="Auto-calculated">
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                    Create Section
                                </button>
                                <button type="button" onclick="toggleSectionForm()"
                                    class="ml-2 px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Sections List -->
                <div class="space-y-4">
                    @forelse($course->sections as $section)
                        <div class="border rounded-lg">
                            <!-- Section Header -->
                            <div class="p-4 bg-gray-50 border-b flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-semibold">{{ $section->title }}</h3>
                                    <p class="text-sm text-gray-600">{{ $section->lessons_count }} lessons</p>
                                </div>
                                <div class="flex gap-2">
                                    <!-- Add Lesson Button -->
                                    <a href="{{ route('lessons.create', ['course' => $course, 'section' => $section]) }}"
                                        class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">
                                        Add Lesson
                                    </a>

                                    <!-- Update Section Button -->
                                    <a href="{{ route('sections.edit', ['course' => $course, 'section' => $section]) }}"
                                        class="px-3 py-1 bg-yellow-600 text-white text-sm rounded hover:bg-yellow-700">
                                        Update
                                    </a>

                                    <!-- Delete Section Button -->
                                    <form action="{{ route('sections.destroy', ['course' => $course, 'section' => $section]) }}"
                                        method="POST" onsubmit="return confirm('Delete this section and all its lessons?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="cursor-pointer px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Lessons List -->
                            <div class="divide-y">
                                @forelse($section->lessons as $lesson)
                                    <div class="p-4 flex justify-between items-center hover:bg-gray-50">
                                        <div class="flex items-center gap-3">
                                            <div class="text-gray-400">
                                                <i class="fas fa-play-circle"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-medium">{{ $lesson->title }}</h4>
                                                @if($lesson->video_url)
                                                    <span class="text-sm text-blue-600">Video</span>
                                                @endif
                                                @if($lesson->attachments_count > 0)
                                                    <span class="text-sm text-gray-600">{{ $lesson->attachments_count }}
                                                        attachments</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <!-- View Lesson Button -->
                                            {{-- <a href="{{ route('lessons.show', ['course' => $course, 'lesson' => $lesson]) }}"
                                                class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                                                View
                                            </a> --}}

                                            <!-- Edit Lesson Button -->
                                            {{-- <a href="{{ route('lessons.edit', ['course' => $course, 'lesson' => $lesson]) }}"
                                                class="px-3 py-1 bg-yellow-600 text-white text-sm rounded hover:bg-yellow-700">
                                                Edit
                                            </a> --}}

                                            <!-- Delete Lesson Button -->
                                            {{-- <form
                                                action="{{ route('lessons.destroy', ['course' => $course, 'lesson' => $lesson]) }}"
                                                method="POST" onsubmit="return confirm('Delete this lesson?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                                                    Delete
                                                </button>
                                            </form> --}}
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-gray-500 bg-gray-50">
                                        <p class="mb-2">No lessons in this section yet.</p>
                                        <a href="{{ route('lessons.create', ['course' => $course, 'section' => $section]) }}"
                                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Add your first lesson
                                        </a>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg">
                            <p class="mb-4">No sections created yet.</p>
                            <button onclick="toggleSectionForm()"
                                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                Add your first section
                            </button>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSectionForm() {
            document.getElementById('sectionForm').classList.toggle('hidden');
        }
    </script>
@endsection