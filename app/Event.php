<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table= 'events';
    protected $fillable=['titulo','color','start_date', 'end_date'];
}


/*

protected $fillable=['vendedor_id','categoria', 'cliente_id','fecha'
    ,'notas','titulo','start_date','end_date','color'];


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


*/