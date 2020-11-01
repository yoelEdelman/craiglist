<?php

namespace App\Mail;

use App\Models\ResponseMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailtrapResponseAdvert extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( ResponseMail $responseMail)
    {
        $this->data = $responseMail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->data->mail, $this->data->lastName)
            ->subject($this->data->subject)
            ->markdown('mail.email')
            ->with([
                'firstName' => $this->data->firstName,
                'lastName' => $this->data->lastName,
                'subject' => $this->data->subject,
                'message' => $this->data->message,
                'nameUser' => $this->data->nameUser,
                'titleAd' => $this->data->titleAd
            ]);
    }
}
