<?php

namespace App\Repositories;

use App\Models\Materias;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MateriasRepository
 * @package App\Repositories
 * @version October 9, 2017, 7:38 pm PET
 *
 * @method Materias findWithoutFail($id, $columns = ['*'])
 * @method Materias find($id, $columns = ['*'])
 * @method Materias first($columns = ['*'])
*/
class MateriasRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'mtr_descripcion',
        'mtr_obs',
        'mtr_tipo',
        'anl_id',
        'esp_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Materias::class;
    }
}
