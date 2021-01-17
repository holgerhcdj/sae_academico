<?php

namespace App\Repositories;

use App\Models\DiasNoLaborables;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DiasNoLaborablesRepository
 * @package App\Repositories
 * @version April 27, 2019, 2:01 pm PET
 *
 * @method DiasNoLaborables findWithoutFail($id, $columns = ['*'])
 * @method DiasNoLaborables find($id, $columns = ['*'])
 * @method DiasNoLaborables first($columns = ['*'])
*/
class DiasNoLaborablesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'f_reg',
        'responsable',
        'f_desde',
        'f_hasta',
        'descripcion',
        'estado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return DiasNoLaborables::class;
    }
}
