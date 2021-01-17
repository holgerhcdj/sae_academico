<?php

namespace App\Repositories;

use App\Models\Cursos;
use InfyOm\Generator\Common\BaseRepository;

class CursosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'cur_descripcion',
        'cur_obs',
        'cur_tipo'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Cursos::class;
    }
}
