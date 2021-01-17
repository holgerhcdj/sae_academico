<?php

namespace App\Repositories;

use App\Models\OrdenesPension;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class OrdenesPensionRepository
 * @package App\Repositories
 * @version December 6, 2017, 9:16 am PET
 *
 * @method OrdenesPension findWithoutFail($id, $columns = ['*'])
 * @method OrdenesPension find($id, $columns = ['*'])
 * @method OrdenesPension first($columns = ['*'])
*/
class OrdenesPensionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'anl_id',
        'mat_id',
        'fecha',
        'mes',
        'codigo',
        'valor',
        'fecha_pago',
        'tipo',
        'estado',
        'responsable',
        'obs',
        'identificador',
        'motivo',
        'vpagado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return OrdenesPension::class;
    }
}
