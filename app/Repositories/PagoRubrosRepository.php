<?php

namespace App\Repositories;

use App\Models\PagoRubros;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PagoRubrosRepository
 * @package App\Repositories
 * @version October 8, 2018, 8:37 am PET
 *
 * @method PagoRubros findWithoutFail($id, $columns = ['*'])
 * @method PagoRubros find($id, $columns = ['*'])
 * @method PagoRubros first($columns = ['*'])
*/
class PagoRubrosRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'rub_id',
        'per_id',
        'usu_id',
        'pgr_fecha',
        'pgr_monto',
        'pgr_forma_pago',
        'pgr_banco',
        'pgr_fecha_efectiviza',
        'pgr_documento',
        'pgr_tipo',
        'pgr_estado',
        'pgr_obs',
        'pgr_num'
    ];

    public function model()
    {
        return PagoRubros::class;
    }
}
