<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Event;
use MadHatter\LaravelFullCalendar\Facades\Calendar;
use App\User;
use App\Telephone;
use App\AboutCategory;
use App\MoralCategory;

use Illuminate\Support\Facades\DB;
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $events = Event::all();
        $event = [];        
        foreach($events as $row){
            $enddate = $row->end_date."24:00:00";
            
            $event[]=\Calendar::event( $row->titulo,
            false,
            new \DateTime($row->start_date),
            new \DateTime($row->end_date),
            $row->id,
            [
                'color' => $row->color,
            ]               
            );
        }
        $calendar=\Calendar::addEvents($event);
        return view('/eventpage', compact('events','calendar','users'));
    }
    //original eventpage    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function display(){
        return view('addevent');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function guardar(Request $request){
        //dd($request);
        $this->validate($request,
       ['titulo' =>'required',
       'color'=>'required',
        'start_date'=>'required',
        'end_date'=>'required']);
        $events= new Event;
        $events->titulo = $request->input('titulo');
	    $events->color=$request->input('color');
        $events->start_date = $request->input('start_date');
        $events->end_date = $request->input('end_date');


       
        $events->save();
        return redirect('events')->with('success','Evento Agregado');
    }
    /*

        $events->vendedor_id = $request->input('vendedor_id');
	    $events->categoria=$request->input('categoria');
        $events->cliente_id = $request->input('cliente_id');
        $events->fecha = $request->input('fecha');
        $events->notas = $request->input('notas');

            $table->increments('id');
            $table->integer('vendedor_id');
            $table->string('categoria');
            $table->integer('cliente_id');
            $table->integer('fecha');
            $table->text('notas');
            
            $table->string('titulo');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('color');
            $table->timestamps();
    */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $events = Event::find($id); 
        $events->delete(); //delete the client
        
        return redirect('events')->with('success','Evento eliminado');
    }
}
