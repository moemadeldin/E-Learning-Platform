@props([
    'category',
    'title',
    'description',
    'courseThumbnail',
    'lessons',
    'hours',
    'levelText',
    'levelColorFrom',
    'levelColorTo',
    'rating',
    'instructorName',
    'instructorImage',
    'price',
    'badgeText' => null,
    'badgeColor' => 'bg-yellow-400',
    'labelColor' => 'bg-dark-900',
    'labelTextColor' => 'text-black',
    'courseUrl' => ''
])

<div class="course-card bg-dark-700 rounded-xl overflow-hidden shadow-lg">
    <div class="relative h-40">
        {{-- Actual Course Thumbnail --}}
        <a href="{{ $courseUrl }}" class="w-full h-full">
            <img src="{{ $courseThumbnail }}" alt="Course Thumbnail" class="w-full h-full object-cover">
        </a>

        {{-- Badge --}}
        @if ($badgeText)
            <span class="absolute top-4 right-4 {{ $badgeColor }} text-slate-900 text-xs font-bold px-2 py-1 rounded-full">
                {{ $badgeText }}
            </span>
        @endif

        {{-- Category Label --}}
        <div class="absolute bottom-4 left-4">
            <span class="bg-black bg-opacity-60 text-white text-sm px-3 py-1 rounded-full">
                {{ $category }}
            </span>
        </div>
    </div>

    <div class="p-5">
        <a href="{{ $courseUrl }}">
            <h3 class="text-lg font-bold text-white mb-1">{{ $title }}</h3>
        </a>
        <p class="text-slate-400 text-sm mb-4">{{ $description }}</p>
        <div class="flex justify-between text-sm text-slate-500 mb-3">
            <div><i class="far fa-list-alt mr-2"></i>{{ $lessons }} Lessons</div>
        </div>

        <div class="flex justify-between items-center mb-4">
            <span class="px-3 py-1 text-xs bg-gradient-to-r from-{{ $levelColorFrom }} to-{{ $levelColorTo }} text-white rounded-full">{{ $levelText }}</span>
            <div class="flex items-center text-yellow-400">
                <i class="fas fa-star mr-1"></i> {{ $rating }}
            </div>
        </div>

        <div class="flex justify-between items-center border-t border-slate-600 pt-4">
            <div class="flex items-center">
                <img src="{{ $instructorImage }}" alt="Instructor" class="w-8 h-8 rounded-full mr-2">
                <span class="text-slate-300 text-sm">{{ $instructorName }}</span>
            </div>
            <span class="text-green-400 font-bold text-lg">{{ $price }}</span>
        </div>
    </div>
</div>
