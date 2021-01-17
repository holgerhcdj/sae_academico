<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AnioLectivo
 * @package App\Models
 * @version August 21, 2017, 7:58 pm UTC
 */
class AnioLectivo extends Model
{
//    use SoftDeletes;

    public $table = 'aniolectivo';
    public $timestamps=false;
    
    public $fillable = [
        'anl_descripcion',
        'anl_obs',
        'anl_selected',
        'especial',
        'votacion',
        'periodo',
        'anl_estado',
        'anl_quimestres',
        'anl_parciales',
        'anl_evq_tipo',
        'anl_peso_ev',
        'anl_ninsumos'
    ];

    protected $casts = [
        'id' => 'integer',
        'anl_descripcion' => 'string',
        'anl_obs' => 'string',
        'anl_selected' => 'integer',
        'especial'=>'integer',
        'votacion'=>'integer',
        'periodo'=>'integer',
        'anl_quimestres'=>'integer',
        'anl_parciales'=>'integer',
        'anl_evq_tipo'=>'integer',
        'anl_peso_ev'=>'integer',
        'anl_ninsumos'=>'integer'


    ];
    
    public function matriculas() {
        return $this->hasMany(App\Models\Matriculas::class,'anl_id','id');
    }
    
    public static $rules = [
        
    ];

    
}
