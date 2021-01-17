<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAulaVirtualRequest;
use App\Http\Requests\UpdateAulaVirtualRequest;
use App\Repositories\AulaVirtualRepository;
use App\Repositories\RegNotasRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DateTime;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\AnioLectivo;
use App\Models\Jornadas;
use App\Models\Cursos;
use App\Models\Especialidades;
use App\Models\Materias;
use App\Models\Auditoria;
use App\Models\Matriculas;
use Session;
use Storage;
use Excel;
use PHPExcel_Style_Border;
use Zipper;

class AulaVirtualController extends AppBaseController
{
    /** @var  AulaVirtualRepository */
    private $aulaVirtualRepository;
    private $regNotasRepository;

    private $jor;
    private $esp;
    private $cur;
    private $anl;
    private $anl_bgu;
    
    public function __construct(AulaVirtualRepository $aulaVirtualRepo,RegNotasRepository $regNotasRepo)
    {
        date_default_timezone_set('America/Guayaquil');
        $this->aulaVirtualRepository = $aulaVirtualRepo;
        $this->regNotasRepository = $regNotasRepo;

        $this->jor=Jornadas::orderBy('jor_descripcion','ASC')->pluck('jor_descripcion','id');
        $this->esp=Especialidades::orderBy('esp_descripcion','ASC')->pluck('esp_descripcion','id');
        $this->cur=Cursos::pluck('cur_descripcion','id');
        $this->anl = Session::get('anl_id');
        $this->anl_bgu = Session::get('periodo_id');


    }

    /**
     * Display a listing of the AulaVirtual.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

      $jornada=Jornadas::orderBy('jor_descripcion','ASC')->pluck('jor_descripcion','id');
      $especialidad=Especialidades::orderBy('esp_descripcion','ASC')->pluck('esp_descripcion','id');
      $curso=Cursos::pluck('cur_descripcion','id');
      $mtr=Materias::where('esp_id',10)->where('id','<>',3)->orderBy("mtr_descripcion")->pluck('mtr_descripcion','id');
      $tareas=[];

        return view('aula_virtuals.index')
        ->with('jor',$jornada)
        ->with('cur',$curso)
        ->with('esp',$especialidad)      
        ->with('tareas',$tareas)
        ->with('mtr',$mtr);
        //->with('aulaVirtuals', $aulaVirtuals);
    }

    /**
     * Show the form for creating a new AulaVirtual.
     *
     * @return Response
     */
    public function create()
    {
        return view('aula_virtuals.create');
    }

    /**
     * Store a newly created AulaVirtual in storage.
     *
     * @param CreateAulaVirtualRequest $request
     *
     * @return Response
     */
    public function store(CreateAulaVirtualRequest $req)
    {
        $input = $req->all();
        /////si viene desde las el registro de notas 
        if(isset($input['op'])){
            if($input['op']==0){
                $codigo_nuevo=json_decode(json_encode($this->load_codigo_tarea($req)));
                $input['tar_codigo']=$codigo_nuevo->original;
                $input['tar_minini']='00';
                $input['tar_minfin']='00';
            }
        }

        $id=$input['tar_id'];
        if($id!=0){
            $tareas = $this->aulaVirtualRepository->findWithoutFail($id);
            $aux=explode("-",$tareas->tar_aux_cursos);
            $input['jor_id']=$aux[0];
            $input['esp_id']=$aux[1];
            $input['cur_id']=$aux[2];
            $input['paralelo']=$aux[3];
        }

        $jr=DB::select("SELECT * FROM jornadas where id=".$input['jor_id']);
        $ep=DB::select("SELECT * FROM especialidades where id=".$input['esp_id']);
        $cr=DB::select("SELECT * FROM cursos where id=".$input['cur_id']);
        $cursos=$jr[0]->jor_obs.'-'.$ep[0]->esp_obs.'-'.$cr[0]->cur_obs.$input['paralelo'];
        $curso_aux=$input['jor_id'].'-'.$input['esp_id'].'-'.$input['cur_id'].'-'.$input['paralelo'];

        $usu_id=Auth::user()->id;
        $datos['usu_id']=$usu_id;
        $datos['tar_tipo']=$input['tar_tipo'];
        $datos['tar_titulo']=$input['tar_titulo'];
        $datos['tar_descripcion']=$input['tar_descripcion'];
        $datos['tar_link']=$input['tar_link'];
        $datos['tar_finicio']=$input['tar_finicio'];
        $datos['tar_hinicio']=$input['tar_hinicio'].':'.$input['tar_minini'];
        $datos['tar_ffin']=$input['tar_ffin'];
        $datos['tar_hfin']=$input['tar_hfin'].':'.$input['tar_minfin'];
        $datos['tar_estado']=$input['tar_estado'];
        $datos['tar_cursos']=$cursos;
        $datos['tar_aux_cursos']=$curso_aux;
        $datos['tar_codigo']=$input['tar_codigo'];
        $datos['esp_id']=$input['esp_id'];
        $datos['mtr_id']=$input['mtr_id'];
        $datos['tar_mostrar']=$input['tar_mostrar'];

//dd($datos);

            $anl=Session::get('anl_id');
            $esp=$input['esp_id'];
            if($esp==7){
                $anl=Session::get('periodo_id');
            }

            $jor=$input['jor_id'];
            $cur=$input['cur_id'];
            $par=$input['paralelo'];
            $estado=1;
            $parametros=[$anl,$jor,$esp,$cur,$par,$estado];
            $aud= new Auditoria();
            $est=$aud->buscador_estudiantes($parametros);//Busco los estudiantes


        if($id==0){

            if(!empty($est)){

                try {
                    $tareas = $this->aulaVirtualRepository->create($datos);
                    foreach ($est as $e) {
                        DB::select("INSERT INTO tareas_usuarios( tar_id,mat_id ) VALUES ($tareas->tar_id,$e->mat_id) ; ");
                    }

                } catch(\Illuminate\Database\QueryException $e) {
                    dd("Insertar".$e);
                }
                if ($req->hasfile('tar_adjuntos')) {
                    $img = $req->file('tar_adjuntos');
                //$file_route =  $tareas->tar_id.'_'.$img->getClientOriginalName();
                    $file_route =  $tareas->tar_codigo.'.'.$img->getClientOriginalExtension();
                    Storage::disk('aulaVirtual')->put($file_route, file_get_contents($img->getRealPath()));
                    $dtnew['tar_adjuntos']=$file_route;
                    $tareas = $this->aulaVirtualRepository->update($dtnew,$tareas->tar_id);
                }

            }else{

                echo "<h1>No existen estudiantes en este paralelo</h1>";
                dd();

            }

        }else{

            if(!empty($est)){
                    $file_route=$tareas->tar_adjuntos;
                    if ($req->hasfile('tar_adjuntos')) {
                        $img = $req->file('tar_adjuntos');
                        $file_route =  $tareas->tar_codigo.'.'.$img->getClientOriginalExtension();
                        Storage::disk('aulaVirtual')->put($file_route, file_get_contents($img->getRealPath()));
                    }

                    try {
                        $datos['tar_adjuntos']=$file_route;
                        $tareas = $this->aulaVirtualRepository->update($datos,$tareas->tar_id);
                        //****MODIFICAR TAREAS DE LOS ESTUDIANTES
                        foreach ($est as $e) {
                            $tr_env=DB::select("SELECT * FROM tareas_usuarios WHERE tar_id=$tareas->tar_id AND mat_id=".$e->mat_id);
                            if( empty($tr_env) ){
                                DB::select("INSERT INTO tareas_usuarios ( tar_id,mat_id ) VALUES ($tareas->tar_id,$e->mat_id) ; ");
                            }
                        }
                        //***************************************                        
                    } catch(\Illuminate\Database\QueryException $e) {
                        dd("Modificar:".$e);
                    }
            }else{

                echo "<h1>No existen estudiantes en este paralelo</h1>";
                dd();

            }

            
        }


        if(isset($input['op'])){
            if($input['op']==0){
                return Response()->json($tareas);
            }
        }else{

        Flash::success('Proceso Correcto.');
        return redirect(route('aulaVirtuals.index'));
    }
        // $input = $request->all();
        // $aulaVirtual = $this->aulaVirtualRepository->create($input);
        // Flash::success('Aula Virtual saved successfully.');


    }

