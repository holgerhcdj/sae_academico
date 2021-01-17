<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSeguimientoCapDocentesRequest;
use App\Http\Requests\UpdateSeguimientoCapDocentesRequest;
use App\Repositories\SeguimientoCapDocentesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Usuarios;
use App\Models\Auditoria;
use Response;
use DB;

class SeguimientoCapDocentesController extends AppBaseController
{
    /** @var  SeguimientoCapDocentesRepository */
    private $seguimientoCapDocentesRepository;

    public function __construct(SeguimientoCapDocentesRepository $seguimientoCapDocentesRepo)
    {
        $this->seguimientoCapDocentesRepository = $seguimientoCapDocentesRepo;
    }

    /**
     * Display a listing of the SeguimientoCapDocentes.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $seguimientoCapDocentes=DB::select('SELECT cap.id as capellan,doc.id as docente,doc.name,doc.usu_apellidos,sc.* 
            FROM seguimiento_capellania_docentes sc 
            right join users cap on sc.usu_id=cap.id 
            right join users doc on sc.usu_id2=doc.id 
            where doc.usu_estado=0 
            ORDER BY doc.usu_apellidos' );

         return view('seguimiento_cap_docentes.index')
             ->with('seguimientoCapDocentes', $seguimientoCapDocentes);
    }

    /**
     * Show the form for creating a new SeguimientoCapDocentes.
     *
     * @return Response
     */
    public function create()
    {
        $usu = Usuarios::where('usu_estado', 0)->get()->pluck('full_name', 'id');

        return view('seguimiento_cap_docentes.create')
        ->with("usu",$usu);
    }

    /**
     * Store a newly created SeguimientoCapDocentes in storage.
     *
     * @param CreateSeguimientoCapDocentesRequest $request
     *
     * @return Response
     */
    public function store(CreateSeguimientoCapDocentesRequest $request)
    {
        $input = $request->all();
        $seguimientoCapDocentes = $this->seguimientoCapDocentesRepository->create($input);
         $aud= new Auditoria();
                 $data=["mod"=>"SeguimientoCapDocentes","acc"=>"Crear","dat"=>$seguimientoCapDocentes,"doc"=>"NA"];
                 $aud->save_adt($data);

        return redirect(route('seguimientoCapDocentes.index'));
    }

    /**
     * Display the specified SeguimientoCapDocentes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        dd('okk');
             $seguimientoCapDocentes=DB::select(
            "select * from seguimiento_capellania_docentes seg
            join users u on seg.usu_id2=u.id"
        );

        return view('seguimiento_cap_docentes.show')->with('seguimientoCapDocentes', $seguimientoCapDocentes[0]);
    }

    /**
     * Show the form for editing the specified SeguimientoCapDocentes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($dat)
    {
        $dt=explode('&',$dat);
        $segid=$dt[0];
        $docid=$dt[1];

        //$usu = Usuarios::where('usu_estado', 0)->get()->pluck('full_name', 'id');
        $user= DB::select("select * from users where id=".$docid);
        $docente=$user[0]->usu_apellidos.' '.$user[0]->name;
        $seguimientoCapDocentes = $this->seguimientoCapDocentesRepository->findWithoutFail($segid);

        if($segid>0){
                return view('seguimiento_cap_docentes.edit')
                ->with('seguimientoCapDocentes', $seguimientoCapDocentes)
                ->with("docid",$docid)
                ->with("docente",$docente);
        }else{
                return view('seguimiento_cap_docentes.create')
                ->with("docid",$docid)
                ->with("docente",$docente)
                ;
        }

    }

    /**
     * Update the specified SeguimientoCapDocentes in storage.
     *
     * @param  int              $id
     * @param UpdateSeguimientoCapDocentesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSeguimientoCapDocentesRequest $request)
    {
        $seguimientoCapDocentes = $this->seguimientoCapDocentesRepository->findWithoutFail($id);

        if (empty($seguimientoCapDocentes)) {
            Flash::error('Seguimiento Cap Docentes not found');

            return redirect(route('seguimientoCapDocentes.index'));
        }

        $seguimientoCapDocentes = $this->seguimientoCapDocentesRepository->update($request->all(), $id);
        $aud= new Auditoria();
                 $data=["mod"=>"SeguimientoCapDocentes","acc"=>"Modificar","dat"=>$seguimientoCapDocentes,"doc"=>"NA"];
                 $aud->save_adt($data);

        Flash::success('Seguimiento Cap Docentes updated successfully.');

        return redirect(route('seguimientoCapDocentes.index'));
    }

    /**
     * Remove the specified SeguimientoCapDocentes from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $seguimientoCapDocentes = $this->seguimientoCapDocentesRepository->findWithoutFail($id);

        if (empty($seguimientoCapDocentes)) {
            Flash::error('Seguimiento Cap Docentes not found');

            return redirect(route('seguimientoCapDocentes.index'));
        }

        $this->seguimientoCapDocentesRepository->delete($id);
        $aud= new Auditoria();
                 $data=["mod"=>"SeguimientoCapDocentes","acc"=>"Eliminar
                 ","dat"=>$seguimientoCapDocentes,"doc"=>"NA"];
                 $aud->save_adt($data);

        Flash::success('Seguimiento Cap Docentes deleted successfully.');

        return redirect(route('seguimientoCapDocentes.index'));
    }

       public function buscar(Request $datos){
        $seg=$datos->all();
        // dd($seg);

        if (empty($seg['n_docentes'])) {

            $sc=DB::select(
            "select * from seguimiento_capellania_docentes sc
           join users u on sc.usu_id2=u.id
            where sc.fecha between '$seg[desde]' and '$seg[hasta]'"
        );
        }else if(!empty($seg['n_docentes'])){
            $sc=DB::select(
            "select * from seguimiento_capellania_docentes sc
           join users u on sc.usu_id2=u.id
            where u.usu_apellidos like '%".strtoupper($seg['n_docentes'])."%' "
        );
        }
 return view('seguimiento_cap_docentes.index')
        ->with('seguimientoCapDocentes', $sc);

       
    }
}
