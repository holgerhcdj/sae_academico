<?php

namespace App\Repositories;

use App\Models\Insumos;
use InfyOm\Generator\Common\BaseRepository;

class InsumosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ins_descripcion',
        'ins_obs',
        'tipo',
        'anl_id',
        'ins_siglas',
        'ins_peso',
        'ins_excluyente'
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Insumos::class;
    }
}
