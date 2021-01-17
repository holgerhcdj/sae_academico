<?php

namespace App\Repositories;

use App\Models\MovimientosRequerimiento;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MovimientosRequerimientoRepository
 * @package App\Repositories
 * @version March 3, 2018, 12:36 pm PET
 *
 * @method MovimientosRequerimiento findWithoutFail($id, $columns = ['*'])
 * @method MovimientosRequerimiento find($id, $columns = ['*'])
 * @method MovimientosRequerimiento first($columns = ['*'])
*/
class MovimientosRequerimientoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'personas',
        'req_id',
        'mvr_descripcion',
        'personas_ids',
        'mvr_fecha',
        'usu_id',
        'cc_personas',
        'cc_personas_ids',
        'mvr_hora'
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MovimientosRequerimiento::class;
    }
}
