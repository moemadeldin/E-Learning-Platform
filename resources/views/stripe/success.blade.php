{{-- resources/views/success.blade.php --}}
<!DOCTYPE html>
<html>

<head>
    <title>Payment Successful</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto text-center">
            @if(isset($session) && $session->payment_status === 'paid')
                <!-- Success State -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>

                    <h1 class="text-3xl font-bold text-gray-900 mb-4">Payment Successful! 🎉</h1>

                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                        <p class="text-green-800 font-medium">Thank you for your purchase!</p>
                        <p class="text-green-700 text-sm mt-1">
                            You have been enrolled in your courses. Check your email for confirmation.
                        </p>
                    </div>

                    <div class="text-left bg-gray-50 rounded-lg p-4 mb-6">
                        <h3 class="font-semibold text-gray-900 mb-2">Order Details:</h3>
                        <p class="text-sm text-gray-600">Payment ID: {{ $session->id }}</p>
                        <p class="text-sm text-gray-600">
                            Amount: £{{ number_format($session->amount_total / 100, 2) }}
                        </p>
                        <p class="text-sm text-gray-600">Status: {{ ucfirst($session->payment_status) }}</p>
                    </div>

                    <div class="space-y-4">
                        {{-- <a href="{{ route('my-courses') }}"
                            class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                            Go to My Courses
                        </a> --}}
                        <a href="{{ route('home') }}"
                            class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition duration-200">
                            Return to Homepage
                        </a>
                    </div>
                </div>
            @else
                <!-- Error State -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </div>

                    <h1 class="text-3xl font-bold text-gray-900 mb-4">Payment Issue</h1>

                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <p class="text-red-800">
                            {{ $error ?? 'There was an issue processing your payment. Please contact support.' }}
                        </p>
                    </div>

                    <a href="{{ route('checkout') }}"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                        Return to Checkout
                    </a>
                </div>
            @endif
        </div>
    </div>
</body>

</html>