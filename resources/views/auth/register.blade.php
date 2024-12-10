<x-guest-layout>
    <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
        @csrf

        <header>
            <h1 class="text-xl font-semibold text-gray-800">{{ __('Register') }}</h1>
        </header>
        <!-- User Information Section -->
        <div class="rounded-lg bg-white">
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
