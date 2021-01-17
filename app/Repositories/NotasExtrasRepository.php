<?php

namespace App\Repositories;

use App\Models\NotasExtras;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class NotasExtrasRepository
 * @package App\Repositories
 * @version January 10, 2018, 4:50 pm PET
 *
 * @method NotasExtras findWithoutFail($id, $columns = ['*'])
 * @method NotasExtras find($id, $columns = ['*'])
 * @method NotasExtras first($columns = ['*'])
*/
class NotasExtrasRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'est_id',
        'anl_id',
        'emi_id',
        'f_registro',
        'cert_primaria',
        'par_estudiantil',
        'ex_enes',
        'responsable',
        'obs',
        'n2',
        'n3',
        'n4',
        'n5',
        'n6',
        'n7',
        'n8',
        'n9',
        'n10',
        'n11',
        'n12',
        'n13'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return NotasExtras::class;
    }
}
