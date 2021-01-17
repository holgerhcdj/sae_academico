<?php

namespace App\Repositories;

use App\Models\EncRegistros;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class EncRegistrosRepository
 * @package App\Repositories
 * @version September 14, 2019, 10:55 am PET
 *
 * @method EncRegistros findWithoutFail($id, $columns = ['*'])
 * @method EncRegistros find($id, $columns = ['*'])
 * @method EncRegistros first($columns = ['*'])
*/
class EncRegistrosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'prg_id',
        'usu_id',
        'respuesta'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return EncRegistros::class;
    }
}
