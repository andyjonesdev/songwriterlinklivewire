<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lyric;
use App\Models\LyricPromote;
use Carbon\Carbon;

class AddPromotedLyric extends Component
{
    public $client_reference_id = '';

    protected $rules = [
        'client_reference_id' => 'required|string',
    ];

    public function submit()
    {
        $this->validate();

        $parts = explode('-', $this->client_reference_id);

        if (count($parts) !== 6 || $parts[0] !== 'pro') {
            $this->addError('client_reference_id', 'Must be in format: pro-{user_id}-{lyric_id}-{bid}-{placement}-{duration}');
            return;
        }

        [, , $lyric_id, $bid, $placement, $duration] = $parts;

        $lyric = Lyric::find($lyric_id);
        if (!$lyric) {
            $this->addError('client_reference_id', "Lyric #{$lyric_id} not found.");
            return;
        }

        $user_id = $lyric->user_id;

        if (!in_array($duration, ['1', '2', '4'])) {
            $this->addError('client_reference_id', 'Duration must be 1, 2, or 4.');
            return;
        }

        $starts = Carbon::now();

        if ($duration == 1) {
            $ends_at = $starts->copy()->addWeeks(1);
        } elseif ($duration == 2) {
            $ends_at = $starts->copy()->addWeeks(2);
        } else {
            $ends_at = $starts->copy()->addMonth();
        }

        LyricPromote::create([
            'stripe_session_id' => 'manual_' . uniqid(),
            'user_id'           => $user_id,
            'lyric_id'          => $lyric_id,
            'placement'         => $placement,
            'duration'          => $duration,
            'bid'               => $bid,
            'amount'            => 0,
            'starts_at'         => $starts,
            'ends_at'           => $ends_at,
        ]);

        session()->flash('success', "Promotion added for lyric #{$lyric_id} (user #{$user_id}), placement: {$placement}, duration: {$duration}.");

        $this->client_reference_id = '';
    }

    public function render()
    {
        return view('livewire.add-promoted-lyric');
    }
}
