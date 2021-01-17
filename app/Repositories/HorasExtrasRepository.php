<?php

namespace App\Repositories;

use App\Models\HorasExtras;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class HorasExtrasRepository
 * @package App\Repositories
 * @version April 24, 2019, 3:04 pm PET
 *
 * @method HorasExtras findWithoutFail($id, $columns = ['*'])
 * @method HorasExtras find($id, $columns = ['*'])
 * @method HorasExtras first($columns = ['*'])
*/
class HorasExtrasRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'usuid',
        'anlid',
        'f_reg',
        'mes',
        'horas',
        'descripcion',
        'estado',
        'responsable'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return HorasExtras::class;
    }
}
