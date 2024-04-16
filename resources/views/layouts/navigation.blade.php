<nav class="flex flex-col lg:items-baseline lg:flex-row justify-between bg-white p-6 lg:p-12 ">

    <div>
        <div class="flex justify-between items-center">
            <a href="/dashboard">
                <h1 class="text-xl">LiveWire</h1>
            </a>

            <div class="flex items-center space-x-3 lg:space-x-7">
                <div class="p-3 lg:hidden">
                    @auth
                        <a href="{{ route('notifications') }}">
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                                </svg>
                                @if (auth()->user()->unreadNotifications()->count())
                                    <span class="absolute -top-2 text-white bg-red-600 rounded-full px-1 font-bold text-sm">
                                        {{ auth()->user()->unreadNotifications()->count() }}
                                    </span>
                                @endif
                            </div>
                        </a>
                    @endauth
                </div>

                <button onclick="toggleNav()" class="cursor-pointer lg:hidden">
                    <h1 class="text-xl">Menu</h1>
                </button>
            </div>
        </div>
        <div class="mt-4">
            <Search></Search>
        </div>
    </div>

    <div class="hidden lg:flex flex-col lg:flex-row lg:items-center gap-5 mt-5 lg:mt-0 move" id="navMenu">
        @guest
            <div class="text-base font-medium text-gray-800 dark:text-gray-200">{{ 'Guest' }}
            </div>
            <a href="/login">Login</a>
        @endguest

        @auth
            <a href="/dashboard" class="bg-gray-100 p-3 lg:bg-inherit lg:p-0">
                {{ __('Dashboard') }}
            </a>

            <a href="{{ route('profile.edit') }}" class="bg-gray-100 p-3 lg:bg-inherit lg:p-0">
                {{ Auth::user()?->name }}
            </a>

            <a class="cursor-pointer rounded-lg underline font-bold text-green-500 bg-gray-100 p-3 lg:bg-inherit lg:p-0"
                href="{{ route('post.create') }}">
                Create New Post
            </a>
        @endauth

        <a class="lg:ml-3 bg-gray-100 p-3 lg:bg-inherit lg:p-0" href="{{ route('category.index') }}">Categories</a>

        @auth
            <a class="lg:ml-3 bg-gray-100 p-3 lg:bg-inherit lg:p-0" href="{{ route('users') }}">Users</a>
        @endauth

        <div class="bg-gray-100 p-3 hidden lg:block">
            @auth
                <a href="{{ route('notifications') }}">
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                        </svg>
                        @if (auth()->user()->unreadNotifications()->count())
                            <span class="absolute -top-2 text-white bg-red-600 rounded-full px-1 font-bold text-sm">
                                {{ auth()->user()->unreadNotifications()->count() }}
                            </span>
                        @endif
                    </div>
                </a>
            @endauth
        </div>

        <!-- Authentication -->
        <form action="{{ route('logout') }}" method="POST" class='bg-gray-100 p-3 lg:bg-inherit lg:p-0'>
            @csrf

            <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                this.closest('form').submit();">
                {{ __('Log Out') }}
            </a>
        </form>
    </div>
</nav>
