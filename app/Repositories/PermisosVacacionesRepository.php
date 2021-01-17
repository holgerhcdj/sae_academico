<?php

namespace App\Repositories;

use App\Models\PermisosVacaciones;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PermisosVacacionesRepository
 * @package App\Repositories
 * @version April 24, 2019, 3:02 pm PET
 *
 * @method PermisosVacaciones findWithoutFail($id, $columns = ['*'])
 * @method PermisosVacaciones find($id, $columns = ['*'])
 * @method PermisosVacaciones first($columns = ['*'])
*/
class PermisosVacacionesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'usuid',
        'f_reg',
        'f_desde',
        'f_hasta',
        'h_desde',
        'h_hasta',
        'reemplazo',
        'motivo',
        'obs',
        'tipo',
        'estado',
        'pagado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PermisosVacaciones::class;
    }
}
