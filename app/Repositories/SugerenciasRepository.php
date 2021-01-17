<?php

namespace App\Repositories;

use App\Models\Sugerencias;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SugerenciasRepository
 * @package App\Repositories
 * @version March 14, 2019, 9:13 am PET
 *
 * @method Sugerencias findWithoutFail($id, $columns = ['*'])
 * @method Sugerencias find($id, $columns = ['*'])
 * @method Sugerencias first($columns = ['*'])
*/
class SugerenciasRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'usu_id',
        'revisado',
        'asunto',
        'f_registro',
        'f_vista',
        'detalle',
        'estado',
        'contestacion'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Sugerencias::class;
    }
}
