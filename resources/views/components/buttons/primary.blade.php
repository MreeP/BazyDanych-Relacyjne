<x-buttons.base {{ $attributes->class(['bg-indigo-600 dark:bg-indigo-500 text-white hover:bg-indigo-500 dark:hover:bg-indigo-400 focus-visible:outline-indigo-600 dark:focus-visible:outline-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2']) }}>
    @if($slot->isNotEmpty())
        {{ $slot }}
    @else
        {{ $text }}
    @endif
</x-buttons.base>
