<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMatriculasRequest;
use App\Http\Requests\UpdateMatriculasRequest;
use App\Repositories\MatriculasRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Estudiantes;
use App\Models\AnioLectivo;
use App\Models\Cursos;
use App\Models\Jornadas;
use App\Models\Especialidades;
use App\Models\Matriculas;
use App\Models\Sucursales;
use Laracasts\Flash\Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Response;
use App\Models\Auditoria;


class MatriculasController extends AppBaseController {

    /** @var  MatriculasRepository */
    private $matriculasRepository;
    private $mod_id = 10;

    public function __construct(MatriculasRepository $matriculasRepo) {
        $this->matriculasRepository = $matriculasRepo;
    }

    public function buscar(Request $req) {
        $b = $req->all();
        $jor = Jornadas::all();
        $esp = Especialidades::all();
        $cur = Cursos::all();

        if ($b['jor'] == '0' && $b['esp'] == '0' && $b['cur'] == '0') {
            $matriculas = Matriculas::paginate();
        } elseif ($b['jor'] > 0 && $b['esp'] == '0' && $b['cur'] == '0') {
            $matriculas = Matriculas::where('jor_id', '=', $b['jor'])->get();
        } elseif ($b['jor'] > 0 && $b['esp'] > 0 && $b['cur'] == '0') {
            $matriculas = Matriculas::where('jor_id', '=', $b['jor'])
                    ->where('esp_id', '=', $b['esp'])
                    ->get();
        } elseif ($b['jor'] > 0 && $b['esp'] > 0 && $b['cur'] > 0) {
            $matriculas = Matriculas::where('jor_id', '=', $b['jor'])
                    ->where('esp_id', '=', $b['esp'])
                    ->where('cur_id', '=', $b['cur'])
                    ->get();
        } elseif ($b['jor'] == '0' && $b['esp'] > 0 && $b['cur'] > 0) {
            $matriculas = Matriculas::where('esp_id', '=', $b['esp'])
                    ->where('cur_id', '=', $b['cur'])
                    ->get();
        } elseif ($b['jor'] == '0' && $b['esp'] == '0' && $b['cur'] > 0) {
            $matriculas = Matriculas::where('cur_id', '=', $b['cur'])
                    ->get();
        } elseif ($b['jor'] == '0' && $b['esp'] > 0 && $b['cur'] == '0') {
            $matriculas = Matriculas::where('esp_id', '=', $b['esp'])
                    ->get();
        }



        return view('matriculas.index')
                        ->with('matriculas', $matriculas)
                        ->with('esp', $esp)
                        ->with('jor', $jor)
                        ->with('cur', $cur)
                        ->with('busqueda', $b);
                        
    }

    public function index() {
        $matriculas = Matriculas::all();
        $jor = Jornadas::all();
        $esp = Especialidades::all();
        $cur = Cursos::all();
        return view('matriculas.index')
                        ->with('matriculas', $matriculas)
                        ->with('esp', $esp)
                        ->with('jor', $jor)
                        ->with('cur', $cur);
    }

    /**
     * Show the form for creating a new Matriculas.
     *
     * @return Response
     */
    public function create($id) {

        $estudiantes = Estudiantes::all();
        $est = Estudiantes::find($id);

        $anios = AnioLectivo::orderBy('anl_descripcion', 'ASC')->pluck('anl_descripcion', 'id');
        $anl_select = AnioLectivo::where('id', '=', Session::get('anl_id'))->get();

        $especialidades = Especialidades::orderBy('esp_descripcion', 'ASC')->pluck('esp_descripcion', 'id');
        $cursos = Cursos::orderBy('cur_descripcion', 'ASC')->pluck('cur_descripcion', 'id');
        $jornadas = Jornadas::orderBy('jor_descripcion', 'ASC')->pluck('jor_descripcion', 'id');
        $sucursales = Sucursales::orderBy('nombre', 'ASC')->pluck('nombre', 'id');

        return view('matriculas.create')
                        ->with('estudiantes', $estudiantes)
                        ->with('anios', $anios)
                        ->with('especialidades', $especialidades)
                        ->with('cursos', $cursos)
                        ->with('jornadas', $jornadas)
                        ->with('anl_select', $anl_select)
                        ->with('est', $est)
                        ->with('sucursales', $sucursales);

    }

    public function show($id) {
        $matriculas = $this->matriculasRepository->findWithoutFail($id);
        if (empty($matriculas)) {
            Flash::error('Matriculas not found');
            return redirect(route('matriculas.index'));
        }
        return view('matriculas.show')->with('matriculas', $matriculas);
    }


