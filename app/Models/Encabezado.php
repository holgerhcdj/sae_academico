<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Encabezado
 * @package App\Models
 * @version August 29, 2017, 9:04 pm UTC
 */
class Encabezado extends Model
{
    public $table = 'encabezado';
    public $timestamps = false;
    public $fillable = [
        'descripcion',
        'cedula',
        'direccion'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'descripcion' => 'string',
        'cedula' => 'string',
        'direccion' => 'string'
    ];
    
    public function detalles() {
        return $this->hasMany('App\Models\detalles','encabezado_id','id');
//return $this->hasMany('Comment', 'foreign_key', 'local_key');
    }
    

        public static $rules = [
        
    ];
    
    

    
}
