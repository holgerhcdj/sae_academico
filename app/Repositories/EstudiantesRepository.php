<?php

namespace App\Repositories;

use App\Models\Estudiantes;
use InfyOm\Generator\Common\BaseRepository;

class EstudiantesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'est_codigo',
        'est_cedula',
        'est_apellidos',
        'est_nombres',
        'est_sexo',
        'est_fnac',
        'est_sector',
        'est_direccion',
        'est_telefono',
        'est_celular',
        'est_email',
        'est_discapacidad',
        'est_porcentaje_disc',
        'est_tiposangre',
        'proc_pais',
        'proc_provincia',
        'proc_canton',
        'proc_sector',
        'rep_cedula',
        'rep_nombres',
        'rep_telefono',
        'rep_mail',
        'est_obs',
        'est_tdocumento',
        'est_tdocumentor',
        'rep_parentezco'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Estudiantes::class;
    }
}
