<label {{ $attributes->class(['block text-sm/6 font-medium text-gray-900']) }}>
    @if($slot->isNotEmpty())
        {{ $slot }}
    @else
        {{ $label }}
    @endif

    @if($required ?? false)
        <span class="text-red-500 select-none">
            *
        </span>
    @endif
</label>
