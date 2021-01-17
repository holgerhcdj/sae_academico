<?php

namespace App\Repositories;

use App\Models\VisitasHogares;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class VisitasHogaresRepository
 * @package App\Repositories
 * @version July 23, 2019, 12:05 pm -05
 *
 * @method VisitasHogares findWithoutFail($id, $columns = ['*'])
 * @method VisitasHogares find($id, $columns = ['*'])
 * @method VisitasHogares first($columns = ['*'])
*/
class VisitasHogaresRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'mat_id',
        'usu_id',
        'fecha',
        'h_inicio',
        'h_fin',
        'sector',
        'barrio',
        'calles',
        'punto_ref',
        'croquis',
        'genograma',
        'ant_familiares',
        'ant_academicas',
        'ant_conductuales',
        'tipo_vivienda',
        'tipo_construccion',
        'agua',
        'luz',
        'telefono',
        'internet',
        'tvcable',
        'otros',
        'necesita_ayuda',
        'vida_cristo',
        'cree_jesus',
        'cree_porque',
        'se_congrega',
        'congregra_frecuencia',
        'lugar_congrega',
        'miembro_activo',
        'ministerio',
        'libros_manuales',
        'religion',
        'peticion_oracion',
        'porcion_biblica',
        'recomendaciones_familia',
        'recomendaciones_colegio',
        'estado',
        'usted_bautizado',
        'porque_bautizado',
        'tipo',
        'numero',
        'img_casa'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return VisitasHogares::class;
    }
}
