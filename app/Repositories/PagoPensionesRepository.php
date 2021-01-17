<?php

namespace App\Repositories;

use App\Models\PagoPensiones;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PagoPensionesRepository
 * @package App\Repositories
 * @version October 18, 2018, 4:30 am PET
 *
 * @method PagoPensiones findWithoutFail($id, $columns = ['*'])
 * @method PagoPensiones find($id, $columns = ['*'])
 * @method PagoPensiones first($columns = ['*'])
*/
class PagoPensionesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'descripcion',
        'f_inicio',
        'f_fin',
        'cedula',
        'estudiante',
        'valor',
        'canal',
        'ndocumento',
        'fecha_pago',
        'hora_pago',
        'valor_p',
        'cod_orden',
        'f_registro',
        'responsable'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PagoPensiones::class;
    }
}
