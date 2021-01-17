<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Asistencia
 * @package App\Models
 * @version May 31, 2018, 4:20 pm PET
 *
 * @property \App\Models\Matricula matricula
 * @property \App\Models\Materia materia
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection erpNotaCredito
 * @property \Illuminate\Database\Eloquent\Collection erpNotaDebito
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property \Illuminate\Database\Eloquent\Collection regNotasExtras
 * @property \Illuminate\Database\Eloquent\Collection requerimientos
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection movimientosRequerimiento
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property integer mat_id
 * @property integer mtr_id
 * @property string fecha
 * @property string hora
 * @property integer estado
 * @property string observaciones
 */
class Asistencia extends Model
{

    public $table = 'asistencia';
    public $timestamps=false;

    public $fillable = [
        'mat_id',
        'mtr_id',
        'fecha',
        'hora',
        'estado',
        'observaciones',
        'usu_id',
        'sms_estado',
        'sms_obs'
    ];

    protected $casts = [
        'id' => 'integer',
        'mat_id' => 'integer',
        'mtr_id' => 'integer',
        'fecha' => 'string',
        'hora' => 'string',
        'estado' => 'integer',
        'observaciones' => 'string',
        'usu_id'=>'integer',
        'sms_estado'=>'integer',
        'sms_obs'=>'string'
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
    public function materia()
    {
        return $this->belongsTo(\App\Models\Materia::class);
    }
}
