<?php

namespace App\Http\Controllers\CMS;

use App\Missing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MissingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach($request[0] as $item){
            $faltante = new Missing();
            $faltante->inventory_id = $item['id'];
            $faltante->servicio = $item['servicio'];
            $faltante->saliente = $item['cantidad'];
            $faltante->faltante = $item['faltante'];
            $faltante->total = $item['cantidad'] - $item['faltante'];
            $faltante->save();
        }

        foreach($request[1] as $item){
            foreach($item['inventories'] as $element){
                $faltante = new Missing();
                $faltante->inventory_id = $element['id'];
                $faltante->servicio = $element['servicio'];
                $faltante->saliente = $element['cantidad'];
                $faltante->faltante = $element['faltante'];
                $faltante->total = $element['cantidad'] - $element['faltante'];
                $faltante->save();
            }
        }

        return;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
        //
    }
}
