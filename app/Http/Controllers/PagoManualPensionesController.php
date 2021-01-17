<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Auditoria;
use App\Models\Jornadas;
use App\Models\Cursos;
use App\Models\AnioLectivo;
use App\Models\Especialidades;
use App\Models\OrdenesPension;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class PagoManualPensionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $dat=$req->all();
        $anl=Session::get('anl_id');
        //$anl_bgu=Session::get('periodo_id');
         if(isset($dat['search'])){
//dd($dat['esp_id']);
            if($dat['esp_id']=='7'){
                $anl=Session::get('periodo_id');
            }

            if($dat['esp_id']=='0'){
                $tx_par=" and m.mat_paralelo='$dat[par_id]'";
                $tx_esp=" and m.esp_id<>7 and m.esp_id<>8";
            }else{

                if($dat['esp_id']=='7' || $dat['esp_id']=='8'){
                   $tx_par=" and m.mat_paralelo='$dat[par_id]'";
                }else{
                   $tx_par=" and m.mat_paralelot='$dat[par_id]'";
                }
                $tx_esp=" and m.esp_id=".$dat['esp_id'];

            }

$sql="
                select e.id as est_id,m.esp_id,es.esp_descripcion,
                op.id as opid,
                op.tipo,
                op.motivo,
                e.est_cedula,
                e.est_apellidos,
                e.est_nombres,
                op.valor,
                op.vpagado,
                op.estado,
                op.id,
                op.codigo,
                op.responsable,
                op.fecha_pago 
                from matriculas m 
                join estudiantes e on m.est_id=e.id
                join especialidades es on m.esp_id=es.id 
                left join ordenes_pension op on m.id=op.mat_id and op.mes='$dat[mes]' 
                where m.anl_id=$anl
                and m.jor_id=$dat[jor_id]
                and m.cur_id=$dat[cur_id]
                $tx_par
                $tx_esp
                and m.mat_estado=1 order by e.est_apellidos ";
                //dd($sql);

            $lista=DB::select($sql);
         }else{
           $lista=[];            
         }
         $jornadas=Jornadas::orderBy("id","ASC")->pluck("jor_descripcion","id");
         $cursos=Cursos::orderBy("id","ASC")->pluck("cur_descripcion","id");
         $especialidades=Especialidades::where('id','<>',10)->orderBy("id","ASC")->pluck("esp_descripcion","id");
         $cursos->put("0","Todos");
         $especialidades->put("0","Todas");

        return view('ordenes_pensions.pagoManual')
            ->with('jor', $jornadas)
            ->with('cur', $cursos) 
            ->with('lista', $lista)
            ->with('esp', $especialidades)
            ;

        //return view('ordenes_pensions.pagoManual');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function elimina_pago(Request $req)
    {
        $usu = Auth::user();
        if($usu->id==21 || $usu->id==1 || $usu->id==24 ){ //Paty y Lucy pueden eliminar
            $dt=$req->all();
            $rst_est=DB::select("delete from ordenes_pension where id=".$dt['opid']);
            return 0;
        }else{
            return 1;
        }
    }

    public function registra_pago(Request $req){
        $usu = Auth::user();
        $datos=$req->all();
        $anl=Session::get('anl_id');
        $anl_bgu=Session::get('periodo_id');
        //dd($datos);
        if($datos['opid']==null){
            $Op=new OrdenesPension();
            $rst_est=DB::select("select m.*,es.esp_obs,vp.valor as vsolicitado from matriculas m 
                join especialidades es on m.esp_id=es.id
                join valor_pensiones vp on vp.id=m.pen_id
                where m.est_id=$datos[mtid] and (m.anl_id=$anl or m.anl_id=$anl_bgu) ");

            switch ($datos['jr']) {
                case 1:$j="M";break;
                case 2:$j="N";break;
                case 3:$j="S";break;
                case 4:$j="V";break;
            }
            switch ($datos['ms']) {
                case 1:$m="MT";break;
                case 2:$m="S";break;
                case 3:$m="O";break;
                case 4:$m="N";break;
                case 5:$m="D";break;
                case 6:$m="E";break;
                case 7:$m="F";break;
                case 8:$m="MZ";break;
                case 9:$m="A";break;
                case 10:$m="MY";break;
                case 11:$m="J";break;
                default:
                $m='OT';
                break;
            }
            //DD($rst_est);
            //DD($rst_est[0]->cur_id);
            $cod=$m."G".$j.$rst_est[0]->cur_id.$rst_est[0]->esp_obs;
            $Op['anl_id']=Session::get('anl_id');
            $Op['mat_id']=$rst_est[0]->id;
            $Op['fecha']=date('Y-m-d');
            $Op['mes']=$datos['ms'];
            $Op['codigo']=$cod;
            $Op['valor']=$rst_est[0]->vsolicitado;
            $Op['fecha_pago']=date('Y-m-d');
        $Op['tipo']=1;//Pago 0 automatico 1 manual
        $Op['estado']=1;
        $Op['responsable']=$usu->name;
        $Op['obs']='MN-0-0-2018-2019';
        $Op['identificador']='ORD-000000';
        if($datos['vl']==null){
            $Op['vpagado']=($Op['valor']/100);
        }else{
            $Op['vpagado']=$datos['vl'];    
        }
        $Op['motivo']=$datos['mtv'];
    }else{

            $Op=OrdenesPension::find($datos['opid']);
            $Op['fecha_pago']=date('Y-m-d');
            $Op['tipo']=1;//Pago 0 automatico 1 manual
            $Op['estado']=1;
            if($datos['vl']==null){
                $Op['vpagado']=($Op['valor']/100);
            }else{
                $Op['vpagado']=$datos['vl'];    
            }
            $Op['motivo']=$datos['mtv'];
            //$Op->save();
        }

        $Op->save();
        return response()->json($Op);

    }

}
