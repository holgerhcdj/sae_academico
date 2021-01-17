<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class VisitasHogares
 * @package App\Models
 * @version July 23, 2019, 12:05 pm -05
 *
 * @property \App\Models\Matricula matricula
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection erpNotaCredito
 * @property \Illuminate\Database\Eloquent\Collection erpNotaDebito
 * @property \Illuminate\Database\Eloquent\Collection horasExtras
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property \Illuminate\Database\Eloquent\Collection regNotasExtras
 * @property \Illuminate\Database\Eloquent\Collection seguimientoCapellania
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection facturaDetalle
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property \Illuminate\Database\Eloquent\Collection movimientosRequerimiento
 * @property \Illuminate\Database\Eloquent\Collection requerimientos
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection valorPensiones
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property integer mat_id
 * @property integer usu_id
 * @property date fecha
 * @property time h_inicio
 * @property time h_fin
 * @property string sector
 * @property string barrio
 * @property string calles
 * @property string punto_ref
 * @property string croquis
 * @property string genograma
 * @property string ant_familiares
 * @property string ant_academicas
 * @property string ant_conductuales
 * @property integer tipo_vivienda
 * @property string tipo_construccion
 * @property integer agua
 * @property integer luz
 * @property integer telefono
 * @property integer internet
 * @property integer tvcable
 * @property string otros
 * @property integer necesita_ayuda
 * @property integer vida_cristo
 * @property integer cree_jesus
 * @property string cree_porque
 * @property integer se_congrega
 * @property string congregra_frecuencia
 * @property string lugar_congrega
 * @property integer miembro_activo
 * @property string ministerio
 * @property string libros_manuales
 * @property string religion
 * @property string peticion_oracion
 * @property string porcion_biblica
 * @property string recomendaciones_familia
 * @property string recomendaciones_colegio
 * @property integer estado
 */
class VisitasHogares extends Model
{
    public $table = 'visita_hogares';
    protected $primaryKey='vstid';
    public $timestamps=false;
    public $fillable = [
        'mat_id',
        'usu_id',
        'fecha',
        'h_inicio',
        'h_fin',
        'sector',
        'barrio',
        'calles',
        'punto_ref',
        'croquis',
        'genograma',
        'ant_familiares',
        'ant_academicas',
        'ant_conductuales',
        'tipo_vivienda',
        'tipo_construccion',
        'agua',
        'luz',
        'telefono',
        'internet',
        'tvcable',
        'otros',
        'necesita_ayuda',
        'vida_cristo',
        'cree_jesus',
        'cree_porque',
        'se_congrega',
        'congregra_frecuencia',
        'lugar_congrega',
        'miembro_activo',
        'ministerio',
        'libros_manuales',
        'religion',
        'peticion_oracion',
        'porcion_biblica',
        'recomendaciones_familia',
        'recomendaciones_colegio',
        'estado', 
        'usted_bautizado',
        'porque_bautizado',
        'tipo',
        'numero',
        'img_casa'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'vstid' => 'integer',
        'mat_id' => 'integer',
        'usu_id' => 'integer',
        'fecha' => 'date',
        'sector' => 'string',
        'barrio' => 'string',
        'calles' => 'string',
        'punto_ref' => 'string',
        'croquis' => 'string',
        'genograma' => 'string',
        'ant_familiares' => 'string',
        'ant_academicas' => 'string',
        'ant_conductuales' => 'string',
        'tipo_vivienda' => 'integer',
        'tipo_construccion' => 'string',
        'agua' => 'integer',
        'luz' => 'integer',
        'telefono' => 'integer',
        'internet' => 'integer',
        'tvcable' => 'integer',
        'otros' => 'string',
        'necesita_ayuda' => 'integer',
        'vida_cristo' => 'integer',
        'cree_jesus' => 'integer',
        'cree_porque' => 'string',
        'se_congrega' => 'integer',
        'congregra_frecuencia' => 'string',
        'lugar_congrega' => 'string',
        'miembro_activo' => 'integer',
        'ministerio' => 'string',
        'libros_manuales' => 'string',
        'religion' => 'string',
        'peticion_oracion' => 'string',
        'porcion_biblica' => 'string',
        'recomendaciones_familia' => 'string',
        'recomendaciones_colegio' => 'string',
        'estado' => 'integer',
        'especialidad' => 'string',
        'representante' => 'string',
        'usted_bautizado' => 'string',
        'porque_bautizado' => 'string',
        'tipo' => 'integer',
        'numero' => 'integer',
        'img_casa' => 'string',
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
    public function matricula()
    {
        return $this->belongsTo(\App\Models\Matricula::class);
    }
}
