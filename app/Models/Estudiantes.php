<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Estudiantes
 * @package App\Models
 * @version August 24, 2017, 3:25 pm UTC
 */
class Estudiantes extends Model {

    public $table = 'estudiantes';
    public $timestamps = true;
    public $fillable = [
        'est_codigo',
        'est_cedula',
        'est_apellidos',
        'est_nombres',
        'est_sexo',
        'est_fnac',
        'est_sector',
        'est_direccion',
        'est_telefono',
        'est_celular',
        'est_email',
        'est_discapacidad',
        'est_porcentaje_disc',
        'est_tiposangre',
        'proc_pais',
        'proc_provincia',
        'proc_canton',
        'proc_sector',
        'rep_cedula',
        'rep_nombres',
        'rep_telefono',
        'rep_mail',
        'est_obs',
        'created_at',
        'est_tdocumento',
        'rep_parentezco'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'est_codigo' => 'string',
        'est_cedula' => 'string',
        'est_apellidos' => 'string',
        'est_nombres' => 'string',
        'est_fnac' => 'date',
        'est_sector' => 'string',
        'est_direccion' => 'string',
        'est_telefono' => 'string',
        'est_celular' => 'string',
        'est_email' => 'string',
        'est_discapacidad' => 'string',
        'est_tiposangre' => 'string',
        'proc_pais' => 'string',
        'proc_provincia' => 'string',
        'proc_canton' => 'string',
        'proc_sector' => 'string',
        'rep_cedula' => 'string',
        'rep_nombres' => 'string',
        'rep_telefono' => 'string',
        'rep_mail' => 'string',
        'est_obs' => 'string',
        'est_tdocumento' => 'string',
        'est_tdocumentor' => 'string',
        'rep_parentezco' => 'string'
        
    ];

    /**
     * Validation rules
     *
     * @var array
     */
   public static $rules = array(
       
    );
    
    
    public function matriculas() {
        return $this->hasMany(\App\Models\Matriculas::class, 'est_id', 'id');
    }

    public function getFullNameAttribute()
    {
        return $this->est_apellidos . ' ' . $this->est_nombres;
    }



}
