<form {{ $attributes->merge(['method' => 'POST']) }}>
    <x-cards.primary>
        <x-grids.cols-6>
            {{ $slot }}
        </x-grids.cols-6>
    </x-cards.primary>

    @if(isset($actions))
        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 dark:bg-gray-800 text-end sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
            {{ $actions }}
        </div>
    @endif
</form>
