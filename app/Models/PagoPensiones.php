<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PagoPensiones
 * @package App\Models
 * @version October 18, 2018, 4:30 am PET
 *
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection erpNotaCredito
 * @property \Illuminate\Database\Eloquent\Collection erpNotaDebito
 * @property \Illuminate\Database\Eloquent\Collection movimientosRequerimiento
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property \Illuminate\Database\Eloquent\Collection regNotasExtras
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection requerimientos
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection valorPensiones
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property string descripcion
 * @property date f_inicio
 * @property date f_fin
 * @property string cedula
 * @property string estudiante
 * @property float valor
 * @property string canal
 * @property string ndocumento
 * @property string fecha_pago
 * @property string hora_pago
 * @property float valor_p
 * @property string cod_orden
 * @property date f_registro
 * @property string responsable
 */
class PagoPensiones extends Model
{
    public $table = 'pago_pensiones';
    public $timestamps = true;
    
    public $fillable = [
        'descripcion',
        'f_inicio',
        'f_fin',
        'cedula',
        'estudiante',
        'valor',
        'canal',
        'ndocumento',
        'fecha_pago',
        'hora_pago',
        'valor_p',
        'cod_orden',
        'f_registro',
        'responsable'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'descripcion' => 'string',
        'f_inicio' => 'date',
        'f_fin' => 'date',
        'cedula' => 'string',
        'estudiante' => 'string',
        'valor' => 'float',
        'canal' => 'string',
        'ndocumento' => 'string',
        'fecha_pago' => 'string',
        'hora_pago' => 'string',
        'valor_p' => 'float',
        'cod_orden' => 'string',
        'f_registro' => 'date',
        'responsable' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