    /**
     * Display the specified AulaVirtual.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $aulaVirtual = $this->aulaVirtualRepository->findWithoutFail($id);

        if (empty($aulaVirtual)) {
            Flash::error('Aula Virtual not found');

            return redirect(route('aulaVirtuals.index'));
        }

        return view('aula_virtuals.show')->with('aulaVirtual', $aulaVirtual);
    }

    /**
     * Show the form for editing the specified AulaVirtual.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $aulaVirtual = $this->aulaVirtualRepository->findWithoutFail($id);

        if (empty($aulaVirtual)) {
            Flash::error('Aula Virtual not found');

            return redirect(route('aulaVirtuals.index'));
        }

        return view('aula_virtuals.edit')->with('aulaVirtual', $aulaVirtual);
    }

    /**
     * Update the specified AulaVirtual in storage.
     *
     * @param  int              $id
     * @param UpdateAulaVirtualRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAulaVirtualRequest $request)
    {
        $aulaVirtual = $this->aulaVirtualRepository->findWithoutFail($id);

        if (empty($aulaVirtual)) {
            Flash::error('Aula Virtual not found');

            return redirect(route('aulaVirtuals.index'));
        }

        $aulaVirtual = $this->aulaVirtualRepository->update($request->all(), $id);

        Flash::success('Aula Virtual updated successfully.');

        return redirect(route('aulaVirtuals.index'));
    }

    /**
     * Remove the specified AulaVirtual from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy(Request $rq)
    {

        $dat=$rq->all();
        $id=$dat['aux_tar_id'];
        $aux=DB::select("SELECT tru_estado FROM tareas_usuarios WHERE tar_id=$id GROUP BY tru_estado ");
        $sms="";
//        if(count($aux)==0 || count($aux)==1){ ///SE BLOQUEA SI HAN CARGADO TAREAS 
        if(true){

            $aulaVirtual = $this->aulaVirtualRepository->findWithoutFail($id);
            if (empty($aulaVirtual)) {
                $sms=('Aula Virtual not found');
                return redirect(route('aulaVirtuals.index'));
            }
            try {
                DB::select("DELETE FROM tareas_usuarios where tar_id=$id");
                DB::select("DELETE FROM tareas where tar_id=$id");
                //$this->aulaVirtualRepository->delete($id);
                //Flash::success('Tarea eliminada correctamente');
            } catch(\Illuminate\Database\QueryException $e) {
               $sms=('Error: '.$e);
            }

        }else{
            $sms=('No se puede eliminar ya se cargaron tareas');
        }
        

        if($sms==""){
            return redirect(route('aulaVirtuals.index'));
        }else{
            dd("Error ".substr($sms,0,150));
        }


    }

   public function load_tareas(Request $rq){
        $usu_id=Auth::user()->id;
            // -- and (m.anl_id=$this->anl or m.anl_id=$this->anl_bgu )
        $sql_tar=" SELECT t.*,mt.mtr_descripcion,count(tu.*) as new_tar FROM tareas t 
            join materias mt on t.mtr_id=mt.id  
            left join tareas_usuarios tu on t.tar_id=tu.tar_id and (tu.tru_estado=2 or tu.tru_estado=4)
            left join matriculas m on m.id=tu.mat_id 
            WHERE usu_id=$usu_id  
            group by t.tar_id, 
            t.usu_id, 
            t.tar_tipo, 
            t.tar_titulo, 
            t.tar_descripcion, 
            t.tar_adjuntos, 
            t.tar_link, 
            t.tar_finicio, 
            t.tar_hinicio, 
            t.tar_ffin, 
            t.tar_hfin, 
            t.tar_estado, 
            t.tar_cursos, 
            t.tar_aux_cursos, 
            t.tar_codigo, 
            t.esp_id, 
            t.mtr_id, 
            t.tru_date,
            mt.mtr_descripcion
            order by t.tar_cursos ";
        $tareas=DB::select($sql_tar);
        return response()->json($tareas);
    }

    public function load_una_tarea(Request $rq){
        date_default_timezone_set('America/Guayaquil');
        $tar_id=$rq->all()['tar_id'];
        $tarea=DB::select("SELECT * FROM tareas WHERE tar_id=$tar_id");
        $usu_tar=DB::select("SELECT * FROM tareas_usuarios tu 
            join tareas t on t.tar_id=tu.tar_id
            join matriculas m on tu.mat_id=m.id 
            join estudiantes e on e.id=m.est_id
            where tu.tar_id=$tar_id order By e.est_apellidos  ");

        $resp="<table id='tbl_datos'  >
                    <colgroup span='2' ></colgroup>
                    <colgroup span='2' class='bg-info'></colgroup>
                    <colgroup span='3' class='bg-warning'></colgroup>
                <tr>
                    <th colspan='2'></th>
                    <th colspan='2'class='text-center'>Respuesta</th>
                    <th colspan='2'class='text-center'>Docente</th>
                    <th></th>
                    <th class='text-center' style='display:none'>Tiempo</th>
                </tr>
                <tr>
                    <th class='text-center' >No</th>
                    <th class='text-center'>Estudiantes</th>
                    <th class='text-center' colspan='2' >
                            Del Estudiante
                            <form action='".route('descargar_adjuntos_tareas')."'  method='POST' id='frm_descarga_adjuntos'>
                            ".csrf_field()." 
                            <input type='hidden' id='desc_tar_id' name='desc_tar_id'>
                            <i class='btn  fa fa-download cls_download pull-right btn_desc_adjuntos_tareas' data-toggle='tooltip' data-placement='top' data-original-title='Descargar Todos los Archivos' ></i> 
                            </form>  

                    </th>
                    <th class='text-center'>Nota <i class='btn btn-warning btn-xs fa fa-random btn_transferir_notas' title='Transferir notas'></i> </th>
                    <th class='text-center' colspan='2'>Observación</th>
                    <th class='text-center' style='display:none'>Entrega</th>
                    <th class='text-center'>Estado</th>
                    <th class='text-center'>Fecha Entrega</th>
                </tr>";
        $x=0;
        foreach ($usu_tar as $ut) {
            $x++;
            $cls_est="";
            $est="";
            switch ($ut->tru_estado) {
                case 0: $est="ENVIADO"; $cls_est="text-scondary"; break;
                case 1: $est="LEIDO"; $cls_est="label label-info"; break;
                case 2: $est="RECIBIDO"; $cls_est="label label-warning"; break;
                case 3: $est="ENV-CORREGIR"; $cls_est="label label-danger"; break;
                case 4: $est="REC-CORRECCIÓN"; $cls_est="label label-danger"; break;
                case 5: $est="CALIFICADO"; $cls_est="label label-success"; break;
            }
            $adj="";
            if(strlen($ut->tru_adjunto)>0){
                $adj="<span class='btn btn_link_descarga' style='color:#0061D8' data='$ut->tru_adjunto' >$ut->tru_adjunto</span>";
            }

            $fecha1 = new DateTime($ut->tru_fentrega.' '.$ut->tru_hentrega);
            $fecha2 = new DateTime($ut->tar_ffin.' '.$ut->tar_hfin);
            $resultado = $fecha1->diff($fecha2);

            $dias=$resultado->format('%R%a');
            $hrs=$resultado->format('%R%h');
            $min=$resultado->format('%R%m');

            $cls_tmp="label-info";
            if($dias<=1){
                $cls_tmp="label-warning";
            }
            if($dias<0){
                $cls_tmp="label-danger";
            }

            $slc_estado="<select class='form-control tru_estado' data='$ut->tru_id' truobs='$ut->tru_observacion' truadj='$ut->tru_doc_adjunto'  >
                            <option value=''>Seleccione</option>
                            <option value='3'>ENV-CORREGIR</option>
                            <option value='5'>CALIFICAR</option>
                        </select> ";

            $btnacciones="<i class='btn btn-success fa fa-floppy-o btn-xs btn_calificar' style='display:none'  data='$ut->tru_id'></i>";

            $btnacciones_est="<i class='bg-default text-muted'>...</i>";
            
            if (!empty($ut->tru_adjunto)) {
                $btnacciones_est = "<i class='btn fa fa-paperclip dropdown-toggle text-success' type='button' id='dropdownMenuButton' data-toggle='dropdown' ></i>";
            }

            if($ut->tru_estado==0 || $ut->tru_estado==5){
                // $slc_estado="<select class='form-control tru_estado' data='$ut->tru_id'  >
                //                 <option value=''>No Acciones</option>
                //             </select> ";
                //$btnacciones="<i class='bg-default text-muted'> </i>";
            }

            $ut->tru_respuesta=$this->sanear_string($ut->tru_respuesta);

            $resp.="<tr>
                        <td>$x</td>
                        <td style='font-size:12px'>$ut->est_apellidos $ut->est_nombres</td>
                        <td colspan='2'>
                                <div class='dropdown'>

                                <input type='text' style='background:#eee;border:solid 1px #ccc;height:30px' readonly value='".substr($ut->tru_respuesta,0,20)."' />
                                   $btnacciones_est
                                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton' style='width:250px;padding:10px '>
                                      $ut->tru_respuesta
                                   <br>
                                      $adj
                                </div>
                                </div>
                        </td>
                        <td><input type='text' value='$ut->tru_nota' class='form-control tru_nota' style='width:70px' maxlength='4' disabled=»disabled» /></td>

                        <td>$slc_estado</td>
                        <td>
                              $btnacciones  
                        </td>
                        <td style='display:none' ><span class='label $cls_tmp '>$dias</span></td>
                        <td><span class='$cls_est lbl_estado'>$est</span></td>
                        <td>$ut->tru_fentrega $ut->tru_hentrega</td>
                    </tr>";

        }

        $resp.="</table>";
        array_push($tarea,$resp);
        //$tarea_final=utf8_decode($tarea);
        //$tar_final=utf8_encode($resp);
        return response()->json($tarea);

    }
    public function descargar_archivo($adj){

        $id = public_path() . "/tareas/$adj";

        if (is_file($id)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $content_type = finfo_file($finfo, $id);
            finfo_close($finfo);
            $file_name = basename($id) . PHP_EOL;
            $size = filesize($id);
            header("Content-Type: $content_type");
            header("Content-Disposition: attachment; filename=$file_name");
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: $size");

            ob_clean();
            flush();
            readfile($id);
            exit;

        } else {
            echo $ms="<span style='background:#EB5454;color:white;padding:5px;border-radius:5px; '>Archivo dañado no fue cargado correctamente </span>";
            dd('');
            return false;
        }

    }

    public function calificar_tarea(Request $rq){
        $dt=$rq->all();
        $est=$dt['est'];

//dd($dt);
        $datos1=DB::select("SELECT * FROM tareas_usuarios WHERE tru_id=".$dt['tru']);
        if($est==3){  //ENVIAR CORRECCIÓN

            $adj=$dt['adj'];
            if($adj=='undefined'){
                $adj=$datos1[0]->tru_doc_adjunto;
            }
            if ($rq->hasfile('adj')) {
                $img = $rq->file('adj');
                $file_route =  'RE'.$dt['trc'].'_'.$dt['tru'].'.'.$img->getClientOriginalExtension();
                Storage::disk('aulaVirtual')->put($file_route, file_get_contents($img->getRealPath()));
                $adj=$file_route;
            }

            try {
                DB::select("UPDATE tareas_usuarios set tru_observacion='$dt[obs]',tru_doc_adjunto='$adj', tru_nota=0 ,tru_estado=$est where tru_id=".$dt['tru']);
            } catch(\Illuminate\Database\QueryException $e) {
                return 0;
                //return $e;
            }

        }

        if($est==5){  //CALIFICAR 

//dd($dt['nota']);
            // try {
             $obs=$datos1[0]->tru_observacion.' (Calificado)';
             DB::select("UPDATE tareas_usuarios set tru_nota='$dt[nota]',tru_observacion='$obs',tru_estado=$est where tru_id=".$dt['tru']);
            // } catch(\Illuminate\Database\QueryException $e) {
            //     //return 0;
            //     //return $e;
            // }

        }

        $datos=DB::select("SELECT * FROM tareas_usuarios WHERE tru_id=".$dt['tru']);

        return Response()->json($datos);


    }

    public function descargar_archivo_aula(Request $rq){
        $dt=$rq->all();
        $adj=$dt['txt_tar_adjuntos'];
        $id = public_path() . "/aulaVirtual/$adj";
//        dd($id);
        if (is_file($id)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $content_type = finfo_file($finfo, $id);
            finfo_close($finfo);
            $file_name = basename($id) . PHP_EOL;
            $size = filesize($id);
            header("Content-Type: $content_type");
            header("Content-Disposition: attachment; filename=$file_name");
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: $size");

            ob_clean();
            flush();
            readfile($id);
            exit;
            //return true;
        } else {
            echo $ms="<span style='background:#EB5454;color:white;padding:5px;border-radius:5px; '>Archivo dañado no fue cargado correctamente </span>";
            dd('');
            return false;
        }
        
    }

    public function load_codigo_tarea(Request $rq){
        $us=Auth::user()->id;
        $datos=DB::select("SELECT max(cast( right(tar_codigo,9) as integer )) as tar_codigo FROM tareas where usu_id=$us");
        $tx="00000000";
        if(empty($datos)){
            $cd=1;
        }else{
            $cd=($datos[0]->tar_codigo+1);
            if($cd>0 && $cd<10){
                $tx="00000000";
            }elseif($cd>=100 && $cd<100){
                $tx="0000000";
            }elseif($cd>=1000 && $cd<1000){
                $tx="000000";
            }elseif($cd>=10000 && $cd<10000){
                $tx="00000";
            }elseif($cd>=100000 && $cd<100000){
                $tx="0000";
            }elseif($cd>=1000000 && $cd<1000000){
                $tx="000";
            }elseif($cd>=10000000 && $cd<10000000){
                $tx="00";
            }elseif($cd>=100000000 && $cd<100000000){
                $tx="0";
            }elseif($cd>=1000000000 && $cd<1000000000){
                $tx="";
            }
        }
        return Response()->json($us.'_'.$tx.$cd);
    }

    public function load_modulo_materia(Request $rq){
        $d=$rq->all();
        $anl=Session::get('anl_id');
        $jor=$d['jor'];
        $esp=$d['esp'];
        $cur=$d['cur'];
        $mt=$d['mt'];
        $rst="";

        if($esp==10 || $esp==7 || $esp==8){
            $mtr=DB::select("SELECT * FROM materias WHERE esp_id=10 and id<>3 order By mtr_descripcion");
        }else{
            $mtr=DB::select("
                SELECT m.*,am.bloques FROM asg_materias_cursos am, materias m 
                WHERE am.mtr_id=m.id 
                AND am.anl_id=$anl
                AND am.suc_id=1 
                AND am.jor_id=1
                AND am.esp_id=$esp
                AND am.cur_id=$cur
                and am.estado=0
                ");
        }

        foreach ($mtr as $m) {
            $nbloq="";
            if(isset($m->bloques)){
                $nbloq="->".$m->bloques;
            }

            if($m->id==$mt){
                $rst.="<option selected  value='$m->id'>$m->mtr_descripcion $nbloq</option>";
            }else{
                $rst.="<option  value='$m->id'>$m->mtr_descripcion $nbloq</option>";
            }

        }

        return Response()->json($rst);

    }


public function descargar_tareas_enviadas(Request $rq){

        $dt=$rq->all();

        $tar=DB::select("SELECT * FROM tareas t 
            JOIN users u on t.usu_id=u.id
            JOIN departamentos d on u.usu_perfil=d.id
            JOIN materias m on t.mtr_id=m.id
            JOIN especialidades es on t.esp_id=es.id
            WHERE t.tru_date BETWEEN '$dt[fdesde]' and '$dt[fhasta]'
            ");

        //return view("reportes.tareas_enviadas")->with('tar',$tar);

        Excel::create('Reporte_tareas enviadas', function($excel) use($tar) {
            $excel->sheet('Lista', function($sheet) use($tar) {
                $sheet->loadView("reportes.tareas_enviadas")->with('tar',$tar);
            });
        })->export('xls');

}

public function load_parciales_modulo(Request $rq){
    $dt=$rq->all();
    $rst=DB::select("SELECT * FROM tareas t  
        join materias m on t.mtr_id=m.id 
        join especialidades e on t.esp_id=e.id 
        WHERE t.tar_id=".$dt['trid'] );
       return Response()->json($rst[0]);
     }



public function transferir_notas(Request $rq){

                        $dt=$rq->all();
                        $per=$dt['par'];
                        $ins=$dt['ins'];
                        $f_modific=date('Y-m-d');
                        $disciplina=null;
                        $blq=$dt['blq'];
                        $aux_audt=$dt['audt'];
                        $estado=1;
                        $us=Auth::user()->id;
                        $tar=DB::select("SELECT * FROM tareas t 
                            JOIN tareas_usuarios tu ON t.tar_id=tu.tar_id 
                            JOIN materias mt ON t.mtr_id=mt.id 
                            WHERE  tu.tru_estado=5 AND t.tar_id=".$dt['trid'] );
                        $sms="";
                        $x=0;
                        $y=count($tar);
                        $j=0;
                        foreach ($tar as $t) {

                                $mat_id=$t->mat_id;
                                $mtr_id=$t->mtr_id;
                                $nota=$t->tru_nota;
                                $mtr_tipo=$t->mtr_tipo;
                                $mtr_tec_id=0;

                                if($mtr_tipo==1){
                                    $mtr_id=1;
                                    $mtr_tec_id=$t->mtr_id;
                                }

                                $datos=$mat_id.'&'.$ins.'&'.$nota.'&'.$mtr_id.'&0&'.$per.'&'.$us.'&0&'.$mtr_tec_id.'&'.$disciplina.'&'.$blq;

                                        $rst_nt=DB::select("SELECT * FROM reg_notas 
                                            WHERE mat_id=$mat_id 
                                            AND periodo=$per
                                            AND ins_id=$ins
                                            AND mtr_id=$mtr_id
                                            AND mtr_tec_id=$mtr_tec_id ");

                                        if(empty($rst_nt)){
                                            $this->save_transferir_notas($datos);
                                            $x++;              
                                        }else{
                                            $j++;
                                        }

                        }

                        $sms=$x." de ".$y." transferidos";
                        if($j>0){
                            $sms=$x." de ".$y." transferidos <br>".$j." transferidos anteriormente";
                        }

                        $datos = $aux_audt.' '.$sms;
                        $aud= new Auditoria();
                        $data=["mod"=>"Aula Virtual","acc"=>"Tranf Notas","dat"=>$datos,"doc"=>"NA"];
                        $aud->save_adt($data);        

    return Response()->json($sms);

}



    public function save_transferir_notas($dt) {

        $datos=explode("&",$dt);
        $fecha = date('Y-m-d');
        $data = ['mat_id' => $datos[0],
            'ins_id' => $datos[1],
            'nota' => $datos[2],
            'mtr_id' => $datos[3],
            'periodo' => $datos[5],
            'usu_id' => $datos[6],
            'f_modific' => $fecha,
            'disciplina' => $datos[9],
            'mtr_tec_id' => $datos[8],
        ];
        $n_bloques=$datos[10];

            if($datos[7]==0){//Si no existe ID del registro de notas
////*******************NOTAS DE INSUMOS******************///////////////
                if($n_bloques=='6'){
                    if ($notas=$this->regNotasRepository->create($data)) {
                        return response()->json($notas);
                    }else{
                       return 0;
                   }

               }else if($n_bloques=='1'){


                  $notas=$this->regNotasRepository->create($data);

                   if($data['periodo']!=100){

                           if($data['periodo']==7 && $data['ins_id']==9 ){ ///SI ES EXAMEN FINAL Q1
                                $data['periodo']=8;
                                $data['ins_id']=10;
                                try {
                                    $this->regNotasRepository->create($data);                                    
                                } catch (\Illuminate\Database\QueryException $e) {
                                    $rst_nt=DB::select("SELECT * FROM reg_notas 
                                        WHERE mat_id=$data[mat_id] 
                                        AND periodo=$data[periodo]
                                        AND ins_id=$data[ins_id]
                                        AND mtr_id=$data[mtr_id]
                                        AND mtr_tec_id=$data[mtr_tec_id] ");
                                    $this->regNotasRepository->update($data,$rst_nt[0]->id);
                                }

                            }else{

                                $data['periodo']=2;
                                $this->regNotasRepository->create($data);
                                $data['periodo']=3;
                                $this->regNotasRepository->create($data);
                                $data['periodo']=4;
                                $this->regNotasRepository->create($data);
                                $data['periodo']=5;
                                $this->regNotasRepository->create($data);
                                $data['periodo']=6;
                                $this->regNotasRepository->create($data);
                            }
                   }   

                return response()->json($notas);        

               }elseif ($n_bloques=='2') {
                            $notas=$this->regNotasRepository->create($data);
                            if($data['periodo']!=100){   
                                   if($data['periodo']==7 && $data['ins_id']==9 ){ ///SI ES EXAMEN FINAL Q1
                                        $data['periodo']=8;
                                        $data['ins_id']=10;
                                        $this->regNotasRepository->create($data); ///INSERTA EXAMEN FINAL Q2
                                   }else{
                                           $data['periodo']=($data['periodo']+2);
                                           $this->regNotasRepository->create($data);
                                           $data['periodo']=($data['periodo']+2);
                                           $this->regNotasRepository->create($data);
                                   }  
                            }                         
                                return response()->json($notas);           

               }elseif ($n_bloques=='3') {

                        $notas=$this->regNotasRepository->create($data);
                            if($data['periodo']!=100){                    
                               if($data['periodo']==7 && $data['ins_id']==9 ){ ///SI ES EXAMEN FINAL Q1
                                $data['periodo']=8;
                                $data['ins_id']=10;
                                    $this->regNotasRepository->create($data); ///INSERTA EXAMEN FINAL Q2
                                }else{
                                 $data['periodo']=($data['periodo']+3);
                                 $this->regNotasRepository->create($data);
                             }
                        }
                        return response()->json($notas);

               }

////**************************************************///////////////

            }else{



                   if ($notas=$this->regNotasRepository->update($data,$datos[7])) {

                                if($data['periodo']==7 && $data['ins_id']==9 &&  ($n_bloques=='1' || $n_bloques=='2' || $n_bloques=='3'  )){ 
                                    /// Si es examen I quimestre y los modulos duran 1 o 2 o 3
                                    $not_ex2=DB::select("SELECT * FROM reg_notas 
                                        WHERE mat_id=$data[mat_id]
                                        AND mtr_id=1
                                        AND mtr_tec_id=$data[mtr_tec_id]
                                        AND ins_id=10
                                        AND periodo=8
                                         ");
                                    if(!empty($not_ex2)){
                                        DB::select("UPDATE reg_notas set nota=$data[nota] where id=".$not_ex2[0]->id);
                                    }
                                }                    
                                if($n_bloques=='1'){
                                    $not_ant=DB::select("SELECT * FROM reg_notas 
                                        WHERE mat_id=$data[mat_id]
                                        AND mtr_id=1
                                        AND mtr_tec_id=$data[mtr_tec_id]
                                        AND ins_id=$data[ins_id]");

                                    foreach ($not_ant as $nta) {
                                        DB::select("UPDATE reg_notas SET nota=$data[nota] WHERE id=$nta->id ");
                                    }
                                }
                                if($n_bloques=='2'){
                                        $not_ant=DB::select("SELECT * FROM reg_notas 
                                            WHERE mat_id=$data[mat_id]
                                            AND mtr_id=1
                                            AND mtr_tec_id=$data[mtr_tec_id]
                                            AND ins_id=$data[ins_id]
                                            AND (periodo=($data[periodo]+2) or periodo=($data[periodo]+4))
                                        ");
                                        foreach ($not_ant as $nta) {
                                            DB::select("UPDATE reg_notas SET nota=$data[nota] WHERE id=$nta->id ");
                                        }
                                }                                
                                if($n_bloques=='3'){
                                        $not_ant=DB::select("SELECT * FROM reg_notas 
                                            WHERE mat_id=$data[mat_id]
                                            AND mtr_id=1
                                            AND mtr_tec_id=$data[mtr_tec_id]
                                            AND ins_id=$data[ins_id]
                                            AND periodo=($data[periodo]+3)
                                        ");

                                         foreach ($not_ant as $nta) {
                                             DB::select("UPDATE reg_notas SET nota=$data[nota] WHERE id=$nta->id ");
                                         }
                                }                                

                       return response()->json($notas);
                   }else{
                    return 0;
                   }

            }
}


public function cumplimiento_tareas(Request $rq){
    $dt=$rq->all();
    $tar_id=$dt['cumpl_tar_id'];
    $rst=DB::select("SELECT * FROM tareas_usuarios tu 
            join tareas t on t.tar_id=tu.tar_id
            join matriculas m on tu.mat_id=m.id 
            join jornadas j on m.jor_id=j.id 
            join especialidades es on m.esp_id=es.id 
            join cursos c on m.cur_id=c.id 
            join estudiantes e on e.id=m.est_id
            where tu.tar_id=$tar_id order By e.est_apellidos ");

        Excel::create('Rep_cumplimiento', function($excel) use($rst) {
            $excel->sheet('Lista', function($sheet) use($rst) {
                 // $sheet->cells('A5', function($cells) {
                 //     $cells->setBorder('thin','thin','thin','thin');
                 // });
                 $sheet->loadView("reportes.cumplimiento_tareas")->with('rst',$rst);

            });
        })->export('xlsx');


    // return view("reportes.cumplimiento_tareas")
    // ->with("rst",$rst);
    


}


public function aulaVirtuals_folder(Request $rq){
    // $mtr=Materias::where('esp_id',10)->where('id','<>',3)->orderBy("mtr_descripcion")->pluck('mtr_descripcion','id');
    return view('aula_virtuals.student_folder')
    ->with("jor",$this->jor)
    ->with("esp",$this->esp)
    ->with("cur",$this->cur)
    ;

}

public function student_folder_search(Request $rq){
    $us=Auth::user();
    $dt=$rq->all();
    $jor=$dt['jor_id'];
    $esp=$dt['esp_id'];
    $cur=$dt['cur_id'];
    $paralelo=$dt['paralelo'];
    $anl=Session::get('anl_id');
    $sql_esp="AND m.esp_id<>7 AND m.esp_id<>8 ";
    $sql_paralelo1="AND m.mat_paralelo='$paralelo' ";//Para el ec¿ncabezado
    $sql_paralelo2="AND m.mat_paralelo=''$paralelo'' ";//Para el crosstab
    $tp=0;//Materia Cultural
    if($esp<>10){ //Cultural
        $sql_esp="AND m.esp_id=$esp ";
    }
    if($esp<>10 && $esp<>7 && $esp<>8){
        $sql_paralelo1="AND m.mat_paralelot='$paralelo' ";
        $sql_paralelo2="AND m.mat_paralelot=''$paralelo'' ";
        $tp=1;//Materia Técnica
    }
    if($esp==7){ //BGU
        $anl=Session::get('periodo_id');
    }
////*****PARA NOTAS EN INSUMOS******///////
$sql_materia="";
$sql_mostrar="";
    if( isset($dt['op']) ){
        if($dt['op']=='0'){
            $sql_materia="AND t.mtr_id=".$dt['mtr_id'];
            $sql_mostrar="AND t.tar_mostrar=1";
        }
    }
//////*****************////////////////////
    $sql_mat="
                SELECT mt.id,t.tar_codigo,t.tar_finicio,t.tar_ffin,mt.mtr_descripcion,t.tar_titulo from tareas t 
                JOIN tareas_usuarios tu  on t.tar_id=tu.tar_id
                JOIN matriculas m on m.id=tu.mat_id
                JOIN estudiantes e on m.est_id=e.id
                JOIN materias mt on t.mtr_id=mt.id
                WHERE t.usu_id=$us->id
                AND m.anl_id=$anl 
                AND m.jor_id=$jor
                AND m.cur_id=$cur
                $sql_paralelo1
                AND m.mat_estado=1
                AND mt.mtr_tipo=$tp
                $sql_esp
                $sql_materia
                $sql_mostrar
                GROUP by mt.id,t.tar_codigo,t.tar_finicio,t.tar_ffin,t.tar_titulo
                ORDER by mt.mtr_descripcion,t.tar_finicio,t.tar_codigo  ";
//dd($sql_mat);
$materias=DB::select($sql_mat);

$tx_head="";
$tx_head2="";
$tx_head3=[];
$n_mat=count($materias);
$x=0;
$nm=0;
$mt_id=0;
$tx_materia=[];
foreach ($materias as $m) {
    $sql_union=" UNION ALL ";
    $x++;
    if($x==$n_mat){
        $sql_union=" ";
    }

    if($mt_id==0){
        $mt_id=$m->id;
    }

    if($mt_id==$m->id){
        $nm++;
    }else{
        $nm=1;
        $mt_id=0;
    }
    $tx_head.="SELECT ''".$m->id.$m->tar_codigo."'' ".$sql_union;
    $tx_head2.=",m".$m->id.$nm." text";
    array_push($tx_head3,'m'.$m->id.$nm);
    //array_push($tx_materia,$m->mtr_descripcion.' '.$m->tar_finicio.' '.$m->tar_ffin);
    array_push($tx_materia,$m->mtr_descripcion.'*&'.$m->tar_titulo.'*&'.$m->tar_finicio.'*&'.$m->tar_ffin.'*&'.$m->tar_codigo);
}


$sql=" SELECT * FROM crosstab('SELECT concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id) as estudiante,concat(mt.id,t.tar_codigo) as materia,concat(tu.tru_adjunto,''&'',tu.tru_estado,''&'',tu.tru_nota,''&'',t.tar_codigo,''&'',t.tar_id) from tareas t 
JOIN tareas_usuarios tu  on t.tar_id=tu.tar_id
JOIN matriculas m on m.id=tu.mat_id
JOIN estudiantes e on m.est_id=e.id
JOIN materias mt on t.mtr_id=mt.id
WHERE m.anl_id=$anl  
AND m.jor_id=$jor
AND m.cur_id=$cur
$sql_paralelo2
AND m.mat_estado=1
AND mt.mtr_tipo=$tp
$sql_esp
$sql_materia
$sql_mostrar
ORDER by e.est_apellidos,mt.mtr_descripcion,t.tar_finicio,t.tar_codigo
                                    '::text,' $tx_head  '::text) 
                                crosstab(estudiante text $tx_head2); 
  ";

//    dd($sql);
    $datos=DB::select($sql);
    if( isset($dt['op']) ){
        if($dt['op']=='0'){
            return $this->tabla_folder_student($datos,$tx_materia,$tx_head3);
        }
    }


        if($dt['btn_buscar']=='search'){
            return view('aula_virtuals.student_folder')
            ->with('datos',$datos)
            ->with('tx_head',$tx_head3)
            ->with('tx_materia',$tx_materia)
            ->with("jor",$this->jor)
            ->with("esp",$this->esp)
            ->with("cur",$this->cur)    
            ;

        }else{

            $jr=DB::select("select * from jornadas where id=".$jor);
            $cr=DB::select("select * from cursos where id=".$cur);
            return view('aula_virtuals.student_folder_excel')
            ->with('datos',$datos)
            ->with('tx_head',$tx_head3)
            ->with('tx_materia',$tx_materia)
            ->with("jr",$jr[0])
            ->with("cr",$cr[0])    
            ->with("par",$paralelo)    
            ;

        }
}


    public function tabla_folder_student($datos,$tx_materia,$tx_head){

         $rst_aula="<table class='' id='tbl_tareas'><thead><tr><th>#</th><th>Estudiante</th>";
                        foreach($tx_materia as $th){
                          $aux_enc=explode("*&",$th);
                          $mtr=$aux_enc[0];//Materia
                          $tit=$aux_enc[1];//Titulo
                          $desde=$aux_enc[2];//Desde
                          $hasta=$aux_enc[3];//Hasta
                          $cod=$aux_enc[4];//Código
                          $aux_cod=explode("_",$cod);
                          $sec=number_format($aux_cod[1]);
                          $rst_aula.="<th class='col_nota text-center $cod' title='$cod $tit $desde $hasta' data-toggle='tooltip' data-placement='top' >
                          <i class='fa fa-eye ocultar_tarea btn' tar_cod='$cod' ></i><br>
                          <input type='checkbox' class='chk_act' data='$cod' /><br>
                          $sec
                          </th>";
                        }
        $rst_aula.="<th>Prom</th></tr></thead></tbody>";

        $x=0;
        foreach ($datos as $d) {
            $x++;
            $dtest=explode("&",$d->estudiante);
            $rst_aula.="<tr><td>$x</td><td>$dtest[0]</td>";        

            foreach ($tx_head as $th) {
                if( strlen($d->$th)>0 ){
                    $valores=explode('&',$d->$th);
                    $doc=$valores[0];
                    $status=$valores[1];
                    $nota=$valores[2];
                    $codigo=$valores[3];
                    $tar_id=$valores[4];
                    $rst_aula.="<td class='txt_prom $codigo' > <input type='text' size='1' value='$nota' mat_id='$dtest[1]' tar_id='$tar_id' class='form-control text-right txt_new_notas'  />  </td>";        
                }else{
                    $rst_aula.="<td class='txt_prom text-center' >NA</td>";        
                }
            }
            $rst_aula.="<td class='txt_prom_tmp cls_prom_tmp' mat_id='$dtest[1]' ></td>";        
            $rst_aula.="</tr>";        
        }

        $rst_aula.="</tbody></table>";        
        return Response()->json($rst_aula);

    }


public function sanear_string($string)
{
 
    $string = trim($string);
 
    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
 
    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
 
    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
 
    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
 
    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
 
    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );
 
    //Esta parte se encarga de eliminar cualquier caracter extraño

 
    return $string;
}
 
public function registra_notas_aulav(Request $req){
    $dt=$req->all();
    $esp=$dt['esp'];
    $mat_id=$dt['mat_id'];
    $nota=$dt['nota'];
    $qm1=$dt['qm1'];
    $qm2=$dt['qm2'];
    $anl=Session::get('anl_id');
    $mat=DB::select("SELECT * FROM matriculas where id=".$mat_id);
    $cur=$mat[0]->cur_id;

    if($esp==10 || $esp==7 || $esp==8){ //Materias Culturales
        $materias=DB::select("SELECT ac.mtr_id,m.mtr_descripcion FROM asg_materias_cursos ac
                                join materias m on ac.mtr_id=m.id
                                where ac.anl_id=$anl
                                and ac.esp_id=10
                                and ac.cur_id=$cur
                                and m.mtr_tipo=0
                                order by m.mtr_descripcion ");
    }else{  //Materias Técnicas
        $materias=DB::select("SELECT ac.mtr_id,m.mtr_descripcion FROM asg_materias_cursos ac
                                join materias m on ac.mtr_id=m.id
                                where ac.anl_id=$anl
                                and ac.esp_id=$esp
                                and ac.cur_id=$cur
                                and m.mtr_tipo=1
                                order by m.mtr_descripcion ");
    }



//INSUMO 8 ES INSUMO 5
//INSUMO 12 ES INSUMO 6
//PERIODO 7 INSUMO 9 EXAMEN QUIMESTRE I
//PERIODO 8 INSUMO 10 EXAMEN QUIMESTRE II
//PERIODO 100 INSUMO 5 EXAMEN SUPLETORIO
//PERIODO 101 INSUMO 6 EXAMEN REMEDIAL
//PERIODO 102 INSUMO 7 EXAMEN EX-GRACIA
//PERIODOS CORRECTOS DEL 1 AL 6 NORMALES
                if($qm1=="true"){//Registra o modifica notas el 1er quimestre masivamente

                    foreach ($materias as $m) {
                        if($esp==10 || $esp==7 || $esp==8){
                            $mtr_id=$m->mtr_id;
                            $mtr_tec=0;
                        }else{
                            $mtr_id=1;
                            $mtr_tec=$m->mtr_id;
                        }
                        if( $esp==7){
                            $this->registra_notas_periodos($mat_id,1,$mtr_id,$mtr_tec,$nota);
                            $this->registra_notas_periodos($mat_id,2,$mtr_id,$mtr_tec,$nota);
                            $this->registra_notas_periodo_individual($mat_id,7,$mtr_id,$mtr_tec,$nota,9);//Ex 1er Quim
                            }else{
                                $this->registra_notas_periodos($mat_id,1,$mtr_id,$mtr_tec,$nota);
                                $this->registra_notas_periodos($mat_id,2,$mtr_id,$mtr_tec,$nota);
                                $this->registra_notas_periodos($mat_id,3,$mtr_id,$mtr_tec,$nota);
                                $this->registra_notas_periodo_individual($mat_id,7,$mtr_id,$mtr_tec,$nota,9);//Ex 1er Quim
                        }
                    }
                }

                if($qm2=="true"){//Registra o modifica notas el 2er quimestre masivamente
                    foreach ($materias as $m) {

                        if($esp==10 || $esp==7 || $esp==8){
                            $mtr_id=$m->mtr_id;
                            $mtr_tec=0;
                        }else{
                            $mtr_id=1;//Técnicas
                            $mtr_tec=$m->mtr_id;
                        }
                        if( $esp==7){
                            $this->registra_notas_periodos($mat_id,3,$mtr_id,$mtr_tec,$nota);
                            $this->registra_notas_periodos($mat_id,4,$mtr_id,$mtr_tec,$nota);
                            $this->registra_notas_periodo_individual($mat_id,8,$mtr_id,$mtr_tec,$nota,10);//Ex 2do Quim
                        }else{
                            $this->registra_notas_periodos($mat_id,4,$mtr_id,$mtr_tec,$nota);
                            $this->registra_notas_periodos($mat_id,5,$mtr_id,$mtr_tec,$nota);
                            $this->registra_notas_periodos($mat_id,6,$mtr_id,$mtr_tec,$nota);
                            $this->registra_notas_periodo_individual($mat_id,8,$mtr_id,$mtr_tec,$nota,10);//Ex 2do Quim
                        }
                    }
                }   

                return 0;             

}

        public function registra_notas_periodo_individual($mat,$periodo,$mtr,$mtr_tec,$nota,$ins){
            //POR EL MOMENTO SE USA PARA MODIFICAR LOS EXAMENES QUIMESTRALES
            $usu=Auth::user()->id;
                            $not=DB::select("SELECT * FROM reg_notas WHERE mat_id=$mat
                                                                     AND periodo=$periodo 
                                                                     AND ins_id=$ins
                                                                     AND mtr_id=$mtr 
                                                                     AND mtr_tec_id=$mtr_tec 
                                                                      ");
                            $data=[];
                            $data['mat_id']=$mat;
                            $data['periodo']=$periodo;
                            $data['ins_id']=$ins;
                            $data['mtr_id']=$mtr;
                            $data['usu_id']=$usu;
                            $data['nota']=$nota;
                            $data['f_modific']=date('Y-m-d');
                            $data['mtr_tec_id']=$mtr_tec;

                            if(empty($not)){
                                //Inserta la Nota
                                $this->regNotasRepository->create($data);
                            }else{
                                //Modifica Nota
                                $this->regNotasRepository->update($data,$not[0]->id);
                            }


        }

        public function registra_notas_periodos($mat,$periodo,$mtr,$mtr_tec,$nota){
                //mtr_id=1 es Materia Técnica mtr_tec_id>0
                //mtr_id<>1 es Materia Cultural mtr_tec_id=0
            $usu=Auth::user()->id;
                $ins=0;//Perdiodo
                    for($i=1;$i<=6;$i++){//Insumos
                        if($i==5){ 
                            $ins=8; 
                        }elseif($i==6){ 
                            $ins=12; 
                        }else{
                            $ins=$i; 
                        }
                       
                            $not=DB::select("SELECT id FROM reg_notas WHERE mat_id=$mat
                                                                     AND periodo=$periodo 
                                                                     AND ins_id=$ins
                                                                     AND mtr_id=$mtr 
                                                                     AND mtr_tec_id=$mtr_tec 
                                                                      ");

                            $data=[];
                            $data['mat_id']=$mat;
                            $data['periodo']=$periodo;
                            $data['ins_id']=$ins;
                            $data['mtr_id']=$mtr;
                            $data['usu_id']=$usu;
                            $data['nota']=$nota;
                            $data['f_modific']=date('Y-m-d');
                            $data['mtr_tec_id']=$mtr_tec;

                            if(empty($not)){
                                //Inserta la Nota
                                if($i!=6){
                                    $this->regNotasRepository->create($data);
                                }
                            }else{
                                //Modifica Nota
                                $this->regNotasRepository->update($data,$not[0]->id);
                            }
                       }

        return 0;
        }


    public function comprimirDescargar(Request $rq)
    {
        $dt=$rq->all();
        $mat_id=$dt['folder_mat_id'];
        $est=$dt['folder_estudiante'];
        $files=[];
        str_replace(" ","_",$est);
        $nm="FOLDER_".$est;

        $tareas=DB::select("SELECT tu.tru_estado,tu.tru_adjunto FROM tareas t join tareas_usuarios tu on tu.tar_id=t.tar_id 
            WHERE tu.mat_id=$mat_id and tu.tru_estado=5 
            AND tu.tru_adjunto is not null limit 5");

            foreach ($tareas as $t){
                $fl=public_path() . "/aulaVirtual/".$t->tru_adjunto;
                if(is_file($fl)){
                    array_push($files,$fl);
                }
            }

        if(count($files)>0){
            Zipper::make( storage_path('app/public/zip_av/'.$nm.'.zip') )->add($files)->close();
            return response()->download(storage_path('app/public/zip_av/'.$nm.'.zip'));
        }else{
            return 0;
        }
    }

    public function reporte_tareas_recibidas(Request $rq)
    {
        $dt = $rq->all();
        $rst="";
        if(isset($dt['btn_reporte_cumplimiento_tareas'])){
            $tp=$dt['tar_tipo'];

        if (empty($dt['profe'])){//solo tareas de estudiantes matriculados en este año
            $sql="SELECT t.usu_id,u.usu_apellidos,u.name,u.usu_perfil,count(tu.*) as enviadas  from tareas t
                JOIN tareas_usuarios tu on t.tar_id=tu.tar_id
                JOIN users u on t.usu_id=u.id 
                JOIN matriculas m on m.id=tu.mat_id
                WHERE t.tar_tipo=$tp
                AND   m.anl_id=$this->anl or m.anl_id=$this->anl_bgu 
                GROUP by t.usu_id,u.usu_apellidos,u.name,u.usu_perfil
                ORDER by u.usu_apellidos";
            $profs = DB::select($sql);
        }else{
            $sql="SELECT t.usu_id,u.usu_apellidos,u.name,u.usu_perfil,count(tu.*) as enviadas  from tareas t
                JOIN tareas_usuarios tu on t.tar_id=tu.tar_id
                JOIN users u on t.usu_id=u.id 
                JOIN matriculas m on m.id=tu.mat_id
                WHERE t.tar_tipo=$tp
                AND   (m.anl_id=$this->anl or m.anl_id=$this->anl_bgu) 
                and (u.usu_apellidos like '%".strtoupper($dt['profe'])."%' OR u.usu_no_documento like '%".strtoupper($dt['profe'])."%')
                GROUP by t.usu_id,u.usu_apellidos,u.name,u.usu_perfil
                ORDER by u.usu_apellidos";

            $profs = DB::select($sql);

        }
        $rst="";
        $c=0;
        foreach ($profs as $p) {
            $c++;

            $sql2=" SELECT count(tu.*) as cumplidas  from tareas t 
                JOIN tareas_usuarios tu on t.tar_id=tu.tar_id
                JOIN users u on t.usu_id=u.id 
                JOIN matriculas m on m.id=tu.mat_id
                WHERE u.id=$p->usu_id
                AND   tu.tru_estado=5
                AND   tu.tru_adjunto is not null 
                AND   t.tar_tipo=$tp
                AND   (m.anl_id=$this->anl or m.anl_id=$this->anl_bgu) 
                GROUP by t.usu_id,u.usu_apellidos,u.name,u.usu_perfil
                ORDER by u.usu_apellidos  ";

            $tar=DB::select($sql2);

            if(empty($tar)){
                $cump=0;
            }else{
                $cump=$tar[0]->cumplidas;
            }
            $por_cump=number_format($cump*100/$p->enviadas,2);
            $bg_color="";
            if($por_cump>70){
                //$bg_color="#00a65a";
                $bg_color="progress-bar-success";
            }elseif($por_cump>=50){
                //$bg_color="#db9d19";
                $bg_color="progress-bar-warning";
            }elseif($por_cump>=0){
                //$bg_color="brown";
                $bg_color="progress-bar-danger";
            }            


            $rst.="<tr><td>$c</td> 
            <td>
                       <div class='dropdown' >
                          <label  style='font-size:12px;cursor:pointer;font-weight:500;   ' type='button' data-toggle='dropdown'> $p->usu_apellidos $p->name <span class='caret'></span> </label>
                              <ul class='dropdown-menu' style='border:solid 2px #75BDCC;' >
                                <li><a href='javascript:void(0)' class='btn_info_cumplimiento' info_tipo='0' porc='$por_cump' usuid='$p->usu_id' ><i class='fa fa-check-circle text-success'></i>Todas las Tareas</a></li>
                                <li><a href='javascript:void(0)' disapled class='btn_info_cumplimiento' info_tipo='1' porc='$por_cump' usuid='$p->usu_id' ><i class='fa fa-times-circle text-danger'></i>Tareas No Cumplidas</a></li>
                            </ul>
                        </div> 

            </td> 
            <td class='text-right'>$p->enviadas</td> 
            <td class='text-right'>".$cump."</td>
            <td style='width:30%' class='xl$bg_color barra_tareas' usuid='".$p->usu_id."'>
            <div class='progress progress-striped active '  style='background:#eee;border:solid 1px #ccc;padding:0px'>
            <div class='progress-bar $bg_color'  style='width:$por_cump%;padding:0px;text-align:right;opacity:0.9'>$por_cump %</div>
            </div>
            </td>
            </tr>";
        }
    }
    if(isset($dt['btn_reporte_cumplimiento_tareas'])){
        if($dt['btn_reporte_cumplimiento_tareas']=='Excel'){
            return view('aula_virtuals.reporte_cumplimiento_tareas_excel')
            ->with('rst',$rst);
        }
    }
    return view('aula_virtuals.reporte_cumplimiento_tareas')
    ->with('rst',$rst);
}


    public function descargar_adjuntos_tareas(Request $rq)
    {
        $dt = $rq->all();
        $tar_id=$dt['desc_tar_id'];
        $files  = [];

        $tareas = DB::select("SELECT tu.tru_estado,t.tar_cursos,tu.tru_adjunto 
            FROM tareas t join tareas_usuarios tu on tu.tar_id=t.tar_id
            WHERE t.tar_id=$tar_id 
            AND tu.tru_adjunto is not null ");
        foreach ($tareas as $t) {
            $fl = public_path() . "/aulaVirtual/" . $t->tru_adjunto;
             if (is_file($fl)) {
                 array_push($files, $fl);
             }
        }
        $nm = "TAR-".$tareas[0]->tar_cursos;
        if (count($files) > 0) {
            Zipper::make(storage_path('app/public/zip_tar/' . $nm . '.zip'))->add($files)->close();
            return response()->download(storage_path('app/public/zip_tar/' . $nm . '.zip'));
        } else {
            return 0;
        }

    }

    public function informe_cumplimiento_tareas(Request $rq){
        $dt=($rq->all());
        $us=$dt['usu_id'];
        $tp=$dt['tipo'];        
        $info_tipo=$dt['info_tipo'];        
        $porc=$dt['porc'];        

        $sql_tipo="";
        if($info_tipo==1){
            $sql_tipo="AND (tu.tru_estado<>5 OR tu.tru_adjunto is null)";
        }
            $cursos=DB::select("SELECT t.tar_cursos,e.est_apellidos,e.est_nombres,tu.tru_estado,tu.tru_adjunto from tareas t 
                    JOIN tareas_usuarios tu on t.tar_id=tu.tar_id
                    JOIN users u on t.usu_id=u.id
                    JOIN matriculas m on m.id=tu.mat_id
                    JOIN estudiantes e on e.id=m.est_id
                    WHERE u.id=$us
                    AND  t.tar_tipo=$tp
                    $sql_tipo
                    AND  (m.anl_id=$this->anl or m.anl_id=$this->anl_bgu) 
                    ORDER by t.tar_cursos,e.est_apellidos  ");


            return view("aula_virtuals.informe_cumplimiento_tareas_excel")
            ->with('cursos',$cursos)
            ->with('tporc',$porc);
    }

    public function guarda_notas_aportes(Request $rq){
//return 125;
        $dt=$rq->all();
        $tar_id=$dt['tar_id'];
        $mat_id=$dt['mat_id'];
        $nota=$dt['nota'];
        $fecha=date('Y-m-d');
        $tar_usu=DB::select(" SELECT * FROM tareas_usuarios where tar_id=$tar_id and mat_id=$mat_id");
        DB::select("UPDATE tareas_usuarios set tru_nota=$nota, tru_observacion='Aporte', tru_estado=5, tru_fentrega='$fecha' WHERE tru_id=".$tar_usu[0]->tru_id);
        return 0;

        //dd( $rq->all() );

    }

    public function ocultar_tarea(Request $rq){
        $dt=$rq->all();
        $cod=$dt['cod'];
        DB::select("UPDATE tareas set tar_mostrar=0 where tar_codigo='$cod' ");
        return 0;

    }

}
