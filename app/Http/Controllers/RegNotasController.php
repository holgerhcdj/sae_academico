<?php
namespace App\Http\Controllers;
use App\Http\Requests\CreateRegNotasRequest;
use App\Http\Requests\UpdateRegNotasRequest;
use App\Repositories\RegNotasRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\DB;
use App\Models\AnioLectivo;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Usuarios;
use App\Models\Jornadas;
use App\Models\Materias;
use App\Models\Cursos;
use App\Models\Especialidades;
use PDF;
use App\Models\Auditoria;
use App\Models\Estudiantes;
use App\Http\Controllers\SmsMailController;

class RegNotasController extends AppBaseController {
    private $regNotasRepository;
    private $smsMl;
    private $anl;
    private $anl_bgu;
    private $anl_desc;
    public function __construct(RegNotasRepository $regNotasRepo, SmsMailController $smsMail) {
        $this->regNotasRepository = $regNotasRepo;
        $this->smsMl = $smsMail;
        $anl = AnioLectivo::find(Session::get('anl_id'));
        $anl_bgu = AnioLectivo::find(Session::get('periodo_id'));
        $this->anl = $anl['id'];
        $this->anl_bgu = $anl_bgu['id'];
        $this->anl_desc = $anl['anl_descripcion'];
        //Si no funciona la variable de session revisar el archivo app\Http\Kernel.php
    }

    public function index(Request $op){
        //dd('ok');
         $anl_id=$this->anl;
         //$usu = 50;
         $usu = Auth::user();

            $jor=Jornadas::orderBy('id', 'ASC')->where('id',0)->pluck('jor_descripcion', 'id');
            $esp=Especialidades::pluck('esp_descripcion', 'id');
            $jor->put('0','Seleccione');

            if($usu->jor1==1){
                $jor->put('1','MATUTINA');
            }
            if($usu->jor2==1){
                $jor->put('2','NOCTURNA');
            }
            if($usu->jor3==1){
                $jor->put('3','SEMI-PRESENCIAL');
            }
            if($usu->jor4==1){
                $jor->put('4','VESPERTINA');
            }
            $mtr=['0'=>'Seleccione'];
            $cur=['0'=>'Seleccione'];
            $ins=['0'=>'Seleccione'];
        return view('reg_notas.index')
                        ->with('jor', $jor)
                        ->with('esp', $esp)
                        ->with('mtr', $mtr)
                        ->with('cur', $cur)
                        ->with('ins', $ins);

        // $horarios=DB::select("
        //     SELECT a.anl_id,
        //     j.jor_descripcion,
        //     e.esp_descripcion,
        //     c.cur_descripcion,
        //     a.paralelo
        //     FROM asg_horario_profesores a
        //     join materias m on a.mtr_id=m.id
        //     join aniolectivo al on al.id=a.anl_id
        //     join jornadas j on j.id=a.jor_id
        //     join especialidades e on e.id=a.esp_id
        //     join cursos c on c.id=a.cur_id
        //     WHERE a.mtr_id<>3
        //     and a.suc_id=1
        //     and (a.anl_id=$anl_id or a.anl_id=$this->anl_bgu)
        //     and a.usu_id=50
        //     order by  a.anl_id,j.jor_descripcion,e.esp_descripcion,c.cur_descripcion,a.paralelo  ");

        // //dd($horarios);

        // return view('reg_notas.index')
        // ->with("horarios",$horarios)
        // ;



    }

    public function envia_sms_nota_baja($data){
        $rep=DB::select("SELECT * FROM matriculas m JOIN estudiantes e ON m.est_id=e.id WHERE m.id=".$data['mat_id']);
        $plantilla=DB::select("SELECT * FROM plantillas_sms WHERE pln_id=7 and pln_estado=0"); //Plantilla de nota baja
        $mtr=DB::select("SELECT * FROM materias where id=".$data['mtr_id']);
        if(!empty($plantilla)){
            $obs_v1=str_replace('VAR1',$data['nota'],$plantilla[0]->pln_descripcion);
            $obs_v2=str_replace('(VAR2)',$mtr[0]->mtr_descripcion,$obs_v1);
            $obs_v3=str_replace('(VAR3)',$rep[0]->est_apellidos.' '.$rep[0]->est_nombres,$obs_v2);
            $obs=str_replace('(VAR4)'," ".date('Y-m-d'),$obs_v3);

                              $inp[0]=$data['mat_id'];
                              $inp[1]=null;
                              $inp[2]=null;
                              $inp[3]=null;
                              $inp[4]=null;
                              $inp[5]=null;
                              $inp[6]=null;
                              $inp[7]=$obs;
                              $cd=$this->smsMl->codigo_sms();
                              $this->smsMl->inserta_mensaje($inp,0,$cd);

        }
    }


