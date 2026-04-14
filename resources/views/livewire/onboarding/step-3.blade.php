<div>
    <h1 class="mb-2 text-2xl font-bold">Verify your phone number</h1>
    <p class="mb-8 text-sm text-zinc-400">We'll send a 6-digit code by SMS. Your number is stored securely and never shared.</p>

    @if(session('status'))
        <div class="mb-4 rounded-lg bg-green-900/30 px-4 py-3 text-sm text-green-300">{{ session('status') }}</div>
    @endif

    @if(!$smsSent)
        <div class="space-y-4">
            <flux:input
                wire:model="phone"
                label="Phone number"
                type="tel"
                placeholder="+44 7700 900000"
                autocomplete="tel"
            />
            @error('phone') <p class="text-sm text-red-400">{{ $message }}</p> @enderror

            <flux:button wire:click="sendSmsCode" variant="primary" class="w-full">
                Send verification code
            </flux:button>
        </div>
    @else
        <div class="space-y-4">
            <p class="text-sm text-zinc-400">Enter the 6-digit code sent to <strong class="text-white">{{ $phone }}</strong></p>

            <flux:input
                wire:model="smsCode"
                label="Verification code"
                type="text"
                inputmode="numeric"
                maxlength="6"
                placeholder="000000"
                autofocus
            />
            @error('smsCode') <p class="text-sm text-red-400">{{ $message }}</p> @enderror

            <flux:button wire:click="verifyPhone" variant="primary" class="w-full">
                Verify
            </flux:button>

            <button wire:click="$set('smsSent', false)" class="w-full text-sm text-zinc-500 hover:text-zinc-300">
                Wrong number? Go back
            </button>
        </div>
    @endif
</div>
