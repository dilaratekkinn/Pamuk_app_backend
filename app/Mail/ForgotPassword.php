<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    protected $url;
    public function __construct($url)
    {
        $this->url=$url;
    }

    public function build()
    {
        return $this->subject('Reset Password')
            ->markdown('email.forgot-password')
            ->with(['url' => $this->url]);
    }
}
