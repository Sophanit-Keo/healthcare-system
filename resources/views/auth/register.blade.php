<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - one Healthcare</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">
</head>

<body>
    <div class="auth-wrap">

        <aside class="auth-panel">
            ...
        </aside>

        <main class="auth-form-wrap">
            <div class="auth-form-box">

                <div class="form-header">
                    <span class="eyebrow">New Account</span>
                    <h1>Create your account</h1>
                    <p>Start your journey to better health today â€” it's completely free.</p>
                </div>

                @if ($errors->any())
                <div class="alert-error">
                    @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="field-group">
                        <x-input-label for="name" :value="__('Name')" />
                        <div class="field-wrap">
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autofocus
                                autocomplete="name"
                                class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                                placeholder="John Doe">
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="field-group mt-3">
                        <x-input-label for="email" :value="__('Email')" />
                        <div class="field-wrap">
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="username"
                                class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                                placeholder="you@example.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="field-group mt-3">
                        <x-input-label for="phone" :value="__('Phone')" />
                        <div class="field-wrap">
                            <input
                                id="phone"
                                type="text"
                                name="phone"
                                value="{{ old('phone') }}"
                                required
                                autocomplete="tel"
                                class="{{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                placeholder="012 345 678">
                        </div>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div class="field-group mt-3">
                        <x-input-label for="password" :value="__('Password')" />
                        <div class="field-wrap">
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="new-password"
                                class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                                placeholder="Create password">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="field-group mt-3">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <div class="field-wrap">
                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="Repeat password">
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                    <div class="field-group mt-3">
                        <label for="user_type">Register as</label>
                        <div class="field-wrap">
                            <select
                                id="user_type"
                                name="user_type"
                                required
                                class="{{ $errors->has('user_type') ? 'is-invalid' : '' }}">

                                <option value="">-- Select Role --</option>
                                <option value="patient" {{ old('user_type') == 'patient' ? 'selected' : '' }}>
                                    Patient
                                </option>
                                <option value="doctor" {{ old('user_type') == 'doctor' ? 'selected' : '' }}>
                                    Doctor
                                </option>
                            </select>
                        </div>

                        @error('user_type')
                        <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit mt-4">
                        {{ __('Register') }}
                    </button>

                </form>

                <p class="form-footer">
                    Already registered?
                    <a href="{{ route('login') }}">Sign in</a>
                </p>

            </div>
        </main>

    </div>

</body>

</html>


