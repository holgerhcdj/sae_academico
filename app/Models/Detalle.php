<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Detalle
 * @package App\Models
 * @version August 29, 2017, 9:09 pm UTC
 */
class Detalle extends Model {

    public $table = 'detalle';
    public $timestamps = false;
    public $fillable = [
        'encabezado_id',
        'det_descripcion',
        'obs'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'encabezado_id' => 'integer',
        'det_descripcion' => 'string',
        'obs' => 'string'
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
    public function encabezado() {
        return $this->belongsTo(\App\Models\Encabezado::class);
    }

}
