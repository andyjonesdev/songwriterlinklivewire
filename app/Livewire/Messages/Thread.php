<?php

namespace App\Livewire\Messages;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\VerificationLog;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Thread extends Component
{
    public int    $conversationId;
    public string $newMessage = '';

    private const PAYMENT_KEYWORDS = [
        'send payment', 'bank transfer', 'cash app', 'venmo', 'paypal',
        'invoice', 'upfront', 'advance', '£', '$', 'fee', 'charge',
        'pay me', 'bank details', 'sort code', 'account number',
    ];

    public function mount(Conversation $conversation): void
    {
        // Ensure the current user is a participant
        if (! $conversation->participants->contains('id', auth()->id())) {
            abort(403);
        }

        $this->conversationId = $conversation->id;
        $this->markRead();
    }

    public function loadMessages(): void
    {
        $this->markRead();
    }

    public function sendMessage(): void
    {
        $user = auth()->user();

        if (! $user->isActive()) {
            $this->addError('newMessage', 'Your account must be active to send messages.');
            return;
        }

        $this->validate(['newMessage' => 'required|string|max:3000']);

        $body    = trim($this->newMessage);
        $flagged = $this->scanForPaymentKeywords($body);

        Message::create([
            'conversation_id' => $this->conversationId,
            'sender_id'       => $user->id,
            'body'            => $body,
            'flagged'         => $flagged,
            'flagged_reason'  => $flagged ? 'payment_keyword' : null,
            'created_at'      => now(),
        ]);

        if ($flagged) {
            VerificationLog::create([
                'user_id'    => $user->id,
                'event'      => 'message_flagged',
                'detail'     => ['conversation_id' => $this->conversationId, 'reason' => 'payment_keyword'],
                'created_at' => now(),
            ]);
        }

        // Update last_read_at for sender so the message they just sent is "read"
        $this->markRead();

        $this->newMessage = '';
    }

    private function markRead(): void
    {
        $conversation = Conversation::find($this->conversationId);

        $conversation->participants()->updateExistingPivot(auth()->id(), [
            'last_read_at' => now(),
        ]);
    }

    private function scanForPaymentKeywords(string $body): bool
    {
        $lower = mb_strtolower($body);
        foreach (self::PAYMENT_KEYWORDS as $keyword) {
            if (str_contains($lower, $keyword)) {
                return true;
            }
        }
        return false;
    }

    public function render()
    {
        $conversation = Conversation::with('participants.profile')->find($this->conversationId);

        $messages = Message::where('conversation_id', $this->conversationId)
            ->with('sender.profile')
            ->orderBy('created_at')
            ->get();

        $other = $conversation->participants->firstWhere('id', '!=', auth()->id());

        return view('livewire.messages.thread', compact('conversation', 'messages', 'other'));
    }
}
