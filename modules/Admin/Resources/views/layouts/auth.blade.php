<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
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
    <body class="font-sans antialiased h-full">
        <div class="flex min-h-full">
            <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
                <div class="mx-auto w-full max-w-sm lg:w-96 space-y-6">
                    <div>
                        <img class="h-10 w-auto" src="https://tailwindui.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
                        <x-texts.headers.header-2 :text="$header" />

                        @if(\Illuminate\Support\Facades\Session::has(\Modules\Customer\View\Components\AuthLayout::SESSION_STATUS))
                            <div @class([
                            "text-md",
                            match (\Illuminate\Support\Facades\Session::get(\Modules\Customer\View\Components\AuthLayout::SESSION_STATUS_TYPE)) {
                                \Modules\Customer\View\Components\AuthLayout::STATUS_SUCCESS => 'text-green-500',
                                \Modules\Customer\View\Components\AuthLayout::STATUS_ERROR => 'text-red-500',
                                \Modules\Customer\View\Components\AuthLayout::STATUS_INFO => 'text-blue-500',
                                default => 'text-gray-500',
                            },
                        ])>
                                {{ \Illuminate\Support\Facades\Session::get(\Modules\Customer\View\Components\AuthLayout::SESSION_STATUS) }}
                            </div>
                        @endif

                        @if(is_a($description, \Illuminate\View\ComponentSlot::class))
                            {{ $description }}
                        @elseif(is_string($description))
                            <p class="mt-2 text-sm/6 text-gray-500">
                                {{ $description }}
                            </p>
                        @endif
                    </div>

                    <div>
                        {{ $slot }}
                    </div>
                </div>
            </div>
            <div class="relative hidden w-0 flex-1 lg:block">
                <img class="absolute inset-0 h-full w-full object-cover" src="https://images.unsplash.com/photo-1496917756835-20cb06e75b4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1908&q=80" alt="">
            </div>
        </div>

        @livewireScriptConfig
    </body>
</html>
