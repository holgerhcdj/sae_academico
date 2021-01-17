<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMateriasCursosRequest;
use App\Http\Requests\UpdateMateriasCursosRequest;
use App\Repositories\MateriasCursosRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\AnioLectivo;
use App\Models\Cursos;
use App\Models\Materias;
use App\Models\Especialidades;
use App\Models\Jornadas;
use App\Models\Sucursales;
use App\Models\MateriasCursos;
use Session;
use App\Models\Auditoria;

class MateriasCursosController extends AppBaseController {

    private $materiasCursosRepository;

    public function __construct(MateriasCursosRepository $materiasCursosRepo) {
        $this->materiasCursosRepository = $materiasCursosRepo;
    }

    public function index(Request $request) {
        $this->materiasCursosRepository->pushCriteria(new RequestCriteria($request));
        $materiasCursos = $this->materiasCursosRepository->all();
        return view('materias_cursos.index')
                        ->with('materiasCursos', $materiasCursos);
    }

    public function create() {
        return view('materias_cursos.create');
    }

    public function store(CreateMateriasCursosRequest $request) {

        $req = $request->all();
        //$anl= AnioLectivo::where("anl_selected",1)->get();
        $anl= AnioLectivo::where("id",Session::get('anl_id'))->get();

        if($req['mtr_id']=="0"){
            $datos['mtr_descripcion']=$req['mtr_descripcion'];
            $datos['mtr_obs']=null;
            $datos['mtr_tipo']=1;//Tecnico
            $datos['anl_id']=$anl[0]['id'];
            $datos['esp_id']=$req['esp_id'];
            $materias=Materias::create($datos);
            $req['mtr_id']=$materias->id;
        }
        $tipo = $req['tipo'];
        $materiasCursos = $this->materiasCursosRepository->create($req);
                 $aud= new Auditoria();
                 $data=["mod"=>"MateriasCursos","acc"=>"Insertar","dat"=>$materiasCursos,"doc"=>"NA"];
                 $aud->save_adt($data);        

        return $this->asignarnew($req, $tipo);
    }

