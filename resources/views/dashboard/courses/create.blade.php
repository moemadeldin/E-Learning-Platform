<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <x-dashboard.side-bar />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <x-dashboard.header />

            <!-- Create Form Section -->
            <main class="flex-1 overflow-y-auto p-6">
                <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Create New Course</h2>

                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('dashboard.courses.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                                placeholder="Enter Name" required>
                        </div>

                        <!-- Thumbnail -->
                        <div class="mb-4">
                            <label for="thumbnail" class="block text-gray-700 font-semibold mb-2">Thumbnail</label>
                            <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                                required>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
                            <textarea name="description" id="description" rows="3"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                                placeholder="Enter Description" required>{{ old('description') }}</textarea>
                        </div>

                        <!-- Long Description -->
                        <div class="mb-4">
                            <label for="long_description" class="block text-gray-700 font-semibold mb-2">Long
                                Description</label>
                            <textarea name="long_description" id="long_description" rows="5"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                                placeholder="Enter Long Description" required>{{ old('long_description') }}</textarea>
                        </div>

                        <!-- Price -->
                        <div class="mb-4">
                            <label for="price" class="block text-gray-700 font-semibold mb-2">Price</label>
                            <input type="text" name="price" id="price" value="{{ old('price') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                                placeholder="Enter Price" required>
                        </div>

                        <!-- Is Free -->
                        <div class="mb-4">
                            <label for="is_free" class="block text-gray-700 font-semibold mb-2">Is Free?</label>
                            <select name="is_free" id="is_free"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                                required>
                                <option value="1" {{ old('is_free') == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('is_free') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <!-- Level -->
                        <div class="mb-4">
                            <label for="level" class="block text-gray-700 font-semibold mb-2">Level</label>
                            <select name="level" id="level"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                                <option value="">Select Level</option>
                                @foreach (App\Enums\CourseLevel::cases() as $level)
                                    <option value="{{ $level->value }}" {{ old('level') == $level->value ? 'selected' : '' }}>
                                        {{ $level->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Language -->
                        <div class="mb-4">
                            <label for="language" class="block text-gray-700 font-semibold mb-2">Language</label>
                            <input type="text" name="language" id="language" value="{{ old('language') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                                placeholder="Enter Language (2chars)" required>
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <label for="category_id" class="block text-gray-700 font-semibold mb-2">Category</label>
                            <select name="category_id" id="category_id" required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                                <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Select Category
                                </option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if (Auth::user()->roles()->first()->name->value === \App\Enums\Roles::ADMIN->value)
                            <div class="mb-4">
                                <label for="user_id" class="block text-gray-700 font-semibold mb-2">Teacher</label>
                                <select name="user_id" id="user_id" required
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                                    <option value="" disabled {{ old('user_id') ? '' : 'selected' }}>Select Teacher</option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ old('user_id') == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <!-- Submit -->
                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>

</html>