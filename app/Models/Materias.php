<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Materias
 * @package App\Models
 * @version October 9, 2017, 7:38 pm PET
 *
 * @property \App\Models\Aniolectivo aniolectivo
 * @property \App\Models\Especialidade especialidade
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection AsgHorarioProfesore
 * @property \Illuminate\Database\Eloquent\Collection AsgMateriasCurso
 * @property string mtr_descripcion
 * @property string mtr_obs
 * @property integer mtr_tipo
 * @property integer anl_id
 * @property integer esp_id
 */
class Materias extends Model
{

    public $table = 'materias';
    public $timestamps=false;
//    use SoftDeletes;
//    const CREATED_AT = 'created_at';
//    const UPDATED_AT = 'updated_at';
//    protected $dates = ['deleted_at'];


    public $fillable = [
        'mtr_descripcion',
        'mtr_obs',
        'mtr_tipo',
        'anl_id',
        'esp_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'mtr_descripcion' => 'string',
        'mtr_obs' => 'string',
        'mtr_tipo' => 'integer',
        'anl_id' => 'integer',
        'esp_id' => 'integer'
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
        return $this->belongsTo(\App\Models\Aniolectivo::class,'anl_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function especialidad()
    {
        return $this->belongsTo(\App\Models\Especialidades::class,'esp_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function asgHorarioProfesores()
    {
        return $this->hasMany(\App\Models\AsgHorarioProfesore::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function asgMateriasCursos()
    {
        return $this->hasMany(\App\Models\AsgMateriasCurso::class);
    }
}
