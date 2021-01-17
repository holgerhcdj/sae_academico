<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FichaDece
 * @package App\Models
 * @version July 14, 2019, 7:29 pm PET
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
 * @property \Illuminate\Database\Eloquent\Collection valorPensiones
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection facturaDetalle
 * @property \Illuminate\Database\Eloquent\Collection requerimientos
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection movimientosRequerimiento
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property integer mat_id
 * @property integer m_si
 * @property string m_apellidos
 * @property string m_nombres
 * @property integer m_tipo_doc
 * @property string m_num_doc
 * @property integer m_edad
 * @property integer m_est_civil
 * @property integer m_instruccion
 * @property string m_profesion
 * @property float m_ingresos
 * @property string m_telefono
 * @property string m_celular
 * @property integer p_si
 * @property string p_apellidos
 * @property string p_nombres
 * @property integer p_tipo_doc
 * @property string p_nup_doc
 * @property integer p_edad
 * @property integer p_est_civil
 * @property integer p_instruccion
 * @property string p_profesion
 * @property float p_ingresos
 * @property string p_telefono
 * @property string p_celular
 * @property string rp_parentezco
 * @property string rp_apellidos
 * @property string rp_nombres
 * @property integer rp_tipo_doc
 * @property string rp_nurp_doc
 * @property integer rp_edad
 * @property integer rp_est_civil
 * @property integer rp_instruccion
 * @property string rp_profesion
 * @property float rp_ingresos
 * @property string rp_telefono
 * @property string rp_celular
 * @property string ae_primaria
 * @property string ae_repetidos
 * @property string ae_causa_rep
 * @property string ae_inst_procedencia
 * @property string ae_motivo_cambio
 * @property string ae_dificultades
 * @property integer ae_dif_lectura
 * @property integer ae_dif_escritura
 * @property integer ae_dif_matematica
 * @property integer ae_dif_ideas
 * @property integer ap_recursos
 * @property integer ap_horas_estudio
 * @property integer n_her_8vo
 * @property integer n_her_9vo
 * @property integer n_her_10vo
 * @property integer n_her_1vo
 * @property integer n_her_2vo
 * @property integer n_her_3vo
 * @property integer sc_tipo_casa
 * @property integer sc_tipo_construccion
 * @property integer sc_num_hab
 * @property string sc_resp_economica
 * @property string sc_nivel
 * @property integer sb_agua
 * @property integer sb_electricidad
 * @property integer sb_alcantarillado
 * @property integer sb_telefono
 * @property integer sb_internet
 * @property integer sb_azfaltado
 * @property integer ap_lugar_estudio
 * @property string ap_tipo_lugar_estudio
 * @property integer ap_apoyo
 * @property string ap_apoyo_nombre
 * @property string es_enfermedad1
 * @property string es_enfermedad2
 * @property string es_enfermedad3
 * @property string es_enfermedad4
 * @property string es_tratamiento1
 * @property string es_tratamiento2
 * @property string es_tratamiento3
 * @property string es_tratamiento4
 * @property string es_alergias1
 * @property string es_operaciones1
 * @property string es_ant_graves_fmla1
 * @property integer es_discapacidad
 * @property string es_tipo_discapacidad
 * @property integer es_porcentage_disc
 * @property integer es_carnet_conadis
 * @property string es_tratamiento_disc
 * @property string es_vive_persona_discapacidad
 * @property integer es_tipo_seguro
 * @property string es_seguro
 * @property string es_observaciones
 * @property string es_maps
  * @property string estado
 */
class FichaDece extends Model
{

    public $table = 'ficha_dece';
    public $timestamps = false;
    protected $primaryKey='fc_id';

