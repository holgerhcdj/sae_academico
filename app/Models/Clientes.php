<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Clientes
 * @package App\Models
 * @version March 2, 2020, 9:14 pm PET
 *
 * @property \Illuminate\Database\Eloquent\Collection asgPerfilDepartamentos
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection encPreguntas
 * @property \Illuminate\Database\Eloquent\Collection encResultados
 * @property \Illuminate\Database\Eloquent\Collection facturaDetalle
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection movimientos
 * @property \Illuminate\Database\Eloquent\Collection novedadesInspeccion
 * @property \Illuminate\Database\Eloquent\Collection seguimientoCapellania
 * @property \Illuminate\Database\Eloquent\Collection horasExtras
 * @property \Illuminate\Database\Eloquent\Collection movimientosRequerimiento
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection regNotasExtras
 * @property \Illuminate\Database\Eloquent\Collection requerimientos
 * @property \Illuminate\Database\Eloquent\Collection sancionados
 * @property \Illuminate\Database\Eloquent\Collection segAccionesDece
 * @property \Illuminate\Database\Eloquent\Collection seguimientoSemanalDocente
 * @property \Illuminate\Database\Eloquent\Collection smsMail
 * @property \Illuminate\Database\Eloquent\Collection valorPensiones
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property \Illuminate\Database\Eloquent\Collection asgUsersDepartamentos
 * @property date cli_fecha
 * @property string cli_tipo
 * @property string cli_categoria
 * @property string cli_codigo
 * @property string cli_apellidos
 * @property string cli_nombres
 * @property string cli_ced_ruc
 * @property string cli_raz_social
 * @property string cli_retencion
 * @property decimal cli_cup_maximo
 * @property string cli_nacionalidad
 * @property string cli_direccion
 * @property integer cli_estado
 * @property string cli_telefono
 * @property string cli_email
 */
class Clientes extends Model
{

    public $table = 'erp_i_cliente';
    public $timestamps = false;
    protected $primaryKey='cli_id';    


    public $fillable = [
        'cli_fecha',
        'cli_tipo',
        'cli_categoria',
        'cli_codigo',
        'cli_apellidos',
        'cli_nombres',
        'cli_ced_ruc',
        'cli_raz_social',
        'cli_retencion',
        'cli_cup_maximo',
        'cli_nacionalidad',
        'cli_direccion',
        'cli_estado',
        'cli_telefono',
        'cli_email'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'cli_id' => 'integer',
        'cli_fecha' => 'date',
        'cli_tipo' => 'string',
        'cli_categoria' => 'string',
        'cli_codigo' => 'string',
        'cli_apellidos' => 'string',
        'cli_nombres' => 'string',
        'cli_ced_ruc' => 'string',
        'cli_raz_social' => 'string',
        'cli_retencion' => 'string',
        'cli_nacionalidad' => 'string',
        'cli_direccion' => 'string',
        'cli_estado' => 'integer',
        'cli_telefono' => 'string',
        'cli_email' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
