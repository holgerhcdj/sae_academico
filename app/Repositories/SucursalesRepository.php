<?php

namespace App\Repositories;

use App\Models\Sucursales;
use InfyOm\Generator\Common\BaseRepository;

class SucursalesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'codigo',
        'nombre',
        'direccion',
        'telefono',
        'email',
        'estado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Sucursales::class;
    }
}
