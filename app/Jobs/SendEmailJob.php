<?php

namespace App\Jobs;

use App\Mail\SendMailAdmin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $emailDetails;

    public function __construct($emailDetails)
    {
        $this->emailDetails = $emailDetails;
    }

    public function handle()
    {
        Mail::to($this->emailDetails['email'])->send(new SendMailAdmin($this->emailDetails));
    }
}
