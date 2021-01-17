<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEstudiantesRequest;
use App\Http\Requests\UpdateEstudiantesRequest;
use App\Repositories\EstudiantesRepository;
use App\Http\Controllers\AppBaseController;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Estudiantes;
use Laracasts\Flash\Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\AnioLectivo;
use App\Models\Cursos;
use App\Models\Jornadas;
use App\Models\Especialidades;
use App\Models\Sucursales;
use App\Models\Matriculas;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Models\Auditoria;


class EstudiantesController extends AppBaseController {

    /** @var  EstudiantesRepository */
    private $estudiantesRepository;
    private $mod_id = 10;

    public function __construct(EstudiantesRepository $estudiantesRepo) {
        $this->estudiantesRepository = $estudiantesRepo;
    }

    public function index() {

        $permisos = $this->permisos($this->mod_id);
        $jor = Jornadas::all();
        $esp = Especialidades::all();
        $cur = Cursos::all();
        $estudiantes = array();
        $anl_select= AnioLectivo::where("id",Session::get('anl_id'))->get();

        return view('estudiantes.index')
                        ->with('estudiantes', $estudiantes)
                        ->with('esp', $esp)
                        ->with('jor', $jor)
                        ->with('cur', $cur)
                        ->with('anl_select', $anl_select)
                        ->with('permisos', $permisos);
    }

    public function valida_cedulas() {
        $permisos = $this->permisos($this->mod_id);
        $datos = Estudiantes::all();
        $resultado = array();
        foreach ($datos as $d) {
            $r = $this->validarCI($d->est_cedula);
            if (!$r) {
                array_push($resultado, $d->est_cedula);
            }
        }

        return view('estudiantes.cedulas')->with('resultado', $resultado)->with('permisos', $permisos);
    }


