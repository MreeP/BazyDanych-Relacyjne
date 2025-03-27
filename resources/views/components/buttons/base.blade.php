<button {{ $attributes->merge(['type' => 'submit'])->class(['rounded-md px-3 py-2 text-sm font-semibold shadow-sm']) }}>
    {{ $slot }}
</button>
