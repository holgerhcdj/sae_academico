<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePagoPensionesRequest;
use App\Http\Requests\UpdatePagoPensionesRequest;
use App\Repositories\PagoPensionesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\DB;
use App\Models\Auditoria;
use App\Models\Jornadas;
use App\Models\Cursos;
use App\Models\Especialidades;
use App\Models\AnioLectivo;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\QueryException;


class PagoPensionesController extends AppBaseController
{
    /** @var  PagoPensionesRepository */
    private $pagoPensionesRepository;
    private $anl;
    private $anl_bgu;

    public function __construct(PagoPensionesRepository $pagoPensionesRepo)
    {
        $this->pagoPensionesRepository = $pagoPensionesRepo;
        $this->anl=Session::get('anl_id');
        $this->anl_bgu=Session::get('periodo_id');

    }

    public function index(Request $req)
    {
         $data=$req->all();
         if(isset($data['search']) || isset($data['search_impr'])){
         $j=$data['jor_id'];
         $c=$data['cur_id'];
         $p=$data['par_id'];
         $e=$data['esp_id'];
         $anl=$this->anl;
         if($e==7){
           $anl=$this->anl_bgu;
         }
         $e==7?$p.='BG':'';
         $e==8?$p.='BS':'';

         $dirigente=DB::select("select * from asg_dirigentes a 
                                join users u on a.usu_id=u.id
                                where a.anl_id=$anl 
                                and a.cur_id=$c
                                and a.par_id='$p'
                                and a.jor_id=$j
                                and a.tipo=0                                
                                ");

            if($data['esp_id']=='0'){
                $tx_par=" and m.mat_paralelo=''$data[par_id]''";
                $tx_esp=" and m.esp_id<>7 and m.esp_id<>8";
            }else{
                if($data['esp_id']=='7' || $data['esp_id']=='8'){
                   $tx_par=" and m.mat_paralelo=''$data[par_id]''";
                }else{
                   $tx_par=" and m.mat_paralelot=''$data[par_id]''";
                }
                $tx_esp=" and m.esp_id=".$data['esp_id'];
            }

            $sql_pagpp="
                SELECT * FROM crosstab('
                select e.est_apellidos|| '' '' ||e.est_nombres|| ''&'' ||op.mat_id ,cast(op.mes as integer),op.estado 
                from matriculas m 
                join ordenes_pension op on m.id=op.mat_id 
                join estudiantes e on e.id=m.est_id
                where m.anl_id=$anl
                and m.jor_id=$j
                and m.cur_id=$c
                $tx_par
                $tx_esp
                and m.mat_estado=1
                group by e.est_apellidos,e.est_nombres,cast(op.mes as integer),op.mat_id,op.estado
                order by 1,2 
                '::text, 'select l from generate_series(1,13) l'::text) crosstab(est text, mt text, s text, o text, n text, d text, e text, f text, mz text, a text, my text, j text, jl text, ag text);";

            $pagoPensiones=DB::select($sql_pagpp);

         }elseif(isset($data['rep_gen'])){

         $j=$data['jor_id'];
         $c=$data['cur_id'];
         $p=$data['par_id'];
         $e=$data['esp_id'];
         $anl=$this->anl;
         if($e==7){
           $anl=$this->anl_bgu;
         }         
            $jor=Jornadas::find($j);
            $cur=Cursos::find($c);
            $esp_desc="";
            if($e>0){
                $esp=Especialidades::find($e);
                $esp_desc=$esp->esp_descripcion;
            }
            $datos=[$jor->jor_descripcion,$esp_desc,$cur->cur_descripcion,$p];

                DB::select("truncate table tmp_pagos");
                $this->reporte_general($data);
                $head=DB::select("SELECT rubro FROM tmp_pagos GROUP BY rubro,mes order by mes");
                $txhead=[];
                $tx_cr="";
                foreach ($head as $h) {
                    $d=explode("&",$h->rubro);
                    array_push($txhead,$d[1]);
                    $tx_cr.=$d[1]." text,";
                }
                $tx_cr=substr($tx_cr,0,-1);

                try {
                    $data=DB::select("
                        SELECT * FROM crosstab('
                        select persona,rubro,sum(valor) from tmp_pagos 
                        group by persona,rubro
                        order by 1,2 
                        '::text, 'select rubro from tmp_pagos group by rubro,mes order by mes '::text) crosstab(est text, $tx_cr );            
                        ");
                } catch (QueryException $e) {
                    return view("errors.query_errors")
                    ->with('err',$e->errorInfo);
                }


                return view("pago_pensiones.rep_gen_pagos")
                ->with('data',$data)
                ->with('txhead',$txhead)
                ->with('datos',$datos)
                ;

         }elseif(isset($data['rep_mgen'])){

         $j=$data['jor_id'];
         $c=$data['cur_id'];
         $e=$data['esp_id'];
         $p=$data['par_id'];
         $anl=$this->anl;
         if($e==7){
           $anl=$this->anl_bgu;
         }         
         
         $jor_des="";
         if($j>0){
            $jor=Jornadas::find($j);
            $jor_des=$jor->jor_descripcion;
        }
        $cur_des="";
         if($c>0){
            //dd($c);
            $cur=Cursos::find($c);
            $cur_des=$cur->cur_descripcion;
        }
        $esp_desc="";
        if($e>0){
            $esp=Especialidades::find($e);
            $esp_desc=$esp->esp_descripcion;
        }

            $datos=[$jor_des,$esp_desc,$cur_des,$p];
                DB::select("truncate table tmp_pagos");
                $this->reporte_general_matriz($data);
                $head=DB::select("select rubro,mes from tmp_pagos group by rubro,mes order by 2");
                $txhead=[];
                $tx_cr="";
                foreach ($head as $h) {
                    $d=explode("&",$h->rubro);
                    array_push($txhead,$d[1]);
                    $tx_cr.=$d[1]." text,";
                }
                $tx_cr=substr($tx_cr,0,-1);
                //dd($tx_cr);
                $data=DB::select("
                    SELECT * FROM crosstab('
                    select persona,rubro,sum(valor) from tmp_pagos 
                    group by persona,rubro
                    order by 1,2 
                    '::text, 'select rubro from tmp_pagos group by rubro,mes order by mes '::text) crosstab(est text, $tx_cr );            
                    ");
                //dd($data);
//*******************excel*********//

                Excel::create('Pago_pensiones', function($excel) use($data, $txhead,$datos) {
                    $excel->sheet('Lista_pagos', function($sheet) use($data, $txhead,$datos) {
                        $sheet->loadView('pago_pensiones.rep_matriz_pagos')
                        ->with('data',$data)
                        ->with('txhead',$txhead)
                        ->with('datos',$datos)
                        ;
                    });
                })->export('xls');        

//*******************excel*********//
                // return view("pago_pensiones.rep_matriz_pagos")
                // ->with('data',$data)
                // ->with('txhead',$txhead)
                // ->with('datos',$datos)
                // ;

         }else{

             $pagoPensiones=[];
             $dirigente=[];
         }
         $jornadas=Jornadas::orderBy("id","ASC")->pluck("jor_descripcion","id");
         $especialidades=Especialidades::where('id','<>',10)->orderBy("id","ASC")->pluck("esp_descripcion","id");
         $cursos=Cursos::orderBy("id","ASC")->pluck("cur_descripcion","id");
         $cursos->put("0","Todos");
         $especialidades->put("0","Todas");


         if(isset($data['search_impr'])){
            $jor=Jornadas::find($j);
            $cur=Cursos::find($c);
//            dd($cur);
            $datos=[$jor->jor_descripcion,$cur->cur_descripcion,$p];
            return view('pago_pensiones.rep_pago_cursos')
            ->with('pagoPensiones', $pagoPensiones)
            ->with('datos', $datos)
            ->with('esp', $especialidades)
            ->with('dirigente', $dirigente)
            ;
         }

        return view('pago_pensiones.index')
            ->with('jor', $jornadas)
            ->with('cur', $cursos)
            ->with('pagoPensiones', $pagoPensiones)
            ->with('esp', $especialidades)
            ->with('dirigente', $dirigente)
            ;
    }


    public function reporte_general($data){
        $jor=$data['jor_id'];
        $esp=$data['esp_id'];
        $cur=$data['cur_id'];
        $par=$data['par_id'];
        $anl=$this->anl;
        if($esp==7){
            $anl=$this->anl_bgu;
        }
       
        if($esp==0){
            $mat=DB::select("select m.id,e.est_apellidos,e.est_nombres 
                from matriculas m join estudiantes e on m.est_id=e.id
                where anl_id=$anl 
                and jor_id=$jor 
                and cur_id=$cur 
                and mat_paralelo='$par' 
                and mat_estado=1 
                and esp_id<>7
                and esp_id<>8
                ");
        }else{
             if($esp==7 || $esp==8){//Si es Basica Flexible o BGU
                    $mat=DB::select("select m.id,e.est_apellidos,e.est_nombres 
                        from matriculas m join estudiantes e on m.est_id=e.id
                        where m.anl_id=$anl 
                        and m.jor_id=$jor 
                        and m.cur_id=$cur 
                        and m.mat_paralelo='$par' 
                        and m.mat_estado=1 
                        and m.esp_id=$esp
                    ");            

             }else{
                    $mat=DB::select("select m.id,e.est_apellidos,e.est_nombres 
                        from matriculas m join estudiantes e on m.est_id=e.id
                        where m.anl_id=$anl 
                        and m.jor_id=$jor 
                        and m.cur_id=$cur 
                        and m.mat_paralelot='$par' 
                        and m.mat_estado=1 
                        and m.esp_id=$esp
                    ");            

            }

        }

//dd($mat);

        foreach ($mat as $m) {

            $pens=DB::select("SELECT * FROM ordenes_pension WHERE mat_id=$m->id and mes is not null ORDER BY cast(mes as integer)");
            $estudiante=$m->est_apellidos.' '.$m->est_nombres;
            foreach ($pens as $p) {
                switch ($p->mes) {
                    case 1:$mes='A1&MAT';break;
                    case 2:$mes='A2&SEP';break;
                    case 3:$mes='A3&OCT';break;
                    case 4:$mes='A4&NOV';break;
                    case 5:$mes='A5&DIC';break;
                    case 6:$mes='A6&ENE';break;
                    case 7:$mes='A7&FEB';break;
                    case 8:$mes='A8&MAR';break;
                    case 9:$mes='A9&ABR';break;
                    case 10:$mes='A10&MAY';break;
                    case 11:$mes='A11&JUN';break;
                    case 12:$mes='A12&JUL';break;
                    case 13:$mes='A13&AGO';break;
                }
                if($p->vpagado==null){
                    $p->vpagado=0;
                }

                $dat=array($estudiante,$mes,$p->vpagado,$p->mes);

                $this->insert_tmp_rep_pagos($dat);    
            }

            $rubros=DB::select("
                                    SELECT r.rub_siglas,
                                    r.rub_id,
                                    r.rub_descripcion,
                                    (SELECT 

                                           CASE WHEN pr.pgr_tipo=0 THEN sum(pr.pgr_monto)
                                                WHEN pr.pgr_tipo=1 THEN 1
                                           END as pago

                                    FROM pago_rubros pr 
                                    WHERE pr.rub_id=r.rub_id 
                                    AND pr.per_id=$m->id 
                                    group by pr.pgr_tipo
                                    limit 1
                                    ) 
                                    FROM rubros r
                                    WHERE r.rub_estado=0
                                    
                ");



            foreach ($rubros as $r) {
                if($r->pago==null){
                    $r->pago=0;
                }       
                $r->rub_siglas='B'.$r->rub_id.'&'.$r->rub_siglas;
                $dat=array($estudiante,$r->rub_siglas,$r->pago,20);
                $this->insert_tmp_rep_pagos($dat);    

            }
       }
    }

    public function reporte_general_matriz($data){
        $jor=$data['jor_id'];
        $esp=$data['esp_id'];
        $cur=$data['cur_id'];
        $par=$data['par_id'];
        $anl=$this->anl;
         if($esp==7){
           $anl=$this->anl_bgu;
         }        


        if($jor==0){
            $tx_jor="";
        }else{
           $tx_jor="and jor_id=$jor "; 
        }

        if($cur==0){
            $tx_cur="";
        }else{
           $tx_cur="and cur_id=$cur "; 
        }

        if($par=='0'){
            $tx_par="";
        }else{
           $tx_par="and mat_paralelo='$par' "; 
        }

        if($esp==0){
            $mat=DB::select("
                select m.id,
                e.est_apellidos,
                e.est_nombres,
                j.jor_descripcion,
                ep.esp_descripcion,
                c.cur_descripcion,
                m.mat_paralelo,
                m.mat_paralelot 
                from matriculas m join estudiantes e on m.est_id=e.id
                                JOIN jornadas j ON m.jor_id=j.id
                                JOIN especialidades ep ON m.esp_id=ep.id
                                JOIN cursos c ON m.cur_id=c.id
                where anl_id=$anl 
                $tx_jor
                $tx_cur
                $tx_par
                and mat_estado=1 
                and esp_id<>7
                and esp_id<>8

                ");
        }else{

            $mat=DB::select("
                select m.id,
                e.est_apellidos,
                e.est_nombres,
                j.jor_descripcion,
                ep.esp_descripcion,
                c.cur_descripcion,
                m.mat_paralelo,
                m.mat_paralelot 
                from matriculas m join estudiantes e on m.est_id=e.id
                                JOIN jornadas j ON m.jor_id=j.id
                                JOIN especialidades ep ON m.esp_id=ep.id
                                JOIN cursos c ON m.cur_id=c.id
                where anl_id=$anl 
                $tx_jor
                $tx_cur
                $tx_par
                and mat_estado=1 
                and esp_id=$esp

            ");            

//dd($mat);

        }

        foreach ($mat as $m) {
            $pens=DB::select("SELECT * FROM ordenes_pension WHERE mat_id=$m->id and mes is not null ORDER BY mes");
            $estudiante=$m->est_apellidos.' '.$m->est_nombres.'&'.$m->jor_descripcion.'&'.$m->esp_descripcion.'&'.$m->cur_descripcion.'&'.$m->mat_paralelo.'&'.$m->mat_paralelot;
            foreach ($pens as $p) {
                switch ($p->mes) {
                    case 1:$mes='A1&MAT';break;
                    case 2:$mes='A2&SEP';break;
                    case 3:$mes='A3&OCT';break;
                    case 4:$mes='A4&NOV';break;
                    case 5:$mes='A5&DIC';break;
                    case 6:$mes='A6&ENE';break;
                    case 7:$mes='A7&FEB';break;
                    case 8:$mes='A8&MAR';break;
                    case 9:$mes='A9&ABR';break;
                    case 10:$mes='A10&MAY';break;
                    case 11:$mes='A11&JUN';break;
                    case 12:$mes='A12&JUL';break;
                    case 13:$mes='A13&AGO';break;
                }
                if($p->vpagado==null){
                    $p->vpagado=0;
                }
                $dat=array($estudiante,$mes,$p->vpagado,$p->mes);
                $this->insert_tmp_rep_pagos($dat);    
            }

            $rubros=DB::select("
                                    SELECT r.rub_siglas,
                                    r.rub_id,
                                    r.rub_descripcion,
                                    (SELECT 

                                           CASE WHEN pr.pgr_tipo=0 THEN sum(pr.pgr_monto)
                                                WHEN pr.pgr_tipo=1 THEN 1
                                           END as pago

                                    FROM pago_rubros pr 
                                    WHERE pr.rub_id=r.rub_id 
                                    AND pr.per_id=$m->id 
                                    group by pr.pgr_tipo
                                    limit 1 
                                    ) 
                                    FROM rubros r
                                    WHERE r.rub_estado=0
                                    
                ");



            foreach ($rubros as $r) {
                if($r->pago==null){
                    $r->pago=0;
                }       
                $r->rub_siglas='B'.$r->rub_id.'&'.$r->rub_siglas;
                $dat=array($estudiante,$r->rub_siglas,$r->pago,20);
                $this->insert_tmp_rep_pagos($dat);    

            }
       }
    }


    public function insert_tmp_rep_pagos($data){

        DB::select("insert into tmp_pagos (persona,rubro,valor,mes) values ('$data[0]','$data[1]',$data[2],$data[3]) ");

    }

    public function create()
    {
        return view('pago_pensiones.create');
    }

    /**
     * Store a newly created PagoPensiones in storage.
     *
     * @param CreatePagoPensionesRequest $request
     *
     * @return Response
     */
    public function store(CreatePagoPensionesRequest $request)
    {
        $input = $request->all();

        $pagoPensiones = $this->pagoPensionesRepository->create($input);

        Flash::success('Pago Pensiones saved successfully.');

        return redirect(route('pagoPensiones.index'));
    }

    /**
     * Display the specified PagoPensiones.
     *
     * @param  int $id
     *
     * @return Response
     */

    public function show($id)
    {

        $pagoPensiones = DB::select("select op.*,e.est_cedula,e.est_apellidos,e.est_nombres from ordenes_pension op,matriculas m,estudiantes e 
                                    where op.mat_id=m.id 
                                    and e.id=m.est_id
                                    and op.identificador='$id' ");
        return view('pago_pensiones.show')->with('pagoPensiones', $pagoPensiones);
    }

    public function edit($id)
    {
        $ordenes=DB::select("select distinct vpagado,count(*)
            from ordenes_pension 
            group by vpagado 
            order by vpagado
            ");
        return view('pago_pensiones.edit')
        ->with('ordenes', $ordenes)
        ->with('cod', $id)
        ;
    }

    /**
     * Update the specified PagoPensiones in storage.
     *
     * @param  int              $id
     * @param UpdatePagoPensionesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePagoPensionesRequest $request)
    {
        $pagoPensiones = $this->pagoPensionesRepository->findWithoutFail($id);

        if (empty($pagoPensiones)) {
            Flash::error('Pago Pensiones not found');

            return redirect(route('pagoPensiones.index'));
        }

        $pagoPensiones = $this->pagoPensionesRepository->update($request->all(), $id);

        Flash::success('Pago Pensiones updated successfully.');

        return redirect(route('pagoPensiones.index'));
    }

    /**
     * Remove the specified PagoPensiones from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $pagoPensiones = $this->pagoPensionesRepository->findWithoutFail($id);

        if (empty($pagoPensiones)) {
            Flash::error('Pago Pensiones not found');

            return redirect(route('pagoPensiones.index'));
        }

        $this->pagoPensionesRepository->delete($id);

        Flash::success('Pago Pensiones deleted successfully.');

        return redirect(route('pagoPensiones.index'));
    }

    public function ordenes(Request $req)
    {
        $dt=$req->all();
        $ordenes=DB::select("select * from ordenes_pension where mat_id=$dt[mt_id] and anl_id=$this->anl and estado<>1 and codigo<>'MTGM' order by cast(mes as integer)");
        //select * from ordenes_pension where mat_id=3311 and anl_id=2 and estado<>1 and codigo<>'MTGM' order by mes
        return response()->json($ordenes);
    
    }
    public function save_ordenes(Request $req)
    {

         $dt=$req->all();
         if($dt['ac']==0){
            $dt['fac']=date('Y-m-d');
            $dt['ac_no']=null;
         }
         DB::select("update ordenes_pension set estado=$dt[ac],f_acuerdo='$dt[fac]',ac_no='$dt[ac_no]' where id=".$dt['id']);
         return 0;
    
    }




}