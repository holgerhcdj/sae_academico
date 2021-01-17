<?php

namespace App\Repositories;

use App\Models\Sancionados;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SancionadosRepository
 * @package App\Repositories
 * @version January 1, 2020, 3:38 pm PET
 *
 * @method Sancionados findWithoutFail($id, $columns = ['*'])
 * @method Sancionados find($id, $columns = ['*'])
 * @method Sancionados first($columns = ['*'])
*/
class SancionadosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'mat_id',
        'usu_id',
        'usu_new_id',
        'snc_fecha',
        'snc_hora_reg',
        'snc_motivo',
        'snc_resolucion',
        'snc_resolucion_descripcion',
        'snc_asistencia',
        'snc_desde',
        'snc_hasta',
        'snc_frecuencia_seg',
        'snc_notificacion',
        'snc_estado',
        'snc_finicio',
        'snc_ffin',

    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Sancionados::class;
    }
}
