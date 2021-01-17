<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PermisosVacaciones
 * @package App\Models
 * @version April 24, 2019, 3:02 pm PET
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
 * @property integer usuid
 * @property date f_reg
 * @property date f_desde
 * @property date f_hasta
 * @property time h_desde
 * @property time h_hasta
 * @property string reemplazo
 * @property string motivo
 * @property string obs
 * @property smallInteger tipo
 * @property smallInteger estado
 * @property smallInteger pagado
 */
class PermisosVacaciones extends Model
{

    public $table = 'permisos_vacaciones';
    public $timestamps=false;
    protected $primaryKey='pmid';



    public $fillable = [
        'usuid',
        'f_reg',
        'f_desde',
        'f_hasta',
        'h_desde',
        'h_hasta',
        'reemplazo',
        'motivo',
        'obs',
        'tipo',
        'estado',
        'pagado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'pmid' => 'integer',
        'usuid' => 'integer',
        'f_reg' => 'date',
        'f_desde' => 'date',
        'f_hasta' => 'date',
        'reemplazo' => 'string',
        'motivo' => 'string',
        'obs' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
