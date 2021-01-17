<?php

namespace App\Repositories;

use App\Models\Clientes;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ClientesRepository
 * @package App\Repositories
 * @version March 2, 2020, 9:14 pm PET
 *
 * @method Clientes findWithoutFail($id, $columns = ['*'])
 * @method Clientes find($id, $columns = ['*'])
 * @method Clientes first($columns = ['*'])
*/
class ClientesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'cli_fecha',
        'cli_tipo',
        'cli_categoria',
        'cli_codigo',
        'cli_apellidos',
        'cli_nombres',
        'cli_ced_ruc',
        'cli_raz_social',
        'cli_retencion',
        'cli_cup_maximo',
        'cli_nacionalidad',
        'cli_direccion',
        'cli_estado',
        'cli_telefono',
        'cli_email'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Clientes::class;
    }
}
