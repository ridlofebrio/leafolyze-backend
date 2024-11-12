<header class="sticky top-0 z-10">
    <nav id="navbar" class="relative bg-white transition-shadow duration-300">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <!-- Logo Section -->
                <div class="flex-shrink-0">
                    <a href="/" class="flex items-center">
                        <x-application-logo class="h-10 fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Menu -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-center space-x-4">
                        <a href="#home"
                            class="active nav-link rounded-md px-3 py-2 text-sm font-medium text-gray-800 hover:text-[#417777]">Home</a>
                        <a href="#about"
                            class="nav-link rounded-md px-3 py-2 text-sm font-medium text-gray-800 hover:text-[#417777]">About</a>
                        <a href="#features"
                            class="nav-link rounded-md px-3 py-2 text-sm font-medium text-gray-800 hover:text-[#417777]">Features</a>
                        <a href="#faq"
                            class="nav-link rounded-md px-3 py-2 text-sm font-medium text-gray-800 hover:text-[#417777]">FAQ</a>
                    </div>
                </div>

                <!-- Login/Register Buttons -->
                <div class="hidden md:block">
                    <div class="flex items-center space-x-4">
                        <a href="/login"
                            class="rounded-md px-3 py-2 text-sm font-medium text-gray-800 hover:text-gray-600">Login</a>
                        <a href="/register"
                            class="rounded-md bg-[#417777] px-4 py-2 text-sm font-medium text-white hover:bg-[#345f5f]">Register</a>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-md p-2 text-gray-800 hover:bg-gray-100 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
                        aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="hidden bg-white md:hidden" id="mobile-menu">
            <div class="space-y-1 px-2 pb-3 pt-2">
                <a href="/"
                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-800 hover:bg-gray-100">Home</a>
                <a href="/features"
                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-800 hover:bg-gray-100">Features</a>
                <a href="/pricing"
                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-800 hover:bg-gray-100">Pricing</a>
                <a href="/about"
                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-800 hover:bg-gray-100">About</a>
                <a href="/contact"
                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-800 hover:bg-gray-100">Contact</a>
            </div>
        </div>

    </nav>
</header>