    public function asignarnew($req){
        $datos = $req;
        $materias = DB::select("  SELECT m.*,es.esp_descripcion FROM materias m
          JOIN especialidades es ON m.esp_id=es.id
          WHERE not exists(
          SELECT * FROM asg_materias_cursos am 
          WHERE am.anl_id=$datos[anl_id]
          AND am.suc_id=$datos[suc_id]
          AND am.jor_id=$datos[jor_id]
          AND am.esp_id=$datos[esp_id]
          AND am.cur_id=$datos[cur_id]
          AND m.id=am.mtr_id
          )
          AND m.mtr_tipo=1
          AND m.esp_id=$datos[esp_id]
          ORDER BY m.mtr_descripcion  ");
        
        $materiasCursos = MateriasCursos::leftjoin('materias as m','m.id','=','mtr_id')
                ->select('asg_materias_cursos.*','m.mtr_descripcion')
                ->where('asg_materias_cursos.anl_id', $datos['anl_id'])
                ->where('asg_materias_cursos.suc_id', $datos['suc_id'])
                ->where('asg_materias_cursos.esp_id', $datos['esp_id'])
                ->where('asg_materias_cursos.cur_id', $datos['cur_id'])
                ->where('asg_materias_cursos.jor_id', $datos['jor_id'])
                ->orderBy('m.mtr_descripcion','ASC')
                ->get();
                $esp= Especialidades::find($datos['esp_id']);                
        return view('materias_cursos.create')
                        ->with('datos', $datos)
                        ->with('materias', $materias)
                        ->with('materiasCursos', $materiasCursos)
                        ->with('esp',$esp) ;
        
    }

    public function asignar(Request $req) {
      //dd('ok');
        $anl_select = AnioLectivo::where('id', '=', Session::get('anl_id'))->get();
        $datos = $req->all();
        $datos += ['anl_id' => $anl_select[0]['id']];
        $datos += ['suc_id' => 1];
        $datos += ['esp_id' => 10];
        
        $materias = DB::select("
          SELECT m.*,es.esp_descripcion FROM materias m
          JOIN especialidades es ON m.esp_id=es.id
          WHERE not exists(
          SELECT * FROM asg_materias_cursos am 
          WHERE am.anl_id=$datos[anl_id]
          AND am.suc_id=$datos[suc_id]
          AND am.jor_id=$datos[jor_id]
          AND am.esp_id=$datos[esp_id]
          AND am.cur_id=$datos[cur_id]
          AND m.id=am.mtr_id
          )
          AND m.mtr_tipo=1
          AND m.esp_id=$datos[esp_id]
          ORDER BY m.mtr_descripcion 
 
          ");

        $materiasCursos = MateriasCursos::leftjoin('materias as m','m.id','=','mtr_id')
                ->select('asg_materias_cursos.*','m.mtr_descripcion')
                ->where('asg_materias_cursos.anl_id', $datos['anl_id'])
                ->where('asg_materias_cursos.suc_id', $datos['suc_id'])
                ->where('asg_materias_cursos.esp_id', $datos['esp_id'])
                ->where('asg_materias_cursos.cur_id', $datos['cur_id'])
                ->where('asg_materias_cursos.jor_id', $datos['jor_id'])
                ->orderBy('m.mtr_descripcion','ASC')
                ->get();
        $esp= Especialidades::find($datos['esp_id']);
        return view('materias_cursos.create')
                        ->with('datos', $datos)
                        ->with('materias', $materias)
                        ->with('materiasCursos', $materiasCursos)
                        ->with('esp', $esp)                
                ;
    }


public function asignar_cultural($dt){
    $dat=explode("&",$dt);
    //$anl= AnioLectivo::where("anl_selected",1)->get();
    $anl= AnioLectivo::where("id",Session::get('anl_id'))->get();
    $anl_id=$anl[0]['id'];
    $req=[];
    if($dat[1]>0){
        $req=['anl_id'=>$anl[0]['id'],
        'suc_id'=>1,
        'jor_id'=>1,
        'esp_id'=>10,
        'cur_id'=>$dat[0],
        'mtr_id'=>$dat[1],
        'horas'=>$dat[3],
        'obs'=>$dat[4],
    ];
    }else{

        $req=['mtr_descripcion'=>$dat[2],
        'mtr_obs'=>null,
        'mtr_tipo'=>0,
        'anl_id'=>$anl_id,
        'esp_id'=>10
        ];
        $materias=Materias::create($req);
                 $aud= new Auditoria();
                 $data=["mod"=>"Materias","acc"=>"Insertar","dat"=>$materias,"doc"=>"NA"];
                 $aud->save_adt($data);        

        $req=['anl_id'=>$anl_id,
        'suc_id'=>1,
        'jor_id'=>1,
        'esp_id'=>10,
        'cur_id'=>$dat[0],
        'mtr_id'=>$materias->id,
        'horas'=>$dat[3],
        'obs'=>$dat[4]
        ];

    }
    $materiasCursos = $this->materiasCursosRepository->create($req); 
                 $aud= new Auditoria();
                 $data=["mod"=>"MateriasCursos","acc"=>"Insertar","dat"=>$materiasCursos,"doc"=>"NA"];
                 $aud->save_adt($data);        

    $mtr_asg=DB::select("select *,ac.id as ac_id from asg_materias_cursos ac, materias m where ac.mtr_id=m.id and  ac.anl_id=$anl_id and ac.esp_id=10 and ac.cur_id=$dat[0] ");

    $materias=DB::select("select * from materias
                                where not exists(
                                select * from asg_materias_cursos where 
                                 anl_id=$anl_id
                                  and suc_id=1
                                  and jor_id=1
                                  and esp_id=10
                                  and cur_id=$dat[0]
                                  and materias.id=mtr_id
                                  )
                                  and materias.id<>1
                                  and materias.id<>3
                                  and materias.mtr_tipo=0  
                                  order by mtr_descripcion");   
$resm="<option value='0'>Nueva Materia</option>";                                   

foreach ($materias as $mt) {
    $resm.="<option value='$mt->id'>$mt->mtr_descripcion</option>";                
}

    $res="";
    $x=0;

    foreach ($mtr_asg as $m) {
        $x++;
        $res.="<tr>
        <td>$x</td>
        <td>$m->mtr_descripcion</td>
        <td>$m->horas</td>
        <td>$m->obs</td>
        <td>
        </td>
        </tr>";
    }

    return response()->json($res."&".$resm);
}


    public function show($id) {
        $materiasCursos = $this->materiasCursosRepository->findWithoutFail($id);
        if (empty($materiasCursos)) {
            Flash::error('Materias Cursos not found');

            return redirect(route('materiasCursos.index'));
        }
        return view('materias_cursos.show')->with('materiasCursos', $materiasCursos);
    }

    public function edit($id) {
        $materiasCursos = $this->materiasCursosRepository->findWithoutFail($id);

        if (empty($materiasCursos)) {
            Flash::error('Materias Cursos not found');

            return redirect(route('materiasCursos.index'));
        }

        return view('materias_cursos.edit')->with('materiasCursos', $materiasCursos);
    }

    public function update($id, UpdateMateriasCursosRequest $request) {
        $materiasCursos = $this->materiasCursosRepository->findWithoutFail($id);
        if (empty($materiasCursos)) {
            Flash::error('Materias Cursos not found');
            return redirect(route('materiasCursos.index'));
        }
        $materiasCursos = $this->materiasCursosRepository->update($request->all(), $id);
                 $aud= new Auditoria();
                 $data=["mod"=>"MateriasCursos","acc"=>"Modificar","dat"=>$materiasCursos,"doc"=>"NA"];
                 $aud->save_adt($data);        

        Flash::success('Materias Cursos updated successfully.');
        return redirect(route('materiasCursos.index'));
    }

    public function destroy($id) {
        $materiasCursos = $this->materiasCursosRepository->findWithoutFail($id);
        $req = $materiasCursos;
        if (empty($materiasCursos)) {
            Flash::error('Materias Cursos not found');
            return redirect(route('materiasCursos.index'));
        }
        $this->materiasCursosRepository->delete($id);
                 $aud= new Auditoria();
                 $data=["mod"=>"MateriasCursos","acc"=>"Eliminar","dat"=>$materiasCursos,"doc"=>"NA"];
                 $aud->save_adt($data);        

        return $this->asignarnew($req);
    }

    public function elimina_cultural(Request $req) {
        $id=$req->all();

        $materiasCursos=$this->materiasCursosRepository->delete($id['asm_id']);
                 $aud= new Auditoria();
                 $data=["mod"=>"MateriasCursos","acc"=>"Eliminar","dat"=>$materiasCursos,"doc"=>"NA"];
                 $aud->save_adt($data);        

        return redirect()->route('materias.show',$id);
    }


}
