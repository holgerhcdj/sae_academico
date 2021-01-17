<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSmsMailRequest;
use App\Http\Requests\UpdateSmsMailRequest;
use App\Repositories\SmsMailRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Auth;
use Response;
use App\Models\SmsMail;
use DB;
use Storage;
use Illuminate\Support\Facades\Mail;
use App\Models\AnioLectivo;
use App\Models\Jornadas;
use App\Models\Cursos;
use App\Models\Especialidades;
use App\Models\Materias;
use App\Models\Auditoria;
use App\Models\Matriculas;
use Session;

class SmsMailController extends AppBaseController
{
    /** @var  SmsMailRepository */
    private $smsMailRepository;
    private $mod_id=49;
    public function __construct(SmsMailRepository $smsMailRepo)
    {
        date_default_timezone_set('America/Guayaquil');         
        $this->smsMailRepository = $smsMailRepo;
    }

    /**
     * Display a listing of the SmsMail.
     *
     * @param Request $request
     * @return Response
     */
    public function revisa_permisos($mod){

      $prm=Auth::user()->AsignaPermisos;
      return $mod=$prm->where('mod_id',$mod)->first();
      
    }
    public function index(Request $request)
    {

      $dt=$request->all();
      $us=Auth::user();
      $usu_id=$us->id;
      $d=date('Y-m-d');
      $h=date('Y-m-d');
      $esp=$this->revisa_permisos($this->mod_id)->especial;
      $tx_us=" and s.usu_id=$usu_id";
      if($esp==1){ //Si tiene permisos especial puede ver de todos los usuarios
        $tx_us=" ";
      }
      if(isset($dt['btn_buscar'])){
        $d=$dt['desde'];
        $h=$dt['hasta'];
      }

                 $smsMails = DB::select("select   
                j.jor_descripcion,
                c.cur_descripcion,
                m.mat_paralelo,
                u.name,
                u.usu_apellidos,
                s.usu_id, 
                s.sms_fecha,
                s.sms_grupo
                from sms_mail s 
                join matriculas m on m.id=s.mat_id
                join jornadas j on j.id=m.jor_id
                join cursos c on c.id=m.cur_id
                join users u on u.id=s.usu_id
                WHERE s.sms_fecha between '$d' and '$h'
                $tx_us
                group by
                j.jor_descripcion,
                c.cur_descripcion,
                m.mat_paralelo,
                u.name,
                u.usu_apellidos,
                s.usu_id, 
                s.sms_fecha,
                s.sms_grupo
                order by s.sms_grupo desc
                ");

        return view('sms_mails.index')
            ->with('smsMails', $smsMails);

    }


    public function create()
    {
///**************ESTUDIANTE********************////////////////
        $aud= new Auditoria();
        $est=$aud->estudiantes();
//////////**************************************///////////////
        $periodo=AnioLectivo::where('periodo',1)->pluck('anl_descripcion','id');
        $jornada=Jornadas::orderBy('jor_descripcion','ASC')->pluck('jor_descripcion','id');
        $especialidad=Especialidades::orderBy('esp_descripcion','ASC')->pluck('esp_descripcion','id');
        $especialidad->put('0','TODAS');
        $curso=Cursos::pluck('cur_descripcion','id');
        $curso->put('0','TODOS');
        $materias=Materias::where('mtr_tipo',0)
        ->where('id','<>',3)
        ->orderBy('mtr_descripcion','ASC')
        ->pluck('mtr_descripcion','id');

        $materias->put('10','CULTURAL/GENERAL');


        return view('sms_mails.create')
        ->with('jor',$jornada)
        ->with('cur',$curso)
        ->with('mtr',$materias)
        ->with('esp',$especialidad)
        ->with('anl',Session::get('anl_id'))
        ->with('per',$periodo)
        ->with('est',$est);

    }

    /**
     * Store a newly created SmsMail in storage.
     *
     * @param CreateSmsMailRequest $request
     *
     * @return Response
     */
    public function store(CreateSmsMailRequest $request)
    {
        $cd=$this->codigo_sms();
        $dt = $request->all();
        if($dt['opcion']==1){//corre
          $dt['sms_mensaje']=$dt['sms_mensaje2'];
        }
//        dd($dt);
        if($dt['contador']>0){
            $x=0;
            while($x<$dt['contador']){
                $x++;
             if(isset($dt['tp'.$x])){
                if($dt['tp'.$x]==0){ //Si el envio es individual
                      $inp[0]=$dt['est'.$x];
                      $inp[1]=null;
                      $inp[2]=null;
                      $inp[3]=null;
                      $inp[4]=null;
                      $inp[5]=null;
                      $inp[6]=null;
                      $inp[7]=$dt['sms_mensaje'];
                      if($dt['opcion']==2){//Si es mensaje y Correo
                          $this->inserta_mensaje($inp,0,$cd);
                          $this->inserta_mensaje($inp,1,$cd);
                      }else{
                          $this->inserta_mensaje($inp,$dt['opcion'],$cd);
                      }
                }elseif($dt['tp'.$x]==1){ //Si es grupal
                    $parametros=[
                        $dt['anl'.$x],
                        $dt['jr'.$x],
                        $dt['es'.$x],
                        $dt['cu'.$x],
                        $dt['pr'.$x],
                        1
                    ];

                    $aud=new Auditoria();
                    $est=$aud->buscador_estudiantes($parametros);//Busco los estudiantes
                    foreach ($est as $e) {
                              $inp[0]=$e->mat_id;
                              $inp[1]=null;
                              $inp[2]=null;
                              $inp[3]=null;
                              $inp[4]=null;
                              $inp[5]=null;
                              $inp[6]=null;
                              $inp[7]=$dt['sms_mensaje'];
                              if($dt['opcion']==2){//Si es mensaje y Correo
                                  $this->inserta_mensaje($inp,0,$cd);
                                  $this->inserta_mensaje($inp,1,$cd);
                              }else{
                                  $this->inserta_mensaje($inp,$dt['opcion'],$cd);
                              }
                    }
                }
            }

        }
    }
        return redirect(route('smsMails.index'));
    }


    public function inserta_mensaje($dt,$tp,$cod){ //$tp->si es para 0->mensaje o 1->mail

        $e=DB::select("SELECT * FROM matriculas m JOIN estudiantes e ON m.est_id=e.id WHERE m.id=$dt[0] ");

        if($tp==0){
            $destino=$e[0]->rep_telefono;
        }else{
            $destino=$e[0]->rep_mail;
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

                    $inp['usu_id']=Auth::user()->id;
                    $inp['mat_id']=$dt[0];
                    $inp['sms_mensaje']=$dt[7];
                    $inp['sms_modulo']='COMUNICADO';
                    $inp['sms_tipo']=$tp;
                    $inp['destinatario']=$destino;
                    $inp['estado']=$estado;
                    $inp['respuesta']=$respuesta;
                    $inp['persona']=$e[0]->rep_nombres;
                    $inp['sms_fecha']=date('Y-m-d');
                    $inp['sms_hora']=date('H:s');
                    $inp['sms_grupo']=$cod;

        //dd($inp['sms_mensaje']);
        $smsMail = $this->smsMailRepository->create($inp);                    

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



    public function show($id)
    {
        $smsMail = DB::select("select *
         from sms_mail s 
         join matriculas m on m.id=s.mat_id
         join estudiantes e on e.id=m.est_id
         join jornadas j on j.id=m.jor_id
         join cursos c on c.id=m.cur_id
         join users u on u.id=s.usu_id
         where s.sms_grupo='$id' order by e.est_apellidos   ");
        return view('sms_mails.show')
        ->with('smsMail', $smsMail)
        ->with('cod', $id)
        ->with('count',count($smsMail))
        ;
        
    }

    /**
     * Show the form for editing the specified SmsMail.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $smsMail = $this->smsMailRepository->findWithoutFail($id);

        if (empty($smsMail)) {
            Flash::error('Sms Mail not found');

            return redirect(route('smsMails.index'));
        }

        return view('sms_mails.edit')->with('smsMail', $smsMail);
    }

    /**
     * Update the specified SmsMail in storage.
     *
     * @param  int              $id
     * @param UpdateSmsMailRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSmsMailRequest $request)
    {
        $smsMail = $this->smsMailRepository->findWithoutFail($id);

        if (empty($smsMail)) {
            Flash::error('Sms Mail not found');

            return redirect(route('smsMails.index'));
        }

        $smsMail = $this->smsMailRepository->update($request->all(), $id);

        Flash::success('Sms Mail updated successfully.');

        return redirect(route('smsMails.index'));
    }

    public function destroy($id)
    {
        $smsMail = $this->smsMailRepository->findWithoutFail($id);

        if (empty($smsMail)) {
            Flash::error('Sms Mail not found');
            return redirect(route('smsMails.index'));
        }
        $this->smsMailRepository->delete($id);
        Flash::success('Sms Mail deleted successfully.');
        return redirect(route('smsMails.index'));
    }


    public function buscar_estudiantes(Request $req){

        $dat=$req->all();
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
                order by e.est_apellidos");

        }else if($dat['esp_id']==0){

            $est=DB::select("select m.id as mat_id,e.est_nombres,e.est_apellidos from estudiantes e join matriculas m on e.id=m.est_id
                where m.anl_id=$dat[anl_id]
                and m.jor_id=$dat[jor_id]
                and m.cur_id=$dat[cur_id]
                and m.mat_paralelo='$dat[par_id]'
                and m.esp_id<>7
                and m.esp_id<>8
                order by e.est_apellidos");

        }else{

            $est=DB::select("select m.id as mat_id,e.est_nombres,e.est_apellidos from estudiantes e join matriculas m on e.id=m.est_id
                where m.anl_id=$dat[anl_id]
                and m.jor_id=$dat[jor_id]
                and m.cur_id=$dat[cur_id]
                and m.esp_id=$dat[esp_id]
                and m.mat_paralelot='$dat[par_id]'
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


    public function envia_mail(Request $req){

    $dm=$req->all();
      Mail::send('sms_mails.envio_mail',$dm,function($message)use($dm){
       $message->subject('Comunicado UETVN ');
       $message->from('hfcaiza@fundacionvidanueva.org.ec','Comunicado FVN');
       $message->to($dm['correo'],$dm['correo']);
     });
      return 0;
    }
    public function actualiza_estado(Request $req){
      $id=$req->all()['sms_id'];
      if(DB::select("UPDATE sms_mail SET estado=1 WHERE sms_id=$id ")){
        return 0;
      }
    }

    public function actualiza_estado_incorrecto($dt){
      $f=date("Y-m-d");
      foreach ($dt as $d){
        if($d->sms_fecha!=$f){
          DB::select("UPDATE sms_mail SET estado=2 WHERE sms_id=$d->sms_id ");
        }

      }
    }

    public function lista_mensaje_no_enviados(Request $req){
      $conf=DB::select("SELECT * FROM erp_configuraciones where con_id=23");
      $sms=[];
       if($conf[0]->con_valor==1){
         $sms=DB::select("SELECT * FROM sms_mail WHERE estado=0");
         $this->actualiza_estado_incorrecto($sms);
       }
       return response()->json($sms);

    }
    public function comunicaciones(Request $req){

        $datos=($req->all());
        $usu_id=Auth::user()->id;
        $jornada=Jornadas::orderBy('jor_descripcion','ASC')->pluck('jor_descripcion','id');
        $especialidad=Especialidades::orderBy('esp_descripcion','ASC')->pluck('esp_descripcion','id');
        $curso=Cursos::pluck('cur_descripcion','id');

        $d=date("Y-m-d");
        $h=date("Y-m-d");
          $sql_search=" and cu.cmu_estado=0 "; ///LOS NO LEIDOS
        if(!isset($datos['op'])==0){
          $d=$datos['desde'];
          $h=$datos['hasta'];
          $sql_search=" and c.com_fecha between '$d' and '$h' ";
          if(!empty($datos['estudiante'])){
            $datos['estudiante']=strtoupper($datos['estudiante']);
            $sql_search=" and e.est_apellidos like '%$datos[estudiante]%' ";
          }

        }

        if($usu_id==96){
          $usu_id=1;
        }

          $com_sent=DB::select("SELECT * from comunicaciones c
              where usu_id=$usu_id
              and not exists (select * from comunicaciones_usuarios cu where cu.com_id=c.com_id and cu.per_tipo=1) 
              order by com_fecha desc,com_hora desc ");

            $com_inbox=DB::select(" SELECT * FROM comunicaciones c 
              JOIN comunicaciones_usuarios cu ON c.com_id=cu.com_id
              JOIN users u ON c.usu_id=u.id
              JOIN matriculas m ON m.id=cu.per_id
              JOIN estudiantes e ON e.id=m.est_id
              where c.usu_id=$usu_id and cu.per_tipo=1 $sql_search
              order by cu.cmu_estado, c.com_fecha desc, c.com_hora desc  ");        

      return view('sms_mails.mail_inbox')
        ->with('jor',$jornada)
        ->with('cur',$curso)
        ->with('esp',$especialidad)
        ->with('com_sent',$com_sent)
        ->with('com_inbox',$com_inbox)
        ->with('d',$d)
        ->with('h',$h)
      ;
    }

    public function cargar_estudiantes(Request $req){
        $dat=$req->all();
        $anl_id=Session::get('anl_id');
        $periodo=Session::get('periodo_id');

        if($dat['esp_id']==7 || $dat['esp_id']==8){//Si es BGU o BXS
            if($dat['esp_id']==7){
                $anl_id=$periodo; //El año lectivo pasa a ser el periodo BGU
            }
            $est=DB::select("select m.id as mat_id,e.est_nombres,e.est_apellidos from estudiantes e join matriculas m on e.id=m.est_id
                where m.anl_id=$anl_id
                and m.jor_id=$dat[jor_id]
                and m.cur_id=$dat[cur_id]
                and m.mat_paralelo='$dat[par_id]'
                and m.esp_id=$dat[esp_id]
                order by e.est_apellidos");

        }else if($dat['esp_id']==10){

            $est=DB::select("select m.id as mat_id,e.est_nombres,e.est_apellidos from estudiantes e join matriculas m on e.id=m.est_id
                where m.anl_id=$anl_id
                and m.jor_id=$dat[jor_id]
                and m.cur_id=$dat[cur_id]
                and m.mat_paralelo='$dat[par_id]'
                and m.esp_id<>7
                and m.esp_id<>8
                order by e.est_apellidos");

        }else{

            $est=DB::select("select m.id as mat_id,e.est_nombres,e.est_apellidos from estudiantes e join matriculas m on e.id=m.est_id
                where m.anl_id=$anl_id
                and m.jor_id=$dat[jor_id]
                and m.cur_id=$dat[cur_id]
                and m.esp_id=$dat[esp_id]
                and m.mat_paralelot='$dat[par_id]'
                order by e.est_apellidos");
        }

        $rsp="";$x=0;
        foreach ($est as $e) {
          $x++;
          $name=$e->est_apellidos.' '.$e->est_nombres;
          $rsp.="<tr>
                    <td>$x</td>
                    <td>$name</td>
                    <td class='text-right'>
                      <input type='checkbox' data='$name' est_id='$e->mat_id' class='chk_est' >
                    </td>
                </tr>";
        }


        return Response()->json($rsp);

    }

public function upload_adjuntos(Request $rq){
        $dt=($rq->all());
        if ($rq->hasfile('archivo')) {
            $img = $rq->file('archivo');
            $file_route =  'prueba.' . $img->getClientOriginalExtension();
            Storage::disk('tareas')->put($file_route, file_get_contents($img->getRealPath()));
        }
}

public function enviar_notificaciones(Request $rq){
        $dt=($rq->all());
        $usu_id=Auth::user()->id;
        $f=date('Y-m-d');
        $h=date('H:s');
        $as=$dt['ast'];
        $ms=$dt['ms'];
        $cur=$dt['cur'];
        $adj='';
        $est=explode(',',$dt['est']);
        $com=DB::select(" INSERT INTO comunicaciones(usu_id,
         com_fecha, 
         com_hora, 
         com_asunto, 
         com_mensaje,
         com_curso, 
         com_adjuntos)
         VALUES ( '$usu_id','$f','$h','$as','$ms','$cur','$adj' ) returning com_id  "); 
        $cm=$com[0]->com_id;

        foreach ($est as $e) {
          DB::select(" INSERT INTO comunicaciones_usuarios(
            per_id,
            com_id)
            VALUES ('$e','$cm' ) ");
        }

        if ($rq->hasfile('archivo')) {
            $img = $rq->file('archivo');
            //$file_route =  $img->getClientOriginalName().'.'.$img->getClientOriginalExtension();
            $file_route =  $cm.'_'.$img->getClientOriginalName();
            Storage::disk('tareas')->put($file_route, file_get_contents($img->getRealPath()));
            DB::select("UPDATE comunicaciones set com_adjuntos='$file_route' where com_id=$cm ");
        }


        return 0;

}

    public function load_datos_comunicado(Request $rq){
      $dt=$rq->all();
      $rst_aux=DB::select("SELECT * FROM comunicaciones c join comunicaciones_usuarios cu on c.com_id=cu.com_id and c.com_id=$dt[com_id]");
      if(count($rst_aux)==1 && $rst_aux[0]->per_tipo==1){
        DB::select("UPDATE comunicaciones_usuarios set cmu_estado=1 where cmu_id=".$rst_aux[0]->cmu_id);
      }

      $rst=DB::select("SELECT * FROM comunicaciones where com_id=".$dt['com_id']);
      $rst_est=DB::select("SELECT * FROM comunicaciones_usuarios where com_id=".$dt['com_id'] );
      $pers="";
      foreach ($rst_est as $r) {
        $est=DB::select("SELECT * FROM matriculas m join estudiantes e on m.est_id=e.id  where m.id=".$r->per_id);
        $pers.= "<div class='bg-default' style='border:solid 1px #ccc; border-radius:5px;padding:1px' >".$est[0]->est_apellidos.' '.$est[0]->est_nombres.'</div>' ;
      }
      $rst['estudiantes']=$pers;
      return Response()->json($rst);
    }

    public function elimina_comunicado(Request $rq){
      $com_id=$rq->all()['com_id'];
      try {
        DB::select("DELETE FROM comunicaciones_usuarios WHERE com_id=$com_id;");
        DB::select("DELETE FROM comunicaciones WHERE com_id=$com_id;");
        return 0;
      } catch(\Illuminate\Database\QueryException $e) {
        return $e;
      }

    }



}
