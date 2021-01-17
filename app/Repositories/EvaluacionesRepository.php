<?php

namespace App\Repositories;

use App\Models\Evaluaciones;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class EvaluacionesRepository
 * @package App\Repositories
 * @version April 18, 2020, 6:58 am PET
 *
 * @method Evaluaciones findWithoutFail($id, $columns = ['*'])
 * @method Evaluaciones find($id, $columns = ['*'])
 * @method Evaluaciones first($columns = ['*'])
*/
class EvaluacionesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'usu_id',
        'evl_freg',
        'evl_descripcion',
        'evl_estado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Evaluaciones::class;
    }
}
