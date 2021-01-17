<?php

namespace App\Repositories;

use App\Models\Jornadas;
use InfyOm\Generator\Common\BaseRepository;

class JornadasRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'jor_descripcion',
        'jor_obs'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Jornadas::class;
    }
}
