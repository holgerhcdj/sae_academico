<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNovedadesInspeccionRequest;
use App\Http\Requests\UpdateNovedadesInspeccionRequest;
use App\Repositories\NovedadesInspeccionRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Estudiantes;
use App\Models\Matriculas;
use App\Models\Usuarios;
use DB;
use Session;

class NovedadesInspeccionController extends AppBaseController
{
    /** @var  NovedadesInspeccionRepository */
    private $novedadesInspeccionRepository;

    public function __construct(NovedadesInspeccionRepository $novedadesInspeccionRepo)
    {
        $this->novedadesInspeccionRepository = $novedadesInspeccionRepo;
    }

    /**
     * Display a listing of the NovedadesInspeccion.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $novedadesInspeccions = [];

        $docentes = Usuarios::where('usu_estado', 0)
       ->orderBy('usu_apellidos','ASC')
       ->get()->pluck('full_name', 'id');

        return view('novedades_inspeccions.index')
            ->with('novedadesInspeccions', $novedadesInspeccions)
            ->with('docentes',$docentes);
    }

    /**
     * Show the form for creating a new NovedadesInspeccion.
     *
     * @return Response
     */
    public function create()
    {
        $anl = Session::get('anl_id');

        $estud = Estudiantes::
        join('matriculas', 'matriculas.est_id', '=', 'estudiantes.id')
        ->where('matriculas.anl_id', '=', $anl)
        ->where('matriculas.mat_estado', '=', 1)
        ->select('estudiantes.est_apellidos','estudiantes.est_nombres','matriculas.id')
        ->orderBy('estudiantes.est_apellidos')
        ->get()->pluck('full_name', 'id');


        return view('novedades_inspeccions.create')
        ->with('estud',$estud);
    }


    public function codigo_sms(){
        $cod=DB::select("select max(cast(sms_grupo as integer)) as n from sms_mail ");
        $c=(($cod[0]->n)+1);
        if($c>=1 && $c<10){
            $tx='00000';
        }elseif ($c>=10 && $c<100) {
            $tx='0000';
        }elseif ($c>=100 && $c<1000) {
            $tx='000';
        }elseif ($c>=1000 && $c<10000) {
            $tx='00';
        }elseif ($c>=10000 && $c<100000) {
            $tx='0';
        }elseif ($c>=100000 && $c<1000000) {
            $tx='';
        }
        return $tx.$c;
    }

