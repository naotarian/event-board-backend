<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventContactMail extends Mailable
{
    use Queueable, SerializesModels;
     protected $title;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($admin_flag)
    {
        $this->title = $admin_flag ? 'お問い合わせがありました。':'お問い合わせが完了しました。';
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
                    ->view('emails.event_contact');
    }
}
