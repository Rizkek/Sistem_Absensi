@props(['title', 'description' => null, 'icon' => null, 'action' => null])

<div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md transition-shadow h-full flex flex-col">
    <!-- Header -->
    <div class="flex items-start justify-between mb-4">
        <div class="flex-1">
            @if ($icon)
                <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-emerald-600">{{ $icon }}</svg>
                </div>
            @endif
            <h3 class="font-semibold text-gray-900 text-lg">{{ $title }}</h3>
            @if ($description)
                <p class="text-sm text-gray-600 mt-1">{{ $description }}</p>
            @endif
        </div>
        @if ($action)
            <button class="p-2 hover:bg-gray-100 rounded-lg transition text-gray-600">
                {{ $action }}
            </button>
        @endif
    </div>

    <!-- Content -->
    <div class="flex-1">
        {{ $slot }}
    </div>

    <!-- Footer Optional -->
    @isset($footer)
        <div class="mt-4 pt-4 border-t border-gray-100">
            {{ $footer }}
        </div>
    @endisset
</div>
