<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAsistenciaRequest;
use App\Http\Requests\UpdateAsistenciaRequest;
use App\Repositories\AsistenciaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Jornadas;
use App\Models\Cursos;
use App\Models\Especialidades;
use App\Models\Materias;
use App\Models\Auditoria;
use App\Models\AnioLectivo;
use Session;
use Excel;

class AsistenciaController extends AppBaseController
{
    /** @var  AsistenciaRepository */
    private $asistenciaRepository;
    private $permiso;
    private $mod_id;
    private $anl;
    private $anl_bgu;

    public function __construct(AsistenciaRepository $asistenciaRepo)
    {
         $this->asistenciaRepository = $asistenciaRepo;
        $anl = AnioLectivo::find(Session::get('anl_id'));
        $anl_bgu = AnioLectivo::find(Session::get('periodo_id'));
        $this->anl = $anl['id'];
        $this->anl_bgu = $anl_bgu['id'];
    }

    public function permisos($mod_id){
         $usu = Auth::user();//El usuario autentificado
         $permisos=DB::select("SELECT u.*,
                                  ap.usu_id,
                                  ap.mod_id,
                                  ap.new,
                                  ap.edit,
                                  ap.del,
                                  ap.show,
                                  ap.grupo,
                                  ap.especial
                                 FROM users u
                                 join asg_permisos ap on ap.usu_id=u.id
                                 and ap.usu_id=$usu->id AND ap.mod_id=$mod_id  ");
         //$this->permiso=$permisos[0];//Permisos de el usuario autentificado en el modulo asignado
         return $permisos[0];//Permisos de el usuario autentificado en el modulo asignado

    }
    public function lista($dt)
    {
        $d=explode("&",$dt);

             $select = array('matriculas.*',
                'estudiantes.est_cedula',
                'estudiantes.est_apellidos',
                'estudiantes.est_nombres',
                'especialidades.esp_descripcion',
                'jornadas.jor_descripcion',
                'cursos.cur_descripcion');

        $lista = DB::table('matriculas')
        ->select($select)
        ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
        ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
        ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
        ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
        ->where('jor_id', '=', $d[0])
        ->where('cur_id', '=', $d[2])
        ->where('mat_paralelo', '=',$d[3])
        ->where('esp_id', '<>', 7)
        ->where('esp_id', '<>', 8)
        ->where('mat_estado', '=', 1)
        ->where('anl_id', '=', 1)
        ->orderBy('estudiantes.est_apellidos', 'ASC')
        ->get();

 $data="<tr><th>No</th><th>Estudiante</th><th>Novedad</th><th>Observacion</th></tr>";
 $c=0;
foreach ($lista as $l) {
    $c++;

        //$asistencia=DB::select("select * from asistencia where mat_id=$l->id and mtr_id=$l->mtr_id fecha='24/09/2018' ");

    $data.="
    <tr class='asist' id='$l->id' >
    <td>$c</td>
    <td>$l->est_apellidos $l->est_nombres </td>
    <td>
    <select class='form-control' id='nov_$l->id'>
        <option value='0'>Ninguna</option>
        <option value='1'>Atraso</option>
        <option value='2'>Falta</option>
        <option value='3'>Fuga</option>
        <option value='4'>Otro</option>
    </select>
    </td>
    <td>
        <input type='text' size='15' class='form-control' id='obs_$l->id' />
    </td>
    </tr>
    ";
}
        return response()->json($data);
    }




    public function index(Request $request)
    {
      $asistencias=[];
      $dt=$request->all();
      if(isset($dt['btn_buscar'])){
        $jor_id=$dt['jor_id'];
            $anio=$this->anl;
            $f=$dt['fecha'];
        if($dt['esp_id']==7){
            $anio=$this->anl_bgu;
        }
        $asistencias=DB::select("select j.jor_descripcion,
                c.cur_descripcion,
                m.mat_paralelo,
                a.fecha,
                u.usu_apellidos,
                u.name,
                a.mtr_id,
                m.jor_id,
                m.cur_id,
                mt.mtr_descripcion
                from asistencia a
                join matriculas m on a.mat_id=m.id
                join users u on u.id=a.usu_id
                join jornadas j on m.jor_id=j.id
                join cursos c on m.cur_id=c.id
                join materias mt on a.mtr_id=mt.id
                where m.anl_id=$anio
                and m.jor_id=$jor_id
                and a.fecha='$f'
                group by j.jor_descripcion,
                c.cur_descripcion,
                m.mat_paralelo,
                a.fecha,
                u.usu_apellidos,
                u.name,
                a.mtr_id,
                a.mtr_id,
                m.jor_id,
                m.cur_id,
                mt.mtr_descripcion 
                order by m.cur_id
                ");

      }

              $jor=Jornadas::orderBy('id','ASC')->pluck('jor_descripcion','id');

            return view('asistencias.index')
            ->with('jor',$jor)
            ->with('asistencias',$asistencias);

    }

    /**
     * Show the form for creating a new Asistencia.
     *
     * @return Response
     */
    public function create()
    {
        $est=[];
        $per=$this->anl_bgu;
        $jornada=Jornadas::orderBy('id','ASC')->pluck('jor_descripcion','id');
        $especialidad=Especialidades::orderBy('esp_descripcion','ASC')->pluck('esp_descripcion','id');
        $curso=Cursos::pluck('cur_descripcion','id');
        $materias=Materias::where('mtr_tipo',0)
        ->orderBy('mtr_descripcion','ASC')
        ->pluck('mtr_descripcion','id');
        return view('asistencias.create')
        ->with('jor',$jornada)
        ->with('cur',$curso)
        ->with('mtr',$materias)
        ->with('esp',$especialidad)
        ->with('anl',Session::get('anl_id'))
        ->with('per',$per)
        ->with('est',$est)
        ;
    }

    public function store(Request $req)
    {
        $dt=$req->all();
        //dd($dt);
        $c=0;
        if($dt['materia']==null){
            $dt['materia']=3;
        }
        $cd=$this->codigo_sms();
        while($c<$dt['cant']){
            $c++;
            $inp['mat_id']=$dt['mat_id'.$c];
            $inp['mtr_id']=$dt['materia'];
            $inp['fecha']=$dt['fecha'];
            $inp['hora']=date('H:s');
            $inp['estado']=$dt['estado'.$c];         // 'estado',0->Asistencia,1->Falta,2->Atraso
            $inp['observaciones']=$dt['observaciones'.$c];
            $inp['usu_id']=Auth::user()->id;
            $inp['sms_estado']=0;
            $inp['sms_obs']=null;
            $ast=DB::select("select * from asistencia where mat_id=$inp[mat_id] and fecha='$inp[fecha]' and mtr_id=$inp[mtr_id] ");
            if(empty($ast)){
                if($asistencia = $this->asistenciaRepository->create($inp)){
                    if($inp['estado']>0){//si existe novedad
                         $this->inserta_para_envio($inp,0,$cd);//Mensaje de texto
                        $this->inserta_para_envio($inp,1,$cd);//Mail
                    }
                }else{
                        dd('Error Reg. Asistencia');
                }

            }


        }

        return redirect(route('asistencias.index'));
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

    public function inserta_para_envio($inp,$tp,$cd){//$tp->si es para 0->mensaje o 1->mail
      
                        $rep=DB::select("select * from matriculas m join estudiantes e on m.est_id=e.id 
                            where m.id=".$inp['mat_id']);
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

                        if($inp['estado']==1){
                            $mod_motivo='FALTA';
                        }elseif($inp['estado']==2){
                            $mod_motivo='ATRASO';
                        }else{
                            $mod_motivo=null;
                        }


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
                           $inp[usu_id],
                           $inp[mat_id],
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

    public function show($id)
    {

        $asistencia = $this->asistenciaRepository->findWithoutFail($id);
        if (empty($asistencia)) {
            Flash::error('Asistencia not found');

            return redirect(route('asistencias.index'));
        }

        return view('asistencias.show')->with('asistencia', $asistencia);
    }

    /**
     * Show the form for editing the specified Asistencia.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($dt)
    {
      //dd('okk');
        $dat=explode("&",$dt);
            $f=$dat[0];//Fecha
            $m=$dat[1];//Materia
            $j=$dat[2];//Jornada
            $c=$dat[3];//Curso
            $p=$dat[4];//Paralelo

        $asistencias=DB::select("SELECT e.est_apellidos,
            e.est_nombres,
            a.estado,
            a.observaciones,
            a.*
            FROM asistencia a
            JOIN matriculas m ON a.mat_id=m.id
            JOIN estudiantes e ON m.est_id=e.id
            JOIN users u ON u.id=a.usu_id
            JOIN jornadas j ON m.jor_id=j.id
            JOIN cursos c ON m.cur_id=c.id
            JOIN materias mt ON a.mtr_id=mt.id
            WHERE a.fecha='$f'
            AND a.mtr_id=$m
            AND m.jor_id=$j
            AND m.cur_id=$c
            AND m.mat_paralelo='$p'
            ORDER BY e.est_apellidos
            ");
        
         return view('asistencias.edit')
         ->with('asistencias', $asistencias)
         ->with('dat', $dat)
         ;
    }

    /**
     * Update the specified Asistencia in storage.
     *
     * @param  int              $id
     * @param UpdateAsistenciaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAsistenciaRequest $request)
    {
        $asistencia = $this->asistenciaRepository->findWithoutFail($id);

        if (empty($asistencia)) {
            Flash::error('Asistencia not found');

            return redirect(route('asistencias.index'));
        }
        $asistencia = $this->asistenciaRepository->update($request->all(), $id);
                 $aud= new Auditoria();
                 $data=["mod"=>"Asistencia","acc"=>"Update","dat"=>$asistencia,"doc"=>"NA"];
                 $aud->save_adt($data);        

        Flash::success('Asistencia updated successfully.');
        return redirect(route('asistencias.index'));
    }

    /**
     * Remove the specified Asistencia from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $asistencia = $this->asistenciaRepository->findWithoutFail($id);

        if (empty($asistencia)) {
            Flash::error('Asistencia not found');

            return redirect(route('asistencias.index'));
        }

        $this->asistenciaRepository->delete($id);
                 $aud= new Auditoria();
                 $data=["mod"=>"Asistencia","acc"=>"Eliminar","dat"=>$asistencia,"doc"=>"NA"];
                 $aud->save_adt($data);        

        Flash::success('Asistencia deleted successfully.');

        return redirect(route('asistencias.index'));
    }


    public function search(Request $req){

         if($req->ajax()){
             $dt=$req->all();
             switch ($dt['op']) {
                 case 1:
                        return response()->json($this->cursos_asignados($req));
                     break;
                 case 2:
                        return response()->json($this->materias_asignadas($req));
                     break;

                     default:
                        return response()->json("Error");
                     break;
             }

                
             
         }


    }

    public function cursos_asignados(Request $req){

            $dt=$req->all();
            $prm=$this->permisos(27);

            $usu_id=$prm->usu_id;

                if($prm->especial==1){ //SI EL USUARIO TIENE PERMISO TOTAL aparece todos los cursos asignados
                    $cursos=DB::select("select ap.cur_id,c.cur_descripcion,ap.paralelo from asg_horario_profesores ap
                        join cursos c on ap.cur_id=c.id
                        and ap.jor_id=1
                        and ap.mtr_id<>3
                        group by ap.cur_id,c.cur_descripcion,ap.paralelo
                        order by ap.cur_id,ap.paralelo ");
                }else{ //SOLO CURSOS asignados
                    $cursos=DB::select("select ap.cur_id,c.cur_descripcion,ap.paralelo from asg_horario_profesores ap
                        join cursos c on ap.cur_id=c.id
                        and ap.jor_id=1
                        and ap.usu_id=$usu_id
                        and ap.mtr_id<>3
                        group by ap.cur_id,c.cur_descripcion,ap.paralelo
                        order by ap.cur_id,ap.paralelo ");
                }
                $resp="";                
                foreach ($cursos as $c) {
                    $resp.="<option value='$c->cur_id-$c->paralelo'>$c->cur_descripcion $c->paralelo</option>";
                }
             return $resp;
    }

    public function materias_asignadas(Request $req){
        $usu = Auth::user();
        $dat=$req->all();
        $curso=explode("-",$dat['cur']);

        $materias=DB::select("select ap.mtr_id, m.mtr_descripcion from asg_horario_profesores ap
                                    join materias m on ap.mtr_id=m.id
                                    and ap.jor_id=1
                                    and ap.usu_id=$usu->id
                                    and ap.cur_id=$curso[0]
                                    and ap.paralelo='$curso[1]'
                                    and ap.mtr_id<>3
                                    group by ap.mtr_id,m.mtr_descripcion ");
        $resp="";                        
        foreach ($materias as $m) {
             $resp.="<option value='$m->mtr_id'>$m->mtr_descripcion</option>"; 
        }

        return $resp;

    }

    public function jor_asignadas($usu){

         $jor = Jornadas::orderBy('id', 'ASC')->where('id', 0)->pluck('jor_descripcion', 'id');
         if ($usu->especial==1) {
                $jor = Jornadas::orderBy('id', 'ASC')->pluck('jor_descripcion', 'id');
            }else{
                 if ($usu->jor1==1) {
                        $jor->put('1','MATUTINA'); 
                    }
                 if ($usu->jor2==1) {
                        $jor->put('2','NOCTURNA'); 
                    }
                 if ($usu->jor3==1) {
                        $jor->put('3','SEMI-PRESENCIAL'); 
                    }
                 if ($usu->jor4==1) {
                        $jor->put('4','VESPERTINA'); 
                    }

            }
            $jor->put('0','Seleccione'); 
            return $jor;
    }


    public function buscar(Request $req){
        $dat=$req->all();
        $estado=1;
        if($dat['esp_id']==7 || $dat['esp_id']==8){//Si es BGU o BXS

            if($dat['esp_id']==7){
                $dat['anl_id']=$dat['per_id']; //El año lectivo pasa a ser el periodo BGU
            }

            $est=DB::select("select m.id as mat_id,e.est_nombres,e.est_apellidos from estudiantes e join matriculas m on e.id=m.est_id
                where m.anl_id=$dat[anl_id]
                and m.jor_id=$dat[jor_id]
                and m.cur_id=$dat[cur_id]
                and m.mat_paralelo='$dat[par_id]'
                and m.esp_id=$dat[esp_id]
                and m.mat_estado=$estado
                order by e.est_apellidos");

        }else if($dat['esp_id']==10){

            $est=DB::select("select m.id as mat_id,e.est_nombres,e.est_apellidos from estudiantes e join matriculas m on e.id=m.est_id
                where m.anl_id=$dat[anl_id]
                and m.jor_id=$dat[jor_id]
                and m.cur_id=$dat[cur_id]
                and m.mat_paralelo='$dat[par_id]'
                and m.esp_id<>7
                and m.esp_id<>8
                and m.mat_estado=$estado
                order by e.est_apellidos");

        }else{

            $est=DB::select("select m.id as mat_id,e.est_nombres,e.est_apellidos from estudiantes e join matriculas m on e.id=m.est_id
                where m.anl_id=$dat[anl_id]
                and m.jor_id=$dat[jor_id]
                and m.cur_id=$dat[cur_id]
                and m.esp_id=$dat[esp_id]
                and m.mat_paralelot='$dat[par_id]'
                and m.mat_estado=$estado
                order by e.est_apellidos");

        }

        $periodo=AnioLectivo::where('periodo',1)->pluck('anl_descripcion','id');
        $jornada=Jornadas::orderBy('jor_descripcion','ASC')->pluck('jor_descripcion','id');
        $especialidad=Especialidades::orderBy('esp_descripcion','ASC')->pluck('esp_descripcion','id');
        $especialidad->put('0','TODAS');
        $curso=Cursos::pluck('cur_descripcion','id');
        $materias=Materias::where('mtr_tipo',0)
        ->orderBy('mtr_descripcion','ASC')
        ->pluck('mtr_descripcion','id');
        return view('asistencias.create')
        ->with('jor',$jornada)
        ->with('cur',$curso)
        ->with('mtr',$materias)
        ->with('esp',$especialidad)
        ->with('anl',Session::get('anl_id'))
        ->with('per',$periodo)
        ->with('est',$est)
        ;
    }

    public function justifica_asistencia(Request $req){
      
        $dt=$req->all();
        if($dt['data'][2]==0){
              $est=$dt['data'][1];
              $id=$dt['data'][0];

              if( $asistencia=DB::select("UPDATE asistencia SET estado=$est WHERE id=$id RETURNING mat_id  ") ){
                $cd=$this->codigo_sms();
                  $inp['mat_id']=$asistencia[0]->mat_id;
                  $inp['mtr_id']=0;
                  $inp['fecha']=null;
                  $inp['hora']=null;
                  $inp['estado']=$est;  // 'estado',0->Asistencia,1->Falta,2->Atraso
                  $inp['observaciones']=null;
                  $inp['usu_id']=Auth::user()->id;
                  $inp['sms_estado']=0;
                  $inp['sms_obs']=null;

               $this->inserta_para_envio($inp,0,$cd);//Mensaje de texto   
               $this->inserta_para_envio($inp,1,$cd);//Mensaje de texto   

              }

              return 0;

        }else{
              $p_just=$dt['data'][0];
              $mot_just=$dt['data'][1];
              $ast_id=$dt['data'][2];
              $asistencia=DB::select("select * from asistencia where id=".$ast_id);
            if($asistencia[0]->estado==1){//Falta
                $est=3;//Falta Justificada
            }else if($asistencia[0]->estado==2){//Atraso
                $est=4;//Atraso Justificado
              }

              $usu=Auth::user()->usu_apellidos.' '.Auth::user()->name;
              DB::select("UPDATE asistencia 
                SET usu_justifica='$usu',
                persona_justifica='$p_just',
                motivo_justifica='$mot_just',
                estado=3
                WHERE id=$ast_id
                ");
              return 0;
      }

    }
    public function reporte_asistencias(){
        $jor=Jornadas::orderBy('id','ASC')->pluck("jor_descripcion","id");
        $esp=Especialidades::pluck("esp_descripcion","id");
        $mtrc=[];
        $mtrt=[];

      return view('asistencias.reporte')
        ->with('jor',$jor)
        ->with('esp',$esp)
        ->with('materiac',$mtrc)
        ->with('materiat',$mtrt);

    }
    public function busca_asistencias(Request $req){
        $dt=$req->all();
        $cur=Cursos::all();
        $resp="";
        $jor=$dt['jor'];
        $f=$dt['fecha'];
        $mtr=3;//Revisar luego materia
        if($dt['esp']==10){//Cultural General
            $esp=0;
        }else{
            $esp=$dt['esp'];
        }
            foreach ($cur as $c){
                $resp.="<tr>";
                $resp.="<td>$c->cur_descripcion</td>";
                    $paralelo = "A";
                    for ($i =0; $i < 7; $i++){

                      $ast=$this->asistencias_curso($jor,$esp,$c->id,$paralelo,$f,$mtr);

                      $cl="";
                      $tx_ast=$ast[0].'/'.$ast[1];

                      if($ast[0]==$ast[1] && $ast[0]>0 ){
                        $cl="fa-check text-success";
                      }elseif($ast[0]>0 && $ast[1]==0){
                        $cl="fa-exclamation-triangle text-red";
                      }elseif($ast[0]>0 && $ast[1]>0){
                        $cl="fa-exclamation-triangle text-warning bg-warning";
                      }else{
                        $cl='';
                        $tx_ast='-'; 
                      }
                      $resp.="<td class='text-center '><i class='fa $cl  tx_asistencias' ne='$ast[0]' na='$ast[1]' fl='$ast[2]' at='$ast[3]'   >$tx_ast<i/></td>";
                      $paralelo++;
                    }                
                $resp.="</tr>";
            }            
        $resp.="";

        return response()->json($resp);
    }

    public function asistencias_curso($jor,$esp,$cur,$paralelo,$f,$mtr){
        $AUD=new Auditoria();
        $d[0]=$this->anl;
        if($esp==7){
            $d[0]=$this->anl_bgu;
        }
        $d[1]=$jor;
        $d[2]=$esp;
        $d[3]=$cur;
        $d[4]=$paralelo;
        $d[5]=1;
        $est=$AUD->buscador_estudiantes($d);
        $ne=count($est);//NUmero de estudiantes
        $na=0;//NUmero de asistentes
        $nf=0;//Numero de novedades
        $nat=0;//Numero de novedades
        foreach ($est as $e) {

              $ast=DB::select("SELECT * FROM asistencia WHERE mat_id=$e->mat_id AND mtr_id=$mtr AND fecha='$f' ");
              if(!empty($ast)){
                if($ast[0]->estado==0){
                  $na++;
                }elseif($ast[0]->estado==1){
                  $nf++;
                }elseif($ast[0]->estado==2){
                   $nat++;
                }

              }
        }
        return [$ne,$na,$nf,$nat];
    }


    public function busca_asistencias_reporte(Request $req){
      $dt=$req->all();
      return view('asistencias.reporte_asistencias_imprimible')
      ->with('dt',$dt)

      ;
    }

    public function busca_asistencias_novedades(Request $req){
      $dt=$req->all();
        $tx_esp="";
      if($dt['especialidad']==7){
        $tx_esp="AND m.esp_id=7";
      }

      $materia=$dt['materia'];
      if($dt['especialidad']==10){
        $materia=3;
      }
     
      $as=DB::select("SELECT * FROM asistencia a 
        JOIN matriculas m ON a.mat_id=m.id 
        JOIN estudiantes e on m.est_id=e.id
        JOIN cursos c on m.cur_id=c.id
        JOIN jornadas j on m.jor_id=j.id
        WHERE a.estado=$dt[tipo] 
        AND m.jor_id=$dt[jornada] 
        AND a.mtr_id=$materia
        AND a.fecha='$dt[fch]'
        $tx_esp

        ORDER BY m.cur_id, m.mat_paralelo,e.est_apellidos

       ");

      if($dt['tipo']==1){
        $nv="ESTUDIANTES FALTANTES ";
      }elseif($dt['tipo']==2){
        $nv="ESTUDIANTES ATRASADOS";

      }

      return view('asistencias.detalle_novedades')
      ->with('as',$as)
      ->with('f',$dt['fch'])
      ->with('nv',$nv)
      ;
    }

    public function reporte_general_asistencias(Request $req){
      $dt=$req->all();
      $est=[];
      $f_head=[];
      if(!empty($dt)){

      $anl=$this->anl; 
        $j=$dt['jor_id'];
        $e=$dt['esp_id'];
        $c=$dt['cur_id'];
        $p=$dt['paralelo'];

        $tx_esp='and m.esp_id<>7 and m.esp_id<>8';
        $tx_paralelo="and m.mat_paralelo=''$p'' ";
        if($e!=10){
          $tx_esp="and m.esp_id=$e";
          $tx_paralelo="and m.mat_paralelot=''$p'' ";
        }

        if($e==7 || $e==8){
         $tx_paralelo="and m.mat_paralelo=''$p'' "; 
        }

        if($e==7){
          $anl=$this->anl_bgu;
        }

         $f_head=DB::select("SELECT generate_series('$dt[desde]'::timestamp,'$dt[hasta]'::timestamp, '1 day') as f ");
         $tx_head='';
         $x=1;
         foreach ($f_head as $fh) {
           $tx_head.='f'.$x.' text,';
         $x++;
         }

        $tx_head=(substr($tx_head,0,strlen($tx_head)-1));
$sql="SELECT * FROM crosstab(' select e.est_apellidos ||'' ''|| e.est_nombres,cast(s.fecha as timestamp),s.estado
        from asistencia s
        right join matriculas m on s.mat_id=m.id
        join estudiantes e on e.id=m.est_id
        where m.anl_id=$anl 
        and m.jor_id=$j
        and m.cur_id=$c
        $tx_esp
        $tx_paralelo
        and m.mat_estado=1
        order by e.est_apellidos
            '::text,'SELECT generate_series(''$dt[desde]''::timestamp,''$dt[hasta]''::timestamp, ''1 day'') '::text) crosstab(estudiante text, $tx_head );
          ";
//          dd($sql);

        $est=DB::select($sql);
      }
        $jornada=Jornadas::orderBy('id','ASC')->pluck('jor_descripcion','id');
        $especialidad=Especialidades::orderBy('id','DESC')->pluck('esp_descripcion','id');
        $curso=Cursos::pluck('cur_descripcion','id');

        if(isset($dt['btn_reporte_excel'])=='btn_reporte_excel'){


                Excel::create('Reporte_Asisistencias', function($excel) use($est,$f_head,$dt) {
                   $excel->sheet('Reporte', function($sheet) use($est,$f_head,$dt) {

                    $jr=DB::select("select * from jornadas where id=$dt[jor_id]");
                    $ep=DB::select("select * from especialidades where id=$dt[esp_id]");
                    $cur=DB::select("select * from cursos where id=$dt[cur_id]");

                    $datos=$jr[0]->jor_descripcion.' '.$ep[0]->esp_descripcion.' '.$cur[0]->cur_descripcion.' '.$dt['paralelo'];

                         $sheet->loadView('asistencias.reporte_general_asistencias_excel')
                         ->with('est',$est)
                         ->with('f_head',$f_head)
                         ->with('dt',$dt)
                         ->with('datos',$datos)

                         ;

                    });
                })->export('xls');

                      return view('asistencias.reporte_general_asistencias_excel')
                      ->with('jor',$jornada)
                      ->with('cur',$curso)
                      ->with('est',$est)
                      ->with('esp',$especialidad)
                      ->with('f_head',$f_head);                      


        }else{

          return view('asistencias.reporte_general_asistencias')
          ->with('jor',$jornada)
          ->with('cur',$curso)
          ->with('est',$est)
          ->with('esp',$especialidad)
          ->with('f_head',$f_head);
        }
   }
}
