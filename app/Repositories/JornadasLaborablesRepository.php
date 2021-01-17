<?php

namespace App\Repositories;

use App\Models\JornadasLaborables;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class JornadasLaborablesRepository
 * @package App\Repositories
 * @version May 1, 2019, 1:37 pm PET
 *
 * @method JornadasLaborables findWithoutFail($id, $columns = ['*'])
 * @method JornadasLaborables find($id, $columns = ['*'])
 * @method JornadasLaborables first($columns = ['*'])
*/
class JornadasLaborablesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'jrl_descripcion',
        'jrl_desde',
        'jrl_hasta',
        'jrl_lun',
        'jrl_mar',
        'jrl_mie',
        'jrl_jue',
        'jrl_vie',
        'jrl_sab',
        'jrl_dom'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return JornadasLaborables::class;
    }
}
