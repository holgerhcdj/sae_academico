<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RegistroAsistencia
 * @package App\Models
 * @version April 27, 2019, 2:43 pm PET
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
 * @property string codigo
 * @property date fecha
 * @property time hora
 * @property integer tipo
 */
class RegistroAsistencia extends Model
{

    public $table = 'timbradas';
    public $timestamps=false;
    protected $primaryKey='tmbid';


    public $fillable = [
        'codigo',
        'fecha',
        'hora',
        'tipo',
        'motivo',
        'responsable',
        'estado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'reg_id' => 'integer',
        'codigo' => 'string',
        'fecha' => 'date',
        'tipo' => 'integer',
        'motivo' => 'string',
        'responsable' => 'string',
        'estado' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
