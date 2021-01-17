<?php

namespace App\Repositories;

use App\Models\Especialidades;
use InfyOm\Generator\Common\BaseRepository;

class EspecialidadesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'esp_descripcion',
        'esp_obs',
        'esp_tipo'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Especialidades::class;
    }
}
