<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Productos
 * @package App\Models
 * @version July 31, 2019, 9:44 am PET
 *
 * @property \App\Models\ProTipo proTipo
 * @property \App\Models\ErpDivision erpDivision
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection erpNotaCredito
 * @property \Illuminate\Database\Eloquent\Collection erpNotaDebito
 * @property \Illuminate\Database\Eloquent\Collection horasExtras
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property \Illuminate\Database\Eloquent\Collection movimientosRequerimiento
 * @property \Illuminate\Database\Eloquent\Collection seguimientoCapellania
 * @property \Illuminate\Database\Eloquent\Collection requerimientos
 * @property \Illuminate\Database\Eloquent\Collection regNotasExtras
 * @property \Illuminate\Database\Eloquent\Collection valorPensiones
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection facturaDetalle
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection novedadesInspeccion
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property integer tpid
 * @property string pro_descripcion
 * @property string pro_medida
 * @property string pro_marca
 * @property string pro_tipo
 * @property string pro_unidad
 * @property string pro_serie
 * @property string pro_codigo
 * @property smallInteger pro_estado
 */
class Productos extends Model
{
    public $table = 'productos';
    protected $primaryKey='proid';
    public $timestamps = false;

    public $fillable = [
        'tpid',
        'pro_descripcion',
        'pro_medida',
        'pro_marca',
        'pro_tipo',
        'pro_unidad',
        'pro_serie',
        'pro_codigo',
        'pro_estado',
        'pro_caracteristicas',
        'pro_color',
        'pro_valor',
        'pro_obs'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'proid' => 'integer',
        'tpid' => 'integer',
        'pro_descripcion' => 'string',
        'pro_medida' => 'string',
        'pro_marca' => 'string',
        'pro_tipo' => 'string',
        'pro_unidad' => 'string',
        'pro_serie' => 'string',
        'pro_estado' => 'string',
        'pro_caracteristicas' => 'string',
        'pro_color' => 'string',
        'pro_valor' => 'integer',
        'pro_obs' => 'string',
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
    public function proTipo()
    {
        return $this->belongsTo(\App\Models\ProTipo::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function erpDivision()
    {
        return $this->belongsTo(\App\Models\ErpDivision::class);
    }
}
