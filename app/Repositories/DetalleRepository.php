<?php

namespace App\Repositories;

use App\Models\Detalle;
use InfyOm\Generator\Common\BaseRepository;

class DetalleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'encabezado_id',
        'det_descripcion',
        'obs'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Detalle::class;
    }
}
