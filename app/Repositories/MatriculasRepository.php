<?php

namespace App\Repositories;

use App\Models\Matriculas;
use InfyOm\Generator\Common\BaseRepository;

class MatriculasRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'est_id',
        'anl_id',
        'esp_id',
        'cur_id',
        'jor_id',
        'proc_id',
        'dest_id',
        'mat_paralelo',
        'mat_paralelot',
        'mat_estado',
        'mat_obs',
        'est_tipo',
        'responsable',
        'plantel_procedencia',
        'motivo',
        'fecha_asistencia',
        'fecha_accion',
        'facturar',
        'enc_tipo',
        'enc_detalle',
        'docs'        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Matriculas::class;
    }
}
