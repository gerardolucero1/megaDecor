<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NuevoPresupuesto extends Mailable
{
    use Queueable, SerializesModels;

    public $presupuesto;
    public $inventario;
    public $festejados;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    
    public function __construct($presupuesto, $inventario, $festejados)
    {
        $this->presupuesto  = $presupuesto;
        $this->inventario   = $inventario;
        $this->festejados   = $festejados;
    }
    
    /*
    public function __construct()
    {
        //$this->presupuesto  = $presupuesto;
        //$this->inventario   = $inventario;
        //$this->festejados   = $festejados;
    }

    */

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.prueba')
            ->from('gerardo.lucero.glez@hotmail.com', 'Administrador')
            ->subject('Nuevo presupuesto creado');
    }
}
