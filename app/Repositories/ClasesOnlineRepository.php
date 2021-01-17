<?php

namespace App\Repositories;

use App\Models\ClasesOnline;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ClasesOnlineRepository
 * @package App\Repositories
 * @version April 12, 2020, 7:48 pm PET
 *
 * @method ClasesOnline findWithoutFail($id, $columns = ['*'])
 * @method ClasesOnline find($id, $columns = ['*'])
 * @method ClasesOnline first($columns = ['*'])
*/
class ClasesOnlineRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'usu_id',
        'mtr_id',
        'cls_days',
        'cls_hinicio',
        'cls_hfin',
        'cls_freg',
        'cls_link',
        'cls_estado',
        'cls_cursos'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ClasesOnline::class;
    }
}
