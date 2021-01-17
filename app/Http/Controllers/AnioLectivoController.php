<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAnioLectivoRequest;
use App\Http\Requests\UpdateAnioLectivoRequest;
use App\Repositories\AnioLectivoRepository;
use App\Repositories\InsumosRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\AnioLectivo;
use App\Models\Auditoria;
use DB;

class AnioLectivoController extends AppBaseController {

    /** @var  AnioLectivoRepository */
    private $anioLectivoRepository;
    private $insumosRepository;

    public function __construct(AnioLectivoRepository $anioLectivoRepo, InsumosRepository $insumosRepo ) {
        $this->anioLectivoRepository = $anioLectivoRepo;
        $this->insumosRepository = $insumosRepo;
    }

    /**
     * Display a listing of the AnioLectivo.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) {

        $anioLectivos =AnioLectivo::orderby('id','Asc')->get();
        return view('anio_lectivos.index')
        ->with('anioLectivos', $anioLectivos);
    }

    /**
     * Show the form for creating a new AnioLectivo.
     *
     * @return Response
     */
    public function create() {
        return view('anio_lectivos.create');
    }

    /**
     * Store a newly created AnioLectivo in storage.
     *
     * @param CreateAnioLectivoRequest $request
     *
     * @return Response
     */
    public function store(CreateAnioLectivoRequest $request) {
        $input = $request->all();
        dd($input);
        $rules = array(
            'anl_descripcion' => 'required|unique:aniolectivo,anl_descripcion',
        );
        $v = Validator::make($input, $rules);
        if ($v->fails()) {
            Flash::error("Año lectivo ya existe");
            return $this->create();
        } else {
            $anioLectivo = $this->anioLectivoRepository->create($input);
                 $aud= new Auditoria();
                 $data=["mod"=>"Año Lectivo","acc"=>"Crear","dat"=>$anioLectivo,"doc"=>"NA"];
                 $aud->save_adt($data);  

               $this->reg_insumos($input,$aniolectivo->id);

            Flash::success('Año Lectivo Guardado Correctamente.');
            return redirect(route('anioLectivos.index'));
        }
    }

    /**
     * Display the specified AnioLectivo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id) {

        $anioLectivo = $this->anioLectivoRepository->findWithoutFail($id);
        
        if (empty($anioLectivo)) {
            Flash::error('Anio Lectivo not found');
            return redirect(route('anioLectivos.index'));
        }
        return view('anio_lectivos.show')->with('anioLectivo', $anioLectivo);
    }

    /**
     * Show the form for editing the specified AnioLectivo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id) {
        $anioLectivo = $this->anioLectivoRepository->findWithoutFail($id);

        if (empty($anioLectivo)) {
            Flash::error('Anio Lectivo not found');

            return redirect(route('anioLectivos.index'));
        }
        return view('anio_lectivos.edit')->with('anioLectivo', $anioLectivo);
    }

    /**
     * Update the specified AnioLectivo in storage.
     *
     * @param  int              $id
     * @param UpdateAnioLectivoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAnioLectivoRequest $request) {

        $anioLectivo = $this->anioLectivoRepository->findWithoutFail($id);
        if (empty($anioLectivo)) {
            Flash::error('Anio Lectivo not found');
            return redirect(route('anioLectivos.index'));
        }
        $anioLectivo = $this->anioLectivoRepository->update($request->all(), $id);

        if($id==4 || $id>10 ){ ///SI ES AÑO LECTIVO 20-21 O  LOS AÑOS LECTIVOS SIGUIENTES A ID 10
           $this->reg_insumos($request->all(),$id);
        }  

        Flash::success('Año Lectivo Guardado Correctamente');
        return redirect(route('anioLectivos.index'));
    }


public function reg_insumos($dt,$anl_id){
//$ins=$this->$insumosRepository->findwhere(['anl_id',$anl_id]);  
$ins=DB::select("SELECT * FROM insumos where anl_id=$anl_id ");
if(empty($ins)){

        $peso=(100/$dt['anl_ninsumos']);
        for ($i=1; $i <= $dt['anl_ninsumos']; $i++) { 
            $input['ins_descripcion']='Insumo'.$i;
            $input['ins_obs']='Insumo'.$i;
            $input['tipo']='I';
            $input['anl_id']=$anl_id;
            $input['ins_siglas']='I'.$i;
            $input['ins_peso']=$peso;
            $insumos = $this->insumosRepository->create($input);
        }
        //EVALUACIÓN QUIMESTRAL
            $ev_quimestral="NA";
            $sgl_ev="NA";
            if($dt['anl_evq_tipo']==0){
                $ev_quimestral="Examen Quimestral";
                $sgl_ev="EXQ";
            }
            if($dt['anl_evq_tipo']==1){
                $ev_quimestral="Proyecto";
                $sgl_ev="PROY";
            }
            if($dt['anl_evq_tipo']==2){
                $ev_quimestral="Otro";
                $sgl_ev="OTR";
            }
        //Evalauciones quimestrales
            $input['ins_descripcion']=$ev_quimestral.' Q1';
            $input['ins_obs']='Evaluación quimestral';
            $input['tipo']='EQ1';
            $input['anl_id']=$anl_id;
            $input['ins_siglas']=$sgl_ev.' 1';
            $input['ins_peso']=$dt['anl_peso_ev'];
            $insumos = $this->insumosRepository->create($input);

            $input['ins_descripcion']=$ev_quimestral.' Q2';
            $input['ins_obs']='Evaluación quimestral';
            $input['tipo']='EQ2';
            $input['anl_id']=$anl_id;
            $input['ins_siglas']=$sgl_ev.' 2';
            $input['ins_peso']=$dt['anl_peso_ev'];
            $insumos = $this->insumosRepository->create($input);
        //SUPLETORIO
            $input['ins_descripcion']='Supletorio';
            $input['ins_obs']='Examen Supletorio';
            $input['tipo']='S';
            $input['anl_id']=$anl_id;
            $input['ins_siglas']='SPL';
            $input['ins_peso']=70;
            $insumos = $this->insumosRepository->create($input);
        //REMEDIAL
            $input['ins_descripcion']='Remedial';
            $input['ins_obs']='Examen Remedial';
            $input['tipo']='R';
            $input['anl_id']=$anl_id;
            $input['ins_siglas']='REM';
            $input['ins_peso']=70;
            $insumos = $this->insumosRepository->create($input);
        //EX GRACIA
            $input['ins_descripcion']='Gracia';
            $input['ins_obs']='Examen Gracia';
            $input['tipo']='G';
            $input['anl_id']=$anl_id;
            $input['ins_siglas']='GRA';
            $input['ins_peso']=70;
            $insumos = $this->insumosRepository->create($input);

}



}


    /**
     * Remove the specified AnioLectivo from storage.
     *
     * @param  int $id
     *
     * @return Response
     */

