<?php

namespace App\Repositories;

use App\Models\EncuestaEncabezado;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class EncuestaEncabezadoRepository
 * @package App\Repositories
 * @version June 25, 2020, 4:42 am PET
 *
 * @method EncuestaEncabezado findWithoutFail($id, $columns = ['*'])
 * @method EncuestaEncabezado find($id, $columns = ['*'])
 * @method EncuestaEncabezado first($columns = ['*'])
*/
class EncuestaEncabezadoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ger_id',
        'ani_id',
        'usu_id',
        'ecb_numero',
        'ecb_descripcion',
        'ecb_objetivo',
        'ecb_estado',
        'ecb_freg',
        'ecb_tipo'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return EncuestaEncabezado::class;
    }
}
