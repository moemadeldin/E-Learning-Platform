<x-layouts.auth :title="'Edit Profile'">
    <div class="min-h-screen flex flex-col bg-gradient-to-b from-dark-900 to-dark-800 text-white">

        {{-- Header --}}
        <x-home.header />

        {{-- Main Content --}}
        <main class="flex-grow py-12 px-4 lg:px-8">
            <div class="max-w-2xl mx-auto">
                {{-- Profile Header --}}
                <div class="bg-dark-800 rounded-xl p-8 mb-8">
                    <h1 class="text-3xl font-bold mb-6">Edit Profile</h1>

                    <div class="space-y-6">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        {{-- Buttons --}}
                        <div class="flex gap-4 pt-4">
                            <form action="{{ route('profiles.update', auth()->user()) }}" method="POST"
                                enctype="multipart/form-data" class="w-full max-w-2xl">
                                @csrf
                                @method('PUT')

                                <div class="space-y-6">
                                    <!-- Avatar Upload -->
                                    <div class="flex flex-col items-center mb-6">
                                        <div class="relative mb-4">
                                            <img src="{{ asset('/storage/' . Auth::user()->profile->avatar) }}"
                                                alt="Profile"
                                                class="w-32 h-32 rounded-full border-4 border-blue-500 object-cover">
                                            <input type="file" name="avatar" id="avatar" class="hidden"
                                                accept="image/*">
                                            <button type="button" onclick="document.getElementById('avatar').click()"
                                                class="absolute bottom-2 right-2 bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full cursor-pointer transition duration-200">
                                                <i class="fas fa-camera text-sm"></i>
                                            </button>
                                        </div>
                                        <p class="text-gray-400 text-sm">Click camera icon to upload new avatar</p>
                                    </div>
                                    @error('avatar')
                                        <p class="text-red-400 text-sm mt-1 text-center">{{ $message }}</p>
                                    @enderror
                                    {{-- Name Fields --}}
                                    <div class="grid md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-300 mb-2">First
                                                Name</label>
                                            <input disabled readonly type="text"
                                                class="w-full bg-dark-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:ring-0 focus:border-gray-500 opacity-75"
                                                placeholder="Enter your first name"
                                                value="{{ auth()->user()->profile->first_name }}">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-300 mb-2">Last
                                                Name</label>
                                            <input disabled readonly type="text"
                                                class="w-full bg-dark-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:ring-0 focus:border-gray-500 opacity-75"
                                                placeholder="Enter your last name"
                                                value="{{ auth()->user()->profile->last_name }}">
                                        </div>
                                    </div>
                                    <!-- Email Field -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                                        <input type="email" name="email"
                                            class="w-full bg-dark-800 border border-gray-600 text-white rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                            placeholder="Enter your email" value="{{ auth()->user()->email }}">
                                    </div>
                                    @error('email')
                                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                    @enderror

                                    <!-- National ID Field -->
                                    @if(auth()->user()->isTeacher())
                                        <div>
                                            <label class="block text-sm font-medium text-gray-300 mb-2">National ID</label>
                                            <input type="text" name="national_id"
                                                class="w-full bg-dark-800 border border-gray-600 text-white rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                                placeholder="Enter your national ID"
                                                value="{{ auth()->user()->teacher->national_id }}">
                                        </div>
                                        @error('national_id')
                                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    @endif

                                    <!-- Bio Field -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Bio</label>
                                        <textarea rows="4" name="bio"
                                            class="w-full bg-dark-800 border border-gray-600 text-white rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none transition duration-200"
                                            placeholder="Tell us about yourself...">{{ auth()->user()->profile->bio }}</textarea>
                                    </div>
                                    @error('bio')
                                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                    @enderror

                                    <!-- Submit Button -->
                                    <button
                                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200 flex items-center gap-2 hover:scale-105 transform">
                                        <i class="fas fa-save"></i>
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        {{-- Footer --}}
        <x-home.footer />

    </div>
</x-layouts.auth>