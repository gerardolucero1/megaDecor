<?php

namespace App;

use App\User;
use App\Client;
use App\Payment;
use App\Celebrated;
use App\BudgetInventory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = [
        'folio',
        'vendedor_id',
        'client_id',
        'tipoEvento',
        'tipoServicio',
        'categoriaEvento',
        'fechaEvento',
        'pendienteFecha',
        'horaEventoInicio',
        'horaEventoFin',
        'pendienteHora',
        'lugarEvento',
        'nombreLugar',
        'direccionLugar',
        'numeroLugar',
        'coloniaLugar',
        'CPLugar',
        'observacionesLugar',
        'numeroInvitados',
        'colorEvento',
        'temaEvento',
        'opcionPrecioUnitario',
        'opcionDescripcionPaquete',
        'opcionImagen',
        'opcionPrecio',
        'opcionDescuento',
        'opcionIVA',
        'tipo',
        'impresion',
        'pagado',
        'facturaSolicitada',

        //Datos facturacion
        'horaInicio',
        'horaFin',
        'horaEntrega',
        'fechaRecoleccion',
        'notasFacturacion',
        'nombreFacturacion',
        'direccionFacturacion',
        'numeroFacturacion',
        'coloniaFacturacion',
        'emailFacturacion',

        //version
        'version',
        'comision',
        'total',
        'pagado',

        //Notas
        'notasPresupuesto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'vendedor_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    

    public function celebrateds()
    {
        return $this->hasMany(Celebrated::class);
    }

    public function inventories()
    {
        return $this->hasMany(BudgetInventory::class, 'budget_id');
    }

    public function budgetPacks()
    {
        return $this->hasMany(BudgetPack::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
