<?php

namespace App\Repositories;

use App\Models\SmsMail;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SmsMailRepository
 * @package App\Repositories
 * @version August 7, 2019, 11:58 am PET
 *
 * @method SmsMail findWithoutFail($id, $columns = ['*'])
 * @method SmsMail find($id, $columns = ['*'])
 * @method SmsMail first($columns = ['*'])
*/
class SmsMailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'usu_id',
        'mat_id',
        'sms_mensaje',
        'sms_modulo',
        'sms_tipo',
        'destinatario',
        'estado',
        'respuesta',
        'persona',
        'sms_fecha',
        'sms_hora',
        'sms_grupo'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SmsMail::class;
    }
}
