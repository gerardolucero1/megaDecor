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
    public $Paquetes;
    public $Elementos_paquete;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    
    public function __construct($presupuesto, $Telefonos, $Elementos, $Paquetes, $Elementos_paquete)
    {
        $this->presupuesto  = $presupuesto;
        $this->Telefonos   = $Telefonos;
        $this->Elementos   = $Elementos;
        $this->Paquetes = $Paquetes;
        $this->Elementos_paquete = $Elementos_paquete;
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
