<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite('resources/js/app.js')

        <!-- Styles -->
        @livewireStyles
        @vite('resources/css/app.css')
    </head>
    <body class="font-sans antialiased">
        <div>
            <x-customer::layout.app.sidebar :header="$header" />

            <main class="py-10 lg:pl-72">
                <div class="px-4 sm:px-6 lg:px-8 space-y-6">
                    <h1 class="font-bold text-2xl hidden lg:block">
                        {{ $header }}
                    </h1>

                    <div>
                        <div class="-mt-6 lg:mt-0">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <x-notifications.alpine-body>
            <div class="p-4">
                <div class="flex items-center">
                    <div class="flex w-0 flex-1 justify-between">
                        <p class="w-0 flex-1 text-sm font-medium text-gray-900" x-bind="text_container"></p>
                    </div>
                    <div class="ml-4 flex shrink-0">
                        <button type="button" x-bind="close_button" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <span class="sr-only">{{ __('Close') }}</span>
                            @svg('heroicon-o-x-mark', ['class' => 'size-5'])
                        </button>
                    </div>
                </div>
            </div>
        </x-notifications.alpine-body>

        @livewireScriptConfig
    </body>
</html>
