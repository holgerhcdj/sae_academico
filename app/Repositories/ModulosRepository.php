<?php

namespace App\Repositories;

use App\Models\Modulos;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ModulosRepository
 * @package App\Repositories
 * @version September 30, 2017, 5:57 pm PET
 *
 * @method Modulos findWithoutFail($id, $columns = ['*'])
 * @method Modulos find($id, $columns = ['*'])
 * @method Modulos first($columns = ['*'])
*/
class ModulosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'menu',
        'submenu',
        'direccion',
        'estado',
        'mod_grupo'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Modulos::class;
    }
}
