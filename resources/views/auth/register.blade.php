<x-guest-layout>
    <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
        @csrf

        <header>
            <h1 class="text-xl font-semibold text-gray-800">{{ __('Register') }}</h1>
        </header>
        <!-- User Information Section -->
        <div class="rounded-lg bg-white">
            <h2 class="mb-2 text-xl font-semibold text-gray-400">{{ __('User Information') }}</h2>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="mt-1 block w-full" type="text" name="name" :value="old('name')"
                        required autofocus autocomplete="name" placeholder="John Doe" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="mt-1 block w-full" type="email" name="email"
                        :value="old('email')" required autocomplete="username" placeholder="john.doe@example.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required
                        autocomplete="new-password" placeholder="Password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="mt-1 block w-full" type="password"
                        name="password_confirmation" required autocomplete="new-password"
                        placeholder="Confirm Password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>
        </div>

        <!-- Shop Information Section -->
        <div class="rounded-lg bg-white">
            <h2 class="mb-2 text-xl font-semibold text-gray-400">{{ __('Shop Information') }}</h2>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <!-- Shop Name -->
                <div>
                    <x-input-label for="shop_name" :value="__('Shop Name')" />
                    <x-text-input id="shop_name" class="mt-1 block w-full" type="text" name="shop_name"
                        :value="old('shop_name')" placeholder="Shop Name" required />
                    <x-input-error :messages="$errors->get('shop_name')" class="mt-2" />
                </div>

                <!-- Shop Address -->
                <div>
                    <x-input-label for="shop_address" :value="__('Shop Address')" />
                    <x-text-input id="shop_address" class="mt-1 block w-full" type="text" name="shop_address"
                        :value="old('shop_address')" placeholder="Shop Address" required />
                    <x-input-error :messages="$errors->get('shop_address')" class="mt-2" />
                </div>

                <!-- Shop Description -->
                <div class="col-span-1 md:col-span-2">
                    <x-input-label for="shop_description" :value="__('Shop Description')" />
                    <textarea id="shop_description" name="shop_description"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required rows="4">{{ old('shop_description') }}</textarea>
                    <x-input-error :messages="$errors->get('shop_description')" class="mt-2" />
                </div>

                <!-- Shop Operational Hours -->
                <div>
                    <x-input-label for="shop_operational" :value="__('Shop Operational Hours')" />
                    <x-text-input id="shop_operational" class="mt-1 block w-full" type="text" name="shop_operational"
                        :value="old('shop_operational')" placeholder="e.g., Monday-Friday 9:00 AM - 5:00 PM" required />
                    <x-input-error :messages="$errors->get('shop_operational')" class="mt-2" />
                </div>
            </div>
        </div>

        <!-- Registration Actions -->
        <div class="flex items-center justify-end">
            <a class="rounded-md text-sm text-gray-600 underline hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
