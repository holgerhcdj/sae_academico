<?php

namespace App\Repositories;

use App\Models\EvaluacionPreguntas;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class EvaluacionPreguntasRepository
 * @package App\Repositories
 * @version April 18, 2020, 10:41 am PET
 *
 * @method EvaluacionPreguntas findWithoutFail($id, $columns = ['*'])
 * @method EvaluacionPreguntas find($id, $columns = ['*'])
 * @method EvaluacionPreguntas first($columns = ['*'])
*/
class EvaluacionPreguntasRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'evg_id',
        'evp_pregunta',
        'evp_imagen',
        'evp_valor',
        'evp_resp1',
        'evp_resp2',
        'evp_resp3',
        'evp_resp4',
        'evp_resp5',
        'evp_resp',
        'evp_estado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return EvaluacionPreguntas::class;
    }
}
