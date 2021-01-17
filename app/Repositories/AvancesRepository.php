<?php

namespace App\Repositories;

use App\Models\Avances;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AvancesRepository
 * @package App\Repositories
 * @version March 6, 2019, 2:40 pm PET
 *
 * @method Avances findWithoutFail($id, $columns = ['*'])
 * @method Avances find($id, $columns = ['*'])
 * @method Avances first($columns = ['*'])
*/
class AvancesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'f_inicio',
        'f_fin',
        'descripcion',
        'obs',
        'responsable',
        'estado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Avances::class;
    }
}
