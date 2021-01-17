<?php

namespace App\Repositories;

use App\Models\MateriasCursos;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MateriasCursosRepository
 * @package App\Repositories
 * @version October 9, 2017, 6:15 am PET
 *
 * @method MateriasCursos findWithoutFail($id, $columns = ['*'])
 * @method MateriasCursos find($id, $columns = ['*'])
 * @method MateriasCursos first($columns = ['*'])
*/
class MateriasCursosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'anl_id',
        'suc_id',
        'jor_id',
        'esp_id',
        'cur_id',
        'mtr_id',
        'horas',
        'obs',
        'bloques'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MateriasCursos::class;
    }
}
