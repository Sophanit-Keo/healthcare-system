<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Create account</h1>
        <p class="mt-1 text-sm text-gray-600">Patient registration creates your patient profile automatically.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" value="Full name" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="username" value="Username (optional)" />
            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username')" autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="phone" value="Phone (optional)" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone')" autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <x-input-label for="date_of_birth" value="Date of birth (optional)" />
                <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full" :value="old('date_of_birth')" />
                <x-input-error class="mt-2" :messages="$errors->get('date_of_birth')" />
            </div>

            <div>
                <x-input-label for="gender" value="Gender (optional)" />
                <x-text-input id="gender" name="gender" type="text" class="mt-1 block w-full" :value="old('gender')" />
                <x-input-error class="mt-2" :messages="$errors->get('gender')" />
            </div>
        </div>

        <div>
            <x-input-label for="address" value="Address (optional)" />
            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address')" autocomplete="street-address" />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
            <x-input-error class="mt-2" :messages="$errors->get('password')" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Confirm password" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
            <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center">
                Register
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 text-sm text-gray-600">
        <span>Already have an account?</span>
        <a class="text-indigo-600 hover:text-indigo-700" href="{{ route('login') }}">Sign in</a>
    </div>
</x-guest-layout>

