<?php

namespace App\Repositories;

use App\Models\EvaluacionGrupo;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class EvaluacionGrupoRepository
 * @package App\Repositories
 * @version April 18, 2020, 8:30 am PET
 *
 * @method EvaluacionGrupo findWithoutFail($id, $columns = ['*'])
 * @method EvaluacionGrupo find($id, $columns = ['*'])
 * @method EvaluacionGrupo first($columns = ['*'])
*/
class EvaluacionGrupoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'evl_id',
        'evg_descripcion',
        'evg_valoracion',
        'evg_estado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return EvaluacionGrupo::class;
    }
}
