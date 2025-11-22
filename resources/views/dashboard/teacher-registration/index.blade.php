@extends('dashboard.layout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-4 text-gray-800">Teacher Requests</h1>
            <x-flash-message/>
            {{-- Users Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($teachers as $teacher)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $teacher->user->profile->full_name}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $teacher->category->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                    <form action="{{ route('teachers.requests.accept', $teacher) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1 text-xs font-medium bg-green-500 text-white rounded hover:bg-green-600">
                                            Accept
                                        </button>
                                    </form>
                                    <form action="{{ route('teachers.requests.reject', $teacher) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1 text-xs font-medium bg-red-500 text-white rounded hover:bg-red-600"
                                            onclick="return confirm('Are you sure?')">
                                            Reject
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">No Teachers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Pagination --}}
            <div class="mt-4">
                {{ $teachers->links() }}
            </div>
        </div>
    </div>
@endsection