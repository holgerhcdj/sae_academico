<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Sancionados
 * @package App\Models
 * @version January 1, 2020, 3:38 pm PET
 *
 * @property \App\Models\Matricula matricula
 * @property \App\Models\User user
 * @property \Illuminate\Database\Eloquent\Collection asgPerfilDepartamentos
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection erpNotaCredito
 * @property \Illuminate\Database\Eloquent\Collection erpNotaDebito
 * @property \Illuminate\Database\Eloquent\Collection horasExtras
 * @property \Illuminate\Database\Eloquent\Collection movimientos
 * @property \Illuminate\Database\Eloquent\Collection movimientosRequerimiento
 * @property \Illuminate\Database\Eloquent\Collection novedadesInspeccion
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection seguimientoSemanalDocente
 * @property \Illuminate\Database\Eloquent\Collection requerimientos
 * @property \Illuminate\Database\Eloquent\Collection smsMail
 * @property \Illuminate\Database\Eloquent\Collection seguimientoCapellania
 * @property \Illuminate\Database\Eloquent\Collection regNotasExtras
 * @property \Illuminate\Database\Eloquent\Collection valorPensiones
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection encPreguntas
 * @property \Illuminate\Database\Eloquent\Collection facturaDetalle
 * @property \Illuminate\Database\Eloquent\Collection segAccionesDece
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property integer mat_id
 * @property integer usu_id
 * @property integer usu_new_id
 * @property date snc_fecha
 * @property time snc_hora_reg
 * @property string snc_motivo
 * @property integer snc_resolucion
 * @property string snc_resolucion_descripcion
 * @property integer snc_asistencia
 * @property date snc_desde
 * @property date snc_hasta
 * @property string snc_frecuencia_seg
 * @property integer snc_notificacion
 * @property integer snc_estado
 */
class Sancionados extends Model
{

    public $table = 'sancionados';
    public $timestamps = false;
    protected $primaryKey='snc_id';

    public $fillable = [
        'mat_id',
        'usu_id',
        'usu_new_id',
        'snc_fecha',
        'snc_hora_reg',
        'snc_motivo',
        'snc_resolucion',
        'snc_resolucion_descripcion',
        'snc_asistencia',
        'snc_desde',
        'snc_hasta',
        'snc_frecuencia_seg',
        'snc_notificacion',
        'snc_estado',
        'snc_finicio',
        'snc_ffin'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'snc_id' => 'integer',
        'mat_id' => 'integer',
        'usu_id' => 'integer',
        'usu_new_id' => 'integer',
        'snc_fecha' => 'date',
        'snc_motivo' => 'string',
        'snc_resolucion' => 'integer',
        'snc_resolucion_descripcion' => 'string',
        'snc_asistencia' => 'integer',
        'snc_desde' => 'date',
        'snc_hasta' => 'date',
        'snc_frecuencia_seg' => 'string',
        'snc_notificacion' => 'integer',
        'snc_estado' => 'integer',
        'snc_finicio' => 'date',
        'snc_ffin' => 'date',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function matricula()
    {
        return $this->belongsTo(\App\Models\Matricula::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
