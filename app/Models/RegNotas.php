<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RegNotas
 * @package App\Models
 * @version November 13, 2017, 4:50 pm PET
 *
 * @property \App\Models\Matricula matricula
 * @property \App\Models\Insumo insumo
 * @property \App\Models\Materia materia
 * @property \App\Models\User user
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection erpNotaCredito
 * @property \Illuminate\Database\Eloquent\Collection erpNotaDebito
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property integer mat_id
 * @property integer periodo
 * @property integer ins_id
 * @property integer mtr_id
 * @property integer usu_id
 * @property float nota
 * @property string f_modific
 */
class RegNotas extends Model
{
//    use SoftDeletes;

    public $table = 'reg_notas';
    public $timestamps=false;

    public $fillable = [
        'mat_id',
        'periodo',
        'ins_id',
        'mtr_id',
        'usu_id',
        'nota',
        'f_modific',
        'disciplina',
        'mtr_tec_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'mat_id' => 'integer',
        'periodo' => 'integer',
        'ins_id' => 'integer',
        'mtr_id' => 'integer',
        'usu_id' => 'integer',
        'nota' => 'float',
        'f_modific' => 'string',
        'disciplina' => 'string',
        'mtr_tec_id' => 'integer'
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
    public function matricula()
    {
        return $this->belongsTo(\App\Models\Matricula::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function insumo()
    {
        return $this->belongsTo(\App\Models\Insumo::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function materia()
    {
        return $this->belongsTo(\App\Models\Materia::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
