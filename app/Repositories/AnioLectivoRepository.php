<?php

namespace App\Repositories;

use App\Models\AnioLectivo;
use InfyOm\Generator\Common\BaseRepository;

class AnioLectivoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'anl_descripcion',
        'anl_obs',
        'anl_selected',
        'especial',
        'votacion',
        'periodo',
        'anl_quimestres',
        'anl_parciales',
        'anl_evq_tipo',
        'anl_peso_ev',
        'anl_ninsumos'
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AnioLectivo::class;
    }
}
