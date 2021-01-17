<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Insumos
 * @package App\Models
 * @version August 24, 2017, 4:24 pm UTC
 */
class Insumos extends Model
{
    use SoftDeletes;
    public $table = 'insumos';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];


// ins_descripcion, 
// ins_obs,
// tipo,
// anl_id,
// ins_siglas,
// ins_peso,
// ins_excluyente

    public $fillable = [
        'ins_descripcion',
        'ins_obs',
        'tipo',
        'anl_id',
        'ins_siglas',
        'ins_peso',
        'ins_excluyente'


    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'ins_descripcion' => 'string',
        'ins_obs' => 'string',
        'tipo' => 'string',
        'anl_id' => 'integer',
        'ins_siglas' => 'string',
        'ins_peso' => 'float',
        'ins_excluyente' => 'integer'        
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
