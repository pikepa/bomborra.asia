<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscribedEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public string $OTP;

    public int $ID;

    public string $subj = 'Please confirm your subscription to Bomborra Media';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $OTP, int $ID)
    {
        $this->OTP = $OTP;
        $this->ID = $ID;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->subj)->markdown('mail.subscribed-email', ['OTP' => $this->OTP, 'ID' => $this->ID]);
    }
}
