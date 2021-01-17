<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRequerimientosRequest;
use App\Http\Requests\UpdateRequerimientosRequest;
use App\Repositories\RequerimientosRepository;
use App\Repositories\MovimientosRequerimientoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Storage;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\DB;
use App\Models\Departamentos;
use App\Models\Tramites;
use App\Models\Auditoria;


class RequerimientosController extends AppBaseController {

    /** @var  RequerimientosRepository */
    private $requerimientosRepository;
    private $movimientosRequerimientoRepository;

    public function __construct(RequerimientosRepository $requerimientosRepo, MovimientosRequerimientoRepository $movimientosRequerimientoRepo) {
        $this->requerimientosRepository = $requerimientosRepo;
        $this->movimientosRequerimientoRepository = $movimientosRequerimientoRepo;
        $this->msj();
    }


    public function cargar_dato2($id, $usr, $usu_id,$op) {
        $para="hidden";
        $cc="hidden";
        if($op==0){
            $para="";
        }else{
            $cc="";
        }

        $usrs=DB::select("select * from users where usu_perfil=$usu_id and usu_estado=0");
        $resp="<tr>
        <th $para >Para:</th>
        <th $cc >CC:</th>
        <th>PERSONAL <i onclick='cerrar_ventana()' class='btn btn-danger glyphicon glyphicon-remove'></i></th>
        </tr>";
        foreach ($usrs as $u) {
            $nm=$u->usu_apellidos." ".$u->name;

            $resp.="<tr>
            <td hidden><input type='hidden' class='personal' value='".$u->id."' /></td>
            <td $para ><input  type='checkbox' onclick='validar_check(0,".$u->id.")' id='to_".$u->id."'  /></td>
            <td $cc ><input  type='checkbox' onclick='validar_check(1,".$u->id.")' id='cc_".$u->id."'  /></td>
            <td id='usr_".$u->id."' >$nm</td>
            </tr>";
        }
        $resp.="<tr><td colspan='3'><i class='btn btn-warning' onclick='carga_personal()' >Asignar</i></td></tr>";
        return response()->json($resp);

    }

    
    public function cargar_dato($id, $usu_id,$op) {
        $para="hidden";
        $cc="hidden";
        if($op==0){
            $para="";
        }else{
            $cc="";
        }

        $usrs=DB::select("select * from users where usu_perfil=$usu_id and usu_estado=0");
        $resp="<tr>
        <th $para >Para:</th>
        <th $cc >CC:</th>
        <th>PERSONAL <i onclick='cerrar_ventana()' class='btn btn-danger glyphicon glyphicon-remove'></i></th>
        </tr>";
        foreach ($usrs as $u) {
            $nm=$u->usu_apellidos." ".$u->name;

            $resp.="<tr>
            <td hidden><input type='hidden' class='personal' value='".$u->id."' /></td>
            <td $para ><input  type='checkbox' onclick='validar_check(0,".$u->id.")' id='to_".$u->id."'  /></td>
            <td $cc ><input  type='checkbox' onclick='validar_check(1,".$u->id.")' id='cc_".$u->id."'  /></td>
            <td id='usr_".$u->id."' >$nm</td>
            </tr>";
        }
        $resp.="<tr><td colspan='3'><i class='btn btn-warning' onclick='carga_personal()' >Asignar</i></td></tr>";
        return response()->json($resp);
 
    }


    public function index(Request $request){

        $this->requerimientosRepository->pushCriteria(new RequestCriteria($request));
        $requerimientos = array();
        return view('requerimientos.index')
                        ->with('requerimientos', $requerimientos);
    }

