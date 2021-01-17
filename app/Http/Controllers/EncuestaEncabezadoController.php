<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEncuestaEncabezadoRequest;
use App\Http\Requests\UpdateEncuestaEncabezadoRequest;
use App\Repositories\EncuestaEncabezadoRepository;
use App\Repositories\EncuestaGruposRepository;
use App\Repositories\EncuestaPreguntasRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AnioLectivo;
use App\Models\Gerencias;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class EncuestaEncabezadoController extends AppBaseController
{
    /** @var  EncuestaEncabezadoRepository */
    private $encuestaEncabezadoRepository;
    private $encuestaGruposRepository;
    private $encuestaPreguntasRepository;
    private $anl;
    private $anl_bgu;
    private $us;
    private $ger;

    public function __construct(EncuestaEncabezadoRepository $encuestaEncabezadoRepo,EncuestaGruposRepository $encuestaGruposRepo,EncuestaPreguntasRepository $encuestaPreguntasRepo)
    {
        $this->encuestaEncabezadoRepository = $encuestaEncabezadoRepo;
        $this->encuestaGruposRepository = $encuestaGruposRepo;
        $this->encuestaPreguntasRepository = $encuestaPreguntasRepo;
        $anl = AnioLectivo::find(Session::get('anl_id'));
        $anl_bgu = AnioLectivo::find(Session::get('periodo_id'));
        $this->anl = $anl['id'];
        $this->anl_bgu = $anl_bgu['id'];
        $this->us = Auth::user()->id;
        $this->ger = 1;

    }

    /**
     * Display a listing of the EncuestaEncabezado.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
         $encuesta=DB::select("SELECT * from ect_encabezado ");

        return view('encuesta_encabezados.index')
        ->with('encuesta', $encuesta);

    }

    /**
     * Show the form for creating a new EncuestaEncabezado.
     *
     * @return Response
     */
    public function create()
    {

        // $dt=DB::select("select * from ect_encabezado ecb 
        //                 join ect_grupos gru on ecb.ecb_id=gru.ecb_id
        //                 join ect_preguntas pre on gru.gru_id=pre.gru_id");


        return view('encuesta_encabezados.create')

        ;

    }

    /**
     * Store a newly created EncuestaEncabezado in storage.
     *
     * @param CreateEncuestaEncabezadoRequest $request
     *
     * @return Response
     */
    public function store(CreateEncuestaEncabezadoRequest $request)
    {
        $input = $request->all();

        $encuestaEncabezado = $this->encuestaEncabezadoRepository->create($input);

        Flash::success('Encuesta Encabezado saved successfully.');

        return redirect(route('encuestaEncabezados.index'));
    }

    /**
     * Display the specified EncuestaEncabezado.
     *
     * @param  int $id
     *
     * @return Response
     */
    /**
     * Show the form for editing the specified EncuestaEncabezado.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {

        $encuesta=DB::select("SELECT * FROM ect_encabezado ecb 
                        JOIN ect_grupos gru on ecb.ecb_id=gru.ecb_id
                        JOIN ect_preguntas pre on gru.gru_id=pre.gru_id  
                        WHERE ecb.ecb_id=$id
                         ");

        return view('encuesta_encabezados.edit')
        ->with('encuesta', $encuesta)
        ;
    }

    /**
     * Update the specified EncuestaEncabezado in storage.
     *
     * @param  int              $id
     * @param UpdateEncuestaEncabezadoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEncuestaEncabezadoRequest $request)
    {
        $encuestaEncabezado = $this->encuestaEncabezadoRepository->findWithoutFail($id);

        if (empty($encuestaEncabezado)) {
            Flash::error('Encuesta Encabezado not found');

            return redirect(route('encuestaEncabezados.index'));
        }

        $encuestaEncabezado = $this->encuestaEncabezadoRepository->update($request->all(), $id);

        Flash::success('Encuesta Encabezado updated successfully.');

        return redirect(route('encuestaEncabezados.index'));
    }

    /**
     * Remove the specified EncuestaEncabezado from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //$this->encuestaEncabezadoRepository->delete($id);
        //DB::select("DELETE FROM ect_encabezado where  ");
        // Flash::success('Encuesta eliminada correctamente');
        // return redirect(route('encuestaEncabezados.index'));

    }



    public function guarda_encabezado(Request $rq){
        //ENCUESTA ENCABEZADO
        $dt=$rq->all();
        $dt_enc['ger_id']=$this->ger;//Capturar desdee DB
        $dt_enc['ani_id']=$this->anl;
        $dt_enc['usu_id']=$this->us;
        $dt_enc['ecb_numero']=1;//Funcion que genere 
        $dt_enc['ecb_descripcion']=$dt['ecb_desc'];
        $dt_enc['ecb_objetivo']=$dt['ecb_obj'];
        $dt_enc['ecb_estado']=0;//Poner en formulario
        $dt_enc['ecb_freg']=date('Y-m-d');
        $dt_enc['ecb_tipo']=0;//Poner en formulario

        if($dt['ecb_id']==0){
            $ect_enc = $this->encuestaEncabezadoRepository->create($dt_enc);
        }else{
            $ect_enc = $this->encuestaEncabezadoRepository->update($dt_enc,$dt['ecb_id']);

        }

    //ENCUESTA GRUPOS
            $dt_gru['ecb_id']=$ect_enc->ecb_id;
            $dt_gru['gru_descripcion']=$dt['gru_desc'];
            $dt_gru['gru_valoracion']=$dt['gru_val'];
            if($dt['ecb_id']==0){
                $encuestaGrupos = $this->encuestaGruposRepository->create($dt_gru);
            }else{
                $grupo=DB::select("SELECT * FROM ect_grupos WHERE ecb_id=".$dt_gru['ecb_id']);
                $encuestaGrupos = $this->encuestaGruposRepository->update($dt_gru,$grupo[0]->gru_id);
            }
    //ENCUESTA PREGUNTAS 
        $dt_pre['gru_id']=$encuestaGrupos->gru_id;
        $dt_pre['pre_pregunta']=$dt['pre_preg'];
        $dt_pre['pre_valoracion']=0;
        $dt_pre['pre_estado']=0;
        $encuestaPreguntas = $this->encuestaPreguntasRepository->create($dt_pre);
        $rst=[$dt_gru['gru_descripcion'],$dt_pre['pre_pregunta'],$encuestaPreguntas->pre_id,$ect_enc->ecb_id];
        return response()->json($rst);

    }

    public function elimina_pregunta(Request $rq){
        $dt=$rq->all();
        $preid=$dt['preid'];
        $this->encuestaPreguntasRepository->delete($preid);
        //return response()->json($preid);
        return 0;
      //dd($dt);
    }


    public function usuarios_carga_horaria(){
//      and u.id=57 / 70 /42
        return DB::select(" SELECT u.id,u.usu_apellidos,name FROM users u WHERE  
                              exists(select id from asg_horario_profesores ap WHERE ap.usu_id=u.id and ap.anl_id=$this->anl and suc_id=1) 
                              and u.usu_estado=0 order by u.usu_apellidos ");

    }

    public function cursos_paralelos_asignados($us){

            return DB::select("  SELECT ap.jor_id,u.esp_id,ap.cur_id,ap.paralelo,ap.mtr_id 
                from asg_horario_profesores ap 
                JOIN users u on u.id=ap.usu_id
                JOIN materias m on m.id=ap.mtr_id
                WHERE u.id=$us
                and (ap.anl_id=$this->anl or ap.anl_id=$this->anl_bgu)
                group by ap.jor_id,u.esp_id,ap.cur_id,ap.paralelo,ap.mtr_id 
                order by ap.jor_id,u.esp_id,ap.cur_id,ap.paralelo
                ");        

    }

    public function materias_tecnicas_asignadas_curso($jor,$esp,$cur){

       return DB::select(" SELECT * from asg_materias_cursos mc
                        where mc.anl_id=$this->anl
                        and mc.suc_id=1 
                        and mc.jor_id=$jor
                        and mc.esp_id=$esp
                        and mc.cur_id=$cur
                        and exists(select * from ect_registro_encuestas re where re.mtr_id=mc.mtr_id ) ");

    }


    public function show($id)
    {
//Usuarios con carga horaria
        $users=$this->usuarios_carga_horaria();
        $rst="";
        $x=0;
        foreach ($users as $u) {
            $x++;
            $us=$u->id;
//CURSOS Y PARALELOS ASIGNADOS
            $cur=$this->cursos_paralelos_asignados($us);
///POR CADA CURSO Y PARALELO MATERIAS O MODULOS ENCUESTADOS (0% 50% 100%)
            $porc_tot=0;
            $preg_tot=0;
            $cont_tot=0;
            $tot_gen_user=0;
            foreach ($cur as $c) {
                    $sql_par="and m.mat_paralelo='".$c->paralelo."'";
                    $mtr_tp=0;
                    $sql_mtrid="and mt.id=".$c->mtr_id;
                    $sql_esp="";
                if($c->mtr_id==1){
                    $sql_par="and m.mat_paralelot='".$c->paralelo."'";
                    $mtr_tp=1;
                    $sql_mtrid="";
                    $sql_esp="and m.esp_id=".$c->esp_id;
                }
                $sql=("SELECT  mt.mtr_descripcion,
                                    r.mtr_id,
                                    count(r.reg_respuesta) as n_preg,
                                    sum(
                                    CASE
                                    WHEN r.reg_respuesta='1'  THEN 0 
                                    WHEN r.reg_respuesta='2'  THEN 50 
                                    WHEN r.reg_respuesta='3'  THEN 100 
                                    END
                                    )/count(r.reg_respuesta) as porciento
                                    from ect_preguntas p 
                                    join ect_registro_encuestas r on p.pre_id=r.pre_id
                                    join materias mt on mt.id=r.mtr_id
                                    join matriculas m on m.id=r.mat_id
                                    WHERE m.anl_id=$this->anl
                                    and m.jor_id=$c->jor_id
                                    and m.cur_id=$c->cur_id
                                    and mt.mtr_tipo=$mtr_tp
                                    $sql_esp
                                    $sql_par
                                    $sql_mtrid
                                    group by mt.mtr_descripcion,r.mtr_id
                                    order by mt.mtr_descripcion,r.mtr_id
                    ");
                //dd($sql);
                $calif=DB::select($sql);
            ///POR CADA MATERIA CALIFICADA SE SUMA LOS TOTALES              
                                foreach ($calif as $clf) {
                                    $cont_tot++;
                                    $porc_tot+=$clf->porciento;
                                    $preg_tot+=$clf->n_preg;
                                }

            }

            if($cont_tot==0){
                $cont_tot=1;
            }
            $tot_gen_user=number_format($porc_tot/$cont_tot,2);
            $bg_color="";
            if($tot_gen_user>70){
                //$bg_color="#00a65a";
                $bg_color="progress-bar-success";
            }elseif($tot_gen_user>=50){
                //$bg_color="#db9d19";
                $bg_color="progress-bar-warning";
            }elseif($tot_gen_user>0){
                //$bg_color="brown";
                $bg_color="progress-bar-danger";
            }

            $rst.="<tr> 
                        <td>$x</td> 
                        <td>$u->usu_apellidos $u->name</td> 
                        <td>
                                <div class='progress progress-striped active' style='background:#eee;border:solid 1px #ccc;padding:0px'>
                                  <div class='progress-bar $bg_color '  style='width:$tot_gen_user%;padding:0px;text-align:right;opacity:0.9'>$tot_gen_user %</div>
                               </div>
                        </td> 
                        <td>
                          <i style='margin-left:20px;margin-top:-10px;' usu_name='$u->usu_apellidos $u->name' usu_id='$us' tot_gen_por='$tot_gen_user' class='btn btn-primary btn-xs fa fa-list btn_detalle_encuesta'></i>
                        </td>
                   </tr>";
        }

        return view('encuesta_encabezados.show')
        ->with('rst', $rst)
        ;
    }



    // public function detalle_encuesta_curso_paralelo_materia($anl,$jor,$esp,$cur,$par,$tp,$mtr){

    //     $sql="SELECT * FROM crosstab('
    //     SELECT p.pre_pregunta,r.reg_respuesta,count(r.reg_respuesta)
    //     from ect_preguntas p 
    //     join ect_registro_encuestas r on p.pre_id=r.pre_id
    //     join materias mt on mt.id=r.mtr_id
    //     join matriculas m on m.id=r.mat_id
    //     WHERE m.anl_id=$anl
    //     and m.jor_id=$jor
    //     and m.cur_id=$cur
    //     and m.mat_paralelo=''$par''
    //     and mt.mtr_tipo=$tp
    //     and mt.id=$mtr
    //     group by p.pre_pregunta,mt.mtr_descripcion,r.mtr_id,r.reg_respuesta
    //     order by p.pre_pregunta,mt.mtr_descripcion,r.mtr_id,r.reg_respuesta
    //     '::text,'select ''3'' as respuesta union all select ''2'' union all select ''1'' '::text) 
    //     crosstab(pregunta text, siempre text,aveces text,nunca text  ); ";
    //     return DB::select($sql);

    // }

    public function load_detalle_encuesta(Request $rq){
        $peso_simepre=100;
        $peso_aveces=50;
        $peso_nunca=0;

        $dt=$rq->all();
        $us=$dt['us'];
        $cur=$this->cursos_paralelos_asignados($us);
        $rst="";
        $cnt_mtr=0;
        $tot_general=0;
        foreach ($cur as $c) {

            $sql_par="and m.mat_paralelo=''".$c->paralelo."''";
            $mtr_tp=0;
            $sql_mtrid="and mt.id=".$c->mtr_id;
            $sql_esp="";
            if($c->mtr_id==1){

                $sql_par="and m.mat_paralelot=''".$c->paralelo."''";
                $mtr_tp=1;
                $sql_esp="and m.esp_id=".$c->esp_id;
                ///BUSCO LOS MÓDULOS ASIGNADOS A CADA CURSO
                $materias=$this->materias_tecnicas_asignadas_curso($c->jor_id,$c->esp_id,$c->cur_id);
                foreach ($materias as $m) {

                    $sql_mtrid="and mt.id=".$m->mtr_id;
                    $jr=$c->jor_id;

                    // ////*******************************************************///////////////////////////
                                $sql="SELECT * FROM crosstab('
                                SELECT concat(p.pre_pregunta,''&'',j.jor_descripcion,''&'',c.cur_descripcion,''&'',mt.mtr_descripcion),r.reg_respuesta,count(r.reg_respuesta)
                                from ect_preguntas p 
                                join ect_registro_encuestas r on p.pre_id=r.pre_id
                                join materias mt on mt.id=r.mtr_id
                                join matriculas m on m.id=r.mat_id
                                join jornadas j on j.id=m.jor_id
                                join cursos c on c.id=m.cur_id
                                WHERE m.anl_id=$this->anl
                                and m.jor_id=$c->jor_id
                                and m.cur_id=$c->cur_id
                                and mt.mtr_tipo=$mtr_tp
                                $sql_esp
                                $sql_par
                                $sql_mtrid
                                group by p.pre_pregunta,j.jor_descripcion,c.cur_descripcion,mt.mtr_descripcion,r.mtr_id,r.reg_respuesta
                                order by p.pre_pregunta,j.jor_descripcion,c.cur_descripcion,mt.mtr_descripcion,r.mtr_id,r.reg_respuesta
                                '::text,'select ''3'' as respuesta union all select ''2'' union all select ''1'' '::text) 
                                crosstab(pregunta text, siempre text,aveces text,nunca text  ); ";

                                $result=DB::select($sql);

                            if(!empty($result)){
                                $cnt_mtr++;
                              
                                        $dt_enc=explode("&",$result[0]->pregunta);
                                        $enc=$dt_enc[3].' '.$dt_enc[1].' '.$dt_enc[2].' '.$c->paralelo;
                                        $rst.="
                                            <table>
                                                <tr>
                                                   <th colspan='2'> $enc </th>
                                                   <th colspan='4'>Estudiantes encuestados</th>
                                                </tr>
                                                <tr>
                                                   <th>#</th>
                                                   <th>Criterio de Evaluación</th>
                                                   <th>Siempre(100%)</th>
                                                   <th style='50px'>Algunas Veces (50%)</th>
                                                   <th>Nunca (0%)</th>
                                                   <th>%</th>
                                                </tr>
                                        ";

                                         $cnt=0;
                                         $t_est=0;
                                         $t_porc=0;
                                         $tot_porc_preg=0;
                                         $tot_porc_mtr=0;
                                        foreach ($result as $r) {
                                            $cnt++;
                                            $dt_enc=explode("&",$r->pregunta);
                                            $t_est=($r->siempre+$r->aveces+$r->nunca);
                                            $t_porc=(($r->siempre*$peso_simepre)+($r->aveces*$peso_aveces)+($r->nunca*$peso_nunca));
                                            $tot_porc_preg=number_format($t_porc/$t_est,2);
                                            $tot_porc_mtr+=$tot_porc_preg;
                                            $rst.=" <tr> 
                                                        <td>$cnt</td> 
                                                        <td>$dt_enc[0]</td> 
                                                        <td>$r->siempre</td> 
                                                        <td>$r->aveces</td> 
                                                        <td>$r->nunca</td> 
                                                        <td>$tot_porc_preg</td> 
                                                    </tr>
                                                 ";
                                        }

                                        $tot_general+=number_format($tot_porc_mtr/$cnt,2);

                                        $rst.="<tr><th colspan='5' class='text-right'>TOTAL MATERIA</th> <th>".number_format($tot_porc_mtr/$cnt,2)."</th> </tr></table>";
                                }
                    /////////////******************************************************///////////////////////////
                }

                            //$rst.="<div style='text-danger' id='lbl_tot_gen' ></di>";

            }else{

////*******************************************************///////////////////////////
            $sql="SELECT * FROM crosstab('
            SELECT concat(p.pre_pregunta,''&'',j.jor_descripcion,''&'',c.cur_descripcion,''&'',mt.mtr_descripcion),r.reg_respuesta,count(r.reg_respuesta)
            from ect_preguntas p 
            join ect_registro_encuestas r on p.pre_id=r.pre_id
            join materias mt on mt.id=r.mtr_id
            join matriculas m on m.id=r.mat_id
            join jornadas j on j.id=m.jor_id
            join cursos c on c.id=m.cur_id

            WHERE m.anl_id=$this->anl
            and m.jor_id=$c->jor_id
            and m.cur_id=$c->cur_id
            and mt.mtr_tipo=$mtr_tp
            $sql_esp
            $sql_par
            $sql_mtrid
            group by p.pre_pregunta,j.jor_descripcion,c.cur_descripcion,mt.mtr_descripcion,r.mtr_id,r.reg_respuesta
            order by p.pre_pregunta,j.jor_descripcion,c.cur_descripcion,mt.mtr_descripcion,r.mtr_id,r.reg_respuesta
            '::text,'select ''3'' as respuesta union all select ''2'' union all select ''1'' '::text) 
            crosstab(pregunta text, siempre text,aveces text,nunca text  ); ";

            $result=DB::select($sql);

        if(!empty($result)){

                    $cnt_mtr++;
          
                    $dt_enc=explode("&",$result[0]->pregunta);
                    $enc=$dt_enc[3].' '.$dt_enc[1].' '.$dt_enc[2].' '.$c->paralelo;
                    $rst.="
                        <table>
                            <tr>
                               <th colspan='2'> $enc </th>
                               <th colspan='4'>Estudiantes encuestados</th>
                            </tr>
                            <tr>
                               <th>#</th>
                               <th>Criterio de Evaluación</th>
                               <th>Siempre(100%)</th>
                               <th style='50px'>Algunas Veces (50%)</th>
                               <th>Nunca (0%)</th>
                               <th>%</th>
                            </tr>
                    ";
                    $cnt=0;
                    $t_est=0;
                    $t_porc=0;
                    $tot_porc_preg=0;
                    $tot_porc_mtr=0;

                    foreach ($result as $r) {
                        $cnt++;
                        $dt_enc=explode("&",$r->pregunta);
                        $t_est=($r->siempre+$r->aveces+$r->nunca);
                        $t_porc=(($r->siempre*$peso_simepre)+($r->aveces*$peso_aveces)+($r->nunca*$peso_nunca));
                        $tot_porc_preg=number_format($t_porc/$t_est,2);
                        $tot_porc_mtr+=$tot_porc_preg;

                        $rst.=" <tr> 
                                    <td>$cnt</td> 
                                    <td>$dt_enc[0]</td> 
                                    <td>$r->siempre</td> 
                                    <td>$r->aveces</td> 
                                    <td>$r->nunca</td> 
                                    <td>$tot_porc_preg</td> 
                                </tr>
                             ";
                    }
                    $tot_general+=number_format($tot_porc_mtr/$cnt,2);
                    $rst.="<tr><th colspan='5' class='text-right'>TOTAL MATERIA</th> <th>".number_format($tot_porc_mtr/$cnt,2)."</th> </tr></table>";
            }

            //$rst.="<div style='text-danger' id='lbl_tot_gen' ></di>";
/////////////******************************************************///////////////////////////
        }
     }

        return response()->json($rst);




    }



}
