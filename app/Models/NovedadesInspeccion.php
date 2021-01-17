<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NovedadesInspeccion extends Model
{

    public $table = 'novedades_inspeccion';
    protected $primaryKey='inspid';
    public $timestamps=false;

    public $fillable = [
        'mat_id',
        'usu_id',
        'fecha',
        'novedad',
        'acciones',
        'recomendaciones',
        'reportada_a',
        'derivado_a',
        'departamento',
        'estado',
        'envio_sms',
        'envio_detalle',
        'estado_sms'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'inspid' => 'integer',
        'mat_id' => 'integer',
        'usu_id' => 'integer',
        'fecha' => 'date',
        'novedad' => 'string',
        'acciones' => 'string',
        'recomendaciones' => 'string',
        'reportada_a' => 'string',
        'derivado_a' => 'integer',
        'departamento' => 'string',
        'estado' => 'integer',
        'envio_sms' => 'string',
        'envio_detalle' => 'string',
        'estado_sms' => 'integer'
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
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
