<?php

namespace App\Repositories;

use App\Models\ProTipo;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ProTipoRepository
 * @package App\Repositories
 * @version July 31, 2019, 9:39 am PET
 *
 * @method ProTipo findWithoutFail($id, $columns = ['*'])
 * @method ProTipo find($id, $columns = ['*'])
 * @method ProTipo first($columns = ['*'])
*/
class ProTipoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'descripcion',
        'observacion',
        'estado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ProTipo::class;
    }
}
