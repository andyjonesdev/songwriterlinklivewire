<x-layouts.onboarding>
    <div class="flex flex-col gap-6">
        {{-- Progress bar matching the wizard --}}
        <div>
            <div class="mb-1.5 flex items-center justify-between text-xs text-zinc-400">
                <span>Step 2 of 10 — Account</span>
                <span>20%</span>
            </div>
            <div class="h-1 w-full overflow-hidden rounded-full bg-zinc-100">
                <div class="h-full w-[20%] rounded-full bg-violet-600"></div>
            </div>
        </div>

        <x-auth-header
            :title="__('Create your account')"
            :description="__('Enter your details to continue your membership application')"
        />

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-4">
            @csrf

            <flux:input name="name" :label="__('Full name')" :value="old('name')" type="text" required autofocus autocomplete="name" :placeholder="__('Your name')" />
            <flux:input name="email" :label="__('Email address')" :value="old('email')" type="email" required autocomplete="email" placeholder="you@example.com" />
            <flux:input name="password" :label="__('Password')" type="password" required autocomplete="new-password" :placeholder="__('Password')" viewable />
            <flux:input name="password_confirmation" :label="__('Confirm password')" type="password" required autocomplete="new-password" :placeholder="__('Confirm password')" viewable />

            <flux:button type="submit" variant="primary" class="w-full mt-2">
                {{ __('Create account') }}
            </flux:button>
        </form>

        <p class="text-center text-sm text-zinc-500">
            Already have an account?
            <a href="{{ route('login') }}" class="text-violet-600 hover:underline" wire:navigate>Sign in</a>
        </p>
    </div>
</x-layouts.onboarding>
