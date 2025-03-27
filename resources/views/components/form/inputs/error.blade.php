<p {{ $attributes->class(['mt-2 text-sm text-red-600']) }}>
    @if($slot->isNotEmpty())
        {{ $slot }}
    @else
        {{ $errors->first($id) }}
    @endif
</p>
