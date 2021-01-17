<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SmsMail
 * @package App\Models
 * @version August 7, 2019, 11:58 am PET
 *
 * @property \App\Models\User user
 * @property \App\Models\Matricula matricula
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection erpNotaCredito
 * @property \Illuminate\Database\Eloquent\Collection erpNotaDebito
 * @property \Illuminate\Database\Eloquent\Collection horasExtras
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property \Illuminate\Database\Eloquent\Collection regNotasExtras
 * @property \Illuminate\Database\Eloquent\Collection valorPensiones
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection movimientosRequerimiento
 * @property \Illuminate\Database\Eloquent\Collection facturaDetalle
 * @property \Illuminate\Database\Eloquent\Collection requerimientos
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property integer usu_id
 * @property integer mat_id
 * @property string sms_mensaje
 * @property string sms_modulo
 * @property integer sms_tipo
 * @property string destinatario
 * @property integer estado
 * @property string respuesta
 * @property string persona
 * @property date sms_fecha
 * @property time sms_hora
 * @property string sms_grupo
 */
class SmsMail extends Model
{
    public $table = 'sms_mail';
    public $timestamps=false;
    protected $primaryKey='sms_id';

    public $fillable = [
        'usu_id',
        'mat_id',
        'sms_mensaje',
        'sms_modulo',
        'sms_tipo',
        'destinatario',
        'estado',
        'respuesta',
        'persona',
        'sms_fecha',
        'sms_hora',
        'sms_grupo'
    ];



    protected $casts = [
        'sms_id' => 'integer',
        'usu_id' => 'integer',
        'mat_id' => 'integer',
        'sms_mensaje' => 'string',
        'sms_modulo' => 'string',
        'sms_tipo' => 'integer',
        'destinatario' => 'string',
        'estado' => 'integer',
        'respuesta' => 'string',
        'persona' => 'string',
        'sms_fecha' => 'date',
        'sms_grupo' => 'string'
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function matricula()
    {
        return $this->belongsTo(\App\Models\Matricula::class);
    }
}
