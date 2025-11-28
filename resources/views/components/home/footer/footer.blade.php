<footer class="bg-dark-900 border-t border-slate-700 py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">E‑Learning Platform</h3>
                <p class="text-slate-400">Learn from industry experts and enhance your skills with our wide range of
                    courses.</p>
            </div>

            <x-home.footer.quick-links title="Quick Links" :links="[
        ['text' => 'Home', 'url' => '#'],
        ['text' => 'Courses', 'url' => '#'],
        ['text' => 'About Us', 'url' => '#'],
        ['text' => 'Contact', 'url' => '#']
    ]" />

            <x-home.footer.quick-links title="Categories" :links="[
        ['text' => 'Programming', 'url' => '#'],
        ['text' => 'Design', 'url' => '#'],
        ['text' => 'Business', 'url' => '#'],
        ['text' => 'Photography', 'url' => '#']
    ]" />
        </div>

        <div class="border-t border-slate-700 mt-8 pt-8 text-center text-slate-500">
            <p>&copy; {{ date('Y') }} E‑Learning Platform. All rights reserved.</p>
        </div>
    </div>
</footer>