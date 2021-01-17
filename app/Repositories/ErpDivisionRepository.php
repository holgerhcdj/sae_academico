<?php

namespace App\Repositories;

use App\Models\ErpDivision;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ErpDivisionRepository
 * @package App\Repositories
 * @version July 31, 2019, 9:46 am PET
 *
 * @method ErpDivision findWithoutFail($id, $columns = ['*'])
 * @method ErpDivision find($id, $columns = ['*'])
 * @method ErpDivision first($columns = ['*'])
*/
class ErpDivisionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'div_codigo',
        'div_descripcion',
        'ger_id',
        'div_siglas',
        'estado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ErpDivision::class;
    }
}
