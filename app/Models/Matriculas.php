<?php

namespace App\Models;
use Eloquent as Model;

/**
 * Class Matriculas
 * @package App\Models
 * @version August 28, 2017, 8:59 pm UTC
 */
class Matriculas extends Model {

    public $table = 'matriculas';
    public $timestamps = true;
    public $fillable = [
        'est_id',
        'anl_id',
        'esp_id',
        'cur_id',
        'jor_id',
        'proc_id',
        'dest_id',
        'mat_paralelo',
        'mat_paralelot',
        'mat_estado',
        'mat_obs',
        'est_tipo',
        'responsable',
        'plantel_procedencia',
        'motivo',
        'fecha_asistencia',
        'fecha_accion',
        'facturar',
        'fac_razon_social',
        'fac_ruc',
        'fac_direccion',
        'fac_telefono',
        'enc_tipo',
        'enc_detalle',
        'docs'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'est_id' => 'integer',
        'anl_id' => 'integer',
        'esp_id' => 'integer',
        'cur_id' => 'integer',
        'jor_id' => 'integer',
        'proc_id' => 'integer',
        'dest_id' => 'integer',
        'mat_paralelo' => 'string',
        'mat_paralelot' => 'string',
        'mat_estado' => 'integer',
        'mat_obs' => 'string',
        'est_tipo' => 'string',
        'responsable'=> 'string',
        'plantel_procedencia'=> 'string',
        'motivo' => 'string',
        'fecha_asistencia' => 'string',
        'fecha_accion'=> 'string',
        'facturar' => 'integer',
        'fac_razon_social'=> 'string',
        'fac_ruc'=> 'string',
        'fac_direccion'=> 'string',
        'fac_telefono'=> 'string',
        'enc_tipo'=> 'string',
        'enc_detalle'=> 'string',
        'docs'=> 'string',

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
    public function estudiante() {
        return $this->belongsTo(\App\Models\Estudiantes::class,'est_id','id');
    }
    
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * */
    public function aniolectivo() {
        return $this->belongsTo(\App\Models\Aniolectivo::class,'anl_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * */
    public function curso() {
        return $this->belongsTo(\App\Models\Cursos::class,'cur_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * */
    public function especialidad() {
        return $this->belongsTo(\App\Models\Especialidades::class,'esp_id','id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * */
    public function jornada() {
        return $this->belongsTo(\App\Models\Jornadas::class,'jor_id','id');
    }

    //Procedencia
    public function sucursalp() {
        return $this->belongsTo(\App\Models\Sucursales::class,'proc_id','id');
    }
    //Destino
    public function sucursald() {
        return $this->belongsTo(\App\Models\Sucursales::class,'dest_id','id');
    }
    





    
}
