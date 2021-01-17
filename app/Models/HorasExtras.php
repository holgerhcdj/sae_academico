<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class HorasExtras
 * @package App\Models
 * @version April 24, 2019, 3:04 pm PET
 *
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection erpNotaCredito
 * @property \Illuminate\Database\Eloquent\Collection erpNotaDebito
 * @property \Illuminate\Database\Eloquent\Collection movimientosRequerimiento
 * @property \Illuminate\Database\Eloquent\Collection regNotasExtras
 * @property \Illuminate\Database\Eloquent\Collection valorPensiones
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection requerimientos
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection asistenciaPersonal
 * @property string usuid
 * @property date f_reg
 * @property time mes
 * @property smallInteger horas
 * @property string descripcion
 * @property smallInteger estado
 * @property string responsable
 */
class HorasExtras extends Model
{

    public $table = 'horas_extras';
    public $timestamps=false;
    protected $primaryKey='heid';


    public $fillable = [
        'usuid',
        'f_reg',
        'anlid',
        'mes',
        'horas',
        'descripcion',
        'estado',
        'responsable'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'usuid' => 'string',
        'anlid' => 'integer',
        'f_reg' => 'date',
        'descripcion' => 'string',
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
