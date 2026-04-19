<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Sign in</h1>
        <p class="mt-1 text-sm text-gray-600">Use your email address or username.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="login" value="Email or Username" />
            <x-text-input id="login" name="login" type="text" class="mt-1 block w-full" :value="old('login')" required autofocus autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('login')" />
        </div>

        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required autocomplete="current-password" />
            <x-input-error class="mt-2" :messages="$errors->get('password')" />
        </div>

        <div class="flex items-center justify-between">
            <label class="inline-flex items-center">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('remember') ? 'checked' : '' }}>
                <span class="ms-2 text-sm text-gray-600">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-indigo-600 hover:text-indigo-700" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center">
                Log in
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 text-sm text-gray-600">
        <span>New here?</span>
        <a class="text-indigo-600 hover:text-indigo-700" href="{{ route('register') }}">Create an account</a>
    </div>
</x-guest-layout>

