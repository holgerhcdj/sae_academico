<?php

namespace App\Repositories;

use App\Models\Tramites;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TramitesRepository
 * @package App\Repositories
 * @version March 18, 2018, 11:00 am PET
 *
 * @method Tramites findWithoutFail($id, $columns = ['*'])
 * @method Tramites find($id, $columns = ['*'])
 * @method Tramites first($columns = ['*'])
*/
class TramitesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'dep_id',
        'nombre_tramite',
        'obs'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Tramites::class;
    }
}
