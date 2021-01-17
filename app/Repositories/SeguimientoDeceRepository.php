<?php

namespace App\Repositories;

use App\Models\SeguimientoDece;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SeguimientoDeceRepository
 * @package App\Repositories
 * @version July 17, 2019, 10:35 am PET
 *
 * @method SeguimientoDece findWithoutFail($id, $columns = ['*'])
 * @method SeguimientoDece find($id, $columns = ['*'])
 * @method SeguimientoDece first($columns = ['*'])
*/
class SeguimientoDeceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'mat_id',
        'fecha',
        'motivo',
        'responsable',
        'obs',
        'estado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SeguimientoDece::class;
    }
}
