<!DOCTYPE html>
<html>
<head>
    <title>Checkout - Review Your Order</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @if($cart && $cart->items->count() > 0)
                <!-- Cart Items Summary -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                    
                    @foreach($cart->items as $item)
                        <div class="flex justify-between items-center py-4 border-b">
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">{{ $item->course->name }}</h3>
                                <p class="text-gray-600 text-sm mt-1">
                                    {{ Str::limit($item->course->description, 100) }}
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="font-semibold text-gray-900">
                                    @if($item->course->is_free)
                                        FREE
                                    @else
                                        £{{ number_format($item->course->price, 2) }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endforeach

                    <!-- Total -->
                    <div class="flex justify-between items-center pt-4 mt-4 border-t">
                        <span class="text-lg font-bold text-gray-900">Total</span>
                        <span class="text-lg font-bold text-gray-900">
                            £{{ number_format($cart->items->sum(function($item) {
                                return $item->course->is_free ? 0 : $item->course->price;
                            }), 2) }}
                        </span>
                    </div>
                </div>

                <!-- Checkout Button -->
                <form action="{{ route('stripe.create-session') }}" method="POST">
                    @csrf
                    <button 
                        type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-lg transition duration-200"
                    >
                        Proceed to Payment
                    </button>
                </form>

                <p class="text-center text-gray-500 text-sm mt-4">
                    You'll be redirected to Stripe's secure checkout page
                </p>

            @else
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Your cart is empty</h2>
                    <p class="text-gray-600 mb-4">Add some courses to your cart before checking out.</p>
                    <a href="{{ route('courses.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        Browse Courses
                    </a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>