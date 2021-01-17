<?php
namespace App\Http\Controllers;
use App\Http\Requests\CreateOrdenesPensionRequest;
use App\Http\Requests\UpdateOrdenesPensionRequest;
use App\Repositories\OrdenesPensionRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Maatwebsite\Excel\Facades\Excel;
use Response;
use PDF;
use App\Models\Jornadas;
use App\Models\Especialidades;
use App\Models\Estudiantes;
use App\Models\AnioLectivo;
use Illuminate\Support\Facades\DB;
use App\Models\OrdenesPension;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuarios;
use App\Models\Auditoria;
use App\Models\Matriculas;

class OrdenesPensionController extends AppBaseController
{
    /** @var  OrdenesPensionRepository */
    private $ordenesPensionRepository;
    private $anl;
    private $anl_desc;
    private $periodo_id;
    public function __construct(OrdenesPensionRepository $ordenesPensionRepo)
    {
        $this->ordenesPensionRepository = $ordenesPensionRepo;
        $anl = AnioLectivo::find(Session::get('anl_id'));
        $this->anl = $anl['id'];
        $this->anl_desc = $anl['anl_descripcion'];
        $this->periodo_id=Session::get('periodo_id');
    }
    public function index(Request $request)
    {
        $ordenesPensions=DB::select("select identificador,obs,anl_id from ordenes_pension 
                                    where (anl_id=".$this->anl." or anl_id=".$this->periodo_id." )
                                    group by identificador,obs,anl_id
                                    order by identificador desc
            ");
        $jornadas = Jornadas::orderBy('jor_descripcion', 'ASC')->pluck('jor_descripcion', 'id');
        return view('ordenes_pensions.index')
               ->with('ordenesPensions', $ordenesPensions)
               ->with('jornadas', $jornadas);

    }

    public function busca_est($cedula){
        $anl = AnioLectivo::where('anl_selected', '=', 1)->get();
        $anl_id = $this->anl;
        return $est = DB::select("select *,m.id as mat_id from estudiantes e, matriculas m, jornadas j, cursos c, especialidades es
            where m.est_id=e.id
            and m.jor_id=j.id
            and m.cur_id=c.id
            and m.esp_id=es.id
            and m.anl_id=$anl_id
            and m.mat_estado=1
            and e.est_cedula='$cedula'
            ");
       
    }


    public function busca_varios_est($cedula){
        $anl_id = $this->anl;
        $anl_bgu = $this->periodo_id;
        $est = DB::select("select *,m.id as mat_id from estudiantes e, matriculas m, jornadas j, cursos c, especialidades es
            where m.est_id=e.id
            and m.jor_id=j.id
            and m.cur_id=c.id
            and m.esp_id=es.id
            and (m.anl_id=$anl_id or m.anl_id=$anl_bgu)
            and m.mat_estado=1
            and (e.est_cedula like '%$cedula%' or e.est_apellidos like '%$cedula%' or e.est_nombres like '%$cedula%')
            ");
        return response()->json($est);
    }    

    public function busca_varios_est2($op,$cedula){
        $anl_id = $this->anl;
        $anl_bgu = $this->periodo_id;
        $est = DB::select("select *,m.id as mat_id from estudiantes e, matriculas m, jornadas j, cursos c, especialidades es
            where m.est_id=e.id
            and m.jor_id=j.id
            and m.cur_id=c.id
            and m.esp_id=es.id
            and (m.anl_id=$anl_id or m.anl_id=$anl_bgu)
            and m.mat_estado=1
            and (e.est_cedula like '%$cedula%' or e.est_apellidos like '%$cedula%' or e.est_nombres like '%$cedula%')
            ");
        return response()->json($est);
    }

    public function busca_pagos($op,$dt){
        $dat=explode("&",$dt);
        $pagos=DB::select("select pr.*,m.jor_id from 
            pago_rubros pr JOIN matriculas m ON pr.per_id=m.id
            where pr.rub_id=$dat[0] 
            and pr.per_id=$dat[1]  ");
        
        return response()->json($pagos);
    }



    public function novedades_ord($idt){

        return $est = DB::select("select 
            op.id as ord_id,
            j.jor_descripcion,
            es.esp_descripcion,
            c.cur_descripcion,
            m.mat_paralelot,
            e.est_cedula,
            e.est_apellidos,
            e.est_nombres,
            op.valor,
            op.identificador,
            op.codigo,
            op.mat_id,
            op.motivo
            from ordenes_pension op, matriculas m, estudiantes e, cursos c,jornadas j,especialidades es
            where op.mat_id=m.id
            and m.est_id=e.id
            and m.cur_id=c.id
            and m.jor_id=j.id
            and m.esp_id=es.id
            and m.mat_estado=1
            and op.identificador='$idt' 
            and CHAR_LENGTH(TRIM(op.motivo))>1
            ORDER BY es.esp_descripcion,c.id,m.mat_paralelot,e.est_apellidos  ");

    }

    public function busca_ord($idt){

        return $est = DB::select("select 
op.id as ord_id,
j.jor_descripcion,
es.esp_descripcion,
c.cur_descripcion,
m.mat_paralelot,
e.est_cedula,
e.est_apellidos,
e.est_nombres,
op.valor,
op.identificador,
op.codigo,
op.mat_id,
op.motivo
from ordenes_pension op, matriculas m, estudiantes e, cursos c,jornadas j,especialidades es
where op.mat_id=m.id
and m.est_id=e.id
and m.cur_id=c.id
and m.jor_id=j.id
and m.esp_id=es.id
and m.mat_estado=1
and op.identificador='$idt' ORDER BY es.esp_descripcion,c.id,m.mat_paralelot,e.est_apellidos  ");
    }


    public function genera_ord($dt){
        $idt=DB::select('select identificador from ordenes_pension 
            group by identificador
            order by identificador desc limit 1');

        if(empty($idt)){
            $nidt=1;
            $txt='00000';
        }else{ //ojo solo hasta el millon revisar cuantas ordenes se hace anuales
            $arr_idt=explode('-',$idt[0]->identificador);
            $nidt=($arr_idt[1]*1)+1;
            if($nidt>0 && $nidt<10){
                $txt='00000';
            }else if($nidt>=10 && $nidt<100){
                $txt='0000';
            }else if($nidt>=100 && $nidt<1000){
                $txt='000';
            }else if($nidt>=1000 && $nidt<10000){
                $txt='00';
            }else if($nidt>=10000 && $nidt<100000){
                $txt='0';
            }else if($nidt>=100000 && $nidt<1000000){
                $txt='';
            }
        }
        $identificador='ORD-'.$txt.$nidt;

     $ord=null;

//dd($dt);

if(!empty($ord)){
    return 1;
}else{

        $usu = Auth::user();
        $anl_id = $this->anl;
        $dat=explode('_', $dt);
        $tipo='';
        $mes=$dat[1];

        switch ($dat[0]) {
            case '0':
                $tipo='ME';//Mensualidad
            break;
            case '1':
                $tipo='MA';//Matricula
            break;
            case '2':
                $tipo='OT';//Otro
            break;
        }

        switch ($dat[2]) {
            case '1':
            $jr='M';
            break;
            case '2':
            $jr='N';
            break;
            case '3':
            $jr='S';
            break;
            case '4':
            $jr='V';
            break;
        }
        $op='RG';
        if($dat[3]==1){ ///si es bgu
            $periodo=DB::select("select * from aniolectivo where id=".$this->periodo_id);
            $op='BG';
            $this->anl_desc=substr($periodo[0]->m_desde,0,2).$periodo[0]->a_desde.'-'.substr($periodo[0]->m_hasta,0,2).$periodo[0]->a_hasta;
        }

        $obs=$op.'-'.$tipo.'-'.$mes.'-'.$jr.'-'.$this->anl_desc;

        $c=0;
        $datos=[];

            $tx_esp='and m.esp_id<>10';
        if($dat[3]==1){ // si es bgu
            $tx_esp='and m.esp_id=7';
            $anl_id=$this->periodo_id;
        }


        $est = DB::select("select e.est_cedula,
                    e.est_apellidos,
                    e.est_nombres,
                    es.esp_obs,
                    vp.valor,
                    m.cur_id,
                    m.id as mat_id,
                    m.anl_id
                    from estudiantes e,
                    matriculas m,
                    jornadas j,
                    especialidades es,
                    valor_pensiones vp
                    where m.est_id=e.id
                    and m.jor_id=j.id
                    and m.esp_id=es.id
                    and vp.id=$dat[2] 
                    and m.anl_id=$anl_id
                    and m.mat_estado=1
                    and m.jor_id=$dat[2]
                    $tx_esp
                    order by es.esp_obs,m.cur_id,e.est_apellidos asc ");


                    switch ($dat[1]) {
                        case 'S':$ms=2; break;
                        case 'O':$ms=3; break;
                        case 'N':$ms=4; break;
                        case 'D':$ms=5; break;
                        case 'E':$ms=6; break;
                        case 'F':$ms=7; break;
                        case 'MZ':$ms=8; break;
                        case 'A':$ms=9; break;
                        case 'MY':$ms=10; break;
                        case 'J':$ms=11; break;
                        case 'JL':$ms=12; break;
                        case 'AG':$ms=13; break;
                    }
                    if($dat[0]==1){
                        $dat[1]='M';
                        $ms=1;
                    }
                    foreach ($est as $e) {

                        $motivo="";                            
                        if($tipo=='MA'){
                            $cod='MTG'.$jr;
                            if($jr=='M' || $jr=='V'){
                                $e->valor=7000;
                            }else{
                                $e->valor=5500;
                            }
                        }else{

                            $cod=$dat[1].'G'.$jr.$e->cur_id.$e->esp_obs;
                            if($res_ant=DB::select("
                                SELECT * FROM ordenes_pension WHERE mat_id=$e->mat_id and anl_id=".$this->anl." and tipo=0 order by cast(mes as integer) desc limit 1    ")){
                                $e->valor=$res_ant[0]->valor;
                                $motivo=$res_ant[0]->motivo;
                                if (!empty($res_ant)) {
                                    # code...
                                    $e->valor=$res_ant[0]->valor;
                                    $motivo=$res_ant[0]->motivo;
                                }
                            }

                        }



                            $input=array(
                                'anl_id' => $e->anl_id,
                                'mat_id' => $e->mat_id,
                                'fecha' => date("d-m-Y"),
                                'mes' => $ms,
                                'codigo' => $cod,
                                'valor' => $e->valor,
                                'fecha_pago' => NULL,
                                'tipo' => '0',
                                'estado' => '0',
                                'responsable' => $usu->name,
                                'obs' => $obs,
                                'identificador'=>$identificador,            
                                'motivo'=>$motivo            
                            );

                            if($res=$this->ordenesPensionRepository->create($input)){
                                array_push($datos,$res->id);
                            }else{
                                $c++;
                            }


                        }

                        }

                        if($c>0){
                           return 0;
                       }else{
                           return response()->json(['obs' => $obs, 'identificador' => $identificador]);
                       }


    }

public function update_orden($dt){
    $dat=explode("&",$dt);
    $id=$dat[0];
    $input['valor']=$dat[1];
    $input['motivo']=$dat[2];
         $ordenesPension = $this->ordenesPensionRepository->update($input, $id);
    return response()->json(0);
}

public function delete_este($dt){
    $dat=explode("&",$dt);
    $id=$dat[0];
    $this->ordenesPensionRepository->delete($id);
    return 0;
}

public function add_est($dt){
    //2999&ORD-000001&50&prueba
    $usu = Auth::user();
    $dat=explode("&",$dt);
    $mat_id=$dat[0];
    $ord=$dat[1];
    $valor=$dat[2];
    $codigo=$dat[3];
    $motivo=$dat[4];

    $orden=DB::select("select mes,obs from ordenes_pension where identificador='$ord' group by mes,obs limit 1 ");
        $input['anl_id']=$this->anl;
        $input['mat_id']=$mat_id;
        $input['fecha']=date('Y-m-d');
        $input['mes']=$orden[0]->mes;
        $input['codigo']=$codigo;
        $input['valor']=$valor;
        // $input['fecha_pago']=;
        $input['tipo']=2;//Otro
        $input['estado']=0;
        $input['responsable']=$usu->usu_apellidos." ".$usu->name;
        $input['obs']=$orden[0]->obs;
        $input['identificador']=$ord;
        $input['motivo']=$motivo;

        $ordenesPension = $this->ordenesPensionRepository->create($input);

    return 0;
}

public function add_est_ord_ind($dt){
    
//    3886& ORD-IND-2018-2019& ORD-000003& codigo& 700& prueba

    $usu = Auth::user();
    $dat=explode("&",$dt);
    $mat_id=$dat[0];
    $ord=$dat[1];
    $identificador=$dat[2];
    $codigo=$dat[3];
    $valor=$dat[4];
    $motivo=$dat[5];

        $input['anl_id']=$this->anl;
        $input['mat_id']=$mat_id;
        $input['fecha']=date('Y-m-d');
        // $input['mes']=null;
        $input['codigo']=$codigo;
        $input['valor']=$valor;
        // $input['fecha_pago']=;
        $input['tipo']=2;//Otro
        $input['estado']=0;
        $input['responsable']=$usu->usu_apellidos." ".$usu->name;
        $input['obs']=$ord;
        $input['identificador']=$identificador;
        $input['motivo']=$motivo;

         $ordenesPension = $this->ordenesPensionRepository->create($input);

         $ord=$this->busca_ord($identificador);

         return response()->json($ord);
         //return 0;
}

    public function create()
    {
        return view('ordenes_pensions.create');
    }

    public function excel(Request $req)
    {

         $dt=$req->all();
//dd($dt);
         if(isset($dt['del_ord'])){

            $this->elimina_ord($dt['identificador']);

         }else{
                $idt=$req->all()['identificador'];
                $orden=DB::select("select op.id as ord_id,e.est_cedula,e.est_apellidos,e.est_nombres,op.valor,op.identificador,op.codigo,op.mat_id from ordenes_pension op, matriculas m, estudiantes e
                   where op.mat_id=m.id
                   and m.est_id=e.id
                   and op.identificador='$idt' ");

                if(isset($dt['pdf_novedades'])){

                        $orden=$this->novedades_ord($idt);
                        $pdf = PDF::loadView('reportes.ord_novedades', [
                            'orden' => $orden,
                            'noorden' => $idt
                        ]);
                        return $pdf->stream();                
                }else{

                        Excel::create('orden_'.$idt, function($excel) use($orden) {
                            $excel->sheet('Lista', function($sheet) use($orden) {
                                $sheet->loadView('reportes.orden_pension')
                                        ->with('orden', $orden);
                            });
                        })->export('xls');      
                }
         }

    }


    public function elimina_ord(Request $req){
        $dat=$req->all();
        $ord=$dat['identificador'];
         $resp=DB::select("SELECT * FROM ordenes_pension where identificador='$ord' and estado=1 ");
        if(empty($resp)){
            DB::select("delete from ordenes_pension where identificador='$ord' ");
        }else{
            //Flash::error('Ordenes Pension no se puede eliminar');
            dd('Ordenes Pension no se puede eliminar ya tiene pagos registrados');
        }

             return redirect(route('ordenesPensions.index'));
    }

    public function store($request)
    {

        $input = $request->all();
        $ordenesPension = $this->ordenesPensionRepository->create($request);
        $datos = implode("-", array_flatten($ordenesPension['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"OrdenesPension","acc"=>"Insertar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        

        Flash::success('Ordenes Pension saved successfully.');
        return redirect(route('ordenesPensions.index'));

    }

    /**
     * Display the specified OrdenesPension.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $ordenesPension = $this->ordenesPensionRepository->findWithoutFail($id);

        if (empty($ordenesPension)) {
            Flash::error('Ordenes Pension not found');

            return redirect(route('ordenesPensions.index'));
        }

        return view('ordenes_pensions.show')->with('ordenesPension', $ordenesPension);
    }

    /**
     * Show the form for editing the specified OrdenesPension.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $ordenesPension = $this->ordenesPensionRepository->findWithoutFail($id);

        if (empty($ordenesPension)) {
            Flash::error('Ordenes Pension not found');

            return redirect(route('ordenesPensions.index'));
        }

        return view('ordenes_pensions.edit')->with('ordenesPension', $ordenesPension);
    }

    /**
     * Update the specified OrdenesPension in storage.
     *
     * @param  int              $id
     * @param UpdateOrdenesPensionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOrdenesPensionRequest $request)
    {
        $ordenesPension = $this->ordenesPensionRepository->findWithoutFail($id);

        if (empty($ordenesPension)) {
            Flash::error('Ordenes Pension not found');

            return redirect(route('ordenesPensions.index'));
        }

        $ordenesPension = $this->ordenesPensionRepository->update($request->all(), $id);
        $datos = implode("-", array_flatten($ordenesPension['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"OrdenesPension","acc"=>"Modificar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        

        Flash::success('Ordenes Pension updated successfully.');

        return redirect(route('ordenesPensions.index'));
    }

public function genera_num_orden(){
        $idt=DB::select('select identificador from ordenes_pension 
            group by identificador
            order by identificador desc limit 1');  

        if(empty($idt)){
            $nidt=1;
            $txt='00000';
        }else{ //ojo solo hasta el millon revisar cuantas ordenes se hace anuales
            $arr_idt=explode('-',$idt[0]->identificador);
            $nidt=($arr_idt[1]*1)+1;
            if($nidt>0 && $nidt<10){
                $txt='00000';
            }else if($nidt>=10 && $nidt<100){
                $txt='0000';
            }else if($nidt>=100 && $nidt<1000){
                $txt='000';
            }else if($nidt>=1000 && $nidt<10000){
                $txt='00';
            }else if($nidt>=10000 && $nidt<100000){
                $txt='0';
            }else if($nidt>=100000 && $nidt<1000000){
                $txt='';
            }
        }
        $identificador='ORD-'.$txt.$nidt;
        return response()->json([$identificador,$this->anl_desc]);            

}
  
    public function destroy(Request $req)
    {
        $data=$req->all();
        DB::select("delete from ordenes_pension where identificador='$data[identificador]' ");
        return redirect(route('ordenesPensions.index'));
    }

    public function generar_matriculas_provisionales_nuevo_anio(Request $req){
        
        $est=DB::select("SELECT * FROM matriculas where cur_id<>6 and anl_id=".$this->anl." and mat_estado=1 ");//Solo matriculasdos NO BGU y NO 3eros
        //$est=DB::select("SELECT * FROM matriculas where id=5248");
        foreach ($est as $e) {
            $new_cur=($e->cur_id+1);
            if($e->esp_id==8){
                $new_cur=4;
            }
            $Mat=new Matriculas();
            $Mat->est_id=$e->est_id;
            $Mat->anl_id=($e->anl_id+1);
            $Mat->esp_id=$e->esp_id;
            $Mat->cur_id=$new_cur;
            $Mat->jor_id=$e->jor_id;
            $Mat->proc_id=1;
            $Mat->dest_id=1;
            $Mat->mat_paralelo='NINGUNO';
            $Mat->mat_paralelot='NINGUNO';
            $Mat->mat_estado=1;
            $Mat->mat_obs='MATRICULA PROVISIONAL';
            $Mat->est_tipo='ANTIGUO';
            $Mat->responsable='LUCIA COLLAGUAZO';
            $Mat->plantel_procedencia='UETVN';
            $Mat->docs=$e->docs;
            try {
                $Mat->save();
                Flash::success('Generado correctamente');
            } catch (\Illuminate\Database\QueryException $ex) {
                //Flash::error('Error: '.$ex);
                die(substr($ex,0,150));
                
            }
        }

        return redirect(route('ordenesPensions.index'));




    }

}
