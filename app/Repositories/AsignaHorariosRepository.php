<?php

namespace App\Repositories;

use App\Models\AsignaHorarios;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AsignaHorariosRepository
 * @package App\Repositories
 * @version October 11, 2017, 8:58 pm PET
 *
 * @method AsignaHorarios findWithoutFail($id, $columns = ['*'])
 * @method AsignaHorarios find($id, $columns = ['*'])
 * @method AsignaHorarios first($columns = ['*'])
*/
class AsignaHorariosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'anl_id',
        'usu_id',
        'suc_id',
        'jor_id',
        'esp_id',
        'cur_id',
        'mtr_id',
        'paralelo',
        'tipo',
        'horas',
        'obs'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AsignaHorarios::class;
    }
}
