<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Sucursales
 * @package App\Models
 * @version September 2, 2017, 5:48 pm UTC
 */
class Sucursales extends Model {

    public $table = 'sucursales';
    public $timestamps = false;
    public $fillable = [
        'codigo',
        'nombre',
        'direccion',
        'telefono',
        'email',
        'estado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'codigo' => 'string',
        'nombre' => 'string',
        'direccion' => 'string',
        'telefono' => 'string',
        'email' => 'string',
        'estado' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];

}
