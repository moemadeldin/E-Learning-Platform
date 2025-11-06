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

            <!-- Cards Section -->
            <div class="flex justify-center p-6">
                <!-- Card Container with 1 card that spans full width on large screens -->
                <div class="w-full lg:w-3/4 xl:w-1/2">
                    <!-- Card 1 -->
                    <div class="bg-white p-8 rounded-lg shadow-xl">
                        <div class="mt-6">
                            <h3 class="text-2xl font-semibold">Name: {{ $category->name }}</h3>
                            <div class="mt-6 flex space-x-4">
                                <a href="{{ route('categories.edit', $category) }}"
                                    class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 text-lg">
                                    Update
                                </a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 text-lg"
                                        onclick="return confirm('Are you sure?')">
                                        Destroy
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>