<?php

namespace App\Mail;

use App\Models\ShareAd;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class shareAdvert extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( ShareAd $shareAd)
    {
        $this->data = $shareAd;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("craiglist@yahoo.fr", "Craiglist System")
            ->subject("Annonce partagé")
            ->markdown('mail.share')
            ->with([
                'firstName' => $this->data->firstName,
                'lastName' => $this->data->lastName,
                'message' => $this->data->message,
                'linkUrl' => $this->data->linkUrl,
                'titleAd' => $this->data->titleAd
            ]);
    }
}
