<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $fillable = [
        'porcentajeCrecimientoVentas',
        'porcentajeCrecimientoUtilidad',
        'bonoObjetivoVentas',
        'bonoObjetivoNoVentas',
        'comisionContrato',
        'bonoVendedorMes',
        'minimoVentaComision',
    ];
}
