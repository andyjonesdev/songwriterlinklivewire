<div>
    <flux:heading size="xl" class="text-center">Verify your phone number</flux:heading>
    <flux:subheading class="text-center">We'll send a 6-digit code by SMS. Your number is stored securely and never shared.</flux:subheading>

    @if(session('status'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('status') }}</div>
    @endif

    @if(!$smsSent)
        <div class="space-y-4">
            <flux:input wire:model="phone" label="Phone number" type="tel" placeholder="+44 7700 900000" autocomplete="tel" />
            @error('phone') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
            <flux:button wire:click="sendSmsCode" variant="primary" class="w-full">Send verification code</flux:button>
        </div>
    @else
        <div class="space-y-4">
            <p class="text-sm text-zinc-500">Enter the 6-digit code sent to <strong class="text-zinc-900">{{ $phone }}</strong></p>
            <flux:input wire:model="smsCode" label="Verification code" type="text" inputmode="numeric" maxlength="6" placeholder="000000" autofocus />
            @error('smsCode') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
            <flux:button wire:click="verifyPhone" variant="primary" class="w-full">Verify</flux:button>
            <button wire:click="$set('smsSent', false)" class="w-full text-sm text-zinc-400 hover:text-zinc-600">Wrong number? Go back</button>
        </div>
    @endif
</div>
