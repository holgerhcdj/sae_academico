<?php

namespace App\Repositories;

use App\Models\AsgJornadasLaborables;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AsgJornadasLaborablesRepository
 * @package App\Repositories
 * @version May 6, 2019, 5:11 am PET
 *
 * @method AsgJornadasLaborables findWithoutFail($id, $columns = ['*'])
 * @method AsgJornadasLaborables find($id, $columns = ['*'])
 * @method AsgJornadasLaborables first($columns = ['*'])
*/
class AsgJornadasLaborablesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'asg_jrl_usuid',
        'asg_jrl_anl',
        'asg_jrl_jor',
        'asg_jrl_desde',
        'asg_jrl_hasta',
        'asg_jrl_alm',
        'asg_jrl_alm_desde',
        'asg_jrl_alm_hasta',
        'asg_jrl_lun',
        'asg_jrl_mar',
        'asg_jrl_mie',
        'asg_jrl_jue',
        'asg_jrl_vie',
        'asg_jrl_sab',
        'asg_jrl_dom',
        'asg_jrl_obs',
        'asg_jrl_estado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AsgJornadasLaborables::class;
    }
}