    public function buscador(Request $request){
        $dat=$request->all();
        $txt=strtoupper($dat['texto']);

        $estado=$dat['estado'];
        if(strlen($estado)==0){
            $txt_estado="";
        }else{
            $txt_estado="and r.estado=$estado ";
        }

        if(strlen($txt)>0){

        $requerimientos = DB::select("
                select r.*,t.nombre_tramite,u.name,u.usu_apellidos,
                (select count(*) from movimientos_requerimiento m where m.req_id=r.id) as mv,
                (select mv1.personas from movimientos_requerimiento mv1 where mv1.req_id=r.id limit 1) as receptor
                from requerimientos r, tramites t, users u
                where exists(select * from movimientos_requerimiento mv where mv.req_id=r.id and r.codigo='$txt' )
                and r.trm_id=t.id
                and r.usu_id=u.id
                $txt_estado
                order by estado, codigo desc
            ");
        }else{

        $requerimientos = DB::select("select r.*,t.nombre_tramite,u.name,u.usu_apellidos,(select count(*) from movimientos_requerimiento m where m.req_id=r.id) as mv,(select mv1.personas from movimientos_requerimiento mv1 where mv1.req_id=r.id limit 1) as receptor
            from requerimientos r, tramites t, users u
            where exists(select * from movimientos_requerimiento mv where mv.req_id=r.id and (UPPER(mv.personas) like '%$txt%' or UPPER(u.usu_apellidos) like '%$txt%' or UPPER(u.name) like '%$txt%') )
            and r.trm_id=t.id
            and r.usu_id=u.id
            $txt_estado
            order by estado, codigo desc");

        }


        return view('requerimientos.index')
                        ->with('requerimientos', $requerimientos);
    }


    /**
     * Show the form for creating a new Requerimientos.
     *
     * @return Response
     */
    public function create($id) {
        $codigo = DB::table('requerimientos')
                        ->orderBy('codigo', 'desc')
                        ->limit(1)->get();
       $usuariosactivos = Departamentos::orderBy('descripcion', 'ASC')->pluck('descripcion', 'id');
       $tramite = Tramites::orderBy('nombre_tramite', 'ASC')->pluck('nombre_tramite', 'id');
        if (count($codigo) == 0) {
            $cd = 1;
        } else {
            $cd = $codigo[0]->codigo + 1;
        }
        if ($cd > 0 && $cd < 10) {
            $txt = '000000000';
        } else if ($cd >= 10 && $cd < 100) {
            $txt = '00000000';
        } else if ($cd >= 100 && $cd < 1000) {
            $txt = '0000000';
        } else if ($cd >= 1000 && $cd < 10000) {
            $txt = '000000';
        } else if ($cd >= 10000 && $cd < 100000) {
            $txt = '00000';
        } else if ($cd >= 100000 && $cd < 1000000) {
            $txt = '0000';
        } else if ($cd >= 1000000 && $cd < 10000000) {
            $txt = '000';
        } else if ($cd >= 10000000 && $cd < 100000000) {
            $txt = '00';
        } else if ($cd >= 100000000 && $cd < 1000000000) {
            $txt = '0';
        } else if ($cd >= 1000000000 && $cd < 10000000000) {
            $txt = '';
        }
        $cod = $txt . $cd;
        return view('requerimientos.create')
                        ->with('codigo', $cod)
                        ->with('usu_id', $id)
                        ->with('usuariosactivos', $usuariosactivos)
                        ->with('tramite',$tramite)
                        ->with('id', '');
    }

    /**
     * Store a newly created Requerimientos in storage.
     *
     * @param CreateRequerimientosRequest $request
     *
     * @return Response
     */
    public function store(CreateRequerimientosRequest $request) {
        $input = $request->all();
        //dd($input);
        $file_route = '';
        if ($request->hasfile('archivo')) {
            $img = $request->file('archivo');
            $file_route = $input['codigo'] . '.' . $img->getClientOriginalExtension();
//            dd( $img->getRealPath() ) ;
            Storage::disk('documentos')->put($file_route, file_get_contents($img->getRealPath()));
        }

        $data = array(
            'asunto' => strtoupper($input['asunto']),
            'codigo' => $input['codigo'],
            'descripcion' => strtoupper($input['mvr_descripcion']),
            'fecha_registro' => $input['mvr_fecha'],
            'fecha_finalizacion' => $input['fecha_finalizacion'],
            'archivo' => $file_route,
            'estado' => $input['estado'],
            'usu_id' => $input['usu_id'],
            'hora_registro'=>date("H:i:s"),
            'hora_final'=>'00:00:00',
            'trm_id'=>$input['trm_id']

        );
        $requerimientos = $this->requerimientosRepository->create($data);

        $datos = implode("-", array_flatten($requerimientos['attributes']));
        $aud= new Auditoria();
        $data=["mod"=>"Requerimientos","acc"=>"Insertar","dat"=>$datos,"doc"=>"NA"];
        $aud->save_adt($data);        


        $data2 = array(
            'personas' => strtoupper($input['personas']),
            'personas_ids' => $input['personas_ids'],
            'mvr_descripcion' => strtoupper($input['mvr_descripcion']),
            //'mvr_fecha' => $input['mvr_fecha'],
            'mvr_fecha' => date('Y-m-d'),
            'usu_id' => $input['usu_id'],
            'req_id' => $requerimientos->id,
            'cc_personas' => strtoupper($input['cc_personas']),
            'cc_personas_ids' => $input['cc_personas_ids'],
            'mvr_hora' => date("H:i:s")

        );
        $movimientosRequerimiento = $this->movimientosRequerimientoRepository->create($data2);
        $dtupd['last_ids']=$data2['personas_ids'];
        $upd_req=$this->requerimientosRepository->update($dtupd,$requerimientos->id);
                            $datos = implode("-", array_flatten($movimientosRequerimiento['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"Requerimientos","acc"=>"Insertar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        

        Flash::success('Requerimiento Enviado Correctamente.');

        return redirect(route('requerimientoMovimiento', ['id' => $input['usu_id'],'op'=>0]));
    }

    /**
     * Display the specified Requerimientos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id) {
        $movimientosRequerimiento = DB::select("select r.usu_id as usur,m.usu_id as usum,r.id as req_id,m.id as mvr_id,u.id as usuario_id,u.*,r.*,m.*,t.nombre_tramite 
from requerimientos r, movimientos_requerimiento m , users u,tramites t 
where r.id=m.req_id 
and m.usu_id=u.id
and r.trm_id=t.id 
and m.req_id=$id 
order by mvr_fecha,r.codigo,m.id");
$req=DB::select("select * from requerimientos where id=$id");
return view('requerimientos.show')->with('movimientosRequerimiento', $movimientosRequerimiento)->with('req',$req);

    }

    /**
     * Show the form for editing the specified Requerimientos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id, $usu_id) {
        $requerimientos = DB::select("select r.usu_id as usur,m.usu_id as usum,r.id as req_id,m.id as mvr_id,r.*,m.* 
                                                from requerimientos r, movimientos_requerimiento m where r.id=m.req_id and m.id=$id");
        $usuariosactivos = Departamentos::orderBy('descripcion', 'ASC')->pluck('descripcion', 'id');
        $tramite = Tramites::orderBy('nombre_tramite', 'ASC')->pluck('nombre_tramite', 'id');
        $emisor=DB::select("select * from users where id=".$requerimientos[0]->usu_id);
        return view('requerimientos.edit')
                        ->with('requerimientos', $requerimientos[0])
                        ->with('codigo', $requerimientos[0]->codigo)
                        ->with('usu_id', $usu_id)
                        ->with('usuariosactivos',$usuariosactivos)
                        ->with('tramite',$tramite)
                        ->with('id', $requerimientos[0]->req_id)
                        ->with('emisor', $emisor[0])
                        ;
    }

    /**
     * Update the specified Requerimientos in storage.
     *
     * @param  int              $id
     * @param UpdateRequerimientosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRequerimientosRequest $request) {
        $input = $request->all();
        $file_route = '';
        if ($request->hasfile('archivo')) {
            $img = $request->file('archivo');
            $file_route = $input['codigo'] . '.' . $img->getClientOriginalExtension();
            Storage::disk('documentos')->put($file_route, file_get_contents($img->getRealPath()));
        }

        $data2 = array(
            'personas' => strtoupper($input['personas']),
            'personas_ids' => $input['personas_ids'],
            'mvr_descripcion' => strtoupper($input['mvr_descripcion']),
            'mvr_fecha' => date('Y-m-d'),
            'usu_id' => $input['usu_id'],
            'req_id' => $input['req_id'],
            'cc_personas' => strtoupper($input['cc_personas']),
            'cc_personas_ids' => $input['cc_personas_ids'],
            'mvr_hora' => date("H:i:s")

        );
        $movimientosRequerimiento = $this->movimientosRequerimientoRepository->create($data2);

        $dtupd['last_ids']=$data2['personas_ids'];
        $dtupd['archivo']=$file_route;

        $upd_req=$this->requerimientosRepository->update($dtupd,$data2['req_id']);


                            $datos = implode("-", array_flatten($movimientosRequerimiento['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"Requerimientos","acc"=>"Insertar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        

        Flash::success('Requerimiento Reenviado Correctamente.');

        return redirect(route('requerimientoMovimiento', ['id' => $input['usu_id'],'op'=>0]));
    }

    /**
     * Remove the specified Requerimientos from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id) {
        $requerimientos = $this->requerimientosRepository->findWithoutFail($id);

        if (empty($requerimientos)) {
            Flash::error('Requerimientos not found');

            return redirect(route('requerimientos.index'));
        }

        $this->requerimientosRepository->delete($id);
                            $datos = implode("-", array_flatten($requerimientos['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"Requerimientos","acc"=>"Eliminar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        

        Flash::success('Requerimiento Eliminado Correctamente.');

        return redirect(route('requerimiento', ['id' => $requerimientos->usu_id]));
    }

    public function finalizar($id, $usu_id) {
        $data = array(
            'estado' => 1,
            'fecha_finalizacion' => date('Y-m-d'),
            'hora_final' => date('H:i:s')
        );
        $Requerimientos = $this->requerimientosRepository->update($data, $id);
                            $datos = implode("-", array_flatten($Requerimientos['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"Requerimientos","acc"=>"Finalizar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        

        Flash::success('Requerimiento Finalizado Correctamente.');
        return redirect(route('requerimientoMovimiento', ['id' => $usu_id,'op'=>0]));
    }

    public function anular($id, $usu_id) {
        $data = array(
            'estado' => 2,
            'fecha_finalizacion' => date('Y-m-d')
        );
        $Requerimientos = $this->requerimientosRepository->update($data, $id);
                            $datos = implode("-", array_flatten($Requerimientos['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"Requerimientos","acc"=>"Anular","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        

        Flash::success('Requerimiento Anulado Correctamente.');

        return redirect(route('requerimientoMovimiento', ['id' => $usu_id,'op'=>0]));
    }

    public function descargar($id) {
        $id = public_path() . "/documentos/$id";
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
            readfile($id);
            return true;
        } else {
            return false;
        }
    }

}
