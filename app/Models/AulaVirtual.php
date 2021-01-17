<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AulaVirtual
 * @package App\Models
 * @version March 17, 2020, 8:29 pm PET
 *
 * @property \App\Models\User user
 * @property \Illuminate\Database\Eloquent\Collection asgPerfilDepartamentos
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection asgUsersDepartamentos
 * @property \Illuminate\Database\Eloquent\Collection encResultados
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection horasExtras
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection movimientos
 * @property \Illuminate\Database\Eloquent\Collection movimientosRequerimiento
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property \Illuminate\Database\Eloquent\Collection requerimientos
 * @property \Illuminate\Database\Eloquent\Collection regNotasExtras
 * @property \Illuminate\Database\Eloquent\Collection seguimientoCapellania
 * @property \Illuminate\Database\Eloquent\Collection encPreguntas
 * @property \Illuminate\Database\Eloquent\Collection comunicacionesUsuarios
 * @property \Illuminate\Database\Eloquent\Collection segAccionesDece
 * @property \Illuminate\Database\Eloquent\Collection facturaDetalle
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection erpDetFactura
 * @property \Illuminate\Database\Eloquent\Collection novedadesInspeccion
 * @property \Illuminate\Database\Eloquent\Collection sancionados
 * @property \Illuminate\Database\Eloquent\Collection seguimientoSemanalDocente
 * @property \Illuminate\Database\Eloquent\Collection smsMail
 * @property \Illuminate\Database\Eloquent\Collection tareasUsuarios
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection valorPensiones
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property integer usu_id
 * @property integer tar_tipo
 * @property string tar_titulo
 * @property string tar_descripcion
 * @property string tar_adjuntos
 * @property string tar_link
 * @property date tar_finicio
 * @property time tar_hinicio
 * @property date tar_ffin
 * @property time tar_hfin
 * @property integer tar_estado
 * @property string tar_cursos
 * @property string tar_aux_cursos
 */
class AulaVirtual extends Model
{

    public $table = 'tareas';
    protected $primaryKey='tar_id';
    public $timestamps = false;

    public $fillable = [
        'usu_id',
        'tar_tipo',
        'tar_titulo',
        'tar_descripcion',
        'tar_adjuntos',
        'tar_link',
        'tar_finicio',
        'tar_hinicio',
        'tar_ffin',
        'tar_hfin',
        'tar_estado',
        'tar_cursos',
        'tar_aux_cursos',
        'tar_codigo',
        'esp_id',
        'mtr_id',
        'tar_mostrar'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'tar_id' => 'integer',
        'usu_id' => 'integer',
        'tar_tipo' => 'integer',
        'tar_titulo' => 'string',
        'tar_descripcion' => 'string',
        'tar_adjuntos' => 'string',
        'tar_link' => 'string',
        'tar_finicio' => 'date',
        'tar_ffin' => 'date',
        'tar_estado' => 'integer',
        'tar_cursos' => 'string',
        'tar_aux_cursos' => 'string',
        'tar_codigo' => 'string',
        'esp_id' => 'integer',
        'mtr_id' => 'integer',
        'tar_mostrar' => 'integer',
        
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function matriculas()
    {
        return $this->belongsToMany(\App\Models\Matricula::class, 'tareas_usuarios');
    }
}
