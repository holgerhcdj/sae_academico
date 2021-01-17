<?php

namespace App\Repositories;

use App\Models\SeguimientoCapDocentes;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SeguimientoCapDocentesRepository
 * @package App\Repositories
 * @version July 22, 2019, 12:32 pm PET
 *
 * @method SeguimientoCapDocentes findWithoutFail($id, $columns = ['*'])
 * @method SeguimientoCapDocentes find($id, $columns = ['*'])
 * @method SeguimientoCapDocentes first($columns = ['*'])
*/
class SeguimientoCapDocentesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'usu_id',
        'usu_id2',
        'fecha',
        'historia_vida',
        'situacion_academica',
        'recomendaciones',
        'necesidad_oracion',
        'recomendacion',
        'estado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SeguimientoCapDocentes::class;
    }
}
