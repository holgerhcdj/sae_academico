<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Rubros
 * @package App\Models
 * @version October 8, 2018, 7:58 am PET
 *
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection erpNotaCredito
 * @property \Illuminate\Database\Eloquent\Collection erpNotaDebito
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property \Illuminate\Database\Eloquent\Collection requerimientos
 * @property \Illuminate\Database\Eloquent\Collection regNotasExtras
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection movimientosRequerimiento
 * @property \Illuminate\Database\Eloquent\Collection valorPensiones
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property string rub_descripcion
 * @property integer rub_grupo
 * @property float rub_valor
 * @property date rub_fecha_reg
 * @property date rub_fecha_max
 * @property integer rub_estado
 */
class Rubros extends Model
{

    public $table = 'rubros';
    public $timestamps=false;
    protected $primaryKey = 'rub_id';

    public $fillable = [
        'rub_descripcion',
        'rub_grupo',
        'rub_valor',
        'rub_fecha_reg',
        'rub_fecha_max',
        'rub_estado',
        'usuario',
        'rub_obs',
        'rub_siglas',
        'rub_no',
        'ger_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'rub_id' => 'integer',
        'rub_descripcion' => 'string',
        'rub_grupo' => 'integer',
        'rub_valor' => 'float',
        'rub_fecha_reg' => 'date',
        'rub_fecha_max' => 'date',
        'rub_estado' => 'integer',
        'usuario'=> 'string',
        'rub_obs'=> 'string',
        'rub_siglas'=> 'string',
        'rub_no'=> 'string',
        'ger_id'=> 'integer'

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