    public function cambia_periodos_bgu(Request $rq){

        $dt=$rq->all();

        $periodo=DB::select("SELECT * FROM aniolectivo WHERE id=".$dt['vl']);

        // Session::put('anl_id',$anl_id);
        // Session::put('anio',$anl_select[0]->anl_descripcion);
        // Session::put('msj',$msj[0]->msj);
        Session::put('periodo_id',$periodo[0]->id);
        Session::put('periodo_descripcion',$periodo[0]->anl_descripcion.' '.$periodo[0]->anl_obs);

        return 0;

    }
    public function periodos_bgu() {
                 $periodo_layout=DB::select("SELECT * FROM aniolectivo WHERE periodo=1 order by id asc");
                 $rsp="<tr>
                 <th>#</th>
                 <th>Periodo</th>
                 <th class='text-center'>Nivel</th>
                 <th class='text-center'>Activo</th>
                 </tr>";
                 foreach ($periodo_layout as $pl) {
                    $chk='';
                    if($pl->id==Session::get('periodo_id')){
                        $chk='checked';
                    }
                     $rsp.="<tr>
                                <td>".$pl->id."</td>
                                <td>".$pl->anl_descripcion."</td>
                                <td>".$pl->anl_obs."</td>
                                <td  class='text-center'><input type='radio' $chk name='rd_periodo' class='rd_periodo' data='".$pl->id."' /></td>
                           </tr>";

                 }
                 return response()->json($rsp);
    }

    public function destroy($id) {

        $anioLectivo = $this->anioLectivoRepository->findWithoutFail($id);
        if (empty($anioLectivo)) {
            Flash::error('Anio Lectivo not found');
            return redirect(route('anioLectivos.index'));
        }
        $this->anioLectivoRepository->delete($id);
                 $aud= new Auditoria();
                 $data=["mod"=>"Año Lectivo","acc"=>"Eliminar","dat"=>$anioLectivo,"doc"=>$id];
                 $aud->save_adt($data);        
        Flash::success('Anio Lectivo borrado successfully.');
        return redirect(route('anioLectivos.index'));

    }

//**************************************//////////
//NUEVA PROGRAMACIÓN OCTUBRE 2020 REGISTRO DE NOTAS
//*****************************************///////
    public function obtiene_anio_lectivo(Request $rq) {
        $dt=$rq->all();
        if($dt['op']==0){
            return Session::get('anl_id'); 
        }else{
            return Session::get('periodo_id'); 
        }
        
        //return 150;
    }


}
