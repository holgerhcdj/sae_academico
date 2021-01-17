<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSeguimientoDeceRequest;
use App\Http\Requests\UpdateSeguimientoDeceRequest;
use App\Repositories\SeguimientoDeceRepository;
use App\Repositories\SeguimientoAccionesDeceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Estudiantes;
use DB;
use Session;
use Auth;

class SeguimientoDeceController extends AppBaseController
{
    /** @var  SeguimientoDeceRepository */
    private $seguimientoDeceRepository;
    private $seguimientoAccionesDeceRepository;

    public function __construct(SeguimientoDeceRepository $seguimientoDeceRepo, SeguimientoAccionesDeceRepository $seguimientoAccDeceRepo )
    {
        $this->seguimientoDeceRepository = $seguimientoDeceRepo;
        $this->seguimientoAccionesDeceRepository = $seguimientoAccDeceRepo;
    }

    /**
     * Display a listing of the SeguimientoDece.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $seguimientoDeces=[];
        return view('seguimiento_deces.index')
            ->with('seguimientoDeces', $seguimientoDeces);
    }

    /**
     * Show the form for creating a new SeguimientoDece.
     *
     * @return Response
     */

    public function estudiante(){
        return $estudiantes = Estudiantes::
        join('matriculas', 'matriculas.est_id', '=', 'estudiantes.id')
        ->where('matriculas.anl_id', '=', Session::get('anl_id'))
        ->where('matriculas.mat_estado', '=', 1)
        ->select('estudiantes.est_apellidos','estudiantes.est_nombres','matriculas.id')
        ->orderBy('estudiantes.est_apellidos')
        ->get()->pluck('full_name', 'id');
    }

    

    public function create()
    {
        $acc=[];
        $est=$this->estudiante();
        $est->put('0','Elija un Estudiante');
        return view('seguimiento_deces.create')
        ->with('est',$est)
        ->with('acc',$acc)
        ;
    }

    /**
     * Store a newly created SeguimientoDece in storage.
     *
     * @param CreateSeguimientoDeceRequest $request
     *
     * @return Response
     */
    public function store(CreateSeguimientoDeceRequest $request)
    {
        $input = $request->all();
        if(empty($input['segid'])){
            $seguimientoDece = $this->seguimientoDeceRepository->create($input);
        }else{
            $seguimientoDece = $this->seguimientoDeceRepository->findWithoutFail($input['segid']);
        }

            $det['segid']=$seguimientoDece->segid;
            $det['departamento']=$input['departamento'];
            $det['fecha']=date('Y-m-d');
            $det['responsable']=$input['responsable'];
            $det['motivo']=$input['motivo'];
            $det['area_trabajada']=$input['area_trabajada'];
            $det['seguimiento']=$input['seguimiento'];
            $det['obs']=$input['obs'];
            $det['usu_id']=Auth::user()->id;
            $seguimientoAccionesDece = $this->seguimientoAccionesDeceRepository->create($det);


        return $this->edit($seguimientoDece->segid);
    }

    /**
     * Display the specified SeguimientoDece.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $seguimientoDece=DB::select(
            "select * from seguimiendo_dece sd
            join matriculas m on sd.mat_id=m.id
            join estudiantes e on m.est_id=e.id"
        );

        return view('seguimiento_deces.show')
        ->with('seguimientoDece', $seguimientoDece[0]);
    }

    /**
     * Show the form for editing the specified SeguimientoDece.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $seguimientoDece = $this->seguimientoDeceRepository->findWithoutFail($id);
        $acc=DB::select("select * from seg_acciones_dece sd
                        join users u on sd.usu_id=u.id
                        where segid=$id");
        //dd($acc);
        //$acc=[];
        return view('seguimiento_deces.edit')
        ->with('seguimientoDece', $seguimientoDece)
        ->with('est',$this->estudiante())
        ->with('acc',$acc)
        ;
    }

    /**
     * Update the specified SeguimientoDece in storage.
     *
     * @param  int              $id
     * @param UpdateSeguimientoDeceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSeguimientoDeceRequest $request)
    {
        $input = $request->all();
        $seguimientoDece = $this->seguimientoDeceRepository->update($request->all(), $id);

        $det['segid']=$seguimientoDece->segid;
        $det['departamento']=$input['departamento'];
        $det['fecha']=date("Y-m-d");
        $det['responsable']=$input['responsable'];
        $det['motivo']=$input['motivo'];
        $det['area_trabajada']=$input['area_trabajada'];
        $det['seguimiento']=$input['seguimiento'];
        $det['obs']=$input['obs'];
        $det['usu_id']=Auth::user()->id;
        $seguimientoAccionesDece = $this->seguimientoAccionesDeceRepository->create($det);


        return $this->edit($seguimientoDece->segid);

    }

    /**
     * Remove the specified SeguimientoDece from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $seguimientoDece = $this->seguimientoDeceRepository->findWithoutFail($id);

        if (empty($seguimientoDece)) {
            Flash::error('Seguimiento Dece not found');

            return redirect(route('seguimientoDeces.index'));
        }

        $this->seguimientoDeceRepository->delete($id);

        Flash::success('Seguimiento Dece deleted successfully.');

        return redirect(route('seguimientoDeces.index'));
    }

        public function buscar(Request $datos){
        $seg=$datos->all();
        // dd($seg);

        if (empty($seg['n_estudiante'])) {
            $sd=DB::select(
            "select sd.*,e.est_apellidos,e.est_nombres from seguimiendo_dece sd
            join matriculas m on sd.mat_id=m.id
            join estudiantes e on m.est_id=e.id
            where sd.fecha between '$seg[desde]' and '$seg[hasta]'   order by e.est_apellidos"
        );
        }else if(!empty($seg['n_estudiante'])){
            $sd=DB::select(
            "select sd.*,e.est_apellidos,e.est_nombres from seguimiendo_dece sd
            join matriculas m on sd.mat_id=m.id
            join estudiantes e on m.est_id=e.id
            where e.est_apellidos like '%".strtoupper($seg['n_estudiante'])."%' order by e.est_apellidos"
        );
        }

        return view('seguimiento_deces.index')
            ->with('seguimientoDeces', $sd);

       
    }
}
