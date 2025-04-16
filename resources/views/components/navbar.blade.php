<nav id="navbar" class="bg-sky-800 fixed top-0 left-0 right-0 z-50 transition-transform duration-300">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-10">
        <div class="relative flex h-16 items-center justify-between">
            <div class="flex shrink-0 items-center">
                <span class="rounded-md text-sm font-medium text-white">{{ session('user_email') }}</span>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="relative rounded-full p-1 text-white hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</nav>


  