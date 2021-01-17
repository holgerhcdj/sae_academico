<?php

namespace App\Repositories;

use App\Models\EncuestaGrupos;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class EncuestaGruposRepository
 * @package App\Repositories
 * @version June 25, 2020, 4:43 am PET
 *
 * @method EncuestaGrupos findWithoutFail($id, $columns = ['*'])
 * @method EncuestaGrupos find($id, $columns = ['*'])
 * @method EncuestaGrupos first($columns = ['*'])
*/
class EncuestaGruposRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ecb_id',
        'gru_descripcion',
        'gru_valoracion',
        'gru_estado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return EncuestaGrupos::class;
    }
}
