<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ClasesOnline
 * @package App\Models
 * @version April 12, 2020, 7:48 pm PET
 *
 * @property \App\Models\User user
 * @property \App\Models\Materia materia
 * @property \Illuminate\Database\Eloquent\Collection asgPerfilDepartamentos
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection asgUsersDepartamentos
 * @property \Illuminate\Database\Eloquent\Collection comunicacionesUsuarios
 * @property \Illuminate\Database\Eloquent\Collection encPreguntas
 * @property \Illuminate\Database\Eloquent\Collection encResultados
 * @property \Illuminate\Database\Eloquent\Collection facturaDetalle
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection erpDetFactura
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection movimientos
 * @property \Illuminate\Database\Eloquent\Collection novedadesInspeccion
 * @property \Illuminate\Database\Eloquent\Collection seguimientoCapellania
 * @property \Illuminate\Database\Eloquent\Collection horasExtras
 * @property \Illuminate\Database\Eloquent\Collection movimientosRequerimiento
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property \Illuminate\Database\Eloquent\Collection regNotasExtras
 * @property \Illuminate\Database\Eloquent\Collection requerimientos
 * @property \Illuminate\Database\Eloquent\Collection sancionados
 * @property \Illuminate\Database\Eloquent\Collection segAccionesDece
 * @property \Illuminate\Database\Eloquent\Collection seguimientoSemanalDocente
 * @property \Illuminate\Database\Eloquent\Collection smsMail
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection tareasUsuarios
 * @property \Illuminate\Database\Eloquent\Collection valorPensiones
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property integer usu_id
 * @property integer mtr_id
 * @property string cls_days
 * @property time cls_hinicio
 * @property time cls_hfin
 * @property date cls_freg
 * @property string cls_link
 * @property integer cls_estado
 */
class ClasesOnline extends Model
{

    public $table = 'clases_online';
    protected $primaryKey='cls_id';
    public $timestamps = false;

    public $fillable = [
        'usu_id',
        'mtr_id',
        'cls_days',
        'cls_hinicio',
        'cls_hfin',
        'cls_freg',
        'cls_link',
        'cls_estado',
        'cls_cursos'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'cls_id' => 'integer',
        'usu_id' => 'integer',
        'mtr_id' => 'integer',
        'cls_days' => 'string',
        'cls_freg' => 'date',
        'cls_link' => 'string',
        'cls_estado' => 'integer',
        'cls_cursos' => 'string'
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
    public function materia()
    {
        return $this->belongsTo(\App\Models\Materia::class);
    }
}
