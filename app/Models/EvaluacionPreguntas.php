<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class EvaluacionPreguntas
 * @package App\Models
 * @version April 18, 2020, 10:41 am PET
 *
 * @property \App\Models\EvaluacionGrupo evaluacionGrupo
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
 * @property integer evg_id
 * @property string evp_pregunta
 * @property string evp_imagen
 * @property float evp_valor
 * @property string evp_resp1
 * @property string evp_resp2
 * @property string evp_resp3
 * @property string evp_resp4
 * @property string evp_resp5
 * @property integer evp_resp
 * @property integer evp_estado
 */
class EvaluacionPreguntas extends Model
{

    public $table = 'evaluacion_preguntas';
    protected $primaryKey='evp_id';
    public $timestamps = false;



    public $fillable = [
        'evg_id',
        'evp_pregunta',
        'evp_imagen',
        'evp_valor',
        'evp_resp1',
        'evp_resp2',
        'evp_resp3',
        'evp_resp4',
        'evp_resp5',
        'evp_resp',
        'evp_estado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'evp_id' => 'integer',
        'evg_id' => 'integer',
        'evp_pregunta' => 'string',
        'evp_imagen' => 'string',
        'evp_valor' => 'float',
        'evp_resp1' => 'string',
        'evp_resp2' => 'string',
        'evp_resp3' => 'string',
        'evp_resp4' => 'string',
        'evp_resp5' => 'string',
        'evp_resp' => 'integer',
        'evp_estado' => 'integer'
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
    public function evaluacionGrupo()
    {
        return $this->belongsTo(\App\Models\EvaluacionGrupo::class);
    }
}
