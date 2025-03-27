<a {{ $attributes->merge(['href' => '#'])->class(['font-semibold text-indigo-600 hover:text-indigo-500']) }}>
    @if($slot->isNotEmpty())
        {{ $slot }}
    @else
        {{ $text }}
    @endif
</a>
