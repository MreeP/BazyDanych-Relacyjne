<div x-data="slidein">
    <div class="relative z-50 lg:hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/80" aria-hidden="true" x-bind="fadeIn"></div>
        <div class="fixed inset-0 flex" x-bind="slideFromLeft">
            <div class="relative mr-16 flex w-full max-w-xs flex-1">
                <div class="absolute left-full top-0 flex w-16 justify-center pt-5" x-bind="fadeIn">
                    <button type="button" class="-m-2.5 p-2.5" x-bind="closingTrigger">
                        <span class="sr-only">{{ __('Close sidebar') }}</span>
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-2" x-bind="areaOfInterest">
                    <div class="flex h-16 shrink-0 items-center">
                        <img class="h-8 w-auto" src="https://tailwindui.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
                    </div>
                    <nav class="flex flex-1 flex-col">
                        <ul role="list" class="flex flex-1 flex-col gap-y-7">
                            <li>
                                <ul role="list" class="-mx-2 space-y-1">
                                    @foreach(menu(\App\Helpers\Menu\Contracts\MenuProvider::CUSTOMER) as $item)
                                        <x-customer::layout.app.menu-item :item="$item" />
                                    @endforeach
                                </ul>
                            </li>
                            <li class="-mx-6 mt-auto flex items-center justify-between px-6 py-3">
                                <div class="flex items-center justify-center space-x-3">
                                    <img class="size-10 rounded-full bg-gray-50" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">

                                    <a href="{{ \Illuminate\Support\Facades\URL::route('customer.profile.edit') }}" class="flex flex-col justify-center text-sm font-semibold text-gray-900">
                                        <span aria-hidden="true">{{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
                                        <span class="text-gray-600">{{ __('Your profile') }}</span>
                                    </a>
                                </div>

                                <form action="{{ route('customer.auth.logout') }}" method="POST" class="flex-shrink-0">
                                    @csrf

                                    <button>
                                        <span class="sr-only">{{ __('Logout') }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-700">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                        </svg>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Static sidebar for desktop -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6">
            <div class="flex h-16 shrink-0 items-center">
                <img class="h-8 w-auto" src="https://tailwindui.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
            </div>
            <nav class="flex flex-1 flex-col">
                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li>
                        <ul role="list" class="-mx-2 space-y-1">
                            @foreach(menu(\App\Helpers\Menu\Contracts\MenuProvider::CUSTOMER) as $item)
                                <x-customer::layout.app.menu-item :item="$item" />
                            @endforeach
                        </ul>
                    </li>
                    <li class="-mx-6 mt-auto flex items-center justify-between px-6 py-3">
                        <div class="flex items-center justify-center space-x-3">
                            @svg('heroicon-o-user-circle', ['class' => 'size-10 bg-gray-50'])

                            <a href="{{ \Illuminate\Support\Facades\URL::route('customer.profile.edit') }}" class="flex flex-col justify-center text-sm font-semibold text-gray-900">
                                <span aria-hidden="true">{{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
                                <span class="text-gray-600">{{ __('Your profile') }}</span>
                            </a>
                        </div>

                        <form action="{{ route('customer.auth.logout') }}" method="POST" class="flex-shrink-0">
                            @csrf

                            <button>
                                <span class="sr-only">{{ __('Logout') }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-700">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                </svg>
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="sticky top-0 z-40 flex items-center gap-x-6 bg-white px-4 py-4 shadow-sm sm:px-6 lg:hidden">
        <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" x-bind="openingTrigger">
            <span class="sr-only">{{ __('Open sidebar') }}</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>

        @isset($header)
            <div class="flex-1 text-sm font-semibold leading-6 text-gray-900">
                {{ $header }}
            </div>
        @else
            <div class="flex-1"></div>
        @endisset
    </div>
</div>
