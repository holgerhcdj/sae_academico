<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class JornadasLaborables
 * @package App\Models
 * @version May 1, 2019, 1:37 pm PET
 *
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection erpNotaCredito
 * @property \Illuminate\Database\Eloquent\Collection erpNotaDebito
 * @property \Illuminate\Database\Eloquent\Collection movimientosRequerimiento
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection horasExtras
 * @property \Illuminate\Database\Eloquent\Collection regNotasExtras
 * @property \Illuminate\Database\Eloquent\Collection requerimientos
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection valorPensiones
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property string jrl_descripcion
 * @property string|\Carbon\Carbon jrl_desde
 * @property string|\Carbon\Carbon jrl_hasta
 * @property smallInteger jrl_lun
 * @property smallInteger jrl_mar
 * @property smallInteger jrl_mie
 * @property smallInteger jrl_jue
 * @property smallInteger jrl_sab
 * @property smallInteger jrl_dom
 */
class JornadasLaborables extends Model
{
    public $table = 'jornadas_laborables';
    public $timestamps=false;
    protected $primaryKey='jrl_id';
   


    public $fillable = [
        'jrl_descripcion',
        'jrl_desde',
        'jrl_hasta',
        'jrl_lun',
        'jrl_mar',
        'jrl_mie',
        'jrl_jue',
        'jrl_vie',
        'jrl_sab',
        'jrl_dom'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'jrl_id' => 'integer',
        'jrl_descripcion' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
