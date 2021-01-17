<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SeguimientoAccionesDece
 * @package App\Models
 * @version July 17, 2019, 10:53 am PET
 *
 * @property \App\Models\SeguimiendoDece seguimiendoDece
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection erpNotaCredito
 * @property \Illuminate\Database\Eloquent\Collection erpNotaDebito
 * @property \Illuminate\Database\Eloquent\Collection horasExtras
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection movimientosRequerimiento
 * @property \Illuminate\Database\Eloquent\Collection regNotasExtras
 * @property \Illuminate\Database\Eloquent\Collection requerimientos
 * @property \Illuminate\Database\Eloquent\Collection valorPensiones
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection facturaDetalle
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property integer segid
 * @property integer departamento
 * @property date fecha
 * @property string responsable
 * @property string area_trabajada
 * @property string seguimiento
 * @property string obs
 */
class SeguimientoAccionesDece extends Model
{
    public $table = 'seg_acciones_dece';
    protected $primaryKey='accid';
    public $timestamps = false;
    
    public $fillable = [
        'segid',
        'departamento',
        'fecha',
        'responsable',
        'area_trabajada',
        'seguimiento',
        'obs',
        'usu_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'accid' => 'integer',
        'segid' => 'integer',
        'departamento' => 'integer',
        'fecha' => 'date',
        'responsable' => 'string',
        'area_trabajada' => 'string',
        'seguimiento' => 'string',
        'obs' => 'string',
         'usu_id' => 'integer'
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
    public function seguimiendoDece()
    {
        return $this->belongsTo(\App\Models\SeguimiendoDece::class);
    }
}
