<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSeguimientoCapellaniaRequest;
use App\Http\Requests\UpdateSeguimientoCapellaniaRequest;
use App\Repositories\SeguimientoCapellaniaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Estudiantes;
use App\Models\Auditoria;
use Response;
use Session;
use DB;

class SeguimientoCapellaniaController extends AppBaseController
{
    /** @var  SeguimientoCapellaniaRepository */
    private $seguimientoCapellaniaRepository;
    private $anl;

    public function __construct(SeguimientoCapellaniaRepository $seguimientoCapellaniaRepo)
    {
        $this->seguimientoCapellaniaRepository = $seguimientoCapellaniaRepo;
        $this->anl=Session::get('anl_id');
    }

    /**
     * Display a listing of the SeguimientoCapellania.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
       $seguimientoCapellanias=[];
        return view('seguimiento_capellanias.index')
            ->with('seguimientoCapellanias', $seguimientoCapellanias);
    }

    /**
     * Show the form for creating a new SeguimientoCapellania.
     *
     * @return Response
     */
    public function create()
    {
        $estudiantes = Estudiantes::
        join('matriculas', 'matriculas.est_id', '=', 'estudiantes.id')
        ->where('matriculas.anl_id', '=', $this->anl)
        ->where('matriculas.mat_estado', '=', 1)
        ->select('estudiantes.est_apellidos','estudiantes.est_nombres','matriculas.id')
        ->orderBy('estudiantes.est_apellidos')
        ->get()->pluck('full_name', 'id');

        return view('seguimiento_capellanias.create') 
        ->with("estudiantes",$estudiantes);
    }

    /**
     * Store a newly created SeguimientoCapellania in storage.
     *
     * @param CreateSeguimientoCapellaniaRequest $request
     *
     * @return Response
     */
    public function store(CreateSeguimientoCapellaniaRequest $request)
    {
        $input = $request->all();

        $seguimientoCapellania = $this->seguimientoCapellaniaRepository->create($input);
        $aud= new Auditoria();
                 $data=["mod"=>"SeguimientoCapellania","acc"=>"Crear","dat"=>$seguimientoCapellania,"doc"=>"NA"];
                 $aud->save_adt($data);

        Flash::success('Seguimiento Capellania saved successfully.');

        return redirect(route('seguimientoCapellanias.index'));
    }

    /**
     * Display the specified SeguimientoCapellania.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $seguimientoCapellania=DB::select(
            "select * from seguimiento_capellania sc
            join matriculas m on sc.mat_id=m.id
            join estudiantes e on m.est_id=e.id
            join users u on sc.usu_id=u.id
            where sc.segid=$id "
        );

        return view('seguimiento_capellanias.show')
        ->with('seguimientoCapellania', $seguimientoCapellania[0]);
    }

    /**
     * Show the form for editing the specified SeguimientoCapellania.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $seguimientoCapellania = $this->seguimientoCapellaniaRepository->findWithoutFail($id);

        $estudiantes = Estudiantes::
        join('matriculas', 'matriculas.est_id', '=', 'estudiantes.id')
        ->where('matriculas.anl_id', '=', $this->anl)
        ->where('matriculas.mat_estado', '=', 1)
        ->select('estudiantes.est_apellidos','estudiantes.est_nombres','matriculas.id')
        ->orderBy('estudiantes.est_apellidos')
        ->get()->pluck('full_name', 'id');
        
        return view('seguimiento_capellanias.edit')->with('seguimientoCapellania', $seguimientoCapellania)
            ->with("estudiantes",$estudiantes);
    }

    /**
     * Update the specified SeguimientoCapellania in storage.
     *
     * @param  int              $id
     * @param UpdateSeguimientoCapellaniaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSeguimientoCapellaniaRequest $request)
    {
        $seguimientoCapellania = $this->seguimientoCapellaniaRepository->findWithoutFail($id);

        if (empty($seguimientoCapellania)) {
            Flash::error('Seguimiento Capellania not found');

            return redirect(route('seguimientoCapellanias.index'));
        }

        $seguimientoCapellania = $this->seguimientoCapellaniaRepository->update($request->all(), $id);
        $aud= new Auditoria();
                 $data=["mod"=>"SeguimientoCapellania","acc"=>"Modificar","dat"=>$seguimientoCapellania,"doc"=>"NA"];
                 $aud->save_adt($data);

        Flash::success('Seguimiento Capellania updated successfully.');

        return redirect(route('seguimientoCapellanias.index'));
    }

    /**
     * Remove the specified SeguimientoCapellania from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $seguimientoCapellania = $this->seguimientoCapellaniaRepository->findWithoutFail($id);

        if (empty($seguimientoCapellania)) {
            Flash::error('Seguimiento Capellania not found');

            return redirect(route('seguimientoCapellanias.index'));
        }

        $this->seguimientoCapellaniaRepository->delete($id);
        $aud= new Auditoria();
                 $data=["mod"=>"SeguimientoCapellania","acc"=>"Eliminar","dat"=>$seguimientoCapellania,"doc"=>"NA"];
                 $aud->save_adt($data);

        Flash::success('Seguimiento Capellania deleted successfully.');

        return redirect(route('seguimientoCapellanias.index'));
    }

    public function buscar(Request $datos){
        $seg=$datos->all();
        // dd($seg);

        if (empty($seg['n_estudiante'])) {

            $sc=DB::select(
            "select * from seguimiento_capellania sc
            join matriculas m on sc.mat_id=m.id
            join estudiantes e on m.est_id=e.id
            join users u on sc.usu_id=u.id
            where sc.fecha between '$seg[desde]' and '$seg[hasta]'"
        );
        }else if(!empty($seg['n_estudiante'])){
            $sc=DB::select(
            "select * from seguimiento_capellania sc
            join matriculas m on sc.mat_id=m.id
            join estudiantes e on m.est_id=e.id
            join users u on sc.usu_id=u.id
            where e.est_apellidos like '%".strtoupper($seg['n_estudiante'])."%' "
        );
        }

        return view('seguimiento_capellanias.index')
            ->with('seguimientoCapellanias', $sc);
    }
}
