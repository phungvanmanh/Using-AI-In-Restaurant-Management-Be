<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMailAdmin extends Mailable
{
    use Queueable, SerializesModels;
    protected $emailDetails;

    public function __construct($emailDetails)
    {
        $this->emailDetails = $emailDetails;
    }

    public function build()
    {
        return $this->subject($this->emailDetails['tieu_de'])->view('send_mail_admin', [
            'emailDetails'  => $this->emailDetails,
        ]);
    }

}
