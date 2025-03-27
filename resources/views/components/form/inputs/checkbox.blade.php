@php
    if (!isset($name) && !isset($id) && !$attributes->wire('model')->value) {
        throw new \InvalidArgumentException('You must provide a name, id or wire:model attribute for the input.');
    }

    $name = $name ?? $attributes->wire('model')->value;
    $id = $id ?? $name;
    $error = $errors->has($id);
@endphp

<div {{ $attributes->only(['class']) }}>
    <div>
        <x-form.inputs.label :for="$id" :label="$label" />

        @if($required ?? false)
            <span class="text-red-500">
                *
            </span>
        @endif
    </div>

    <div class="">
        <x-form.inputs.base-input {{ $attributes->except(['label', 'optional', 'leftIcon', 'rightIcon', 'class'])->merge(['id' => $id, 'name' => $name, 'type' => 'checkbox']) }}/>
    </div>

    @if($error)
        <x-form.inputs.error :id="$id" />
    @endif
</div>
