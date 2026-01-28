<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header 
            :title="__('Create an account')" 
            :description="__('Enter your details below to create your account')" 
        />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Name -->
            <flux:input
                name="name"
                :label="__('Name')"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Full name')"
            />

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Email address')"
                :value="old('email')"
                type="email"
                required
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <flux:input
                name="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Password')"
                viewable
            />

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                :label="__('Confirm password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Confirm password')"
                viewable
            />

            @php
                $roleFromUrl = request('role');
            @endphp

            <!-- Role Selection -->
            <div class="flex flex-col gap-2">
                <label class="block font-semibold">{{ __('Register as') }}</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2">
                        <input
                            type="radio"
                            name="role"
                            value="buyer"
                            {{ old('role', $roleFromUrl ?? 'buyer') === 'buyer' ? 'checked' : '' }}
                            required
                        />
                        {{ __('Buyer') }}
                    </label>

                    <label class="flex items-center gap-2">
                        <input
                            type="radio"
                            name="role"
                            value="seller"
                            {{ old('role', $roleFromUrl) === 'seller' ? 'checked' : '' }}
                            required
                        />
                        {{ __('Seller') }}
                    </label>
                </div>

                @error('role')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            @php
                $a = rand(1,9);
                $b = rand(1,9);
                session(['captcha_answer' => $a + $b]);
            @endphp

            <!-- Captcha -->
            <flux:input
                name="captcha"
                :label="__('Human check')"
                type="text"
                required
                :placeholder="__('What is ' . $a . ' + ' . $b . '?')"
            />

            @error('captcha')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror


            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                    {{ __('Create account') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Already have an account?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
        </div>
    </div>
</x-layouts.auth>
