<?php

namespace App\Repositories;

use App\Models\RegDisciplina;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RegDisciplinaRepository
 * @package App\Repositories
 * @version October 27, 2019, 12:59 pm PET
 *
 * @method RegDisciplina findWithoutFail($id, $columns = ['*'])
 * @method RegDisciplina find($id, $columns = ['*'])
 * @method RegDisciplina first($columns = ['*'])
*/
class RegDisciplinaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'mat_id',
        'mtr_id',
        'usu_id',
        'dsc_parcial',
        'dsc_tipo',
        'dsc_nota'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return RegDisciplina::class;
    }
}
