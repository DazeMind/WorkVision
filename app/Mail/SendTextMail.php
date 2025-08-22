<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendTextMail extends Mailable
{
    use Queueable, SerializesModels;

    public $asunto;
    public $data;

    public function __construct($asunto, $data)
    {
        $this->asunto = $asunto;
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject($this->asunto)
                    ->view('correo.OrdenCreate') // Vista con el contenido del correo
                    ->with('data', $this->data);         
    }
    
}
