<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Class Usuarios
 * @package App\Models
 * @version September 18, 2017, 2:46 am UTC
 */
class Usuarios extends Model
{
//    use SoftDeletes;
    public $table = 'users';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
//    protected $dates = ['deleted_at'];

    public $fillable = [
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
        'jor4'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'remember_token' => 'string',
        'usu_foto' => 'string',
        'usu_tipo_documento' => 'integer',
        'usu_no_documento' => 'string',
        'usu_sexo' => 'integer',
        'usu_apellidos' => 'string',
        'usu_fnacimiento' => 'string',
        'usu_canton' => 'string',
        'usu_parroquia' => 'string',
        'usu_direccion' => 'string',
        'usu_telefono' => 'string',
        'usu_celular' => 'string',
        'usu_mail' => 'string',
        'usu_estado_civil' => 'string',
        'usu_nivel_instruccion' => 'string',
        'usu_descripcion_instruccion' => 'string',
        'usu_titulo' => 'string',
        'usu_nacionalidad' => 'string',
        'usu_dir_nacimiento' => 'string',
        'usu_disc' => 'boolean',
        'usu_disc_descripcion' => 'string',
        'usu_cta_banco' => 'string',
        'usu_cta_tipo' => 'string',
        'usu_cta_numero' => 'string',
        'usu_estado' => 'integer',
        'usu_perfil' => 'integer',
        'usu_obs' => 'string',
        'username' => 'string',
        'materia' => 'string',
        'jor1'  => 'integer',
        'jor2'  => 'integer',
        'jor3'  => 'integer',
        'esp_id' => 'integer',
        'jor4'  => 'integer'

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function AsignaPermisos() {
        return $this->hasMany(\App\Models\AsignaPermisos::class, 'usu_id', 'id');
    }


    public function getFullNameAttribute()
    {
        return $this->usu_apellidos . ' ' . $this->name;
    }

    
}
