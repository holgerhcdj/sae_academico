<?php

namespace App\Repositories;

use App\Models\Departamentos;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DepartamentosRepository
 * @package App\Repositories
 * @version March 9, 2018, 5:41 am PET
 *
 * @method Departamentos findWithoutFail($id, $columns = ['*'])
 * @method Departamentos find($id, $columns = ['*'])
 * @method Departamentos first($columns = ['*'])
*/
class DepartamentosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'descripcion',
        'obs',
        'ger_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Departamentos::class;
    }
}
