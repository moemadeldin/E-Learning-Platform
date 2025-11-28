<x-layouts.auth :title="'Shopping Cart'">
    <div class="min-h-screen flex flex-col bg-gradient-to-b from-dark-900 to-dark-800 text-white">

        {{-- Header --}}
        <x-home.header />

        {{-- Main Content --}}
        <main class="flex-grow py-12 px-4 lg:px-8">
            <div class="container mx-auto max-w-6xl">
                {{-- Page Header --}}
                <div class="text-center mb-12">
                    <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Shopping Cart</h1>
                    <p class="text-lg text-slate-400 max-w-2xl mx-auto">
                        Review your selected courses and proceed to checkout
                    </p>
                </div>

                @if($cartItems && $cartItems->count() > 0)
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        {{-- Cart Items --}}
                        <div class="lg:col-span-2 space-y-6">
                            @foreach($cartItems as $item)
                                <div class="bg-dark-800 rounded-xl p-6 shadow-lg">
                                    <div class="flex flex-col md:flex-row gap-6">
                                        {{-- Course Image --}}
                                        <div class="flex-shrink-0">
                                            <div class="w-40 h-24 rounded-lg overflow-hidden bg-gray-700">
                                                @if($item->course->thumbnail)
                                                    <img src="{{ asset('storage/' . $item->course->thumbnail) }}" 
                                                         alt="{{ $item->course->name }}"
                                                         class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full bg-gradient-to-r from-blue-600 to-indigo-700 flex items-center justify-center">
                                                        <i class="fas fa-image text-white text-2xl"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        {{-- Course Details --}}
                                        <div class="flex-grow">
                                            <div class="flex justify-between items-start mb-2">
                                                <div>
                                                    <span class="inline-block bg-indigo-900 text-indigo-200 text-sm font-medium px-3 py-1 rounded-full mb-2">
                                                        {{ $item->course->category->name }}
                                                    </span>
                                                    <h3 class="text-xl font-bold text-white mb-2">
                                                        {{ $item->course->capitalized_title }}
                                                    </h3>
                                                    <p class="text-gray-400 text-sm mb-3 line-clamp-2">
                                                        {{ Str::limit($item->course->description, 120) }}
                                                    </p>
                                                </div>
                                                <div class="text-right">
                                                    <span class="text-2xl font-bold text-white">
                                                        {{ $item->course->formatted_price }}
                                                        <a class="text-white bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded text-sm"href="{{ route('carts.show', $item->course->slug) }}">Show</a>
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            {{-- Course Stats --}}
                                            <div class="flex items-center text-sm text-gray-400 space-x-4 mb-4">
                                                <div class="flex items-center">
                                                    <i class="fas fa-user-graduate mr-1"></i>
                                                    <span>{{ $item->course->enrollments_count }} students</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    <span>{{ $item->course->lessons_count }} lessons</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <i class="fas fa-signal mr-1"></i>
                                                    <span>{{ $item->course->level->label() }}</span>
                                                </div>
                                            </div>
                                            
                                            {{-- Instructor --}}
                                            <div class="flex items-center">
                                                <img src="{{ asset('storage/' . $item->course->teacher->profile->avatar) }}" 
                                                     alt="Instructor"
                                                     class="w-8 h-8 rounded-full mr-3">
                                                <span class="text-gray-300 text-sm">
                                                    {{ $item->course->capitalized_instructor }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Order Summary --}}
                        {{-- <div class="lg:col-span-1">
                            <div class="bg-dark-800 rounded-xl p-6 sticky top-24">
                                <h3 class="text-2xl font-bold mb-6">Order Summary</h3>
                                
                                <div class="space-y-4 mb-6">
                                    <div class="flex justify-between text-gray-300">
                                        <span>Subtotal ({{ $cartItems->count() }} courses)</span>
                                        <span>${{ number_format($subtotal, 2) }}</span>
                                    </div>
                                    <div class="border-t border-gray-700 pt-4">
                                        <div class="flex justify-between text-xl font-bold text-white">
                                            <span>Total</span>
                                            <span>${{ number_format($total, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-6 rounded-lg transition mb-4">
                                    Proceed to Checkout
                                </button>
                                
                                <p class="text-center text-gray-400 text-sm">
                                    <i class="fas fa-shield-alt mr-1"></i>
                                    30-Day Money-Back Guarantee
                                </p>
                                
                                <div class="mt-6 space-y-3 text-sm text-gray-400">
                                    <div class="flex items-center">
                                        <i class="far fa-play-circle text-gray-500 mr-3"></i>
                                        <span>Full lifetime access</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-mobile-alt text-gray-500 mr-3"></i>
                                        <span>Access on mobile and TV</span>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                @else
                    {{-- Empty Cart --}}
                    <div class="text-center py-16">
                        <div class="mb-6">
                            <i class="fas fa-shopping-cart text-6xl text-gray-600 mb-4"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-4">Your cart is empty</h3>
                        <p class="text-gray-400 mb-8 max-w-md mx-auto">
                            Start exploring our courses and add some to your cart to begin your learning journey.
                        </p>
                        <a href="{{ route('courses.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-white font-semibold transition">
                            <i class="fas fa-search mr-2"></i>
                            Browse Courses
                        </a>
                    </div>
                @endif
            </div>
        </main>

        {{-- Footer --}}
        <x-home.footer />
    </div>
</x-layouts.auth>