<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $userEmail;
    /**
     * Create a new message instance.
     */
    public function __construct($otp, $userEmail)
    {
        //
        $this->otp = $otp;
        $this->userEmail = $userEmail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    // 
    

    public function build()
    {
        return $this
            ->from('bookaholic@laravel.com')
            ->to($this->userEmail)
            ->subject('OTP to update password')
            ->markdown('mails.mail', ['otp' => $this->otp]);
        // return $this->view('view.name');
    }
}
