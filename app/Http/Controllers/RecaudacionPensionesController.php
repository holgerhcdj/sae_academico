<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auditoria;
use App\Models\Jornadas;
use App\Models\Cursos;
use App\Models\AnioLectivo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class RecaudacionPensionesController extends Controller
{


    public function index(Request $req)
    {
        $dat=$req->all();
        if(isset($dat['search'])){
            if(empty($dat['fac_no'])){

                $tx_sql="where fd.fecha_pago between '$dat[desde]' and '$dat[hasta]' ";
            }else{
                $dat['fac_no']=strtoupper($dat['fac_no']);
                $tx_sql="where (f.fac_no like '%$dat[fac_no]%' or e.est_apellidos like '%$dat[fac_no]%' or e.est_nombres like '%$dat[fac_no]%') ";
            }

           $lista=DB::select("
            select 
            f.fac_id,
            e.est_apellidos,
            e.est_nombres,
            fd.valor_pagado,
            fd.codigo,
            fd.fecha_pago,
            f.fac_no,
            f.num_fact 
            from factura f 
            join factura_detalle fd on f.fac_id=fd.fac_id
            join matriculas m on m.id=fd.mat_id
            join estudiantes e on e.id=m.est_id
            $tx_sql
            order by e.est_apellidos            
            ");
        }else{
            $lista=[];
        }
         return view('recaudacion.index')
             ->with('lista', $lista);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $est=DB::select("select *,m.id as mat_id from estudiantes e 
            join matriculas m on e.id=m.est_id
            join cursos c on c.id=m.cur_id
            join jornadas j on j.id=m.jor_id
            and m.anl_id=2 order by e.est_apellidos ");
        return view('recaudacion.create')
        ->with('est',$est);
        ;            
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $factura=DB::select("select * from factura f 
            join factura_detalle fd on f.fac_id=fd.fac_id
            join matriculas m on fd.mat_id=m.id
            join estudiantes e on e.id=m.est_id
            where f.fac_id=$id ");
            return view('recaudacion.show')
             ->with('factura', $factura[0])
            ;


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $factura=DB::select("select * from factura f 
            join factura_detalle fd on f.fac_id=fd.fac_id
            join matriculas m on fd.mat_id=m.id
            join estudiantes e on e.id=m.est_id
            where f.fac_id=$id ");
       return view('recaudacion.edit')
       ->with('recaudacionPensiones',$factura[0]);        

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data=$request->all();
        $fact=DB::select("update factura set cli_ruc='$data[cli_ruc]', 
            cli_nombre='$data[cli_nombre]', 
            cli_direccion='$data[cli_direccion]', 
            cli_telefono='$data[cli_telefono]' 
            where fac_id=$data[fac_id] ");
        return redirect(route('recaudacionPensiones.index'));

    }

    public function destroy($id){

    }

    public function datos_factura(Request $req)
    {
        $dt=$req->all();
        $datos=DB::select("select m.*,e.est_cedula,e.est_apellidos,e.est_nombres from matriculas m join estudiantes e on m.est_id=e.id where m.id=".$dt['matid']);
        $orden=DB::select("select * from ordenes_pension where mes='$dt[mes]' and mat_id=".$dt['matid']);        
        return response()->json([$datos,$orden]);

    }

    public function factura_pension(Request $req){

        $data=$req->all();
        $pago=DB::select("select * from ordenes_pension where mat_id=$data[est] and codigo='$data[cod]' ");
        $factura=DB::select("select * from factura_detalle where mat_id=$data[est] and codigo='$data[cod]' ");

        if(count($factura)>0){
            return 0;//Factura ya realizada
        }else{
            $ultima_fact=DB::select("select max(cast(fac_no as integer)) as no from factura");
            $est=DB::select("select * from matriculas m join estudiantes e on m.est_id=e.id where m.id=$data[est] ");
            $rst_fact['no']=($ultima_fact[0]->no+1);

                if($rst_fact['no']==null){
                    $txt_no='00000';
                }elseif($rst_fact['no']>0 && $rst_fact['no']<10){
                    $txt_no='00000';
                }elseif($rst_fact['no']>=10 && $rst_fact['no']<100){
                    $txt_no='0000';
                }elseif($rst_fact['no']>=100 && $rst_fact['no']<1000){
                    $txt_no='000';
                }elseif($rst_fact['no']>=1000 && $rst_fact['no']<10000){
                    $txt_no='00';
                }elseif($rst_fact['no']>=10000 && $rst_fact['no']<100000){
                    $txt_no='0';
                }elseif($rst_fact['no']>=100000 && $rst_fact['no']<1000000){
                    $txt_no='';
                }
                $fac_no=$txt_no.$rst_fact['no'];
                $dat['usu_id']=Auth::user()->id;
                $dat['fac_no']=$fac_no;
                $dat['fac_fecha']=date('Y-m-d');
                $dat['fac_hora']=date('H:s:i');
                $dat['fac_estado']=0;

                if($est[0]->facturar==1){
                    $dat['cli_ruc']=$est[0]->fac_ruc;
                    $dat['cli_nombre']=$est[0]->fac_razon_social;
                    $dat['cli_direccion']=$est[0]->fac_direccion;
                    $dat['cli_telefono']=$est[0]->fac_telefono;
                }else{
                    $dat['cli_ruc']=$est[0]->rep_cedula;
                    $dat['cli_nombre']=$est[0]->rep_nombres;
                    $dat['cli_direccion']=$est[0]->est_direccion;
                    isset($est[0]->rep_telefono)?$dat['cli_telefono']=$est[0]->rep_telefono:$dat['cli_telefono']='0999999999';
                }

                $factura=DB::select(" INSERT INTO factura 
                    (usu_id,
                    fac_no,
                    fac_fecha,
                    fac_hora,
                    cli_ruc,
                    cli_nombre,
                    cli_direccion,
                    fac_estado,
                    cli_telefono)
                    VALUES(
                    $dat[usu_id],
                    $dat[fac_no],
                    '$dat[fac_fecha]',
                    '$dat[fac_hora]',
                    '$dat[cli_ruc]',
                    '$dat[cli_nombre]',
                    '$dat[cli_direccion]',
                    $dat[fac_estado],
                    '$dat[cli_telefono]' ) returning fac_id");


                    $data[0]=$factura[0]->fac_id;
                    $data[1]=$data['est'];
                    $data[2]=$data['cod'];
                    $data[3]=($pago[0]->valor/100);
                    $data[4]=$pago[0]->vpagado;
                    $data[5]=$pago[0]->fecha_pago;
                    $data[6]=$pago[0]->mes;

                $detalle=DB::select("
                    INSERT INTO factura_detalle(
                    fac_id,
                    mat_id,
                    codigo,
                    valor,
                    valor_pagado,
                    fecha_pago, 
                    descripcion)
                    VALUES (
                    $data[0],
                    $data[1],
                   '$data[2]',
                    $data[3],
                    $data[4],
                   '$data[5]',
                   '$data[6]' ) ");

                return $factura[0]->fac_id;




    }

    }

    public function busca_pensiones(Request $req){
        $data=$req->all();
        $ordenes=DB::select("select * from ordenes_pension where mat_id=$data[est] and estado<>0 ");
        return Response()->json($ordenes);
    }


    public function elimina_duplicados_facturas(Request $req){

        $rst=DB::select("select df.mat_id,df.codigo,df.descripcion,count(*) from factura f 
            join factura_detalle df on f.fac_id=df.fac_id
            group by df.mat_id,df.codigo,df.descripcion
            having count(*)>1 order by df.mat_id");
                foreach ($rst as $r) {
                 $rst2=DB::select("SELECT * FROM factura f 
                    JOIN factura_detalle df ON f.fac_id=df.fac_id
                    WHERE df.mat_id=$r->mat_id and df.codigo='$r->codigo'     "); 
                 $x=0;
                 $c=(count($rst2)-1);
                         foreach ($rst2 as $key=>$r2) {
                            if(!empty($r2->num_fact)){
                                $x=1;//No elimine
                            }else{
                                if($key==$c && $x==0){
                                //no elimine;
                                }else{
                                //elimnine
                                    //echo $r2->fac_id.'-'.($key+1).'<br>';
                                    DB::select("delete from factura where fac_id=$r2->fac_id");
                                }
                            }
                        }
             }
                       dd('Eliminado Correctamente');


    }
    public function actualiza_num_factura(Request $req){
        $dt=$req->all();
        $data=DB::select("select * from factura where fac_id=$dt[fac_id] ");
        if(empty($data[0]->num_fact)){
            $dat=DB::select("select * from factura where num_fact='$dt[nfc]' ");
            if(empty($dat)){
                DB::select("update factura set num_fact='$dt[nfc]' where fac_id=$dt[fac_id] ");
                return $dt['fac_id'];
            }else{
                return 0;
            }
        }else{
            return 0;
        }

    }




}
