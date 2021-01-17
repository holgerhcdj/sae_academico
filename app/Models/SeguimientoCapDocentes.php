<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SeguimientoCapDocentes
 * @package App\Models
 * @version July 22, 2019, 12:32 pm PET
 *
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
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection requerimientos
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property \Illuminate\Database\Eloquent\Collection seguimientoCapellania
 * @property integer usu_id
 * @property integer usu_id2
 * @property date fecha
 * @property string historia_vida
 * @property string situacion_academica
 * @property string recomendaciones
 * @property string necesidad_oracion
 * @property string recomendacion
 * @property integer estado
 */
class SeguimientoCapDocentes extends Model
{
 public $table = 'seguimiento_capellania_docentes';
    protected $primaryKey='segid';
    public $timestamps = false;



    public $fillable = [
        'usu_id',
        'usu_id2',
        'fecha',
        'historia_vida',
        'situacion_academica',
        'recomendaciones',
        'necesidad_oracion',
        'recomendacion',
        'estado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'segid' => 'integer',
        'usu_id' => 'integer',
        'usu_id2' => 'integer',
        'fecha' => 'date',
        'historia_vida' => 'string',
        'situacion_academica' => 'string',
        'recomendaciones' => 'string',
        'necesidad_oracion' => 'string',
        'recomendacion' => 'string',
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
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
