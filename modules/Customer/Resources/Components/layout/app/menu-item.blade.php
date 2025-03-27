@php
    /** @var \App\Helpers\Menu\Contracts\MenuItem $item */
@endphp

<li>
    <a href="{{ $item->href() }}" @class([
        "group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6" => true,
        "bg-gray-50 text-indigo-600" => $item->isActive(),
        "text-gray-600" => !$item->isActive(),
    ])>
        @svg($item->icon(), \Illuminate\Support\Arr::toCssClasses(['size-6' => true, 'text-indigo-600' => $item->isActive()]))
        {{ $item->title() }}
    </a>
</li>
