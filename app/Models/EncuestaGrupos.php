<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class EncuestaGrupos
 * @package App\Models
 * @version June 23, 2020, 6:59 pm -05
 *
 * @property \App\Models\EctEncabezado ectEncabezado
 * @property \Illuminate\Database\Eloquent\Collection asgPerfilDepartamentos
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection clasesOnline
 * @property \Illuminate\Database\Eloquent\Collection asgUsersDepartamentos
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection horasExtras
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection movimientos
 * @property \Illuminate\Database\Eloquent\Collection facturaDetalle
 * @property \Illuminate\Database\Eloquent\Collection movimientosRequerimiento
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property \Illuminate\Database\Eloquent\Collection requerimientos
 * @property \Illuminate\Database\Eloquent\Collection regNotasExtras
 * @property \Illuminate\Database\Eloquent\Collection sancionados
 * @property \Illuminate\Database\Eloquent\Collection seguimientoSemanalDocente
 * @property \Illuminate\Database\Eloquent\Collection smsMail
 * @property \Illuminate\Database\Eloquent\Collection seguimientoCapellania
 * @property \Illuminate\Database\Eloquent\Collection valorPensiones
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection encPreguntas
 * @property \Illuminate\Database\Eloquent\Collection comunicacionesUsuarios
 * @property \Illuminate\Database\Eloquent\Collection encResultados
 * @property \Illuminate\Database\Eloquent\Collection erpDetFactura
 * @property \Illuminate\Database\Eloquent\Collection segAccionesDece
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection novedadesInspeccion
 * @property \Illuminate\Database\Eloquent\Collection tareasUsuarios
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection ectRegistroEncuestas
 * @property \Illuminate\Database\Eloquent\Collection EctPregunta
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection ectResultados
 * @property integer ecb_id
 * @property string gru_descripcion
 * @property float gru_valoracion
 * @property integer gru_estado
 */
class EncuestaGrupos extends Model
{
    public $table = 'ect_grupos';
    public $primaryKey='gru_id';
    public $timestamps = false;   


    public $fillable = [
        'ecb_id',
        'gru_descripcion',
        'gru_valoracion',
        'gru_estado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'gru_id' => 'integer',
        'ecb_id' => 'integer',
        'gru_descripcion' => 'string',
        'gru_valoracion' => 'float',
        'gru_estado' => 'integer'
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
    public function ectEncabezado()
    {
        return $this->belongsTo(\App\Models\EctEncabezado::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function ectPreguntas()
    {
        return $this->hasMany(\App\Models\EctPregunta::class);
    }
}
