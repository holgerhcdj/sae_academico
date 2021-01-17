<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MateriasCursos
 * @package App\Models
 * @version October 9, 2017, 6:15 am PET
 *
 * @property \App\Models\Aniolectivo aniolectivo
 * @property \App\Models\Curso curso
 * @property \App\Models\Especialidade especialidade
 * @property \App\Models\Sucursale sucursale
 * @property \App\Models\Materia materia
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property integer anl_id
 * @property integer suc_id
 * @property integer jor_id
 * @property integer esp_id
 * @property integer cur_id
 * @property integer mtr_id
 * @property integer horas
 * @property string obs
 */
class MateriasCursos extends Model {

//    use SoftDeletes;
    public $table = 'asg_materias_cursos';
    public $timestamps=false;
//    const CREATED_AT = 'created_at';
//    const UPDATED_AT = 'updated_at';
//    protected $dates = ['deleted_at'];


    public $fillable = [
        'anl_id',
        'suc_id',
        'jor_id',
        'esp_id',
        'cur_id',
        'mtr_id',
        'horas',
        'obs',
        'bloques'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'anl_id' => 'integer',
        'suc_id' => 'integer',
        'jor_id' => 'integer',
        'esp_id' => 'integer',
        'cur_id' => 'integer',
        'mtr_id' => 'integer',
        'horas' => 'integer',
        'obs' => 'string',
        'bloques' => 'integer'
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
     * */
    public function aniolectivo() {
        return $this->belongsTo(\App\Models\Aniolectivo::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * */
    public function sucursal() {
        return $this->belongsTo(\App\Models\Sucursales::class,'suc_id','id');
    }
    public function curso() {
        return $this->belongsTo(\App\Models\Cursos::class,'cur_id','id');
    }
    public function especialidad() {
        return $this->belongsTo(\App\Models\Especialidades::class,'esp_id','id');
    }
    public function materia() {
        return $this->belongsTo(\App\Models\Materias::class,'mtr_id','id');
    }
    public function jornada() {
        return $this->belongsTo(\App\Models\Jornadas::class,'jor_id','id');
    }
    

}
