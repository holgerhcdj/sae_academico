<?php

namespace App\Repositories;

use App\Models\AulaVirtual;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AulaVirtualRepository
 * @package App\Repositories
 * @version March 17, 2020, 8:29 pm PET
 *
 * @method AulaVirtual findWithoutFail($id, $columns = ['*'])
 * @method AulaVirtual find($id, $columns = ['*'])
 * @method AulaVirtual first($columns = ['*'])
*/
class AulaVirtualRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'usu_id',
        'tar_tipo',
        'tar_titulo',
        'tar_descripcion',
        'tar_adjuntos',
        'tar_link',
        'tar_finicio',
        'tar_hinicio',
        'tar_ffin',
        'tar_hfin',
        'tar_estado',
        'tar_cursos',
        'tar_aux_cursos',
        'tar_codigo',
        'esp_id',
        'mtr_id',
        'tar_mostrar'
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AulaVirtual::class;
    }
}
