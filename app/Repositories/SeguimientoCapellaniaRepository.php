<?php

namespace App\Repositories;

use App\Models\SeguimientoCapellania;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SeguimientoCapellaniaRepository
 * @package App\Repositories
 * @version July 22, 2019, 12:03 pm PET
 *
 * @method SeguimientoCapellania findWithoutFail($id, $columns = ['*'])
 * @method SeguimientoCapellania find($id, $columns = ['*'])
 * @method SeguimientoCapellania first($columns = ['*'])
*/
class SeguimientoCapellaniaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'mat_id',
        'usu_id',
        'fecha',
        'situacion_familiar',
        'situacion_academica_',
        'situacion_espiritual',
        'observacion',
        'recomendacion',
        'pedido_oracion',
        'estado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SeguimientoCapellania::class;
    }
}
