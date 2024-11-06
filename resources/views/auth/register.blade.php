<x-app-layout>
    <div class="mx-auto py-20 px-10 min-h-screen w-screen bg-amber-200 md:gap-6">
        {{-- <div class="mt-20 lg:mt-36 sm:mx-auto sm:w-full sm:max-w-lg lg:max-w-2xl px-10 lg:px-20 border-orange-300 border-4 h-96 rounded-xl shadow">
            <h2 class="mt-10 text-left text-2xl font-bold">Login to your account</h2>
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email">Email</label>
                    <div class="mt-2">
                        <input id="email" type="email" name="email" :value="old('email')" required class="block w-full mx-auto rounded-md border-1 border-blue-400 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-blue-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-300 sm:text-sm sm:leading-3">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="password">Password</label>
                    <div class="mt-2">
                        <input id="password" type="password" name="password" required class="block w-full mx-auto rounded-md border-1 border-blue-400 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-blue-300 placeholder:text-gray-400 ocus:ring-2 focus:ring-inset focus:ring-blue-300 sm:text-sm sm:leading-3">

                    </div>
                </div>

                <div class="flex items-center justify-between mt-4">
                    @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                    @endif
                    <div class="">
                        <button type="submit" class="py-2 px-5 rounded-md bg-sky-400 border-sky-600 border-1 font-semibold text-xl leading-6 text-white hover:bg-sky-500 shadow">Login</button>
                    </div>

                </div>
            </form>
        </div>

        end of login form --}}

        <div class="mt-20 lg:mt-36 sm:mx-auto sm:w-full sm:max-w-lg lg:max-w-2xl px-10 lg:px-20 pb-10 border-sky-300 border-4 rounded-xl shadow">
            <h2 class="mt-10 text-left text-2xl font-bold">New Customer</h2>
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                   <!-- Name -->
        {{-- <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div> --}}
                <div>
                    <label for="name">Username</label>
                    <div class="mt-2">
                        <input id="name" type="text" name="name" :value="old('name')" required class="block w-full mx-auto rounded-md border-1 border-blue-400 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-blue-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-300 sm:text-sm sm:leading-3">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="email">Email</label>
                    <div class="mt-2">
                        <input id="email" type="email" name="email" :value="old('email')" required class="block w-full mx-auto rounded-md border-1 border-blue-400 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-blue-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-300 sm:text-sm sm:leading-3">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="password">Password</label>
                    <div class="mt-2">
                        <input id="password" type="password" name="password" required class="block w-full mx-auto rounded-md border-1 border-blue-400 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-blue-300 placeholder:text-gray-400 ocus:ring-2 focus:ring-inset focus:ring-blue-300 sm:text-sm sm:leading-3">
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="py-2 px-8 rounded-md bg-sky-400 border-sky-600 border-1 font-semibold text-xl leading-6 text-white hover:bg-sky-500 shadow">Register</button>
                </div>
            </form>
        </div>

    </div>

    {{-- <x-guest-layout>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button class="ms-3">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout> --}}
    {{-- <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form> --}}
</x-app-layout>
