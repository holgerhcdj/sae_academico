<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Modulos
 * @package App\Models
 * @version September 30, 2017, 5:57 pm PET
 *
 * @property string menu
 * @property string submenu
 * @property string direccion
 * @property integer estado
 */
class Modulos extends Model
{
    // use SoftDeletes;

    public $table = 'modulos';
    
    // const CREATED_AT = 'created_at';
    // const UPDATED_AT = 'updated_at';
    // protected $dates = ['deleted_at'];
    public $timestamps=false;

    public $fillable = [
        'menu',
        'submenu',
        'direccion',
        'estado',
        'mod_grupo'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'menu' => 'string',
        'submenu' => 'string',
        'direccion' => 'string',
        'estado' => 'integer',
        'mod_grupo'=>'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function AsignaPermisos() {
        return $this->hasMany(\App\Models\AsignaPermisos::class, 'usu_id', 'id');
    }
    
    
}
