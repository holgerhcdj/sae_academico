<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class NotasExtras
 * @package App\Models
 * @version January 10, 2018, 4:50 pm PET
 *
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection erpNotaCredito
 * @property \Illuminate\Database\Eloquent\Collection erpNotaDebito
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property integer id
 * @property integer est_id
 * @property integer anl_id
 * @property integer emi_id
 * @property string f_registro
 * @property string cert_primaria
 * @property integer par_estudiantil
 * @property integer ex_enes
 * @property string responsable
 * @property string obs
 * @property float n2
 * @property float n3
 * @property float n4
 * @property float n5
 * @property float n6
 * @property float n7
 * @property float n8
 * @property float n9
 * @property float n10
 * @property float n11
 * @property float n12
 * @property float n13
 */
class NotasExtras extends Model
{
    //use SoftDeletes;

    public $table = 'reg_notas_extras';
    
    // const CREATED_AT = 'created_at';
    // const UPDATED_AT = 'updated_at';
    // protected $dates = ['deleted_at'];
public $timestamps=false;

    public $fillable = [
        'id',
        'est_id',
        'anl_id',
        'emi_id',
        'f_registro',
        'cert_primaria',
        'par_estudiantil',
        'ex_enes',
        'responsable',
        'obs',
        'n2',
        'n3',
        'n4',
        'n5',
        'n6',
        'n7',
        'n8',
        'n9',
        'n10',
        'n11',
        'n12',
        'n13'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'est_id' => 'integer',
        'anl_id' => 'integer',
        'emi_id' => 'integer',
        'f_registro' => 'string',
        'cert_primaria' => 'string',
        'par_estudiantil' => 'integer',
        'ex_enes' => 'integer',
        'responsable' => 'string',
        'obs' => 'string',
        'n2' => 'float',
        'n3' => 'float',
        'n4' => 'float',
        'n5' => 'float',
        'n6' => 'float',
        'n7' => 'float',
        'n8' => 'float',
        'n9' => 'float',
        'n10' => 'float',
        'n11' => 'float',
        'n12' => 'float',
        'n13' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