    public function valida_cupo($req,Request $data){
        $anl= AnioLectivo::where("id",Session::get('anl_id'))->get();
        $anlid=$anl[0]['id'];
        if($data->ajax()){
            $dat=$data->all();
                $n_mat=DB::select("select count(*) from matriculas where anl_id=$anlid 
                    and jor_id=$dat[jor]
                    and cur_id=$dat[cur]
                    and mat_paralelo='$dat[par]' 
                    and mat_estado=1");            
                $cupo=DB::select("select cupo from cursos where id=$dat[cur]");

                if($n_mat[0]->count>=$cupo[0]->cupo){
                    return 1;//No hay Cupo                    
                }else{
                    return 0;//Si hay Cupo                    
                }

            //return response()->json($dat['op']);
        }
    }


    public function validarCI($strCedula) {
        if (strlen($strCedula) < 10) {
            return false;
        }
        if (strlen($strCedula) > 10) {
            return false;
        }
        $suma = 0;
        $strOriginal = $strCedula;
        $intProvincia = substr($strCedula, 0, 2);
        $intTercero = $strCedula[2];
        $intUltimo = $strCedula[9];
        if (!settype($strCedula, "float"))
            return FALSE;
        if ((int) $intProvincia < 1 || (int) $intProvincia > 23)
            return FALSE;
        if ((int) $intTercero == 7 || (int) $intTercero == 8)
            return FALSE;
        for ($indice = 0; $indice < 9; $indice++) {
//echo $strOriginal[$indice],'';
            switch ($indice) {
                case 0:
                case 2:
                case 4:
                case 6:
                case 8:
                    $arrProducto[$indice] = $strOriginal[$indice] * 2;
                    if ($arrProducto[$indice] >= 10)
                        $arrProducto[$indice] -= 9;
//echo $arrProducto[$indice],'';
                    break;
                case 1:
                case 3:
                case 5:
                case 7:
                    $arrProducto[$indice] = $strOriginal[$indice] * 1;
                    if ($arrProducto[$indice] >= 10)
                        $arrProducto[$indice] -= 9;
//echo $arrProducto[$indice],'';
                    break;
            }
        }
        foreach ($arrProducto as $indice => $producto)
            $suma += $producto;
        $residuo = $suma % 10;
        $intVerificador = $residuo == 0 ? 0 : 10 - $residuo;
        return ($intVerificador == $intUltimo ? TRUE : FALSE);
    }

    public function buscar(Request $req) {
//dd('ok');

        $anl= Session::get('anl_id');
        $anl_bgu= Session::get('periodo_id');
        $permisos = $this->permisos($this->mod_id);
        $b = $req->all();
        $b['txt'] = strtoupper($b['txt']);
        $jor = Jornadas::all();
        $esp = Especialidades::all();
        $cur = Cursos::all();

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
            'especialidades.esp_descripcion',
            'jornadas.jor_descripcion',
            'cursos.cur_descripcion');


        if (strlen($b['txt']) == 0) {//SI NO SE SE ESCRIBE ALGO

            if ($b['jor'] == '0' && $b['esp'] == '0' && $b['cur'] == '0' && $b['parc'] == '0' && $b['part'] == '0') {
                //SI SE PIDE TODOS ok
                $estudiantes = \DB::table('matriculas')
                        ->select($select)
                        ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                        ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                        ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                        ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                        ->orderBy('estudiantes.est_apellidos', 'ASC')
                        ->where('mat_estado', '=', $b['mat_estado'])
                        ->where('anl_id', '=', $anl)
                        ->get();
            } elseif ($b['jor'] > 0 && $b['esp'] == '0' && $b['cur'] == '0' && $b['parc'] == '0' && $b['part'] == '0') {
                //SOLO JORNADA ok
                $estudiantes = \DB::table('matriculas')
                        ->select($select)
                        ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                        ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                        ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                        ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                        ->orderBy('estudiantes.est_apellidos', 'ASC')
                        ->where('jor_id', '=', $b['jor'])
                        ->where('mat_estado', '=', $b['mat_estado'])
                        ->where('anl_id', '=', $anl)
                        ->get();

            } elseif ($b['jor'] > 0 && $b['esp'] == '0' && $b['cur'] != '0' && $b['parc'] == '0' && $b['part'] == '0') {
                //SOLO JORNADA y CURSO 
                //DD('OKK');
                $estudiantes = \DB::table('matriculas')
                        ->select($select)
                        ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                        ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                        ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                        ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                        ->orderBy('estudiantes.est_apellidos', 'ASC')
                        ->where('jor_id', '=', $b['jor'])
                        ->where('esp_id', '<>',7)
                        ->where('esp_id', '<>',8)
                        ->where('cur_id', '=', $b['cur'])
                        ->where('mat_estado', '=', $b['mat_estado'])
                        ->where('anl_id', '=', $anl)
                        ->get();

            } elseif ($b['jor'] > 0 && $b['esp'] > 0 && $b['cur'] == '0' && $b['parc'] == '0' && $b['part'] == '0') {
                //JORNADA Y ESPECIALIDAD ok
                if($b['esp']==7){
                    $anl=Session::get('periodo_id');
                }
                $estudiantes = \DB::table('matriculas')
                        ->select($select)
                        ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                        ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                        ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                        ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                        ->where('jor_id', '=', $b['jor'])
                        ->where('esp_id', '=', $b['esp'])
                        ->where('mat_estado', '=', $b['mat_estado'])
                        ->where('anl_id', '=', $anl)
                        ->orderBy('estudiantes.est_apellidos', 'ASC')
                        ->get();
            } elseif ($b['jor'] > 0 && $b['esp'] > 0 && $b['cur'] > 0 && $b['parc'] == '0' && $b['part'] == '0') {
                if($b['esp']==7){
                    $anl=Session::get('periodo_id');
                }
                //SI ES JORNADA ESPECIALIDAD Y CURSO
                $estudiantes = \DB::table('matriculas')
                        ->select($select)
                        ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                        ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                        ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                        ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                        ->where('jor_id', '=', $b['jor'])
                        ->where('esp_id', '=', $b['esp'])
                        ->where('cur_id', '=', $b['cur'])
                        ->where('mat_estado', '=', $b['mat_estado'])
                        ->where('anl_id', '=', $anl)
                        ->orderBy('estudiantes.est_apellidos', 'ASC')
                        ->get();

            } elseif ($b['jor'] > 0 && $b['esp'] == '0' && $b['cur'] > 0 && $b['parc'] != '0' && $b['part'] == '0') {
//JORNADA CURSO PARALELO CULTURAL
                if($b['esp']==7){
                    $anl=Session::get('periodo_id');
                }

                $estudiantes = \DB::table('matriculas')
                        ->select($select)
                        ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                        ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                        ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                        ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                        ->where('jor_id', '=', $b['jor'])
                        ->where('cur_id', '=', $b['cur'])
                        ->where('mat_paralelo', '=', $b['parc'])
                        ->where('esp_id', '<>', 7)
                        ->where('esp_id', '<>', 8)
                        ->where('mat_estado', '=', $b['mat_estado'])
                        ->where('anl_id', '=', $anl)
                        ->orderBy('estudiantes.est_apellidos', 'ASC')
                        ->get();
            } elseif ($b['jor'] > 0 && $b['esp'] > 0 && $b['cur'] > 0 && $b['parc'] == '0' && $b['part'] != '0') {
                if($b['esp']==7){
                    $anl=Session::get('periodo_id');
                }
                //JORNADA ESPECIALIDAD CURSO PARALELO TECNICO
                $estudiantes = \DB::table('matriculas')
                        ->select($select)
                        ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                        ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                        ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                        ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                        ->where('jor_id', '=', $b['jor'])
                        ->where('esp_id', '=', $b['esp'])
                        ->where('cur_id', '=', $b['cur'])
                        ->where('mat_paralelot', '=', $b['part'])
                        ->where('mat_estado', '=', $b['mat_estado'])
                        ->where('anl_id', '=', $anl)
                        ->orderBy('estudiantes.est_apellidos', 'ASC')
                        ->get();
            } elseif ($b['jor'] > 0 && $b['esp'] > 0 && $b['cur'] > 0 && $b['parc'] != '0' && $b['part'] == '0') {
                if($b['esp']==7){
                    $anl=Session::get('periodo_id');
                }
                //JORNADA ESPECIALIDAD CURSO PARALELO CULTURAL
                $estudiantes = \DB::table('matriculas')
                        ->select($select)
                        ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                        ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                        ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                        ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                        ->where('jor_id', '=', $b['jor'])
                        ->where('esp_id', '=', $b['esp'])
                        ->where('cur_id', '=', $b['cur'])
                        ->where('mat_paralelo', '=', $b['parc'])
                        ->where('mat_estado', '=', $b['mat_estado'])
                        ->where('anl_id', '=', $anl)
                        ->orderBy('estudiantes.est_apellidos', 'ASC')
                        ->get();
            } elseif ($b['jor'] > 0 && $b['esp'] == '0' && $b['cur'] == '0' && $b['parc'] != '0' && $b['part'] == '0') {
                //JORNADA PARALELO CULTURAL OJO NO TIENE SENTIDO
                $estudiantes = \DB::table('matriculas')
                        ->select($select)
                        ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                        ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                        ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                        ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                        ->where('jor_id', '=', $b['jor'])
                        ->where('mat_paralelo', '=', $b['parc'])
                        ->where('esp_id', '<>', 7)
                        ->where('esp_id', '<>', 8)
                        ->where('mat_estado', '=', $b['mat_estado'])
                        ->where('anl_id', '=', $anl)
                        ->orderBy('estudiantes.est_apellidos', 'ASC')
                        ->get();
            } elseif ($b['jor'] =='0' && $b['esp'] == '0' && $b['cur'] == '0' && $b['parc'] == '0' && $b['part'] == 'NINGUNO') {
    //QUIENES NO ESTAN ASIGNADOS EN PARALELOS TECNICOS
                $estudiantes = \DB::table('matriculas')
                        ->select($select)
                        ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                        ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                        ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                        ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                        ->where('mat_paralelot', '=', $b['part'])
                        ->where('mat_estado', '=', $b['mat_estado'])
                        ->where('esp_id', '<>', 7)
                        ->where('esp_id', '<>', 8)
                        ->where('anl_id', '=', $anl)
                        ->orderBy('estudiantes.est_apellidos', 'ASC')
                        ->get();
            } elseif ($b['jor'] =='0' && $b['esp'] == '0' && $b['cur'] == '0' && $b['parc'] == 'NINGUNO' && $b['part'] == '0') {
    //QUIENES NO ESTAN ASIGNADOS EN PARALELOS CULTURALES            
                $estudiantes = \DB::table('matriculas')
                        ->select($select)
                        ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                        ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                        ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                        ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                        ->where('mat_paralelo', '=', $b['parc'])
                        ->where('mat_estado', '=', $b['mat_estado'])
                        ->where('esp_id', '<>', 7)
                        ->where('esp_id', '<>', 8)
                        ->where('anl_id', '=', $anl)
                        ->orderBy('estudiantes.est_apellidos', 'ASC')
                        ->get();
            } else {

                return redirect(route('estudiantes.index'));
            }
        } else {
            $estudiantes = \DB::table('matriculas')
                    ->select($select)
                    ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                    ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                    ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                    ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                    ->where(function($q)use($anl,$anl_bgu){
                        $q->orWhere('anl_id', '=', $anl)
                        ->orWhere('anl_id', '=', $anl_bgu);
                    })
                    ->where(function($q)use($b){
                        $q->orWhere('est_apellidos', 'like', '%' . $b['txt'] . '%')
                        ->orWhere('est_nombres', 'like', '%' . $b['txt'] . '%')
                        ->orWhere('est_cedula', 'like', '%' . $b['txt'] . '%');
                    })
                    ->orderBy('estudiantes.est_apellidos', 'ASC')
                    ->get();

        }
        $anl_select = AnioLectivo::where('id', '=', $anl)->get();
        if (isset($b['search'])) {
            if ($b['search'] == 'Buscar') {
                return view('estudiantes.index')
                                ->with('estudiantes', $estudiantes)
                                ->with('anl_select', $anl_select)
                                ->with('busqueda', $b)
                                ->with('esp', $esp)
                                ->with('jor', $jor)
                                ->with('cur', $cur)
                                ->with('permisos', $permisos);

            } elseif ($b['search'] == 'excel') {

                Excel::create('Estudiantes', function($excel) use($estudiantes, $anl_select, $b) {
                    $excel->sheet('Lista', function($sheet) use($estudiantes, $anl_select, $b) {
                        $jor = Jornadas::find($b['jor']);
                        $esp = Especialidades::find($b['esp']);
                        $cur = Cursos::find($b['cur']);
                        $sheet->loadView('reportes.listasxl')
                                ->with('estudiantes', $estudiantes)
                                ->with('anl_select', $anl_select)
                                ->with('jornada', $jor)
                                ->with('especialidad', $esp)
                                ->with('curso', $cur)
                                ->with('busqueda', $b)
                        ;
                    });
                })->export('xls');
                
            } elseif ($b['search'] == 'pdf') {
                $jor = Jornadas::find($b['jor']);
                $esp = Especialidades::find($b['esp']);
                $cur = Cursos::find($b['cur']);
                $pdf = PDF::loadView('reportes.listaspdf', [
                            'estudiantes' => $estudiantes,
                            'anl_select' => $anl_select,
                            'jornada' => $jor,
                            'especialidad' => $esp,
                            'curso' => $cur,
                            'busqueda' => $b
                ]);

                return $pdf->stream();
            } elseif ($b['search'] == 'matriz') {
                
                $this->matriz($req);
            }
        }
    }
    public function matriz(Request $req) {
        //$anl= AnioLectivo::where("id",Session::get('anl_id'))->get();
        $b = $req->all();
        $anl=Session::get('anl_id');
        $anl_bgu=Session::get('periodo_id');
        if($b['esp']==7){
            $anl=$anl_bgu;
        }

        $permisos = $this->permisos($this->mod_id);
        $b['txt'] = strtoupper($b['txt']);
        $jor = Jornadas::all();
        $esp = Especialidades::all();
        $cur = Cursos::all();

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
            'especialidades.esp_descripcion',
            'jornadas.jor_descripcion',
            'cursos.cur_descripcion');


