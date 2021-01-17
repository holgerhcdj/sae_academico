<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SegSemanalDocente
 * @package App\Models
 * @version August 21, 2019, 9:27 am PET
 *
 * @property \App\Models\User user
 * @property \App\Models\User user
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection erpNotaCredito
 * @property \Illuminate\Database\Eloquent\Collection erpNotaDebito
 * @property \Illuminate\Database\Eloquent\Collection horasExtras
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property \Illuminate\Database\Eloquent\Collection movimientosRequerimiento
 * @property \Illuminate\Database\Eloquent\Collection regNotasExtras
 * @property \Illuminate\Database\Eloquent\Collection requerimientos
 * @property \Illuminate\Database\Eloquent\Collection seguimientoCapellania
 * @property \Illuminate\Database\Eloquent\Collection smsMail
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection valorPensiones
 * @property \Illuminate\Database\Eloquent\Collection movimientos
 * @property \Illuminate\Database\Eloquent\Collection facturaDetalle
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property \Illuminate\Database\Eloquent\Collection segAccionesDece
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property integer cap_id
 * @property integer doc_id
 * @property date fecha
 * @property integer nivel
 * @property string textos_biblicos
 * @property string respuesta
 * @property integer nivel_final
 * @property integer estado
 * @property string obs
 */
class SegSemanalDocente extends Model
{


    public $table = 'seguimiento_semanal_docente';
    protected $primaryKey='sgmid';
    public $timestamps=false;

    public $fillable = [
        'cap_id',
        'doc_id',
        'fecha',
        'nivel',
        'textos_biblicos',
        'respuesta',
        'nivel_final',
        'estado',
        'obs'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'sgmid' => 'integer',
        'cap_id' => 'integer',
        'doc_id' => 'integer',
        'fecha' => 'date',
        'nivel' => 'integer',
        'textos_biblicos' => 'string',
        'respuesta' => 'string',
        'nivel_final' => 'integer',
        'estado' => 'integer',
        'obs' => 'string'
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
    public function docente()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function capellan()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
