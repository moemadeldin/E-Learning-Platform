@extends('dashboard.layout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">Courses</h1>

            {{-- Create Button --}}
            <div class="flex justify-end mb-6">
                <a href="{{ route('dashboard.teacher.courses.create') }}"
                    class="inline-flex items-center px-5 py-3 bg-blue-600 text-white text-base font-semibold rounded hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-2"></i>
                    Create Course
                </a>
            </div>
            <x-flash-message />
            {{-- Filter Form --}}
            <form method="GET" action="{{ route('dashboard.teacher.courses.index') }}" class="mb-6 flex flex-wrap gap-4">
                <div>
                    <label for="category_id" class="block text-base font-medium text-gray-700">Category</label>
                    <select name="category_id" id="category_id"
                        class="mt-1 block w-44 border-gray-300 rounded-md shadow-sm text-base">
                        <option value="">All</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="is_free" class="block text-base font-medium text-gray-700">Free?</label>
                    <select name="is_free" id="is_free"
                        class="mt-1 block w-44 border-gray-300 rounded-md shadow-sm text-base">
                        <option value="">All</option>
                        <option value="1" {{ request('is_free') === '1' ? 'selected' : '' }}>Free</option>
                        <option value="0" {{ request('is_free') === '0' ? 'selected' : '' }}>Paid</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded text-base hover:bg-blue-700">
                        Filter
                    </button>

                    <a href="{{ route('dashboard.teacher.courses.index') }}"
                        class="px-5 py-2 bg-gray-300 text-gray-700 rounded text-base hover:bg-gray-400">
                        Reset
                    </a>
                </div>
            </form>

            {{-- Courses Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full table-fixed border border-gray-200 text-base">
                    <thead class="bg-gray-100">
                        <tr class="text-left">
                            <th class="w-40 px-4 py-3 font-semibold text-gray-700">Name</th>
                            <th class="w-32 px-4 py-3 font-semibold text-gray-700">Slug</th>
                            <th class="w-40 px-4 py-3 font-semibold text-gray-700">Category</th>
                            <th class="w-40 px-4 py-3 font-semibold text-gray-700">Teacher</th>
                            <th class="w-28 px-4 py-3 font-semibold text-gray-700 text-center">Thumbnail</th>
                            <th class="w-48 px-4 py-3 font-semibold text-gray-700">Description</th>
                            <th class="w-56 px-4 py-3 font-semibold text-gray-700">Long Description</th>
                            <th class="w-24 px-4 py-3 font-semibold text-gray-700">Price</th>
                            <th class="w-20 px-4 py-3 font-semibold text-gray-700">Free?</th>
                            <th class="w-24 px-4 py-3 font-semibold text-gray-700">Level</th>
                            <th class="w-28 px-4 py-3 font-semibold text-gray-700">Language</th>
                            <th class="w-56 px-4 py-3 font-semibold text-gray-700 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($courses as $course)
                            <tr class="align-middle">
                                <td class="px-4 py-3 truncate">{{ $course->name }}</td>
                                <td class="px-4 py-3 truncate">{{ $course->slug }}</td>
                                <td class="px-4 py-3 truncate">{{ $course->category->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 truncate">{{ $course->user->profile->full_name }}</td>
                                <td class="px-4 py-3 text-center">
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Thumbnail"
                                        class="w-16 h-16 object-cover mx-auto rounded">
                                </td>
                                <td class="px-4 py-3 truncate">{{ Str::limit($course->description, 60) }}</td>
                                <td class="px-4 py-3 truncate">{{ Str::limit($course->long_description, 70) }}</td>
                                <td class="px-4 py-3">{{ $course->formatted_price }}</td>
                                <td class="px-4 py-3 text-center">{{ $course->is_free ? 'Yes' : 'No' }}</td>
                                <td class="px-4 py-3">{{ $course->level }}</td>
                                <td class="px-4 py-3">{{ $course->language }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2 justify-center">
                                        <a href="{{ route('dashboard.teacher.courses.edit', $course) }}"
                                            class="px-4 py-2 text-white bg-yellow-500 rounded hover:bg-yellow-600 text-sm">
                                            Update
                                        </a>
                                        <form action="{{ route('dashboard.teacher.courses.destroy', $course) }}" method="POST"
                                            onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600 text-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center py-4 text-gray-500 text-base">No Courses found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $courses->links() }}
            </div>
        </div>
    </div>
@endsection