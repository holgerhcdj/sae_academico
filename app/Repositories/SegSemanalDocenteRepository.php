<?php

namespace App\Repositories;

use App\Models\SegSemanalDocente;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SegSemanalDocenteRepository
 * @package App\Repositories
 * @version August 21, 2019, 9:27 am PET
 *
 * @method SegSemanalDocente findWithoutFail($id, $columns = ['*'])
 * @method SegSemanalDocente find($id, $columns = ['*'])
 * @method SegSemanalDocente first($columns = ['*'])
*/
class SegSemanalDocenteRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'cap_id',
        'doc_id',
        'fecha',
        'nivel',
        'textos_biblicos',
        'respuesta',
        'nivel_final',
        'estado',
        'obs'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SegSemanalDocente::class;
    }
}
