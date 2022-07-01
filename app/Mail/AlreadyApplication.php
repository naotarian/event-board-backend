<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AlreadyApplication extends Mailable
{
    use Queueable, SerializesModels;
     protected $title;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->title = 'お申し込み済みのメールアドレスです。';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), 'サービス名')
                    ->subject($this->title)
                    ->view('emails.already_application');
    }
}
