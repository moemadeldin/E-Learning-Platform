<x-layouts.auth :title="'Profile'">
    <div class="min-h-screen flex flex-col bg-gradient-to-b from-dark-900 to-dark-800 text-white">

        {{-- Header --}}
        <x-home.header />

        {{-- Main Content --}}
        <main class="flex-grow py-12 px-4 lg:px-8">
            <div class="max-w-4xl mx-auto">
                {{-- Profile Header --}}
                <div class="bg-dark-800 rounded-xl p-8 mb-8">
                    <div class="flex flex-col md:flex-row items-center gap-6">
                        <div class="relative">
                            <img src="{{ asset('/storage/' . Auth::user()->profile->avatar) }}" alt="Profile"
                                class="w-32 h-32 rounded-full border-4 border-blue-500">
                            <button
                                class="absolute bottom-2 right-2 bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full">
                                <i class="fas fa-camera text-sm"></i>
                            </button>
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <h1 class="text-3xl font-bold mb-2">{{ auth()->user()->profile->full_name }}</h1>
                            <p class="text-gray-400 mb-4">{{ auth()->user()->isTeacher() ? auth()->user()->title : ''}}
                            </p>
                            <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-blue-400">
                                        {{ auth()->user()->course()->count() }}
                                    </div>
                                    <div class="text-sm text-gray-400">Courses</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-green-400">
                                        #</div>
                                    <div class="text-sm text-gray-400">Students</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-purple-400">
                                        {{ auth()->user()->teacher->avg_rating ?? null }}
                                    </div>
                                    <div class="text-sm text-gray-400">Rating</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('profiles.edit', auth()->user()) }}"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                            <i class="fas fa-edit mr-2"></i>Edit Profile
                        </a>

                    </div>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    {{-- Left Column --}}
                    <div class="md:col-span-2 space-y-6">
                        {{-- About Section --}}
                        <div class="bg-dark-800 rounded-xl p-6">
                            <h2 class="text-2xl font-bold mb-4">About Me</h2>
                            <p class="text-gray-300 leading-relaxed">
                                {{ auth()->user()->profile->bio ?? 'User did not include any information'}}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-8 text-center">
                    <form action="{{ route('profiles.destroy', auth()->user()) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button
                            class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition"
                            onclick="if(confirm('Are you sure you want to delete your account? This action cannot be undone.')) { /* Add your delete action here */ }">
                            <i class="fas fa-trash-alt mr-2"></i>Delete Account
                        </button>
                    </form>

                </div>
            </div>
        </main>

        {{-- Footer --}}
        <x-home.footer />

    </div>
</x-layouts.auth>