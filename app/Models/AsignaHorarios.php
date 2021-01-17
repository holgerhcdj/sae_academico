<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AsignaHorarios
 * @package App\Models
 * @version October 11, 2017, 8:58 pm PET
 *
 * @property \App\Models\Aniolectivo aniolectivo
 * @property \App\Models\Curso curso
 * @property \App\Models\Especialidade especialidade
 * @property \App\Models\Jornada jornada
 * @property \App\Models\Sucursale sucursale
 * @property \App\Models\User user
 * @property \App\Models\Materia materia
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property integer anl_id
 * @property integer usu_id
 * @property integer suc_id
 * @property integer jor_id
 * @property integer esp_id
 * @property integer cur_id
 * @property integer mtr_id
 * @property string paralelo
 * @property integer tipo
 * @property integer horas
 * @property string obs
 */
class AsignaHorarios extends Model
{
    

    public $table = 'asg_horario_profesores';
    public $timestamps=false;
//    use SoftDeletes;
//    const CREATED_AT = 'created_at';
//    const UPDATED_AT = 'updated_at';
//    protected $dates = ['deleted_at'];


    public $fillable = [
        'anl_id',
        'usu_id',
        'suc_id',
        'jor_id',
        'esp_id',
        'cur_id',
        'mtr_id',
        'paralelo',
        'tipo',
        'horas',
        'dia'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'anl_id' => 'integer',
        'usu_id' => 'integer',
        'suc_id' => 'integer',
        'jor_id' => 'integer',
        'esp_id' => 'integer',
        'cur_id' => 'integer',
        'mtr_id' => 'integer',
        'paralelo' => 'string',
        'tipo' => 'integer',
        'horas' => 'integer',
        'dia' => 'integer'
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
    public function curso()
    {
        return $this->belongsTo(\App\Models\Cursos::class,'cur_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function especialidade()
    {
        return $this->belongsTo(\App\Models\Especialidade::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function jornada()
    {
        return $this->belongsTo(\App\Models\Jornadas::class,'jor_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function sucursale()
    {
        return $this->belongsTo(\App\Models\Sucursale::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function materia()
    {
        return $this->belongsTo(\App\Models\Materias::class,'mtr_id','id');
    }
}
