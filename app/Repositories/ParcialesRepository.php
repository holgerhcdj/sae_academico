<?php

namespace App\Repositories;

use App\Models\Parciales;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ParcialesRepository
 * @package App\Repositories
 * @version December 1, 2019, 10:20 am PET
 *
 * @method Parciales findWithoutFail($id, $columns = ['*'])
 * @method Parciales find($id, $columns = ['*'])
 * @method Parciales first($columns = ['*'])
*/
class ParcialesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'anl_id',
        'par_descripcion',
        'par_finicio',
        'par_ffin',
        'par_estado',
        'par_numero',
        'par_act_m',
        'par_act_v',
        'par_act_n',
        'par_act_s'
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Parciales::class;
    }
}
