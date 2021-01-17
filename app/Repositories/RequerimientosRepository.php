<?php

namespace App\Repositories;

use App\Models\Requerimientos;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RequerimientosRepository
 * @package App\Repositories
 * @version March 2, 2018, 10:30 pm PET
 *
 * @method Requerimientos findWithoutFail($id, $columns = ['*'])
 * @method Requerimientos find($id, $columns = ['*'])
 * @method Requerimientos first($columns = ['*'])
*/
class RequerimientosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'usu_id',
        'asunto',
        'codigo',
        'descripcion',
        'fecha_registro',
        'fecha_finalizacion',
        'archivo',
        'estado',
        'hora_registro',
        'hora_final',
        'trm_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Requerimientos::class;
    }
}
