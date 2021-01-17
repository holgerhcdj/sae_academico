<?php

namespace App\Repositories;

use App\Models\ValorPensiones;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ValorPensionesRepository
 * @package App\Repositories
 * @version December 6, 2017, 7:46 am PET
 *
 * @method ValorPensiones findWithoutFail($id, $columns = ['*'])
 * @method ValorPensiones find($id, $columns = ['*'])
 * @method ValorPensiones first($columns = ['*'])
*/
class ValorPensionesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'anl_id',
        'descripcion',
        'valor',
        'observacion',
        'responsable',
        'estado',
        'jor_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ValorPensiones::class;
    }
}
