<x-layouts.auth :title="'About Us'">
    <div class="min-h-screen flex flex-col bg-gradient-to-b from-dark-900 to-dark-800 text-white">

        {{-- Header --}}
        <x-home.header />

        {{-- Main Content --}}
        <main class="flex-grow py-12 px-4 lg:px-8">
            {{-- Flash Message Component --}}
            <x-flash-message />

            {{-- Hero Section --}}
            <section class="text-center mb-16">
                <h1 class="text-4xl md:text-6xl font-extrabold mb-6 bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
                    Learn Without Limits
                </h1>
                <p class="text-xl text-slate-400 max-w-4xl mx-auto">
                    Empowering millions of learners worldwide to acquire new skills, advance their careers, and explore their passions.
                </p>
            </section>

            {{-- Stats Section --}}
            <section class="container mx-auto mb-20">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                    <div class="bg-dark-800 rounded-lg p-6">
                        <div class="text-3xl font-bold text-blue-400 mb-2">2M+</div>
                        <div class="text-gray-400">Students Enrolled</div>
                    </div>
                    <div class="bg-dark-800 rounded-lg p-6">
                        <div class="text-3xl font-bold text-green-400 mb-2">500+</div>
                        <div class="text-gray-400">Expert Instructors</div>
                    </div>
                    <div class="bg-dark-800 rounded-lg p-6">
                        <div class="text-3xl font-bold text-purple-400 mb-2">5,000+</div>
                        <div class="text-gray-400">Courses Available</div>
                    </div>
                    <div class="bg-dark-800 rounded-lg p-6">
                        <div class="text-3xl font-bold text-yellow-400 mb-2">150+</div>
                        <div class="text-gray-400">Countries Reached</div>
                    </div>
                </div>
            </section>

            {{-- Mission Section --}}
            <section class="max-w-6xl mx-auto mb-20">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-3xl font-bold mb-6">Our Mission</h2>
                        <p class="text-gray-300 mb-4">
                            We believe that education should be accessible to everyone, everywhere. Our platform breaks down barriers to learning by providing high-quality courses at affordable prices.
                        </p>
                        <p class="text-gray-300">
                            Whether you're looking to advance your career, explore a new hobby, or gain new skills, we're here to support your learning journey every step of the way.
                        </p>
                    </div>
                    <div class="bg-dark-800 rounded-xl p-8">
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <i class="fas fa-graduation-cap text-blue-400 mt-1 mr-4"></i>
                                <div>
                                    <h3 class="font-semibold text-lg mb-2">Quality Education</h3>
                                    <p class="text-gray-400">Courses crafted by industry experts and experienced instructors</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-rocket text-green-400 mt-1 mr-4"></i>
                                <div>
                                    <h3 class="font-semibold text-lg mb-2">Career Advancement</h3>
                                    <p class="text-gray-400">Gain skills that employers are looking for in today's market</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-users text-purple-400 mt-1 mr-4"></i>
                                <div>
                                    <h3 class="font-semibold text-lg mb-2">Community Learning</h3>
                                    <p class="text-gray-400">Join a global community of learners and instructors</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Team Section --}}
            <section class="max-w-6xl mx-auto text-center">
                <h2 class="text-3xl font-bold mb-12">Meet Our Team</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-dark-800 rounded-xl p-6">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="CEO" class="w-24 h-24 rounded-full mx-auto mb-4">
                        <h3 class="text-xl font-semibold mb-2">Alex Johnson</h3>
                        <p class="text-blue-400 mb-3">CEO & Founder</p>
                        <p class="text-gray-400">Passionate about making education accessible to everyone</p>
                    </div>
                    <div class="bg-dark-800 rounded-xl p-6">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="CTO" class="w-24 h-24 rounded-full mx-auto mb-4">
                        <h3 class="text-xl font-semibold mb-2">Sarah Chen</h3>
                        <p class="text-green-400 mb-3">Chief Technology Officer</p>
                        <p class="text-gray-400">Building the future of online learning platforms</p>
                    </div>
                    <div class="bg-dark-800 rounded-xl p-6">
                        <img src="https://randomuser.me/api/portraits/men/67.jpg" alt="Head of Education" class="w-24 h-24 rounded-full mx-auto mb-4">
                        <h3 class="text-xl font-semibold mb-2">Marcus Rivera</h3>
                        <p class="text-purple-400 mb-3">Head of Education</p>
                        <p class="text-gray-400">Ensuring quality and excellence in every course</p>
                    </div>
                </div>
            </section>
        </main>

        {{-- Footer --}}
        <x-home.footer />

    </div>
</x-layouts.auth>