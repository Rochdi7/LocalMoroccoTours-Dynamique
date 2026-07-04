<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActivityReservationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $data;
    public $slug;

    public function __construct($data, $slug)
    {
        $this->data = $data;
        $this->slug = $slug;
    }

    public function build()
    {
        return $this->subject('New Activity Reservation')
                    ->view('emails.activity-reservation');
    }
}
