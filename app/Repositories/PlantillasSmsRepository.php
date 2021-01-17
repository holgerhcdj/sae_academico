<?php

namespace App\Repositories;

use App\Models\PlantillasSms;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PlantillasSmsRepository
 * @package App\Repositories
 * @version August 15, 2019, 3:47 pm PET
 *
 * @method PlantillasSms findWithoutFail($id, $columns = ['*'])
 * @method PlantillasSms find($id, $columns = ['*'])
 * @method PlantillasSms first($columns = ['*'])
*/
class PlantillasSmsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'pln_descripcion',
        'pln_var1',
        'pln_var2',
        'pln_var3',
        'pln_var4',
        'pln_var5',
        'pln_estado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PlantillasSms::class;
    }
}
