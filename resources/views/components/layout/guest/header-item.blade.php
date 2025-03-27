@php
    /** @var \App\Helpers\Menu\Contracts\MenuItem $item */
@endphp
<a href="{{ $item->href() }}" class="text-sm/6 font-semibold text-gray-900">
    {{ $item->title() }}
</a>
