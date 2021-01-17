<?php

namespace App\Repositories;

use App\Models\Gerencias;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class GerenciasRepository
 * @package App\Repositories
 * @version February 23, 2020, 8:44 pm PET
 *
 * @method Gerencias findWithoutFail($id, $columns = ['*'])
 * @method Gerencias find($id, $columns = ['*'])
 * @method Gerencias first($columns = ['*'])
*/
class GerenciasRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ger_codigo',
        'ger_descripcion',
        'ger_ruc',
        'ger_direccion',
        'ger_telefono',
        'ger_estado',
        'ger_rep_legal'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Gerencias::class;
    }
}
