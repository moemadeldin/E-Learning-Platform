<div class="w-64 bg-blue-800 text-white p-4">
    <h2 class="text-xl font-bold mb-6 mt-2">Learning Platform</h2>

    <div class="mb-8">
        <ul class="space-y-2">
            <li class="flex items-center hover:bg-blue-700 p-2 rounded cursor-pointer">
                <a href="{{ route('categories.index') }}" class="flex items-center text-white w-full">
                    <i class="fas fa-laptop-code mr-2"></i> Categories
                </a>
            </li>
            <li class="flex items-center hover:bg-blue-700 p-2 rounded cursor-pointer">
                <a href="{{ route('dashboard.courses.index') }}" class="flex items-center text-white w-full">
                    <i class="fas fa-graduation-cap mr-2"></i> Courses
                </a>
            </li>
        </ul>
    </div>
    <div class="mt-8">
        <h3 class="text-sm uppercase text-blue-200 mb-3">More Features</h3>
        <ul class="space-y-2">
            <li class="flex items-center hover:bg-blue-700 p-2 rounded cursor-pointer">
                <a href="{{ route('users.index') }}" class="flex items-center text-white w-full">
                    <i class="fa-solid fa-users mr-2"></i> Users
                </a>
            </li>
            <li class="flex items-center hover:bg-blue-700 p-2 rounded cursor-pointer">
                <a href="{{ route('teachers.requests.index') }}" class="flex items-center text-white w-full">
                    <i class="fa-solid fa-users mr-2"></i> Teachers Requests
                </a>
            </li>

            <li class="flex items-center hover:bg-blue-700 p-2 rounded cursor-pointer">
                <i class="fas fa-calendar-alt mr-2"></i> Schedule
            </li>
        </ul>
    </div>
</div>