<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PagoRubros
 * @package App\Models
 * @version October 8, 2018, 8:37 am PET
 *
 * @property \App\Models\Rubro rubro
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
 * @property integer rub_id
 * @property integer per_id
 * @property integer usu_id
 * @property date pgr_fecha
 * @property float pgr_monto
 * @property string pgr_forma_pago
 * @property string pgr_banco
 * @property date pgr_fecha_efectiviza
 * @property string pgr_documento
 * @property integer pgr_tipo
 * @property integer pgr_estado
 */
class PagoRubros extends Model
{
    
    public $table = 'pago_rubros';
    public $timestamps=false;
    protected $primaryKey = 'pgr_id';

    public $fillable = [
        'rub_id',
        'per_id',
        'usu_id',
        'pgr_fecha',
        'pgr_monto',
        'pgr_forma_pago',
        'pgr_banco',
        'pgr_fecha_efectiviza',
        'pgr_documento',
        'pgr_tipo',
        'pgr_estado',
        'pgr_obs',
        'pgr_num'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'pgr_id' => 'integer',
        'rub_id' => 'integer',
        'per_id' => 'integer',
        'usu_id' => 'integer',
        'pgr_fecha' => 'date',
        'pgr_monto' => 'float',
        'pgr_forma_pago' => 'string',
        'pgr_banco' => 'string',
        'pgr_fecha_efectiviza' => 'date',
        'pgr_documento' => 'string',
        'pgr_tipo' => 'integer',
        'pgr_estado' => 'integer',
        'pgr_obs' => 'string',
        'pgr_num' => 'string'

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
    public function rubro()
    {
        return $this->belongsTo(\App\Models\Rubro::class);
    }
}