    public $fillable = [
        'mat_id',
        'm_si',
        'm_apellidos',
        'm_nombres',
        'm_tipo_doc',
        'm_num_doc',
        'm_edad',
        'm_est_civil',
        'm_instruccion',
        'm_profesion',
        'm_ingresos',
        'm_telefono',
        'm_celular',
        'p_si',
        'p_apellidos',
        'p_nombres',
        'p_tipo_doc',
        'p_nup_doc',
        'p_edad',
        'p_est_civil',
        'p_instruccion',
        'p_profesion',
        'p_ingresos',
        'p_telefono',
        'p_celular',
        'rp_parentezco',
        'rp_apellidos',
        'rp_nombres',
        'rp_tipo_doc',
        'rp_nurp_doc',
        'rp_edad',
        'rp_est_civil',
        'rp_instruccion',
        'rp_profesion',
        'rp_ingresos',
        'rp_telefono',
        'rp_celular',
        'ae_primaria',
        'ae_repetidos',
        'ae_causa_rep',
        'ae_inst_procedencia',
        'ae_motivo_cambio',
        'ae_dificultades',
        'ae_dif_lectura',
        'ae_dif_escritura',
        'ae_dif_matematica',
        'ae_dif_ideas',
        'ap_recursos',
        'ap_horas_estudio',
        'ef_relacion_familiar',
        'n_her_8vo',
        'n_her_9vo',
        'n_her_10vo',
        'n_her_1vo',
        'n_her_2vo',
        'n_her_3vo',
        'sc_tipo_casa',
        'sc_tipo_construccion',
        'sc_num_hab',
        'sc_resp_economica',
        'sc_nivel',
        'sb_agua',
        'sb_electricidad',
        'sb_alcantarillado',
        'sb_telefono',
        'sb_internet',
        'sb_azfaltado',
        'ap_lugar_estudio',
        'ap_tipo_lugar_estudio',
        'ap_apoyo',
        'ap_apoyo_nombre',
        'es_enfermedad1',
        'es_enfermedad2',
        'es_enfermedad3',
        'es_enfermedad4',
        'es_tratamiento1',
        'es_tratamiento2',
        'es_tratamiento3',
        'es_tratamiento4',
        'es_alergias1',
        'es_operaciones1',
        'es_ant_graves_fmla1',
        'es_discapacidad',
        'es_tipo_discapacidad',
        'es_porcentage_disc',
        'es_carnet_conadis',
        'es_tratamiento_disc',
        'es_vive_persona_discapacidad',
        'es_tipo_seguro',
        'es_seguro',
        'es_observaciones',
        'es_maps',
        'estado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'fc_id' => 'integer',
        'mat_id' => 'integer',
        'm_si' => 'integer',
        'm_apellidos' => 'string',
        'm_nombres' => 'string',
        'm_tipo_doc' => 'integer',
        'm_num_doc' => 'string',
        'm_edad' => 'integer',
        'm_est_civil' => 'integer',
        'm_instruccion' => 'integer',
        'm_profesion' => 'string',
        'm_ingresos' => 'float',
        'm_telefono' => 'string',
        'm_celular' => 'string',
        'p_si' => 'integer',
        'p_apellidos' => 'string',
        'p_nombres' => 'string',
        'p_tipo_doc' => 'integer',
        'p_nup_doc' => 'string',
        'p_edad' => 'integer',
        'p_est_civil' => 'integer',
        'p_instruccion' => 'integer',
        'p_profesion' => 'string',
        'p_ingresos' => 'float',
        'p_telefono' => 'string',
        'p_celular' => 'string',
        'rp_parentezco' => 'string',
        'rp_apellidos' => 'string',
        'rp_nombres' => 'string',
        'rp_tipo_doc' => 'integer',
        'rp_nurp_doc' => 'string',
        'rp_edad' => 'integer',
        'rp_est_civil' => 'integer',
        'rp_instruccion' => 'integer',
        'rp_profesion' => 'string',
        'rp_ingresos' => 'float',
        'rp_telefono' => 'string',
        'rp_celular' => 'string',
        'ae_primaria' => 'string',
        'ae_repetidos' => 'string',
        'ae_causa_rep' => 'string',
        'ae_inst_procedencia' => 'string',
        'ae_motivo_cambio' => 'string',
        'ae_dificultades' => 'string',
        'ae_dif_lectura' => 'integer',
        'ae_dif_escritura' => 'integer',
        'ae_dif_matematica' => 'integer',
        'ae_dif_ideas' => 'integer',
        'ap_recursos' => 'integer',
        'ap_horas_estudio' => 'integer',
        'ef_relacion_familiar' => 'string',
        'n_her_8vo' => 'integer',
        'n_her_9vo' => 'integer',
        'n_her_10vo' => 'integer',
        'n_her_1vo' => 'integer',
        'n_her_2vo' => 'integer',
        'n_her_3vo' => 'integer',
        'sc_tipo_casa' => 'integer',
        'sc_tipo_construccion' => 'integer',
        'sc_num_hab' => 'integer',
        'sc_resp_economica' => 'string',
        'sc_nivel' => 'string',
        'sb_agua' => 'integer',
        'sb_electricidad' => 'integer',
        'sb_alcantarillado' => 'integer',
        'sb_telefono' => 'integer',
        'sb_internet' => 'integer',
        'sb_azfaltado' => 'integer',
        'ap_lugar_estudio' => 'integer',
        'ap_tipo_lugar_estudio' => 'string',
        'ap_apoyo' => 'integer',
        'ap_apoyo_nombre' => 'string',
        'es_enfermedad1' => 'string',
        'es_enfermedad2' => 'string',
        'es_enfermedad3' => 'string',
        'es_enfermedad4' => 'string',
        'es_tratamiento1' => 'string',
        'es_tratamiento2' => 'string',
        'es_tratamiento3' => 'string',
        'es_tratamiento4' => 'string',
        'es_alergias1' => 'string',
        'es_operaciones1' => 'string',
        'es_ant_graves_fmla1' => 'string',
        'es_discapacidad' => 'integer',
        'es_tipo_discapacidad' => 'string',
        'es_porcentage_disc' => 'integer',
        'es_carnet_conadis' => 'integer',
        'es_tratamiento_disc' => 'string',
        'es_vive_persona_discapacidad' => 'string',
        'es_tipo_seguro' => 'integer',
        'es_seguro' => 'string',
        'es_observaciones' => 'string',
        'es_maps' => 'string',
        'estado' => 'integer'
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
