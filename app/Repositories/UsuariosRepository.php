<?php

namespace App\Repositories;

use App\Models\Usuarios;
use InfyOm\Generator\Common\BaseRepository;

class UsuariosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'password',
        'remember_token',
        'usu_foto',
        'usu_tipo_documento',
        'usu_no_documento',
        'usu_sexo',
        'usu_apellidos',
        'usu_fnacimiento',
        'usu_canton',
        'usu_parroquia',
        'usu_direccion',
        'usu_telefono',
        'usu_celular',
        'usu_mail',
        'usu_estado_civil',
        'usu_nivel_instruccion',
        'usu_descripcion_instruccion',
        'usu_titulo',
        'usu_nacionalidad',
        'usu_dir_nacimiento',
        'usu_disc',
        'usu_disc_descripcion',
        'usu_cta_banco',
        'usu_cta_tipo',
        'usu_cta_numero',
        'usu_estado',
        'usu_perfil',
        'usu_obs',
        'username',
        'materia',
        'jor1',
        'jor2',
        'jor3',
        'esp_id',
        'jor4',
        'usu_id'        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Usuarios::class;
    }
}
