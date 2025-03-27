<div aria-live="assertive" class="pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6" x-data="notification" x-cloak>
    <div class="flex w-full flex-col items-center space-y-4 sm:items-end">
        <div class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black/5" x-bind="notification_body">
            {{ $slot }}
        </div>
    </div>
</div>
