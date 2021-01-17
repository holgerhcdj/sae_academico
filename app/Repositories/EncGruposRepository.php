<?php

namespace App\Repositories;

use App\Models\EncGrupos;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class EncGruposRepository
 * @package App\Repositories
 * @version September 14, 2019, 4:43 am PET
 *
 * @method EncGrupos findWithoutFail($id, $columns = ['*'])
 * @method EncGrupos find($id, $columns = ['*'])
 * @method EncGrupos first($columns = ['*'])
*/
class EncGruposRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'grp_descripcion',
        'grp_valoracion',
        'grp_estado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return EncGrupos::class;
    }
}
