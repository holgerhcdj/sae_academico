<?php

namespace App\Repositories;

use App\Models\Movimientos;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MovimientosRepository
 * @package App\Repositories
 * @version August 2, 2019, 11:07 am PET
 *
 * @method Movimientos findWithoutFail($id, $columns = ['*'])
 * @method Movimientos find($id, $columns = ['*'])
 * @method Movimientos first($columns = ['*'])
*/
class MovimientosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'proid',
        'div_id',
        'movfecha',
        'movtipo',
        'mov',
        'movtpdoc',
        'movnumdoc',
        'movvalorunit',
        'procaracteristicas',
        'proserie',
        'observaciones',
        'movestado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Movimientos::class;
    }
}
