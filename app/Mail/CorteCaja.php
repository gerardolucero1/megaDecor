<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CorteCaja extends Mailable
{
    use Queueable, SerializesModels;

    public $sesion;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sesion)
    {
        $this->sesion  = $sesion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.corteCaja')
            ->from('IVONNEARROYOSG@MSN.COM', 'Mega Mundo Decor')
            ->subject('Corte de caja');
    }
}
