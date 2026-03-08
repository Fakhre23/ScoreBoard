<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">

    @php
        $notifications = auth()->user()->unreadNotifications;
    @endphp

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Home') }}
                    </x-nav-link>
                </div>

            </div>

            <!-- Right Side -->
            <div class="hidden sm:flex sm:items-center sm:ms-12 space-x-5">

                <!--Notification Dropdown -->
                <x-dropdown align="right" width="80">
                    <x-slot name="trigger">
                        <button
                            class="relative inline-flex items-center p-2 text-gray-500 hover:text-gray-700 focus:outline-none">

                            <!-- Bell Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405C18.21 15.21 18 14.7 18 14.172V11
a6.002 6.002 0 00-4-5.659V5
a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.172
c0 .528-.21 1.038-.595 1.423L4 17h5m6 0
a3 3 0 11-6 0m6 0H9" />
                            </svg>

                            @if ($notifications->count())
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1">
                                    {{ $notifications->count() }}
                                </span>
                            @endif

                        </button>
                    </x-slot>

                    <x-slot name="content">

                        <div class="max-h-80 overflow-y-auto">

                            @if ($notifications->count())

                                @foreach ($notifications as $notification)
                                    <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                        @csrf

                                        <button type="submit"
                                            class="block w-full text-left px-8 py-3 text-sm text-gray-700 hover:bg-gray-200">

                                            {{ $notification->data['message'] }}

                                        </button>

                                    </form>
                                @endforeach
                            @else
                                <div class="px-4 py-2 text-sm text-gray-500">
                                    No new notifications
                                </div>

                            @endif

                        </div>

                    </x-slot>
                </x-dropdown>

                <!-- User Settings Dropdown -->
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">

                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10
10.586l3.293-3.293a1 1 0 111.414
1.414l-4 4a1 1 0 01-1.414
0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>

                        </button>
                    </x-slot>

                    <x-slot name="content">

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>

                        </form>

                    </x-slot>

                </x-dropdown>

            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">

                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />

                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />

                    </svg>

                </button>
            </div>

        </div>
    </div>

</nav>
