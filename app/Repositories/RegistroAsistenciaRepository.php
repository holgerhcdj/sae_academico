<?php

namespace App\Repositories;

use App\Models\RegistroAsistencia;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RegistroAsistenciaRepository
 * @package App\Repositories
 * @version April 27, 2019, 2:43 pm PET
 *
 * @method RegistroAsistencia findWithoutFail($id, $columns = ['*'])
 * @method RegistroAsistencia find($id, $columns = ['*'])
 * @method RegistroAsistencia first($columns = ['*'])
*/
class RegistroAsistenciaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'codigo',
        'fecha',
        'hora',
        'tipo',
        'motivo',
        'responsable',
        'estado'        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return RegistroAsistencia::class;
    }
}
