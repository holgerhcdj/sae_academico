<?php

namespace App\Repositories;

use App\Models\Auditoria;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AuditoriaRepository
 * @package App\Repositories
 * @version October 7, 2018, 11:38 am PET
 *
 * @method Auditoria findWithoutFail($id, $columns = ['*'])
 * @method Auditoria find($id, $columns = ['*'])
 * @method Auditoria first($columns = ['*'])
*/
class AuditoriaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'usu_id',
        'adt_date',
        'adt_hour',
        'adt_modulo',
        'adt_accion',
        'adt_ip',
        'adt_documento',
        'adt_campo',
        'adt_vi',
        'adt_vf',
        'usu_login'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Auditoria::class;
    }
}
