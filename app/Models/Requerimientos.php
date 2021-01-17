<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Requerimientos
 * @package App\Models
 * @version March 2, 2018, 10:30 pm PET
 *
 * @property \App\Models\User user
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection erpNotaCredito
 * @property \Illuminate\Database\Eloquent\Collection erpNotaDebito
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property \Illuminate\Database\Eloquent\Collection regNotasExtras
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection asgDepartamentos
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property integer usu_id
 * @property string asunto
 * @property string codigo
 * @property string descripcion
 * @property date fecha_registro
 * @property date fecha_finalizacion
 * @property string archivo
 * @property integer estado
 */
class Requerimientos extends Model
{
    

    public $table = 'requerimientos';
    public $timestamps=false;
    
//    use SoftDeletes;
//    const CREATED_AT = 'created_at';
//    const UPDATED_AT = 'updated_at';
//    protected $dates = ['deleted_at'];


    public $fillable = [
        'usu_id',
        'asunto',
        'codigo',
        'descripcion',
        'fecha_registro',
        'fecha_finalizacion',
        'archivo',
        'estado',
        'hora_registro',
        'hora_final',
        'trm_id',
        'last_ids'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'usu_id' => 'integer',
        'asunto' => 'string',
        'codigo' => 'string',
        'descripcion' => 'string',
        'fecha_registro' => 'date',
        'fecha_finalizacion' => 'date',
        'archivo' => 'string',
        'estado' => 'integer',
        'hora_registro'=>'time',
        'hora_final'=>'time',
        'trm_id'=>'integer',
        'last_ids'=>'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'personas' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
