<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEvaluacionesRequest;
use App\Http\Requests\UpdateEvaluacionesRequest;
use App\Repositories\EvaluacionesRepository;
use App\Repositories\EvaluacionGrupoRepository;
use App\Repositories\EvaluacionPreguntasRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class EvaluacionesController extends AppBaseController
{
    /** @var  EvaluacionesRepository */
    private $evaluacionesRepository;
    private $evaluacionGrupoRepository;
    private $evaluacionPreguntasRepository;

    public function __construct(
        EvaluacionesRepository $evaluacionesRepo,
        EvaluacionGrupoRepository $evaluacionGrupoRepo,
        EvaluacionPreguntasRepository $evaluacionPreguntasRepo)
    {
        $this->evaluacionesRepository = $evaluacionesRepo;
        $this->evaluacionGrupoRepository = $evaluacionGrupoRepo;
        $this->evaluacionPreguntasRepository = $evaluacionPreguntasRepo;
    }

    /**
     * Display a listing of the Evaluaciones.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->evaluacionesRepository->pushCriteria(new RequestCriteria($request));
        $evaluaciones = $this->evaluacionesRepository->all();

        return view('evaluaciones.index')
            ->with('evaluaciones', $evaluaciones);
    }

    /**
     * Show the form for creating a new Evaluaciones.
     *
     * @return Response
     */
    public function create()
    {
        return view('evaluaciones.create');
    }

    /**
     * Store a newly created Evaluaciones in storage.
     *
     * @param CreateEvaluacionesRequest $request
     *
     * @return Response
     */
    public function store(CreateEvaluacionesRequest $request)
    {
        $input = $request->all();
        $evaluaciones = $this->evaluacionesRepository->create($input);
        Flash::success('Evaluaciones saved successfully.');
        return redirect(route('evaluaciones.index'));
    }

    /**
     * Display the specified Evaluaciones.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $evaluaciones = $this->evaluacionesRepository->findWithoutFail($id);
        $grupos = $this->evaluacionGrupoRepository->scopeQuery(function($query){
            return $query->orderBy('evg_id','asc');
        })->findWhere(['evl_id'=>$id]);        

        $datos="";
        $x=0;

        foreach ($grupos as $g) {
                        //$preg=$this->evaluacionPreguntasRepository->findWhere(['evg_id'=>$g->evg_id]);        
                        $preg=$this->evaluacionPreguntasRepository->scopeQuery(function($query){
                            return $query->orderBy('evp_id','asc');
                        })->findWhere(['evg_id'=>$g->evg_id]);       

                        $n_preg=1;
                        if(count($preg)>0){
                            $n_preg=count($preg);
                        }

                                $datos.="<tr style='font-weight:bolder;background:#eee' >
                                        <td></td>
                                        <td>$g->evg_descripcion</td>
                                        <td><span class='pull-left evg_valoracion' >".number_format($g->evg_valoracion,2)."</span> <span class='pull-right' >(" .number_format(($g->evg_valoracion)/$n_preg,2).") C/U </span></td>
                                        <td>
                                            <i class='btn text-success fa fa-plus  btn-xs btn_modal_preguntas' data='$g->evg_id'></i>
                                            <i class='btn text-primary fa fa-pencil  btn-xs btn_edita_grupo' evg_id='$g->evg_id' evg_descripcion='$g->evg_descripcion' evg_valoracion='$g->evg_valoracion'   ></i>
                                            <i class='btn text-danger fa fa-trash  btn-xs btn_elimina_grupo '  evg_id='$g->evg_id' ></i>
                                        </td>
                                </tr>";
                        foreach ($preg as $p) {
                            $x++;
                                        $cls_rep1="fa fa-circle-thin";
                                        $cls_rep2="fa fa-circle-thin";
                                        $cls_rep3="fa fa-circle-thin";
                                        $cls_rep4="fa fa-circle-thin";
                                        $cls_rep5="fa fa-circle-thin";
                                        switch ($p->evp_resp) {
                                            case 1:$cls_rep1="fa fa-dot-circle-o text-success"; break;
                                            case 2:$cls_rep2="fa fa-dot-circle-o text-success"; break;
                                            case 3:$cls_rep3="fa fa-dot-circle-o text-success"; break;
                                            case 4:$cls_rep4="fa fa-dot-circle-o text-success"; break;
                                            case 5:$cls_rep5="fa fa-dot-circle-o text-success"; break;
                                        }

                                        $op_resp1="";
                                        $op_resp2="";
                                        $op_resp3="";
                                        $op_resp4="";
                                        $op_resp5="";
                                        if(strlen($p->evp_resp1)>0){
                                            $op_resp1="<span class='col-md-1' ><i class='$cls_rep1'></i></span> <span class='col-md-11 col_respuestas '><b>a)</b> $p->evp_resp1</span>";
                                        }
                                        if(strlen($p->evp_resp2)>0){
                                            $op_resp2="<span class='col-md-1' ><i class='$cls_rep2'></i></span> <span class='col-md-11 col_respuestas '><b>b)</b> $p->evp_resp2</span>";
                                        }
                                        if(strlen($p->evp_resp3)>0){
                                            $op_resp3="<span class='col-md-1' ><i class='$cls_rep3'></i></span> <span class='col-md-11 col_respuestas '><b>c)</b> $p->evp_resp3</span>";
                                        }
                                        if(strlen($p->evp_resp4)>0){
                                            $op_resp4="<span class='col-md-1' ><i class='$cls_rep4'></i></span> <span class='col-md-11 col_respuestas '><b>d)</b> $p->evp_resp4</span>";
                                        }
                                        if(strlen($p->evp_resp5)>0){
                                            $op_resp5="<span class='col-md-1' ><i class='$cls_rep5'></i></span> <span class='col-md-11 col_respuestas '><b>e)</b> $p->evp_resp5</span>";
                                        }

                            $datos.="  <tr> 
                                            <td class='text-right'>
                                                <div class='col-sm-12 badge' style='background:#fff;color:#000;border:solid 1px '>$x</div>
                                                <i class='btn text-primary fa fa-pencil col-sm-12 btn_edita_pregunta' data='$p->evp_id' ></i>
                                                <i class='btn text-danger fa fa-trash col-sm-12 btn_elimina_pregunta' data='$p->evp_id' ></i>
                                            </td>
                                            <td>$p->evp_pregunta</td>
                                            <td>
                                                    <img src='".asset('img/einstein2.jpg')."' style='width:200px;' />
                                            </td>
                                            <td>
                                                <div class='row'>
                                                    $op_resp1
                                                    $op_resp2
                                                    $op_resp3
                                                    $op_resp4
                                                    $op_resp5

                                                </di>
                                            </td>

                                       </tr> ";
                        }

            }





        return view('evaluaciones.show')
        ->with('evaluaciones', $evaluaciones)
        ->with('datos', $datos)
        ;
    }

    /**
     * Show the form for editing the specified Evaluaciones.
     *
     * @param  int $id
     *
     * @return Response
     */

    public function edit($id)
    {
        $evaluaciones = $this->evaluacionesRepository->findWithoutFail($id);

        if (empty($evaluaciones)) {
            Flash::error('Evaluaciones not found');

            return redirect(route('evaluaciones.index'));
        }

        return view('evaluaciones.edit')->with('evaluaciones', $evaluaciones);
    }

    /**
     * Update the specified Evaluaciones in storage.
     *
     * @param  int              $id
     * @param UpdateEvaluacionesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEvaluacionesRequest $request)
    {
        $evaluaciones = $this->evaluacionesRepository->findWithoutFail($id);

        if (empty($evaluaciones)) {
            Flash::error('Evaluaciones not found');

            return redirect(route('evaluaciones.index'));
        }

        $evaluaciones = $this->evaluacionesRepository->update($request->all(), $id);

        Flash::success('Evaluaciones updated successfully.');

        return redirect(route('evaluaciones.index'));
    }

    /**
     * Remove the specified Evaluaciones from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $evaluaciones = $this->evaluacionesRepository->findWithoutFail($id);
        if (empty($evaluaciones)) {
            Flash::error('Evaluaciones not found');
            return redirect(route('evaluaciones.index'));
        }
        $this->evaluacionesRepository->delete($id);
        Flash::success('Evaluaciones deleted successfully.');
        return redirect(route('evaluaciones.index'));
    }

    public function store_groups(Request $rq){
        $dt=$rq->all();
        $evg_id=$dt['evg_id'];

        if($evg_id!=0){
            $groups=$this->evaluacionGrupoRepository->update($dt,$evg_id);
        }else{
            $groups=$this->evaluacionGrupoRepository->create($dt);
        }

        return redirect(route('evaluaciones.show',$dt['evl_id']));

    }

    public function store_questions(Request $rq){
        $dt=$rq->all();
        $evp_id=$dt["evp_id"];
        $dt['evg_id']=$dt['aux_evg_id'];
        if($evp_id!=0){
            $groups=$this->evaluacionPreguntasRepository->update($dt,$evp_id);
        }else{
            $groups=$this->evaluacionPreguntasRepository->create($dt);
        }

        $evl=$this->evaluacionGrupoRepository->findWhere(['evg_id'=>$dt['evg_id']]);
        return redirect(route('evaluaciones.show',$evl[0]->evl_id));

    }

    public function elimina_grupo(Request $rq){
        $dt=$rq->all();
        $evg_id=$dt['elimina_evg_id'];
        $evp_id=$dt['elimina_evp_id'];

        if($evg_id!=0){
            $evl=$this->evaluacionGrupoRepository->findWithoutFail($evg_id);
            $this->evaluacionPreguntasRepository->deleteWhere(['evg_id'=>$evg_id]);
            $this->evaluacionGrupoRepository->delete($evg_id);
        }else{
            $evp=$this->evaluacionPreguntasRepository->findWithoutFail($evp_id);
            $evl=$this->evaluacionGrupoRepository->findWithoutFail($evp->evg_id);
            $this->evaluacionPreguntasRepository->delete($evp_id);
        }


        return redirect(route('evaluaciones.show',$evl->evl_id));

    }

    public function load_pregunta(Request $rq){
        $dt=$rq->all();
        $evp_id=$dt['evp_id'];
        $preg=DB::select("SELECT * FROM evaluacion_preguntas ep JOIN evaluacion_grupo eg ON ep.evg_id=eg.evg_id WHERE ep.evp_id=$evp_id ");

        return Response()->json($preg[0]);

//        return $evp_id;


    }




}
