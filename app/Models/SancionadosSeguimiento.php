<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SancionadosSeguimiento
 * @package App\Models
 * @version January 2, 2020, 4:34 am PET
 *
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
 * @property \Illuminate\Database\Eloquent\Collection sancionados
 * @property integer snc_id
 * @property integer usu_id
 * @property integer usu_new_id
 * @property date sgsnc_fecha
 * @property date sgsnc_sig_fecha
 * @property time sgsnc_hora
 * @property time sgsnc_sig_hora
 * @property string sgsnc_accion
 * @property string sgsnc_informe
 * @property string sgsnc_recomendacion
 * @property integer sgsnc_estado
 */
class SancionadosSeguimiento extends Model
{
    public $table = 'sancionados_seguimiento';
    public $timestamps = false;
    protected $primaryKey='sgsnc_id';


    public $fillable = [
        'snc_id',
        'usu_id',
        'usu_new_id',
        'sgsnc_fecha',
        'sgsnc_sig_fecha',
        'sgsnc_hora',
        'sgsnc_sig_hora',
        'sgsnc_accion',
        'sgsnc_informe',
        'sgsnc_recomendacion',
        'sgsnc_estado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'sgsnc_id' => 'integer',
        'snc_id' => 'integer',
        'usu_id' => 'integer',
        'usu_new_id' => 'integer',
        'sgsnc_fecha' => 'date',
        'sgsnc_sig_fecha' => 'date',
        'sgsnc_accion' => 'string',
        'sgsnc_informe' => 'string',
        'sgsnc_recomendacion' => 'string',
        'sgsnc_estado' => 'integer'
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
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
