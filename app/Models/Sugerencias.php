<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Sugerencias
 * @package App\Models
 * @version March 14, 2019, 9:13 am PET
 *
 * @property \App\Models\User user
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection erpNotaDebito
 * @property \Illuminate\Database\Eloquent\Collection erpNotaCredito
 * @property \Illuminate\Database\Eloquent\Collection movimientosRequerimiento
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection regNotasExtras
 * @property \Illuminate\Database\Eloquent\Collection requerimientos
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection valorPensiones
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property integer usu_id
 * @property string revisado
 * @property string asunto
 * @property date f_registro
 * @property date f_vista
 * @property string detalle
 * @property integer estado
 * @property string contestacion
 */
class Sugerencias extends Model
{

    public $table = 'sugerencias';
public $timestamps=false;

    public $fillable = [
        'usu_id',
        'revisado',
        'asunto',
        'f_registro',
        'f_vista',
        'detalle',
        'estado',
        'contestacion'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'usu_id' => 'integer',
        'revisado' => 'string',
        'asunto' => 'string',
        'f_registro' => 'date',
        'f_vista' => 'date',
        'detalle' => 'string',
        'estado' => 'integer',
        'contestacion' => 'string'
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
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
