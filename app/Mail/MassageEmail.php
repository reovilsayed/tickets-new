<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MassageEmail extends Mailable 
{
    use  SerializesModels;
    public $massage;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($massage)
    {
        $this->massage = (object) $massage;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    // public function envelope()
    // {
    //     return new Envelope(
    //         subject: $this->data->subject,
    //     );
    // }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    // public function content()
    // {
    //     return new Content(
    //         view: 'emails.notification',
    //     );
    // }
    public function build()
    {
        if($this->massage->parent){
            $email=$this->massage->email;
            $subject=$this->massage->user ? $this->massage->user->name.' send a massage' :$this->massage->email .'send a massage';
        }else{
            $email=$this->massage->shop->email;
            $subject='';
        }
       
        return $this->markdown('emails.massage')
                    ->subject($subject)
                    ->replyTo($email,$this->massage->shop->name);
    }
    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
