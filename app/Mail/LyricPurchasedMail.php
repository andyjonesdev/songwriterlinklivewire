<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LyricPurchasedMail extends Mailable
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
            ->subject('New Lyric Purchase')
            ->view('emails.lyric-purchased');
    }

}
