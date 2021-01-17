<?php

namespace App\Repositories;

use App\Models\RegNotas;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RegNotasRepository
 * @package App\Repositories
 * @version November 13, 2017, 4:50 pm PET
 *
 * @method RegNotas findWithoutFail($id, $columns = ['*'])
 * @method RegNotas find($id, $columns = ['*'])
 * @method RegNotas first($columns = ['*'])
*/
class RegNotasRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'mat_id',
        'periodo',
        'ins_id',
        'mtr_id',
        'usu_id',
        'nota',
        'f_modific',
        'disciplina',
        'mtr_tec_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return RegNotas::class;
    }
}
