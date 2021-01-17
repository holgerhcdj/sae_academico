<?php

namespace App\Repositories;

use App\Models\SeguimientoAccionesDece;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SeguimientoAccionesDeceRepository
 * @package App\Repositories
 * @version July 17, 2019, 10:53 am PET
 *
 * @method SeguimientoAccionesDece findWithoutFail($id, $columns = ['*'])
 * @method SeguimientoAccionesDece find($id, $columns = ['*'])
 * @method SeguimientoAccionesDece first($columns = ['*'])
*/
class SeguimientoAccionesDeceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'segid',
        'departamento',
        'fecha',
        'responsable',
        'area_trabajada',
        'seguimiento',
        'obs',
        'usu_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SeguimientoAccionesDece::class;
    }
}
