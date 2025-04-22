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
        <textarea {{ $attributes->merge(['id' => $id, 'name' => $name])->class([
            'block rounded-md bg-white py-1.5 text-base outline outline-1 -outline-offset-1 focus:outline focus:outline-2 focus:-outline-offset-2 sm:text-sm/6 disabled:opacity-50',
            'text-red-900 outline-red-300 placeholder:text-red-300 focus:outline-red-600' => $error,
            'text-gray-900 outline-gray-300 placeholder:text-gray-400 focus:outline-indigo-600' => !$error,
        ]) }}>@if($slot->isEmpty()){{ $value ?? '' }}@else{{ $slot }}@endif</textarea>
    </div>

    @if($error)
        <x-form.inputs.error :id="$id" />
    @endif
</div>
