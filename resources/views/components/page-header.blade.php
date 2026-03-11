@props(['title', 'subtitle' => null])

<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">{{ $title }}</h1>
        @if($subtitle)
            <p class="text-gray-500 mt-1">{{ $subtitle }}</p>
        @endif
    </div>
    @if(isset($actions))
        <div class="flex gap-3">
            {{ $actions }}
        </div>
    @endif
</div>