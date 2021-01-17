<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Configuraciones
 * @package App\Models
 * @version May 20, 2019, 3:20 pm PET
 *
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection erpNotaCredito
 * @property \Illuminate\Database\Eloquent\Collection erpNotaDebito
 * @property \Illuminate\Database\Eloquent\Collection horasExtras
 * @property \Illuminate\Database\Eloquent\Collection movimientosRequerimiento
 * @property \Illuminate\Database\Eloquent\Collection regNotasExtras
 * @property \Illuminate\Database\Eloquent\Collection requerimientos
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection valorPensiones
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection facturaDetalle
 * @property string con_nombre
 * @property integer con_valor
 * @property string con_valor2
 * @property string con_valor3
  * @property integer tipo
 */
class Configuraciones extends Model
{
    public $table = 'erp_configuraciones';
    protected $primaryKey='con_id';
    public $timestamps=false;
        
    public $fillable = [
        'con_nombre',
        'con_valor',
        'con_valor2',
        'con_valor3',
        'tipo'
    ];

    protected $casts = [
        'con_id' => 'integer',
        'con_nombre' => 'string',
        'con_valor' => 'integer',
        'con_valor2' => 'string',
        'con_valor3' => 'string',
        'tipo' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
