<?php

namespace App\Http\Controllers\CMS;
use App\Http\Controllers\Controller;
use App\TaskCategory;
use App\Task;
use App\PhysicalPerson;
use stdClass;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TareasController extends Controller
{
   //Obtenemos todas las categorias 
    public function categorias(){
        return TaskCategory::orderBy('id', 'DESC')->get();   
    }
    //Obtenemos los clientes fisicos 
    public function clientesF(){
        return PhysicalPerson::orderBy('id', 'DESC')->get();   
    }
    public function obtenerTareas(){

        $clientes_morales = DB::table('clients')
        ->join('moral_people', 'moral_people.client_id', '=', 'clients.id')
        ->select('clients.id', 'moral_people.nombre', 'moral_people.emailFacturacion as email', 'moral_people.nombreFacturacion','moral_people.direccionFacturacion', 'moral_people.coloniaFacturacion', 'moral_people.numeroFacturacion')
        ->get();

        $clientes_fisicos = DB::table('clients')
        ->join('physical_people', 'physical_people.client_id', '=', 'clients.id')
        ->select( 'clients.id', 'physical_people.nombre', 'physical_people.apellidoPaterno', 'physical_people.email', 'physical_people.nombreFacturacion', 'physical_people.direccionFacturacion', 'physical_people.coloniaFacturacion', 'physical_people.numeroFacturacion')
        ->get();
        
        $clientes = $clientes_morales->merge($clientes_fisicos);
        //dd($clientes);

        $tareas = DB::table('tasks')
        ->join('clients', 'tasks.cliente_id', '=', 'clients.id')
        ->select('clients.id', 'tasks.vendedor_id', 'tasks.categoria', 'tasks.notas', 'tasks.completa')
        ->get();

        $Tasks=[];

       // $tamanoClientes=count($clientes);
       // $tamanoTareas=count($tareas);
        foreach ($tareas as $tarea) {
             $tarea->id;
            foreach($clientes as $cliente){
                if($cliente->id==$tarea->id){
                $Task = new stdClass();
                $Task->id = $tarea->id;
                $Task->cliente = $cliente->nombre;
                $Task->notas = $tarea->notas;
                $Task->categoria = $tarea->categoria;
                $Task->completa = $tarea->completa;
                array_push($Tasks,$Task);
                }
            }
        }
        //dd($Tasks);
       /*for($i=0; $i<$tamanoTareas; $i++){
            for($j=0; $j<$tamanoClientes; $j++){
            if($clientes[$j]['id']==$tareas[$i]['id']){
                
                //$Task = new stdClass();
                $Task->id = $tareas[$i]['id'];
                $Task->cliente = $clientes[$j]['nombre'].$clientes[$j]['apellidoPaterno'];
                $Task->notas = $tareas=[$i]['notas'];
                $Task->categoria = $tareas=[$i]['categoria'];
                //$Task->cliente = 'Gerardo';
                //dd($Task);
                //array_push($Tasks,$Task); 
               }
            }
        } */

        //return view('clientes',compact('resultTasks'));   
        //dd($Tasks);
        return $Tasks;
    
        


    }
    public function store(Request $request){
        //dd($request);
        // Guardo una nueva tarea
         $tarea = new Task();
         $tarea->vendedor_id = $request->idVendedor;
         $tarea->categoria = $request->nombreCategoria;
         $tarea->cliente_id = $request->idCliente;
         $tarea->fecha = $request->fecha;
         $tarea->notas = $request->textoNotas;
         $tarea->save();

    }
    public function createC(Request $request){
        //dd($request);
        // Guardo un nueva categoría
        $categoria = new TaskCategory(); 
        $categoria->nombre = $request->nombre;
        $categoria->save();
    }
    public function deleteCategoria($id){
        $categoria = TaskCategory::find($id);
        $categoria->delete();
    }
    public function deleteTarea($id){
        $categoria = Task::find($id);
        //$categoria->delete();
        $categoria->completa = '1';
        $categoria->save();

    }
    public function editarCategoria(Request $request, $id){
         // edito una nueva categoría
         $categoria = new TaskCategory(); 
         $categoria->nombre = $request->nombre;
         $categoria->save();
    }
   
}
