<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Forgot your password? Enter your email and we'll send a reset link.
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center justify-end">
            <x-primary-button>
                Email Password Reset Link
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

