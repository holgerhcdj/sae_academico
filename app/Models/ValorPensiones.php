<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ValorPensiones
 * @package App\Models
 * @version December 6, 2017, 7:46 am PET
 *
 * @property \App\Models\Aniolectivo aniolectivo
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
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property integer anl_id
 * @property string descripcion
 * @property float valor
 * @property string observacion
 * @property string responsable
 * @property integer estado
 */
class ValorPensiones extends Model
{
    public $table = 'valor_pensiones';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

  // id serial NOT NULL,
  // anl_id integer,
  // descripcion character varying,
  // valor double precision,
  // observacion character varying,
  // responsable character varying,
  // estado integer,
  // created_at timestamp(0) without time zone,
  // updated_at timestamp(0) without time zone,
  // jor_id integer,

    public $fillable = [
        'anl_id',
        'descripcion',
        'valor',
        'observacion',
        'responsable',
        'estado',
        'jor_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'anl_id' => 'integer',
        'descripcion' => 'string',
        'valor' => 'float',
        'observacion' => 'string',
        'responsable' => 'string',
        'estado' => 'integer',
        'jor_id' => 'integer'
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
}
