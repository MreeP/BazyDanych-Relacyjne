@php
    if (!isset($name) && !isset($id) && !$attributes->wire('model')->value) {
        throw new \InvalidArgumentException('You must provide a name, id or wire:model attribute for the input.');
    }

    $name = $name ?? $attributes->wire('model')->value;
    $id = $id ?? $name;
    $error = $errors->has($id);
    $leftIcon = $leftIcon ?? null;
    $rightIcon = $rightIcon ?? null;
@endphp

<div {{ $attributes->only(['class']) }}>
    <div class="flex justify-between">
        <x-form.inputs.label :for="$id" :label="$label" :required="$required ?? false" />

        @if($optional ?? false)
            <span class="text-sm/6 text-gray-500">
                {{ __('Optional') }}
            </span>
        @endif
    </div>

    <div class="mt-2 grid grid-cols-1">
        <x-form.inputs.base-input {{ $attributes->except(['label', 'optional', 'leftIcon', 'rightIcon', 'class'])->merge(['id' => $id, 'name' => $name])->class([
            'col-start-1 row-start-1',
            'pl-10' => $leftIcon,
            'pl-3' => !$leftIcon,
            'pr-10' => $rightIcon || $error,
            'pr-3' => !($rightIcon || $error),
        ]) }}/>

        @if($leftIcon && is_string($leftIcon))
            @svg($leftIcon, \Illuminate\Support\Arr::toCssClasses([
                'pointer-events-none col-start-1 row-start-1 mr-3 size-5 self-center justify-self-end text-gray-400 sm:size-4',
            ]))
        @elseif($leftIcon && is_a($leftIcon, \Illuminate\View\ComponentSlot::class))
            {{ $leftIcon }}
        @endif

        @if($rightIcon && is_string($rightIcon))
            @svg($rightIcon, \Illuminate\Support\Arr::toCssClasses([
                'pointer-events-none col-start-1 row-start-1 mr-3 size-5 self-center justify-self-end text-gray-400 sm:size-4',
            ]))
        @elseif($rightIcon && is_a($rightIcon, \Illuminate\View\ComponentSlot::class))
            {{ $rightIcon }}
        @elseif($error)
            @svg('heroicon-c-exclamation-circle', 'pointer-events-none col-start-1 row-start-1 mr-3 size-5 self-center justify-self-end text-red-500 sm:size-4')
        @endif
    </div>

    @if($error)
        <x-form.inputs.error :id="$id" />
    @endif
</div>