    public function save($dt) {

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
        if($data['ins_id']==5){
            $data['periodo']=100;
        }
        if($data['ins_id']==6){
            $data['periodo']=101;
        }
        if($data['ins_id']==7){
            $data['periodo']=102;
        }


            if($datos[7]==0){//Si no existe ID del registro de notas
////*******************NOTAS DE INSUMOS******************///////////////
                if($n_bloques=='6'){

                    if ($notas=$this->regNotasRepository->create($data)) {

                        $datos = implode("-", array_flatten($notas['attributes']));
                        $aud= new Auditoria();
                        $data=["mod"=>"RegNotas","acc"=>"Insertar","dat"=>$datos,"doc"=>"NA"];
                        $aud->save_adt($data);
                        return response()->json($notas);

                    }else{
                       return 0;
                   }

               }else if($n_bloques=='1'){


                  $notas=$this->regNotasRepository->create($data);

                   if($data['periodo']!=100 && $data['periodo']!=101 && $data['periodo']!=102){

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
            if($data['periodo']!=100 && $data['periodo']!=101 && $data['periodo']!=102){

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
            if($data['periodo']!=100 && $data['periodo']!=101 && $data['periodo']!=102){
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
                                        //dd($not_ant);
                                         foreach ($not_ant as $nta) {
                                             DB::select("UPDATE reg_notas SET nota=$data[nota] WHERE id=$nta->id ");
                                         }
                                }
                                DB::select("update reg_notas set disciplina='$datos[9]' where mat_id=$notas->mat_id and periodo=$notas->periodo and mtr_id=$notas->mtr_id");
                                $datos = implode("-", array_flatten($notas['attributes']));
                                $aud= new Auditoria();
                                $data=["mod"=>"RegNotas","acc"=>"Modificar","dat"=>$datos,"doc"=>"NA"];
                                $aud->save_adt($data);
                       return response()->json($notas);
                   }else{
                    return 0;
                   }

            }
}

    public function mtr_tecnicas($esp,$cur){

        $usu = Auth::user();
        if($usu->id<>22 && $usu->id<>86){
            $esp=0;
        }
        if($esp==0){
            $esp=$usu->esp_id;
        }
       return $mtr_tec = DB::select("select m.*,am.bloques from asg_materias_cursos am, materias m
        where am.mtr_id=m.id
        and am.anl_id=$this->anl
        and am.suc_id=1
        and am.jor_id=1
        and am.esp_id=$esp
        and am.cur_id=$cur ");
    }


public function busca_admin_notas($tipo,$parcial,$jor=0,$esp=0,$cur=0,$par=0,$mtr=0,$mod=0){
    //dd($tipo.'-'.$parcial.'-'.$jor.'-'.$esp.'-'.$cur.'-'.$par.'-'.$mtr.'-'.$mod);
    $hoy=date("Y-m-d");
   return $result=DB::select("
                SELECT insumo FROM admin_notas
                WHERE  '$hoy' BETWEEN adm_finicio AND adm_ffinal
                AND adm_tipo=$tipo
                AND adm_parcial=$parcial
                AND jor_id=$jor
                AND esp_id=$esp
                AND cur_id=$cur
                AND paralelo='$par'
                AND mtr_id=$mtr
                AND mod_id=$mod
                AND adm_estado=1
                ORDER BY insumo;
        ");

}


public function culturales_parcial_total($parcial){
    $hoy=date("Y-m-d");
//Por Parcial abierto para todos
    $result=DB::select(" SELECT insumo FROM admin_notas
        WHERE  '$hoy' BETWEEN adm_finicio AND adm_ffinal
        AND adm_tipo=1
        AND adm_parcial=$parcial
        AND jor_id=0
        AND esp_id=0
        AND cur_id=0
        AND paralelo='0'
        AND mtr_id=0
        AND mod_id=0
        AND doc_id=0
        AND adm_estado=1 order by insumo");
    return $result;

}
///***************REVISAR SI SE UTILIZA**************************//////////////
public function culturales_parcial_jornada($parcial,$jor){
    $hoy=date("Y-m-d");
//Por Parcial abierto para todos
    $result=DB::select(" SELECT count(*) FROM admin_notas
        WHERE  '$hoy' BETWEEN adm_finicio AND adm_ffinal
        AND adm_tipo=1
        AND adm_parcial=$parcial
        AND jor_id=$jor
        AND esp_id=0
        AND cur_id=0
        AND paralelo='0'
        AND mtr_id=0
        AND mod_id=0
        AND doc_id=0
        AND adm_estado=1 ");
    return $result[0];
}
public function culturales_parc_jor_curso($parcial,$jor,$cur){
    $hoy=date("Y-m-d");
//Por Parcial abierto para todos
    $result=DB::select(" SELECT count(*) FROM admin_notas
        WHERE  '$hoy' BETWEEN adm_finicio AND adm_ffinal
        AND adm_tipo=1
        AND adm_parcial=$parcial
        AND jor_id=$jor
        AND esp_id=0
        AND cur_id=$cur
        AND paralelo='0'
        AND mtr_id=0
        AND mod_id=0
        AND doc_id=0
        AND adm_estado=1 ");
    return $result[0];
}
public function culturales_parc_jor_cur_par($parcial,$jor,$cur,$par){
    $hoy=date("Y-m-d");
//Por Parcial abierto para todos
    $result=DB::select(" SELECT count(*) FROM admin_notas
        WHERE  '$hoy' BETWEEN adm_finicio AND adm_ffinal
        AND adm_tipo=1
        AND adm_parcial=$parcial
        AND jor_id=$jor
        AND esp_id=0
        AND cur_id=$cur
        AND paralelo='$par'
        AND mtr_id=0
        AND mod_id=0
        AND doc_id=0
        AND adm_estado=1 ");
    return $result[0];
}
public function culturales_parc_jor_cur_par_mtr($parcial,$jor,$cur,$par,$mtr){
    $hoy=date("Y-m-d");
//Por Parcial abierto para todos
    $result=DB::select(" SELECT count(*) FROM admin_notas
        WHERE  '$hoy' BETWEEN adm_finicio AND adm_ffinal
        AND adm_tipo=1
        AND adm_parcial=$parcial
        AND jor_id=$jor
        AND esp_id=0
        AND cur_id=$cur
        AND paralelo='$par'
        AND mtr_id=$mtr
        AND mod_id=0
        AND doc_id=0
        AND adm_estado=1 ");
    return $result[0];
}

public function culturales_parc_materia($parcial,$mtr){
    $hoy=date("Y-m-d");
//Por Parcial abierto para todos
    $result=DB::select(" SELECT count(*) FROM admin_notas
        WHERE  '$hoy' BETWEEN adm_finicio AND adm_ffinal
        AND adm_tipo=1
        AND adm_parcial=$parcial
        AND jor_id=0
        AND esp_id=0
        AND cur_id=0
        AND paralelo='0'
        AND mtr_id=$mtr
        AND mod_id=0
        AND doc_id=0
        AND adm_estado=1 ");
    return $result[0];
}
public function culturales_parc_jor_materia($parcial,$jor,$mtr){
    $hoy=date("Y-m-d");
//Por Parcial abierto para todos
    $result=DB::select(" SELECT count(*) FROM admin_notas
        WHERE  '$hoy' BETWEEN adm_finicio AND adm_ffinal
        AND adm_tipo=1
        AND adm_parcial=$parcial
        AND jor_id=$jor
        AND esp_id=0
        AND cur_id=0
        AND paralelo='0'
        AND mtr_id=$mtr
        AND mod_id=0
        AND doc_id=0
        AND adm_estado=1 ");
    return $result[0];
}
public function culturales_parc_jor_cur_materia($parcial,$jor,$cur,$mtr){
    $hoy=date("Y-m-d");
//Por Parcial abierto para todos
    $result=DB::select(" SELECT count(*) FROM admin_notas
        WHERE  '$hoy' BETWEEN adm_finicio AND adm_ffinal
        AND adm_tipo=1
        AND adm_parcial=$parcial
        AND jor_id=$jor
        AND esp_id=0
        AND cur_id=$cur
        AND paralelo='0'
        AND mtr_id=$mtr
        AND mod_id=0
        AND doc_id=0
        AND adm_estado=1 ");
    return $result[0];
}
public function culturales_parc_jor_cur_par_materia($parcial,$jor,$cur,$par,$mtr){
    $hoy=date("Y-m-d");
//Por Parcial abierto para todos
    $result=DB::select(" SELECT count(*) FROM admin_notas
        WHERE  '$hoy' BETWEEN adm_finicio AND adm_ffinal
        AND adm_tipo=1
        AND adm_parcial=$parcial
        AND jor_id=$jor
        AND esp_id=0
        AND cur_id=$cur
        AND paralelo='$par'
        AND mtr_id=$mtr
        AND mod_id=0
        AND doc_id=0
        AND adm_estado=1 ");
    return $result[0];
}

public function tecnicos_total(){
    $hoy=date("Y-m-d");
//Por Parcial abierto para todos
    $result=DB::select(" SELECT insumo FROM admin_notas
        WHERE  '$hoy' BETWEEN adm_finicio AND adm_ffinal
        AND adm_tipo=2
        AND adm_parcial=0
        AND jor_id=0
        AND esp_id=0
        AND cur_id=0
        AND paralelo='0'
        AND mtr_id=0
        AND mod_id=0
        AND doc_id=0
        AND adm_estado=1 ORDER BY insumo ");
    return $result;
}
public function tecnicos_jornada($jor){
    $hoy=date("Y-m-d");
//Por Parcial abierto para todos
    $result=DB::select(" SELECT count(*) FROM admin_notas
        WHERE  '$hoy' BETWEEN adm_finicio AND adm_ffinal
        AND adm_tipo=2
        AND adm_parcial=0
        AND jor_id=$jor
        AND esp_id=0
        AND cur_id=0
        AND paralelo='0'
        AND mtr_id=0
        AND mod_id=0
        AND doc_id=0
        AND adm_estado=1 ");
    return $result[0];
}
public function tecnicos_jor_esp($jor,$esp){
    $hoy=date("Y-m-d");
//Por Parcial abierto para todos
    $result=DB::select(" SELECT count(*) FROM admin_notas
        WHERE  '$hoy' BETWEEN adm_finicio AND adm_ffinal
        AND adm_tipo=2
        AND adm_parcial=0
        AND jor_id=$jor
        AND esp_id=$esp
        AND cur_id=0
        AND paralelo='0'
        AND mtr_id=0
        AND mod_id=0
        AND doc_id=0
        AND adm_estado=1 ");
    return $result[0];
}
public function tecnicos_jor_esp_cur($jor,$esp,$cur){
    $hoy=date("Y-m-d");
//Por Parcial abierto para todos
    $result=DB::select(" SELECT count(*) FROM admin_notas
        WHERE  '$hoy' BETWEEN adm_finicio AND adm_ffinal
        AND adm_tipo=2
        AND adm_parcial=0
        AND jor_id=$jor
        AND esp_id=$esp
        AND cur_id=$cur
        AND paralelo='0'
        AND mtr_id=0
        AND mod_id=0
        AND doc_id=0
        AND adm_estado=1 ");
    return $result[0];
}
public function tecnicos_jor_esp_cur_par($jor,$esp,$cur,$par){
    $hoy=date("Y-m-d");
//Por Parcial abierto para todos
    $result=DB::select(" SELECT count(*) FROM admin_notas
        WHERE  '$hoy' BETWEEN adm_finicio AND adm_ffinal
        AND adm_tipo=2
        AND adm_parcial=0
        AND jor_id=$jor
        AND esp_id=$esp
        AND cur_id=$cur
        AND paralelo='$par'
        AND mtr_id=0
        AND mod_id=0
        AND doc_id=0
        AND adm_estado=1 ");
    return $result[0];
}
public function tecnicos_jor_esp_cur_par_mod($jor,$esp,$cur,$par,$mod){
    $hoy=date("Y-m-d");
//Por Parcial abierto para todos
    $result=DB::select(" SELECT count(*) FROM admin_notas
        WHERE  '$hoy' BETWEEN adm_finicio AND adm_ffinal
        AND adm_tipo=2
        AND adm_parcial=0
        AND jor_id=$jor
        AND esp_id=$esp
        AND cur_id=$cur
        AND paralelo='$par'
        AND mtr_id=0
        AND mod_id=$mod
        AND doc_id=0
        AND adm_estado=1 ");
    return $result[0];
}
public function tecnicos_esp($esp){
    $hoy=date("Y-m-d");
//Por Parcial abierto para todos
    $result=DB::select(" SELECT count(*) FROM admin_notas
        WHERE  '$hoy' BETWEEN adm_finicio AND adm_ffinal
        AND adm_tipo=2
        AND adm_parcial=0
        AND jor_id=0
        AND esp_id=$esp
        AND cur_id=0
        AND paralelo='0'
        AND mtr_id=0
        AND mod_id=0
        AND doc_id=0
        AND adm_estado=1 ");
    return $result[0];
}
////***************//////////////////**********

    public function cls_color($nt){

            $cls_color='';
            if($nt>0 && $nt<5){
                $cls_color='remedial';
            }else if($nt>=5 && $nt<7){
                $cls_color='supletorio';
            }else{
                $cls_color='';
            }
                return $cls_color;
    }

    public function promedio_bloque_persona_materia($ins,$dt){
                    $tot=0;
                    $divisor=1;
                    foreach ($ins as $i){
                          if($notas=DB::select("SELECT * FROM reg_notas
                            WHERE ins_id=$i->id
                            AND mat_id=$dt[0]
                            AND periodo=$dt[1]
                            AND mtr_id=$dt[2]
                            AND mtr_tec_id=$dt[3] ")){
                              $nt=$notas[0]->nota;
                              $ntid=$notas[0]->id;
                          }else{
                              $nt=0;
                              $ntid=0;
                          }
                          $tot=($tot+$nt);
                            if($i->id==12 && $nt>0){//SI EN EL INSUMO 6 ESXITE NOTA SE PROMEDIA
                                $divisor=6;
                            }else{
                                $divisor=5;
                            }
                    }
                    return ($tot/$divisor);

    }


    public function load_datos_org($dt) {
             $dt=explode("&",$dt);
             $usu = Auth::user();
             $AUD=new Auditoria();
             $anl=$this->anl;
             $jor=$dt[0];
             $esp=$dt[6];
             if($esp==10){
                $esp=0;
             }
             $cur=$dt[1];
             $par=$dt[2];
             $estado=1;
             if($esp==7){
                $anl=$this->anl_bgu;
            }
            $datos=[$anl,$jor,$esp,$cur,$par,$estado];
            $lista=$AUD->buscador_estudiantes($datos);

            $ins = DB::select("select * from insumos where tipo='I' order by id");


            if($dt[4]==7){
    //SI ES EXAMEN QUIMESTRAL I
                if($esp==7){ ///si es BGU
                $resp="<thead><tr>
                                <th><spam>#</spam></th>
                                <th>Estudiante</th>
                                <th ><label class='rotate_tx' >Bloque 1</label></th>
                                <th ><label class='rotate_tx' >Bloque 2</label></th>
                                <th ><label class='rotate_tx' >Examen PI</label></th>
                                <th ><label class='rotate_tx' >Prom PI</label></th>
                                </tr></<thead><tbody>";
                }else{
                $resp="<thead><tr>
                                <th><spam>#</spam></th>
                                <th>Estudiante</th>
                                <th ><label class='rotate_tx' >Bloque 1</label></th>
                                <th ><label class='rotate_tx' >Bloque 2</label></th>
                                <th ><label class='rotate_tx' >Bloque 3</label></th>
                                <th ><label class='rotate_tx' >Examen QI</label></th>
                                <th ><label class='rotate_tx' >Prom QI</label></th>
                                </tr></<thead><tbody>";
                }

                                $x=0;
                                foreach ($lista as $r) {
                                    $x++;
                                    $resp.="<tr>
                                    <td>$x</td>
                                    <td>$r->est_apellidos $r->est_nombres</td>";
////***************PROMEDIO BLOQUE 1********************/////////////
                                    $ax_dt[0]=$r->mat_id;//Matricula ID
                                    $ax_dt[1]=1;//Periodo o Bloque
                                    $ax_dt[2]=$dt[3];//Materia Cultural
                                    $ax_dt[3]=$dt[5];//Materia Técnica
                                    $prm1=number_format($this->promedio_bloque_persona_materia($ins,$ax_dt),2);
                                    $cls_color=$this->cls_color($prm1);
                                    $resp.="<td align='right'><input class='txt_notas form-control $cls_color'  type='text' value='$prm1' maxlength='5' id='$r->mat_id&0' lang='0' disabled  /></td>";
////***************PROMEDIO BLOQUE 2********************/////////////
                                    $ax_dt[0]=$r->mat_id;//Matricula ID
                                    $ax_dt[1]=2;//Periodo o Bloque
                                    $ax_dt[2]=$dt[3];//Materia Cultural
                                    $ax_dt[3]=$dt[5];//Materia Técnica
                                    $prm2=number_format($this->promedio_bloque_persona_materia($ins,$ax_dt),2);
                                    $cls_color=$this->cls_color($prm2);
                                    $resp.="<td align='right'><input class='txt_notas form-control $cls_color'  type='text' value='$prm2' maxlength='5' id='$r->mat_id&0' lang='0' disabled /></td>";
////***************PROMEDIO BLOQUE 3********************/////////////
                             if($esp==7){
                                $prm3=(($prm1+$prm2)/2);
                             }else{
                                    $ax_dt[0]=$r->mat_id;//Matricula ID
                                    $ax_dt[1]=3;//Periodo o Bloque
                                    $ax_dt[2]=$dt[3];//Materia Cultural
                                    $ax_dt[3]=$dt[5];//Materia Técnica
                                    $prm3=number_format($this->promedio_bloque_persona_materia($ins,$ax_dt),2);
                                    $cls_color=$this->cls_color($prm3);
                                    $resp.="<td align='right'><input class='txt_notas form-control $cls_color'  type='text' value='$prm3' maxlength='5' id='$r->mat_id&0' lang='0' disabled  /></td>";
                            }
////***************PROMEDIO QUIMESTRE I ********************/////////////
                                    $sql_mtr="and mtr_id=$dt[3]";
                                    if($dt[3]==1){
                                        $sql_mtr="and mtr_id=$dt[3] and mtr_tec_id=$dt[5]";
                                    }

                                    if($q1=DB::select("select * from reg_notas where mat_id=$r->mat_id and periodo=7 and ins_id=9 $sql_mtr ")){
                                        $nt=$q1[0]->nota;
                                        $ntid=$q1[0]->id;
                                    }else{
                                        $nt=0;
                                        $ntid=0;
                                    }

                                    $pq180=(($prm1+$prm2+$prm3)/3)*0.8;
                                    $eq120=$nt*0.2;
                                    $ptq1=number_format($pq180+$eq120,2);
                                    $cls_color=$this->cls_color($nt);
                                    $resp.="<td>
                                                <input class='txt_notas form-control $cls_color'  type='text' value='$nt' maxlength='5' id='$r->mat_id&9' onchange='save(this)' lang='$ntid' />
                                                <input type='hidden' value='$pq180' id='pq_$r->mat_id' />
                                            </td>";
                                    $cls_color=$this->cls_color($ptq1);
                                    $resp.="<td><input class='txt_notas form-control $cls_color' type='text' value='$ptq1' maxlength='5' id='tot$r->mat_id' disabled /></td>";
                                }
                    $resp.="</tr></<tbody>";

            }else if($dt[4]==8){
                //SI ES EXAMEN QUIMESTRAL II
                if($esp==7){ //SI ES BGU
                                $resp="<thead><tr>
                                <th><spam>#</spam></th>
                                <th >Estudiante</th>
                                <th ><label class='rotate_tx'>Prom PI</label></th>
                                <th ><label class='rotate_tx'>Bloque 3</label></th>
                                <th ><label class='rotate_tx'>Bloque 4</label></th>
                                <th ><label class='rotate_tx'>Examen P-II</label></th>
                                <th ><label class='rotate_tx'>Prom P-II</label></th>
                                <th ><label class='rotate_tx'>Prom Final</label></th>
                                </tr></<thead><tbody>";
                }else{
                                $resp="<thead><tr>
                                <th><spam>#</spam></th>
                                <th >Estudiante</th>
                                <th ><label class='rotate_tx'>Prom QI</label></th>
                                <th ><label class='rotate_tx'>Bloque 4</label></th>
                                <th ><label class='rotate_tx'>Bloque 5</label></th>
                                <th ><label class='rotate_tx'>Bloque 6</label></th>
                                <th ><label class='rotate_tx'>Examen QII</label></th>
                                <th ><label class='rotate_tx'>Prom QII</label></th>
                                <th ><label class='rotate_tx'>Prom Final</label></th>
                                </tr></<thead><tbody>";
                }
                                $x=0;
                                foreach ($lista as $r) {
                                    $x++;
                                    $resp.="<tr>
                                    <td>$x</td>
                                    <td>$r->est_apellidos $r->est_nombres</td>";
////***************PROMEDIO QUIMESTRE I********************/////////////
                                    /////******PROMEDIO BLOQUE 1 **************//////
                                    $ax_dt[0]=$r->mat_id;//Matricula ID
                                    $ax_dt[1]=1;//Periodo o Bloque
                                    $ax_dt[2]=$dt[3];//Materia Cultural
                                    $ax_dt[3]=$dt[5];//Materia Técnica
                                    $prm1=number_format($this->promedio_bloque_persona_materia($ins,$ax_dt),2);
                                    //dd();
                                    /////******PROMEDIO BLOQUE 2 **************//////
                                    $ax_dt[1]=2;//Periodo o Bloque
                                    $prm2=number_format($this->promedio_bloque_persona_materia($ins,$ax_dt),2);
                                     if($esp==7){ //si es BGU
                                        $prm3=(($prm1+$prm2)/2);
                                    }else{
                                            /////******PROMEDIO BLOQUE 3 **************//////
                                            $ax_dt[1]=3;//Periodo o Bloque
                                            $prm3=number_format($this->promedio_bloque_persona_materia($ins,$ax_dt),2);
                                        }

                                    $sql_mtr="and mtr_id=$dt[3]";
                                    if($dt[3]==1){
                                        $sql_mtr="and mtr_id=$dt[3] and mtr_tec_id=$dt[5]";
                                    }

                                    if($q1=DB::select("select * from reg_notas where mat_id=$r->mat_id and periodo=7 and ins_id=9 $sql_mtr ")){
                                        $nt=$q1[0]->nota;
                                    }else{
                                        $nt=0;
                                    }
                                    $ptq1 =number_format((($prm1+$prm2+$prm3)/3*0.80)+($nt*0.2),2);

                                    $cls_color=$this->cls_color($ptq1);
                                    $resp.="<td><input class='txt_notas form-control $cls_color' type='text' value='$ptq1' maxlength='5' id='tq1$r->mat_id' disabled /></td>";
////***************PROMEDIO BLOQUE 4********************/////////////
                                    $ax_dt[1]=4;//Periodo o Bloque
                                     if($esp==7){ //si es BGU
                                        $ax_dt[1]=3;
                                    }
                                    $prm4=number_format($this->promedio_bloque_persona_materia($ins,$ax_dt),2);
                                    $cls_color=$this->cls_color($prm4);
                                    $resp.="<td align='right'><input class='txt_notas form-control $cls_color'  type='text' value='$prm4' maxlength='5' id='$r->mat_id&0' lang='0' disabled  /></td>";
////***************PROMEDIO BLOQUE 5********************/////////////
                                    $ax_dt[1]=5;//Periodo o Bloque
                                     if($esp==7){ //si es BGU
                                        $ax_dt[1]=4;
                                    }
                                    $prm5=number_format($this->promedio_bloque_persona_materia($ins,$ax_dt),2);
                                    $cls_color=$this->cls_color($prm5);
                                    $resp.="<td align='right'><input class='txt_notas form-control $cls_color'  type='text' value='$prm5' maxlength='5' id='$r->mat_id&0' lang='0' disabled /></td>";
////***************PROMEDIO BLOQUE 6********************/////////////
                                if($esp==7){ //si es BGU
                                    $prm6=(($prm4+$prm5)/2);
                                }else{
                                    $ax_dt[1]=6;//Periodo o Bloque
                                    $prm6=number_format($this->promedio_bloque_persona_materia($ins,$ax_dt),2);
                                    $cls_color=$this->cls_color($prm6);
                                    $resp.="<td align='right'><input class='txt_notas form-control $cls_color'  type='text' value='$prm6' maxlength='5' id='$r->mat_id&0' lang='0' disabled  /></td>";
                                }
////***************PROMEDIO QUIMESTRE II ********************/////////////
                                    $sql_mtr="and mtr_id=$dt[3]";
                                    if($dt[3]==1){
                                        $sql_mtr="and mtr_id=$dt[3] and mtr_tec_id=$dt[5]";
                                    }

                                    if($q2=DB::select("select * from reg_notas where mat_id=$r->mat_id and periodo=8 and ins_id=10 $sql_mtr ")){
                                        $nt=$q2[0]->nota;
                                        $ntid=$q2[0]->id;
                                    }else{
                                        $nt=0;
                                        $ntid=0;
                                    }
                                    $pq280=(($prm4+$prm5+$prm6)/3)*0.8;
                                    $eq220=$nt*0.2;
                                    $ptq2=number_format($pq280+$eq220,2);
                                    $cls_color=$this->cls_color($nt);
                                    $resp.="<td>
                                                <input class='txt_notas form-control $cls_color'  type='text' value='$nt' maxlength='5' id='$r->mat_id&10' onchange='save(this)' lang='$ntid' />
                                                <input type='hidden' value='$pq280' id='pq_$r->mat_id' />
                                            </td>";
                                    $cls_color=$this->cls_color($ptq2);
                                    $resp.="<td><input class='txt_notas form-control $cls_color' type='text' value='$ptq2' maxlength='5' id='tot$r->mat_id' disabled /></td>";
                                    $pfin=number_format(($ptq1+$ptq2)/2,2);
                                    $cls_color=$this->cls_color($pfin);
                                    $resp.="<td><input class='txt_notas form-control $cls_color' type='text' value='$pfin' maxlength='5' id='tfin$r->mat_id' disabled /></td>";
                                }

                    $resp.="</tr></<tbody>";
            }else if($dt[4]>=1 && $dt[4]<=6){ //si es cualquier bloque CULTURAL

//****************permisos****************
                //dd('okokok');
    //dd($dt[5]);
//dd($dt);
//if($dt[3]==1){ //Si es Materia Técnica
    // $hbl="";
    // $hb1="disabled";
    // $hb2="disabled";
    // $hb3="disabled";
    // $hb4="disabled";
    // $hb5="disabled";
    // $hb6="disabled";
//Busco la especialidad por la materia tecnica
  // 0 => "1" Jor
  // 1 => "4" Cur
  // 2 => "A" Par
  // 3 => "1" Mtr
  // 4 => "1" Bloq
  // 5 => "30" Mtrt
  // 6 => "2" Esp

    //$perm=$this->tecnicos_total();
    // foreach ($perm as $p) {
    //     if($p->insumo==0){
    //         $hb1="";$hb2="";$hb3="";$hb4="";$hb5="";$hb6="";
    //     }
    //     if($p->insumo==1){$hb1="";}if($p->insumo==2){$hb2="";}if($p->insumo==3){$hb3="";}
    //     if($p->insumo==4){$hb4="";}if($p->insumo==8){$hb5="";}if($p->insumo==12){$hb6="";}
    // }



//}else{

    // $hbl="";
    // $hb1="disabled";
    // $hb2="disabled";
    // $hb3="disabled";
    // $hb4="disabled";
    // $hb5="disabled";
    // $hb6="disabled";

    $hbl="";
    $hb1="";
    $hb2="";
    $hb3="";
    $hb4="";
    $hb5="";
    $hb6="";
    $tp=1;
    if($dt[3]==1){
        $tp=2;
        //$dt[4]=0;
    }
      // 0 => "3" Jor
      // 1 => "5" Cur
      // 2 => "A" Par
      // 3 => "33" Mtr
      // 4 => "1" Bloq
      // 5 => "0" Mtrt
      // 6 => "7" Esp
    //($tipo,$parcial,$jor,$esp,$cur,$par,$mtr,$mod)
    $perm=$this->busca_admin_notas($tp,$dt[4],$dt[0],$dt[6],$dt[1],$dt[2],$dt[3],$dt[5]);
    if(empty($perm)){
        //dd('N1');
        $perm=$this->busca_admin_notas($tp,$dt[4],$dt[0],$dt[6],$dt[1],$dt[2],$dt[3]);
        if(empty($perm)){
            //dd('N2');
            $perm=$this->busca_admin_notas($tp,$dt[4],$dt[0],$dt[6],$dt[1],$dt[2]);
            if(empty($perm)){
                //dd('N3');
                $perm=$this->busca_admin_notas($tp,$dt[4],$dt[0],$dt[6],$dt[1]);
                if(empty($perm)){
                    //dd('N4');
                    $perm=$this->busca_admin_notas($tp,$dt[4],$dt[0],$dt[6]);
                    if(empty($perm)){
                        //dd('N5');
                        $perm=$this->busca_admin_notas($tp,$dt[4],$dt[0]);
                        //dd($perm);
                        if(empty($perm)){
                            //dd('N6');
                            $perm=$this->busca_admin_notas($tp,$dt[4]);
                        }
                    }
                }
            }
        }
    }
    foreach ($perm as $p) {
        if($p->insumo==0){
            $hb1="";$hb2="";$hb3="";$hb4="";$hb5="";$hb6="";
        }
        if($p->insumo==1){$hb1="";}if($p->insumo==2){$hb2="";}if($p->insumo==3){$hb3="";}
        if($p->insumo==4){$hb4="";}if($p->insumo==8){$hb5="";}if($p->insumo==12){$hb6="";}
    }

//}

//****************************************
               $resp="<thead><tr><th><spam>#</spam></th><th>Estudiante</th>";
                $x=0;
                foreach ($ins as $i) {
                    if($i->id==12){ //Si es insumo 6 de recuperacion
                        $resp.="<th><label  class='rotate_tx text-danger'>$i->ins_descripcion</label></th>";
                    }else{
                        $resp.="<th><label class='rotate_tx'>$i->ins_descripcion</label></th>";
                    }
                }
                 $resp.="<th>
                            <label class='rotate_tx'>PROMEDIO</label>
                            <input type='hidden' name='count' id='count' value='".(count($ins))."' >
                         </th>
                         <th style='width:60px' ><label class='rotate_tx'>COMPORTAMIENTO</label></th>
                 </tr></thead><tbody>";
                foreach ($lista as $r) {
                    $x++;
                    $resp.="<tr>
                    <td>$x</td>
                    <td style='font-size:12px;'>$r->est_apellidos $r->est_nombres</td>";
                    $prm=0;
                    $cls_color="";
                    foreach ($ins as $i){
                          if($notas=DB::select("select * from reg_notas where mat_id=$r->mat_id and periodo=$dt[4] and ins_id=$i->id and mtr_id=$dt[3] and mtr_tec_id=$dt[5] ")){
                              $nt=$notas[0]->nota;
                              $ntid=$notas[0]->id;
                          }else{
                              $nt=0;
                              $ntid=0;
                          }
                         $prm=($prm+$nt);
                         $cls_color=$this->cls_color($nt);
                         if($i->id==1){$hbl=$hb1;}if($i->id==2){$hbl=$hb2;}if($i->id==3){$hbl=$hb3;}
                         if($i->id==4){$hbl=$hb4;}if($i->id==8){$hbl=$hb5;}if($i->id==12){$hbl=$hb6;}

                            $resp.="<td><input $hbl tabindex='$i->id' class='txt_notas form-control  $cls_color ' type='text' value='$nt' maxlength='5' id='$r->mat_id&$i->id'  onchange='save(this)' lang='$ntid' /></td>";

                        if($i->id==12 && $nt>0){//SI EN EL INSUMO 6 ESXITE NOTA SE PROMEDIA
                            $divisor=6;
                        }else{
                            $divisor=5;
                        }
                    }

                    $prm=number_format(($prm/$divisor),2);
                    $cls_color=$this->cls_color($prm);
//***************BUSCO COMPORTAMIENTO**************/////////////
                    $mtr=$dt[3];
                    if($dt[3]==1){
                        $mtr=$dt[5];
                    }
                    $disciplina=DB::select("SELECT * FROM reg_disciplina WHERE mat_id=$r->mat_id AND mtr_id=$mtr AND dsc_parcial=$dt[4] AND dsc_tipo=0 ");
                    $dsc_id=0;
                    $dsa="";$dsb="";$dsc="";$dsd="";
                    if(!empty($disciplina)){
                        $dsc_id=$disciplina[0]->dsc_id;
                        switch ($disciplina[0]->dsc_nota) {
                            case 'A': $dsa="selected";$dsb="";$dsc="";$dsd="";  break;
                            case 'B': $dsa="";$dsb="selected";$dsc="";$dsd="";  break;
                            case 'C': $dsa="";$dsb="";$dsc="selected";$dsd="";  break;
                            case 'D': $dsa="";$dsb="";$dsc="";$dsd="selected";  break;
                        }
                    }
///////////////**********************/////////////////////////
                    $resp.="<td><input class='txt_notas form-control promedio $cls_color' type='text' value='$prm' maxlength='5' id='tot$r->mat_id' disabled /></td>
                    <td>
                        <select class='form-control tx_comprtamiento'   type='text' value='A' maxlength='1' dsc_id=$dsc_id mat_id='$r->mat_id' >
                            <option value='0'></option>
                            <option $dsa value='A'>A</option>
                            <option $dsb value='B'>B</option>
                            <option $dsc value='C'>C</option>
                            <option $dsd value='D'>D</option>
                        </select>
                    </td>
                    </tr>";
                }
                $resp.="</tbody>";

            }else if($dt[4]==100){ //SI ES NOTAS EXTRAS

                if($esp==7){
                                $resp="<thead><tr>
                                <th><spam>#</spam></th>
                                <th>Estudiante</th>
                                <th><label class='rotate_tx'>Prom PI</label></th>
                                <th><label class='rotate_tx'>Prom PII</label></th>
                                <th><label class='rotate_tx'>Supletorio</label></th>
                                <th><label class='rotate_tx'>Remedial</label></th>
                                <th><label class='rotate_tx'>Ex Gracia</label></th>
                                <th><label class='rotate_tx'>P-Final</label></th>
                                </tr></<thead><tbody>";
                }else{
                                $resp="<thead><tr>
                                <th><spam>#</spam></th>
                                <th>Estudiante</th>
                                <th><label class='rotate_tx'>Prom QI</label></th>
                                <th><label class='rotate_tx'>Prom QII</label></th>
                                <th><label class='rotate_tx'>Supletorio</label></th>
                                <th><label class='rotate_tx'>Remedial</label></th>
                                <th><label class='rotate_tx'>Ex Gracia</label></th>
                                <th><label class='rotate_tx'>P-Final</label></th>
                                </tr></<thead><tbody>";
                            }
                                $x=0;
                                foreach ($lista as $r) {
                                    $x++;
                                    $resp.="<tr>
                                    <td>$x</td>
                                    <td>$r->est_apellidos $r->est_nombres</td>";

                    ////**************PROMEDIO QUIMESTRE 1 ******************//////////////
                                    /////******PROMEDIO BLOQUE 1 **************//////
                                    $ax_dt[0]=$r->mat_id;//Matricula ID
                                    $ax_dt[1]=1;//Periodo o Bloque
                                    $ax_dt[2]=$dt[3];//Materia Cultural
                                    $ax_dt[3]=$dt[5];//Materia Técnica
                                    $prm1=number_format($this->promedio_bloque_persona_materia($ins,$ax_dt),2);
                                    /////******PROMEDIO BLOQUE 2 **************//////
                                    $ax_dt[1]=2;//Periodo o Bloque
                                    $prm2=number_format($this->promedio_bloque_persona_materia($ins,$ax_dt),2);
                                    /////******PROMEDIO BLOQUE 3 **************//////
                                    $ax_dt[1]=3;//Periodo o Bloque
                                    $prm3=number_format($this->promedio_bloque_persona_materia($ins,$ax_dt),2);

                                    $sql_mtr="and mtr_id=$dt[3]";
                                    if($dt[3]==1){
                                        $sql_mtr="and mtr_id=$dt[3] and mtr_tec_id=$dt[5]";
                                    }

                                    if($q1=DB::select("select * from reg_notas where mat_id=$r->mat_id and periodo=7 and ins_id=9 $sql_mtr ")){
                                        $nt=$q1[0]->nota;
                                    }else{
                                        $nt=0;
                                    }

                                     if($esp==7){ //si es BGU
                                            $ptq1 =number_format((($prm1+$prm2)/2*0.80)+($nt*0.2),2);
                                     }else{
                                            $ptq1 =number_format((($prm1+$prm2+$prm3)/3*0.80)+($nt*0.2),2);
                                     }


                    ////**************PROMEDIO QUIMESTRE 2 ******************//////////////
                                    /////******PROMEDIO BLOQUE 2 **************//////
                                    $ax_dt[0]=$r->mat_id;//Matricula ID
                                    $ax_dt[1]=4;//Periodo o Bloque
                                    $ax_dt[2]=$dt[3];//Materia Cultural
                                    $ax_dt[3]=$dt[5];//Materia Técnica
                                    $prm4=number_format($this->promedio_bloque_persona_materia($ins,$ax_dt),2);
                                    /////******PROMEDIO BLOQUE 2 **************//////
                                    $ax_dt[1]=5;//Periodo o Bloque
                                    $prm5=number_format($this->promedio_bloque_persona_materia($ins,$ax_dt),2);
                                    /////******PROMEDIO BLOQUE 3 **************//////
                                    $ax_dt[1]=6;//Periodo o Bloque
                                    $prm6=number_format($this->promedio_bloque_persona_materia($ins,$ax_dt),2);


                                    $sql_mtr="and mtr_id=$dt[3]";
                                    if($dt[3]==1){
                                        $sql_mtr="and mtr_id=$dt[3] and mtr_tec_id=$dt[5]";
                                    }

                                    if($q2=DB::select("select * from reg_notas where mat_id=$r->mat_id and periodo=8 and ins_id=10 $sql_mtr ")){
                                        $nt=$q2[0]->nota;
                                    }else{
                                        $nt=0;
                                    }

                                     if($esp==7){ //si es BGU
                                            $ptq2 =number_format((($prm3+$prm4)/2*0.80)+($nt*0.2),2);
                                     }else{
                                            $ptq2 =number_format((($prm4+$prm5+$prm6)/3*0.80)+($nt*0.2),2);
                                     }



                                    $prmf=number_format(($ptq1+$ptq2)/2,2);
                                    if($notas=DB::select("select * from reg_notas where mat_id=$r->mat_id and periodo=$dt[4] and ins_id=5 and mtr_id=$dt[3] and mtr_tec_id=$dt[5] ")){
                                          $nt=$notas[0]->nota;
                                          $ntid=$notas[0]->id;
                                    }else{
                                          $nt=0;
                                          $ntid=0;
                                    }
                                    if($notas=DB::select("select * from reg_notas where mat_id=$r->mat_id and periodo=$dt[4] and ins_id=6 and mtr_id=$dt[3] and mtr_tec_id=$dt[5] ")){
                                          $ntr=$notas[0]->nota;
                                          $ntidr=$notas[0]->id;
                                    }else{
                                          $ntr=0;
                                          $ntidr=0;
                                    }
                                    if($notas=DB::select("select * from reg_notas where mat_id=$r->mat_id and periodo=$dt[4] and ins_id=7 and mtr_id=$dt[3] and mtr_tec_id=$dt[5] ")){
                                          $ntg=$notas[0]->nota;
                                          $ntidg=$notas[0]->id;
                                    }else{
                                          $ntg=0;
                                          $ntidg=0;
                                    }
                                    if($nt>=7 || $ntr>=7 || $ntg>=7){
                                        $prmf=7.00;
                                    }

                                    $sup="disabled";
                                    $rem="disabled";
                                    $gra="disabled";

                                    if($prmf>=7){
                                        $sup="disabled";
                                        $rem="disabled";
                                        $gra="disabled";
                                    }else if($prmf>=5 && $prmf<7 ){
                                        $sup="";
                                        $rem="disabled";
                                        $gra="disabled";
                                    }else if($prmf>0 && $prmf<5 ){
                                        $sup="disabled";
                                        $rem="";
                                        $gra="disabled";
                                    }

                                    $cls_color=$this->cls_color($ptq1);
                                    $resp.="<td><input class='txt_notas form-control $cls_color' type='text' value='$ptq1' maxlength='5' id='tq1$r->mat_id' disabled /></td>";
                                    $cls_color=$this->cls_color($ptq2);
                                    $resp.="<td><input class='txt_notas form-control $cls_color' type='text' value='$ptq2' maxlength='5' id='tq2$r->mat_id' disabled /></td>";
                                    $cls_color=$this->cls_color($nt);
                                    $cls_colorr=$this->cls_color($ntr);
                                    $cls_colorg=$this->cls_color($ntg);
                                    $resp.="
                                    <td><input class='txt_notas form-control $cls_color' $sup type='text' value='$nt' maxlength='5' id='$r->mat_id&5' onchange='save(this)' lang='$ntid' /></td>
                                    <td><input class='txt_notas form-control $cls_colorr' $rem  type='text' value='$ntr' maxlength='5' id='$r->mat_id&6' onchange='save(this)' lang='$ntidr' /></td>
                                    <td><input class='txt_notas form-control $cls_colorg' $gra type='text' value='$ntg' maxlength='5' id='$r->mat_id&7' onchange='save(this)' lang='$ntidg' /></td>
                                    ";
                                    $cls_color=$this->cls_color($prmf);

                                    $resp.="<td><input class='txt_notas form-control $cls_color' type='text' value='$prmf' maxlength='5' id='tfin$r->mat_id' disabled /></td>";
                                }

                    $resp.="</tr></<tbody>";

            }else if($dt[4]==0){
                //SI ES MATERIAS TÉCNICAS

$hbl="disabled";
//Busco la especialidad por la materia tecnica
$res_mtr=DB::select("select * from materias where id=$dt[5]");
$perm=$this->tecnicos_total();
if($perm->count>0){$hbl="";}
$perm=$this->tecnicos_jornada($dt[0]);
if($perm->count>0){$hbl="";}
$perm=$this->tecnicos_jor_esp($dt[0],$res_mtr[0]->esp_id);
if($perm->count>0){$hbl="";}
$perm=$this->tecnicos_jor_esp_cur($dt[0],$res_mtr[0]->esp_id,$dt[1],$dt[2]);
if($perm->count>0){$hbl="";}
$perm=$this->tecnicos_jor_esp_cur_par($dt[0],$res_mtr[0]->esp_id,$dt[1],$dt[2]);
if($perm->count>0){$hbl="";}
$perm=$this->tecnicos_jor_esp_cur_par_mod($dt[0],$res_mtr[0]->esp_id,$dt[1],$dt[2],$dt[5]);
if($perm->count>0){$hbl="";}
$perm=$this->tecnicos_esp($res_mtr[0]->esp_id);
if($perm->count>0){$hbl="";}

               $resp="<thead><tr><th><spam>#</spam></th><th>Estudiantexxx</th>";
                $x=0;
                foreach ($ins as $i) {
                    $resp.="<th>
                                <label class='rotate_tx'> $i->ins_descripcion </label>
                            </th>";
                }
                 $resp.="
                 <th ><label class='rotate_tx'>Supletorio</label></th>
                 <th ><label class='rotate_tx'>Remedial</label></th>
                 <th ><label class='rotate_tx'>Ex Gracia</label></th>
                 <th ><label class='rotate_tx'>PROMEDIO</label>
                    <input type='hidden' name='count' id='count' value='".count($ins)."' >
                 </th>
                 </tr>
                 </thead><tbody>";
                foreach ($lista as $r) {
                    $x++;
                    $resp.="<tr>
                    <td>$x</td>
                    <td>$r->est_apellidos $r->est_nombres</td>";
                    $prm=0;
                    foreach ($ins as $i) {
                          if($notas=DB::select("select * from reg_notas where mat_id=$r->mat_id and periodo=$dt[4] and ins_id=$i->id and mtr_id=$dt[3] and mtr_tec_id=$dt[5] ")){
                              $nt=$notas[0]->nota;
                              $ntid=$notas[0]->id;
                          }else{
                              $nt=0;
                              $ntid=0;
                          }
                         $prm=($prm+$nt);

                         $cls_color=$this->cls_color($nt);

                        $resp.="<td><input class='txt_notas form-control $cls_color' $hbl tabindex='$i->id'  type='text' value='$nt' maxlength='5' id='$r->mat_id&$i->id' onchange='save(this)' lang='$ntid' /></td>";
                    }
                    $prm=number_format(($prm/(count($ins))),2);

                                    if($notas=DB::select("select * from reg_notas where mat_id=$r->mat_id and periodo=$dt[4] and ins_id=5 and mtr_id=$dt[3] and mtr_tec_id=$dt[5] ")){
                                          $nt=$notas[0]->nota;
                                          $ntid=$notas[0]->id;
                                    }else{
                                          $nt=0;
                                          $ntid=0;
                                    }

                                    if($notas=DB::select("select * from reg_notas where mat_id=$r->mat_id and periodo=$dt[4] and ins_id=6 and mtr_id=$dt[3] and mtr_tec_id=$dt[5] ")){
                                          $ntr=$notas[0]->nota;
                                          $ntidr=$notas[0]->id;
                                    }else{
                                          $ntr=0;
                                          $ntidr=0;
                                    }

                                    if($notas=DB::select("select * from reg_notas where mat_id=$r->mat_id and periodo=$dt[4] and ins_id=7 and mtr_id=$dt[3] and mtr_tec_id=$dt[5] ")){
                                          $ntg=$notas[0]->nota;
                                          $ntidg=$notas[0]->id;
                                    }else{
                                          $ntg=0;
                                          $ntidg=0;
                                    }

                                    if($nt>=7 || $ntr>=7 || $ntg>=7){
                                        $prm=7.00;
                                    }

$hbl_sup="disabled";
$hbl_rem="disabled";
$hbl_gra="disabled";

if($prm<7 && $prm>0){$hbl_sup="";}
if($prm<7 && $prm>0 && $nt>0 && $nt<7){$hbl_rem="";}
if($prm<7 && $prm>0 && $nt>0 && $nt<7 && $ntr>0 && $ntr<7){$hbl_gra="";}
// if($prm<7){$hbl_sup="";}

$cls_color=$this->cls_color($nt);
$cls_colorr=$this->cls_color($ntr);
$cls_colorg=$this->cls_color($ntg);



                    $resp.="
                    <td><input $hbl_sup class='txt_notas form-control $cls_color'  type='text' value='$nt' maxlength='5' id='$r->mat_id&5' onchange='save(this)' lang='$ntid' /></td>
                    <td><input $hbl_rem class='txt_notas form-control $cls_colorr'  type='text' value='$ntr' maxlength='5' id='$r->mat_id&6' onchange='save(this)' lang='$ntidr' /></td>
                    <td><input $hbl_gra class='txt_notas form-control $cls_colorg'  type='text' value='$ntg' maxlength='5' id='$r->mat_id&7' onchange='save(this)' lang='$ntidg' /></td>
                    ";

$cls_color=$this->cls_color($prm);

                    $resp.="<td><input class='txt_notas form-control promedio $cls_color' type='text' value='$prm' maxlength='5' id='tot$r->mat_id' disabled /></td></tr>";
                }



                $resp.="</tbody>";

            }else{
                $resp="<thead><tr><th><spam>#</spam></th><th>ERROR</th>";
            }

            return response()->json($resp);
}

    public function create(Request $req) {
        //dd('ok');
        $dat = $req->all();
        $c=substr($dat['cur_id'],0,1);
        $p=substr($dat['cur_id'],1,2);
        $anl = AnioLectivo::where('anl_selected', '=', 1)->get();
        $anl_id = $anl[0]['id'];
        $usu_id = 1;
        $usu = Usuarios::find($usu_id);
        $jor = array_merge(['0' => 'Seleccione'], Jornadas::orderBy('jor_descripcion', 'ASC')->pluck('jor_descripcion', 'id')->toArray());
        $cur = array_merge(['0' => 'Seleccione'], Cursos::orderBy('id', 'ASC')->pluck('cur_descripcion', 'id')->toarray());
        $mtr = array_merge(['0' => 'Seleccione'], Materias::where('mtr_tipo', 0)
                        ->where('id', '<>', 3)
                        ->orderBy('mtr_descripcion', 'ASC')
                        ->pluck('mtr_descripcion', 'id')->toarray());

        $select = array('matriculas.*',
            'estudiantes.est_cedula',
            'estudiantes.est_apellidos',
            'estudiantes.est_nombres',
            'estudiantes.est_sexo',
            'estudiantes.est_fnac',
            'estudiantes.proc_sector',
            'estudiantes.est_direccion',
            'estudiantes.est_celular',
            'estudiantes.est_email',
            'estudiantes.est_discapacidad',
            'estudiantes.est_porcentaje_disc',
            'estudiantes.rep_cedula',
            'estudiantes.rep_nombres',
            'estudiantes.est_telefono',
            'estudiantes.rep_telefono',
            'estudiantes.rep_mail',
            'estudiantes.rep_parentezco',
            'matriculas.created_at',
            'matriculas.id',
            'especialidades.esp_descripcion',
            'jornadas.jor_descripcion',
            'cursos.cur_descripcion');

        $lista = DB::table('matriculas')
                ->select($select)
                ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                ->where('jor_id', '=', $dat['jor_id'])
                ->where('cur_id', '=', $c)
                ->where('mat_paralelo', '=', $p)
                ->where('esp_id', '<>', 7)
                ->where('esp_id', '<>', 8)
                ->where('mat_estado', '=', 1)
                ->orderBy('estudiantes.est_apellidos', 'ASC')
                ->get();


        $ins = \App\Models\Insumos::all();
        return view('reg_notas.index')
                        ->with('jor', $jor)
                        ->with('mtr', $mtr)
                        ->with('cur', $cur)
                        ->with('lista', $lista)
                        ->with('ins', $ins);
    }

    public function show($op,$jor_cur) {
        $usu = Auth::user();
        $dtjc=explode("&",$jor_cur);
        $jor_id=$dtjc[0];
        $cur_id=$dtjc[1];

        $anl_id = $this->anl;
        $anl_bgu = $this->anl_bgu;

        if ($op == 0) {
            //CURSOS ASIGNADOS
          if($usu->id==22 || $usu->id==86){//Lic Alejandro
                //SUPER ADMINISTRADORES
                $sql_user=" ";
            }else{
                //DOCENTE NORMAL
                $sql_user=" AND a.usu_id=$usu->id";
            }
//AND a.cur_id<>6
            return $dt = DB::select("SELECT a.cur_id,c.cur_descripcion,
                CASE
                WHEN a.esp_id =7  THEN a.paralelo ||'BGU'
                WHEN a.esp_id =8  THEN a.paralelo ||'BSX'
                ELSE a.paralelo
                END AS paralelo,
                a.esp_id
                FROM asg_horario_profesores a
                JOIN cursos c ON a.cur_id=c.id
                WHERE a.mtr_id<>3
                AND a.suc_id=1

                $sql_user
                AND a.jor_id=$jor_id
                AND (a.anl_id=$anl_id OR a.anl_id=$anl_bgu)
                GROUP BY a.cur_id,c.cur_descripcion,a.paralelo,a.jor_id,a.esp_id
                ORDER BY c.cur_descripcion ASC, a.paralelo
                ");


    } else {
        //MATERIAS ASIGNADAS
        $dat=str_split($cur_id);
       if($usu->id==22 || $usu->id==86){//Lic Alejandro
        //SUPER ADMINISTRADORES
           return $dt = DB::select("SELECT a.mtr_id,m.mtr_descripcion FROM asg_horario_profesores a, materias m
            WHERE a.mtr_id=m.id
            and a.mtr_id<>3
            and a.suc_id=1
            and a.jor_id=$jor_id
            and a.anl_id=$anl_id
            group by a.mtr_id,m.mtr_descripcion
            order by m.mtr_descripcion ");
       }else{
        //DOCENTE NORMAL
           return $dt = DB::select("SELECT a.mtr_id,m.mtr_descripcion FROM asg_horario_profesores a, materias m
            WHERE a.mtr_id=m.id
            and a.mtr_id<>3
            and a.suc_id=1
            and a.jor_id=$jor_id
            and (a.anl_id=$anl_id or a.anl_id=$anl_bgu)
            and a.usu_id=$usu->id
            and a.cur_id=$dat[0]
            and a.paralelo='$dat[1]'
            group by a.mtr_id,m.mtr_descripcion
            order by m.mtr_descripcion ");
       }

   }

}



public function elimina_notas_duplicadas_tecnicas() {

            $notas=DB::select("select mat_id,
                periodo,
                ins_id,
                mtr_id,
                mtr_tec_id,
                count(*)
                from reg_notas
                where mtr_id=1
                and   mtr_tec_id<>0
                group by mat_id,
                periodo,
                ins_id,
                mtr_id,
                mtr_tec_id
                having count(*)>1");
        $i=0;
        foreach ($notas as $n) {
            $nt=DB::select("
                select * from reg_notas where mat_id=$n->mat_id
                and periodo=$n->periodo
                and ins_id=$n->ins_id
                and mtr_id=1
                and mtr_tec_id=$n->mtr_tec_id
                order by id asc  ");

            if(count($nt)>1){
                $x=0;
                foreach ($nt as $t) {
                    $x++;
                    if($x==1){
                        DB::select("DELETE FROM reg_notas WHERE id=$t->id");
                        $i++;
                    }
                }
            }
        }

        dd($i.' NOTAS DUPLICADAS TECNICAS');

}

    public function elimina_notas_duplicadas_culturales() {

        $notas=DB::select("select mat_id,
                    periodo,
                    ins_id,
                    mtr_id,
                    mtr_tec_id,
                    count(*)
                     from reg_notas
                     where mtr_id<>1
                     group by mat_id,
                    periodo,
                    ins_id,
                    mtr_id,
                    mtr_tec_id
                    having count(*)>1");
        $i=0;
        foreach ($notas as $n) {
            $nt=DB::select("select * from reg_notas where mat_id=$n->mat_id
                and periodo=$n->periodo
                and ins_id=$n->ins_id
                and mtr_id=$n->mtr_id
                order by id asc  ");
            if(count($nt)>1){
                $x=0;
                foreach ($nt as $t) {
                    $x++;
                    if($x==1){
                        DB::select("DELETE FROM reg_notas WHERE id=$t->id");
                        $i++;
                    }
                }
            }
        }
        dd($i.' NOTAS DUPLICADAS CULTURALES');

    }

    public function corregir_notas() {
/////********ELIMINAR INSUMOS INCORRECTOS****

// DB::select("delete from reg_notas
// where mtr_id=1
// and mtr_tec_id<>0
// and periodo<>7
// and ins_id=9
// ");
// dd('ELIMINAR INSUMOS INCORRECTOS');


////*************PROMEDIO FINAL********////////EXQ1 Y Q2
        // $not=DB::select(" select * from reg_notas
        //     where ins_id=9
        //    and periodo=7
        //    and mtr_id=1
        //    and mtr_tec_id<>0
        //    order by f_modific");

//         foreach ($not as $n) {
//             $est=DB::select("select * from matriculas where id=".$n->mat_id);
//             //dd($est[0]->cur_id);
//             $mat=DB::select("select * from asg_materias_cursos
//                         where anl_id=3
//                         and cur_id=".$est[0]->cur_id."
//                         and mtr_id=$n->mtr_tec_id ");
//             //dd($mat);
//             if($mat[0]->bloques<>6){
//                 //dd('ok');
//                 $ex2=DB::select(" select * from reg_notas
//                                      where ins_id=10
//                                      and periodo=8
//                                      and mtr_id=1
//                                      and mtr_tec_id=$n->mtr_tec_id
//                                      and mat_id=$n->mat_id
//                                      order by f_modific
//                                      ");
//                 if(empty($ex2)){
//                     if(!DB::select("insert into reg_notas (mat_id,
//                         periodo,
//                         ins_id,
//                         mtr_id,
//                         usu_id,
//                         nota,
//                         f_modific,
//                         disciplina,
//                         mtr_tec_id,
//                         estado)values
//                         (
//                         $n->mat_id,8,10,1,
//                         $n->usu_id,
//                         $n->nota,
//                         '$n->f_modific',
//                         '$n->disciplina',
//                         $n->mtr_tec_id,
//                         $n->estado
//                         )
//                         ")){
//                         //dd("Error");
//                     }
//                 }
//             }
//         }
// dd('PROMEDIO FINAL EXQ1 Y EXQ2');

        // $est=DB::select("select id,esp_id,cur_id from matriculas
        //                     where id=4363
        //         ");

        $est=DB::select("select id,esp_id,cur_id from matriculas
                            where anl_id=3
                            and esp_id<>8
                            and mat_estado=1
                ");

        foreach ($est as $e) {
    ///////*****PARA MATERIAS DE 2 BLOQUES*******////////////
            $mtr=DB::select("select am.*,m.mtr_descripcion from asg_materias_cursos am
                join materias m on m.id=am.mtr_id
                where am.anl_id=3
                and am.esp_id=$e->esp_id
                and bloques=2
                and cur_id=$e->cur_id
                order by am.mtr_id ");
                if(count($mtr)>0){
                        foreach ($mtr as $mt){
                            //$ins=[1,3,8];
                            $ins=[1,2,3,4,8,12];
                            foreach ($ins as $in) {
                                    $notas=DB::select("select * from reg_notas where mat_id=$e->id
                                    and mtr_id=1
                                    and mtr_tec_id=$mt->mtr_id
                                    and ins_id=$in
                                    order by periodo,ins_id");
                                $nota_per1=0;
                                $nota_per2=0;
                                foreach ($notas as $n) {

                                    if($n->periodo==1){
                                        $nota_per1=$n->nota;
                                    }else{
                                        if($n->periodo==3 || $n->periodo==5){
                                            DB::select("update reg_notas set nota=$nota_per1 where id=$n->id  ");
                                        }
                                    }

                                    if($n->periodo==2){
                                        $nota_per2=$n->nota;
                                    }else{
                                        if($n->periodo==4 || $n->periodo==6){
                                            DB::select("update reg_notas set nota=$nota_per2 where id=$n->id  ");
                                        }
                                    }

                                }

                            }
                        }
                }

    ////***************///////////***************/////////
            // /////*****PARA MATERIAS DE 1 BLOQUE*******/////////
            // $mtr=DB::select("select am.*,m.mtr_descripcion from asg_materias_cursos am
            //     join materias m on m.id=am.mtr_id
            //     where am.anl_id=3
            //     and am.esp_id=$e->esp_id
            //     and bloques=1
            //     and cur_id=$e->cur_id
            //     order by am.mtr_id ");
            // foreach ($mtr as $mt) {
            //     $ins=[1,2,3,4,8,12];
            //     foreach ($ins as $in) {
            //         $notas=DB::select("select * from reg_notas where mat_id=$e->id
            //             and mtr_id=1
            //             and mtr_tec_id=$mt->mtr_id
            //             and ins_id=$in
            //             order by periodo,ins_id");
            //         $nota_per1=0;
            //         foreach ($notas as $n) {
            //             if($n->periodo==1){
            //                 $nota_per1=$n->nota;
            //             }else{
            //                 DB::select("update reg_notas set nota=$nota_per1 where id=$n->id  ");
            //             }
            //         }
            //     }
            // }

            ////***************///////////***************///////////
        }

dd("MATERIAS DE 2 BLOQUES");

//dd("MATERIAS DE 1 BLOQUES");

//////***************************DUPLICADOS DE INSUMOS**************///////////////////////
        // $datos=DB::select("select mat_id,periodo,ins_id,nota,mtr_tec_id,count(*)
        //                             from reg_notas
        //                             where mtr_id=1
        //                             and periodo=2
        //                             group by mat_id,periodo,ins_id,nota,mtr_tec_id
        //                             having count(*)>1");
        // foreach ($datos as $d){

        //     $dt=DB::select("select * from reg_notas
        //                         where mat_id=$d->mat_id
        //                         and mtr_id=1
        //                         and periodo=2
        //                         and ins_id=$d->ins_id
        //                         and mtr_tec_id=$d->mtr_tec_id ");

        //     DB::select("update reg_notas set periodo=1 where id=".$dt[0]->id);
        // }
//////////************************************/////////////////////////////////////////////////////
//////////****************CORRREGIR PARCIAL 1 AUTOMOTRIZ*/////////////////////////////////////////////////////


// $dto=DB::select("select * from reg_notas2
// where periodo=1
// and mtr_tec_id=90
// order by id
// ");
// //dd(count($dto));
// $x=0;$err=0;
// foreach ($dto as $d) {
//     $x++;
//     $dtn=DB::select("select * from reg_notas where id=$d->id");
// //    dd($d->nota);
//     if($dtn[0]->nota!=$d->nota){
//         $err++;
//         DB::select("update reg_notas set nota=$d->nota where id=$d->id");
//     }
// }
// dd($err);



//////////************************************/////////////////////////////////////////////////////




    }


    public function imprimir_individuales(Request $rq) {
        //dd('ok');
        //$this->elimina_notas_duplicadas_tecnicas();
        //$this->elimina_notas_duplicadas_culturales();
        //$this->corregir_notas();
        $dt=$rq->all();
          // "jor_id" => "1"
          // "esp_id" => "1"
          // "cur_id" => "1"
          // "parc" => "0"
          // "quimestre" => "0"
          // "mtr_id" => "7"
        if($dt['quimestre']=='1' || $dt['quimestre']=='2'){
            $result=$this->reporte_masivos_individuales_quimestrales($dt,$op=10);
            return view('reportes.reporte_general_individual')
            ->with('result',$result);
        }else{

            switch ($dt['quimestre']) {
                case 'B1': $dt['quimestre']=1;break;
                case 'B2': $dt['quimestre']=2;break;
                case 'B3': $dt['quimestre']=3;break;
                case 'B4': $dt['quimestre']=4;break;
                case 'B5': $dt['quimestre']=5;break;
                case 'B6': $dt['quimestre']=6;break;
            }

            $data=$dt['jor_id']."&".$dt['cur_id']."&".$dt['parc']."&".$dt['quimestre']."&".$dt['esp_id']."&0&0&0";
            $result=$this->edit($data,$op=10);
            return $result;
        }

    }

    public function reporte_masivos_individuales_quimestrales($dt,$op=null) {
        set_time_limit(0);
        $jor=$dt['jor_id'];
        $cur=$dt['cur_id'];
        $par=$dt['parc'];
        $qui=$dt['quimestre'];
        $esp=$dt['esp_id'];
        $anl=$this->anl;
        if($esp==7){
            $anl=$this->anl_bgu;
        }
        $d=[$anl,$jor,$esp,$cur,$par,1];
        $AUD = new Auditoria();
        $estudiantes=$AUD->buscador_estudiantes($d);
        $resultado="";
////////////////////**********PARCIALES***********************************/////////////
////el rango de fechas de los parciales para buscar las asistencias
        if($qui==1){
            $p1_aux=1;
            $p2_aux=3;
        }
        if($qui==2){
            $p1_aux=4;
            $p2_aux=6;
        }

        $parciales=DB::select("(SELECT par_finicio FROM parciales WHERE par_id=$p1_aux and anl_id=".$this->anl.")
                                UNION all
                               (SELECT par_ffin FROM parciales WHERE par_id=$p2_aux and anl_id=".$this->anl.") ");

        $fi=$parciales[0]->par_finicio;$ff=$parciales[1]->par_finicio;

/////////////**************************ENCABEZADO*********************/////////////////////
            foreach ($estudiantes as $e) {

                            $materias=DB::select("
                                (SELECT ac.mtr_id,m.mtr_descripcion FROM asg_materias_cursos ac
                                join materias m on ac.mtr_id=m.id
                                where ac.anl_id=$this->anl
                                and ac.esp_id=10
                                and ac.cur_id=$cur
                                and m.mtr_tipo=0
                                order by m.mtr_descripcion )
                                UNION ALL
                                ( SELECT ac.mtr_id,m.mtr_descripcion FROM asg_materias_cursos ac
                                join materias m on ac.mtr_id=m.id
                                where ac.anl_id=$this->anl
                                and ac.esp_id=$e->esp_id
                                and ac.cur_id=$cur
                                and m.mtr_tipo=1
                                and ac.estado=0
                                order by m.mtr_descripcion
                                )
                                ");  //Materias Culturales Y TÉCNICAS

                            $materias_finalizadas=DB::select("
                                SELECT ac.mtr_id,m.mtr_descripcion FROM asg_materias_cursos ac
                                join materias m on ac.mtr_id=m.id
                                where ac.anl_id=$this->anl
                                and ac.esp_id=$e->esp_id
                                and ac.cur_id=$cur
                                and m.mtr_tipo=1
                                and ac.estado=1
                                order by m.mtr_descripcion
                                ");


                            $sql_head="";
                            $tx_head="";
                            $datos="";
                            $n_mat=count($materias);
                            $x=0;
                                foreach ($materias as $m) {
                                $sql_union=" UNION ALL ";
                                $x++;
                                if($x==$n_mat){
                                    $sql_union=" ";
                                }

                                $sql_head.="SELECT concat($m->mtr_id,1) AS mtr UNION ALL
                                            SELECT concat($m->mtr_id,2) AS mtr UNION ALL
                                            SELECT concat($m->mtr_id,3) AS mtr UNION ALL
                                            SELECT concat($m->mtr_id,7) AS mtr $sql_union ";
                                $tx_head.=",pb".$m->mtr_id."1 text, pb".$m->mtr_id."2 text, pb".$m->mtr_id."3 text, pb".$m->mtr_id."7 text  ";
                            }

                                     $sql="SELECT * FROM crosstab('select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id) as estudiante,
                                    CASE
                                    WHEN rn.mtr_id=1 THEN concat(rn.mtr_tec_id,rn.periodo)
                                    WHEN rn.mtr_id<>1 THEN concat(rn.mtr_id,rn.periodo)
                                    END AS mtr_id,
                                    CASE
                                    WHEN count(*)=6 AND rn.periodo<>7  THEN sum(rn.nota)/6
                                    WHEN count(*)<6 AND rn.periodo<>7  THEN sum(rn.nota)/5
                                    ELSE sum(rn.nota)
                                    END AS nota
                                    from matriculas m
                                    join estudiantes e on m.est_id=e.id
                                    left join reg_notas rn on rn.mat_id=m.id
                                    and ( rn.periodo=1 or rn.periodo=2 or rn.periodo=3 or rn.periodo=7 )
                                    where m.id=$e->mat_id
                                    group by e.est_apellidos,e.est_nombres,rn.mtr_id,rn.mtr_tec_id,rn.periodo,m.id
                                    order by estudiante,rn.mtr_tec_id,rn.periodo
                                    '::text,' $sql_head   '::text)
                                crosstab(estudiante text $tx_head  ); ";

                                $datos=DB::select($sql);
                                $datos=$datos[0];

                                $tx_materias="<tr>
                                        <th>#</th>
                                        <th>Materias</th>
                                        <th>P1</th>
                                        <th>P2</th>
                                        <th>P3</th>
                                        <th>EXQ1</th>
                                        <th>PROM Q1</th>
                                </tr>";


                                $tx_mat_notas="";
                                $x=0;
                                $promf=0;
                                foreach ($materias as $m) {
                                    $tx_p1="pb".$m->mtr_id.'1';
                                    $tx_p2="pb".$m->mtr_id.'2';
                                    $tx_p3="pb".$m->mtr_id.'3';
                                    $tx_exq1="pb".$m->mtr_id.'7';

                                    $np1=number_format($datos->$tx_p1,2);
                                    $np2=number_format($datos->$tx_p2,2);
                                    $np3=number_format($datos->$tx_p3,2);
                                    $exq1=number_format($datos->$tx_exq1,2);
                                    $tx_prmq1=(($np1+$np2+$np3)/3)*0.8;
                                    $tx_exq1=$exq1*0.2;
                                    $prmq1=number_format($tx_prmq1+$tx_exq1,2);
                                    $promf+=$prmq1;
                                    if($prmq1=='0.00'){
                                        $prmq1='-';
                                    }else{
                                        $x++;
                                    }

                                    if($np1=='0.00'){$np1='-';}
                                    if($np2=='0.00'){$np2='-';}
                                    if($np3=='0.00'){$np3='-';}
                                    if($exq1=='0.00'){$exq1='-';}

                                    $tx_mat_notas.="<tr>
                                            <td>$x</td>
                                            <td>$m->mtr_descripcion</td>
                                            <td style='text-align:right'>$np1</td>
                                            <td style='text-align:right'>$np2</td>
                                            <td style='text-align:right'>$np3</td>
                                            <td style='text-align:right'>$exq1</td>
                                            <td style='text-align:right'>$prmq1</td>
                                    </tr>";
                                }

                                if($x==0){
                                    $x=1;
                                }

                                $promf=number_format($promf/$x,2);


                                $resultado.="
                                <table border='0' style='' >
                                            <thead>
                                            <tr>
                                            <th colspan='9' style='font-size:16px;'>
                                                    Unidad Educativa Técnica Vida Nueva
                                                    <img style='float:right' src=".asset('img/escudo.png'). "  width='35px' />
                                            </th>
                                            </tr>
                                            <tr>
                                            <th colspan='9'  style='text-align:center' ></th>
                                            </tr>
                                            <tr>
                                            <th colspan='9' style='text-align:left' >
                                            <span>
                                                $datos->estudiante
                                            </span>
                                            </tr>
                                            <tr>
                                            <th colspan='9' style='text-align:left'>
                                            <span>Año Lectivo:</span><span>$this->anl_desc</span>
                                            <span>Jornada:</span><span>$e->jor_descripcion</span>
                                            <span>Curso:</span><span>$e->cur_descripcion</span>
                                            <span>Paralelo:</span><span>$e->mat_paralelo</span>
                                            </th>
                                            </tr>
                                            </thead>

                                        $tx_materias
                                        $tx_mat_notas

                                </table>
                                 ";

                                        $cls_prom='';
                                        if($promf>10 || $promf<0){
                                            $cls_prom=';background:brown ';
                                        }



                                 $resultado.="
                                 <table>
                                     <tr>
                                         <th colspan='8' style='text-align:right' >PROMEDIO: </th>
                                         <th style='font-size:11px;text-align:right $cls_prom '>$promf</th>
                                     </tr>
                                     <tr>
                                         <th colspan='9' >MÓDULOS DE FORMACIÓN TÉCNICA FINALIZADOS</th>
                                     </tr>
                                     <tr>
                                         <th></th>
                                         <th style='text-align:left'>MÓDULO</th>
                                         <th>Q1</th>
                                         <th>Q2</th>
                                         <th>Prm</th>
                                         <th>Sup</th>
                                         <th>Rem</th>
                                         <th>Gra</th>
                                         <th>Fin</th>
                                     </tr>
                                 ";

////////////////////////////////PROMEDIO MATERIA TECNICA FINALIZADAS*******************////////////////////////////
                                            $i=0;$prm_gt=0;
                                        foreach ($materias_finalizadas as $mt) {
                                            $i++;
                                            $prmq1=$this->pquimestre($e->mat_id,$mt->mtr_id,1,$esp,1);
                                            $prmq2=$this->pquimestre($e->mat_id,$mt->mtr_id,2,$esp,1);
                                            // $prmq1=7;
                                            // $prmq2=7;

                                            $prmq=number_format(($prmq1+$prmq2)/2,2);

                                            $supl=DB::select("SELECT nota FROM reg_notas WHERE mat_id=$e->mat_id and periodo=100 and ins_id=5 and mtr_id=1 and mtr_tec_id=$mt->mtr_id");
                                             if(!empty($supl)){
                                                 $supl=number_format($supl[0]->nota,2);
                                             }else{
                                                 $supl='-';
                                             }
                                            $rem=DB::select("SELECT nota FROM reg_notas WHERE mat_id=$e->mat_id and periodo=100 and ins_id=6 and mtr_id=1 and mtr_tec_id=$mt->mtr_id");
                                            if(!empty($rem)){
                                                $rem=number_format($rem[0]->nota,2);
                                            }else{
                                                $rem='-';
                                            }
                                            $gra=DB::select("SELECT nota FROM reg_notas WHERE mat_id=$e->mat_id and periodo=100 and ins_id=7 and mtr_id=1 and mtr_tec_id=$mt->mtr_id");
                                            if(!empty($gra)){
                                                $gra=number_format($gra[0]->nota,2);
                                            }else{
                                                $gra='-';
                                            }

                                            //$promf=$prmq;
                                            if($prmq<7 && $supl!='-'){ ///si ha dado supletorio
                                                if($supl>7){
                                                    $prmq=number_format(7,2);
                                                }
                                            }

                                            if($prmq<7 && $rem!='-'){ ///si ha dado REMEDIAL
                                                if($rem>7){
                                                    $prmq=number_format(7,2);
                                                }
                                            }

                                            if($prmq<7 && $gra!='-'){ ///si ha dado EL DE GRACIA
                                                if($gra>7){
                                                    $prmq=number_format(7,2);
                                                }
                                            }

                                            $prm_gt=$prm_gt+$prmq;

                                            $resultado.="<tr>
                                                            <td>$i</td>
                                                            <td>$mt->mtr_descripcion</td>
                                                            <td style='text-align:right'>$prmq1</td>
                                                            <td style='text-align:right'>$prmq2</td>
                                                            <td style='text-align:right'>$prmq</td>
                                                            <td style='text-align:right'>$supl</td>
                                                            <td style='text-align:right'>$rem</td>
                                                            <td style='text-align:right'>$gra</td>
                                                            <td style='text-align:right'>$prmq</td>
                                                         </tr>";
                                        }

                     //////////////********************ASISTENCIAS*************************************//////////////
                                        $ast=DB::select("SELECT estado,count(*) FROM asistencia
                                                            WHERE mtr_id=3
                                                            AND mat_id=$e->mat_id
                                                            AND fecha BETWEEN '$fi' AND '$ff'
                                                            GROUP BY estado");

                                        $fl=0;$fj=0;$at=0;
                                        foreach ($ast as $a) {
                                            if($a->estado==1){
                                                $fl=$a->count;
                                            }
                                            if($a->estado==2){
                                                $at=$a->count;
                                            }
                                            if($a->estado==3){
                                                $fj=$a->count;
                                            }
                                        }

                     /////********************************COMPORTAMIENTO*********************************/////

                                        $nota_comp1=$this->nota_comportamiento($this->comportamiento_por_pracial($e->mat_id,1),0);
                                        $nota_comp2=$this->nota_comportamiento($this->comportamiento_por_pracial($e->mat_id,2),0);
                                        $nota_comp3=$this->nota_comportamiento($this->comportamiento_por_pracial($e->mat_id,3),0);
                                        $nota_comp_aux=round(($nota_comp1+$nota_comp2+$nota_comp3)/3);
                                        $nota_comp=$this->nota_comportamiento($nota_comp_aux,1);

                    ///////////////////////*********************************************************/////////////////////////
                                        if($i==0){
                                            $i=1;
                                        }

                                        $promf_t=number_format(($prm_gt)/$i,2);
                                        if($promf_t==0){
                                            $promf_t='-';
                                        }
                                        $prom_gen_tot='-';

                                        if($promf_t>0 && $promf>0){
                                            $prom_gen_tot=number_format(($promf_t+$promf)/2,2);

                                        }elseif($promf_t==0){
                                            $prom_gen_tot=$promf;
                                        }elseif($promf==0){
                                            $prom_gen_tot=$promf_t;
                                        }

                                        $resultado.="
                                        <tr>
                                            <th colspan='8' style='text-align:right'>PROMEDIO:</th>
                                            <th>$promf_t</th>
                                        </tr>
                                        <tr>
                                            <th colspan='8' style='text-align:right'>PROMEDIO ACADÉMICO FINAL:</th>
                                            <th>$prom_gen_tot</th>
                                        </tr>

                                        <tr>
                                            <td colspan='9' style='text-align:center;'>
                                                    <span>Comportamiento: <b>$nota_comp</b></span>
                                                    <span style='margin-left:40px'>Faltas Justificadas: <b>$fj</b></span>
                                                    <span style='margin-left:40px'>Faltas Injustificadas: <b>$fl</b></span>
                                                    <span style='margin-left:40px'>Atrasos: <b>$at</b></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan='9' style='text-align:center;'>
                                                    <span style='font-weight:bolder' >DESARROLLO COMPORTAMENTAL </span><br>
                                                    A=Muy Satisfactorio B=Satisfactorio
                                                    C=Poco Satisfactorio
                                                    D=Mejorable E=Insatisfactorio
                                            </td>
                                        </tr>
                                        <tr><th colspan='4'>_______________________</th><th colspan='5'>____________________</th></tr>
                                        <tr><th colspan='4'>RECTOR</th><th colspan='5'>SECRETARÍA</th></tr>
                                        </table> ";

                                        $resultado.="<div class='saltopagina'></div>";
////////////////////////************************************************////////////////////////////////////////////

            }

return $resultado;
/////////////******************************NOTAS****************/////////////////////

    }


    public function nota_comportamiento($nt,$op) {
        if($op==0){
            $nt_val=0;
            if($nt=='A'){$nt_val=5;}
            if($nt=='B'){$nt_val=4;}
            if($nt=='C'){$nt_val=3;}
            if($nt=='D'){$nt_val=2;}
            if($nt=='E'){$nt_val=1;}
            return $nt_val;
        }else{
            $nt_val='-';
            if($nt==5){$nt_val='A';}
            if($nt==4){$nt_val='B';}
            if($nt==3){$nt_val='C';}
            if($nt==2){$nt_val='D';}
            if($nt==1){$nt_val='E';}
            return $nt_val;

        }
    }
    public function comportamiento_por_pracial($mat_id,$parcial) {

                                        $comp=DB::select("SELECT mtr_id,dsc_nota FROM reg_disciplina WHERE mat_id=$mat_id AND dsc_parcial=$parcial order by dsc_nota ");
                                        $vl_comp=0;$cn_comp=0;$nota_comp='';$not_insp=0;$tot_comp=0;
                                        foreach ($comp as $c) {
                                            $cn_comp++;
                                            if($c->mtr_id==3){
                                                if($c->dsc_nota=='A'){$not_insp=5;}
                                                if($c->dsc_nota=='B'){$not_insp=4;}
                                                if($c->dsc_nota=='C'){$not_insp=3;}
                                                if($c->dsc_nota=='D'){$not_insp=2;}
                                                if($c->dsc_nota=='E'){$not_insp=1;}
                                            }else{
                                                if($c->dsc_nota=='A'){$vl_comp+=5;}
                                                if($c->dsc_nota=='B'){$vl_comp+=4;}
                                                if($c->dsc_nota=='C'){$vl_comp+=3;}
                                                if($c->dsc_nota=='D'){$vl_comp+=2;}
                                                if($c->dsc_nota=='E'){$vl_comp+=1;}
                                            }
                                        }

                                        if(($cn_comp-1)==0){
                                            $cn_comp=2;
                                        }

                                        $tot_comp=round(($not_insp*0.3)+(($vl_comp/($cn_comp-1))*0.7));
                                        if($tot_comp==5){$nota_comp='A';}
                                        if($tot_comp==4){$nota_comp='B';}
                                        if($tot_comp==3){$nota_comp='C';}
                                        if($tot_comp==2){$nota_comp='D';}
                                        if($tot_comp==1){$nota_comp='E';}
                    return $nota_comp;

    }


    public function edit($data,$op=null) {
        set_time_limit(0);
        $dt=explode("&",$data);
        $anl=$this->anl;
        if($dt[4]==7){
            $anl=$this->anl_bgu;
        }
        // 0->jornada
        // 1->curso
        // 2->paralelo
        // 3->quimestre
        // 4->esp
        // 5->matricula
        // 6->0
        $jor=DB::select("select * from jornadas where id=$dt[0]");
        $cur=DB::select("select * from cursos where id=$dt[1]");
        $jornada=$jor[0]->jor_descripcion;
        $curso=$cur[0]->cur_descripcion;
        $materias=$this->materiasc_por_curso($dt[1]);

$fi=null;
$ff=null;

        if($dt[3]!='Q1' && $dt[3]!='Q2' ){

            $parciales=DB::select("SELECT * FROM parciales WHERE par_id=$dt[3] and anl_id=".$this->anl);
            $fi=$parciales[0]->par_finicio;$ff=$parciales[0]->par_ffin;

        }


             $select = array('matriculas.*',
                'estudiantes.est_cedula',
                'estudiantes.est_apellidos',
                'estudiantes.est_nombres',
                'especialidades.esp_descripcion',
                'matriculas.esp_id',
                'jornadas.jor_descripcion',
                'cursos.cur_descripcion');

        if($op==null){ //SI ES INDIVIDUAL POR MATRICULA

                $lista = DB::table('matriculas')
                ->select($select)
                ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                ->where('matriculas.id', '=', $dt[5])
                ->orderBy('estudiantes.est_apellidos', 'ASC')
                ->get();
        }else{

            if($dt[4]==10){ /// SI ESPECIALIDAD ES CULTURAL
                $lista = DB::table('matriculas')
                ->select($select)
                ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                ->where('matriculas.anl_id', '=', $anl)
                ->where('matriculas.jor_id', '=', $dt[0])
                ->where('matriculas.cur_id', '=', $dt[1])
                ->where('matriculas.mat_paralelo', '=',$dt[2])
                ->where('matriculas.esp_id', '<>', 7)
                ->where('matriculas.esp_id', '<>', 8)
                ->where('matriculas.mat_estado', '=', 1)
                ->orderBy('estudiantes.est_apellidos', 'ASC')
                //->limit(10)
                ->get();
            }else{

                if($dt[4]==7 || $dt[4]==8 ){ ///SI ES ESPECIALIDAD BGU O BÁSICA FLEXIBLE
                    $lista = DB::table('matriculas')
                    ->select($select)
                    ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                    ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                    ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                    ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                    ->where('matriculas.anl_id', '=', $anl)
                    ->where('matriculas.jor_id', '=', $dt[0])
                    ->where('matriculas.cur_id', '=', $dt[1])
                    ->where('matriculas.mat_paralelo', '=',$dt[2])
                    ->where('matriculas.esp_id', '=', $dt[4])
                    ->where('matriculas.mat_estado', '=', 1)
                    ->orderBy('estudiantes.est_apellidos', 'ASC')
                    ->get();
                }else{ ///ELSE SI ES ESPECIALIDAD TÉCNICA
                    $lista = DB::table('matriculas')
                    ->select($select)
                    ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                    ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                    ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                    ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                    ->where('matriculas.anl_id', '=', $anl)
                    ->where('matriculas.jor_id', '=', $dt[0])
                    ->where('matriculas.cur_id', '=', $dt[1])
                    ->where('matriculas.mat_paralelot', '=',$dt[2])
                    ->where('matriculas.esp_id', '=', $dt[4])
                    ->where('matriculas.mat_estado', '=', 1)
                    ->orderBy('estudiantes.est_apellidos', 'ASC')
                    ->get();
                }
            }

        }

        $c=0;
        $result="";
        $pg=0;

        foreach ($lista as $e) {
            $resp="";$titulo="";$enc="";
            $pg++;
            $c++;

                 $materias=DB::select("select ac.id as ac_id,m.id,ac.esp_id,m.mtr_descripcion
                    from asg_materias_cursos ac,materias m
                    where ac.mtr_id=m.id
                    and ac.anl_id=$this->anl
                    and ac.cur_id=$dt[1]
                    and (ac.esp_id=10 or ac.esp_id=$e->esp_id)
                    and ac.estado=0
                    order by m.mtr_descripcion");

                $mtr_tec=DB::select("select ac.id as ac_id,m.id,ac.esp_id,m.mtr_descripcion
                    from asg_materias_cursos ac, materias m
                    where ac.mtr_id=m.id
                    and ac.anl_id=$this->anl
                    and ac.cur_id=$dt[1]
                    and ac.esp_id=$e->esp_id
                    and ac.estado=1
                    order by m.mtr_descripcion
                    ");

//INICIO/*//*************************/////////
     if($dt[3]!='Q1' && $dt[3]!='Q2'){
         $titulo="REPORTE DE CALIFICACIONES PARCIAL $dt[3] ";

         $ins = DB::select("select * from insumos where tipo='I' order by id");
         $ni=0;
                foreach ($ins as $i) {
                    $ni++;
                    $enc.="<th >".substr($i->ins_descripcion,0,3).$ni."</th>";
                }
                $enc.="<th>PROM</th>";
     }else{

         $titulo=" REPORTE DE CALIFICACIONES $dt[3] QUIMESTRE";
         $enc="                           <th style='width:20px' >QUIMESTRE1</th>
                                           <th style='width:20px' >PARCIAL4</th>
                                           <th style='width:20px' >PARCIAL5</th>
                                           <th style='width:20px' >PARCIAL6</th>
                                           <th style='width:20px' >EX_Q2</th>
                                           <th style='width:20px' >PROM_FINAL</th>";

     }
     $stl_mrg='';
     if($pg==2){
       $stl_mrg='margin-top:20px;';
     }

                                       $resp.="<table border='0' style='$stl_mrg' ><thead>
                                       <tr>
                                           <th colspan='9' style='font-size:16px;'>
                                                    Unidad Educativa Técnica Vida Nueva ($e->id)
                                                    <img style='float:right' src='".asset('img/escudo.png')."'  width='35px' />
                                           </th>
                                       </tr>
                                       <tr>
                                           <th colspan='9' class='t1' style='text-align:center' >$titulo</th>
                                       </tr>
                                       <tr>
                                            <th colspan='9' style='text-align:left' >
                                            <span>$e->est_apellidos $e->est_nombres </span>
                                       </tr>
                                       <tr>
                                       <th colspan='9' style='text-align:left'>
                                       <span>Año Lectivo:</span><span>$this->anl_desc</span>
                                       <span>Jornada:</span><span>$jornada</span>
                                       <span>Curso:</span><span>$curso</span>
                                       <span>Paralelo:</span><span>$dt[2]</span>
                                       </th>
                                       </tr>

                                       <tr><th style='width:10px' >No</th>
                                           <th style='width:auto' >Materias</th>

                                           $enc

                                           </tr>
                                           </thead>
                                           <tbody>";
                                           $x=0;
                                           $prmf=0;
                                           $pm=0;
                                           $c=0;
                                           $prmf_gen=0;
                                        foreach ($materias as $m) {
                                            $x++;
                                            if($dt[3]!='Q1' && $dt[3]!='Q2'){

                                                $sql_materias="and rn.mtr_id=$m->id and rn.mtr_tec_id=0 ";
                                                if($m->esp_id<>10){
                                                    $sql_materias="and rn.mtr_id=1 and rn.mtr_tec_id=$m->id ";
                                                }



                                            $notas=DB::select("
                                                SELECT * FROM crosstab(' select mt.mtr_descripcion || ''&'' || mt.id,rn.ins_id,rn.nota from reg_notas rn
                                                join matriculas m on rn.mat_id=m.id
                                                join materias mt on rn.mtr_id=mt.id
                                                where m.id=$e->id
                                                $sql_materias
                                                and rn.periodo=$dt[3]
                                                order by mt.mtr_descripcion
                                                '::text, 'select id from insumos where tipo=''I'' '::text) crosstab(materia text, i1 text, i2 text, i3 text, i4 text, i5 text, i6 text);
                                                ");

                                            $cls_err="";
                                            $n_ins=$ni;

                                                        if(empty($notas)){
                                                            $i1='-';
                                                            $i2='-';
                                                            $i3='-';
                                                            $i4='-';
                                                            $i5='-';
                                                            $i6='-';
                                                        }else{
                                                            $notas[0]->i1==0?$i1='-':$i1=number_format($notas[0]->i1,2);
                                                            $notas[0]->i2==0?$i2='-':$i2=number_format($notas[0]->i2,2);
                                                            $notas[0]->i3==0?$i3='-':$i3=number_format($notas[0]->i3,2);
                                                            $notas[0]->i4==0?$i4='-':$i4=number_format($notas[0]->i4,2);
                                                            $notas[0]->i5==0?$i5='-':$i5=number_format($notas[0]->i5,2);
                                                            $i6=number_format($notas[0]->i6,2);
                                                            if($i6==0){
                                                                $i6='-';
                                                                $n_ins--;
                                                            }

                                                            if($i1>10 || $i2>10 || $i3>10 || $i4>10 || $i5>10 || $i6>10){
                                                                $cls_err="background:brown";
                                                            }
                                                        }

                                                        $pm=number_format(($i1+$i2+$i3+$i4+$i5+$i6)/$n_ins,2);
                                                        if($pm>0){
                                                            $c++;
                                                            $prmf=$prmf+$pm;
                                                        }
                                                        $resp.="<tr style=' $cls_err'>
                                                        <td >$x</td>
                                                        <td >$m->mtr_descripcion</td>
                                                        <td style='text-align:right' >$i1</td>
                                                        <td style='text-align:right' >$i2</td>
                                                        <td style='text-align:right' >$i3</td>
                                                        <td style='text-align:right' >$i4</td>
                                                        <td style='text-align:right' >$i5</td>
                                                        <td style='text-align:right' >$i6</td>
                                                        <td style='text-align:right' >$pm</td>
                                                        </tr>";

                                            }else{

                                            $prmq1=$this->pquimestre($e->id,$m->id,1,$dt[4]);
                                            $pb1=$this->pbloque($e->id,$m->id,4);
                                            $pb2=$this->pbloque($e->id,$m->id,5);
                                            $pb3=$this->pbloque($e->id,$m->id,6);
                                            $pex1=$this->examen($e->id,$m->id,8);
                                            $prmq2=($prmq1+$this->pquimestre($e->id,$m->id,2,$dt[4]));
                                            if($prmq2>0){
                                                $prmq2=number_format(($prmq2/2),2);
                                            }

                                            $prmf+=$prmq2;
                                            $resp.="<tr><td>$x</td><td>$m->mtr_descripcion </td>
                                                        <td>$prmq1</td>
                                                        <td>$pb1</td>
                                                        <td>$pb2</td>
                                                        <td>$pb3</td>
                                                        <td>$pex1</td>
                                                        <td>$prmq2</td></tr>";

                                            }
                                        }

                                        if($c==0){
                                            $c=1;
                                        }

                                        $prmf=number_format($prmf/$c,2);
                     //////////////********************ASISTENCIAS*************************************//////////////
                                        $ast=DB::select("SELECT estado,count(*) FROM asistencia
                                                            WHERE mtr_id=3
                                                            AND mat_id=$e->id
                                                            AND fecha BETWEEN '$fi' AND '$ff'
                                                            GROUP BY estado");
                                        $fl=0;$fj=0;$at=0;
                                        foreach ($ast as $a) {
                                            if($a->estado==1){
                                                $fl=$a->count;
                                            }
                                            if($a->estado==2){
                                                $at=$a->count;
                                            }
                                            if($a->estado==3){
                                                $fj=$a->count;
                                            }
                                        }
                     /////********************************COMPORTAMIENTO*********************************/////
                                        $comp=DB::select("SELECT mtr_id,dsc_nota FROM reg_disciplina WHERE mat_id=$e->id AND dsc_parcial=3 order by dsc_nota ");
                                        //$comp=DB::select("SELECT mtr_id,dsc_nota FROM reg_disciplina WHERE mat_id=$e->id AND dsc_parcial=$dt[3] order by dsc_nota ");
                                        //dd($comp);
                                        $vl_comp=0;$cn_comp=0;$nota_comp='';$not_insp=0;$tot_comp=0;
                                        foreach ($comp as $c) {
                                            $cn_comp++;
                                            if($c->mtr_id==3){
                                                if($c->dsc_nota=='A'){$not_insp=5;}
                                                if($c->dsc_nota=='B'){$not_insp=4;}
                                                if($c->dsc_nota=='C'){$not_insp=3;}
                                                if($c->dsc_nota=='D'){$not_insp=2;}
                                                if($c->dsc_nota=='E'){$not_insp=1;}
                                            }else{
                                                if($c->dsc_nota=='A'){$vl_comp+=5;}
                                                if($c->dsc_nota=='B'){$vl_comp+=4;}
                                                if($c->dsc_nota=='C'){$vl_comp+=3;}
                                                if($c->dsc_nota=='D'){$vl_comp+=2;}
                                                if($c->dsc_nota=='E'){$vl_comp+=1;}
                                            }
                                        }

                                        if(($cn_comp-1)==0){
                                            $cn_comp=2;
                                        }

                                        $tot_comp=round(($not_insp*0.3)+(($vl_comp/($cn_comp-1))*0.7));
                                        if($tot_comp==5){$nota_comp='A';}
                                        if($tot_comp==4){$nota_comp='B';}
                                        if($tot_comp==3){$nota_comp='C';}
                                        if($tot_comp==2){$nota_comp='D';}
                                        if($tot_comp==1){$nota_comp='E';}

                                        $cls_prom='';
                                        if($prmf>10 || $prmf<0){
                                            $cls_prom=';background:brown ';
                                        }



                                        $resp.="<tr><th colspan='8' style='text-align:right;font-size:11px' >PROMEDIO:</th>
                                                    <th style='font-size:11px;text-align:right $cls_prom '>$prmf</th>
                                                </tr>
                                                <tr>
                                                   <th colspan='9' >MÓDULOS DE FORMACIÓN TÉCNICA FINALIZADOS</th>
                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <th style='text-align:left'>MÓDULO</th>
                                                    <th>Q1</th>
                                                    <th>Q2</th>
                                                    <th>Prm</th>
                                                    <th>Sup</th>
                                                    <th>Rem</th>
                                                    <th>Gra</th>
                                                    <th>Fin</th>
                                                </tr>
                                               ";
////////////////////////////////PROMEDIO MATERIA TECNICA FINALIZADAS*******************////////////////////////////
                                            $i=0;$prm_gt=0;
                                        foreach ($mtr_tec as $mt) {
                                            $i++;
                                            $prmq1=$this->pquimestre($e->id,$mt->id,1,$dt[4],1);
                                            $prmq2=$this->pquimestre($e->id,$mt->id,2,$dt[4],1);
                                            $prmq=number_format(($prmq1+$prmq2)/2,2);

                                            $supl=DB::select("SELECT nota FROM reg_notas WHERE mat_id=$e->id and periodo=100 and ins_id=5 and mtr_id=1 and mtr_tec_id=$mt->id");
                                             if(!empty($supl)){
                                                 $supl=number_format($supl[0]->nota,2);
                                             }else{
                                                 $supl='-';
                                             }
                                            $rem=DB::select("SELECT nota FROM reg_notas WHERE mat_id=$e->id and periodo=100 and ins_id=6 and mtr_id=1 and mtr_tec_id=$mt->id");
                                            if(!empty($rem)){
                                                $rem=number_format($rem[0]->nota,2);
                                            }else{
                                                $rem='-';
                                            }
                                            $gra=DB::select("SELECT nota FROM reg_notas WHERE mat_id=$e->id and periodo=100 and ins_id=7 and mtr_id=1 and mtr_tec_id=$mt->id");
                                            if(!empty($gra)){
                                                $gra=number_format($gra[0]->nota,2);
                                            }else{
                                                $gra='-';
                                            }

                                            $promf=$prmq;
                                            if($promf<7 && $supl!='-'){ ///si ha dado supletorio
                                                if($supl>7){
                                                    $promf=number_format(7,2);
                                                }
                                            }

                                            if($promf<7 && $rem!='-'){ ///si ha dado REMEDIAL
                                                if($rem>7){
                                                    $promf=number_format(7,2);
                                                }
                                            }

                                            if($promf<7 && $gra!='-'){ ///si ha dado EL DE GRACIA
                                                if($gra>7){
                                                    $promf=number_format(7,2);
                                                }
                                            }

                                            $prm_gt=$prm_gt+$promf;

                                            $resp.="<tr>
                                                    <td>$i</td>
                                                    <td>$mt->mtr_descripcion</td>
                                                    <td style='text-align:right'>$prmq1</td>
                                                    <td style='text-align:right'>$prmq2</td>
                                                    <td style='text-align:right'>$prmq</td>
                                                    <td style='text-align:right'>$supl</td>
                                                    <td style='text-align:right'>$rem</td>
                                                    <td style='text-align:right'>$gra</td>
                                                    <td style='text-align:right'>$promf</td>
                                            </tr>";
                                        }

                                        if($i==0){
                                            $prm_gt='-';
                                        }else{
                                            $prm_gt=number_format($prm_gt/$i,2);
                                        }

                                        if($prm_gt=='-'){
                                            $prmf_gen=$prmf;
                                        }else{
                                            $prmf_gen=number_format(($prmf+$prm_gt)/2,2);
                                        }

                                        $resp.="<tr>
                                                    <th colspan='8' style='font-size:11px;text-align:right'>PROMEDIO:</th>
                                                    <th style='font-size:11px;text-align:right'>$prm_gt</th>
                                                </tr>
                                                <tr>
                                                     <th colspan='8' style='text-align:right'>PROMEDIO GENERAL</th>
                                                     <th style='text-align:right'>$prmf_gen</th>
                                                </tr>
                                                ";

////////////////////////************************************************////////////////////////////////////////////

                                        $resp.="</tbody><tfoot style='font-size:7px;' >";
                                        $resp.="
                                        <tr>
                                            <td colspan='9' style='text-align:center;'>
                                                    <span>Comportamiento: <b>$nota_comp</b></span>
                                                    <span style='margin-left:40px'>Faltas Justificadas: <b>$fj</b></span>
                                                    <span style='margin-left:40px'>Faltas Injustificadas: <b>$fl</b></span>
                                                    <span style='margin-left:40px'>Atrasos: <b>$at</b></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan='9' style='font-size:7px;text-align:center;'>
                                                    <span style='font-weight:bolder' >DESARROLLO COMPORTAMENTAL </span><br>
                                                    A=Muy Satisfactorio B=Satisfactorio
                                                    C=Poco Satisfactorio
                                                    D=Mejorable E=Insatisfactorio
                                            </td>
                                        </tr>
                                        <tr><th colspan='4'>_______________________</th><th colspan='5'>____________________</th></tr>
                                        <tr><th colspan='4'>RECTOR</th><th colspan='5'>SECRETARÍA</th></tr>
                                        ";
                                        $resp.="</tfoot></table>";

                                        if($pg==1){
                                            $resp.="<div class='saltopagina'></div>";
                                            $pg=0;
                                        }
                                        $result.=$resp;
    }

    return view('reportes.notas_individuales')
           ->with('resp',$result);

}







public function pquimestre($mat,$mrt,$q,$esp,$tp=0){

    if($q==1){
        $prd1=1;$prd2=2;$prd3=3;$prdx=7;$insx=9;
    }
    if($q==2){
        $prd1=4;$prd2=5;$prd3=6;$prdx=8;$insx=10;
        if($esp==7){
            $prd1=3;$prd2=4;$prd3=6;$prdx=8;$insx=10;
        }
    }

    $sql_mtr="and mtr_id=$mrt ";
    if($tp==1){
        $sql_mtr="and mtr_id=1 and mtr_tec_id=$mrt";
    }

                                    $ins = DB::select("select * from insumos where tipo='I' order by id");

                                    $cnt_ins=count($ins);
                                    if($b1=DB::select("select sum(nota) as nota from reg_notas where mat_id=$mat and periodo=$prd1 $sql_mtr ")){
                                        $aux1=DB::select("select nota from reg_notas where mat_id=$mat and periodo=$prd1 and ins_id=12 $sql_mtr ");
                                        if(empty($aux1)){
                                            $cnt_ins--;
                                        }

                                        $prm1=number_format(($b1[0]->nota)/($cnt_ins),2);

                                    }else{
                                        $prm1=0.00;
                                    }

                                    $cnt_ins=count($ins);
                                    if($b2=DB::select("select sum(nota) as nota from reg_notas where mat_id=$mat and periodo=$prd2 $sql_mtr ")){
                                        $aux2=DB::select("select nota from reg_notas where mat_id=$mat and periodo=$prd2 and ins_id=12 $sql_mtr ");
                                        if(empty($aux2)){
                                            $cnt_ins--;
                                        }
                                        $prm2=number_format(($b2[0]->nota)/($cnt_ins),2);
                                    }else{
                                        $prm2=0.00;
                                    }

                                    if($esp==7){
                                        $prm3=(($prm1+$prm2)/2);
                                    }else{
                                        $cnt_ins=count($ins);
                                        if($b3=DB::select("select sum(nota) as nota from reg_notas where mat_id=$mat and periodo=$prd3 $sql_mtr ")){
                                            $aux3=DB::select("select nota from reg_notas where mat_id=$mat and periodo=$prd3 and ins_id=12 $sql_mtr ");
                                            if(empty($aux3)){
                                                $cnt_ins--;
                                            }
                                            $prm3=number_format(($b3[0]->nota)/($cnt_ins),2);
                                        }else{
                                            $prm3=0.00;
                                        }
                                    }

                                    if($q1=DB::select("select * from reg_notas where mat_id=$mat and periodo=$prdx and ins_id=$insx $sql_mtr  ")){
                                        $nt=$q1[0]->nota;
                                    }else{
                                        $nt=0;
                                    }
                                    return $ptq1 =number_format((($prm1+$prm2+$prm3)/3*0.80)+($nt*0.2),2);

                                          // if($mat==3045 && $mrt==42 && $q==2 ){
                                          //     dd($ptq1);
                                          // }

}

                            public function pbloque($mat,$mrt,$p){
                                $ins = DB::select("select * from insumos where tipo='I' order by id");
                                $materia=DB::select("select * from materias where id=$mrt");

                                $sql_materia="AND mtr_id=$mrt";

                                if($materia[0]->mtr_tipo==1){
                                    $sql_materia="AND mtr_tec_id=$mrt";
                                }

                                $cnt_ins=count($ins);
                                $aux=DB::select("SELECT nota,id FROM reg_notas WHERE mat_id=$mat AND periodo=$p AND ins_id=12 $sql_materia ");
                                if(count($aux)>1){
                                    $c_x=0;
                                    foreach ($aux as $ax) {
                                        if($c_x==0){
                                            //dd($ax->id);
                                            DB::select("DELETE FROM reg_notas where id=$ax->id");
                                        }
                                        $c_x++;
                                    }
                                }
                                if(empty($aux)){
                                    $cnt_ins--;
                                }

                                ///**********NOCHE Y SABADOS SOLO 3 INSUMOS********************/////////
                                $est=DB::select("SELECT jor_id FROM matriculas where id=$mat");
                                $sql_insumo="";
                                if($est[0]->jor_id<>1){
                                    $cnt_ins=3;
                                    $sql_insumo="and ins_id<4";
                                }
                                ///********************************************/////////////////////////

                                if($datos=DB::select("select sum(nota) as nota from reg_notas where mat_id=$mat and periodo=$p $sql_materia $sql_insumo")){
                                //dd($cnt_ins);
                                    $prm=number_format(($datos[0]->nota)/$cnt_ins,2);
                                }else{
                                    $prm=0.00;
                                }

                                return $prm;
                            }
                            public function pg_bloque($per,$mtr,$j,$c,$par){
                                $ins = DB::select("SELECT * FROM insumos WHERE tipo='I' ORDER BY id");
                                $anl=$this->anl;
                                if($datos=DB::select("SELECT sum(n.nota) AS nota FROM reg_notas n
                                    JOIN matriculas m on n.mat_id=m.id
                                    where n.periodo=$per
                                    AND n.mtr_id=$mtr
                                    AND m.anl_id=$anl
                                    AND m.jor_id=$j
                                    AND m.cur_id=$c
                                    AND m.mat_paralelo='$par'
                                    ")){
                                    $prm=number_format(($datos[0]->nota)/count($ins),2);
                                }else{
                                    $prm=0.00;
                                }
                                return $prm;
                            }


                            public function parcial($mat,$mrt,$p,$ins){

                                $materia=DB::select("select * from materias where id=$mrt");
                                $sql_materia="and mtr_id=$mrt";
                                if($materia[0]->mtr_tipo==1){
                                    $sql_materia="and mtr_tec_id=$mrt";
                                }
                                if($datos=DB::select("select nota from reg_notas where mat_id=$mat and periodo=$p and ins_id=$ins $sql_materia ")){
                                    $prm=number_format(($datos[0]->nota),2);
                                }else{
                                    $prm=0.00;
                                }

                                return $prm;
                            }

                            public function prom_mat_tec($mat,$mrt){

                                    $ins = DB::select("select * from insumos where tipo='I' order by id");
                                    if($datos=DB::select("select sum(nota) as nota  from reg_notas where mat_id=$mat and periodo=0 and mtr_tec_id=$mrt ")){
                                        $prm=number_format(($datos[0]->nota)/count($ins),2);
                                    }else{
                                        $prm=0.00;
                                    }

                                    return $prm;
                                }
                                public function prom_mat_tec_ins($mat,$mrt,$ins){
                                    if($datos=DB::select("select sum(nota) as nota  from reg_notas where mat_id=$mat and periodo=0 and mtr_tec_id=$mrt and ins_id=$ins ")){
                                        $prm=number_format(($datos[0]->nota)/count($ins),2);
                                    }else{
                                        $prm=0.00;
                                    }

                                    return $prm;
                                }


public function materiasc_por_curso($cur){
                   return $materias=DB::select("select ac.id as ac_id,m.id,m.mtr_descripcion
                    from asg_materias_cursos ac, materias m
                    where ac.mtr_id=m.id
                    and ac.anl_id=$this->anl
                    and ac.esp_id=10
                    and ac.cur_id=$cur
                    order by m.mtr_descripcion");

}

public function examen($mat,$mrt,$p){
if($p==7){
    $ins=9;
}else{
    $ins=10;
}
                                    if($datos=DB::select("select * from reg_notas where mat_id=$mat and periodo=$p and ins_id=$ins and mtr_id=$mrt ")){
                                        $prm=number_format($datos[0]->nota,2);
                                    }else{
                                        $prm=0.00;
                                    }

                                    return $prm;
}


    public function reporte($data) {
        $dt=explode("&",$data);
        //dd($dt[6]);
  // 0 => "1"
  // 1 => "1"
  // 2 => "A"
  // 3 => "B1"
  // 4 => "Q"
  // 5 => "7"
  // 6 => "0"
        if($dt[6]==0){
                return $this->reporte_notas_cultural($data);
        }else if($dt[6]==1){
            return $this->reporte_notas_tecnicas($data);
        }else if($dt[6]==2){
            return $this->reporte_notas_individual($data);
        }


    }


    public function reporte_notas_parcial($data) {
        //data=$("#jor_id").val()+"&"+$("#cur_id").val()+"&"+$("#parc").val()+"&"+$("#quimestre").val()+"&"+$("#option").val()+"&"+$("#mtr_id").val()+"&"+$("#opt_tipo").val();
        // $dt=explode("&",$data);
        // $jor=$data[0];
        // $cur=$data[1];
        // $par=$data[2];
        // $bl_qm=$data[3];
        // $mtr=$data[5];

          $dt=explode("&",$data);
         $jor=DB::select("select * from jornadas where id=$dt[0]");
         $cur=DB::select("select * from cursos where id=$dt[1]");
         $jornada=$jor[0]->jor_descripcion;
         $curso=$cur[0]->cur_descripcion;
         $materias=$this->materiasc_por_curso($dt[1]);

             $select = array('matriculas.*',
                'estudiantes.est_cedula',
                'estudiantes.est_apellidos',
                'estudiantes.est_nombres',
                'especialidades.esp_descripcion',
                'jornadas.jor_descripcion',
                'cursos.cur_descripcion');


             $lista=DB::select("SELECT * FROM matriculas m
                                JOIN estudiantes e ON m.est_id=e.id
                                WHERE m.anl_id=$this->anl
                                and m.jor_id=$jor
                                and m.cur_id=$cur
                                and m.mat_paralelo='$par'
                                and m.esp_id<>7
                                and m.esp_id<>8
                                and m.mat_estado=1 ");

                 $materias=DB::select("select ac.id as ac_id,m.id,m.mtr_descripcion
                    from asg_materias_cursos ac, materias m
                    where ac.mtr_id=m.id
                    and ac.anl_id=$this->anl
                    and ac.esp_id=10
                    and ac.cur_id=$cur
                    order by m.mtr_descripcion");


    }


    public function reporte_notas_tecnicas($data) {
        $dt=explode("&",$data);
        $jor=DB::select("select * from jornadas where id=$dt[0]");
        $cur=DB::select("select * from cursos where id=$dt[1]");
        $ins = DB::select("select * from insumos where tipo='I' order by id");
        if($dt[5]!='null'){
            $mat=DB::select("select * from materias where id=$dt[5]");
            $materia=$mat[0]->mtr_descripcion;
        }else{
            $mat=[];
            $materia="";
        }
        $esp=DB::select("select * from especialidades where id=$dt[7]");
        $jornada=$jor[0]->jor_descripcion;
        $curso=$cur[0]->cur_descripcion;
        $espe=$esp[0]->esp_descripcion;
        $materias=$this->mtr_tecnicas($dt[7],$dt[1]);

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
                ->where('anl_id', '=', $this->anl)
                ->where('jor_id', '=', $dt[0])
                ->where('cur_id', '=', $dt[1])
                ->where('mat_paralelot', '=',$dt[2])
                ->where('esp_id', '=', $dt[7])
                ->where('mat_estado', '=', 1)
                ->orderBy('estudiantes.est_apellidos', 'ASC')
                ->get();

                                    if($dt[4]=='TO'){ //TODOS LOS MODULOS

                                       $resp="<thead>
                                       <tr>
                                       <th colspan='10' class='t1' >
                                       REPORTE DE NOTAS TECNICAS POR FIGURA PROFESIONAL
                                       </th>
                                       </tr>
                                       <tr>
                                       <th colspan='10' class='t2' ><span>Año Lectivo:</span><span>$this->anl_desc</span> <span>Seccion:</span><span> GUAMANI</span></th>
                                       </tr>
                                       <tr>
                                       <th colspan='10' class='t2'>
                                       <span>Jornada:</span><span>$jornada</span>
                                       <span>Especialidad:</span><span>$espe</span>
                                       <span>Curso:</span><span>$curso</span>
                                       <span>Paralelo:</span><span>$dt[2]</span>
                                       </th>
                                       </tr>
                                       <tr><th style='height:70px;'>No</th><th class='est'>Estudiante</th>
                                       ";
                                        foreach ($materias as $m) {
                                            $resp.="<th colspan='3' ><span class='rotar'>$m->mtr_descripcion</span></th>";
                                        }
                                        $resp.="</tr><tr><th><span ></span></th><th><span></span>";
                                        foreach ($materias as $m) {
                                            $resp.="<th><span>Nota</span></th><th><span>Suple</span></th><th><span>Prom</span></th>";
                                        }

                                        $resp.="</tr></thead><tbody>";
                                        $x=0;
                                        foreach ($lista as $e) {
                                            $x++;
                                            $resp.="<tr><td>$x</td><td>$e->est_apellidos $e->est_nombres</td>";
                                            foreach ($materias as $m) {
                                                 $pmod=$this->prom_mat_tec($e->id,$m->id);
                                                $resp.="<td class='nota' >$pmod</td><td class='nota' >-</td><td class='nota' >-</td>";
                                            }
                                            $resp.="</tr>";
                                        }
                                        $resp.="</tbody>";


                                       }else if($dt[4]=='MO'){ //POR MODULO

                                               $resp="<thead>
                                               <tr>
                                               <th colspan='10' class='t1' >
                                               REPORTE DE NOTAS TECNICAS POR FIGURA PROFESIONAL
                                               </th>
                                               </tr>
                                               <tr>
                                               <th colspan='10' class='t2' ><span>Año Lectivo:</span><span>$this->anl_desc</span> <span>Seccion:</span><span> GUAMANI</span></th>
                                               </tr>
                                               <tr>
                                               <th colspan='10' class='t2'>
                                               <span>Jornada:</span><span>$jornada</span>
                                               <span>Especialidad:</span><span>$espe</span>
                                               <span>Modulo:</span><span>$materia</span>
                                               <span>Curso:</span><span>$curso</span>
                                               <span>Paralelo:</span><span>$dt[2]</span>
                                               </th>
                                               </tr>
                                               <tr><th style='height:70px;'>No</th><th class='est'>Estudiante</th>";
                                                $resp.="</tr><tr><th><span></span></th><th><span></span>";

                                                foreach ($ins as $i) {
                                                    $resp.="<th ><label class='rotar'>$i->ins_descripcion</label></th>";
                                                }


                                                $resp.="<th><span>Prom</span></th><th><span>Suple</span></th><th><span>Prom-Fin</span></th>";
                                                $resp.="</tr></thead><tbody>";
                                                $x=0;
                                                foreach ($lista as $e) {
                                                    $x++;
                                                    $resp.="<tr><td>$x</td><td>$e->est_apellidos $e->est_nombres</td>";
                                                    foreach ($ins as $i) {
                                                        $prm=$this->prom_mat_tec_ins($e->id,$mat[0]->id,$i->id);

                                                        if($prm==0){
                                                            $resp.="<th>-</th>";
                                                        }else{
                                                            if($prm>0 && $prm<7){
                                                                $resp.="<th class='nota_baja'>$prm</th>";
                                                            }else{
                                                                $resp.="<th>$prm</th>";
                                                            }

                                                        }
                                                    }

                                                    $pmod=$this->prom_mat_tec($e->id,$dt[5]);
                                                        $resp.="<td class='nota' >$pmod</td><td class='nota' >-</td><td class='nota' >-</td>";
                                                    $resp.="</tr>";
                                                }
                                                $resp.="</tbody>";


                                       }

                return response()->json($resp);

    }

    public function reporte_notas_cultural($data) {
        set_time_limit(0);
        $dt=explode("&",$data);

        $jor=DB::select("SELECT * FROM jornadas WHERE id=$dt[0]");
        $cur=DB::select("SELECT * FROM cursos WHERE id=$dt[1]");
        $mat=DB::select("SELECT * FROM materias WHERE id=$dt[5]");
        $ins = DB::select("SELECT * FROM insumos WHERE tipo='I' order by id");
        $jornada=$jor[0]->jor_descripcion;
        $curso=$cur[0]->cur_descripcion;
        $materia=$mat[0]->mtr_descripcion;

                    // data=$("#jor_id").val()+    0
                    // "&"+$("#cur_id").val()+     1
                    // "&"+$("#parc").val()+       2
                    // "&"+$("#quimestre").val()+  3
                    // "&"+$("#option").val()+     4
                    // "&"+$("#mtr_id").val()+     5
                    // "&"+$("#opt_tipo").val()+   6
                    // "&"+$("#esp_id").val();     7


        // $AUD=new Auditoria();
         $anl=$this->anl;
         $esp=$dt[7];
         if($esp==7){
             $anl=$this->anl_bgu;
         }
        // $d[1]=$dt[0];
        // $d[2]=$dt[7];
        // $d[3]=$dt[1];
        // $d[4]=$dt[2];
        // $d[5]=1;
        // //dd($d);
        // $lista=$AUD->buscador_estudiantes($d);

        // if($esp=='0' || $esp=='7' || $esp=='8'){//Si es cultural
        //     $mtrc=$dt[5];
        //     $mtrt=0;
        // }else{//Si es BGU
        //     $mtrc=1;
        //     $mtrt=$dt[5];
        // }



             $select = array('matriculas.*',
                'estudiantes.est_cedula',
                'estudiantes.est_apellidos',
                'estudiantes.est_nombres',
                'especialidades.esp_descripcion',
                'jornadas.jor_descripcion',
                'cursos.cur_descripcion');

             if($esp==10){

                $lista = DB::table('matriculas')
                ->select($select)
                ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                ->where('jor_id', '=', $dt[0])
                ->where('cur_id', '=', $dt[1])
                ->where('mat_paralelo', '=',$dt[2])
                ->where('esp_id', '<>', 8)
                ->where('esp_id', '<>', 7)
                ->where('mat_estado', '=', 1)
                ->where('anl_id', '=',$anl)
                ->orderBy('estudiantes.est_apellidos', 'ASC')
                ->get();
             }else{


                if(Auth::user()->id==1){ ///PARA PERSONAS AUTORIZADAS QUE SALGAN TODOS LOS ESTUDIANTES INCLUIDO RETIRADOS (ALEXA SANI)

                $lista = DB::table('matriculas')
                ->select($select)
                ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                ->where('jor_id', '=', $dt[0])
                ->where('cur_id', '=', $dt[1])
                ->where('mat_paralelo', '=',$dt[2])
                ->where('esp_id', '=', $esp)
                ->where('anl_id', '=',$anl)
                ->orderBy('estudiantes.est_apellidos', 'ASC')
                ->get();

                }else{

                $lista = DB::table('matriculas')
                ->select($select)
                ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                ->where('jor_id', '=', $dt[0])
                ->where('cur_id', '=', $dt[1])
                ->where('mat_paralelo', '=',$dt[2])
                ->where('esp_id', '=', $esp)
                ->where('mat_estado', '=', 1)
                ->where('anl_id', '=',$anl)
                ->orderBy('estudiantes.est_apellidos', 'ASC')
                ->get();

                }
             }

                 $materias=DB::select("select ac.id as ac_id,m.id,m.mtr_descripcion
                    from asg_materias_cursos ac, materias m
                    where ac.mtr_id=m.id
                    and ac.anl_id=$this->anl
                    and ac.esp_id=10
                    and ac.cur_id=$dt[1]
                    order by m.mtr_descripcion");


                    if($dt[4]=='Q' ){ //SI EL REPORTE PIDE POR QUIMESTRE

                        if($dt[3]!=1 && $dt[3]!=2 ){ //SI PIDE POR PARCIAL INDIVIDUAL

                            switch ($dt[3]) {
                                case 'B1': $dt[3]=1;break;
                                case 'B2': $dt[3]=2;break;
                                case 'B3': $dt[3]=3;break;
                                case 'B4': $dt[3]=4;break;
                                case 'B5': $dt[3]=5;break;
                                case 'B6': $dt[3]=6;break;
                            }

                         $resp="<thead>
                                       <tr>
                                       <th colspan='12' class='t1' >
                                            REPORTE DE NOTAS $dt[3] BLOQUE
                                       </th>
                                       </tr>
                                       <tr>
                                       <th colspan='12' class='t2' ><span>Año Lectivo:</span><span>$this->anl_desc</span> <span>Seccion:</span><span> GUAMANI</span></th>
                                       </tr>
                                       <tr>
                                       <th colspan='12' class='t2'>
                                       <span>Jornada:</span><span>$jornada</span>
                                       <span>Curso:</span><span>$curso</span>
                                       <span>Paralelo:</span><span>$dt[2]</span>
                                       </th>
                                       </tr>
                                       <tr><th style='height:20px;'>No</th><th class='est'>Estudiante</th>
                                       ";
                                       foreach ($materias as $m) {
                                        $resp.="<th ><span class='rotar'>$m->mtr_descripcion</span></th>";
                                        }

                                        $resp.="<th ><span class='rotar'>PROMEDIO</span></th>";

                                    $x=0;
                                    foreach ($lista as $e) {
                                        $x++;
                                        $data=$dt[0]."&".$dt[1]."&".$dt[2]."&".$dt[3]."&"."0&".$e->id."&0&0";
                                        $resp.="<tr><td class='tx_numero'>$x</td>
                                        <td class='th_estudiante' >
                                        <a href='". route('regNotas.edit',$data) ."'  target='_blank' class='rpt_ind'>
                                            $e->est_apellidos $e->est_nombres
                                        </a>
                                        </td>";
                                        $cn=0;$prmb=0;
                                        $cls_nota='';
                                        foreach ($materias as $m) {
                                            $pb=$this->pbloque($e->id,$m->id,$dt[3]);
                                            $prmb+=$pb;
                                            if($pb=='0'){
                                                $resp.="<td class='nota' ></td>";
                                            }else{
                                                $cn++;
                                                if($pb<7){
                                                    $cls_nota='nota_baja';
                                                }else{
                                                    $cls_nota='';
                                                }
                                                $resp.="<td class='nota $cls_nota' >$pb</td>";
                                            }
                                        }
                                        if($cn==0){
                                            $cn=1;
                                        }
                                        $prmb=number_format(($prmb/$cn),2);
                                        $resp.="<td class='nota $cls_nota' >$prmb</td> </tr>";
                                    }
                                    $resp.="</tbody><tfoot>
                                                <tr><td colspan='2'>Promedio</td>";
                                    ///* PROMEDIOS**///
                                    $prg=0;$c=1;
                                    foreach ($materias as $m) {
                                        if($x==0){
                                            $x=1;
                                        }
                                        $pgpm=number_format(($this->pg_bloque($dt[3],$m->id,$dt[0],$dt[1],$dt[2])/$x),2);
                                        $prg+=$pgpm;$c++;

                                                if($pgpm<7){
                                                    $cls_nota='nota_baja';
                                                }else{
                                                    $cls_nota='';
                                                }

                                        $resp.="<td style='font-weight:bold;' class='nota $cls_nota'>$pgpm</td>";

                                    }
                                    $prg=number_format(($prg/$c),2);
                                                if($prg<7){
                                                    $cls_nota='nota_baja';
                                                }else{
                                                    $cls_nota='';
                                                }
                                    $resp.="<td style='font-weight:bold;' class='nota $cls_nota' >$prg</td></tr></tfoot>";


                                       return response()->json($resp);

                        }else{
                         $resp="<thead>
                                       <tr>
                                       <th colspan='30' class='t1' >
                                            REPORTE DE NOTAS $dt[3] QUIMESTRE
                                       </th>
                                       </tr>
                                       <tr>
                                       <th colspan='30' class='t2' ><span>Año Lectivo:</span><span>$this->anl_desc</span> <span>Seccion:</span><span> GUAMANI</span></th>
                                       </tr>
                                       <tr>
                                       <th colspan='30' class='t2'>
                                       <span>Jornada:</span><span>$jornada</span>
                                       <span>Curso:</span><span>$curso</span>
                                       <span>Paralelo:</span><span>$dt[2]</span>
                                       </th>
                                       </tr>
                                       <tr class='enc_titulo'><th class='num' >No</th><th class='est'>Estudiantex</th>
                                       ";
                                       foreach ($materias as $m) {
                                        $resp.="<th class='enc_materias' colspan='2' ><span class=''>$m->mtr_descripcion</span></th>";
                                        }
                                    $resp.="<th><span class=''>Observaciones</span></th> </tr></thead><tbody>";
                                    $x=0;
                                    foreach ($lista as $e) {
                                        $x++;
                                        $data=$dt[0]."&".$dt[1]."&".$dt[2]."&".$dt[3]."&".$esp."&".$e->id."&0&1";

                                        $resp.="<tr><td class='tx_numero'>$x</td>
                                        <td class='th_estudiante' >
                                                    <a href='". route('regNotas.edit',$data) ."'  target='_blank' class='rpt_ind'>
                                                    $e->est_apellidos $e->est_nombres
                                                    </a>
                                        </td>";
                                        $obs_gen='APROBADO';
                                        foreach ($materias as $m) {
                                            $pq1=0;
                                             if($dt[3]==1){
                                                 $pq1=$this->pquimestre($e->id,$m->id,$dt[3],$esp);
                                             }
                                             if($dt[3]==2){
                                                 $pq1=($this->pquimestre($e->id,$m->id,1,$esp))+($this->pquimestre($e->id,$m->id,2,$esp));
                                                 if($pq1>0){
                                                     $pq1=number_format(($pq1/2),2);
                                                 }
                                             }

                                            if($pq1=='0'){
                                                $resp.="<td class='nota' >-</td><td class='nota' >-</td>";
                                                $obs_gen='SUSPENSO';
                                            }else{
                                                $cls_obs='';
                                                $obs='';
                                                if($pq1<7){
                                                    $obs_gen='SUSPENSO';
                                                    $cls_nota='nota_baja';
                                                    if($pq1>=5){
                                                        $obs="S";
                                                        $cls_obs='bg-green';
                                                    }else{
                                                        $obs="R";
                                                        $cls_obs='bg-red';
                                                    }
                                                }else{
                                                    $cls_nota='';
                                                }
                                                $resp.="<td class='nota $cls_nota '>$pq1</td><td class='nota $cls_obs'>$obs</td>";
                                            }
                                        }

                                        if($e->mat_estado<>1){
                                            $obs_gen=$e->fecha_accion;
                                        }

                                        $resp.="<td>$obs_gen</td></tr>";
                                    }
                                    $resp.="</tbody>";

                                }

                        }else if($dt[4]=='P'){ //SI PIDE POR PARCIALES

                                   $resp="<thead>
                                   <tr>
                                   <th colspan='36' class='t1' >
                                        REPORTE DE NOTAS POR PARCIAL
                                   </th>
                                   </tr>
                                   <tr>
                                   <th colspan='36' class='t2' ><span>Año Lectivo:</span><span>$this->anl_desc</span> <span>Seccion:</span><span> GUAMANI</span></th>
                                   </tr>
                                   <tr>
                                   <th colspan='36' class='t2'>
                                   <span>Jornada:</span><span>$jornada</span>
                                   <span>Curso:</span><span>$curso</span>
                                   <span>Paralelo:</span><span>$dt[2]</span>
                                   </th>
                                   </tr>
                                   <tr><th style='height:70px;'>No</th><th class='est'>Estudiante</th>
                                   ";
                                   foreach ($materias as $m) {
                                    $resp.="<th colspan='3' ><span class='rotar'  >$m->mtr_descripcion</span></th>";
                                   }
                                $resp.="</tr><tr><th>...</th><th>...</th>";

                                foreach ($materias as $m) {
                                    $resp.="<th>P1</th><th>P2</th><th>P3</th>";
                                }

                                $resp.="</tr></thead><tbody>";
                                $x=0;
                                foreach ($lista as $e) {
                                    $x++;
                                    $resp.="<tr><td>$x</td><td>$e->est_apellidos $e->est_nombres</td>";
                                    foreach ($materias as $m) {
                                        $pb1=$this->pbloque($e->id,$m->id,1);
                                        $pb2=$this->pbloque($e->id,$m->id,2);
                                        $pb3=$this->pbloque($e->id,$m->id,3);
                                        $cls_notab1='';
                                        $cls_notab2='';
                                        $cls_notab3='';
                                        if($pb1=='0'){$pb1='';}else{if($pb1<7){$cls_notab1='nota_baja';}}
                                        if($pb2=='0'){$pb2='';}else{if($pb2<7){$cls_notab2='nota_baja';}}
                                        if($pb3=='0'){$pb3='';}else{if($pb3<7){$cls_notab3='nota_baja';}}
                                        $resp.="<td class='nota $cls_notab1' >$pb1</td><td class='nota $cls_notab2' >$pb2</td><td class='nota $cls_notab3' >$pb3</td>";
                                    }
                                    $resp.="</tr>";
                                }
                                $resp.="</tbody>";

                    }else if($dt[4]=='M'){ //POR  MATERIA

                               $resp="<thead>
                               <tr><th colspan='36' class='t1' >REPORTE DE NOTAS POR MATERIA</th></tr>
                               <tr><th colspan='36' class='t2' ><span>Año Lectivo:</span><span>$this->anl_desc</span><span>Seccion:</span><span> GUAMANI</span></th></tr>
                               <tr>
                               <th colspan='36' class='t2'>
                               <span>Jornada:</span><span>$jornada</span>
                               <span>Curso:</span><span>$curso</span>
                               <span>Paralelo:</span><span>$dt[2]</span>
                               <span>Materia:</span><span>$materia</span>
                               </th>
                               </tr>
                               <tr><th style='height:70px;'>No</th><th class='est'>Estudiante</th>";
                        $resp.="<th><span class='rotar' >Prom Bloque 1</span></th>
                                <th><span class='rotar' >Prom Bloque 2</span></th>
                                <th><span class='rotar' >Prom Bloque 3</span></th>
                                <th><span class='rotar' >Exam Quimestre 1</span></th>
                                <th><span class='rotar' >Prom Quimestre 1</span></th>
                                ";
                                $resp.="</tr></thead><tbody>";

                                $x=0;
                                foreach ($lista as $e) {
                                    $x++;
                                    $resp.="<tr><td>$x</td><td>$e->est_apellidos $e->est_nombres</td>";

                                        $pb1=$this->pbloque($e->id,$dt[5],1);
                                        $pb2=$this->pbloque($e->id,$dt[5],2);
                                        $pb3=$this->pbloque($e->id,$dt[5],3);
                                        $pex1=$this->examen($e->id,$dt[5],7);
                                        $prmq1=$this->pquimestre($e->id,$dt[5],1);

                                        $cls_notab1='';
                                        $cls_notab2='';
                                        $cls_notab3='';
                                        $cls_notaex1='';
                                        $cls_notapq1='';

                                        if($pb1=='0'){$pb1='';}else{if($pb1<7){$cls_notab1='nota_baja';}}
                                        if($pb2=='0'){$pb2='';}else{if($pb2<7){$cls_notab2='nota_baja';}}
                                        if($pb3=='0'){$pb3='';}else{if($pb3<7){$cls_notab3='nota_baja';}}
                                        if($pex1=='0'){$pex1='';}else{if($pex1<7){$cls_notaex1='nota_baja';}}
                                        if($prmq1=='0'){$prmq1='';}else{if($prmq1<7){$cls_notapq1='nota_baja';}}

                                        $resp.="<td class='nota $cls_notab1' >$pb1</td><td class='nota $cls_notab2' >$pb2</td><td class='nota $cls_notab3' >$pb3</td><td class='nota $cls_notaex1' >$pex1</td><td class='nota $cls_notapq1' >$prmq1</td>";
                                    $resp.="</tr>";
                                }
                                $resp.="</tbody>";


                    }

                return response()->json($resp);

    }


    public function rep_ntas() {

        $jor=Jornadas::orderBy("jor_descripcion","ASC")->pluck('jor_descripcion','id');
        $cur=Cursos::orderBy("id","ASC")->pluck('cur_descripcion','id');
        $mtr=$this->materias_c();
        $mtrt=array();
        $esp=Especialidades::orderBy("id","ASC")->pluck('esp_descripcion','id');
        return view('reportes.rep_notas')->with('jor',$jor)->with('cur',$cur)->with('mtr',$mtr)->with('esp',$esp)->with('mtrt',$mtrt);

    }

    public function load_mat_tec($dt) {
        $dat=explode("&",$dt);
        $mtr=$this->mtr_tecnicas($dat[0],$dat[1]);
        $resp="";
        foreach ($mtr as $m) {
            $resp.="<option value='$m->id'>$m->mtr_descripcion</option>";
        }
        return response()->json($resp);

    }


    public function excel(Request $req){
        $dt=$req->all();
                 if($dt['op']=='0'){
                                Excel::create('Reporte', function($excel) use($dt) {
                                    $excel->sheet('Lista', function($sheet) use($dt) {

                                        // $sheet->setColumnFormat(array(
                                        //     // 'C4:AZ100' => '0.00',
                                        // ));
                                        // $sheet->cells('C4:AZ4', function($cells) {
                                        //     // $cells->setTextRotation(-90);
                                        // });
                                        // $sheet->cells('B5:B50', function($cells) {
                                        //     // $cells->setTextRotation(-90);
                                        // });

                                        $sheet->loadView("reportes.juntasq1")->with('dtx',$dt['datos']);

                                    });
                                })->export('xls');

                }elseif($dt['op']=='1'){

                    $resp='';

                        //$resp.="<table >$dt[datos]</table>";


                         $pdf=PDF::loadHTML($resp)->setPaper('a3', 'landscape');
                         return $pdf->stream();
                }else{
//dd('okk');
                    return view('reportes.juntasq1')
                    ->with('dt',$dt['datos'])
                    ;
                }

    }

public function materias_c(){
        return $mtr=Materias::where('esp_id','=',10)->where('id','>',3)->orderBy("id","ASC")->pluck('mtr_descripcion','id');

}

    /**
     * Update the specified RegNotas in storage.
     *
     * @param  int              $id
     * @param UpdateRegNotasRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRegNotasRequest $request) {
        // $regNotas = $this->regNotasRepository->findWithoutFail($id);
        // if (empty($regNotas)) {
        //     Flash::error('Reg Notas not found');

        //     return redirect(route('regNotas.index'));
        // }

        // $regNotas = $this->regNotasRepository->update($request->all(), $id);
        //                         $datos = implode("-", array_flatten($regNotas['attributes']));
        //                         $aud= new Auditoria();
        //                         $data=["mod"=>"RegNotas","acc"=>"Modificar","dat"=>$datos,"doc"=>"NA"];
        //                         $aud->save_adt($data);

        // Flash::success('Reg Notas updated successfully.');

        // return redirect(route('regNotas.index'));
    }

    /**
     * Remove the specified RegNotas from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id) {
        $regNotas = $this->regNotasRepository->findWithoutFail($id);

        if (empty($regNotas)) {
            Flash::error('Reg Notas not found');

            return redirect(route('regNotas.index'));
        }

        $this->regNotasRepository->delete($id);
        $datos = implode("-", array_flatten($regNotas['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"RegNotas","acc"=>"Eliminar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);

        Flash::success('Reg Notas deleted successfully.');

        return redirect(route('regNotas.index'));
    }


    public function descarga_archivo(Request $req){
        $dt=$req->all();
        $doc=Auth::user();
        return view('reg_notas.imprimible')
        ->with('dt',$dt['inp_datos'])
        ->with('doc',$doc)
        ;
    }


    public function rep_ingreso_notas(){

        $jor=Jornadas::orderBy('id','ASC')->pluck("jor_descripcion","id");
        $esp=Especialidades::pluck("esp_descripcion","id");
        $cur=Cursos::orderBy('id')->get();
        $mtrc=Materias::orderBy('mtr_descripcion','ASC')
        ->where('id','<>',1)
        ->where('id','<>',2)
        ->where('id','<>',3)
        ->where('mtr_tipo','=',0)
        ->pluck('mtr_descripcion','id');

        $mtrt=[];
        return view('reg_notas.reporte_ingreso')
        ->with('jor',$jor)
        ->with('esp',$esp)
        ->with('cur',$cur)
        ->with('materiac',$mtrc)
        ->with('materiat',$mtrt)
        ;
    }


    public function reporte_ingreso_general(Request $req){
        $dt=$req->all();
        $cur=Cursos::all();
        $resp="";
        $ins=DB::select("select * from insumos where tipo='I' ");
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
                        foreach ($ins as $in) {
                            $cl=null;
                            $prom=$this->promedio_ingreso_insumos($in->id,$c->id,$paralelo,$esp,$dt['jor'],$dt['mtr'],$dt['parcial']);
                                $vl_prom='';
                                $cl='';
                            if($prom[2]>0){//si existen estudiantes

                                if($prom[0]==0){
                                    $vl_prom=0;
                                    $cl=' cursos faltantes text-danger';
                                }else{
                                    if($prom[1]==1){ //si existe novedads
                                        $cl=' cursos bg-success novedades  ';
                                    }else{
                                        $cl=' cursos bg-success ';
                                    }
                                    if($prom[0]>0 && $prom[0]<5){
                                        $cl.=" menor5";
                                    }
                                    if($prom[0]>=5 && $prom[0]<7){
                                        $cl.=" mayor5";
                                    }
                                    if($prom[0]>=7){
                                        $cl.=" mayor7";
                                    }
                                        $vl_prom="<form action='ver_notas_reporte' target='_blank' class='frm_ver_insumos' method='POST' >".csrf_field()."
                                                        <input type='hidden' name='jor_id' value='$dt[jor]' >
                                                        <input type='hidden' name='esp_id' value='$esp' >
                                                        <input type='hidden' name='cur_id' value='$c->id' >
                                                        <input type='hidden' name='par_id' value='$paralelo' >
                                                        <input type='hidden' name='mtr_id' value='$dt[mtr]' >
                                                        <input type='hidden' name='parcial' value='$dt[parcial]' >
                                                        <label class='btn_ver_insumos'>".number_format($prom[0],2)."</label>
                                        </form>";

                                }

                            }

                            // if($prom[0]==0){
                            //     $vl_prom='-';
                            //     $cl='bg-info';
                            // }else{
                            //     if($prom[1]==1){
                            //         $cl='text-red';
                            //     }else{
                            //         $cl='bg-info';
                            //     }
                            //     $vl_prom="<form action='ver_notas_reporte' target='_blank' class='frm_ver_insumos' method='POST' >".csrf_field()."
                            //                 <input type='hidden' name='jor_id' value='$dt[jor]' >
                            //                 <input type='hidden' name='esp_id' value='$esp' >
                            //                 <input type='hidden' name='cur_id' value='$c->id' >
                            //                 <input type='hidden' name='par_id' value='$paralelo' >
                            //                 <input type='hidden' name='mtr_id' value='$dt[mtr]' >
                            //                 <input type='hidden' name='parcial' value='$dt[parcial]' >
                            //                 <label class='btn_ver_insumos'>".number_format($prom[0],2)."</label>
                            //     </form>";
                            // }

                           $resp.="<td class='$cl' >$vl_prom</td>";
                        }

                        $paralelo++;
                    }
                $resp.="</tr>";
            }
        $resp.="";
        return response()->json($resp);
    }

    public function promedio_ingreso_insumos($ins,$cur,$paralelo,$esp,$jor,$mtr,$parcial){
//    $prom=$this->promedio_ingreso_insumos($in->id,$c->id,$paralelo,$esp,$dt['jor'],$dt['mtr'],$dt['parcial']);
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

        if($esp=='0' || $esp=='7' || $esp=='8'){//Si es cultural
            $mtrc=$mtr;
            $mtrt=0;
        }else{//Si es BGU
            $mtrc=1;
            $mtrt=$mtr;
        }

//dd($mtrc.' '.$mtrt);

        $n=0;
        $vl=0;//Variable para registrar que hay nota vácia
        $ne=count($est);
        foreach ($est as $e) {

            $not=DB::select("select sum(nota) nota from reg_notas
               where mat_id=$e->mat_id
               and periodo=$parcial
               and mtr_id=$mtrc
               and mtr_tec_id=$mtrt
               and ins_id=$ins ");
            if($not[0]->nota==0){
                $vl=1;
            }
            $n=$n+$not[0]->nota;
        }

        if($ne>0){
             return [($n/$ne),$vl,$ne];
        }else{
            return [0,$vl,$ne];
        }

    }

    public function busca_materia_especialidad(Request $req){
        $dt=$req->all();
        $anl=$this->anl;
        $resp="";
        if($dt['esp']==7 || $dt['esp']==8){
            $dt['esp']=10;
        }
        if($dt['esp']==10){
            $mtr=DB::select("SELECT id,'' as nivel,mtr_descripcion FROM materias WHERE esp_id=10 AND id<>1 AND id<>2 AND id<>3  ORDER BY mtr_descripcion");
        }else{
            $mtr=DB::select("(SELECT m.id,'Basica' as nivel,m.mtr_descripcion FROM
                asg_materias_cursos am
                join materias m on am.mtr_id=m.id
                WHERE am.esp_id=$dt[esp]
                and am.anl_id=$anl
                and (am.cur_id=1 or am.cur_id=2 or am.cur_id=3)
                group by m.id,m.mtr_descripcion )
                UNION
                (SELECT m.id,'Bachillerato' as nivel,m.mtr_descripcion FROM
                asg_materias_cursos am
                join materias m on am.mtr_id=m.id
                WHERE am.esp_id=$dt[esp]
                and am.anl_id=$anl
                and (am.cur_id=4 or am.cur_id=5 or am.cur_id=6)
                group by m.id,m.mtr_descripcion )
                order by nivel desc,mtr_descripcion asc
                ");
        }
        foreach ($mtr as $m) {
            $resp.="<option value='$m->id'>$m->nivel => $m->mtr_descripcion</option>";
        }
        return response()->json($resp);
    }

    public function ver_notas_reporte(Request $req){
        $d=$req->all();
        //dd($d);
        $anl=$this->anl;
        $jor=$d['jor_id'];
        $esp=$d['esp_id'];
        if($esp==7){
            $anl=$this->anl_bgu;
        }
        $cur=$d['cur_id'];
        $par=$d['par_id'];
        $estado=1;

        $mtr=$d['mtr_id'];
        $parcial=$d['parcial'];


        if($esp=='0'){
            $sql_esp=" AND m.esp_id<>7 AND m.esp_id<>8";
            $mtrc=$mtr;
            $mtrt=0;
        }else{
            $sql_esp=" AND m.esp_id=$esp";
            if($esp=='7' || $esp=='8'){
                $mtrc=$mtr;
                $mtrt=0;
            }else{
                $mtrc=1;
                $mtrt=$mtr;
            }
        }

        if($esp=='0' || $esp=='7' || $esp=='8'){
            $sql_par=" AND m.mat_paralelo=''$par'' ";
        }else{
            $sql_par=" AND m.mat_paralelot=''$par'' ";
        }

//dd($mtrc.' '.$mtrt);
//dd($sql_par.' '.$sql_esp);

$notas=DB::select("
            SELECT *
            FROM crosstab('select e.est_apellidos || '' '' || e.est_nombres,rg.ins_id,rg.nota from matriculas m
                join estudiantes e on e.id=m.est_id
                join reg_notas rg on rg.mat_id=m.id
                where m.anl_id=$anl
                and m.jor_id=$jor
                and m.cur_id=$cur

                $sql_par

                $sql_esp

                and m.mat_estado=$estado
                and rg.periodo=$parcial
                and rg.mtr_id=$mtrc
                and rg.mtr_tec_id=$mtrt
                order by e.est_apellidos,rg.ins_id
            '::text, 'select id from insumos where tipo=''I'' '::text) crosstab(est text, i1 text, i2 text, i3 text, i4 text, i5 text, i6 text);
    ");

//dd($notas);
        return view('reg_notas.ver_insumos')
        ->with('notas',$notas);
        ;

    }

public function administrar_notas(){
//Session::get('anl_id');
         $estudiantes = Estudiantes::
        join('matriculas', 'matriculas.est_id', '=', 'estudiantes.id')
        ->where('matriculas.anl_id', '=', Session::get('anl_id'))
        ->where('matriculas.mat_estado', '=', 1)
        ->select('estudiantes.est_apellidos','estudiantes.est_nombres','matriculas.id')
        ->orderBy('estudiantes.est_apellidos')
        ->get()->pluck('full_name', 'id');

        $materias=Materias::orderBy('mtr_descripcion','ASC')->pluck('mtr_descripcion','id');
    return view('reg_notas.administrar_notas')
    ->with('estudiantes',$estudiantes)
    ->with('materias',$materias)
    ;
}

public function busca_notas_generales(Request $req){
    $dt=$req->all();
    $matid=$dt['matid'];
    $mtrid=$dt['mtrid'];
    $parcial=$dt['par'];
    $est=DB::select("select * from matriculas m join reg_notas rg on m.id=rg.mat_id where m.id=$matid and rg.mtr_id=$mtrid and rg.periodo=$parcial");
    $resp="<tr>
                <th class='text-left bg-primary' >Insumo</th>
                <th class='text-left bg-primary' >Nota</th>
          </tr>";
    foreach ($est as $e) {
        $resp.="<tr>
                <td style='width:150px'>Insumo $e->ins_id</td>
                <td>
                <input style='text-align:right;width:100px' type='text' value='$e->nota' class='form-control' />
                </td>
                </tr>";
    }
    $resp.="<tr><td><i class='btn btn-primary'>Guardar</i></td></tr>";
    return response()->json($resp);
}

public function reporte_insumos(Request $req){
    $dt=$req->all();
    //dd($dt);
      // "jor" => "1"
      // "esp" => "10"
      // "cur" => "1"
      // "par" => "A"
      // "blq" => "1"
      // "ins" => "1"
if($dt['tipo']==0){

$ADT=new Auditoria();
        $anl=$this->anl;
        $jor=$dt['jor'];
        $esp=$dt['esp'];
        $aux_esp=10;
        $mtr_tp=0;
        if($esp==7){
            $anl=$this->anl_bgu;
        }else if($esp==10){
            $esp=0;
        }else{
            $aux_esp=$esp;
            $mtr_tp=1;
        }

        $cur=$dt['cur'];
        $par=$dt['par'];
        $estado=1;

        $jornadas=Jornadas::find($jor);
        $especialidades=Especialidades::find($dt['esp']);
        $cursos=Cursos::find($cur);

        $datos=[$anl,$jor,$esp,$cur,$par,$estado];
        $est=$ADT->buscador_estudiantes($datos);
        $res="";
        $c=0;
$materias=DB::select("
select ac.mtr_id,m.mtr_descripcion from asg_materias_cursos ac
join materias m on ac.mtr_id=m.id
where ac.anl_id=$this->anl
and ac.esp_id=$aux_esp
and ac.cur_id=$cur
and m.mtr_tipo=$mtr_tp
order by m.id
    ");
        foreach ($est as $e) {
            $c++;
            $res.="<tr>
                    <td>$c</td>
                    <td>$e->est_apellidos $e->est_nombres $e->mat_id</td>
                    ";
                    foreach($materias as $m){
                        $mtr_tec_id=0;
                        $mtr=$m->mtr_id;
                        if($dt['esp']!=7 && $dt['esp']!=10){
                            $mtr_tec_id=$m->mtr_id;
                            $mtr=1;
                        }
                        //dd($mtr_tec_id);
                        $nota=DB::select("SELECT nota FROM reg_notas WHERE mat_id=$e->mat_id
                            and periodo=$dt[blq]
                            and mtr_id=$mtr
                            and ins_id=$dt[ins]
                            and mtr_tec_id=$mtr_tec_id
                             ");

                            $cls_nota="";
                        if(empty($nota)){
                            $nt="-";
                            $cls_nota="sin_nota";
                        }else{
                            if($nota[0]->nota>=5 && $nota[0]->nota<7){
                                $cls_nota='warning';
                            }
                            if($nota[0]->nota<5){
                                $cls_nota='danger';
                            }
                            $nt=number_format($nota[0]->nota,2);
                        }

                        $res.="<td class='cls_nota $cls_nota'>".$nt."</td>";
                    }
                $res.="</tr>";

        }

$datos=[$jornadas->jor_descripcion,
    $especialidades->esp_descripcion,
    $cursos->cur_descripcion,
    $par,
    $dt['blq'],
    $dt['ins']
];
        return view('reportes.rep_insumos')
      ->with('res',$res)
      ->with('materias',$materias)
      ->with('datos',$datos)
      ;
  }else{
   return $this->bajo_rendimiento_insumo($dt);
  }
}
        public function bajo_rendimiento_insumo($dt){
  // "tipo" => "2"
  // "jor" => "1"
  // "esp" => "10"
  // "cur" => "0"
  // "par" => "0"
  // "blq" => "1"
  // "ins" => "1"
            $anl=$this->anl;
            $jr=$dt['jor'];
            $ep=$dt['esp'];
            $cr=$dt['cur'];
            $pr=$dt['par'];
            $bq=$dt['blq'];
            $is=$dt['ins'];

             if($ep==7){
                $anl=$this->anl_bgu;
             }

             if($ep==7 || $ep==8 || $ep==10){
                 $sql_mtr="and rn.mtr_tec_id=0";
             }else{
                 $sql_mtr="and rn.mtr_id=1";
             }

            if($dt['tipo']==4){
                DB::select("truncate table tmp_sin_notas restart identity");
                //DD('KKKK');
                $res=$this->estudiantes_sin_nota_insumo($dt);
                $sql_notas="";
                $tx_rango="SN";
                $tx_cls="gray";
            }else{

                if($dt['tipo']==1){
                    $sql_notas=" and rn.nota<7 ";
                    $tx_rango=" < 7 Total ";
                    $tx_cls="#0879A3";
                }
                if($dt['tipo']==2){
                    $sql_notas=" and rn.nota>=5 and rn.nota<7 ";
                    $tx_rango=">=5 y <7";
                    $tx_cls="orange";
                }
                if($dt['tipo']==3){
                    $sql_notas=" and rn.nota<5";
                    $tx_rango="<5";
                    $tx_cls="brown";
                }

                $res=DB::select("
                    SELECT m.id,mt.mtr_descripcion,c.cur_descripcion,m.mat_paralelo as paralelo,e.est_apellidos,e.est_nombres,rn.nota,u.usu_apellidos,u.name from reg_notas rn
                    join matriculas m on rn.mat_id=m.id
                    join estudiantes e on m.est_id=e.id
                    join jornadas j on m.jor_id=j.id
                    join especialidades es on m.esp_id=es.id
                    join materias mt on rn.mtr_id=mt.id
                    join cursos c on m.cur_id=c.id
                    join users u on rn.usu_id=u.id
                    where m.jor_id=$jr
                    and   m.anl_id=$anl
                    $sql_mtr
                    and   rn.periodo=$bq
                    and   rn.ins_id=$is
                    $sql_notas
                    order by mt.mtr_descripcion,c.id,m.mat_paralelo,e.est_apellidos

                    ");
            }
        $jornadas=Jornadas::find($jr);
        $especialidades=Especialidades::find($ep);

        $datos=[$jornadas->jor_descripcion,
            $especialidades->esp_descripcion,
            $bq,
            $is,
            $tx_rango,
            $tx_cls
        ];
        return view('reportes.rep_bajo_rend_insumo')
            ->with('res',$res)
            ->with('datos',$datos)
            ;

        }

        public function estudiantes_sin_nota_insumo($dt){

            set_time_limit(0);

            $anl=$this->anl;
            if($dt['esp']==7){
                $anl=$this->anl_bgu;
            }
            $sql_esp=" AND m.esp_id<>7 AND m.esp_id<>8";
            $sql_mtr=" AND mtr_tec_id=0 and mtr_id=";
            $sql_orderby="ORDER BY m.jor_id,m.cur_id,m.mat_paralelo,e.est_apellidos ";

            if($dt['esp']<>10){
                $sql_esp=" AND m.esp_id=".$dt['esp'];
                    if($dt['esp']<>7 && $dt['esp']<>8){
                        $sql_mtr=" AND mtr_id=1 and mtr_tec_id=";
                        $sql_orderby="ORDER BY m.jor_id,m.cur_id,m.mat_paralelot,e.est_apellidos ";
                    }
            }


            $rst=DB::select("SELECT m.id,
                j.jor_descripcion,
                m.cur_id,
                c.cur_descripcion,
                m.mat_paralelo,
                m.mat_paralelot,
                e.est_apellidos,
                e.est_nombres
                FROM matriculas m
                JOIN estudiantes e ON m.est_id=e.id
                JOIN jornadas j ON m.jor_id=j.id
                JOIN especialidades es ON m.esp_id=es.id
                JOIN cursos c ON m.cur_id=c.id
                WHERE m.anl_id=$anl
                AND m.jor_id=$dt[jor]
                AND m.mat_estado=1
                $sql_esp
                $sql_orderby
                ");


            foreach ($rst as $r) {
                $materias=DB::select("SELECT * FROM asg_materias_cursos amc
                                        JOIN materias m ON amc.mtr_id=m.id
                                        WHERE amc.anl_id=$this->anl
                                        AND amc.cur_id=$r->cur_id
                                        AND amc.esp_id=$dt[esp]
                    ");
                //dd($materias);
                foreach ($materias as $m) {
                    $nt=DB::select("SELECT * FROM reg_notas
                        WHERE mat_id=$r->id
                        AND periodo=$dt[blq]
                        AND ins_id=$dt[ins]
                        $sql_mtr $m->mtr_id
                        ");

                    if(empty($nt)){
                        //dd($nt);
                        $cur=$r->cur_descripcion.' '.$r->mat_paralelot;
                        $mtr=$m->mtr_descripcion;
                        $est=$r->est_apellidos.' '.$r->est_nombres;
                        DB::select("INSERT INTO tmp_sin_notas (curso,
                                                                materia,
                                                                profesor,
                                                                estudiante)
                                    VALUES(
                                    '$cur','$mtr',null,'$est'
                                    )
                            ");
                    }
                }

            }
            return DB::select("select * from tmp_sin_notas order by sn_id ");
        }

        public function registra_comportamiento(Request $req){
            $dt=$req->all();

            $dsc_id=$dt['dsc_id'];
            $mat_id=$dt['matid'];
            $mtr_id=$dt['mtrid'];
            $usu_id=Auth::user()->id;
            $dsc_parcial=$dt['dsc_parcial'];
            $dsc_tipo=$dt['dsc_tipo'];
            $dsc_nota=$dt['dsc_nota'];

            if($dsc_id==0){
                $disciplina=DB::select("INSERT INTO reg_disciplina(
                   mat_id, mtr_id, usu_id, dsc_parcial, dsc_tipo, dsc_nota)
                   VALUES ($mat_id,$mtr_id,$usu_id,$dsc_parcial,$dsc_tipo,'$dsc_nota')
                   returning dsc_id
                   ");
                $rep=$disciplina[0]->dsc_id;
            }else{

                $disciplina=DB::select("
                    UPDATE reg_disciplina SET dsc_nota='$dsc_nota' WHERE  dsc_id=$dsc_id
                    ");
                $rep=$dsc_id;
            }

            return $rep;
        }

        public function reporte_adicional(){

            $mod=DB::select("select es.esp_descripcion,c.cur_descripcion,m.mtr_descripcion,ac.mtr_id,ac.cur_id from asg_materias_cursos ac
                join cursos c on ac.cur_id=c.id
                join materias m on ac.mtr_id=m.id
                join especialidades es on ac.esp_id=es.id
                where ac.bloques=1
                and ac.anl_id=$this->anl
                order by es.esp_descripcion,c.id");
            return view('reportes.reporte_adicional')
            ->with('mod',$mod) ;
        }

        public function resumen_notas_modulo(Request $req){
             $dat=$req->all();
            $est=DB::select("select rn.mat_id,j.jor_descripcion,es.esp_descripcion,c.cur_descripcion,m.mat_paralelot,e.est_apellidos,e.est_nombres from reg_notas rn
                join matriculas m on m.id=rn.mat_id
                join estudiantes e on e.id=m.est_id
                join jornadas j on j.id=m.jor_id
                join especialidades es on es.id=m.esp_id
                join cursos c on c.id=m.cur_id
                where rn.mtr_id=1
                and rn.mtr_tec_id=$dat[mtr_id]
                and m.cur_id=$dat[cur_id]
                and m.mat_estado=1
                group by rn.mat_id,j.jor_descripcion,es.esp_descripcion,c.cur_descripcion,m.mat_paralelot,e.est_apellidos,e.est_nombres
                order by j.jor_descripcion,m.mat_paralelot,e.est_apellidos ");

            $resp=collect();

            foreach ($est as $e) {
                    $pq1=$this->pquimestre($e->mat_id,$dat['mtr_id'],1,0,1);
                    if($pq1<7){
                        $supletorio=DB::select("select * from reg_notas
                            where mtr_id=1
                            and mtr_tec_id=$dat[mtr_id]
                            and mat_id=$e->mat_id
                            and periodo=100
                            and ins_id=5
                            ");
                         if(empty($supletorio)){
                            $e->nota=$pq1;
                             $resp->push($e);
                        }
                    }

            }
                             //dd($resp);

                                Excel::create('sin_supletorio_tecnicos ', function($excel) use($resp) {
                                    $excel->sheet('Lista', function($sheet) use($resp) {
                                    $sheet->loadView("reportes.resumen_notas_modulo")->with('dt',$resp);
                                    });
                                })->export('xls');

             // return view('reportes.resumen_notas_modulo')
             // ->with('dt',$resp)
             // ;

        }


        public function reporte_general_notas_org(Request $rq){

            $dt=$rq->all();
            $us=Auth::user()->id;
            $datos=[];
            $datos_c=[];
            $materias=[];
            $enc_nota=[];
            $promedios=[];
            $esp=0;
            $op=0;

            if(isset($dt['btn_buscar'])){

                if($us==85){ ///si es Alexandra Sanni o super Admin no valida el estado
                    $sql_estado="";
                }else{
                    $sql_estado="and (m.mat_estado=1)";
                }

                $jor=$dt['jor_id'];
                $esp=$dt['esp_id'];
                $cur=$dt['cur_id'];
                $paralelo=$dt['paralelo'];
                $per=$dt['periodo'];
                $anl=$this->anl;
                if($esp==7){
                    $anl=$this->anl_bgu;
                }
                if($esp==10 || $esp==7 || $esp==8){

                    $materias=DB::select("
                        select ac.mtr_id,m.mtr_descripcion,m.mtr_tipo from asg_materias_cursos ac
                        join materias m on ac.mtr_id=m.id
                        where ac.anl_id=$this->anl
                        and ac.esp_id=10
                        and ac.cur_id=$cur
                        and m.mtr_tipo=0
                        order by m.mtr_descripcion
                    ");  //Materias Culturales

                }else{

////////////////////////****************ORGINAL SOLO TECNICAS
                    // $materias=DB::select("
                    //     select ac.mtr_id,m.mtr_descripcion from asg_materias_cursos ac
                    //     join materias m on ac.mtr_id=m.id
                    //     where ac.anl_id=$this->anl
                    //     and ac.esp_id=$esp
                    //     and ac.cur_id=$cur
                    //     and m.mtr_tipo=1
                    //     order by m.mtr_descripcion
                    // ");  //Materias Técnicas

////////////////////////****************UNIDAS TÉCNICAS Y CULTURALES

                    $materias=DB::select("
                        (SELECT ac.mtr_id,m.mtr_descripcion,m.mtr_tipo FROM asg_materias_cursos ac
                        join materias m on ac.mtr_id=m.id
                        where ac.anl_id=$this->anl
                        and ac.esp_id=10
                        and ac.cur_id=$cur
                        and m.mtr_tipo=0
                        order by m.mtr_descripcion )
                        UNION ALL
                        ( SELECT ac.mtr_id,m.mtr_descripcion,m.mtr_tipo FROM asg_materias_cursos ac
                         join materias m on ac.mtr_id=m.id
                         where ac.anl_id=$this->anl
                         and ac.esp_id=$esp
                         and ac.cur_id=$cur
                         and m.mtr_tipo=1
                         order by m.mtr_descripcion
                        )

                    ");  //Materias Culturales Y TÉCNICAS


                }



/////////////**************************ENCABEZADO*********************/////////////////////
                            $sql_h="";
                            $tx_head="";
                            $n_mat=count($materias);
                            $x=0;
                            foreach ($materias as $m) {
                                $x++;
                                $sql_union=" union all ";

                                array_push($enc_nota,"nt".$m->mtr_id."1" );
                                array_push($enc_nota,"nt".$m->mtr_id."2" );
                                array_push($enc_nota,"nt".$m->mtr_id."3" );
                                array_push($enc_nota,"nt".$m->mtr_id."4" );
                                array_push($enc_nota,"nt".$m->mtr_id."8" );
                                array_push($enc_nota,"nt".$m->mtr_id."12" );

                                $tx_head.=",nt".$m->mtr_id."1 text,nt".$m->mtr_id."2 text,nt".$m->mtr_id."3 text,nt".$m->mtr_id."4 text,nt".$m->mtr_id."8 text,nt".$m->mtr_id."12 text";

                                if($x==$n_mat){
                                    $sql_union=" ";
                                }
                                $sql_h.=" SELECT cast(concat($m->mtr_id,id) as integer) as ins from insumos where tipo=''I'' $sql_union ";
                            }
/////////////***********************************************/////////////////////




                if($esp==10 || $esp==7 || $esp==8){//SI ES CULTURAL ->BGU Y BÁSICA FLEXIBLE

                    $sql_esp="and m.esp_id<>8 and m.esp_id<>7";

                    if($esp!=10){
                        $sql_esp="and m.esp_id=$esp";
                    }

                          if($per=="Q1" || $per=="Q2"){
/////////////**************************ENCABEZADO*********************/////////////////////
                            $sql_head="";
                            $tx_head="";
                            $n_mat=count($materias);
                            $x=0;
                            foreach ($materias as $m) {
                                $sql_union=" UNION ALL ";
                                $x++;
                                if($x==$n_mat){
                                    $sql_union=" ";
                                }
                                if($per=='Q1'){
                                    $op=1;
                                    if($esp==7){
                                        $aux_p1=1;
                                        $aux_p2=2;
                                        $aux_p3=5;
                                    }else{
                                        $aux_p1=1;
                                        $aux_p2=2;
                                        $aux_p3=3;
                                    }
                                        $aux_ex=7;

                                }else{
                                    $op=2;
                                    if($esp==7){
                                        $aux_p1=3;
                                        $aux_p2=4;
                                    }else{
                                        $aux_p1=4;
                                        $aux_p2=5;
                                    }

                                    $aux_p3=6;
                                    $aux_ex=8;
                                }

                                // $op=2;
                                // if($esp==7){
                                //     $aux_p1=3;
                                //     $aux_p2=4;
                                //     $aux_p3=6;
                                // }

                                $sql_head.="SELECT concat($m->mtr_id,$aux_p1) AS mtr UNION ALL
                                            SELECT concat($m->mtr_id,$aux_p2) AS mtr UNION ALL
                                            SELECT concat($m->mtr_id,$aux_p3) AS mtr UNION ALL
                                            SELECT concat($m->mtr_id,$aux_ex) AS mtr $sql_union
                                ";
                                $tx_head.=",pb".$m->mtr_id.$aux_p1." text, pb".$m->mtr_id.$aux_p2." text, pb".$m->mtr_id.$aux_p3." text, pb".$m->mtr_id.$aux_ex." text  ";
                            }
/////////////***********************************************/////////////////////

                                    $sql="SELECT * FROM crosstab('select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id) as estudiante,
                                    concat(rn.mtr_id,rn.periodo),

                                    CASE
                                    WHEN count(*)=6 AND rn.periodo<>7  THEN sum(rn.nota)/6
                                    WHEN count(*)<6 AND rn.periodo<>7  THEN sum(rn.nota)/5
                                    ELSE sum(rn.nota)
                                    END AS nota

                                    from matriculas m
                                    join estudiantes e on m.est_id=e.id
                                    left join reg_notas rn on rn.mat_id=m.id
                                    and ( rn.periodo=$aux_p1 or rn.periodo=$aux_p2 or rn.periodo=$aux_p3 or rn.periodo=$aux_ex )

                                    where m.anl_id=$anl
                                    and m.jor_id=$jor
                                    and m.cur_id=$cur
                                    and m.mat_paralelo=''$paralelo''
                                    $sql_esp
                                    $sql_estado
                                    group by e.est_apellidos,e.est_nombres,rn.mtr_id,rn.periodo,m.id
                                    order by estudiante,rn.mtr_id,rn.periodo
                                    '::text,' $sql_head   '::text)
                                crosstab(estudiante text $tx_head  ); ";

                                //dd($sql);

                                $datos=DB::select($sql);


                                }else{ ///SI ES CUALQUIER PARCIAL


                                    $sql="
                                    SELECT * FROM crosstab('
                                    select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id) as estudiante,
                                    concat(rn.mtr_id,rn.ins_id) mtr_ins,rn.nota
                                    from matriculas m
                                    join estudiantes e on m.est_id=e.id
                                    left join reg_notas rn on rn.mat_id=m.id
                                    and rn.mtr_tec_id=0
                                    and rn.periodo=$per
                                    where m.anl_id=$anl
                                    and m.jor_id=$jor
                                    and m.cur_id=$cur
                                    and m.mat_paralelo=''$paralelo''
                                    $sql_esp
                                    $sql_estado
                                    order by estudiante,rn.mtr_id,rn.ins_id,m.id
                                    '::text,' $sql_h  '::text)
                                    crosstab(estudiante text $tx_head  );";

                                   $datos=DB::select($sql);

                                   $promedios=DB::select("
                                    SELECT * FROM crosstab('
                                    select concat(''Prom'') as estudiante,
                                    concat(rn.mtr_id,rn.ins_id) mtr_ins,
                                    sum(rn.nota)/count(*) as nota
                                    from matriculas m
                                    join estudiantes e on m.est_id=e.id
                                    left join reg_notas rn on rn.mat_id=m.id
                                    and rn.mtr_tec_id=0
                                    and rn.periodo=$per
                                    where m.anl_id=$anl
                                    and m.jor_id=$jor
                                    and m.cur_id=$cur
                                    and m.mat_paralelo=''$paralelo''
                                    $sql_esp
                                    $sql_estado
                                    group by rn.mtr_id,rn.ins_id
                                    order by rn.mtr_id,rn.ins_id

                                    '::text,' $sql_h  '::text)
                                    crosstab(estudiante text $tx_head  );
                                    ");

                               }

                         }else{ //SI ES TÉCNICO

                            if($per=='Q1'){
/////////////**************************ENCABEZADO*********************/////////////////////
                            $op=1;
                            $sql_head="";
                            $tx_head="";
                            $datos="";
                            $n_mat=count($materias);
                            $x=0;
                                foreach ($materias as $m) {
                                $sql_union=" UNION ALL ";
                                $x++;
                                if($x==$n_mat){
                                    $sql_union=" ";
                                }
                                $sql_head.="SELECT concat($m->mtr_id,1) AS mtr UNION ALL
                                            SELECT concat($m->mtr_id,2) AS mtr UNION ALL
                                            SELECT concat($m->mtr_id,3) AS mtr UNION ALL
                                            SELECT concat($m->mtr_id,7) AS mtr $sql_union ";

                                $tx_head.=",pb".$m->mtr_id."1 text, pb".$m->mtr_id."2 text, pb".$m->mtr_id."3 text, pb".$m->mtr_id."7 text  ";
                            }
/////////////******************************NOTAS****************/////////////////////
                                     $sql="SELECT * FROM crosstab('select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id) as estudiante,
                                    CASE
                                    WHEN rn.mtr_id=1 THEN concat(rn.mtr_tec_id,rn.periodo)
                                    WHEN rn.mtr_id<>1 THEN concat(rn.mtr_id,rn.periodo)
                                    END AS mtr_id,
                                    CASE
                                    WHEN count(*)=6 AND rn.periodo<>7  THEN sum(rn.nota)/6
                                    WHEN count(*)<6 AND rn.periodo<>7  THEN sum(rn.nota)/5
                                    ELSE sum(rn.nota)
                                    END AS nota
                                    from matriculas m
                                    join estudiantes e on m.est_id=e.id
                                    left join reg_notas rn on rn.mat_id=m.id
                                    and ( rn.periodo=1 or rn.periodo=2 or rn.periodo=3 or rn.periodo=7 )
                                    where m.anl_id=$anl
                                    and m.jor_id=$jor
                                    and m.cur_id=$cur
                                    and m.mat_paralelot=''$paralelo''
                                    and m.esp_id=$esp
                                    $sql_estado
                                    group by e.est_apellidos,e.est_nombres,rn.mtr_id,rn.mtr_tec_id,rn.periodo,m.id
                                    order by estudiante,rn.mtr_tec_id,rn.periodo
                                    '::text,' $sql_head   '::text)
                                crosstab(estudiante text $tx_head  ); ";

                                $datos=DB::select($sql);
/////////////******************************COMPORTAMIENTO****************/////////////////////
                                $sql_c="
                                SELECT * FROM crosstab('select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id) as estudiante,
                                concat(rn.mtr_id,rn.dsc_parcial),
                                rn.dsc_nota
                                from matriculas m
                                join estudiantes e on m.est_id=e.id
                                left join reg_disciplina rn on rn.mat_id=m.id
                                and ( rn.dsc_parcial=1 or rn.dsc_parcial=2 or rn.dsc_parcial=3 )
                                where m.anl_id=$anl
                                and m.jor_id=$jor
                                and m.cur_id=$cur
                                and m.mat_paralelot=''$paralelo''
                                and m.esp_id=$esp
                                $sql_estado
                                order by estudiante,rn.mtr_id,rn.dsc_parcial
                                '::text,' $sql_head UNION ALL
                                            SELECT concat(3,1) AS mtr UNION ALL
                                            SELECT concat(3,2) AS mtr UNION ALL
                                            SELECT concat(3,3) AS mtr  '::text)
                                crosstab(estudiante text $tx_head ,pb31 text,pb32 text,pb33 text);
                                ";

                                $datos_c=DB::select($sql_c);


                            }elseif($per=='Q2'){ //QUIMESTRE 2

                    /////////////**************************ENCABEZADO*********************/////////////////////
                                                    $op=2;
                                                    $sql_head="";
                                                    $tx_head="";
                                                    $datos="";
                                                    $n_mat=count($materias);
                                                    $x=0;
                                                    foreach ($materias as $m) {
                                                        $sql_union=" UNION ALL ";
                                                        $x++;
                                                        if($x==$n_mat){
                                                            $sql_union=" ";
                                                        }
                                                        $sql_head.="SELECT concat($m->mtr_id,4) AS mtr UNION ALL
                                                        SELECT concat($m->mtr_id,5) AS mtr UNION ALL
                                                        SELECT concat($m->mtr_id,6) AS mtr UNION ALL
                                                        SELECT concat($m->mtr_id,8) AS mtr $sql_union ";
                                                        $tx_head.=",pb".$m->mtr_id."4 text, pb".$m->mtr_id."5 text, pb".$m->mtr_id."6 text, pb".$m->mtr_id."8 text  ";
                                                    }


                    /////////////******************************NOTAS****************/////////////////////
                                                    $sql="SELECT * FROM crosstab('select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id) as estudiante,
                                                    CASE
                                                    WHEN rn.mtr_id=1 THEN concat(rn.mtr_tec_id,rn.periodo)
                                                    WHEN rn.mtr_id<>1 THEN concat(rn.mtr_id,rn.periodo)
                                                    END AS mtr_id,
                                                    CASE
                                                    WHEN count(*)=6 AND rn.periodo<>8  THEN sum(rn.nota)/6
                                                    WHEN count(*)<6 AND rn.periodo<>8  THEN sum(rn.nota)/5
                                                    ELSE sum(rn.nota)
                                                    END AS nota
                                                    from matriculas m
                                                    join estudiantes e on m.est_id=e.id
                                                    left join reg_notas rn on rn.mat_id=m.id
                                                    and ( rn.periodo=4 or rn.periodo=5 or rn.periodo=6 or rn.periodo=8 )
                                                    where m.anl_id=$anl
                                                    and m.jor_id=$jor
                                                    and m.cur_id=$cur
                                                    and m.mat_paralelot=''$paralelo''
                                                    and m.esp_id=$esp
                                                    $sql_estado
                                                    group by e.est_apellidos,e.est_nombres,rn.mtr_id,rn.mtr_tec_id,rn.periodo,m.id
                                                    order by estudiante,rn.mtr_tec_id,rn.periodo
                                                    '::text,' $sql_head   '::text)
                                                    crosstab(estudiante text $tx_head  ); ";

                                                    $datos=DB::select($sql);
                    // /////////////******************************COMPORTAMIENTO****************/////////////////////
                                                    $sql_c="
                                                    SELECT * FROM crosstab('select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id) as estudiante,
                                                    concat(rn.mtr_id,rn.dsc_parcial),
                                                    rn.dsc_nota
                                                    from matriculas m
                                                    join estudiantes e on m.est_id=e.id
                                                    left join reg_disciplina rn on rn.mat_id=m.id
                                                    and ( rn.dsc_parcial=1 or rn.dsc_parcial=2 or rn.dsc_parcial=3 )
                                                    where m.anl_id=$anl
                                                    and m.jor_id=$jor
                                                    and m.cur_id=$cur
                                                    and m.mat_paralelot=''$paralelo''
                                                    and m.esp_id=$esp
                                                    $sql_estado
                                                    order by estudiante,rn.mtr_id,rn.dsc_parcial
                                                    '::text,' $sql_head UNION ALL
                                                    SELECT concat(3,1) AS mtr UNION ALL
                                                    SELECT concat(3,2) AS mtr UNION ALL
                                                    SELECT concat(3,3) AS mtr  '::text)
                                                    crosstab(estudiante text $tx_head ,pb31 text,pb32 text,pb33 text);
                                                    ";

                                                    $datos_c=DB::select($sql_c);


                            }else{

                                $sql="
                                        SELECT * FROM crosstab('
                                        select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id) as estudiante,
                                        CASE
                                        WHEN rn.mtr_id=1 THEN concat(rn.mtr_tec_id,rn.ins_id)
                                        WHEN rn.mtr_id<>1 THEN concat(rn.mtr_id,rn.ins_id)
                                        END AS mtr_ins,
                                        rn.nota
                                        from matriculas m
                                        join estudiantes e on m.est_id=e.id
                                        left join reg_notas rn  on rn.mat_id=m.id
                                        and rn.periodo=$per
                                        where m.anl_id=$anl
                                        and m.jor_id=$jor
                                        and m.esp_id=$esp
                                        and m.cur_id=$cur
                                        and m.mat_paralelot=''$paralelo''
                                        $sql_estado
                                        order by estudiante,rn.mtr_tec_id,rn.ins_id
                                        '::text,' $sql_h  '::text)
                                        crosstab(estudiante text $tx_head  );
                                        ";

                                       $datos=DB::select($sql);

                                       $promedios=[];

                                       $promedios=DB::select("
                                        SELECT * FROM crosstab('
                                        select concat(''Prom '') as estudiante,
                                        CASE
                                        WHEN rn.mtr_id=1 THEN concat(rn.mtr_tec_id,rn.ins_id)
                                        WHEN rn.mtr_id<>1 THEN concat(rn.mtr_id,rn.ins_id)
                                        END AS mtr_ins,
                                        sum(rn.nota)/count(*) as nota
                                        from reg_notas rn
                                        join matriculas m on rn.mat_id=m.id
                                        join estudiantes e on m.est_id=e.id
                                        and rn.periodo=$per
                                        where m.anl_id=$anl
                                        and m.jor_id=$jor
                                        and m.esp_id=$esp
                                        and m.cur_id=$cur
                                        and m.mat_paralelot=''$paralelo''
                                        group by rn.mtr_id,rn.mtr_tec_id,rn.ins_id
                                        order by estudiante,rn.mtr_tec_id,rn.ins_id
                                        '::text,' $sql_h  '::text)
                                        crosstab(estudiante text $tx_head  );
                                        ");

                                }


                         }
            }


            $jor=Jornadas::orderBy('id', 'ASC')->pluck('jor_descripcion', 'id');
            $cmb_esp=Especialidades::pluck('esp_descripcion', 'id');
            $cur=Cursos::pluck('cur_descripcion', 'id');


            if(isset($dt['btn_buscar']) && $dt['btn_buscar']=='btn_excel'){

                $datos=($dt['datos_excel']);
                    Excel::create('Reporte', function($excel) use($datos) {
                        $excel->sheet('Lista', function($sheet) use($datos) {
                            $sheet->loadView("reportes.reporte_general_notas_excel")
                            ->with('datos',$datos)
                            ;
                        });
                    })->export('xls');

            }


            return view('reportes.reporte_general_notas')
            ->with('jor',$jor)
            ->with('cmb_esp',$cmb_esp)
            ->with('esp',$esp)
            ->with('cur',$cur)
            ->with('datos',$datos)
            ->with('datos_c',$datos_c)
            ->with('materias',$materias)
            ->with('enc_nota',$enc_nota)
            ->with('materias',$materias)
            ->with('promedios',$promedios)
            ->with('op',$op)
            ;
        }



        public function modifica_notas(Request $rq){
            $dat=$rq->all()['dt'];
            $mat_id=$dat[0]['mat_id'];
            $mtr_id=$dat[1]['mtr_id'];
            $mtr_tec_id=0;
            $tp=$dat[2]['tp'];///es el periodo
            $nt=$dat[3]['nt'];
            $esp_id=$dat[4]['esp_id'];
            $materia=DB::select("SELECT * from materias where id=".$mtr_id);


            if($tp=='p1' || $tp=='p2' || $tp=='p3' || $tp=='p4' || $tp=='p5' || $tp=='p6' ){

                $this->modifca_notas_parcial($mat_id,$mtr_id,$tp,$nt,$esp_id);

            }elseif($tp=='exq1' || $tp=='exq2'){

                    if($materia[0]->mtr_tipo==1 ){
                        $mtr_tec_id=$mtr_id;
                        $mtr_id=1;
                    }

                    // if($esp_id==7 || $esp_id==8 || $esp_id==10 ){
                    //     $mtr_tec_id=0;
                    // }else{
                    //     $mtr_tec_id=$mtr_id;
                    //     $mtr_id=1;
                    // }

                    if($tp=='exq1'){
                        $periodo=7;
                        $ins_id=9;
                    }elseif($tp=='exq2'){
                        $periodo=8;
                        $ins_id=10;
                    }

                    $fecha = date('Y-m-d');
                    $data = ['mat_id' => $mat_id,
                    'ins_id' => $ins_id,
                    'nota' => $nt,
                    'mtr_id' => $mtr_id,
                    'periodo' => $periodo,
                    'usu_id' => Auth::user()->id,
                    'f_modific' => $fecha,
                    'disciplina' => null,
                    'mtr_tec_id' => $mtr_tec_id
                ];

                    $sql="SELECT * from reg_notas where mat_id=$mat_id and mtr_id=$mtr_id and periodo=$periodo and ins_id=$ins_id and mtr_tec_id=$mtr_tec_id";
                    $notas=DB::select($sql);
                    if(empty($notas)){
                        $this->regNotasRepository->create($data);
                    }else{
                        DB::select("UPDATE reg_notas set nota=$nt where id=".$notas[0]->id);
                    }

            }

            return 0;

        }



        public function modifca_notas_parcial($mat_id,$mtr_id,$tp,$nt,$esp_id){
            $periodo=substr($tp,1,1);
            $x=1;

            if($esp_id==7 || $esp_id==8 || $esp_id==10 ){
                $mtr_tec_id=0;
            }else{
                $mtr_tec_id=$mtr_id;
                $mtr_id=1;
            }


            while ($x <= 6) {
                $ins_id=$x;
                if($x==5){
                    $ins_id=8;
                }elseif($x==6){
                    $ins_id=12;
                }
                //dd($mat_id.'-'.$mtr_id.'-'.$tp.'-'.$nt.'-'.$esp_id);
                $sql="SELECT * from reg_notas where mat_id=$mat_id and mtr_id=$mtr_id and periodo=$periodo and ins_id=$ins_id and mtr_tec_id=$mtr_tec_id";

                $rst=DB::select($sql);
                if(empty($rst)){
                    //Inserta
                            if($x<>6){
                                $fecha = date('Y-m-d');
                                $data = ['mat_id' => $mat_id,
                                'ins_id' => $ins_id,
                                'nota' => $nt,
                                'mtr_id' => $mtr_id,
                                'periodo' => $periodo,
                                'usu_id' => Auth::user()->id,
                                'f_modific' => $fecha,
                                'disciplina' => null,
                                'mtr_tec_id' => $mtr_tec_id
                            ];
                            $this->regNotasRepository->create($data);

                        }else{
                            return 0;
                        }

                }else{
                    //modifica
                    DB::select("UPDATE reg_notas set nota=$nt where id=".$rst[0]->id);
                }

                $x++;
            }

            return 0;

        }


        public function reporte_cuadros_finales(Request $rq){
            $dt=$rq->all();
            if(isset($dt["opcion"])){
                // if($dt['esp_id']==7 || $dt['esp_id']==8 || $dt['esp_id']==10){
                //     return $this->reporte_cuadros_finales_culturales($dt);
                // }else{
                     return $this->reporte_cuadros_finales_ok($dt);
                // }
            }else{


                    $jornadas=Jornadas::orderBy('id', 'ASC')->pluck('jor_descripcion', 'id');
                    $especialidades=Especialidades::orderby('esp_descripcion')->pluck('esp_descripcion', 'id');
                    $cursos=Cursos::orderby('id')->pluck('cur_descripcion', 'id');
                    $datos=[];
                    $datos_c=[];
                    $materias=[];
                    $enc_nota=[];
                    $quim=0;

                       return view("reportes.reporte_cuadros_finales")
                       ->with('jor',$jornadas)
                       ->with('esp',$especialidades)
                       ->with('cur',$cursos)
                       ->with('materias',$materias)
                       ->with('datos',$datos)
                       ->with('datos_c',$datos_c)
                       ->with('qm',$quim)
                       ->with('ep',0)
                       ;

            }

            //dd('okk');
        }


        public function reporte_cuadros_finales_culturales($dt){
            //$dt=$rq->all();
            ////*****VARIABLES DE INICIO******///////
            $us=Auth::user()->id;
            $datos=[];
            $datos_c=[];
            $materias=[];
            $enc_nota=[];
            $promedios=[];

            $op=$dt["opcion"];
            $jor=$dt["jor_id"];
            $esp=$dt["esp_id"];
            $cur=$dt["cur_id"];
            $paralelo=$dt["paralelo"];

            $quim=$dt["periodo"];

                if($us==85){ ///si es Alexandra Sanni o Super Admin no valida el estado
                    $sql_estado="";
                }else{
                    $sql_estado="and (m.mat_estado=1)";
                }

                $anl=$this->anl;
                if($esp==7){
                    $anl=$this->anl_bgu;
                }


                    $materias=DB::select("
                        select ac.mtr_id,m.mtr_descripcion from asg_materias_cursos ac
                        join materias m on ac.mtr_id=m.id
                        where ac.anl_id=$this->anl
                        and ac.esp_id=10
                        and ac.cur_id=$cur
                        and m.mtr_tipo=0
                        order by m.mtr_descripcion
                    ");  //Materias Culturales


/////////////**************************ENCABEZADO*********************/////////////////////
                            $op=1;
                            $sql_head="";
                            $tx_head="";
                            $datos="";
                            $n_mat=count($materias);
                            $x=0;
                                foreach ($materias as $m) {

                                    $sql_union=" UNION ALL ";
                                    $x++;
                                    if($x==$n_mat){
                                        $sql_union=" ";
                                    }
                                    $sql_head.="
                                                SELECT concat($m->mtr_id,1) AS mtr UNION ALL
                                                SELECT concat($m->mtr_id,2) AS mtr UNION ALL
                                                SELECT concat($m->mtr_id,3) AS mtr UNION ALL
                                                SELECT concat($m->mtr_id,4) AS mtr UNION ALL
                                                SELECT concat($m->mtr_id,5) AS mtr UNION ALL
                                                SELECT concat($m->mtr_id,6) AS mtr UNION ALL
                                                SELECT concat($m->mtr_id,7) AS mtr UNION ALL
                                                SELECT concat($m->mtr_id,8) AS mtr UNION ALL
                                                SELECT concat($m->mtr_id,100) AS mtr UNION ALL
                                                SELECT concat($m->mtr_id,101) AS mtr UNION ALL
                                                SELECT concat($m->mtr_id,102) AS mtr $sql_union ";

                                    $tx_head.=",pb".$m->mtr_id.
                                       "1 text, pb".$m->mtr_id.
                                       "2 text, pb".$m->mtr_id.
                                       "3 text, pb".$m->mtr_id.
                                       "4 text, pb".$m->mtr_id.
                                       "5 text, pb".$m->mtr_id.
                                       "6 text, pb".$m->mtr_id.
                                       "7 text, pb".$m->mtr_id.
                                       "8 text, pb".$m->mtr_id.
                                       "100 text, pb".$m->mtr_id.
                                       "101 text, pb".$m->mtr_id.
                                       "102 text  ";

                            }
/////////////******************************NOTAS****************/////////////////////
                                $sql_esp="and m.esp_id=$esp";
                                if($esp==10){
                                    $sql_esp="";
                                }

                                     $sql="SELECT * FROM crosstab('select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id) as estudiante,
                                    CASE
                                    WHEN rn.mtr_id=1 THEN concat(rn.mtr_tec_id,rn.periodo)
                                    WHEN rn.mtr_id<>1 THEN concat(rn.mtr_id,rn.periodo)
                                    END AS mtr_id,
                                    CASE
                                    WHEN count(*)=6 AND (rn.periodo<>7 and rn.periodo<>8 and rn.periodo<>100 and rn.periodo<>101 and rn.periodo<>102 )  THEN sum(rn.nota)/6
                                    WHEN count(*)<6 AND (rn.periodo<>7 and rn.periodo<>8 and rn.periodo<>100 and rn.periodo<>101 and rn.periodo<>102 )  THEN sum(rn.nota)/5
                                    ELSE sum(rn.nota)
                                    END AS nota
                                    from matriculas m
                                    join estudiantes e on m.est_id=e.id
                                    left join reg_notas rn on rn.mat_id=m.id
                                    where m.anl_id=$anl
                                    and m.jor_id=$jor
                                    and m.cur_id=$cur
                                    and m.mat_paralelo=''$paralelo''
                                    $sql_esp
                                    $sql_estado
                                    group by e.est_apellidos,e.est_nombres,rn.mtr_id,rn.mtr_tec_id,rn.periodo,m.id
                                    order by estudiante,rn.mtr_tec_id,rn.periodo
                                    '::text,' $sql_head   '::text)
                                crosstab(estudiante text $tx_head  ); ";


                                $datos=DB::select($sql);
/////////////******************************COMPORTAMIENTO****************/////////////////////
                                $sql_c="
                                SELECT * FROM crosstab('select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id) as estudiante,
                                concat(rn.mtr_id,rn.dsc_parcial),
                                rn.dsc_nota
                                from matriculas m
                                join estudiantes e on m.est_id=e.id
                                left join reg_disciplina rn on rn.mat_id=m.id
                                and ( rn.dsc_parcial=1 or rn.dsc_parcial=2 or rn.dsc_parcial=3 )
                                where m.anl_id=$anl
                                and m.jor_id=$jor
                                and m.cur_id=$cur
                                and m.mat_paralelo=''$paralelo''
                                $sql_esp
                                $sql_estado
                                order by estudiante,rn.mtr_id,rn.dsc_parcial
                                '::text,' $sql_head UNION ALL
                                            SELECT concat(3,1) AS mtr UNION ALL
                                            SELECT concat(3,2) AS mtr UNION ALL
                                            SELECT concat(3,3) AS mtr  '::text)
                                crosstab(estudiante text $tx_head ,pb31 text,pb32 text,pb33 text);
                                ";
                                $datos_c=DB::select($sql_c);



            $jornadas=Jornadas::orderBy('id', 'ASC')->pluck('jor_descripcion', 'id');
            $especialidades=Especialidades::pluck('esp_descripcion', 'id');
            $cursos=Cursos::pluck('cur_descripcion', 'id');

            ////***MANDAR A LA VISTA O AL EXCEL****/////
            if($dt['btn_buscar']=='btn_buscar'){

               return view("reportes.reporte_cuadros_finales")
               ->with('jor',$jornadas)
               ->with('esp',$especialidades)
               ->with('cur',$cursos)
               ->with('materias',$materias)
               ->with('datos',$datos)
               ->with('datos_c',$datos_c)
               ->with('qm',$quim)
               ->with('ep',$esp)
               ;

            }elseif($dt['btn_buscar']=='btn_excel'){

                        $dt_jor=DB::select("SELECT * FROM jornadas WHERE id=".$jor);
                        $dt_esp=DB::select("SELECT * FROM especialidades WHERE id=".$esp);
                        $dt_cur=DB::select("SELECT * FROM cursos WHERE id=".$cur);
                        $dt_enc_xls=[
                            'jor'=>$dt_jor[0]->jor_descripcion,
                            'esp'=>$dt_esp[0]->esp_descripcion,
                            'cur'=>$dt_cur[0]->cur_descripcion,
                            'par'=>$paralelo];

                         return view("reportes.cuadros_culturales_excel")
                         ->with('jor',$jornadas)
                         ->with('esp',$especialidades)
                         ->with('cur',$cursos)
                         ->with('materias',$materias)
                         ->with('datos',$datos)
                         ->with('datos_c',$datos_c)
                         ->with('dt_enc_xls',$dt_enc_xls)
                         ->with('qm',$quim)
                         ->with('ep',$esp)
                         ;



            }


      }




        public function reporte_cuadros_finales_ok($dt){
            ////*****VARIABLES DE INICIO******///////
            $us=Auth::user()->id;
            $datos=[];
            $datos_c=[];
            $materias=[];
            $enc_nota=[];
            $promedios=[];

            $op=$dt["opcion"];
            $jor=$dt["jor_id"];
            $esp=$dt["esp_id"];
            $cur=$dt["cur_id"];
            $paralelo=$dt["paralelo"];

            $cfg=$this->configuracion_periodo_lectivo($esp);

            $quim=$dt["periodo"];

                if($us==85 || $us==1){ ///si es Alexandra Sanni o Super Admin no valida el estado
                    $sql_estado="and (m.mat_estado!=0)";
                }else{
                    $sql_estado="and (m.mat_estado=1)";
                }

                $anl=$this->anl;
                if($esp==7){
                    $anl=$this->anl_bgu;
                }

                if($esp==10 || $esp==7 || $esp==8){
                    $sql_materias="
                        SELECT ac.mtr_id,m.mtr_area,m.mtr_descripcion FROM asg_materias_cursos ac
                        join materias m on ac.mtr_id=m.id
                        where ac.anl_id=$this->anl
                        and ac.esp_id=10
                        and ac.cur_id=$cur
                        and m.mtr_tipo=0
                        order by m.mtr_orden_area, m.mtr_orden_materia
                    ";
                    //dd($sql_materias);
                    $materias=DB::select($sql_materias);  //Materias Culturales
                }else{

////////////////////////****************UNIDAS TÉCNICAS Y CULTURALES
                    $sql_materias="
                        (SELECT ac.mtr_id,m.mtr_area,m.mtr_descripcion FROM asg_materias_cursos ac
                        join materias m on ac.mtr_id=m.id
                        where ac.anl_id=$this->anl
                        and ac.esp_id=10
                        and ac.cur_id=$cur
                        and m.mtr_tipo=0
                        order by m.mtr_orden_area, m.mtr_orden_materia )
                        UNION ALL
                        ( SELECT ac.mtr_id,m.mtr_area,m.mtr_descripcion FROM asg_materias_cursos ac
                         join materias m on ac.mtr_id=m.id
                         where ac.anl_id=$this->anl
                         and ac.esp_id=$esp
                         and ac.cur_id=$cur
                         and m.mtr_tipo=1
                         order by m.mtr_orden_area, m.mtr_orden_materia
                        ) ";
                    //dd($sql_materias);
                    $materias=DB::select($sql_materias);  //Materias Culturales Y TÉCNICAS


                }

                $sql_par="and m.mat_paralelot=''$paralelo'' ";
                $sql_esp="and m.esp_id=$esp";
                if($esp==7 || $esp==8 || $esp==10){ //SI LA ESPECIALIDAD ES BÁSICA FLEXIBLE BGU O CULTURAL
                    $sql_par="and m.mat_paralelo=''$paralelo'' ";
                    $sql_esp="";
                }
            ////*****************************///////
                if($quim=='Q1' || $quim=='Q2'){ //////CUADROS POR QUIMESTRES
/////////////**************************ENCABEZADO*********************/////////////////////
                            $op=1;
                            $sql_head="";
                            $tx_head="";
                            $datos="";
                            $prd=7;
                            $quim_number=1;
                            if($quim=='Q2'){
                                $prd=8;
                            }
                            if($quim=='Q2'){
                                $quim_number=2;
                            }

                            $cross_head=$this->crosstab_sql_head($materias,$quim_number,$cfg->anl_parciales);
                            $sql_head=$cross_head[0];
                            $tx_head=$cross_head[1];
                            $sql_periodos=$this->sql_periodos_quimestres($cfg->anl_parciales,$quim_number);
/////////////******************************NOTAS****************/////////////////////
                            ////////FALTA PONER CUANDO SEA EXCLUYENTE EL INSUMO 6//////////
                                $sql="SELECT * FROM crosstab('select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id,''&'',m.mat_estado,''&'',m.fecha_asistencia) as estudiante,
                                    CASE
                                    WHEN rn.mtr_id=1 THEN concat(rn.mtr_tec_id,rn.periodo)
                                    WHEN rn.mtr_id<>1 THEN concat(rn.mtr_id,rn.periodo)
                                    END AS mtr_id,
                                    CASE
                                        WHEN count(*)=6 AND rn.periodo<>$prd  THEN sum(rn.nota)/6
                                        WHEN count(*)<6 AND rn.periodo<>$prd  THEN sum(rn.nota)/5
                                    ELSE sum(rn.nota)
                                    END as nota

                                    from matriculas m
                                    join estudiantes e on m.est_id=e.id
                                    left join reg_notas rn on rn.mat_id=m.id
                                    $sql_periodos
                                    where m.anl_id=$anl
                                    and m.jor_id=$jor
                                    and m.cur_id=$cur
                                    $sql_par
                                    $sql_esp
                                    $sql_estado
                                    group by e.est_apellidos,e.est_nombres,rn.mtr_id,rn.mtr_tec_id,rn.periodo,m.id
                                    order by estudiante,rn.mtr_tec_id,rn.periodo
                                    '::text,' $sql_head   '::text)
                                crosstab(estudiante text $tx_head  ); ";
                                //dd($sql);
                                $datos=DB::select($sql);
/////////////******************************COMPORTAMIENTO****************/////////////////////
                                $sql_parcial_comp=$this->sql_periodos_comportamiento($cfg->anl_parciales,$quim_number);
                                $sql_c="
                                SELECT * FROM crosstab('select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id) as estudiante,
                                concat(rn.mtr_id,rn.dsc_parcial),
                                rn.dsc_nota
                                from matriculas m
                                join estudiantes e on m.est_id=e.id
                                left join reg_disciplina rn on rn.mat_id=m.id
                                $sql_parcial_comp[0]
                                where m.anl_id=$anl
                                and m.jor_id=$jor
                                and m.cur_id=$cur
                                $sql_par
                                $sql_esp
                                $sql_estado
                                order by estudiante,rn.mtr_id,rn.dsc_parcial
                                '::text,' $sql_head UNION ALL $sql_parcial_comp[1]  '::text)
                                crosstab(estudiante text $tx_head ,pb31 text,pb32 text,pb33 text);
                                ";

                                //$datos_c=DB::select($sql_c);
                                $datos_c=[];
                                //dd($datos_c);

                }else{ ////PARA PROMEDIOS FINALES SUPLETORIOS REMEDIALES GRACIA
/////////////**************************ENCABEZADO*********************/////////////////////
                            $op=1;
                            $sql_head="";
                            $tx_head="";
                            $datos="";
                            $sql_head_cuadro_final=$this->sql_head_cuadro_final($materias,$cfg->anl_parciales);
                            $sql_head=$sql_head_cuadro_final[0];
                            $tx_head=$sql_head_cuadro_final[1];
/////////////******************************NOTAS****************/////////////////////
                                     $sql="SELECT * FROM crosstab('select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id,''&'',m.mat_estado,''&'',m.fecha_asistencia) as estudiante,
                                    CASE
                                    WHEN rn.mtr_id=1 THEN concat(rn.mtr_tec_id,rn.periodo)
                                    WHEN rn.mtr_id<>1 THEN concat(rn.mtr_id,rn.periodo)
                                    END AS mtr_id,
                                    CASE
                                    WHEN count(*)=6 AND (rn.periodo<>7 and rn.periodo<>8 and rn.periodo<>100 and rn.periodo<>101 and rn.periodo<>102 )  THEN sum(rn.nota)/6
                                    WHEN count(*)<6 AND (rn.periodo<>7 and rn.periodo<>8 and rn.periodo<>100 and rn.periodo<>101 and rn.periodo<>102 )  THEN sum(rn.nota)/5
                                    ELSE sum(rn.nota)
                                    END AS nota
                                    from matriculas m
                                    join estudiantes e on m.est_id=e.id
                                    left join reg_notas rn on rn.mat_id=m.id
                                    where m.anl_id=$anl
                                    and m.jor_id=$jor
                                    and m.cur_id=$cur
                                    $sql_par
                                    $sql_esp
                                    $sql_estado
                                    group by e.est_apellidos,e.est_nombres,rn.mtr_id,rn.mtr_tec_id,rn.periodo,m.id
                                    order by estudiante,rn.mtr_tec_id,rn.periodo
                                    '::text,' $sql_head   '::text)
                                crosstab(estudiante text $tx_head  ); ";
                                $datos=DB::select($sql);
                                //dd($datos);
/////////////******************************COMPORTAMIENTO****************/////////////////////
                                $quim_number=1;// se esta tomando el comportamiento del 1er quimestre
                                $sql_parcial_comp=$this->sql_periodos_comportamiento($cfg->anl_parciales,$quim_number);
                                $sql_c="
                                SELECT * FROM crosstab('select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id) as estudiante,
                                concat(rn.mtr_id,rn.dsc_parcial),
                                rn.dsc_nota
                                from matriculas m
                                join estudiantes e on m.est_id=e.id
                                left join reg_disciplina rn on rn.mat_id=m.id
                                $sql_parcial_comp[0]
                                where m.anl_id=$anl
                                and m.jor_id=$jor
                                and m.cur_id=$cur

                                $sql_par
                                $sql_esp
                                $sql_estado

                                order by estudiante,rn.mtr_id,rn.dsc_parcial
                                '::text,' $sql_head UNION ALL $sql_parcial_comp[1]  '::text)
                                crosstab(estudiante text $tx_head ,pb31 text,pb32 text,pb33 text);
                                ";
                                $datos_c=DB::select($sql_c);
                                //dd($datos_c);

                                // $sql_c="
                                // SELECT * FROM crosstab('select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id) as estudiante,
                                // concat(rn.mtr_id,rn.dsc_parcial),
                                // rn.dsc_nota
                                // from matriculas m
                                // join estudiantes e on m.est_id=e.id
                                // left join reg_disciplina rn on rn.mat_id=m.id
                                // and ( rn.dsc_parcial=1 or rn.dsc_parcial=2 or rn.dsc_parcial=3 )
                                // where m.anl_id=$anl
                                // and m.jor_id=$jor
                                // and m.cur_id=$cur
                                // and m.mat_paralelot=''$paralelo''
                                // and m.esp_id=$esp
                                // $sql_estado
                                // order by estudiante,rn.mtr_id,rn.dsc_parcial
                                // '::text,' $sql_head UNION ALL
                                //             SELECT concat(3,1) AS mtr UNION ALL
                                //             SELECT concat(3,2) AS mtr UNION ALL
                                //             SELECT concat(3,3) AS mtr  '::text)
                                // crosstab(estudiante text $tx_head ,pb31 text,pb32 text,pb33 text);
                                // ";
                                // $datos_c=DB::select($sql_c);
                }

            $jornadas=Jornadas::orderBy('id', 'ASC')->pluck('jor_descripcion', 'id');
            $especialidades=Especialidades::pluck('esp_descripcion', 'id');
            $cursos=Cursos::pluck('cur_descripcion', 'id');
            $eqv_comportamiento=DB::select("SELECT * FROM equivalencia_comportamiento ORDER BY eqc_nota  " );
            ////***MANDAR A LA VISTA O AL EXCEL****/////
            if($dt['btn_buscar']=='btn_buscar'){
                   return view("reportes.reporte_cuadros_finales")
                   ->with('jor',$jornadas)
                   ->with('esp',$especialidades)
                   ->with('cur',$cursos)
                   ->with('materias',$materias)
                   ->with('datos',$datos)
                   ->with('datos_c',$datos_c)
                   ->with('qm',$quim)
                   ->with('ep',$esp);

            }elseif($dt['btn_buscar']=='btn_excel'){

                    $dt_conf=$this->config_encabezado_cuadros($jor,$esp,$cur,$paralelo);
                if($quim=='Q1' || $quim=='Q2'){


                    return view("reportes.cuadros_excelq1")
                    ->with('materias',$materias)
                    ->with('datos',$datos)
                    ->with('datos_c',$datos_c)
                    ->with('conf',$dt_conf)
                    ->with('op',$dt['opcion'])
                    ->with('cur',$cur)
                    ->with('quim_number',$quim_number);

                }else{


                    if($dt['periodo']!='PROM'){



                         // $conf=$dt_conf;
                         // $materias=$materias;
                         // $datos=$datos;
                         // $datos_c=$datos_c;
                         // $quim=$quim;
                         // $op=$dt['opcion'];
                         // $cur=$cur;
                         // $view =  \View::make('reportes.cuadros_excelfinal', compact('conf', 'materias', 'datos','datos_c','quim','op','cur'))->render();
                         // $pdf = \App::make('dompdf.wrapper');
                         // $pdf->loadHTML($view)->setPaper('A3','landscape');
                         // return $pdf->stream('invoice');

                         return view("reportes.cuadros_excelfinal")
                         ->with('conf',$dt_conf)
                         ->with('materias',$materias)
                         ->with('datos',$datos)
                         ->with('datos_c',$datos_c)
                         ->with('quim',$quim)
                         ->with('op',$dt['opcion'])
                         ->with('cur',$cur)
                         ;
                    }else{
                         return view("reportes.cuadros_promociones")
                         ->with('conf',$dt_conf)
                         ->with('materias',$materias)
                         ->with('datos',$datos)
                         ->with('datos_c',$datos_c)
                         ->with('quim',$quim)
                         ->with('op',$dt['opcion'])
                         ->with('eqv_comportamiento',$eqv_comportamiento)
                          ;
                    }

                }


            }


      }



        public function reporte_cuadros_finales_ok_org($dt){
            //$dt=$rq->all();
            ////*****VARIABLES DE INICIO******///////
            $us=Auth::user()->id;
            $datos=[];
            $datos_c=[];
            $materias=[];
            $enc_nota=[];
            $promedios=[];

            $op=$dt["opcion"];
            $jor=$dt["jor_id"];
            $esp=$dt["esp_id"];
            $cur=$dt["cur_id"];
            $paralelo=$dt["paralelo"];

            $quim=$dt["periodo"];

                if($us==85){ ///si es Alexandra Sanni o Super Admin no valida el estado
                    $sql_estado="";
                }else{
                    $sql_estado="and (m.mat_estado=1)";
                }

                $anl=$this->anl;
                if($esp==7){
                    $anl=$this->anl_bgu;
                }
                if($esp==10 || $esp==7 || $esp==8){

                    $materias=DB::select("
                        select ac.mtr_id,m.mtr_descripcion from asg_materias_cursos ac
                        join materias m on ac.mtr_id=m.id
                        where ac.anl_id=$this->anl
                        and ac.esp_id=10
                        and ac.cur_id=$cur
                        and m.mtr_tipo=0
                        order by m.mtr_descripcion
                    ");  //Materias Culturales
                }else{

////////////////////////****************UNIDAS TÉCNICAS Y CULTURALES

                    $materias=DB::select("
                        (SELECT ac.mtr_id,m.mtr_descripcion FROM asg_materias_cursos ac
                        join materias m on ac.mtr_id=m.id
                        where ac.anl_id=$this->anl
                        and ac.esp_id=10
                        and ac.cur_id=$cur
                        and m.mtr_tipo=0
                        order by m.mtr_descripcion )
                        UNION ALL
                        ( SELECT ac.mtr_id,m.mtr_descripcion FROM asg_materias_cursos ac
                         join materias m on ac.mtr_id=m.id
                         where ac.anl_id=$this->anl
                         and ac.esp_id=$esp
                         and ac.cur_id=$cur
                         and m.mtr_tipo=1
                         order by m.mtr_descripcion
                        )

                    ");  //Materias Culturales Y TÉCNICAS


                }


            ////*****************************///////
                if($quim=='Q1'){
/////////////**************************ENCABEZADO*********************/////////////////////
                            $op=1;
                            $sql_head="";
                            $tx_head="";
                            $datos="";
                            $n_mat=count($materias);
                            $x=0;
                                foreach ($materias as $m) {

                                $sql_union=" UNION ALL ";
                                $x++;
                                if($x==$n_mat){
                                    $sql_union=" ";
                                }
                                $sql_head.="SELECT concat($m->mtr_id,1) AS mtr UNION ALL
                                            SELECT concat($m->mtr_id,2) AS mtr UNION ALL
                                            SELECT concat($m->mtr_id,3) AS mtr UNION ALL
                                            SELECT concat($m->mtr_id,7) AS mtr $sql_union ";

                                $tx_head.=",pb".$m->mtr_id."1 text, pb".$m->mtr_id."2 text, pb".$m->mtr_id."3 text, pb".$m->mtr_id."7 text  ";
                            }
/////////////******************************NOTAS****************/////////////////////
                                     $sql="SELECT * FROM crosstab('select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id) as estudiante,
                                    CASE
                                    WHEN rn.mtr_id=1 THEN concat(rn.mtr_tec_id,rn.periodo)
                                    WHEN rn.mtr_id<>1 THEN concat(rn.mtr_id,rn.periodo)
                                    END AS mtr_id,
                                    CASE
                                    WHEN count(*)=6 AND rn.periodo<>7  THEN sum(rn.nota)/6
                                    WHEN count(*)<6 AND rn.periodo<>7  THEN sum(rn.nota)/5
                                    ELSE sum(rn.nota)
                                    END AS nota
                                    from matriculas m
                                    join estudiantes e on m.est_id=e.id
                                    left join reg_notas rn on rn.mat_id=m.id
                                    and ( rn.periodo=1 or rn.periodo=2 or rn.periodo=3 or rn.periodo=7 )
                                    where m.anl_id=$anl
                                    and m.jor_id=$jor
                                    and m.cur_id=$cur
                                    and m.mat_paralelot=''$paralelo''
                                    and m.esp_id=$esp
                                    $sql_estado
                                    group by e.est_apellidos,e.est_nombres,rn.mtr_id,rn.mtr_tec_id,rn.periodo,m.id
                                    order by estudiante,rn.mtr_tec_id,rn.periodo
                                    '::text,' $sql_head   '::text)
                                crosstab(estudiante text $tx_head  ); ";

                                $datos=DB::select($sql);
                                //$datos=DB::select($sql);

/////////////******************************COMPORTAMIENTO****************/////////////////////
                                $sql_c="
                                SELECT * FROM crosstab('select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id) as estudiante,
                                concat(rn.mtr_id,rn.dsc_parcial),
                                rn.dsc_nota
                                from matriculas m
                                join estudiantes e on m.est_id=e.id
                                left join reg_disciplina rn on rn.mat_id=m.id
                                and ( rn.dsc_parcial=1 or rn.dsc_parcial=2 or rn.dsc_parcial=3 )
                                where m.anl_id=$anl
                                and m.jor_id=$jor
                                and m.cur_id=$cur
                                and m.mat_paralelot=''$paralelo''
                                and m.esp_id=$esp
                                $sql_estado
                                order by estudiante,rn.mtr_id,rn.dsc_parcial
                                '::text,' $sql_head UNION ALL
                                            SELECT concat(3,1) AS mtr UNION ALL
                                            SELECT concat(3,2) AS mtr UNION ALL
                                            SELECT concat(3,3) AS mtr  '::text)
                                crosstab(estudiante text $tx_head ,pb31 text,pb32 text,pb33 text);
                                ";
                                $datos_c=DB::select($sql_c);
                }

                if($quim=='Q2'){
/////////////**************************ENCABEZADO*********************/////////////////////
                            $op=1;
                            $sql_head="";
                            $tx_head="";
                            $datos="";
                            $n_mat=count($materias);
                            $x=0;
                                foreach ($materias as $m) {

                                $sql_union=" UNION ALL ";
                                $x++;
                                if($x==$n_mat){
                                    $sql_union=" ";
                                }
                                $sql_head.="SELECT concat($m->mtr_id,4) AS mtr UNION ALL
                                            SELECT concat($m->mtr_id,5) AS mtr UNION ALL
                                            SELECT concat($m->mtr_id,6) AS mtr UNION ALL
                                            SELECT concat($m->mtr_id,8) AS mtr $sql_union ";

                                $tx_head.=",pb".$m->mtr_id."4 text, pb".$m->mtr_id."5 text, pb".$m->mtr_id."6 text, pb".$m->mtr_id."8 text  ";
                            }
/////////////******************************NOTAS****************/////////////////////
                                     $sql="SELECT * FROM crosstab('select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id) as estudiante,
                                    CASE
                                    WHEN rn.mtr_id=1 THEN concat(rn.mtr_tec_id,rn.periodo)
                                    WHEN rn.mtr_id<>1 THEN concat(rn.mtr_id,rn.periodo)
                                    END AS mtr_id,
                                    CASE
                                    WHEN count(*)=6 AND rn.periodo<>8  THEN sum(rn.nota)/6
                                    WHEN count(*)<6 AND rn.periodo<>8  THEN sum(rn.nota)/5
                                    ELSE sum(rn.nota)
                                    END AS nota
                                    from matriculas m
                                    join estudiantes e on m.est_id=e.id
                                    left join reg_notas rn on rn.mat_id=m.id
                                    and ( rn.periodo=4 or rn.periodo=5 or rn.periodo=6 or rn.periodo=8 )
                                    where m.anl_id=$anl
                                    and m.jor_id=$jor
                                    and m.cur_id=$cur
                                    and m.mat_paralelot=''$paralelo''
                                    and m.esp_id=$esp
                                    $sql_estado
                                    group by e.est_apellidos,e.est_nombres,rn.mtr_id,rn.mtr_tec_id,rn.periodo,m.id
                                    order by estudiante,rn.mtr_tec_id,rn.periodo
                                    '::text,' $sql_head   '::text)
                                crosstab(estudiante text $tx_head  ); ";
                                $datos=DB::select($sql);
/////////////******************************COMPORTAMIENTO****************/////////////////////
                                $sql_c="
                                SELECT * FROM crosstab('select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id) as estudiante,
                                concat(rn.mtr_id,rn.dsc_parcial),
                                rn.dsc_nota
                                from matriculas m
                                join estudiantes e on m.est_id=e.id
                                left join reg_disciplina rn on rn.mat_id=m.id
                                and ( rn.dsc_parcial=1 or rn.dsc_parcial=2 or rn.dsc_parcial=3 )
                                where m.anl_id=$anl
                                and m.jor_id=$jor
                                and m.cur_id=$cur
                                and m.mat_paralelot=''$paralelo''
                                and m.esp_id=$esp
                                $sql_estado
                                order by estudiante,rn.mtr_id,rn.dsc_parcial
                                '::text,' $sql_head UNION ALL
                                            SELECT concat(3,1) AS mtr UNION ALL
                                            SELECT concat(3,2) AS mtr UNION ALL
                                            SELECT concat(3,3) AS mtr  '::text)
                                crosstab(estudiante text $tx_head ,pb31 text,pb32 text,pb33 text);
                                ";
                                $datos_c=DB::select($sql_c);
                }


                if($quim=='FIN'){
/////////////**************************ENCABEZADO*********************/////////////////////
                            $op=1;
                            $sql_head="";
                            $tx_head="";
                            $datos="";
                            $n_mat=count($materias);
                            $x=0;
                                foreach ($materias as $m) {

                                    $sql_union=" UNION ALL ";
                                    $x++;
                                    if($x==$n_mat){
                                        $sql_union=" ";
                                    }
                                    $sql_head.="
                                                SELECT concat($m->mtr_id,1) AS mtr UNION ALL
                                                SELECT concat($m->mtr_id,2) AS mtr UNION ALL
                                                SELECT concat($m->mtr_id,3) AS mtr UNION ALL
                                                SELECT concat($m->mtr_id,4) AS mtr UNION ALL
                                                SELECT concat($m->mtr_id,5) AS mtr UNION ALL
                                                SELECT concat($m->mtr_id,6) AS mtr UNION ALL
                                                SELECT concat($m->mtr_id,7) AS mtr UNION ALL
                                                SELECT concat($m->mtr_id,8) AS mtr UNION ALL
                                                SELECT concat($m->mtr_id,100) AS mtr UNION ALL
                                                SELECT concat($m->mtr_id,101) AS mtr UNION ALL
                                                SELECT concat($m->mtr_id,102) AS mtr $sql_union ";

                                    $tx_head.=",pb".$m->mtr_id.
                                       "1 text, pb".$m->mtr_id.
                                       "2 text, pb".$m->mtr_id.
                                       "3 text, pb".$m->mtr_id.
                                       "4 text, pb".$m->mtr_id.
                                       "5 text, pb".$m->mtr_id.
                                       "6 text, pb".$m->mtr_id.
                                       "7 text, pb".$m->mtr_id.
                                       "8 text, pb".$m->mtr_id.
                                       "100 text, pb".$m->mtr_id.
                                       "101 text, pb".$m->mtr_id.
                                       "102 text  ";

                            }
/////////////******************************NOTAS****************/////////////////////
                                     $sql="SELECT * FROM crosstab('select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id) as estudiante,
                                    CASE
                                    WHEN rn.mtr_id=1 THEN concat(rn.mtr_tec_id,rn.periodo)
                                    WHEN rn.mtr_id<>1 THEN concat(rn.mtr_id,rn.periodo)
                                    END AS mtr_id,
                                    CASE
                                    WHEN count(*)=6 AND (rn.periodo<>7 and rn.periodo<>8 and rn.periodo<>100 and rn.periodo<>101 and rn.periodo<>102 )  THEN sum(rn.nota)/6
                                    WHEN count(*)<6 AND (rn.periodo<>7 and rn.periodo<>8 and rn.periodo<>100 and rn.periodo<>101 and rn.periodo<>102 )  THEN sum(rn.nota)/5
                                    ELSE sum(rn.nota)
                                    END AS nota
                                    from matriculas m
                                    join estudiantes e on m.est_id=e.id
                                    left join reg_notas rn on rn.mat_id=m.id
                                    where m.anl_id=$anl
                                    and m.jor_id=$jor
                                    and m.cur_id=$cur
                                    and m.mat_paralelot=''$paralelo''
                                    and m.esp_id=$esp
                                    $sql_estado
                                    group by e.est_apellidos,e.est_nombres,rn.mtr_id,rn.mtr_tec_id,rn.periodo,m.id
                                    order by estudiante,rn.mtr_tec_id,rn.periodo
                                    '::text,' $sql_head   '::text)
                                crosstab(estudiante text $tx_head  ); ";

                                $datos=DB::select($sql);
/////////////******************************COMPORTAMIENTO****************/////////////////////
                                $sql_c="
                                SELECT * FROM crosstab('select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id) as estudiante,
                                concat(rn.mtr_id,rn.dsc_parcial),
                                rn.dsc_nota
                                from matriculas m
                                join estudiantes e on m.est_id=e.id
                                left join reg_disciplina rn on rn.mat_id=m.id
                                and ( rn.dsc_parcial=1 or rn.dsc_parcial=2 or rn.dsc_parcial=3 )
                                where m.anl_id=$anl
                                and m.jor_id=$jor
                                and m.cur_id=$cur
                                and m.mat_paralelot=''$paralelo''
                                and m.esp_id=$esp
                                $sql_estado
                                order by estudiante,rn.mtr_id,rn.dsc_parcial
                                '::text,' $sql_head UNION ALL
                                            SELECT concat(3,1) AS mtr UNION ALL
                                            SELECT concat(3,2) AS mtr UNION ALL
                                            SELECT concat(3,3) AS mtr  '::text)
                                crosstab(estudiante text $tx_head ,pb31 text,pb32 text,pb33 text);
                                ";
                                $datos_c=DB::select($sql_c);
                }


            $jornadas=Jornadas::orderBy('id', 'ASC')->pluck('jor_descripcion', 'id');
            $especialidades=Especialidades::pluck('esp_descripcion', 'id');
            $cursos=Cursos::pluck('cur_descripcion', 'id');

            ////***MANDAR A LA VISTA O AL EXCEL****/////
            if($dt['btn_buscar']=='btn_buscar'){

               return view("reportes.reporte_cuadros_finales")
               ->with('jor',$jornadas)
               ->with('esp',$especialidades)
               ->with('cur',$cursos)
               ->with('materias',$materias)
               ->with('datos',$datos)
               ->with('datos_c',$datos_c)
               ->with('qm',$quim)
               ->with('ep',$esp)
               ;

            }elseif($dt['btn_buscar']=='btn_excel'){

                        $dt_jor=DB::select("SELECT * FROM jornadas WHERE id=".$jor);
                        $dt_esp=DB::select("SELECT * FROM especialidades WHERE id=".$esp);
                        $dt_cur=DB::select("SELECT * FROM cursos WHERE id=".$cur);
                        $dt_enc_xls=[
                            'jor'=>$dt_jor[0]->jor_descripcion,
                            'esp'=>$dt_esp[0]->esp_descripcion,
                            'cur'=>$dt_cur[0]->cur_descripcion,
                            'par'=>$paralelo];

                if($quim=='Q1'){
                         return view("reportes.cuadros_excelq1")
                         ->with('jor',$jornadas)
                         ->with('esp',$especialidades)
                         ->with('cur',$cursos)
                         ->with('materias',$materias)
                         ->with('datos',$datos)
                         ->with('datos_c',$datos_c)
                         ->with('dt_enc_xls',$dt_enc_xls)
                         ;
                }

                if($quim=='Q2'){
                         return view("reportes.cuadros_excelq2")
                         ->with('jor',$jornadas)
                         ->with('esp',$especialidades)
                         ->with('cur',$cursos)
                         ->with('materias',$materias)
                         ->with('datos',$datos)
                         ->with('datos_c',$datos_c)
                         ->with('dt_enc_xls',$dt_enc_xls)
                         ;
                }

                if($quim=='FIN'){
                         return view("reportes.cuadros_excelfinal")
                         ->with('jor',$jornadas)
                         ->with('esp',$especialidades)
                         ->with('cur',$cursos)
                         ->with('materias',$materias)
                         ->with('datos',$datos)
                         ->with('datos_c',$datos_c)
                         ->with('dt_enc_xls',$dt_enc_xls)
                         ;
                }


            }


      }



//**************************************//////////
//NUEVA PROGRAMACIÓN OCTUBRE 2020 REGISTRO DE NOTAS
//*****************************************///////

 public function load_datos($dt) { ///CARGAR DATOS PARA REGISTRO DE NOTAS

    $dt_aux=explode("&",$dt);
    $blq=$dt_aux[4];//OBTENGO EL BLOQUE 7 Y 8 EVALUACIONES 100 NOTAS ADICIONALES
    if($blq<>7 && $blq<>8 && $blq<>100 ){
        //dd('bloque');
        return Response()->json($this->load_datos_bloques($dt));
    }else if($blq==7 || $blq==8){
        //dd('eval');
        return Response()->json($this->load_datos_evaluaciones($dt));
    }else{
        //dd('notas add');
        return Response()->json($this->load_datos_notas_adicionales($dt));
    }

}

 public function load_datos_notas_adicionales($dt) { /////NOTAS POR BLOQUES

             $dt=explode("&",$dt);
             $anl=$this->anl;
             $jor=$dt[0];
             $esp=$dt[6];
             $cur=$dt[1];
             $par=$dt[2];
             $blq=$dt[4];
             $estado=1;
             $mt=$dt[3];
             $anl_ins=$anl;
///**********************CONFIGURACIONES OJO CODIGO REPETIDO************//////////////
             $cfg=DB::select("SELECT * FROM aniolectivo WHERE id=".$anl_ins);
             $cfg_qim=$cfg[0]->anl_quimestres;
             $cfg_blq=$cfg[0]->anl_parciales;
///////////***************************************************///////////////////////
             if($mt==1){
                $mt=$dt[5];
            }
             if($esp==7){
                $anl=$this->anl_bgu;
                $anl_ins=$anl;
            }
            if($anl==7 || $anl==8 || $anl==9 ){//Año lectivo BGU Anteriores a la modificacion
                $anl_ins=3;//Obtengo los insumos del año lectivo 3
            }

            $datos=[$anl,$jor,$esp,$cur,$par,$mt,$estado,$blq,$anl_ins];

            $lista=$this->lista_estudiantes_notas($datos);
            $insumos=$this->insumos_periodo($anl_ins,'I');
            $ins_sup=$this->insumos_periodo($anl_ins,'S');
            $ins_rem=$this->insumos_periodo($anl_ins,'R');
            $ins_gra=$this->insumos_periodo($anl_ins,'G');

            $enc_table=$this->encabezado_table_cross($blq,$cfg[0]->anl_parciales,$cfg_qim,$insumos,$anl_ins);////DEVUELVE EN HTML
            $tx_est=$enc_table;///Encabezado de la tabla
            $c=0;
            foreach ($lista as $l) {
                $c++;
                $aux_est=explode("&",$l->estudiante);
                $tx_est.="<tr>
                            <td>$c</td>
                            <td>$aux_est[0]</td>";
///////////////////**************QUIMESTRE 1***************************////////////////////
                   $sum_promq=0;
                   for ($j=1; $j <= $cfg_blq ; $j++) {
                    $sum_notas=0;$prom_notas=0;$x=0;
                          foreach ($insumos as $i) {
                            $sgl=strtolower($i->ins_siglas."_".$j);
                            $n_val=$l->$sgl;
                            $aux_nt=explode("&",$n_val);
                            $nota=$aux_nt[0];
                            if($i->ins_excluyente==0){
                                $x++;
                            }elseif($i->ins_excluyente==1 && $nota>0 ){
                                $x++;
                            }
                            $sum_notas+=$nota;
                          }
                          if($x==0){$x=1;}
                          $prom_notas=number_format($sum_notas/$x,2);
                          $sum_promq+=$prom_notas;
                          $cls_notas="";
                    }

                        $nota_ev=$l->evq_7;
                        $aux_nt=explode("&",$nota_ev);
                        $nota=$aux_nt[0];
                    // //********PROMEDIO FINAL*****////////
                        $prom_parc=number_format(($sum_promq/$cfg[0]->anl_parciales)*0.8,2);
                        $prom_quim=number_format(($prom_parc+($nota*0.2)),2);
                        $cls_notas=$this->clase_notas($prom_quim);
                        $tx_est.="<td><input type='text' readOnly value='$prom_quim' class='$cls_notas' /></td>";
///////////////////***************QUIMESTTRE 2**************************////////////////////
                   $sum_promq=0;
                   for ($j=($cfg_blq+1); $j <= ($cfg_blq*$cfg_qim) ; $j++) {
                    $sum_notas=0;$prom_notas=0;$x=0;
                          foreach ($insumos as $i) {
                            $sgl=strtolower($i->ins_siglas."_".$j);
                            $n_val=$l->$sgl;
                            $aux_nt=explode("&",$n_val);
                            $nota=$aux_nt[0];
                            if($i->ins_excluyente==0){
                                $x++;
                            }elseif($i->ins_excluyente==1 && $nota>0 ){
                                $x++;
                            }
                            $sum_notas+=$nota;
                          }
                          if($x==0){$x=1;}
                          $prom_notas=number_format($sum_notas/$x,2);
                          $sum_promq+=$prom_notas;
                          $cls_notas="";
                    }

                        $nota_ev=$l->evq_8;
                        $aux_nt=explode("&",$nota_ev);
                        $nota=$aux_nt[0];
                    // //********PROMEDIO FINAL*****////////
                        $prom_parc=number_format(($sum_promq/$cfg[0]->anl_parciales)*0.8,2);
                        $prom_quim2=number_format(($prom_parc+($nota*0.2)),2);
                        $cls_notas=$this->clase_notas($prom_quim);
                        $tx_est.="<td><input type='text' readOnly value='$prom_quim2' class='$cls_notas' /></td>";

///////////////////*****PROMEDIO FINAL QUIMESTRES***********************////////////////////
                        $prom_quimestres=number_format(($prom_quim+$prom_quim2)/2,2);
                        $cls_notas=$this->clase_notas($prom_quimestres);
                        $tx_est.="<td><input type='text' readOnly value='$prom_quimestres' class='$cls_notas' /></td>";
///////////////////*********************NOTAS ADICIONALES********************////////////////////
                        //$prom_final=0;
                        $prom_final=$prom_quimestres;
                        if($prom_quimestres>=7 || $prom_quimestres==0){ ////SI HA APROBADO EL AÑO
                            $tx_est.="<td class='text-center'>-</td><td class='text-center'>-</td><td class='text-center'>-</td><td class='text-right cls_prom_final'>$prom_final</td>";
                        }else{

                            if($prom_final>=5){ //SUPLETORIO

                                $reg_sup=0;$nota_s=0;
                                $aux_sup=explode("&",$l->sup_100);
                                if(isset($aux_sup[1])){   ///SI EXISTE EL SUPLETORIO
                                    $nota_s=number_format($aux_sup[0],2);
                                    $reg_sup=$aux_sup[1];
                                    $clase_sup=$this->clase_notas($nota_s);
                                    $tx_est.="<td><input type='text' mat_id='$aux_est[1]'  ins_id='".$ins_sup[0]->id."' reg_id='$reg_sup'  value='$nota_s' class='$clase_sup txt_notas' blq='100'/></td>";
                                    if($nota_s>=7){ ///SI SUPLETORIO MAYOR= A 7
                                        $tx_est.="<td class='text-center'>-</td><td class='text-center'>-</td><td class='text-right'>7.00</td>";
                                    }else{//REMEDIAL

                                        $reg_rem=0;$nota_r=0;$cls_rem="";
                                        $aux_rem=explode("&",$l->rem_101);
                                        if(isset($aux_rem[1])){//SI EXISTE EL REMEDIAL
                                            $nota_r=$aux_rem[0];$reg_rem=$aux_rem[1];
                                            $cls_rem=$this->clase_notas($nota_r);
                                            $tx_est.="<td><input type='text' mat_id='$aux_est[1]'  ins_id='".$ins_rem[0]->id."' reg_id='$reg_rem' value='$nota_r' class='$cls_rem txt_notas' blq='101'/></td>";
                                            if($nota_r>=7){
                                                $tx_est.="<td class='text-center'>-</td><td class='text-right'>7.00</td>";
                                            }else{///GRACIA

                                                $reg_gra=0;$nota_g=0;$cls_gra="";
                                                $aux_gra=explode("&",$l->gra_102);
                                                if(isset($aux_gra[1])){  ///SI EXITE EL DE GRACIA

                                                    $nota_g=$aux_gra[0];$reg_gra=$aux_gra[1];
                                                    $cls_gra=$this->clase_notas($nota_g);
                                                    $tx_est.="<td><input type='text' mat_id='$aux_est[1]'  ins_id='".$ins_gra[0]->id."' reg_id='$reg_gra' value='$nota_g' class='$cls_gra txt_notas' blq='102' /></td>";
                                                    if($nota_g>=7){
                                                        $tx_est.="<td class='text-right'>7.00</td>";
                                                    }else{
                                                        $tx_est.="<td class='text-right'>$prom_final</td>";
                                                    }

                                                }else{
                                                    $tx_est.="<td><input type='text' mat_id='$aux_est[1]'  ins_id='".$ins_gra[0]->id."' reg_id='$reg_gra' value='$nota_g' class='remedial txt_notas' blq='102' /></td>";
                                                    $tx_est.="<td class='text-right'>$prom_final</td>";
                                                }
                                            }
                                        }else{
                                            $tx_est.="<td><input type='text' mat_id='$aux_est[1]'  ins_id='".$ins_rem[0]->id."' reg_id='$reg_rem' value='$nota_r' class='remedial txt_notas' blq='101' /></td>";
                                            $tx_est.="<td class='text-center'>-</td><td class='text-right'>$prom_final</td>";
                                        }

                                    }

                                }else{
                                    $tx_est.="<td><input type='text' mat_id='$aux_est[1]'  ins_id='".$ins_sup[0]->id."' reg_id='$reg_sup'  value='$nota_s' class='remedial txt_notas' blq='100' /></td>";
                                    $tx_est.="<td class='text-center'>-</td><td class='text-center'>-</td> <td class='text-right'>$prom_final</td>";
                                }

                            }

                            if($prom_final>0 && $prom_final<5){//REMEDIAL
                                        $reg_rem=0;$nota_r=0;$cls_rem="";
                                        $aux_rem=explode("&",$l->rem_101);
                                        if(isset($aux_rem[1])){//SI EXISTE EL REMEDIAL
                                            $nota_r=$aux_rem[0];$reg_rem=$aux_rem[1];
                                            $cls_rem=$this->clase_notas($nota_r);
                                            $tx_est.="<td class='text-center'>-</td><td><input type='text' mat_id='$aux_est[1]'  ins_id='".$ins_rem[0]->id."' reg_id='$reg_rem' value='$nota_r' class='$cls_rem txt_notas' blq='101'/></td>";
                                            if($nota_r>=7){
                                                $tx_est.="<td class='text-center'>-</td><td class='text-right'>7.00</td>";
                                            }else{///GRACIA
                                                $reg_gra=0;$nota_g=0;$cls_gra="";
                                                $aux_gra=explode("&",$l->gra_102);
                                                if(isset($aux_gra[1])){  ///SI EXITE EL DE GRACIA
                                                    $nota_g=$aux_gra[0];$reg_gra=$aux_gra[1];
                                                    $cls_gra=$this->clase_notas($nota_g);
                                                    $tx_est.="<td><input type='text' mat_id='$aux_est[1]'  ins_id='".$ins_gra[0]->id."' reg_id='$reg_gra' value='$nota_g' class='$cls_gra txt_notas' blq='102' /></td>";
                                                    if($nota_g>=7){
                                                        $tx_est.="<td class='text-right'>7.00</td>";
                                                    }else{
                                                        $tx_est.="<td class='text-right'>$prom_final</td>";
                                                    }
                                                }else{
                                                    $tx_est.="<td><input type='text' mat_id='$aux_est[1]'  ins_id='".$ins_gra[0]->id."' reg_id='$reg_gra' value='$nota_g' class='remedial txt_notas' blq='102' /></td>";
                                                    $tx_est.="<td class='text-right'>$prom_final</td>";
                                                }
                                            }
                                        }else{
                                            $tx_est.="<td class='text-center'>-</td><td><input type='text' mat_id='$aux_est[1]'  ins_id='".$ins_rem[0]->id."' reg_id='$reg_rem' value='$nota_r' class='remedial txt_notas' blq='101' /></td>";
                                            $tx_est.="<td class='text-center'>-</td><td class='text-right'>$prom_final</td>";
                                        }


                            }


                        }


                    $tx_est.="</tr>";

                }

            //$tx_est.="";

                return $tx_est;



 }

 public function load_datos_evaluaciones($dt) { /////NOTAS POR BLOQUES


             $dt=explode("&",$dt);
             $anl=$this->anl;
             $jor=$dt[0];
             $esp=$dt[6];
             $cur=$dt[1];
             $par=$dt[2];
             $blq=$dt[4];
             $estado=1;
             $mt=$dt[3];
             $anl_ins=$anl;

///**********************CONFIGURACIONES OJO CODIGO REPETIDO************//////////////
             $cfg=DB::select("SELECT * FROM aniolectivo WHERE id=".$anl_ins);
             $cfg_qim=$cfg[0]->anl_quimestres;
             $cfg_blq=$cfg[0]->anl_parciales;
                if($blq==7){
                      $vl_ini=1;
                      $eq="EQ1";
                  }else{
                      $vl_ini=($cfg_blq+1);
                      $cfg_blq=($cfg_blq*$cfg_qim);
                      $eq="EQ2";
                  }

///////////***************************************************///////////////////////
             if($mt==1){
                $mt=$dt[5];
            }
             if($esp==7){
                $anl=$this->anl_bgu;
                $anl_ins=$anl;
            }
            if($anl==7 || $anl==8 || $anl==9 || $anl==10 ){//Año lectivo BGU Anteriores a la modificacion
                $anl_ins=3;//Obtengo los insumos del año lectivo 3
            }

            //dd($anl_ins);

            $datos=[$anl,$jor,$esp,$cur,$par,$mt,$estado,$blq,$anl_ins];
            $lista=$this->lista_estudiantes_notas($datos);
            $insumos=$this->insumos_periodo($anl_ins,'I');
            $enc_table=$this->encabezado_table_cross($blq,$cfg[0]->anl_parciales,$cfg_qim,$insumos,$anl_ins);
            $tx_est=$enc_table;///Encabezado de la tabla

            $c=0;
            foreach ($lista as $l) {
                $c++;
                $aux_est=explode("&",$l->estudiante);
                $tx_est.="<tr>
                            <td>$c</td>
                            <td>$aux_est[0]</td>";
                    $sum_promq=0;
                   for ($j=$vl_ini; $j <= $cfg_blq ; $j++) {

                    $sum_notas=0;$prom_notas=0;$x=0;

                          foreach ($insumos as $i) {
                            $sgl=strtolower($i->ins_siglas."_".$j);
                            $n_val=$l->$sgl;
                            $aux_nt=explode("&",$n_val);
                            $nota=$aux_nt[0];
                            $reg_id=0;
                            if( isset($aux_nt[1]) ){
                                $reg_id=$aux_nt[1];
                            }

                            if($i->ins_excluyente==0){
                                $x++;
                            }elseif($i->ins_excluyente==1 && $aux_nt[0]>0 ){
                                $x++;
                            }
                            $sum_notas+=$aux_nt[0];

                          }

                          if($x==0){$x=1;}
                          $prom_notas=number_format($sum_notas/$x,2);
                          $cls_notas=$this->clase_notas($prom_notas);
                          $sum_promq+=$prom_notas;
                          $tx_est.="<td><input type='text' readOnly value='$prom_notas' class='$cls_notas' /></td>";
                    }
////********************OBTENGO EL REGISTRO DE LA EVALUACION*************///////////////
                    $ins_ev=$this->insumos_periodo($anl_ins,$eq)[0];
                    $evl="evq_".$blq;
                    $nota_ev=$l->$evl;
                    $aux_nt=explode("&",$nota_ev);
                    $nota=$aux_nt[0];
                    $reg_id=0;
                    if( isset($aux_nt[1]) ){
                        $reg_id=$aux_nt[1];
                    }
                    $cls_notas=$this->clase_notas($nota);
                    //********PROMEDIO FINAL*****////////
                    $prom_parc=number_format(($sum_promq/$cfg[0]->anl_parciales)*0.8,2);
                    $prom_quim=number_format(($prom_parc+($nota*0.2)),2);
                    $cls_notas=$this->clase_notas($prom_quim);
                    $tx_est.="<td>
                                <input type='text' class='txt_notas $cls_notas' value='$nota'
                                mat_id='$aux_est[1]'
                                ins_id='$ins_ev->id'
                                reg_id='$reg_id'
                                maxlength='4'   />
                    </td> <td><input readonly class='$cls_notas tx_promq' value='$prom_quim' /> </td>   </tr>";
///************************************************************///////////////////////
                }

        return $tx_est;
}


 public function clase_notas($nota) { /////NOTAS POR BLOQUES
      $cls_notas="";
    if($nota>=5 && $nota<7 ){
        $cls_notas="supletorio";
    }
    if($nota<5){
       $cls_notas="remedial";
    }
    return $cls_notas;
}

 public function configuraciones_parciales($parcial,$anl,$jor,$insumo=0) { /////ACTIVAR O DESACTIVAR NOTAS
    $hbl_parc="disabled";
        $conf_parc=DB::select("SELECT * FROM parciales where anl_id=$anl and par_numero=$parcial ")[0];

        if($jor==1 && $conf_parc->par_act_m==1 ){
            $hbl_parc="";
        }

        if($jor==3 && $conf_parc->par_act_s==1 ){
            $hbl_parc="";
        }

return $hbl_parc;

  // +"par_id": 7
  // +"anl_id": 4
  // +"par_descripcion": "PARCIAL1"
  // +"par_finicio": "2020-11-29"
  // +"par_ffin": "2020-11-29"
  // +"par_estado": 1
  // +"par_numero": 1
  // +"par_act_m": 0
  // +"par_act_v": 0
  // +"par_act_n": 0
  // +"par_act_s": 1

 }

 public function load_datos_bloques($dt) { /////NOTAS POR BLOQUES
             $dt=explode("&",$dt);
             $anl=$this->anl;
             $jor=$dt[0];
             $esp=$dt[6];
             $cur=$dt[1];
             $par=$dt[2];
             $blq=$dt[4];
             $estado=1;
             $mt=$dt[3];
             $anl_ins=$anl;
///*************CONFIGURACIONES DE los parciales o bloques////////////**************//////

$hbl_notas=$this->configuraciones_parciales($blq,$anl,$jor);

///**********************CONFIGURACIONES OJO CODIGO REPETIDO************//////////////
             $cfg=DB::select("SELECT * FROM aniolectivo WHERE id=".$anl_ins);
             $cfg_qim=$cfg[0]->anl_quimestres;
             $cfg_blq=$cfg[0]->anl_parciales;
///////////***************************************************///////////////////////
             if($mt==1){
                $mt=$dt[5];
            }
             if($esp==7){
                $anl=$this->anl_bgu;
                $anl_ins=$anl;
            }
            if($anl==7 || $anl==8 || $anl==9 || $anl==10 ){//Año lectivo BGU Anteriores a la modificacion
                $anl_ins=3;//Obtengo los insumos del año lectivo 3
            }

            $datos=[$anl,$jor,$esp,$cur,$par,$mt,$estado,$blq,$anl_ins];
            $lista=$this->lista_estudiantes_notas($datos);
            $insumos=$this->insumos_periodo($anl_ins,'I');
            $enc_table=$this->encabezado_table_cross($blq,$cfg_blq,$cfg_qim,$insumos);
            $tx_est=$enc_table;

            $c=0;
            foreach ($lista as $l) {

                $c++;
                $sum_notas=0;$prom_notas=0;$x=0;
                $aux_est=explode("&",$l->estudiante);
                $tx_est.="<tr>
                            <td>$c</td>
                            <td>$aux_est[0]</td>";
                          foreach ($insumos as $i) {

                            $sgl=strtolower($i->ins_siglas."_".$blq);
                            $n_val=$l->$sgl;
                            $aux_nt=explode("&",$n_val);
                            $nota=$aux_nt[0];
                            $reg_id=0;
                            if( isset($aux_nt[1]) ){
                                $reg_id=$aux_nt[1];
                            }
                            if($i->ins_excluyente==0){
                                $x++;
                            }elseif($i->ins_excluyente==1 && $aux_nt[0]>0 ){
                                $x++;
                            }
                            $sum_notas+=$aux_nt[0];
                            $cls_notas=$this->clase_notas($aux_nt[0]);
                            $tx_est.="<td><input type='text' class='txt_notas $cls_notas' $hbl_notas value='$aux_nt[0]'
                                                 mat_id='$aux_est[1]'
                                                 ins_id='$i->id'
                                                 reg_id='$reg_id'
                                                 maxlength='4'
                                      /></td>";
                          }
                          if($x==0){$x=1;}
                          $prom_notas=number_format($sum_notas/$x,2);
                          $cls_notas=$this->clase_notas($prom_notas);
                $tx_est.="<td><input type='text' readOnly value='$prom_notas' style='border:none' class='txt_prom_parcial $cls_notas' /></td></tr>";
            }
        return $tx_est;
}


public function encabezado_table_cross($blq,$cfg_blq,$cfg_qim,$insumos,$anl_ins=""){ ///DEVUELVE EN HTML
        $rst_aux="<thead><tr><th>#</th><th>Estudiantes</th>";

        if($blq==7 || $blq==8 ){ ///SI ES EVALUACION QUIMESTRAL
                if($blq==7){
                      $x=1;
                      $eq="EQ1";
                  }else{
                      $x=($cfg_blq+1);
                      $cfg_blq=($cfg_blq*$cfg_qim);
                      $eq="EQ2";
                  }
                $ins_ev=$this->insumos_periodo($anl_ins,$eq);
                $ins_ev=$ins_ev[0];
                ///dividir el peso de acuerdo al peso de cada parcial
                if($blq==7){
                    $ins_peso=number_format((100-$ins_ev->ins_peso)/$cfg_blq);
                }else{
                    $ins_peso=number_format((100-$ins_ev->ins_peso)/($cfg_blq/$cfg_qim));
                }

                  for ($x; $x <= $cfg_blq ; $x++) {
                  ///CREAR EL ENCABEZADO DEL CROSSS PARA PROMEDIO EVALIACION QUIMESTRAL
                    $rst_aux.="<th title=' '> <i class='btn btn-xs'  >$ins_peso %</i> <br>
                    <small class='btn btn-info btn-xs ' >P$x</small>
                    </th>";
                }
                    $rst_aux.="<th title='$ins_ev->ins_obs'> <i class='btn btn-xs'  >".number_format($ins_ev->ins_peso,2)."%</i> <br>
                    <small class='btn btn-info btn-xs btn_notas_aula_virtual' ins_id='$ins_ev->id' >$ins_ev->ins_siglas</small>
                    </th>";

        }elseif($blq==100){  ///SON NOTAS ADICIONALES

                    $rst_aux.="<th title=''> <i class='btn btn-xs'>50%</i> <br>
                               <small class='btn btn-info btn-xs btn_notas_aula_virtual' ins_id='' >Q1</small></th>";
                    $rst_aux.="<th title=''> <i class='btn btn-xs'>50%</i> <br>
                               <small class='btn btn-info btn-xs btn_notas_aula_virtual' ins_id='' >Q2</small></th>";

                    $rst_aux.="<th title=''> <i class='btn btn-xs'>-</i> <br>
                               <small class='btn btn-info btn-xs btn_notas_aula_virtual' ins_id='' >PROM.Q</small></th>";

                    $rst_aux.="<th title=''> <i class='btn btn-xs'>70%+</i> <br>
                               <small class='btn btn-info btn-xs btn_notas_aula_virtual' ins_id='' >SUP</small></th>";
                    $rst_aux.="<th title=''> <i class='btn btn-xs'>70%+</i> <br>
                               <small class='btn btn-info btn-xs btn_notas_aula_virtual' ins_id='' >REM</small></th>";
                    $rst_aux.="<th title=''> <i class='btn btn-xs'>70%+</i> <br>
                               <small class='btn btn-info btn-xs btn_notas_aula_virtual' ins_id='' >GRA</small></th>";

        }else{   ///SI ES 1 SOLO BLOQUE

            foreach ($insumos as $i) {
                    $rst_aux.="<th title='$i->ins_obs'> <i class='btn btn-xs'  >".number_format($i->ins_peso,2)."%</i> <br>
                    <small class='btn btn-info btn-xs btn_notas_aula_virtual' ins_id='$i->id' >$i->ins_siglas</small>
                    </th>";
            }

        }

       $rst_aux.="<th>FINAL</th></tr></thead>";
       return $rst_aux;


}

public function lista_estudiantes_notas($dt){

$anl=$dt[0];
$jor=$dt[1];
$esp=$dt[2];
$cur=$dt[3];
$par=$dt[4];
$mtr=$dt[5];
$status=$dt[6];
$blq=$dt[7];
$anl_ins=$dt[8];
$insumos=$this->insumos_periodo($anl_ins,'I'); // CONSULTO LOS INSUMOS  PARA EL ENCABEZADO DEL CROSS
//dd($insumos);
///***********CONFIGURACION DEL AÑO LECTIVO /**************/////
$cfg=DB::select("SELECT * FROM aniolectivo WHERE id=".$anl_ins);
$cfg_qim=$cfg[0]->anl_quimestres;
$cfg_blq=$cfg[0]->anl_parciales;
/////*************************************/////////////////////

$sql_esp="";
$sql_materia="and rg.mtr_id=$mtr";
$sql_paralelo="and m.mat_paralelo=''$par'' ";
if($esp<>10 && $esp<>7 && $esp<>8){ //SI ES ESPECIALIDAD TECNICA
    $sql_esp=" and m.esp_id=$esp ";
    $sql_materia="and rg.mtr_tec_id=$mtr";
    $sql_paralelo="and m.mat_paralelot=''$par'' ";
}

$ins_aux="";
$sql_bloque="";
$sql_insumos="";
if($blq<>7 && $blq<>8  && $blq<>100 ){ ///SI ES 1 SOLO BLOQUE O PARCIAL
   $sql_bloque="and rg.periodo=$blq";
   $sql_insumos="select concat(id,''-'',$blq) from insumos where tipo=''I'' and anl_id=$anl_ins order by id";
   ///CREAR EL ENCABEZADO DEL CROSSS
   $ins_aux=$this->encabezado_cross($blq,0,0,$insumos);

}elseif($blq==7 || $blq==8){
        /////////************SI ES EV_BLOQUE 1 O 2 ************/////////////////////////
        $sql_bloque="";

        if($blq==7){ ///***SI ES EV_BLOQUE Q1

                switch ($cfg_blq) {
                    case 1:
                        $sql_bloque="and (rg.periodo=1 or rg.periodo=7)";
                        $sql_insumos="(select concat(id,''-'',1) from insumos where tipo=''I'' and anl_id=$anl_ins order by id)
                        union all
                        (select concat(id,''-'',7) from insumos where tipo=''EQ1'' and anl_id=$anl_ins order by id) ";
                    break;
                    case 2:
                        $sql_bloque="and (rg.periodo=1 or rg.periodo=2 or rg.periodo=7)";
                        $sql_insumos="(select concat(id,''-'',1) from insumos where tipo=''I'' and anl_id=$anl_ins order by id)
                        union all
                        (select concat(id,''-'',2) from insumos where tipo=''I'' and anl_id=$anl_ins order by id)
                        union all
                        (select concat(id,''-'',7) from insumos where tipo=''EQ1'' and anl_id=$anl_ins order by id) ";
                    break;
                    case 3:
                        $sql_bloque="and (rg.periodo=1 or rg.periodo=2 or rg.periodo=3 or rg.periodo=7)";
                        $sql_insumos="(select concat(id,''-'',1) from insumos where tipo=''I'' and anl_id=$anl_ins order by id)
                        union all
                        (select concat(id,''-'',2) from insumos where tipo=''I'' and anl_id=$anl_ins order by id)
                        union all
                        (select concat(id,''-'',3) from insumos where tipo=''I'' and anl_id=$anl_ins order by id)
                        union all
                        (select concat(id,''-'',7) from insumos where tipo=''EQ1'' and anl_id=$anl_ins order by id) ";
                    break;
                }


        }elseif($blq==8) { ///****SI ES EV_BLOQUE Q2

                switch ($cfg_blq) {
                    case 1:
                        $sql_bloque="and (rg.periodo=2 or rg.periodo=8 )";
                        $sql_insumos="(select concat(id,''-'',2) from insumos where tipo=''I'' and anl_id=$anl_ins order by id)
                        union all
                        (select concat(id,''-'',8) from insumos where tipo=''EQ2'' and anl_id=$anl_ins order by id) ";
                    break;
                    case 2:
                        $sql_bloque="and (rg.periodo=3 or rg.periodo=4 or rg.periodo=8 )";
                        $sql_insumos="(select concat(id,''-'',3) from insumos where tipo=''I'' and anl_id=$anl_ins order by id)
                        union all
                        (select concat(id,''-'',4) from insumos where tipo=''I'' and anl_id=$anl_ins order by id)
                        union all
                        (select concat(id,''-'',8) from insumos where tipo=''EQ2'' and anl_id=$anl_ins order by id) ";

                    break;
                    case 3:
                        $sql_bloque="and (rg.periodo=4 or rg.periodo=5 or rg.periodo=6 or rg.periodo=8 )";
                        $sql_insumos="(select concat(id,''-'',4) from insumos where tipo=''I'' and anl_id=$anl_ins order by id)
                        union all
                        (select concat(id,''-'',5) from insumos where tipo=''I'' and anl_id=$anl_ins order by id)
                        union all
                        (select concat(id,''-'',6) from insumos where tipo=''I'' and anl_id=$anl_ins order by id)
                        union all
                        (select concat(id,''-'',8) from insumos where tipo=''EQ2'' and anl_id=$anl_ins order by id) ";

                    break;
                }

        }

        ////////////************EL ENCABEZADO DEL CROSSTAB*****************////////////////
          $ins_aux=$this->encabezado_cross($blq,$cfg_blq,$cfg_qim,$insumos);

}else{ ////*****SI ES NOTAS ADICIONALES*****//////

    $sql_notas_extras="
            union all
            (select concat(id,''-'',100) from insumos where tipo=''S'' and anl_id=$anl_ins order by id)
            union all
            (select concat(id,''-'',101) from insumos where tipo=''R'' and anl_id=$anl_ins order by id)
            union all
            (select concat(id,''-'',102) from insumos where tipo=''G'' and anl_id=$anl_ins order by id)
    ";

    switch ($cfg_blq) {
        case 1:
            $sql_bloque="and (rg.periodo=1 or rg.periodo=7 or rg.periodo=2 or rg.periodo=8 or rg.periodo=100 or rg.periodo=101 or rg.periodo=102)";
            $sql_insumos="(select concat(id,''-'',1) from insumos where tipo=''I'' and anl_id=$anl_ins order by id)
            union all
            (select concat(id,''-'',7) from insumos where tipo=''EQ1'' and anl_id=$anl_ins order by id)
            union all
            (select concat(id,''-'',2) from insumos where tipo=''I'' and anl_id=$anl_ins order by id)
            union all
            (select concat(id,''-'',8) from insumos where tipo=''EQ2'' and anl_id=$anl_ins order by id)
            $sql_notas_extras
            ";


        break;
        case 2:
            $sql_bloque="and (rg.periodo=1 or rg.periodo=2 or rg.periodo=7 or rg.periodo=3 or rg.periodo=4 or rg.periodo=8 or rg.periodo=100 or rg.periodo=101 or rg.periodo=102)";
            $sql_insumos="(select concat(id,''-'',1) from insumos where tipo=''I'' and anl_id=$anl_ins order by id)
            union all
            (select concat(id,''-'',2) from insumos where tipo=''I'' and anl_id=$anl_ins order by id)
            union all
            (select concat(id,''-'',7) from insumos where tipo=''EQ1'' and anl_id=$anl_ins order by id)
            union all
            (select concat(id,''-'',3) from insumos where tipo=''I'' and anl_id=$anl_ins order by id)
            union all
            (select concat(id,''-'',4) from insumos where tipo=''I'' and anl_id=$anl_ins order by id)
            union all
            (select concat(id,''-'',8) from insumos where tipo=''EQ2'' and anl_id=$anl_ins order by id)
            $sql_notas_extras
            ";
        break;
        case 3:
            $sql_bloque="and (rg.periodo=1 or rg.periodo=2 or rg.periodo=3 or rg.periodo=7 or rg.periodo=4 or rg.periodo=5 or rg.periodo=6 or rg.periodo=8 or rg.periodo=100 or rg.periodo=101 or rg.periodo=102)";
            $sql_insumos="(select concat(id,''-'',1) from insumos where tipo=''I'' and anl_id=$anl_ins order by id)
            union all
            (select concat(id,''-'',2) from insumos where tipo=''I'' and anl_id=$anl_ins order by id)
            union all
            (select concat(id,''-'',3) from insumos where tipo=''I'' and anl_id=$anl_ins order by id)
            union all
            (select concat(id,''-'',7) from insumos where tipo=''EQ1'' and anl_id=$anl_ins order by id)
            union all
            (select concat(id,''-'',4) from insumos where tipo=''I'' and anl_id=$anl_ins order by id)
            union all
            (select concat(id,''-'',5) from insumos where tipo=''I'' and anl_id=$anl_ins order by id)
            union all
            (select concat(id,''-'',6) from insumos where tipo=''I'' and anl_id=$anl_ins order by id)
            union all
            (select concat(id,''-'',8) from insumos where tipo=''EQ2'' and anl_id=$anl_ins order by id)
            $sql_notas_extras
            ";

        break;
    }

    ////////////************EL ENCABEZADO DEL CROSSTAB*****************////////////////
    $ins_aux=$this->encabezado_cross($blq,$cfg_blq,$cfg_qim,$insumos);

}

$sql_cross="
        SELECT * FROM crosstab('
        SELECT concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id),concat(rg.ins_id,''-'',rg.periodo),concat(rg.nota,''&'',rg.id) FROM estudiantes e
        join matriculas m on e.id=m.est_id
            and m.anl_id=$anl
            and m.jor_id=$jor
            $sql_esp
            and m.cur_id=$cur
            $sql_paralelo
            and m.mat_estado=$status
            left join reg_notas rg on rg.mat_id=m.id
            $sql_materia
            $sql_bloque
            order by e.est_apellidos,rg.ins_id
        '::text,' $sql_insumos     '::text)
     crosstab(estudiante text $ins_aux   );
";

$est=DB::select($sql_cross);
return $est;

}

public function encabezado_cross($blq,$cfg_blq,$cfg_qim,$insumos){
        $rst_aux="";
        if($blq==7 || $blq==8){ ///SI ES EVALUACION QUIMESTRAL
                if($blq==7){
                      $x=1;
                  }else{
                      $x=($cfg_blq+1);
                      $cfg_blq=($cfg_blq*$cfg_qim);
                  }
                  for ($x; $x <= $cfg_blq ; $x++) {
                   foreach ($insumos as $i) { ///CREAR EL ENCABEZADO DEL CROSSS
                     $rst_aux.=", ".$i->ins_siglas."_".$x. " text";
                 }
                }
                $rst_aux.=", Evq_".$blq. " text";

        }elseif($blq==100){ ///SI ES NOTAS ADICIONALES

                for ($x=1; $x <= $cfg_blq ; $x++) {
                   foreach ($insumos as $i) { ///CREAR EL ENCABEZADO DEL CROSSS
                     $rst_aux.=", ".$i->ins_siglas."_".$x. " text";
                  }
                }
                $rst_aux.=", Evq_7 text";
                for ($x==($cfg_blq+1); $x <= ($cfg_blq*$cfg_qim) ; $x++) {
                   foreach ($insumos as $i) { ///CREAR EL ENCABEZADO DEL CROSSS
                     $rst_aux.=", ".$i->ins_siglas."_".$x. " text";
                  }
                }
                $rst_aux.=", Evq_8 text";
                $rst_aux.=", Sup_100 text";
                $rst_aux.=", Rem_101 text";
                $rst_aux.=", Gra_102 text";

        }else{ ///SI ES 1 SOLO BLOQUE
            foreach ($insumos as $i) {
               $rst_aux.=", ".$i->ins_siglas."_".$blq. " text";
            }
        }

       return $rst_aux;

}


public function lista_estudiantes_notas_org($dt){

$anl=$dt[0];
$jor=$dt[1];
$esp=$dt[2];
$cur=$dt[3];
$par=$dt[4];
$mtr=$dt[5];
$status=$dt[6];
$blq=$dt[7];
$anl_ins=$dt[8];

$insumos=$this->insumos_periodo($anl_ins,'I');
$ins_aux="";
foreach ($insumos as $i) {
    //$ins_aux="I1 text,I2 text,I3 text,I4 text,I5 text,I6 text";
    $ins_aux.=", ".$i->ins_siglas. " text";
}
$sql_esp="";
$sql_materia="and rg.mtr_id=$mtr";
$sql_paralelo="and m.mat_paralelo=''$par'' ";
if($esp<>10 && $esp<>7 && $esp<>8){ //SI ES ESPECIALIDAD TECNICA
    $sql_esp=" and m.esp_id=$esp ";
    $sql_materia="and rg.mtr_tec_id=$mtr";
    $sql_paralelo="and m.mat_paralelot=''$par'' ";
}

$sql_cross="
        SELECT * FROM crosstab('
        SELECT concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id),rg.ins_id,concat(rg.nota,''&'',rg.id) FROM estudiantes e
        join matriculas m on e.id=m.est_id
            and m.anl_id=$anl
            and m.jor_id=$jor
            $sql_esp
            and m.cur_id=$cur
            $sql_paralelo
            and m.mat_estado=$status
        left join reg_notas rg on rg.mat_id=m.id
            $sql_materia
            and rg.periodo=$blq
        order by e.est_apellidos,rg.ins_id
        '::text,' select id from insumos where tipo=''I'' and anl_id=$anl_ins order by id '::text)
                                        crosstab(estudiante text $ins_aux   );  ";
//($sql_cross);
$est=DB::select($sql_cross);
return $est;

}




public function insumos_periodo($anl,$tp){

            $sql="SELECT * FROM insumos WHERE anl_id=$anl AND tipo='$tp' order by ins_siglas ";
            return $insumos=DB::select($sql);
}

public function load_parciales(Request $rq){
    $dt=$rq->all();
    $cfg=DB::select("SELECT * FROM aniolectivo WHERE id=".$dt['anl'])[0];
//dd($cfg);
    $q=$cfg->anl_quimestres;
    $p=$cfg->anl_parciales;
    $et=$cfg->anl_evq_tipo;
    $ep=$cfg->anl_peso_ev;
    $tx_par="";$x=0;
    for ($i=1; $i <= $q; $i++) {

        for ($j=1; $j <= $p; $j++) {
            $x++;
            $tx_par.=" <option value='$x' >Parcial $x</option> ";
        }
        if($et==0){$evt="Exámen";}
        if($et==1){$evt="Proyecto";}
        if($et==2){$evt="Otro";}

        $tx_par.=" <option value='".($i+6)."' >$evt Q$i</option> ";
    }

        $tx_par.=" <option value='100' >Notas Adicionales</option> ";

     return Response()->json( $tx_par );

}


public function guardar_notas(Request $rq){

                $datos=$rq->all();
                $vl=1;
                $mat_id=$datos['matid'];
                $ins_id=$datos['insid'];
                $nota=$datos['nota'];
                $periodo=$datos['periodo'];
                $mtr_id=$datos['mtrid'];
                $mtr_tec_id=$datos['mtrtid'];
                $reg_id=$datos['regid'];//Id del registro de la nota
                $n_blq=$datos['nblq'];

                $fecha = date('Y-m-d');
                $us=Auth::user()->id;
                $data = ['mat_id' => $mat_id,
                'ins_id' => $ins_id,
                'nota' => $nota,
                'mtr_id' => $mtr_id,
                'periodo' => $periodo,
                'usu_id' => $us,
                'f_modific' => $fecha,
                'disciplina' => null,
                'mtr_tec_id' => $mtr_tec_id,
            ];

            if($reg_id==0 && $nota>0){//Guarda Nota
               /////GUARDAR NOTAS
               $notas=$this->regNotasRepository->create($data);
               if($n_blq==1){///modifica notas bloques tecnicos
                    $this->guardar_notas_bloques($n_blq,$data);
               }

            }elseif($reg_id>0 && $nota>0){ //Modifica Nota
                /////MODIFICAR NOTAS
               $notas=$this->regNotasRepository->update($data,$reg_id);
               if($n_blq==1){///modifica notas bloques tecnicos
                    $this->modifica_notas_bloques($data);
               }
            }elseif($reg_id>0 && $nota==0){ //Elimina Nota
                ///ELIMINA NOTAS
                 $notas=$this->regNotasRepository->delete($reg_id);
               if($n_blq==1){///elimina notas bloques tecnicos
                    $this->elimina_notas_bloques($data,$reg_id);
               }
               $vl=0;
                //$notas->id=0;
            }
            if($vl==0){ ///si he eliminado las notas
                return 0;
            }else{
                return $notas->id;
            }

}


public function elimina_notas_bloques($data,$reg_id){

        $not_ant=DB::select("SELECT * FROM reg_notas
            WHERE mat_id=$data[mat_id]
            AND mtr_id=1
            AND mtr_tec_id=$data[mtr_tec_id]
            AND ins_id=$data[ins_id]");
            foreach ($not_ant as $nta) {
                DB::select("DELETE FROM reg_notas WHERE id=$nta->id ");
            }

}

public function modifica_notas_bloques($data){

        $not_ant=DB::select("SELECT * FROM reg_notas
            WHERE mat_id=$data[mat_id]
            AND mtr_id=1
            AND mtr_tec_id=$data[mtr_tec_id]
            AND ins_id=$data[ins_id]");
            foreach ($not_ant as $nta) {
                DB::select("UPDATE reg_notas SET nota=$data[nota] WHERE id=$nta->id ");
            }

}

public function guardar_notas_bloques($blq,$data){

    $cfg=DB::select("SELECT * FROM aniolectivo WHERE id=".$this->anl);
    $cfgblq=($cfg[0]->anl_parciales*$cfg[0]->anl_quimestres);
               if($blq==1){
                        for ($blq=2; $blq <= $cfgblq ; $blq++) {
                             $data['periodo']=$blq;
                                try {
                                    $this->regNotasRepository->create($data);
                                }catch(\Illuminate\Database\QueryException $e){

                                }
                        }
               }


}



public function configuracion_anio_lectivo(Request $req){///PARA CARGAR PARCIALES EN COMBO
    $dt=$req->all();
    $esp=$dt['esp'];
    $anl=$this->anl;
    if($esp==7){
        $anl=$this->anl_bgu;
    }
    $cfg=DB::select("SELECT * FROM aniolectivo WHERE id=$anl ")[0];

    $q=$cfg->anl_quimestres;
    $p=$cfg->anl_parciales;
    $et=$cfg->anl_evq_tipo;
    $ep=$cfg->anl_peso_ev;
    $tx_par="";$x=0;
    for ($i=1; $i <= $q; $i++) {

        for ($j=1; $j <= $p; $j++) {
            $x++;
            $tx_par.=" <option value='$x' >Parcial $x</option> ";
        }
        if($et==0){$evt="Exámen";}
        if($et==1){$evt="Proyecto";}
        if($et==2){$evt="Otro";}

        $tx_par.=" <option value='".($i+6)."' >$evt Q$i</option> ";
    }

        $tx_par.=" <option value='100' >Notas Adicionales</option> ";

     return Response()->json( $tx_par );

}

//////*****************REPORTES **********************////////////////

//////************************************************////////////////
        public function reporte_general_notas(Request $rq){

            // $dt=$rq->all();
            // isset($dt['opcion'])?$op=$dt['opcion']:$op=null;


            // if($op==2 || $op==3 || $op==4){

            //       return $this->reporte_bajo_rendimiento_parcial($rq);

            // }else{

                  return $this->reporte_general_notas_parciales($rq);

            //   }

            //  if( isset($dt['opcion']) ){  ////REPORTES GENERALES POR CURSO Y PARCIAL

            //      return $this->reporte_bajo_rendimiento_parcial($dt);

            //  }else{   ///////////REPORTES DE BAJO RENDIMIENTO

            // //     dd('noooo');
            // }


        }


        public function reporte_bajo_rendimiento_parcial($rq){   /////NUEVA PROGRAMACION REPORTES DE BAJO RENDIMIENTO
            $sql="SELECT m.id,e.est_apellidos,e.est_nombres,mt.mtr_descripcion,i.ins_siglas,rg.nota FROM reg_notas rg
                    join matriculas m on m.id=rg.mat_id and rg.periodo=1
                    join estudiantes e on e.id=m.est_id
                    left join insumos i on i.id=rg.ins_id
                    join materias mt on mt.id=rg.mtr_id
                    where m.anl_id=4
                    and m.jor_id=1
                    and m.cur_id=4
                    and m.mat_paralelo='A'
                    and i.anl_id=4
                    order by e.est_apellidos,mt.mtr_descripcion,i.ins_siglas";
            return DB::select($sql);


        }

        public function reporte_general_notas_parciales($rq){
            $dt=$rq->all();
            $us=Auth::user()->id;
            $datos=[];
            $datos_c=[];
            $materias=[];
            $enc_nota=[];
            $promedios=[];
            $ins_anio=[];
            $esp=0;
            $op=0;
            if(isset($dt['btn_buscar'])){

                        if($us==85){ ///si es Alexandra Sanni o super Admin no valida el estado
                            $sql_estado="";
                        }else{
                            $sql_estado="and (m.mat_estado=1)";
                        }

                        $jor=$dt['jor_id'];
                        $esp=$dt['esp_id'];
                        $cur=$dt['cur_id'];
                        $paralelo=$dt['paralelo'];
                        $per=$dt['periodo'];
                        $anl=$this->anl;
                        if($esp==7){
                                $anl=$this->anl_bgu;
                        }
/***************************ANIOS LECTIVOS********************************/
                        $anl_materias=$anl;
                        $anl_ins_periodos=$anl;
                        $anl_ins_cross=$anl;
                        $anl_crostab=$anl;
                        if($esp==7){
                            $anl_materias=$this->anl;
                            $anl_ins_cross=$this->anl;
                            if($this->anl_bgu==7 || $this->anl_bgu==8 || $this->anl_bgu==9 || $this->anl_bgu==10){ ///Los primeros BGU sin seteo
                                $anl_materias=3;
                                $anl_ins_cross=3;
                                $anl_ins_periodos=3;
                            }
                        }
/*************************************************************************/

                        if($esp==10 || $esp==7 || $esp==8){

                            $materias=DB::select("
                                select ac.mtr_id,m.mtr_descripcion,m.mtr_tipo from asg_materias_cursos ac
                                join materias m on ac.mtr_id=m.id
                                where ac.anl_id=$anl_materias
                                and ac.esp_id=10
                                and ac.cur_id=$cur
                                and m.mtr_tipo=0
                                order by m.mtr_descripcion
                            ");  //Materias Culturales

                }else{

///////////////////////****************UNIDAS TÉCNICAS Y CULTURALES
                    $materias=DB::select("
                         SELECT ac.mtr_id,m.mtr_descripcion,m.mtr_tipo FROM asg_materias_cursos ac
                         join materias m on ac.mtr_id=m.id
                         where ac.anl_id=$anl_materias
                         and ac.esp_id=$esp
                         and ac.cur_id=$cur
                         and m.mtr_tipo=1
                         order by m.mtr_descripcion


                    ");  //Materias Culturales Y TÉCNICAS


                    // $materias=DB::select("
                    //     (SELECT ac.mtr_id,m.mtr_descripcion,m.mtr_tipo FROM asg_materias_cursos ac
                    //     join materias m on ac.mtr_id=m.id
                    //     where ac.anl_id=$this->anl
                    //     and ac.esp_id=10
                    //     and ac.cur_id=$cur
                    //     and m.mtr_tipo=0
                    //     order by m.mtr_descripcion )
                    //     UNION ALL
                    //     ( SELECT ac.mtr_id,m.mtr_descripcion,m.mtr_tipo FROM asg_materias_cursos ac
                    //      join materias m on ac.mtr_id=m.id
                    //      where ac.anl_id=$this->anl
                    //      and ac.esp_id=$esp
                    //      and ac.cur_id=$cur
                    //      and m.mtr_tipo=1
                    //      order by m.mtr_descripcion
                    //     )

                    // ");  //Materias Culturales Y TÉCNICAS
                }

                $ins_anio=$this->insumos_periodo($anl_ins_periodos ,'I');

/////////////**************************ENCABEZADO*********************/////////////////////
                            $sql_h="";
                            $tx_head="";
                            $n_mat=count($materias);
                            $x=0;
                            foreach ($materias as $m) {

                                $x++;
                                $sql_union=" union all ";

                                foreach ($ins_anio as $ia) {
                                    array_push($enc_nota,"nt".$m->mtr_id.$ia->id );
                                    $tx_head.=",nt".$m->mtr_id.$ia->id." text ";
                                }
                                if($x==$n_mat){
                                    $sql_union=" ";
                                }
                                $sql_h.=" SELECT cast(concat($m->mtr_id,id) as integer) as ins from insumos where tipo=''I'' and anl_id=$anl_ins_cross $sql_union ";

                            }

/////////////***********************************************/////////////////////
                if($esp==10 || $esp==7 || $esp==8){//SI ES CULTURAL ->BGU Y BÁSICA FLEXIBLE

                            $sql_esp="and m.esp_id<>8 and m.esp_id<>7";
                            if($esp!=10){
                                $sql_esp="and m.esp_id=$esp";
                            }

/////////////**************************ENCABEZADO*********************/////////////////////
                          if($per==7 || $per==8){

                            // dd($sql_periodos);
                            //     $sql="SELECT * FROM crosstab('select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id,''&'',m.mat_estado,''&'',m.fecha_asistencia) as estudiante,
                            //         CASE
                            //         WHEN rn.mtr_id=1 THEN concat(rn.mtr_tec_id,rn.periodo)
                            //         WHEN rn.mtr_id<>1 THEN concat(rn.mtr_id,rn.periodo)
                            //         END AS mtr_id,
                            //         CASE
                            //             WHEN count(*)=6 AND rn.periodo<>$prd  THEN sum(rn.nota)/6
                            //             WHEN count(*)<6 AND rn.periodo<>$prd  THEN sum(rn.nota)/5
                            //         ELSE sum(rn.nota)
                            //         END as nota
                            //         from matriculas m
                            //         join estudiantes e on m.est_id=e.id
                            //         left join reg_notas rn on rn.mat_id=m.id
                            //         $sql_periodos
                            //         where m.anl_id=$anl
                            //         and m.jor_id=$jor
                            //         and m.cur_id=$cur
                            //         $sql_par
                            //         $sql_esp
                            //         $sql_estado
                            //         group by e.est_apellidos,e.est_nombres,rn.mtr_id,rn.mtr_tec_id,rn.periodo,m.id
                            //         order by estudiante,rn.mtr_tec_id,rn.periodo
                            //         '::text,' $sql_h   '::text)
                            //     crosstab(estudiante text $tx_head  ); ";
                            //     dd($sql);
                                //$datos=DB::select($sql);

                                   //  $sql="
                                   //  SELECT * FROM crosstab('
                                   //  select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id) as estudiante,
                                   //  concat(rn.mtr_id,rn.ins_id) mtr_ins,rn.nota
                                   //  from matriculas m
                                   //  join estudiantes e on m.est_id=e.id
                                   //  left join reg_notas rn on rn.mat_id=m.id
                                   //  and rn.mtr_tec_id=0
                                   //  and rn.periodo=$per
                                   //  where m.anl_id=$anl_crostab
                                   //  and m.jor_id=$jor
                                   //  and m.cur_id=$cur
                                   //  and m.mat_paralelo=''$paralelo''
                                   //  $sql_esp
                                   //  $sql_estado
                                   //  order by estudiante,rn.mtr_id,rn.ins_id,m.id
                                   //  '::text,' $sql_h  '::text)
                                   //  crosstab(estudiante text $tx_head  );";
                                   // dd($sql);

                                   $datos=DB::select($sql);
                                }else{ ///SI ES CUALQUIER PARCIAL CULTURAL


                                    $sql="
                                    SELECT * FROM crosstab('
                                    select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id) as estudiante,
                                    concat(rn.mtr_id,rn.ins_id) mtr_ins,rn.nota
                                    from matriculas m
                                    join estudiantes e on m.est_id=e.id
                                    left join reg_notas rn on rn.mat_id=m.id
                                    and rn.mtr_tec_id=0
                                    and rn.periodo=$per
                                    where m.anl_id=$anl_crostab
                                    and m.jor_id=$jor
                                    and m.cur_id=$cur
                                    and m.mat_paralelo=''$paralelo''
                                    $sql_esp
                                    $sql_estado
                                    order by estudiante,rn.mtr_id,rn.ins_id,m.id
                                    '::text,' $sql_h  '::text)
                                    crosstab(estudiante text $tx_head  );";
                                   $datos=DB::select($sql);

                                   $promedios=DB::select("
                                    SELECT * FROM crosstab('
                                    select concat(''Prom'') as estudiante,
                                    concat(rn.mtr_id,rn.ins_id) mtr_ins,
                                    sum(rn.nota)/count(*) as nota
                                    from matriculas m
                                    join estudiantes e on m.est_id=e.id
                                    left join reg_notas rn on rn.mat_id=m.id
                                    and rn.mtr_tec_id=0
                                    and rn.periodo=$per
                                    where m.anl_id=$anl_crostab
                                    and m.jor_id=$jor
                                    and m.cur_id=$cur
                                    and m.mat_paralelo=''$paralelo''
                                    $sql_esp
                                    $sql_estado
                                    group by rn.mtr_id,rn.ins_id
                                    order by rn.mtr_id,rn.ins_id

                                    '::text,' $sql_h  '::text)
                                    crosstab(estudiante text $tx_head  );
                                    ");



                               }

                         }else{ //SI ES CUALQUIER PARCIAL TÉCNICO


                                $sql="
                                        SELECT * FROM crosstab('
                                        select concat(e.est_apellidos,'' '',e.est_nombres,''&'',m.id) as estudiante,
                                        CASE
                                        WHEN rn.mtr_id=1 THEN concat(rn.mtr_tec_id,rn.ins_id)
                                        WHEN rn.mtr_id<>1 THEN concat(rn.mtr_id,rn.ins_id)
                                        END AS mtr_ins,
                                        rn.nota
                                        from matriculas m
                                        join estudiantes e on m.est_id=e.id
                                        left join reg_notas rn  on rn.mat_id=m.id
                                        and rn.periodo=$per
                                        where m.anl_id=$anl_crostab
                                        and m.jor_id=$jor
                                        and m.esp_id=$esp
                                        and m.cur_id=$cur
                                        and m.mat_paralelot=''$paralelo''
                                        $sql_estado
                                        order by estudiante,rn.mtr_tec_id,rn.ins_id
                                        '::text,' $sql_h  '::text)
                                        crosstab(estudiante text $tx_head  );
                                        ";
                                        //DD($sql);
                                       $datos=DB::select($sql);
                                        $promedios=[];

                                       $promedios=DB::select("
                                        SELECT * FROM crosstab('
                                        select concat(''Prom '') as estudiante,
                                        CASE
                                        WHEN rn.mtr_id=1 THEN concat(rn.mtr_tec_id,rn.ins_id)
                                        WHEN rn.mtr_id<>1 THEN concat(rn.mtr_id,rn.ins_id)
                                        END AS mtr_ins,
                                        sum(rn.nota)/count(*) as nota
                                        from reg_notas rn
                                        join matriculas m on rn.mat_id=m.id
                                        join estudiantes e on m.est_id=e.id
                                        and rn.periodo=$per
                                        where m.anl_id=$anl_crostab
                                        and m.jor_id=$jor
                                        and m.esp_id=$esp
                                        and m.cur_id=$cur
                                        and m.mat_paralelot=''$paralelo''
                                        group by rn.mtr_id,rn.mtr_tec_id,rn.ins_id
                                        order by estudiante,rn.mtr_tec_id,rn.ins_id
                                        '::text,' $sql_h  '::text)
                                        crosstab(estudiante text $tx_head  );
                                        ");

//                                 }


                         }
            }


            $jor=Jornadas::orderBy('id', 'ASC')->pluck('jor_descripcion', 'id');
            $cmb_esp=Especialidades::pluck('esp_descripcion', 'id');
            $cur=Cursos::pluck('cur_descripcion', 'id');

            $resultado=$this->reporte_html($datos,$materias,$enc_nota,$ins_anio,$promedios);

            if(isset($dt['btn_buscar']) && $dt['btn_buscar']=='btn_excel'){



                $datos=($dt['datos_excel']);
                    Excel::create('Reporte', function($excel) use($datos) {
                        $excel->sheet('Lista', function($sheet) use($datos) {
                            $sheet->loadView("reportes.reporte_general_notas_excel")
                            ->with('datos',$datos)
                            ;
                        });
                    })->export('xls');

            }


            if(isset($dt['btn_buscar']) && $dt['btn_buscar']=='btn_bajo_supl'){

                $dt_conf=$this->config_encabezado_cuadros($dt['jor_id'],$dt['esp_id'],$dt['cur_id'],$dt['paralelo']);

                            return view('reportes.reporte_general_notas_estadistica')
                            ->with('jorn',$jor)
                            ->with('esp',$esp)
                            ->with('cur',$cur)
                            ->with('datos',$datos)
                            ->with('dt_conf',$dt_conf)
                            ->with('materias',$materias)

                            ;
            }


            return view('reportes.reporte_general_notas')
            ->with('jor',$jor)
            ->with('cmb_esp',$cmb_esp)
            ->with('esp',$esp)
            ->with('cur',$cur)
            ->with('resultado',$resultado)
            // ->with('datos_c',$datos_c) ////REVISAR OJO
            // ->with('materias',$materias)
            // ->with('enc_nota',$enc_nota)
            // ->with('promedios',$promedios)
            ->with('op',$op)
            ;
        }


public function reporte_html($datos,$materias,$enc_nota,$ins_anio,$promedios){
//dd($enc_nota);
$html_ins="";
$colsp=count($ins_anio);// Numero de columnas de colspan
$ins_exc=0;
foreach ($ins_anio as $i) {//Armo el encabezado de insumo de la tabla
  $html_ins.="<th class='ins cls_insumo'>$i->ins_siglas</th>";
  if($i->ins_excluyente==1){
    $ins_exc=$i->id;
  }
}
// $html_ins.="<th class='ins cls_insumo'>PROM</th>";

$rst="<table class='table table-hover' id='tbl_datos' style='width:auto;''>";
$rst.="<colgroup>";
$rst.="<col span='2'>";
$x=1;$clsh='';
    foreach ($materias as $m) { ///armo el encabezado de materias de la tabla
                    $x++;
                    if($x%2==0){
                      $clsh='bg-info';
                    }else{
                      $clsh='';
                    }
                    $rst.="<col span='".($colsp+1)."' class='$clsh' >";
    }
$rst.="</colgroup>";

$rst.="<tr>";
$rst.="<th colspan='2'>Estudiante</th>";
foreach($materias as $m){
    $rst.="<th colspan='".($colsp+1)."' class='text-center cls_materias'>$m->mtr_descripcion</th>";
}
$rst.="</tr>";
$rst.="<tr>";
$rst.="<th>#</th>";
$rst.="<th style='color:#fff;' >------------------------------------------------------------------------------</th>";
foreach($materias as $m){
  $rst.=$html_ins;
  $rst.="<th>Prom</th>";
}
$rst.="<th>Prom Final</th>";

$x=0;
if(!empty($datos)){

        foreach($datos as $d){
                $dt_est=explode('&',$d->estudiante);
                $x++;
                    $rst.="<tr>";
                      $rst.="<td>$x</td>";
                      $rst.="<td>$dt_est[0]</td>";
                      $c=0;
                      $aux_prom=0;
                      $prom_est=0;
                      $prom=0;
                foreach($enc_nota as $enc){
                      $c++;
                      $nota=number_format($d->$enc,2);
                      $aux_prom+=$nota;
                      $cls_nota='';
                      if(empty($d->$enc)){
                        $nota='-';
                      }else{
                          $cls_nota=$this->clase_notas($nota);
                      }

                      if($c==$colsp){

                        // if($ins_exc==0){
                        //        $div=$colsp;
                        // }else{
                        //        $div=($colsp-1);
                        // }

                        if($nota>0){
                               $div=$colsp;
                        }else{
                               $div=($colsp-1);
                        }

                       $cls_prom='';
                          $prom=number_format(($aux_prom/$div),2);
                          $cls_prom=$this->clase_notas($prom);
                          $prom_est+=$prom;
                          $rst.="<td class='text-right $cls_nota cls_insumo'>$nota</td>";
                          $rst.="<td class='text-right $cls_prom '  data-toggle='tooltip' data-placement='top' title='' data-original-title=' $dt_est[0] ' >$prom</td>";
                          $c=0;
                          $aux_prom=0;
                      }else{
                        $rst.="<td class='text-right $cls_nota cls_insumo '>$nota</td>";
                      }
                }
                    $cls_prom_est=$this->clase_notas(number_format(($prom_est/count($materias)),2));
                    $rst.="<td class='text-right $cls_prom_est cls_insumo '>".number_format(($prom_est/count($materias)),2)."</td>";
                    $rst.="</tr>";
        }

//PROMEDIO
            $rst.="<tr>";
                    $rst.="<th colspan='2'>Promedio</th>";
                           $i=0;$aux_cnt=0;
                           $aux_prom_nota=0;
                           $prom_nota=0;
                           $nt_prom=0;
                           $prom_general_curso=0;
                      foreach($enc_nota as $enc){
                          $i++;
                          $nt_prom=number_format($promedios[0]->$enc,2);
                          $aux_prom_nota+=$nt_prom;
                          $cls_prom='';
                          if($nt_prom==0){
                            $nt_prom='-';
                           }else{
                            $cls_prom=$this->clase_notas($nt_prom);
                          }

                          if($i==$colsp){

                            if($ins_exc==0){
                              $div=$colsp;
                            }else{
                              $div=($colsp-1);
                            }
                            $prom_nota=number_format(($aux_prom_nota/$div),2);
                            $cls_prom=$this->clase_notas($prom_nota);
                            $prom_general_curso+=$prom_nota;
                            $rst.="<th class='cls_insumo'>$nt_prom</th>";
                            $rst.="<th class='text-right $cls_prom'>$prom_nota</th>";
                            $i=0;$prom_nota=0;$aux_prom_nota=0;$aux_cnt++;

                          }else{
                              $rst.="<th class='text-right $cls_prom cls_insumo'>$nt_prom</th>";
                          }

                      }
                         $cls_prom_gen="";
                         $cls_prom_gen=$this->clase_notas(($prom_general_curso)/$aux_cnt);

                          $rst.="<th class='$cls_prom_gen'>".number_format(($prom_general_curso)/$aux_cnt,2)."</th>";
                    $rst.="</tr>";
//FIN PROMEDIOS

}else{
$rst.="<tr><th colspan='10' class='bg-danger'>NO EXISTEN DATOS</th></tr>";
}
$rst.="</table>";


return $rst;



}


public function reporte_legalizaciones()
{
    $jor=Jornadas::orderBy('id', 'ASC')->pluck('jor_descripcion', 'id');
    $esp=Especialidades::orderBy('id', 'DESC')->pluck('esp_descripcion', 'id');
    $cur=Cursos::orderBy('id', 'ASC')->pluck('cur_descripcion', 'id');
    return view('reportes.menu_legalizaciones')
    ->with('esp',$esp)
    ->with('jor',$jor)
    ->with('cur',$cur)
    ;
}




public function lista_reporte_legalizaciones(Request $req){
    $dt=$req->all();
    $op=$dt['op_print'];
    $tpr=$dt['tp_report'];
    switch ($tpr) {
        case 0:
            return $this->lista_matriculados($dt);
        break;
        case 1:
            return $this->matriculas_individuales($dt);
        break;
    }
}

public function matriculas_individuales($dt){
    $lista=$this->lista_estudiantes($dt);
    $dt_conf=$this->config_encabezado_cuadros($dt['jor_id'],$dt['esp_id'],$dt['cur_id'],$dt['par_id']);

    return view('reportes.matriculas_individuales')
     ->with('lista',$lista)
     ->with('conf',$dt_conf)
     ->with('op',$dt['op_print']);
}

public function lista_matriculados($dt)
{
    //$this->asignacion_folio();

     $lista=$this->lista_estudiantes($dt);
     $dt_conf=$this->config_encabezado_cuadros($dt['jor_id'],$dt['esp_id'],$dt['cur_id'],$dt['par_id']);
     $op=0;
     if(isset($dt['excel'])){
         $op=1;
     }
     if($dt['cur_id']==1 || $dt['cur_id']==2 || $dt['cur_id']==3){
       $tp_cur=0;
     }elseif($dt['cur_id']==4 || $dt['cur_id']==5){
       $tp_cur=1;
     }else{
       $tp_cur=2;
   }
    return view('reportes.nomina_matriculados')
     ->with('lista',$lista)
     ->with('conf',$dt_conf)
     ->with('tp_cur',$tp_cur)
     ->with('op',$op);

}

public function asignacion_folio(){
    //Matutina Básica
    // $lista=DB::select("SELECT e.est_apellidos,m.id,m.jor_id,m.cur_id,m.mat_paralelo,m.mat_estado
    //                     from matriculas m join estudiantes e on m.est_id=e.id
    //                     where m.anl_id=3 and m.cur_id<4 and (m.mat_estado=1 or m.mat_estado=2)
    //                     order by m.jor_id,m.cur_id,m.mat_paralelo,e.est_apellidos");
    //Matutina Bachillerato
    // $lista=DB::select("SELECT e.est_apellidos,m.id,m.jor_id,m.esp_id,m.cur_id,m.mat_paralelot,m.mat_estado
    //                     from matriculas m join estudiantes e on m.est_id=e.id
    //                     where m.anl_id=3 and m.cur_id>3 and (m.mat_estado=1 or m.mat_estado=2)
    //                     order by m.jor_id,m.esp_id,m.cur_id,m.mat_paralelot,e.est_apellidos");
    $nfolio=215;
    $nest=0;
        foreach ($lista as $l){
            $nest++;
            if($nest%2==0){
                $nfolio++;
            }

            //echo $nest.' - '.$nfolio.'<br>';
            DB::select("UPDATE matriculas set mat_folio=$nfolio where id=$l->id ");
        }



}

public function lista_estudiantes($dt){
    $AUD = new Auditoria();
    $jor=$dt['jor_id'];
    $esp=$dt['esp_id'];
    $cur=$dt['cur_id'];
    $par=$dt['par_id'];
    $anl=$this->anl;
    $estado=0;//SIN FILTRAR ESTADO
    if($esp==7){
        $anl=$this->anl_bgu;
    }

  $data=[$anl,$jor,$esp,$cur,$par,$estado];
  return $lista=$AUD->buscador_estudiantes($data);

}

public function configuracion_periodo_lectivo($esp){
///***********CONFIGURACION DEL AÑO LECTIVO /**************/////
    $anl=$this->anl;
    if($esp==7){
        $anl=$this->anl_bgu;
    }
    return $cfg=DB::select("SELECT * FROM aniolectivo WHERE id=".$anl)[0];
/////*************************************/////////////////////
}

public function crosstab_sql_head($materias,$quim,$cfg_blq){
    $sql_head="";
    $tx_head="";
    $x=0;
    $n_mat=count($materias);
    if($quim==1){

        foreach ($materias as $m) {
            $sql_union=" UNION ALL ";
            $x++;
            if($x==$n_mat){
                $sql_union=" ";
            }
            switch ($cfg_blq) {
                case 1:
                        $sql_head.="SELECT concat($m->mtr_id,1) AS mtr UNION ALL
                        SELECT concat($m->mtr_id,7) AS mtr $sql_union ";
                        $tx_head.=",pb".$m->mtr_id."1 text,pb".$m->mtr_id."7 text  ";
                break;
                case 2:
                        $sql_head.="SELECT concat($m->mtr_id,1) AS mtr UNION ALL
                        SELECT concat($m->mtr_id,2) AS mtr UNION ALL
                        SELECT concat($m->mtr_id,7) AS mtr $sql_union ";
                        $tx_head.=",pb".$m->mtr_id."1 text, pb".$m->mtr_id."2 text, pb".$m->mtr_id."7 text  ";
                break;
                case 3:
                        $sql_head.="SELECT concat($m->mtr_id,1) AS mtr UNION ALL
                        SELECT concat($m->mtr_id,2) AS mtr UNION ALL
                        SELECT concat($m->mtr_id,3) AS mtr UNION ALL
                        SELECT concat($m->mtr_id,7) AS mtr $sql_union ";
                        $tx_head.=",pb".$m->mtr_id."1 text, pb".$m->mtr_id."2 text, pb".$m->mtr_id."3 text, pb".$m->mtr_id."7 text  ";
                break;

            }
        }
    }

    if($quim==2){

        foreach ($materias as $m) {
            $sql_union=" UNION ALL ";
            $x++;
            if($x==$n_mat){
                $sql_union=" ";
            }
            switch ($cfg_blq) {
                case 1:
                        $sql_head.="SELECT concat($m->mtr_id,2) AS mtr UNION ALL
                        SELECT concat($m->mtr_id,8) AS mtr $sql_union ";
                        $tx_head.=",pb".$m->mtr_id."2 text,pb".$m->mtr_id."8 text  ";
                break;
                case 2:
                        $sql_head.="SELECT concat($m->mtr_id,3) AS mtr UNION ALL
                        SELECT concat($m->mtr_id,4) AS mtr UNION ALL
                        SELECT concat($m->mtr_id,8) AS mtr $sql_union ";
                        $tx_head.=",pb".$m->mtr_id."3 text, pb".$m->mtr_id."4 text, pb".$m->mtr_id."8 text  ";
                break;
                case 3:
                        $sql_head.="SELECT concat($m->mtr_id,4) AS mtr UNION ALL
                        SELECT concat($m->mtr_id,5) AS mtr UNION ALL
                        SELECT concat($m->mtr_id,6) AS mtr UNION ALL
                        SELECT concat($m->mtr_id,8) AS mtr $sql_union ";
                        $tx_head.=",pb".$m->mtr_id."4 text, pb".$m->mtr_id."5 text, pb".$m->mtr_id."6 text, pb".$m->mtr_id."8 text  ";
                break;

            }
        }


    }



    return array($sql_head,$tx_head);

}

public function sql_periodos_quimestres($cfg_blq,$quim,$op=0){

    if($quim==1){
        switch ($cfg_blq) {
            case 1:
            $sql_bloque="and (rn.periodo=1 or rn.periodo=7)";
            break;
            case 2:
            $sql_bloque="and (rn.periodo=1 or rn.periodo=2 or rn.periodo=7)";
            break;
            case 3:
            $sql_bloque="and (rn.periodo=1 or rn.periodo=2 or rn.periodo=3 or rn.periodo=7)";
            break;
        }
    }elseif($quim==2){
        switch ($cfg_blq) {
            case 1:
            $sql_bloque="and (rn.periodo=2 or rn.periodo=8)";
            break;
            case 2:
            $sql_bloque="and (rn.periodo=3 or rn.periodo=4 or rn.periodo=8)";
            break;
            case 3:
            $sql_bloque="and (rn.periodo=4 or rn.periodo=5 or rn.periodo=6 or rn.periodo=8)";
            break;
        }
    }
    return $sql_bloque;
}


public function sql_periodos_comportamiento($cfg_blq,$quim){

    $sql_bloque="";
    $sql_head_bloque="";//ADICIONAL PARA EL HEAD DEL CROSSS DEL COMPORTAMIENTO
    if($quim==1){
        switch ($cfg_blq) {
            case 1:
            $sql_bloque="and (rn.dsc_parcial=1)";
            $sql_head_bloque="SELECT concat(3,1) AS mtr ";
            break;
            case 2:
            $sql_bloque="and (rn.dsc_parcial=1 or rn.dsc_parcial=2)";
            $sql_head_bloque="SELECT concat(3,1) AS mtr UNION ALL
                         SELECT concat(3,2) AS mtr  ";
            break;
            case 3:
            $sql_bloque="and (rn.dsc_parcial=1 or rn.dsc_parcial=2 or rn.dsc_parcial=3)";
            $sql_head_bloque="SELECT concat(3,1) AS mtr UNION ALL
                         SELECT concat(3,2) AS mtr UNION ALL
                         SELECT concat(3,3) AS mtr ";
            break;
        }
    }elseif($quim==2){
        switch ($cfg_blq) {
            case 1:
            $sql_bloque="and (rn.dsc_parcial=2)";
            $sql_head_bloque="SELECT concat(3,2) AS mtr ";
            break;
            case 2:
            $sql_bloque="and (rn.dsc_parcial=3 or rn.dsc_parcial=4)";
            $sql_head_bloque="SELECT concat(3,3) AS mtr UNION ALL
                         SELECT concat(3,4) AS mtr ";
            break;
            case 3:
            $sql_bloque="and (rn.dsc_parcial=4 or rn.dsc_parcial=5 or rn.dsc_parcial=6)";
            $sql_head_bloque="SELECT concat(3,4) AS mtr UNION ALL
                         SELECT concat(3,5) AS mtr UNION ALL
                         SELECT concat(3,6) AS mtr ";
            break;
        }
    }
    return array($sql_bloque,$sql_head_bloque);

}


public function sql_head_cuadro_final($materias,$cfg_blq){

    $x=0;
    $sql_head="";
    $tx_head="";
    $n_mat=count($materias);
    foreach ($materias as $m) {

        $sql_union=" UNION ALL ";
        $x++;
        if($x==$n_mat){
            $sql_union=" ";
        }

                switch ($cfg_blq) {

                    case 1:

                    $sql_head.="
                    SELECT concat($m->mtr_id,1) AS mtr UNION ALL
                    SELECT concat($m->mtr_id,2) AS mtr UNION ALL
                    SELECT concat($m->mtr_id,7) AS mtr UNION ALL
                    SELECT concat($m->mtr_id,8) AS mtr UNION ALL
                    SELECT concat($m->mtr_id,100) AS mtr UNION ALL
                    SELECT concat($m->mtr_id,101) AS mtr UNION ALL
                    SELECT concat($m->mtr_id,102) AS mtr $sql_union ";

                    $tx_head.=",pb".$m->mtr_id.
                    "1 text, pb".$m->mtr_id.
                    "2 text, pb".$m->mtr_id.
                    "7 text, pb".$m->mtr_id.
                    "8 text, pb".$m->mtr_id.
                    "100 text, pb".$m->mtr_id.
                    "101 text, pb".$m->mtr_id.
                    "102 text  ";
                    break;

                    case 2:

                    $sql_head.="
                    SELECT concat($m->mtr_id,1) AS mtr UNION ALL
                    SELECT concat($m->mtr_id,2) AS mtr UNION ALL
                    SELECT concat($m->mtr_id,3) AS mtr UNION ALL
                    SELECT concat($m->mtr_id,4) AS mtr UNION ALL
                    SELECT concat($m->mtr_id,7) AS mtr UNION ALL
                    SELECT concat($m->mtr_id,8) AS mtr UNION ALL
                    SELECT concat($m->mtr_id,100) AS mtr UNION ALL
                    SELECT concat($m->mtr_id,101) AS mtr UNION ALL
                    SELECT concat($m->mtr_id,102) AS mtr $sql_union ";

                    $tx_head.=",pb".$m->mtr_id.
                    "1 text, pb".$m->mtr_id.
                    "2 text, pb".$m->mtr_id.
                    "3 text, pb".$m->mtr_id.
                    "4 text, pb".$m->mtr_id.
                    "7 text, pb".$m->mtr_id.
                    "8 text, pb".$m->mtr_id.
                    "100 text, pb".$m->mtr_id.
                    "101 text, pb".$m->mtr_id.
                    "102 text  ";


                    break;
                    case 3:
                    $sql_head.="
                    SELECT concat($m->mtr_id,1) AS mtr UNION ALL
                    SELECT concat($m->mtr_id,2) AS mtr UNION ALL
                    SELECT concat($m->mtr_id,3) AS mtr UNION ALL
                    SELECT concat($m->mtr_id,4) AS mtr UNION ALL
                    SELECT concat($m->mtr_id,5) AS mtr UNION ALL
                    SELECT concat($m->mtr_id,6) AS mtr UNION ALL
                    SELECT concat($m->mtr_id,7) AS mtr UNION ALL
                    SELECT concat($m->mtr_id,8) AS mtr UNION ALL
                    SELECT concat($m->mtr_id,100) AS mtr UNION ALL
                    SELECT concat($m->mtr_id,101) AS mtr UNION ALL
                    SELECT concat($m->mtr_id,102) AS mtr $sql_union ";

                    $tx_head.=",pb".$m->mtr_id.
                    "1 text, pb".$m->mtr_id.
                    "2 text, pb".$m->mtr_id.
                    "3 text, pb".$m->mtr_id.
                    "4 text, pb".$m->mtr_id.
                    "5 text, pb".$m->mtr_id.
                    "6 text, pb".$m->mtr_id.
                    "7 text, pb".$m->mtr_id.
                    "8 text, pb".$m->mtr_id.
                    "100 text, pb".$m->mtr_id.
                    "101 text, pb".$m->mtr_id.
                    "102 text  ";

                    break;

                }
    }

    return array($sql_head,$tx_head);

}


public function config_encabezado_cuadros($jor,$esp,$cur,$par){

    //?$ger_id=2:$ger_id=1;///SE DEBE PONER UNA VARIABLE PARA LA GERENCIA
    if($jor==1 || $jor==4 ){ //si la jornada en Matutina o Vespertina

        $ger_id=1;

    }else{

        $ger_id=2;

    }

    $gerencias=DB::select("SELECT * FROM erp_gerencia where ger_id=$ger_id");

    $jornadas=DB::select("SELECT * FROM jornadas where id=".$jor);
    $especialidades=DB::select("SELECT * FROM especialidades where id=".$esp);
    $cursos=DB::select("SELECT * FROM cursos where id=".$cur);


    $dt_conf=[];
    $dt_conf['distrito']=$gerencias[0]->ger_distrito;
    $dt_conf['institucion']=$gerencias[0]->ger_nombre_original;
    $dt_conf['amie']=$gerencias[0]->ger_codigo;
    $dt_conf['titulo']=$especialidades[0]->esp_tipo_titulo;
    $dt_conf['rector']=$gerencias[0]->ger_rector;
    $dt_conf['secretaria']=$gerencias[0]->ger_secretaria;
    $dt_conf['jornada']=$jornadas[0]->jor_descripcion;
    $dt_conf['especialidad']=$especialidades[0]->esp_descripcion;
    $dt_conf['esp_descripcion_general']=$especialidades[0]->esp_descripcion_general;
    $dt_conf['curso']=$cursos[0]->nombre_general;
    $dt_conf['paralelo']=$par;
    $dt_conf['anio_lectivo']=$this->anl_desc;
    $dt_conf['cur_id']=$cur;
    $dt_conf['cur_siguiente']="";
    if($cur<6){
        $cursos_siguiente=DB::select("SELECT * FROM cursos where id=".($cur+1));
        $dt_conf['cur_siguiente']=$cursos_siguiente[0]->nombre_general;
    }


    return $dt_conf;
}

public function elimina_notas_quimestres(Request $rq){
    //return 120;
    $dt=$rq->all();

    if($dt['matid']>0){
        ////////////************verificar la configuracion de acuerdo a los parciales
        if($dt['quim']=='Q1'){
            $sql_elimina="DELETE from reg_notas where mat_id=$dt[matid] and (periodo<4 or periodo=7)";
        }else{
            $sql_elimina="DELETE from reg_notas where mat_id=$dt[matid] and (periodo>=4 or periodo=8)";
        }
        DB::select($sql_elimina);

    }

return 0;

}


}




