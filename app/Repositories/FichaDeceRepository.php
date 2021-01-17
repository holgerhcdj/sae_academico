<?php

namespace App\Repositories;

use App\Models\FichaDece;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class FichaDeceRepository
 * @package App\Repositories
 * @version July 14, 2019, 7:29 pm PET
 *
 * @method FichaDece findWithoutFail($id, $columns = ['*'])
 * @method FichaDece find($id, $columns = ['*'])
 * @method FichaDece first($columns = ['*'])
*/
class FichaDeceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
     * Configure the Model
     **/
    public function model()
    {
        return FichaDece::class;
    }
}
