<x-buttons.base {{ $attributes->class(['bg-white dark:bg-white/10 text-gray-900 dark:text-white ring-gray-300 dark:ring-transparent hover:bg-gray-50 dark:hover:bg-white/20 ring-1 dark:ring-0 ring-inset dark:ring-inset']) }}>
    {{ $text ?? $slot }}
</x-buttons.base>
