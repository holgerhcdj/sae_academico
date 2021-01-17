<?php

namespace App\Repositories;

use App\Models\EncEncabezado;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class EncEncabezadoRepository
 * @package App\Repositories
 * @version September 14, 2019, 4:26 am PET
 *
 * @method EncEncabezado findWithoutFail($id, $columns = ['*'])
 * @method EncEncabezado find($id, $columns = ['*'])
 * @method EncEncabezado first($columns = ['*'])
*/
class EncEncabezadoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'enc_numero',
        'enc_descripcion',
        'enc_objetivo',
        'enc_estado',
        'usu_id',
        'enc_freg'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return EncEncabezado::class;
    }
}