        if (strlen($b['txt']) == 0) {


            if ($b['jor'] == '0' && $b['esp'] == '0' && $b['cur'] == '0' && $b['parc'] == '0' && $b['part'] == '0') {
                $estudiantes = \DB::table('matriculas')
                        ->select($select)
                        ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                        ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                        ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                        ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                        ->where('anl_id', '=', $anl)
                        ->orderBy('estudiantes.est_apellidos', 'ASC')
                        ->get();
            } elseif ($b['jor'] > 0 && $b['esp'] == '0' && $b['cur'] == '0' && $b['parc'] == '0' && $b['part'] == '0') {
                $estudiantes = \DB::table('matriculas')
                        ->select($select)
                        ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                        ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                        ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                        ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                        ->orderBy('estudiantes.est_apellidos', 'ASC')
                        ->where('jor_id', '=', $b['jor'])
                        ->where('anl_id', '=', $anl)
                        ->get();
            } elseif ($b['jor'] > 0 && $b['esp'] > 0 && $b['cur'] == '0' && $b['parc'] == '0' && $b['part'] == '0') {
                $estudiantes = \DB::table('matriculas')
                        ->select($select)
                        ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                        ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                        ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                        ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                        ->where('jor_id', '=', $b['jor'])
                        ->where('esp_id', '=', $b['esp'])
                        ->where('anl_id', '=', $anl)
                        ->orderBy('estudiantes.est_apellidos', 'ASC')
                        ->get();
            } elseif ($b['jor'] > 0 && $b['esp'] > 0 && $b['cur'] > 0 && $b['parc'] == '0' && $b['part'] == '0') {
                $estudiantes = \DB::table('matriculas')
                        ->select($select)
                        ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                        ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                        ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                        ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                        ->where('jor_id', '=', $b['jor'])
                        ->where('esp_id', '=', $b['esp'])
                        ->where('cur_id', '=', $b['cur'])
                        ->where('anl_id', '=', $anl)
                        ->orderBy('estudiantes.est_apellidos', 'ASC')
                        ->get();
            } elseif ($b['jor'] > 0 && $b['esp'] == '0' && $b['cur'] > 0 && $b['parc'] != '0' && $b['part'] == '0') {
                //JORNADA CURSO PARALELO
                $estudiantes = \DB::table('matriculas')
                        ->select($select)
                        ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                        ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                        ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                        ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                        ->where('jor_id', '=', $b['jor'])
                        ->where('cur_id', '=', $b['cur'])
                        ->where('mat_paralelo', '=', $b['parc'])
                        ->where('esp_id', '<>', 7)
                        ->where('esp_id', '<>', 8)
                        ->where('anl_id', '=', $anl)
                        ->orderBy('estudiantes.est_apellidos', 'ASC')
                        ->get();
            } elseif ($b['jor'] > 0 && $b['esp'] == '0' && $b['cur'] > 0 && $b['parc'] == '0' && $b['part'] == '0') {
                //JORNADA CURSO 
                $estudiantes = \DB::table('matriculas')
                        ->select($select)
                        ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                        ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                        ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                        ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                        ->where('jor_id', '=', $b['jor'])
                        ->where('cur_id', '=', $b['cur'])
                        ->where('esp_id', '<>', 7)
                        ->where('esp_id', '<>', 8)
                        ->where('anl_id', '=', $anl)
                        ->orderBy('estudiantes.est_apellidos', 'ASC')
                        ->get();

            } elseif ($b['jor'] > 0 && $b['esp'] > 0 && $b['cur'] > 0 && $b['parc'] == '0' && $b['part'] != '0') {
                $estudiantes = \DB::table('matriculas')
                        ->select($select)
                        ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                        ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                        ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                        ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                        ->where('jor_id', '=', $b['jor'])
                        ->where('esp_id', '=', $b['esp'])
                        ->where('cur_id', '=', $b['cur'])
                        ->where('anl_id', '=', $anl)
                        ->where('mat_paralelot', '=', $b['part'])
                        ->orderBy('estudiantes.est_apellidos', 'ASC')
                        ->get();
            } elseif ($b['jor'] > 0 && $b['esp'] > 0 && $b['cur'] > 0 && $b['parc'] != '0' && $b['part'] == '0') {
                $estudiantes = \DB::table('matriculas')
                        ->select($select)
                        ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                        ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                        ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                        ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                        ->where('jor_id', '=', $b['jor'])
                        ->where('esp_id', '=', $b['esp'])
                        ->where('cur_id', '=', $b['cur'])
                        ->where('mat_paralelo', '=', $b['parc'])
                        ->where('anl_id', '=', $anl)
                        ->orderBy('estudiantes.est_apellidos', 'ASC')
                        ->get();
            } elseif ($b['jor'] > 0 && $b['esp'] == '0' && $b['cur'] == '0' && $b['parc'] != '0' && $b['part'] == '0') {
                $estudiantes = \DB::table('matriculas')
                        ->select($select)
                        ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                        ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                        ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                        ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                        ->where('jor_id', '=', $b['jor'])
                        ->where('mat_paralelo', '=', $b['parc'])
                        ->where('esp_id', '<>', 7)
                        ->where('esp_id', '<>', 8)
                        ->where('anl_id', '=', $anl)
                        ->orderBy('estudiantes.est_apellidos', 'ASC')
                        ->get();
            } elseif ($b['jor'] =='0' && $b['esp'] == '0' && $b['cur'] == '0' && $b['parc'] == '0' && $b['part'] == 'NINGUNO') {
                $estudiantes = \DB::table('matriculas')
                        ->select($select)
                        ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                        ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                        ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                        ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                        ->where('mat_paralelot', '=', $b['part'])
                        ->where('esp_id', '<>', 7)
                        ->where('esp_id', '<>', 8)
                        ->where('anl_id', '=', $anl)
                        ->orderBy('estudiantes.est_apellidos', 'ASC')
                        ->get();
            } elseif ($b['jor'] =='0' && $b['esp'] == '0' && $b['cur'] == '0' && $b['parc'] == 'NINGUNO' && $b['part'] == '0') {
                $estudiantes = \DB::table('matriculas')
                        ->select($select)
                        ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                        ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                        ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                        ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                        ->where('mat_paralelo', '=', $b['parc'])
                        ->where('esp_id', '<>', 7)
                        ->where('esp_id', '<>', 8)
                        ->where('anl_id', '=', $anl)
                        ->orderBy('estudiantes.est_apellidos', 'ASC')
                        ->get();
            } else {
                Flash::warning('Debe elejir un criterio de busqueda');
                return redirect(route('estudiantes.index'));
            }
        } else {
            $estudiantes = \DB::table('matriculas')
                    ->select($select)
                    ->leftJoin('estudiantes', 'estudiantes.id', '=', 'matriculas.est_id')
                    ->leftJoin('especialidades', 'especialidades.id', '=', 'matriculas.esp_id')
                    ->leftJoin('jornadas', 'jornadas.id', '=', 'matriculas.jor_id')
                    ->leftJoin('cursos', 'cursos.id', '=', 'matriculas.cur_id')
                    ->where('est_apellidos', 'like', '%' . $b['txt'] . '%')
                    ->where('anl_id', '=', $anl)
                    ->orWhere('est_nombres', 'like', '%' . $b['txt'] . '%')
                    ->orWhere('est_cedula', 'like', '%' . $b['txt'] . '%')
                    ->orderBy('estudiantes.est_apellidos', 'ASC')
                    ->get();
        }
        $anl_select = AnioLectivo::where('anl_selected', '=', 1)->get();

