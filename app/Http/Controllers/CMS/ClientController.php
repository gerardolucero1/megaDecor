<?php

namespace App\Http\Controllers\CMS;

use App\Client;
use App\Telephone;
use App\MoralPerson;
use App\PhysicalPerson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->telefonos);

        /*
        Generar cadena aleatoria en PHP con str_shuffle
        */
        $caracteres = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-.#!';
        for($x = 0; $x < 10; $x++){
            $aleatoria = substr(str_shuffle($caracteres), 0, 10);
        }
         

        // Guardo un nuevo cliente.
        $cliente = new Client();
        $cliente->clave = $aleatoria;
        $cliente->save();

        // Obtengo el ultimo cliente guardado en la base de datos.
        $ultimoCliente = Client::orderBy('id', 'DESC')->pluck('id')->first();

        if($request->tipoPersona == 'fisica'){

            // Guardo una nueva persona fisica.
            $cliente = new PhysicalPerson();
            $cliente->cliente_id = $ultimoCliente;
            $cliente->about_id = $request->categoriaAbout;
            $cliente->nombre = $request->nombreCliente;
            $cliente->apellidoPaterno = $request->apellidoCliente;
            $cliente->apellidoMaterno = $request->apellidoCliente2;
            $cliente->email = $request->emailCliente;
            $cliente->nombreFacturacion = $request->nombreFacturacion;
            $cliente->direccionFacturacion = $request->direccionFacturacion;
            $cliente->coloniaFacturacion = $request->coloniaFacturacion;
            $cliente->numeroFacturacion = $request->numeroFacturacion;
            $cliente->rfcFacturacion = $request->rfcFacturacion;
            $cliente->emailFacturacion = $request->emailFacturacion;
            $cliente->save();

        }else{
            // Guardo una nueva persona moral.
            $cliente = new MoralPerson();

            $cliente->cliente_id = $ultimoCliente;
            $cliente->categoria_id = $request->categoriaCliente;
            $cliente->about_id = $request->categoriaAbout;
            $cliente->nombre = $request->nombreCliente;
            $cliente->nombreFacturacion = $request->nombreFacturacion;
            $cliente->direccionFacturacion = $request->direccionFacturacion;
            $cliente->coloniaFacturacion = $request->coloniaFacturacion;
            $cliente->numeroFacturacion = $request->numeroFacturacion;
            $cliente->rfcFacturacion = $request->rfcFacturacion;
            $cliente->emailFacturacion = $request->emailFacturacion;
            $cliente->save();
        }

        foreach ($request->telefonos as $telephone){
            $telefono = new Telephone();

            $telefono->cliente_id = $ultimoCliente;
            $telefono->nombre = $telephone['nombre'];
            $telefono->email = $telephone['email'];
            $telefono->tipo = $telephone['tipo'];
            $telefono->numero = $telephone['numero'];
            $telefono->ext = $telephone['ext'];
            $telefono->save();

        }
        
    }
}
