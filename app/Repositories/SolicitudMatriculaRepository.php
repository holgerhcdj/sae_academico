<?php

namespace App\Repositories;

use App\Models\SolicitudMatricula;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SolicitudMatriculaRepository
 * @package App\Repositories
 * @version July 5, 2020, 5:22 pm PET
 *
 * @method SolicitudMatricula findWithoutFail($id, $columns = ['*'])
 * @method SolicitudMatricula find($id, $columns = ['*'])
 * @method SolicitudMatricula first($columns = ['*'])
*/
class SolicitudMatriculaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'sol_nombres',
        'sol_email',
        'sol_telefono',
        'sol_estado',
        'sol_freg',
        'sol_hreg',
        'sol_obs_usuario',
        'sol_obs_solicitante',
        'sol_usuario'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SolicitudMatricula::class;
    }
}
