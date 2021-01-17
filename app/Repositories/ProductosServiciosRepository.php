<?php

namespace App\Repositories;

use App\Models\ProductosServicios;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ProductosServiciosRepository
 * @package App\Repositories
 * @version February 29, 2020, 7:44 pm PET
 *
 * @method ProductosServicios findWithoutFail($id, $columns = ['*'])
 * @method ProductosServicios find($id, $columns = ['*'])
 * @method ProductosServicios first($columns = ['*'])
*/
class ProductosServiciosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'pro_codigo',
        'pro_tipo',
        'pro_descripcion',
        'pro_estado',
        'ger_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ProductosServicios::class;
    }
}
