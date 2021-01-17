<?php

namespace App\Repositories;

use App\Models\Productos;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ProductosRepository
 * @package App\Repositories
 * @version July 31, 2019, 9:44 am PET
 *
 * @method Productos findWithoutFail($id, $columns = ['*'])
 * @method Productos find($id, $columns = ['*'])
 * @method Productos first($columns = ['*'])
*/
class ProductosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'tpid',
        'pro_descripcion',
        'pro_medida',
        'pro_marca',
        'pro_tipo',
        'pro_unidad',
        'pro_serie',
        'pro_codigo',
        'pro_estado',
        'pro_caracteristicas',
        'pro_color',
        'pro_valor',
        'pro_obs'        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Productos::class;
    }
}
