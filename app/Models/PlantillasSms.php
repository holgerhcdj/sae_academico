<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PlantillasSms
 * @package App\Models
 * @version August 15, 2019, 3:47 pm PET
 *
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection erpNotaCredito
 * @property \Illuminate\Database\Eloquent\Collection erpNotaDebito
 * @property \Illuminate\Database\Eloquent\Collection horasExtras
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property \Illuminate\Database\Eloquent\Collection movimientosRequerimiento
 * @property \Illuminate\Database\Eloquent\Collection smsMail
 * @property \Illuminate\Database\Eloquent\Collection regNotasExtras
 * @property \Illuminate\Database\Eloquent\Collection requerimientos
 * @property \Illuminate\Database\Eloquent\Collection seguimientoCapellania
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection facturaDetalle
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection movimientos
 * @property \Illuminate\Database\Eloquent\Collection valorPensiones
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property string pln_descripcion
 * @property string pln_var1
 * @property string pln_var2
 * @property string pln_var3
 * @property string pln_var4
 * @property string pln_var5
 * @property integer pln_estado
 */
class PlantillasSms extends Model
{

    public $table = 'plantillas_sms';
    public $timestamps = false;
    protected $primaryKey = 'pln_id';

    public $fillable = [
        'pln_descripcion',
        'pln_var1',
        'pln_var2',
        'pln_var3',
        'pln_var4',
        'pln_var5',
        'pln_estado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'pln_id' => 'integer',
        'pln_descripcion' => 'string',
        'pln_var1' => 'string',
        'pln_var2' => 'string',
        'pln_var3' => 'string',
        'pln_var4' => 'string',
        'pln_var5' => 'string',
        'pln_estado' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
