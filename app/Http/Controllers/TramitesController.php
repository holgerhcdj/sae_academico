<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTramitesRequest;
use App\Http\Requests\UpdateTramitesRequest;
use App\Repositories\TramitesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Departamentos;
use Illuminate\Support\Facades\DB;
use App\Models\Auditoria;


class TramitesController extends AppBaseController
{

    private $tramitesRepository;
    public function __construct(TramitesRepository $tramitesRepo)
    {
        $this->tramitesRepository = $tramitesRepo;
    }

    public function index(Request $request)
    {

        //Flash::success('okkkkkkkk');

        $this->tramitesRepository->pushCriteria(new RequestCriteria($request));
        $tramites = $this->tramitesRepository->all();
        return view('tramites.index')
            ->with('tramites', $tramites);
    }

    public function create()
    {
        $dep = Departamentos::orderBy('descripcion', 'ASC')->pluck('descripcion', 'id');

        return view('tramites.create')->with('dep',$dep);
    }

    public function store(CreateTramitesRequest $request)
    {
        $input = $request->all();
        $tramites = $this->tramitesRepository->create($input);
                            $datos = implode("-", array_flatten($tramites['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"Tramites","acc"=>"Insertar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        

        Flash::success('Tramites saved successfully.');

        return redirect(route('tramites.index'));
    }

    public function show($id)
    {
//            dd('okkkkkkkkk');        
        //$per=DB::select("");

        $tramites = "";
         return view('tramites.show')->with('tramites', $tramites);
    }

    public function edit($id)
    {
        $tramites = $this->tramitesRepository->findWithoutFail($id);
        $dep = Departamentos::orderBy('descripcion', 'ASC')->pluck('descripcion', 'id');
        if (empty($tramites)) {
            Flash::error('Tramites not found');

            return redirect(route('tramites.index'));
        }

        return view('tramites.edit')->with('tramites', $tramites)->with('dep',$dep);
    }

    public function update($id, UpdateTramitesRequest $request)
    {
        //dd('ok');
        $tramites = $this->tramitesRepository->findWithoutFail($id);
        if (empty($tramites)) {
            Flash::error('Tramites not found');
            return redirect(route('tramites.index'));
        }
        $tramites = $this->tramitesRepository->update($request->all(), $id);
                            $datos = implode("-", array_flatten($tramites['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"Tramites","acc"=>"Modificar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        

        Flash::success('Tramites updated successfully.');

        return redirect(route('tramites.index'));
    }

    public function destroy($id)
    {
        $tramites = $this->tramitesRepository->findWithoutFail($id);

        if (empty($tramites)) {
            Flash::error('Tramites not found');

            return redirect(route('tramites.index'));
        }

        $this->tramitesRepository->delete($id);
                            $datos = implode("-", array_flatten($tramites['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"Tramites","acc"=>"Eliminar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        

        Flash::success('Tramites deleted successfully.');

        return redirect(route('tramites.index'));
    }


    public function seg_a_dhms($fechaInicial,$fechaFinal) { 
        $seg = strtotime($fechaFinal) - strtotime($fechaInicial);

        $d = floor($seg / 86400);
        $h = floor(($seg - ($d * 86400)) / 3600);
        $m = floor(($seg - ($d * 86400) - ($h * 3600)) / 60);
        $s = $seg % 60; 
        return $d."&".$h."&".$m; 
    }


    public function rep_tramites(Request $req){

        $fd=$req->all()['desde'];
        $fh=$req->all()['hasta'];
        $usr=DB::select("SELECT id,usu_apellidos,name FROM users WHERE usu_estado=0 ORDER BY usu_apellidos");
        //$usr=DB::select("SELECT id,usu_apellidos,name FROM users WHERE id=117 order by usu_apellidos");

        $resp="";
        $usuario=0;
        $n=0;
        foreach ($usr as $u) {
            $mov=DB::select(" 
                SELECT r.id as req_id,
                mv.id as mv_id,
                r.codigo,
                mv.personas_ids,
                mv.mvr_descripcion,
                mv.mvr_fecha,
                mv.mvr_hora,
                mv.usu_id 
                FROM requerimientos r 
                JOIN movimientos_requerimiento mv ON r.id=mv.req_id
                WHERE mv.mvr_fecha BETWEEN '$fd' AND '$fh'
                AND (mv.personas_ids like '%;$u->id;%' OR mv.personas_ids LIKE '$u->id;%')
                AND r.usu_id<>$u->id
                ORDER BY r.id   ");


            if(count($mov)>0)
            {

                if($usuario!=$u->id){
                    $usuario=$u->id;
                    $n++;
                    $resp.="<tr><td>$n</td><td>".strtoupper($u->usu_apellidos.' '.$u->name)."</td>";
                }

            $tot=0;
            $t_atiempo=0;
            $t_atrasado=0;
            $tx_atrasado='';
            $t_noatendido=0;
            $tx_noatendido='';
            $c=0;

                foreach ($mov as $m) { //Recorro todos los tramites de cada usuario 
                    $tot++;
                     $nrows=DB::select("SELECT COUNT(*) FROM movimientos_requerimiento mv WHERE mv.req_id=$m->req_id ");
                     if($nrows[0]->count<2){
                         $t_noatendido++;
                         $tx_noatendido.=$m->codigo.' - ';
                     }else{
                            $req=DB::select("SELECT *,mv.id as mov_id from requerimientos r JOIN movimientos_requerimiento mv ON r.id=mv.req_id
                             WHERE mv.req_id=$m->req_id order by mv.id ");//Todos los movimientos de ese trámite
                           $f1='';
                           $f2='';
                           $h1='';
                           $h2='';
                           $x=0;
                           $hb=0;
                           $y=0;
                           foreach ($req as $r) {
                            $y++;
                                    if($m->mv_id==$r->mov_id){//Busco el mov donde se encontró a la persona
                                        if($y==$nrows[0]->count){
                                            $t_noatendido++;
                                            $tx_noatendido.=$m->codigo.' - ';
                                        }else{
                                           $hb=1;
                                       }
                                    }

                                    if($hb==1){ //Habilito para ver la respuesta
                                     $x++;
                                     if($x==1){
                                        $f1=$r->mvr_fecha;
                                        $h1=$r->mvr_hora;
                                    }elseif($x==2){
                                        $f2=$r->mvr_fecha;
                                        $h2=$r->mvr_hora;
                                        $dt=$this->seg_a_dhms($f1." ".$h1,$f2." ".$h2);
                                        $dat=explode("&",$dt);
                                        if($dat[0]<=1){
                                            $t_atiempo++;
                                        }elseif($dat[0]>1){
                                            $t_atrasado++;
                                            $tx_atrasado.=$r->codigo." - ";
                                        } 
                                    }

                                }
                            }
                     }

                   
                }
                if($t_atiempo>0){
                    //$t_atiempo--;
                }

                $por=number_format($t_atiempo*100/$tot,1);
            $resp.="<td class='text-center bg-info'>$tot</td>
            <td class='text-center bg-success'>$t_atiempo</td>
            <td class='text-center bg-warning' >
            <i class='btn btn-warning btn_trm_atrasados' data='$tx_atrasado' data-toggle='modal' data-target='#modal_tramites' >
                $t_atrasado
            </i>
            </td>
            <td class='text-center bg-danger' title='$tx_noatendido'>
            <i class='btn btn-danger btn_trm_atrasados' data='$tx_noatendido' data-toggle='modal' data-target='#modal_tramites' >
                $t_noatendido
            </i>
            </td>
            <td class='text-left'>$por
                    <progress value='$por' max='100'></progress>
            </td>
            </tr>";

            }


        }

$tramites=$resp;
return view('tramites.show')->with('tramites', $tramites);



    }

}
