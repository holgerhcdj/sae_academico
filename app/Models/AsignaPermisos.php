<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AsignaPermisos
 * @package App\Models
 * @version October 2, 2017, 6:35 pm PET
 *
 * @property \App\Models\User user
 * @property \App\Models\Modulo modulo
 * @property integer usu_id
 * @property integer mod_id
 * @property integer new
 * @property integer edit
 * @property integer del
 * @property integer show
 */
class AsignaPermisos extends Model
{
//    use SoftDeletes;
    public $table = 'asg_permisos';
    public $timestamps=false;
//    const CREATED_AT = 'created_at';
//    const UPDATED_AT = 'updated_at';
//    protected $dates = ['deleted_at'];


    public $fillable = [
        'usu_id',
        'mod_id',
        'new',
        'edit',
        'del',
        'show',
        'grupo',
        'especial',
        'permisos_especiales'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'usu_id' => 'integer',
        'mod_id' => 'integer',
        'new' => 'integer',
        'edit' => 'integer',
        'del' => 'integer',
        'show' => 'integer',
        'grupo'=> 'integer',
        'especial'=> 'integer',
        'permisos_especiales'=> 'string',
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
        return $this->belongsTo(\App\Models\User::class,'usu_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function modulo()
    {
        return $this->belongsTo(\App\Models\Modulo::class,'mod_id','id');
    }
    
    
    
}