                Excel::create('Matriz', function($excel) use($estudiantes, $anl_select, $b) {
                    $excel->sheet('Matriz', function($sheet) use($estudiantes, $anl_select, $b) {
                        $jor = Jornadas::find($b['jor']);
                        $sheet->setAutoFilter('A4:Z4');
                        $sheet->loadView('reportes.matrizxl')
                                ->with('estudiantes', $estudiantes)
                                ->with('anl_select', $anl_select)
                                ->with('jornada', $jor);
                    });
                })->export('xls');     
        

    }

    /**
     * Show the form for creating a new Estudiantes.
     *
     * @return Response
     */
    public function create() {

        $permisos = $this->permisos($this->mod_id);
        $especialidades = Especialidades::orderBy('esp_descripcion', 'ASC')->pluck('esp_descripcion', 'id');
        $cursos = Cursos::orderBy('id', 'ASC')->pluck('cur_descripcion', 'id');
        $jornadas = Jornadas::orderBy('jor_descripcion', 'ASC')->pluck('jor_descripcion', 'id');
        $sucursales = Sucursales::orderBy('nombre', 'DESC')->pluck('nombre', 'id');
        return view('estudiantes.create')
                        ->with('especialidades', $especialidades)
                        ->with('cursos', $cursos)
                        ->with('jornadas', $jornadas)
                        ->with('sucursales', $sucursales)
                        ->with('permisos', $permisos);

    }

    /**
     * Store a newly created Estudiantes in storage.
     *
     * @param CreateEstudiantesRequest $request
     *
     * @return Response
     */
    public function store(CreateEstudiantesRequest $request) {
        //dd('ok');
        $permisos = $this->permisos($this->mod_id);
        $datos = $request->all();

        if ($datos['est_tdocumento'] == 0) {
            $rst = $this->validarCI(trim($datos['est_cedula']));
        } else {
            $rst = true;
        }
        if ($datos['est_tdocumentor'] == 0) {
            $rst2 = $this->validarCI(trim($datos['rep_cedula']));
        } else {
            $rst2 = true;
        }


        if (!$rst) {
            Flash::error('Cedula del Estudiante Incorrecta');
            return $this->create();
        } elseif (!$rst2) {
            Flash::error('Cedula del Representante Incorrecta');
            return $this->create();
        } else {

            $date = date_create($datos['est_fnac']);
            $datos['est_fnac'] = date_format($date, 'Y-m-d');

            $est = array(
                'est_codigo' => $datos['est_codigo'],
                'est_cedula' => $datos['est_cedula'],
                'est_apellidos' => $datos['est_apellidos'],
                'est_nombres' => $datos['est_nombres'],
                'est_sexo' => $datos['est_sexo'],
                'est_fnac' => $datos['est_fnac'],
                'est_sector' => $datos['est_sector'],
                'est_direccion' => $datos['est_direccion'],
                'est_telefono' => $datos['est_telefono'],
                'est_celular' => $datos['est_celular'],
                'est_email' => $datos['est_email'],
                'est_discapacidad' => $datos['est_discapacidad'],
                'est_porcentaje_disc' => $datos['est_porcentaje_disc'],
                'est_tiposangre' => $datos['est_tiposangre'],
                'proc_pais' => $datos['proc_pais'],
                'proc_provincia' => $datos['proc_provincia'],
                'proc_canton' => $datos['proc_canton'],
                'proc_sector' => $datos['proc_sector'],
                'rep_cedula' => $datos['rep_cedula'],
                'rep_nombres' => $datos['rep_nombres'],
                'rep_telefono' => $datos['rep_telefono'],
                'rep_mail' => $datos['rep_mail'],
                'est_obs' => $datos['est_obs'],
                'est_tdocumento' => $datos['est_tdocumento']
            );
            $estudiantes = Estudiantes::create($est);
                 $aud= new Auditoria();
                 $datos_audt = implode("-", array_flatten($estudiantes['attributes']));        
                 $data=["mod"=>"Estudiantes","acc"=>"Insertar","dat"=>$datos_audt,"doc"=>"NA"];
                 $aud->save_adt($data);                    

            //$anl= AnioLectivo::where("id",Session::get('anl_id'))->get();
            $anio_l=Session::get('anl_id');
            if($datos['esp_id']==7){
                $anio_l=Session::get('periodo_id');
            }

            $mat = array(
                'est_id' => $estudiantes['id'],
                'anl_id' => $anio_l,
                'esp_id' => $datos['esp_id'],
                'cur_id' => $datos['cur_id'],
                'jor_id' => $datos['jor_id'],
                'proc_id' => $datos['proc_id'],
                'dest_id' => $datos['dest_id'],
                'mat_paralelo' => $datos['mat_paralelo'],
                'mat_paralelot' => $datos['mat_paralelot'],
                'mat_estado' => $datos['mat_estado'],
                'mat_obs' => $datos['mat_obs'],
                'est_tipo' => $datos['est_tipo'],
                'responsable' => $datos['responsable'],
                'plantel_procedencia' => $datos['plantel_procedencia'],
                'facturar' => $datos['facturar'],
                'fac_razon_social' => $datos['fac_razon_social'],
                'fac_ruc' => $datos['fac_ruc'],
                'fac_direccion' => $datos['fac_direccion'],
                'fac_telefono' => $datos['fac_telefono'],
                'enc_tipo' => $datos['enc_tipo'],
                'enc_detalle' => $datos['enc_detalle'],
                'docs' => $datos['docs']
            );


                // $n_mat=DB::select("select count(*) from matriculas where anl_id=$mat[anl_id] 
                //     and jor_id=$mat[jor_id]
                //     and cur_id=$mat[cur_id]
                //     and mat_paralelo='$mat[mat_paralelo]' 
                //     and mat_estado=1");
                // $cupo=DB::select("select cupo from cursos where id=$mat[cur_id]");

                // if($n_mat[0]->count>=$cupo[0]->cupo){
                //     $mat['mat_paralelo']='NINGUNO';
                //     Flash::warning('No hay cupo favor elejir otro paralelo');
                // }else{
                //     Flash::success('Estudiantes guardado y matriculado correctamente');
                // }

                $matriculas = Matriculas::create($mat);
                 $aud= new Auditoria();
                 $data=["mod"=>"Matriculas","acc"=>"Insertar","dat"=>$matriculas,"doc"=>"NA"];
                 $aud->save_adt($data);        

                return redirect(route('estudiantes.index'));

        }
    }

    /**
     * Display the specified Estudiantes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id) {
        $permisos = $this->permisos($this->mod_id);
        $estudiantes = $this->estudiantesRepository->findWithoutFail($id);
        if (empty($estudiantes)) {
            Flash::error('Estudiantes not found');
            return redirect(route('estudiantes.index'));
        }
        return view('estudiantes.show')->with('estudiantes', $estudiantes)->with('permisos', $permisos);
    }

    /**
     * Show the form for editing the specified Estudiantes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id) {
        $permisos = $this->permisos($this->mod_id);
        $estudiantes = $this->estudiantesRepository->findWithoutFail($id);
        if (empty($estudiantes)) {
            Flash::error('Estudiantes not found');
            return redirect(route('estudiantes.index'));
        }
        return view('estudiantes.edit')->with('estudiantes', $estudiantes)->with('permisos', $permisos);
    }

    /**
     * Update the specified Estudiantes in storage.
     *
     * @param  int              $id
     * @param UpdateEstudiantesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEstudiantesRequest $request) {
        $input = $request->all();
        $date = date_create($input['est_fnac']);
        $input['est_fnac'] = date_format($date, 'Y-m-d');
        $messages = array(
            'est_cedula.required' => 'Cedula es obligatorio.',
            'est_cedula.unique' => 'Cedula ya esta asignada a otro usuario'
        );
        $rules = array(
            'est_cedula' => 'required|unique:estudiantes,est_cedula,' . $id,
        );
        $v = Validator::make($input, $rules, $messages);
        if ($v->fails()) {
            Flash::error('Cedula ya esta registrada');
            return $this->edit($id);
        } else {

            if ($input['est_tdocumento'] == 0) {
                $rst = $this->validarCI(trim($input['est_cedula']));
            } else {
                $rst = true;
            }
            if ($input['est_tdocumentor'] == 0) {
                $rst2 = $this->validarCI(trim($input['rep_cedula']));
            } else {
                $rst2 = true;
            }


            if (!$rst) {
                Flash::error('Cedula del Estudiante Incorrecta');
                return $this->edit($id);
            } elseif (!$rst2) {
                Flash::error('Cedula del Representante Incorrecta');
                return $this->edit($id);
            } else {
                $estudiantes = Estudiantes::find($id);
                if (empty($estudiantes)) {
                    Flash::error('Estudiantes not found');
                    return redirect(route('estudiantes.index'));
                }
                $estudiantes->fill($input);
                $estudiantes->save();

                 $aud= new Auditoria();
                 $datos = implode("-", array_flatten($estudiantes['attributes']));        
                 $data=["mod"=>"Estudiantes","acc"=>"Modificar","dat"=>$datos,"doc"=>"NA"];
                 $aud->save_adt($data);                    


                Flash::success('Estudiantes actualizado correctamente.');
                return redirect(route('estudiantes.index'));
            }
        }
    }

    public function destroy($id) {
        $msj="";
        $estudiantes = $this->estudiantesRepository->findWithoutFail($id);
        $anl= AnioLectivo::where("id",Session::get('anl_id'))->get();
        $anlid = $anl[0]['id'];
        $matricula = Matriculas::where('est_id', '=', $id)
                ->where('anl_id', '=', $anlid)
                ->get();
        $idmat = $matricula[0]['id'];

        try { 
            Matriculas::destroy($idmat);
                 $aud= new Auditoria();
                 $datos = implode("-", array_flatten($matricula['attributes']));        
                 $data=["mod"=>"Matriculas","acc"=>"Eliminar","dat"=>$datos,"doc"=>"NA"];
                 $aud->save_adt($data);                    

            $msj="Matrícula Eliminada Correctamente / ";
        } catch(\Illuminate\Database\QueryException $ex){ 
             if($ex->getCode()=='23503'){
                $msj="<i style='color:brown;font-wight:bolder' >Matrícula no se puedo Eliminar existen datos enlazados / <i>";
             }else{
                $msj=$ex->getMessage();
             }

        }
        try { 
            $est=Estudiantes::destroy($id);
                 $aud= new Auditoria();
                 $datos = implode("-", array_flatten($est['attributes']));        
                 $data=["mod"=>"Estudiantes","acc"=>"Eliminar","dat"=>$datos,"doc"=>"NA"];
                 $aud->save_adt($data);                    

            $msj.="Estudiante Eliminado Correctamente / ";
        } catch(\Illuminate\Database\QueryException $ex){ 
             if($ex->getCode()=='23503'){
                $msj.="<i style='color:brown;font-wight:bolder' >Estudiante no se puedo Eliminar existen datos enlazados </i>";
             }else{
                $msj.=$ex->getMessage();
             }

        }
                   Flash::warning($msj);
                   return redirect(route('estudiantes.index'));
    }



    

}
