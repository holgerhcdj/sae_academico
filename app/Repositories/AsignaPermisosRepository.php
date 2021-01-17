<?php

namespace App\Repositories;

use App\Models\AsignaPermisos;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AsignaPermisosRepository
 * @package App\Repositories
 * @version October 2, 2017, 6:35 pm PET
 *
 * @method AsignaPermisos findWithoutFail($id, $columns = ['*'])
 * @method AsignaPermisos find($id, $columns = ['*'])
 * @method AsignaPermisos first($columns = ['*'])
*/
class AsignaPermisosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'usu_id',
        'mod_id',
        'new',
        'edit',
        'del',
        'show',
        'grupo',
        'especial',
        'permisos_especiales'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AsignaPermisos::class;
    }
}
