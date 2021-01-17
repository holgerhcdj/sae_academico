<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OrdenesPension
 * @package App\Models
 * @version December 6, 2017, 9:16 am PET
 *
 * @property \App\Models\Aniolectivo aniolectivo
 * @property \App\Models\Matricula matricula
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection erpNotaCredito
 * @property \Illuminate\Database\Eloquent\Collection erpNotaDebito
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property integer anl_id
 * @property integer mat_id
 * @property string fecha
 * @property string mes
 * @property string codigo
 * @property float valor
 * @property string fecha_pago
 * @property integer tipo
 * @property integer estado
 * @property string responsable
 * @property string obs
 */
class OrdenesPension extends Model
{
    /*use SoftDeletes;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
*/
public $table = 'ordenes_pension';
public $timestamps=false;

    public $fillable = [
        'anl_id',
        'mat_id',
        'fecha',
        'mes',
        'codigo',
        'valor',
        'fecha_pago',
        'tipo',
        'estado',
        'responsable',
        'obs',
        'identificador',
        'motivo',
        'vpagado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'anl_id' => 'integer',
        'mat_id' => 'integer',
        'fecha' => 'string',
        'mes' => 'string',
        'codigo' => 'string',
        'valor' => 'float',
        'fecha_pago' => 'string',
        'tipo' => 'integer',
        'estado' => 'integer',
        'responsable' => 'string',
        'obs' => 'string',
        'identificador'=>'string',
        'motivo'=>'string',
        'vpagado'=>'float'
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
    public function aniolectivo()
    {
        return $this->belongsTo(\App\Models\Aniolectivo::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function matricula()
    {
        return $this->belongsTo(\App\Models\Matricula::class);
    }
}
