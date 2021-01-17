<?php

namespace App\Repositories;

use App\Models\AdminNotas;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AdminNotasRepository
 * @package App\Repositories
 * @version December 3, 2018, 4:24 am PET
 *
 * @method AdminNotas findWithoutFail($id, $columns = ['*'])
 * @method AdminNotas find($id, $columns = ['*'])
 * @method AdminNotas first($columns = ['*'])
*/
class AdminNotasRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'usu_id',
        'adm_tipo',
        'adm_finicio',
        'adm_ffinal',
        'adm_hinicio',
        'adm_hfinal',
        'jor_id',
        'adm_parcial',
        'esp_id',
        'cur_id',
        'paralelo',
        'mtr_id',
        'mod_id',
        'doc_id',
        'adm_estado',
        'adm_obs',
        'insumo'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AdminNotas::class;
    }
}
