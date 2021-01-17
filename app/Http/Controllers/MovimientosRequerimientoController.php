<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateMovimientosRequerimientoRequest;
use App\Http\Requests\UpdateMovimientosRequerimientoRequest;
use App\Repositories\MovimientosRequerimientoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\DB;
use App\Models\Auditoria;

class MovimientosRequerimientoController extends AppBaseController {

    /** @var  MovimientosRequerimientoRepository */
    private $movimientosRequerimientoRepository;

    public function __construct(MovimientosRequerimientoRepository $movimientosRequerimientoRepo) {
        $this->movimientosRequerimientoRepository = $movimientosRequerimientoRepo;
        $this->msj();
    }

    public function index($id,$op) {

        $movimientosRequerimientos = array();
        return view('movimientos_requerimientos.index')
                        ->with('movimientosRequerimientos', $movimientosRequerimientos)
                        ->with('usu_id', $id)->with('op', $op);
    }

    public function create($id,$estado,$op) {
        if($op==0){
            $movimientosRequerimientos = DB::select("
                select r.usu_id as usur,
                r.id as req_id,
                tr.nombre_tramite,
                r.hora_registro,
                r.hora_final,
                u.name,
                u.usu_apellidos,
                r.codigo,
                r.asunto,
                r.descripcion,
                r.archivo,
                r.estado,
                r.fecha_registro,
                r.fecha_finalizacion,
                (select max(id) as mvr_id from movimientos_requerimiento m where r.id=m.req_id ),
                (select m2.personas from movimientos_requerimiento m2 where r.id=m2.req_id order by m2.id asc limit 1 )
                from requerimientos r 
                join movimientos_requerimiento mr on r.id=mr.req_id
                join tramites tr on tr.id=r.trm_id
                join users u on u.id=r.usu_id 
                where (r.last_ids like '%;$id;%' or r.last_ids like '$id;%')
                and r.estado=$estado
                group by r.usu_id,
                r.id,
                tr.nombre_tramite,
                r.hora_registro,
                r.hora_final,
                u.name,
                u.usu_apellidos,
                r.codigo,
                r.asunto,
                r.descripcion,
                r.archivo,
                r.estado,
                r.fecha_registro,
                r.fecha_finalizacion

                ");
        }else{
                $movimientosRequerimientos = DB::select("
                                                select r.usu_id as usur,r.id as req_id,tr.nombre_tramite,r.hora_registro,r.hora_final,
                                                (select id as mvr_id from movimientos_requerimiento m2 where r.id=m2.req_id order by m2.id desc limit 1),
                                                u.name,u.usu_apellidos,r.codigo,r.asunto,r.descripcion,r.archivo,r.estado,r.fecha_registro,r.fecha_finalizacion,
                                                (select personas from movimientos_requerimiento m3 where r.id=m3.req_id limit 1),
                                                (select cc_personas from movimientos_requerimiento m4 where r.id=m4.req_id limit 1)
                                                from requerimientos r, movimientos_requerimiento m, users u , tramites tr 
                                                where r.id=m.req_id 
                                                and r.usu_id=u.id 
                                                and r.trm_id=tr.id
                                                and r.estado=$estado 
                                                and (cc_personas_ids like '%;$id;%' or cc_personas_ids like '$id;%')
                                                group by r.usu_id,r.id,u.name,u.usu_apellidos,r.codigo,r.asunto,r.descripcion,r.archivo,r.estado,r.fecha_finalizacion,tr.nombre_tramite,r.hora_registro,r.hora_final
                                                order by codigo desc");
            
        }

        return view('movimientos_requerimientos.index')
                        ->with('movimientosRequerimientos', $movimientosRequerimientos)
                        ->with('usu_id', $id)->with('op', $op);

    }

    public function create_org($id,$estado,$op) {
//dd('k');
if($op==0){
                $movimientosRequerimientos = DB::select("select r.usu_id as usur,r.id as req_id,tr.nombre_tramite,r.hora_registro,r.hora_final,
                                                (select id as mvr_id from movimientos_requerimiento m2 where r.id=m2.req_id order by m2.id desc limit 1),
                                                u.name,u.usu_apellidos,r.codigo,r.asunto,r.descripcion,r.archivo,r.estado,r.fecha_registro,r.fecha_finalizacion,
                                                (select personas from movimientos_requerimiento m3 where r.id=m3.req_id limit 1),
                                                (select cc_personas from movimientos_requerimiento m4 where r.id=m4.req_id limit 1)
                                                from requerimientos r, movimientos_requerimiento m, users u, tramites tr 
                                                where r.id=m.req_id 
                                                and r.usu_id=u.id
                                                and r.trm_id=tr.id 
                                                and r.estado=$estado
                                                and (r.usu_id=$id)
                                                union 
                                                select r.usu_id as usur,r.id as req_id,tr.nombre_tramite,r.hora_registro,r.hora_final,
                                                (select id as mvr_id from movimientos_requerimiento m2 where r.id=m2.req_id order by m2.id desc limit 1),
                                                u.name,u.usu_apellidos,r.codigo,r.asunto,r.descripcion,r.archivo,r.estado,r.fecha_registro,r.fecha_finalizacion,
                                                (select personas from movimientos_requerimiento m3 where r.id=m3.req_id limit 1),
                                                (select cc_personas from movimientos_requerimiento m4 where r.id=m4.req_id limit 1)
                                                from requerimientos r, movimientos_requerimiento m, users u , tramites tr 
                                                where r.id=m.req_id 
                                                and r.usu_id=u.id 
                                                and r.trm_id=tr.id
                                                and r.estado=$estado 
                                                and (personas_ids like '%;$id;%' or personas_ids like '$id;%')
                                                group by r.usu_id,r.id,u.name,u.usu_apellidos,r.codigo,r.asunto,r.descripcion,r.archivo,r.estado,r.fecha_finalizacion,tr.nombre_tramite,r.hora_registro,r.hora_final
                                                order by codigo desc");
}else{
                $movimientosRequerimientos = DB::select("
                                                select r.usu_id as usur,r.id as req_id,tr.nombre_tramite,r.hora_registro,r.hora_final,
                                                (select id as mvr_id from movimientos_requerimiento m2 where r.id=m2.req_id order by m2.id desc limit 1),
                                                u.name,u.usu_apellidos,r.codigo,r.asunto,r.descripcion,r.archivo,r.estado,r.fecha_registro,r.fecha_finalizacion,
                                                (select personas from movimientos_requerimiento m3 where r.id=m3.req_id limit 1),
                                                (select cc_personas from movimientos_requerimiento m4 where r.id=m4.req_id limit 1)
                                                from requerimientos r, movimientos_requerimiento m, users u , tramites tr 
                                                where r.id=m.req_id 
                                                and r.usu_id=u.id 
                                                and r.trm_id=tr.id
                                                and r.estado=$estado 
                                                and (cc_personas_ids like '%;$id;%' or cc_personas_ids like '$id;%')
                                                group by r.usu_id,r.id,u.name,u.usu_apellidos,r.codigo,r.asunto,r.descripcion,r.archivo,r.estado,r.fecha_finalizacion,tr.nombre_tramite,r.hora_registro,r.hora_final
                                                order by codigo desc");

}

        return view('movimientos_requerimientos.index')
                        ->with('movimientosRequerimientos', $movimientosRequerimientos)
                        ->with('usu_id', $id)->with('op', $op);
    }

    /**
     * Show the form for creating a new MovimientosRequerimiento.
     *
     * @return Response
     */
    // public function create() {
    //     dd('ok');
    //     return view('movimientos_requerimientos.create');
    // }

    /**
     * Store a newly created MovimientosRequerimiento in storage.
     *
     * @param CreateMovimientosRequerimientoRequest $request
     *
     * @return Response
     */
    public function store(CreateMovimientosRequerimientoRequest $request) {
        $input = $request->all();
        dd($input);
        $movimientosRequerimiento = $this->movimientosRequerimientoRepository->create($input);
        $datos = implode("-", array_flatten($movimientosRequerimiento['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"Requerimientos","acc"=>"Insertar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        

        Flash::success('Movimientos Requerimiento saved successfully.');
        return redirect(route('movimientosRequerimientos.index'));
    }

    /**
     * Display the specified MovimientosRequerimiento.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id, $usu_id) {
//        $movimientosRequerimiento = $this->movimientosRequerimientoRepository->findWithoutFail($id);
//dd('ok');
        $movimientosRequerimiento = DB::select("select r.usu_id as usur,m.usu_id as usum,r.id as req_id,m.id as mvr_id,u.id as usuario_id,u.*,r.*,m.*,t.nombre_tramite 
from requerimientos r, movimientos_requerimiento m , users u,tramites t 
where r.id=m.req_id 
and m.usu_id=u.id
and r.trm_id=t.id 
and m.req_id=$id 
order by mvr_fecha,r.codigo,m.id");
        $req=DB::select("select * from requerimientos where id=$id");

        return view('movimientos_requerimientos.show')
                        ->with('movimientosRequerimiento', $movimientosRequerimiento)
                        ->with('usu_id', $usu_id)
                        ->with('req', $req);
    }

    /**
     * Show the form for editing the specified MovimientosRequerimiento.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id) {
        $movimientosRequerimiento = $this->movimientosRequerimientoRepository->findWithoutFail($id);
        if (empty($movimientosRequerimiento)) {
            Flash::error('Movimientos Requerimiento not found');
            return redirect(route('movimientosRequerimientos.index'));
        }
        return view('movimientos_requerimientos.edit')->with('movimientosRequerimiento', $movimientosRequerimiento);
    }

    /**
     * Update the specified MovimientosRequerimiento in storage.
     *
     * @param  int              $id
     * @param UpdateMovimientosRequerimientoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMovimientosRequerimientoRequest $request) {
        $movimientosRequerimiento = $this->movimientosRequerimientoRepository->findWithoutFail($id);
        if (empty($movimientosRequerimiento)) {
            Flash::error('Movimientos Requerimiento not found');
            return redirect(route('movimientosRequerimientos.index'));
        }
        $movimientosRequerimiento = $this->movimientosRequerimientoRepository->update($request->all(), $id);
        $datos = implode("-", array_flatten($movimientosRequerimiento['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"Requerimientos","acc"=>"Modificar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        
        Flash::success('Movimientos Requerimiento updated successfully.');
        return redirect(route('movimientosRequerimientos.index'));
    }

    /**
     * Remove the specified MovimientosRequerimiento from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id) {
        $movimientosRequerimiento = $this->movimientosRequerimientoRepository->findWithoutFail($id);

        if (empty($movimientosRequerimiento)) {
            Flash::error('Movimientos Requerimiento not found');

            return redirect(route('movimientosRequerimientos.index'));
        }

        $this->movimientosRequerimientoRepository->delete($id);
        $datos = implode("-", array_flatten($movimientosRequerimiento['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"Requerimientos","acc"=>"Eliminar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        

        Flash::success('Movimientos Requerimiento deleted successfully.');

        return redirect(route('movimientosRequerimientos.index'));
    }

}
