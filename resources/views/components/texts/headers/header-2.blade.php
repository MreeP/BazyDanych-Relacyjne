<h2 {{ $attributes->class(['mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900']) }}>
    @if($slot->isNotEmpty())
        {{ $slot }}
    @else
        {{ $text }}
    @endif
</h2>
