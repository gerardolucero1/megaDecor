<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'user_id',
        'dashboard',
        'dashboardCrearPresupuesto',
        'dashboardNuevoCliente',
        'dashboardReporteVentas',
        'dashboardConfiguraciones',
        'dashboardAperturaCaja',
        'dashboardPresupuestosActivos',
        'dashboardContratosHoy',
        'dashboardElementosDanados',
        'dashboardCreditosAtrasados',
        'dashboardComponenteVentas',
        'dashboardComponenteContabilidad',
        'dashboardListaTareas',
        'dashboardCalendario',
        'dashboardVendedorMes',
        'dashboardVentasMes',
    ];
}
