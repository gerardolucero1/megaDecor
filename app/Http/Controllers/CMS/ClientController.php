<?php

namespace App\Http\Controllers\CMS;

use App\Client;
use App\Telephone;
use App\MoralPerson;
use App\PhysicalPerson;
use App\AboutCategory;
use App\MoralCategory;
use App\tipo_empresa;
use App\ComoLoSupo;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    // ESta funcion retorna todos los telefonos al formulario del cliente
    public function telefonos(){
        return Telephone::orderBy('id', 'DESC')->get();
    }

    // Esta funcion retorna todas las categorias de las personas morales a la vista clientes
    public function categorias(){
        return MoralCategory::orderBy('id', 'DESC')->get();   
    }

    

    // Esta funcion retorna todas las opciones de ¿Como nos conocio?
    public function aboutCategorias(){
        return AboutCategory::orderBy('id', 'DESC')->get();
    }

    // Esta funcion se encarga de buscar si hay un telefono repetido y retorna el cliente al que le pertenece
    public function viejoTelefono(){
        $cliente = DB::table('moral_people')
            ->join('telephones', 'telephones.client_id', '=', 'moral_people.client_id')
            ->select('moral_people.nombre')
            ->get();

        $tamano = count($cliente);
        
        if($tamano == 0){

            $cliente = DB::table('physical_people')
            ->join('telephones', 'telephones.client_id', '=', 'physical_people.client_id')
            ->select('physical_people.nombre')
            ->get();

        }

        
        return $cliente;
    }

    public function deleteViejoTelefono($id){
        
        $telefono = Telephone::find($id);
        $telefono->delete();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function createC(Request $request){
        //dd($request);
        // Guardo un nueva categoría
        $tipo = new tipo_empresa(); 
        $tipo->nombre = $request->nombre;
        $tipo->save();
    }
    public function createComoSupo(Request $request){
        //dd($request);
        // Guardo un nueva categoría
        $tipo = new ComoLoSupo(); 
        $tipo->nombre = $request->nombre;
        $tipo->save();
    }
    public function ComoSupo(){
        return ComoLoSupo::orderBy('id', 'DESC')->get();   
    }
    public function TipoEmpresa(){
        return tipo_empresa::orderBy('id', 'DESC')->get();   
    }
    public function deleteTipo($id){
        $tipo = Tipo_empresa::find($id);
        $tipo->delete();
    }
    public function deleteComoSupo($id){
        $tipo = ComoLoSupo::find($id);
        $tipo->delete();
    }
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
            $cliente->client_id = $ultimoCliente;
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
            $cliente->tipoCredito = $request->creditoCliente;
            $cliente->save();

        }else{
            // Guardo una nueva persona moral.
            $cliente = new MoralPerson();

            $cliente->client_id = $ultimoCliente;
            $cliente->categoria_id = $request->categoriaCliente;
            $cliente->about_id = $request->categoriaAbout;
            $cliente->nombre = $request->nombreCliente;
            $cliente->nombreFacturacion = $request->nombreFacturacion;
            $cliente->direccionFacturacion = $request->direccionFacturacion;
            $cliente->coloniaFacturacion = $request->coloniaFacturacion;
            $cliente->numeroFacturacion = $request->numeroFacturacion;
            $cliente->rfcFacturacion = $request->rfcFacturacion;
            $cliente->emailFacturacion = $request->emailFacturacion;
            $cliente->tipoCredito = $request->creditoCliente;
            $cliente->save();
        }

        foreach ($request->telefonos as $telephone){
            $telefono = new Telephone();

            $telefono->client_id = $ultimoCliente;
            $telefono->nombre = $telephone['nombre'];
            $telefono->email = $telephone['email'];
            $telefono->tipo = $telephone['tipo'];
            $telefono->numero = $telephone['numero'];
            $telefono->ext = $telephone['ext'];
            $telefono->save();

        }
        
    }
}
