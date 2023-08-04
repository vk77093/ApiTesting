<?php

namespace App\Mail\Authorization;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;


class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $token;
    public function __construct($token)
    {
        $this->token=$token;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('vk77093@gmail.com', 'Vijay Kumar'),
            subject: 'Password Reset Mail',

        );
        // return new Envelope(
        //     from: new Address('jeffrey@example.com', 'Jeffrey Way'),
        //     subject: 'Order Shipped',
        // );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $data=$this->token;
        return new Content(
            view: 'MailSend.passwordReset',
            with:[
                'data'=>$data,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
