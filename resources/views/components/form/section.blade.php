<div {{ $attributes->class(['md:grid md:grid-cols-3 md:gap-6']) }}>
    <x-form.title :title="$title" :description="$description" />

    <div class="mt-5 md:mt-0 md:col-span-2">
        {{ $slot }}
    </div>
</div>
