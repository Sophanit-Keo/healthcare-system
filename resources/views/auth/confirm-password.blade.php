<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Please confirm your password before continuing.
    </div>

    <form method="POST" action="{{ route('password.confirm.store') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error class="mt-2" :messages="$errors->get('password')" />
        </div>

        <div class="flex items-center justify-end">
            <x-primary-button>
                Confirm
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

