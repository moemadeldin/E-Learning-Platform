@extends('dashboard.layout')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow rounded-lg">
            <div class="p-6 border-b">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Add New Lesson</h1>
                        <p class="text-gray-600 mt-1">Section: {{ $section->title }}</p>
                        <p class="text-gray-600">Course: {{ $course->name }}</p>
                    </div>
                    {{-- <a href="{{ route('dashboard.teacher.courses.show', $course) }}"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                        Back to Course
                    </a> --}}
                </div>
            </div>

            <div class="p-6">
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('lessons.store', $section) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Lesson Title *</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Content -->
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700">Content *</label>
                            <textarea name="content" id="content" rows="6" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('content') }}</textarea>
                        </div>

                        <!-- Order -->
                        <div>
                            <label for="order" class="block text-sm font-medium text-gray-700">Order</label>
                            <input type="number" name="order" id="order" value="{{ old('order') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Leave empty for auto-order">
                            <p class="mt-1 text-sm text-gray-500">Leave empty to automatically add to the end</p>
                        </div>

                        <!-- Video URL -->
                        <div>
                            <label for="video_url" class="block text-sm font-medium text-gray-700">Video URL
                                (Optional)</label>
                            <input type="url" name="video_url" id="video_url" value="{{ old('video_url') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="https://example.com/video.mp4">
                        </div>

                        <!-- Attachments -->
                        <div>
                            <label for="attachments" class="block text-sm font-medium text-gray-700">Attachments
                                (Optional)</label>
                            <input type="file" name="attachments[]" id="attachments" multiple
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                accept=".jpg,.jpeg,.png,.gif,.webp,.svg,.bmp,.mp4,.mov,.avi,.mkv,.wmv,.flv,.mp3,.wav,.aac,.ogg,.flac,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv,.rtf,.odt">
                            <p class="mt-1 text-sm text-gray-500">You can select multiple files. Supported formats: images,
                                videos, audio, documents</p>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end gap-3">
                            {{-- <a href="{{ route('dashboard.teacher.courses.show', $course) }}"
                                class="px-6 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                                Cancel
                            </a> --}}
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Create Lesson
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection