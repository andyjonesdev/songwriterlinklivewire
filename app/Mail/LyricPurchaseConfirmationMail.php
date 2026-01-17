<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LyricPurchaseConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $purchase;

    public function __construct($purchase)
    {
        $this->purchase = $purchase;
    }

    public function build()
    {
        return $this
            ->subject('Your Lyric Purchase from SongwriterLink')
            ->view('emails.buyer-lyric-purchased');
    }
}
