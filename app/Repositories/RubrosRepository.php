<?php

namespace App\Repositories;

use App\Models\Rubros;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RubrosRepository
 * @package App\Repositories
 * @version October 8, 2018, 7:58 am PET
 *
 * @method Rubros findWithoutFail($id, $columns = ['*'])
 * @method Rubros find($id, $columns = ['*'])
 * @method Rubros first($columns = ['*'])
*/
class RubrosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'rub_descripcion',
        'rub_grupo',
        'rub_valor',
        'rub_fecha_reg',
        'rub_fecha_max',
        'rub_estado',
        'usuario',
        'rub_obs',
        'rub_siglas',
        'rub_no',
        'ger_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Rubros::class;
    }
}
