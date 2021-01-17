<?php

namespace App\Repositories;

use App\Models\Encabezado;
use InfyOm\Generator\Common\BaseRepository;

class EncabezadoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'descripcion',
        'cedula',
        'direccion'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Encabezado::class;
    }
}
