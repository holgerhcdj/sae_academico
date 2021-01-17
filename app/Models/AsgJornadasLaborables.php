<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AsgJornadasLaborables extends Model
{
    public $table = 'asigna_jornadas_laborables';
    public $timestamps=false;
    protected $primaryKey='asg_jrl_id';


    public $fillable = [
        'asg_jrl_usuid',
        'asg_jrl_anl',
        'asg_jrl_jor',
        'asg_jrl_desde',
        'asg_jrl_hasta',
        'asg_jrl_alm',
        'asg_jrl_alm_desde',
        'asg_jrl_alm_hasta',
        'asg_jrl_lun',
        'asg_jrl_mar',
        'asg_jrl_mie',
        'asg_jrl_jue',
        'asg_jrl_vie',
        'asg_jrl_sab',
        'asg_jrl_dom',
        'asg_jrl_obs',
        'asg_jrl_estado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'asg_jrl_id' => 'integer',
        'asg_jrl_obs' => 'string'
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
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function aniolectivo()
    {
        return $this->belongsTo(\App\Models\Aniolectivo::class);
    }
}
