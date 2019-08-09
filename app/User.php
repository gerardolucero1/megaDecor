<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contrato', 'cliente','fecha','vendedor','lugar','version','created_at','opciones','updated_at'
    ];
    /*Descomentar este codigo para cuando se tengan todos los datos
    
    protected $fillable = [
        'name', 'email', 'password',
    ];
    */
    
    /**
     *  (#Contrato, fecha, cliente, lugar, vendedor, versión, opciones, ultima modificiacion)
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