    /**
     * Store a newly created NovedadesInspeccion in storage.
     *
     * @param CreateNovedadesInspeccionRequest $request
     *
     * @return Response
     */
    public function store(CreateNovedadesInspeccionRequest $request)
    {
        $input = $request->all();
        if($input['envio_sms']==1){
                        $tp=0;
                        $cd=$this->codigo_sms();
                        $rep=DB::select("select * from matriculas m join estudiantes e on m.est_id=e.id 
                            where m.id=".$input['mat_id']);

                        if($tp==0){
                            $destino=$rep[0]->rep_telefono;
                        }else{
                            $destino=$rep[0]->rep_mail;
                        }

                        if(empty($destino)){
                            $estado=2;
                            $respuesta='Destino Inaccesible';
                        }elseif( (substr($destino,0,2)!='09' && $tp==0) ){
                            $estado=2;
                            $respuesta='Número Incorrecto';
                        }else{
                            $estado=0;
                            $respuesta=null;
                        }


                        $mod_motivo=$input['novedad'];

                        $plantilla=DB::select("SELECT * FROM plantillas_sms WHERE pln_id=1");
                        $obs_v1=str_replace('VAR1',$rep[0]->est_apellidos.' '.$rep[0]->est_nombres,$plantilla[0]->pln_descripcion);
                        $obs_v2=str_replace('VAR2',$mod_motivo,$obs_v1);
                        $obs=str_replace('VAR3',date('Y-m-d'),$obs_v2);

/*************SMS*****************//////////////
                        DB::select("INSERT INTO sms_mail (
                          usu_id,
                          mat_id,
                          sms_mensaje,
                          sms_modulo,
                          sms_tipo,
                          destinatario,
                          estado,
                          persona,
                          sms_grupo,
                          sms_fecha,
                          sms_hora,
                          respuesta
                          )
                          VALUES(
                           $input[usu_id],
                           $input[mat_id],
                          '$obs',
                          '$mod_motivo',
                          $tp,
                          '$destino',
                          $estado,
                          '".$rep[0]->rep_nombres."',
                          '$cd',
                          '".date('Y-m-d')."',
                          '".date('H:s')."',
                          '$respuesta'
                          ) ");
///************MAIL******///////////////////////////
                        $tp=1;
                        if($tp==0){
                            $destino=$rep[0]->rep_telefono;
                        }else{
                            $destino=$rep[0]->rep_mail;
                        }

                        if(empty($destino)){
                            $estado=2;
                            $respuesta='Destino Inaccesible';
                        }elseif( (substr($destino,0,2)!='09' && $tp==0) ){
                            $estado=2;
                            $respuesta='Número Incorrecto';
                        }else{
                            $estado=0;
                            $respuesta=null;
                        }

                        DB::select("INSERT INTO sms_mail (
                          usu_id,
                          mat_id,
                          sms_mensaje,
                          sms_modulo,
                          sms_tipo,
                          destinatario,
                          estado,
                          persona,
                          sms_grupo,
                          sms_fecha,
                          sms_hora,
                          respuesta
                          )
                          VALUES(
                           $input[usu_id],
                           $input[mat_id],
                          '$obs',
                          '$mod_motivo',
                          $tp,
                          '$destino',
                          $estado,
                          '".$rep[0]->rep_nombres."',
                          '$cd',
                          '".date('Y-m-d')."',
                          '".date('H:s')."',
                          '$respuesta'
                          ) ");                        

        }

        $novedadesInspeccion = $this->novedadesInspeccionRepository->create($input);
        return redirect(route('novedadesInspeccions.index'));
    }

    /**
     * Display the specified NovedadesInspeccion.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $anl = Session::get('anl_id');

        $estud = Estudiantes::
        join('matriculas', 'matriculas.est_id', '=', 'estudiantes.id')
        ->where('matriculas.anl_id', '=', $anl)
        ->where('matriculas.mat_estado', '=', 1)
        ->select('estudiantes.est_apellidos','estudiantes.est_nombres','matriculas.id')
        ->orderBy('estudiantes.est_apellidos')
        ->get()->pluck('full_name', 'id');

        $estu=DB::select(
                "select * from novedades_inspeccion ni 
                join matriculas m on ni.mat_id=m.id
                join estudiantes e on m.est_id=e.id
                where ni.inspid=$id"
            );

        return view('novedades_inspeccions.show')
        ->with('estud', $estud)
        ->with('novedadesInspeccion', $estu[0]);
    }

    /**
     * Show the form for editing the specified NovedadesInspeccion.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $novedadesInspeccion = $this->novedadesInspeccionRepository->findWithoutFail($id);

        $anl = Session::get('anl_id');

        $estud = Estudiantes::
        join('matriculas', 'matriculas.est_id', '=', 'estudiantes.id')
        ->where('matriculas.anl_id', '=', $anl)
        ->where('matriculas.mat_estado', '=', 1)
        ->select('estudiantes.est_apellidos','estudiantes.est_nombres','matriculas.id')
        ->orderBy('estudiantes.est_apellidos')
        ->get()->pluck('full_name', 'id');

        return view('novedades_inspeccions.edit')
        ->with('novedadesInspeccion', $novedadesInspeccion)
        ->with('estud',$estud);
    }

    /**
     * Update the specified NovedadesInspeccion in storage.
     *
     * @param  int              $id
     * @param UpdateNovedadesInspeccionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNovedadesInspeccionRequest $request)
    {
      $input=$request->all();
      $novedadesInspeccion = $this->novedadesInspeccionRepository->findWithoutFail($id);

        if($input['envio_sms']==1){
                        $tp=0;
                        $cd=$this->codigo_sms();
                        $rep=DB::select("select * from matriculas m join estudiantes e on m.est_id=e.id 
                            where m.id=".$input['mat_id']);
                        if($tp==0){
                            $destino=$rep[0]->rep_telefono;
                        }else{
                            $destino=$rep[0]->rep_mail;
                        }

                        if(empty($destino)){
                            $estado=2;
                            $respuesta='Destino Inaccesible';
                        }elseif( (substr($destino,0,2)!='09' && $tp==0) ){
                            $estado=2;
                            $respuesta='Número Incorrecto';
                        }else{
                            $estado=0;
                            $respuesta=null;
                        }

                        $mod_motivo=$input['novedad'];

                        $plantilla=DB::select("SELECT * FROM plantillas_sms WHERE pln_id=1");
                        $obs_v1=str_replace('VAR1',$rep[0]->est_apellidos.' '.$rep[0]->est_nombres,$plantilla[0]->pln_descripcion);
                        $obs_v2=str_replace('VAR2',$mod_motivo,$obs_v1);
                        $obs=str_replace('VAR3',date('Y-m-d'),$obs_v2);


                        DB::select("INSERT INTO sms_mail (
                          usu_id,
                          mat_id,
                          sms_mensaje,
                          sms_modulo,
                          sms_tipo,
                          destinatario,
                          estado,
                          persona,
                          sms_grupo,
                          sms_fecha,
                          sms_hora,
                          respuesta
                          )
                          VALUES(
                           $input[usu_id],
                           $input[mat_id],
                          '$obs',
                          '$mod_motivo',
                          $tp,
                          '$destino',
                          $estado,
                          '".$rep[0]->rep_nombres."',
                          '$cd',
                          '".date('Y-m-d')."',
                          '".date('H:s')."',
                          '$respuesta'
                          ) ");
        }


        $novedadesInspeccion = $this->novedadesInspeccionRepository->update($input, $id);

        Flash::success('Novedades Inspeccion updated successfully.');

        return redirect(route('novedadesInspeccions.index'));
    }

    /**
     * Remove the specified NovedadesInspeccion from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $novedadesInspeccion = $this->novedadesInspeccionRepository->findWithoutFail($id);

        if (empty($novedadesInspeccion)) {
            Flash::error('Novedades Inspeccion not found');

            return redirect(route('novedadesInspeccions.index'));
        }

        $this->novedadesInspeccionRepository->delete($id);

        Flash::success('Novedades Inspeccion deleted successfully.');

        return redirect(route('novedadesInspeccions.index'));
    }

    public function busqueda(Request $datos){
        $a=$datos->all();
            $tx_nov="";
          if(!empty($a['novedad'])){
            $tx_nov="and ni.novedad='$a[novedad]' ";
          }
        if(empty($a['nov_estudiantes'])){
          $estu=DB::select(
                "select * from novedades_inspeccion ni 
                join matriculas m on ni.mat_id=m.id
                join estudiantes e on m.est_id=e.id
                join users u on u.id=ni.usu_id

                where ni.fecha between '".$a['desde']."' and '".$a['hasta']."'  $tx_nov     "
            );
        }else{
            $estu=DB::select(
                "select * from novedades_inspeccion ni 
                join matriculas m on ni.mat_id=m.id
                join estudiantes e on m.est_id=e.id
                join users u on u.id=ni.usu_id
                where e.est_apellidos like '%".strtoupper($a['nov_estudiantes'])."%' or e.est_nombres like '%".strtoupper($a['nov_estudiantes'])."%'  $tx_nov  "
            );
        }

        return view('novedades_inspeccions.index')
            ->with('novedadesInspeccions', $estu);

    }
}
