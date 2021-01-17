<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class AdminNotas extends Model
{
    public $table = 'admin_notas';
    public $timestamps=false;
    protected $primaryKey = 'adm_id';

    public $fillable = [
        'usu_id',
        'adm_tipo',
        'adm_finicio',
        'adm_ffinal',
        'adm_hinicio',
        'adm_hfinal',
        'adm_parcial',
        'jor_id',
        'esp_id',
        'cur_id',
        'paralelo',
        'mtr_id',
        'mod_id',
        'doc_id',
        'adm_estado',
        'adm_obs',
        'insumo'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'adm_id' => 'integer',
        'usu_id' => 'integer',
        'adm_tipo' => 'integer',
        'adm_finicio' => 'string',
        'adm_ffinal' => 'string',
        'adm_hinicio' => 'string',
        'adm_hfinal' => 'string',
        'adm_parcial' => 'integer',
        'jor_id' => 'integer',
        'esp_id' => 'integer',
        'cur_id' => 'integer',
        'paralelo' => 'string',
        'mtr_id' => 'integer',
        'mod_id' => 'integer',
        'doc_id' => 'integer',
        'adm_estado' => 'integer',
        'adm_obs' => 'string',
        'insumo' => 'integer'
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
}
