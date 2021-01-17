<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Movimientos
 * @package App\Models
 * @version August 2, 2019, 11:07 am PET
 *
 * @property \App\Models\Producto producto
 * @property \App\Models\ErpDivision erpDivision
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection erpNotaCredito
 * @property \Illuminate\Database\Eloquent\Collection erpNotaDebito
 * @property \Illuminate\Database\Eloquent\Collection horasExtras
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property \Illuminate\Database\Eloquent\Collection movimientosRequerimiento
 * @property \Illuminate\Database\Eloquent\Collection seguimientoCapellania
 * @property \Illuminate\Database\Eloquent\Collection requerimientos
 * @property \Illuminate\Database\Eloquent\Collection regNotasExtras
 * @property \Illuminate\Database\Eloquent\Collection valorPensiones
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection facturaDetalle
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection novedadesInspeccion
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property integer proid
 * @property integer div_id
 * @property date movfecha
 * @property integer movtipo
 * @property float mov
 * @property integer movtpdoc
 * @property string movnumdoc
 * @property float movvalorunit
 * @property string procaracteristicas
 * @property string proserie
 * @property string observaciones
 * @property integer movestado
 */
class Movimientos extends Model
{
    public $table = 'movimientos';
    protected $primaryKey='movid';
    public $timestamps = false;


    public $fillable = [
        'proid',
        'div_id',
        'movfecha',
        'movtipo',
        'mov',
        'movtpdoc',
        'movnumdoc',
        'movvalorunit',
        'procaracteristicas',
        'proserie',
        'observaciones',
        'movestado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'movid' => 'integer',
        'proid' => 'integer',
        'div_id' => 'integer',
        'movfecha' => 'date',
        'movtipo' => 'integer',
        'mov' => 'float',
        'movtpdoc' => 'integer',
        'movnumdoc' => 'string',
        'movvalorunit' => 'float',
        'procaracteristicas' => 'string',
        'proserie' => 'string',
        'observaciones' => 'string',
        'movestado' => 'integer'
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
    public function producto()
    {
        return $this->belongsTo(\App\Models\Producto::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function erpDivision()
    {
        return $this->belongsTo(\App\Models\ErpDivision::class);
    }
}
