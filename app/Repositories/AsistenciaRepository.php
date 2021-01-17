<?php

namespace App\Repositories;

use App\Models\Asistencia;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AsistenciaRepository
 * @package App\Repositories
 * @version May 31, 2018, 4:20 pm PET
 *
 * @method Asistencia findWithoutFail($id, $columns = ['*'])
 * @method Asistencia find($id, $columns = ['*'])
 * @method Asistencia first($columns = ['*'])
*/
class AsistenciaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'mat_id',
        'mtr_id',
        'fecha',
        'hora',
        'estado',
        'observaciones',
        'sms_estado',
        'sms_obs'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Asistencia::class;
    }
}
