<?php

namespace App\Models;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Cursos
 * @package App\Models
 * @version August 24, 2017, 1:15 pm UTC
 */
class Cursos extends Model
{
    use SoftDeletes;
    public $table = 'cursos';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];


    public $fillable = [
        'cur_descripcion',
        'cur_obs',
        'cur_tipo',
        'cupo'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'cur_descripcion' => 'string',
        'cur_obs' => 'string',
        'cur_tipo' => 'integer',
        'cupo' => 'integer'
        
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function matriculas() {
        return $this->hasMany(App\Models\Matriculas::class,'cur_id','id');
    }
    
}
