<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SeguimientoCapellania
 * @package App\Models
 * @version July 22, 2019, 12:03 pm PET
 *
 * @property \App\Models\Matricula matricula
 * @property \App\Models\User user
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection erpNotaCredito
 * @property \Illuminate\Database\Eloquent\Collection erpNotaDebito
 * @property \Illuminate\Database\Eloquent\Collection horasExtras
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property \Illuminate\Database\Eloquent\Collection regNotasExtras
 * @property \Illuminate\Database\Eloquent\Collection valorPensiones
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection movimientosRequerimiento
 * @property \Illuminate\Database\Eloquent\Collection facturaDetalle
 * @property \Illuminate\Database\Eloquent\Collection requerimientos
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property integer mat_id
 * @property integer usu_id
 * @property date fecha
 * @property string situacion_familiar
 * @property string situacion_academica_
 * @property string situacion_espiritual
 * @property string observacion
 * @property string recomendacion
 * @property string pedido_oracion
 * @property integer estado
 */
class SeguimientoCapellania extends Model
{
    public $table = 'seguimiento_capellania';
    protected $primaryKey='segid';
    public $timestamps = false;


    public $fillable = [
        'mat_id',
        'usu_id',
        'fecha',
        'situacion_familiar',
        'situacion_academica_',
        'situacion_espiritual',
        'observacion',
        'recomendacion',
        'pedido_oracion',
        'estado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'segid' => 'integer',
        'mat_id' => 'integer',
        'usu_id' => 'integer',
        'fecha' => 'date',
        'situacion_familiar' => 'string',
        'situacion_academica_' => 'string',
        'situacion_espiritual' => 'string',
        'observacion' => 'string',
        'recomendacion' => 'string',
        'pedido_oracion' => 'string',
        'estado' => 'integer'
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
