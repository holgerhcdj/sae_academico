<?php

namespace App\Repositories;

use App\Models\EncuestaPreguntas;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class EncuestaPreguntasRepository
 * @package App\Repositories
 * @version June 25, 2020, 4:43 am PET
 *
 * @method EncuestaPreguntas findWithoutFail($id, $columns = ['*'])
 * @method EncuestaPreguntas find($id, $columns = ['*'])
 * @method EncuestaPreguntas first($columns = ['*'])
*/
class EncuestaPreguntasRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'gru_id',
        'pre_pregunta',
        'pre_valoracion',
        'pre_estado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return EncuestaPreguntas::class;
    }
}
