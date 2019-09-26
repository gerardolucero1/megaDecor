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
    public $Telefonos;
    public $Elementos;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    
    public function __construct($presupuesto, $Telefonos, $Elementos)
    {
        $this->presupuesto  = $presupuesto;
        $this->Telefonos   = $Telefonos;
        $this->Elementos   = $Elementos;
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
            ->from('ventasmegamundodecor@gmail.com', 'Mega Mundo Decor')
            ->subject('Nuevo presupuesto');
    }
}
