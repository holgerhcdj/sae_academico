<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Jornadas
 * @package App\Models
 * @version August 29, 2017, 10:02 pm UTC
 */
class Jornadas extends Model
{
    public $table = 'jornadas';
    
     public $timestamps=false;

    public $fillable = [
        'jor_descripcion',
        'jor_obs'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'jor_descripcion' => 'string',
        'jor_obs' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function matriculas()
    {
        return $this->hasMany(\App\Models\Matriculas::class,'jor_id','id');
    }
}
