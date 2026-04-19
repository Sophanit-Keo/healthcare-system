<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Delete Account
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Once your account is deleted, all of its resources and data will be permanently deleted.
        </p>
    </header>

    <form method="POST" action="{{ route('profile.destroy') }}" class="mt-6 space-y-4">
        @csrf
        @method('DELETE')

        <div>
            <x-input-label for="delete_password" value="Confirm password" />
            <x-text-input id="delete_password" name="password" type="password" class="mt-1 block w-full" autocomplete="current-password" required />
            <x-input-error class="mt-2" :messages="$errors->get('password')" />
        </div>

        <div>
            <x-danger-button type="submit">
                Delete Account
            </x-danger-button>
        </div>
    </form>
</section>