    public function edit($id) {

        $permisos = $this->permisos($this->mod_id);
        $matriculas = Matriculas::find($id);

        if($matriculas->esp_id==7){
            $anl_select = Session::get('periodo_id');
            $prd=1;
        }else{
            $anl_select = Session::get('anl_id');
            $prd=0;
        }

        //$anios = AnioLectivo::where('periodo',$prd)->orderBy('anl_descripcion', 'ASC')->pluck('anl_descripcion', 'id');
        $anios = AnioLectivo::orderBy('anl_descripcion', 'ASC')->pluck('anl_descripcion', 'id');

        $especialidades = Especialidades::orderBy('esp_descripcion', 'ASC')->pluck('esp_descripcion', 'id');
        $cursos = Cursos::orderBy('cur_descripcion', 'ASC')->pluck('cur_descripcion', 'id');
        $jornadas = Jornadas::orderBy('jor_descripcion', 'ASC')->pluck('jor_descripcion', 'id');
        $sucursales = Sucursales::orderBy('nombre', 'ASC')->pluck('nombre', 'id');

        $est = Estudiantes::find($matriculas->est_id);
        if (empty($matriculas)) {
            Flash::error('Matriculas not found');
            return redirect(route('matriculas.index'));
        }

        //Flash::error('Matriculas not found');

        return view('matriculas.edit')
                        ->with('matriculas', $matriculas)
                        ->with('anios', $anios)
                        ->with('especialidades', $especialidades)
                        ->with('cursos', $cursos)
                        ->with('anl_select', $anl_select)
                        ->with('jornadas', $jornadas)
                        ->with('est', $est)
                        ->with('sucursales', $sucursales)
                        ->with('permisos', $permisos)
        ;
    }

    public function store(CreateMatriculasRequest $request) {
        $input = $request->all();
        $matriculas = $this->matriculasRepository->create($input);
        $datos = implode("-", array_flatten($matriculas['attributes']));        
                 $aud= new Auditoria();
                 $data=["mod"=>"Matriculas","acc"=>"Insertar","dat"=>$matriculas,"doc"=>"NA"];
                 $aud->save_adt($data);        

        Flash::success('Matriculas creada successfully.');
        return redirect(route('estudiantes.index'));
    }

    public function update($id, UpdateMatriculasRequest $request) {

        $matriculas = $this->matriculasRepository->findWithoutFail($id);
        $datos = $request->all();
         if($matriculas->mat_estado==0 && $datos['mat_estado']==1){
            DB::select("update matriculas set created_at='".date('Y-m-d')."' where id=$id ");
         }


        if($datos['pase_anio']==0){

            if($datos['mat_paralelo']!=$datos['validar']){

                $n_mat=DB::select("select count(*) from matriculas where anl_id=$datos[anl_id] 
                    and jor_id=$datos[jor_id]
                    and cur_id=$datos[cur_id]
                    and mat_paralelo='$datos[mat_paralelo]' 
                    and mat_estado=1");
                $cupo=DB::select("select cupo from cursos where id=$datos[cur_id]");
                if($n_mat[0]->count>=$cupo[0]->cupo){
                    Flash::error('No hay cupo en el paralelo');
                }else{
                    $matriculas = $this->matriculasRepository->update($datos, $id);
                    $datos = implode("-", array_flatten($matriculas['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"Matriculas","acc"=>"Modificar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        

                    Flash::success('Matricula Actualizada Correctamente');
                }
            }else{
                $matriculas = $this->matriculasRepository->update($datos, $id);
                $datos = implode("-", array_flatten($matriculas['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"Matriculas","acc"=>"Modificar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        


                Flash::success('Matricula Actualizada Correctamente');
            }

        }else if($datos['pase_anio']>0){

            $find_mat=DB::select("select * from matriculas where anl_id=$datos[anl_id] and est_id=$datos[est_id] ");
            if(empty($find_mat)){ //Si no se ha matriculado en el otro año lectivo
                if($datos['pase_anio']>0){//si es 1 o 2
    //valido el cupo
                $n_mat=DB::select("select count(*) from matriculas where anl_id=$datos[anl_id] 
                    and jor_id=$datos[jor_id]
                    and cur_id=$datos[cur_id]
                    and mat_paralelo='$datos[mat_paralelo]' 
                    and mat_estado=1");
                $cupo=DB::select("select cupo from cursos where id=$datos[cur_id]");

                    if($n_mat[0]->count>=$cupo[0]->cupo){
                        Flash::error('No hay cupo en el paralelo');
                    }else{
                        $matriculas = $this->matriculasRepository->create($datos);
                        $datos = implode("-", array_flatten($matriculas['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"Matriculas","acc"=>"Insertar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        

                        Flash::success('Estudiante Inscrito/Matriculado en nuevo año lectivo');
                    }   
                }else{
                    if (empty($matriculas)) {
                        Flash::error('Matricula no existe');
                        return redirect(route('estudiantes.index'));
                    }
                    $matriculas = $this->matriculasRepository->update($datos, $id);
                       $datos = implode("-", array_flatten($matriculas['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"Matriculas","acc"=>"Modificar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        

                    Flash::success('Matricula Actualizada Correctamente');
                }
            }else{
            Flash::error('Estudiante ya está inscrito/matriculado');
            }

        }
        
        return redirect(route('estudiantes.index'));

    }

    /**
     * Remove the specified Matriculas from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id) {
        $matriculas = $this->matriculasRepository->findWithoutFail($id);

        if (empty($matriculas)) {
            Flash::error('Matriculas not found');

            return redirect(route('matriculas.index'));
        }

        $this->matriculasRepository->delete($id);
        $datos = implode("-", array_flatten($matriculas['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"Matriculas","acc"=>"Eliminar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        

        Flash::success('Matriculas deleted successfully.');

        return redirect(route('matriculas.index'));
    }



    public function revisa_asistencia(Request $rq){
        $dt=$rq->all();
        $rst_ast=DB::select(" select * from asistencia where mat_id=$dt[matid] order by fecha desc limit 1 ");
        if(!empty($rst_ast)){
            $f=$rst_ast[0]->fecha;
        }else{
            $f=0;
        }
        return Response()->json($f);

    }


}
