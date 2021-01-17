<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class EvaluacionGrupo
 * @package App\Models
 * @version April 18, 2020, 8:30 am PET
 *
 * @property \App\Models\Evaluacione evaluacione
 * @property \Illuminate\Database\Eloquent\Collection asgPerfilDepartamentos
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection asgUsersDepartamentos
 * @property \Illuminate\Database\Eloquent\Collection clasesOnline
 * @property \Illuminate\Database\Eloquent\Collection comunicacionesUsuarios
 * @property \Illuminate\Database\Eloquent\Collection encPreguntas
 * @property \Illuminate\Database\Eloquent\Collection encResultados
 * @property \Illuminate\Database\Eloquent\Collection facturaDetalle
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection erpDetFactura
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection movimientos
 * @property \Illuminate\Database\Eloquent\Collection novedadesInspeccion
 * @property \Illuminate\Database\Eloquent\Collection seguimientoCapellania
 * @property \Illuminate\Database\Eloquent\Collection horasExtras
 * @property \Illuminate\Database\Eloquent\Collection movimientosRequerimiento
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property \Illuminate\Database\Eloquent\Collection regNotasExtras
 * @property \Illuminate\Database\Eloquent\Collection requerimientos
 * @property \Illuminate\Database\Eloquent\Collection sancionados
 * @property \Illuminate\Database\Eloquent\Collection segAccionesDece
 * @property \Illuminate\Database\Eloquent\Collection seguimientoSemanalDocente
 * @property \Illuminate\Database\Eloquent\Collection smsMail
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection tareasUsuarios
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection valorPensiones
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property \Illuminate\Database\Eloquent\Collection EvaluacionPregunta
 * @property integer evl_id
 * @property string evg_descripcion
 * @property float evg_valoracion
 * @property integer evg_estado
 */
class EvaluacionGrupo extends Model
{

    public $table = 'evaluacion_grupo';
    protected $primaryKey='evg_id';
    public $timestamps = false;    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'evl_id',
        'evg_descripcion',
        'evg_valoracion',
        'evg_estado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'evg_id' => 'integer',
        'evl_id' => 'integer',
        'evg_descripcion' => 'string',
        'evg_valoracion' => 'float',
        'evg_estado' => 'integer'
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
    public function evaluacione()
    {
        return $this->belongsTo(\App\Models\Evaluacione::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function evaluacionPreguntas()
    {
        return $this->hasMany(\App\Models\EvaluacionPregunta::class);
    }
}
