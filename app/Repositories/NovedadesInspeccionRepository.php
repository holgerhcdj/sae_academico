<?php

namespace App\Repositories;

use App\Models\NovedadesInspeccion;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class NovedadesInspeccionRepository
 * @package App\Repositories
 * @version July 25, 2019, 11:27 am -05
 *
 * @method NovedadesInspeccion findWithoutFail($id, $columns = ['*'])
 * @method NovedadesInspeccion find($id, $columns = ['*'])
 * @method NovedadesInspeccion first($columns = ['*'])
*/
class NovedadesInspeccionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'mat_id',
        'usu_id',
        'fecha',
        'novedad',
        'acciones',
        'recomendaciones',
        'reportada_a',
        'derivado_a',
        'departamento',
        'estado',
        'envio_sms',
        'envio_detalle',
        'estado_sms'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return NovedadesInspeccion::class;
    }
}
