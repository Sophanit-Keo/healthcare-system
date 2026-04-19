<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Please confirm access to your account by entering the authentication code provided by your authenticator application.
        You may also use a recovery code.
    </div>

    <form method="POST" action="{{ route('two-factor.login.store') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="code" value="Authentication code" />
            <x-text-input id="code" class="mt-1 block w-full" type="text" name="code" autofocus inputmode="numeric" autocomplete="one-time-code" />
            <x-input-error class="mt-2" :messages="$errors->get('code')" />
        </div>

        <div>
            <x-input-label for="recovery_code" value="Recovery code" />
            <x-text-input id="recovery_code" class="mt-1 block w-full" type="text" name="recovery_code" autocomplete="one-time-code" />
            <x-input-error class="mt-2" :messages="$errors->get('recovery_code')" />
        </div>

        <div class="flex items-center justify-end">
            <x-primary-button>
                Log in
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

