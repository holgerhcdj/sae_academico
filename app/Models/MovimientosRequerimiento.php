<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MovimientosRequerimiento
 * @package App\Models
 * @version March 3, 2018, 12:36 pm PET
 *
 * @property \App\Models\Requerimiento requerimiento
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection erpNotaCredito
 * @property \Illuminate\Database\Eloquent\Collection erpNotaDebito
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property \Illuminate\Database\Eloquent\Collection regNotasExtras
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection asgDepartamentos
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property string personas
 * @property integer req_id
 * @property string mvr_descripcion
 * @property string personas_ids
 */
class MovimientosRequerimiento extends Model
{

    public $table = 'movimientos_requerimiento';
    public $timestamps=false;
    
    public $fillable = [
        'personas',
        'req_id',
        'mvr_descripcion',
        'personas_ids',
        'mvr_fecha',
        'usu_id',
        'cc_personas',
        'cc_personas_ids',
        'mvr_hora',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'personas' => 'string',
        'req_id' => 'integer',
        'mvr_descripcion' => 'string',
        'personas_ids' => 'string',
        'mvr_fecha' => 'date',
        'usu_id' => 'integer',
        'cc_personas' => 'string',
        'cc_personas_ids' => 'string',
        'mvr_hora' => 'time'

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
    public function requerimiento()
    {
        return $this->belongsTo(\App\Models\Requerimiento::class);
    }
    
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
