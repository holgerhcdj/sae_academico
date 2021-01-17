<?php

namespace App\Repositories;

use App\Models\SancionadosSeguimiento;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SancionadosSeguimientoRepository
 * @package App\Repositories
 * @version January 2, 2020, 4:34 am PET
 *
 * @method SancionadosSeguimiento findWithoutFail($id, $columns = ['*'])
 * @method SancionadosSeguimiento find($id, $columns = ['*'])
 * @method SancionadosSeguimiento first($columns = ['*'])
*/
class SancionadosSeguimientoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'snc_id',
        'usu_id',
        'usu_new_id',
        'sgsnc_fecha',
        'sgsnc_sig_fecha',
        'sgsnc_hora',
        'sgsnc_sig_hora',
        'sgsnc_accion',
        'sgsnc_informe',
        'sgsnc_recomendacion',
        'sgsnc_estado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SancionadosSeguimiento::class;
    }
}
