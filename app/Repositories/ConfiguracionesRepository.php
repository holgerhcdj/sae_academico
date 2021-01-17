<?php

namespace App\Repositories;

use App\Models\Configuraciones;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ConfiguracionesRepository
 * @package App\Repositories
 * @version May 20, 2019, 3:20 pm PET
 *
 * @method Configuraciones findWithoutFail($id, $columns = ['*'])
 * @method Configuraciones find($id, $columns = ['*'])
 * @method Configuraciones first($columns = ['*'])
*/
class ConfiguracionesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'con_nombre',
        'con_valor',
        'con_valor2',
        'con_valor3',
        'tipo'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Configuraciones::class;
    }
}
