<footer class="bg-[#1E1E1E] py-8 text-white">
    <div class="container mx-auto px-4">
        <div class="flex flex-col justify-between md:flex-row">
            <!-- Logo Section -->
            <div class="mb-4 md:mb-0">
                <a href="#" class="text-2xl font-bold">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="inline h-10">
                    Leafolyze
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="flex flex-col md:flex-row">
                <a href="#" class="mx-2 text-gray-400 hover:text-white">Home</a>
                <a href="#" class="mx-2 text-gray-400 hover:text-white">About</a>
                <a href="#" class="mx-2 text-gray-400 hover:text-white">Services</a>
                <a href="#" class="mx-2 text-gray-400 hover:text-white">Contact</a>
            </div>
        </div>

        <!-- Copyright Notice -->
        <div class="mt-4 text-center text-gray-400">
            &copy; {{ date('Y') }} Your Company. All rights reserved.
        </div>
    </div>
</footer>
