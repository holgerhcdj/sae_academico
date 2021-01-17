<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Matriculas;
use App\Models\Especialidades;
use App\Http\Controllers\AppBaseController;
use App\Models\Estudiantes;
use App\Models\Cursos;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;
use App\Models\AnioLectivo;
use Laracasts\Flash\Flash;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use App\Models\Auditoria;
use App\Models\EncEncabezado;

class ReportesController extends AppBaseController {

    private $mod_id = 14;

    public function index() {
        $matutina = array();
        $vespertina= array();
        $nocturna = array();
        $distancia = array();
        $nasignados = array('0', '0');
        $retiradosm = array();
        $retiradosv = array();
        $retiradosd = array();
        $retiradosn = array();
        $otros = array();
        $consolidado = array();

        $date = date('Y-m-d');
        //$date = $date->format('d-m-Y');

        return view("reportes.index")
                        ->with('matutina', $matutina)
                        ->with('vespertina', $vespertina)
                        ->with('nocturna', $nocturna)
                        ->with('distancia', $distancia)
                        ->with('nasignados', $nasignados)
                        ->with('retiradosm', $retiradosm)
                        ->with('retiradosv', $retiradosv)
                        ->with('retiradosd', $retiradosd)
                        ->with('retiradosn', $retiradosn)
                        ->with('nasignados', $nasignados)
                        ->with('otros', $otros)
                        ->with('date', $date)
                        ->with('consolidado', $consolidado)
        ;
    }

    public function reporte_est() {
        //return response()->json('estadistica');
        $anl=Session::get('anl_id');
        $datos=DB::select("select j.jor_descripcion,c.cur_descripcion,m.mat_paralelo,count(*) from matriculas m, jornadas j, cursos c 
            where j.id=m.jor_id
            and c.id=m.cur_id
            and m.anl_id=$anl
            and m.mat_estado=1
            group by j.id,j.jor_descripcion,c.id,c.cur_descripcion,m.mat_paralelo
            order by j.id,j.jor_descripcion,c.id,c.cur_descripcion,m.mat_paralelo
            ");
        $resp="";
        foreach ($datos as $d) {
            $resp.="<tr>
            <td class='col-xs-4 ' >$d->jor_descripcion</td>
            <td class='col-xs-4' >$d->cur_descripcion</td>
            <td class='col-xs-2' >$d->mat_paralelo</td>
            <td class='col-xs-2' >$d->count</td>

            </tr>";
        }
        return response()->json($resp);
    }


    public function rep_total() {
        $date = getdate();
        $fecha = ($date['mday']) . "-" . $date['mon'] . "-" . $date['year'];
        $anl = AnioLectivo::where('id', '=', Session::get('anl_id'))->get();
        $anl_id = $anl[0]['id'];
        $votos = DB::select("select e.est_cedula,
e.est_apellidos,
e.est_nombres,
j.jor_descripcion,
c.cur_descripcion,
m.mat_paralelo,
v.*
from votaciones v join estudiantes e on v.est_id=e.id
join matriculas m on m.est_id=e.id and m.anl_id=$anl_id
join jornadas j on m.jor_id=j.id
join cursos c on m.cur_id=c.id
where v.anl_id=$anl_id
order by v.lista,j.jor_descripcion, c.cur_descripcion,m.mat_paralelo,e.est_apellidos");
        return view("reportes.vot_total")
                        ->with('anl', $anl[0])
                        ->with('fecha', $fecha)
                        ->with('votos', $votos)
        ;
    }

    public function previewestadistica(Request $rq) {
        $anl=Session::get('anl_id');
        $periodo_id=Session::get('periodo_id');

        $dt=$rq->all();

        $date = Carbon::now();
        $date = $date->format('d-m-Y');
        $matutina = DB::select("
            SELECT crosstab.esp,
            crosstab.octavo,
            crosstab.noveno,
            crosstab.decimo,
            crosstab.primero,
            crosstab.segundo,
            crosstab.tercero
            FROM crosstab('select es.esp_descripcion,m.cur_id,count(e.id) as cant 
            from matriculas m, 
            estudiantes e, 
            especialidades es, 
            cursos c
            where m.est_id=e.id
            and   m.esp_id=es.id
            and   m.cur_id=c.id
            and   m.jor_id=1
            and   m.mat_estado=1
            and   m.anl_id=$anl
            group by es.esp_descripcion, m.cur_id
            order by es.esp_descripcion asc, m.cur_id asc 
            '::text, 'select l from generate_series(1,6) l'::text) crosstab(esp text, octavo text, noveno text, decimo text, primero text, segundo text, tercero text);
            ");
        $vespertina = DB::select("
            SELECT crosstab.esp,
            crosstab.octavo,
            crosstab.noveno,
            crosstab.decimo,
            crosstab.primero,
            crosstab.segundo,
            crosstab.tercero
            FROM crosstab('select es.esp_descripcion,m.cur_id,count(e.id) as cant 
            from matriculas m, 
            estudiantes e, 
            especialidades es, 
            cursos c
            where m.est_id=e.id
            and   m.esp_id=es.id
            and   m.cur_id=c.id
            and   m.jor_id=4
            and   m.mat_estado=1
            and   m.anl_id=$anl
            group by es.esp_descripcion, m.cur_id
            order by es.esp_descripcion asc, m.cur_id asc 
            '::text, 'select l from generate_series(1,6) l'::text) crosstab(esp text, octavo text, noveno text, decimo text, primero text, segundo text, tercero text);
            ");
        $nocturna = DB::select("
            SELECT crosstab.esp,
            crosstab.octavo,
            crosstab.noveno,
            crosstab.decimo,
            crosstab.primero,
            crosstab.segundo,
            crosstab.tercero
            FROM crosstab('select es.esp_descripcion,m.cur_id,count(e.id) as cant 
            from matriculas m, 
            estudiantes e, 
            especialidades es, 
            cursos c
            where m.est_id=e.id
            and   m.esp_id=es.id
            and   m.cur_id=c.id
            and   m.jor_id=2
            and   m.mat_estado=1
            and   (m.anl_id=$anl or m.anl_id=$periodo_id)
            group by es.esp_descripcion, m.cur_id
            order by es.esp_descripcion asc, m.cur_id asc 
            '::text, 'select l from generate_series(1,6) l'::text) crosstab(esp text, octavo text, noveno text, decimo text, primero text, segundo text, tercero text);

            ");
        $distancia = DB::select("
            SELECT crosstab.esp,
            crosstab.octavo,
            crosstab.noveno,
            crosstab.decimo,
            crosstab.primero,
            crosstab.segundo,
            crosstab.tercero
            FROM crosstab('select es.esp_descripcion,m.cur_id,count(e.id) as cant 
            from matriculas m, 
            estudiantes e, 
            especialidades es, 
            cursos c
            where m.est_id=e.id
            and   m.esp_id=es.id
            and   m.cur_id=c.id
            and   m.jor_id=3
            and   m.mat_estado=1
            and   (m.anl_id=$anl or m.anl_id=$periodo_id)
            group by es.esp_descripcion, m.cur_id
            order by es.esp_descripcion asc, m.cur_id asc 
            '::text, 'select l from generate_series(1,6) l'::text) crosstab(esp text, octavo text, noveno text, decimo text, primero text, segundo text, tercero text);            
            ");
        $retiradosm = DB::select("
            SELECT crosstab.esp,
            crosstab.octavo,
            crosstab.noveno,
            crosstab.decimo,
            crosstab.primero,
            crosstab.segundo,
            crosstab.tercero
            FROM crosstab('select es.esp_descripcion,m.cur_id,count(e.id) as cant 
            from matriculas m, 
            estudiantes e, 
            especialidades es, 
            cursos c
            where m.est_id=e.id
            and   m.esp_id=es.id
            and   m.cur_id=c.id
            and   m.jor_id=1
            and   m.mat_estado=2
            and   m.anl_id=$anl
            group by es.esp_descripcion, m.cur_id
            order by es.esp_descripcion asc, m.cur_id asc 
            '::text, 'select l from generate_series(1,6) l'::text) crosstab(esp text, octavo text, noveno text, decimo text, primero text, segundo text, tercero text);            
            ");
        $retiradosv = DB::select("
            SELECT crosstab.esp,
            crosstab.octavo,
            crosstab.noveno,
            crosstab.decimo,
            crosstab.primero,
            crosstab.segundo,
            crosstab.tercero
            FROM crosstab('select es.esp_descripcion,m.cur_id,count(e.id) as cant 
            from matriculas m, 
            estudiantes e, 
            especialidades es, 
            cursos c
            where m.est_id=e.id
            and   m.esp_id=es.id
            and   m.cur_id=c.id
            and   m.jor_id=4
            and   m.mat_estado=2
            and   m.anl_id=$anl
            group by es.esp_descripcion, m.cur_id
            order by es.esp_descripcion asc, m.cur_id asc 
            '::text, 'select l from generate_series(1,6) l'::text) crosstab(esp text, octavo text, noveno text, decimo text, primero text, segundo text, tercero text);            
            ");
        $retiradosd = DB::select("
            SELECT crosstab.esp,
            crosstab.octavo,
            crosstab.noveno,
            crosstab.decimo,
            crosstab.primero,
            crosstab.segundo,
            crosstab.tercero
            FROM crosstab('select es.esp_descripcion,m.cur_id,count(e.id) as cant 
            from matriculas m, 
            estudiantes e, 
            especialidades es, 
            cursos c
            where m.est_id=e.id
            and   m.esp_id=es.id
            and   m.cur_id=c.id
            and   m.jor_id=3
            and   m.mat_estado=2
            and   (m.anl_id=$anl or m.anl_id=$periodo_id)
            group by es.esp_descripcion, m.cur_id
            order by es.esp_descripcion asc, m.cur_id asc 
            '::text, 'select l from generate_series(1,6) l'::text) crosstab(esp text, octavo text, noveno text, decimo text, primero text, segundo text, tercero text);
            ");
        $retiradosn = DB::select("
           SELECT crosstab.esp,
           crosstab.octavo,
           crosstab.noveno,
           crosstab.decimo,
           crosstab.primero,
           crosstab.segundo,
           crosstab.tercero
           FROM crosstab('select es.esp_descripcion,m.cur_id,count(e.id) as cant 
           from matriculas m, 
           estudiantes e, 
           especialidades es, 
           cursos c
           where m.est_id=e.id
           and   m.esp_id=es.id
           and   m.cur_id=c.id
           and   m.jor_id=2
           and   m.mat_estado=2
           and   (m.anl_id=$anl or m.anl_id=$periodo_id)
           group by es.esp_descripcion, m.cur_id
           order by es.esp_descripcion asc, m.cur_id asc 
           '::text, 'select l from generate_series(1,6) l'::text) crosstab(esp text, octavo text, noveno text, decimo text, primero text, segundo text, tercero text);

            ");
        $otros = DB::select("
           SELECT count(*) AS cant
           FROM matriculas m
           WHERE m.mat_estado = 0 
           AND   (m.anl_id=$anl or m.anl_id=$periodo_id)
           UNION ALL
           SELECT count(*) AS cant
           FROM matriculas m
           WHERE m.mat_estado = 3
           AND   (m.anl_id=$anl or m.anl_id=$periodo_id)
           UNION ALL
           SELECT count(*) AS cant
           FROM matriculas m
           WHERE m.mat_estado = 4
           AND   (m.anl_id=$anl or m.anl_id=$periodo_id)
           ;            
            "); ///Inscritos Retirados Anulados

        $nopc = Matriculas::where('mat_paralelo', 'NINGUNO')
                ->where('esp_id', '<>', 7)
                ->where('esp_id', '<>', 8)
                ->where('mat_estado', 1)
                ->where('anl_id',$anl)
                ->get();
        $nopt = Matriculas::where('mat_paralelot', 'NINGUNO')
                ->where('esp_id', '<>', 7)
                ->where('esp_id', '<>', 8)
                ->where('mat_estado', 1)
                ->where('anl_id',$anl)
                ->get();

        $nasignados = [count($nopc), count($nopt)];

        $consolidado=DB::select("
            SELECT crosstab.esp,
            crosstab.octavo,
            crosstab.noveno,
            crosstab.decimo,
            crosstab.primero,
            crosstab.segundo,
            crosstab.tercero
            FROM crosstab('select es.esp_descripcion,m.cur_id,count(e.id) as cant 
            from matriculas m, 
            estudiantes e, 
            especialidades es, 
            cursos c
            where m.est_id=e.id
            and   m.esp_id=es.id
            and   m.cur_id=c.id
            and   m.mat_estado=1
           and   (m.anl_id=$anl or m.anl_id=$periodo_id)
            group by es.esp_descripcion, m.cur_id
            order by es.esp_descripcion asc, m.cur_id asc 
            '::text, 'select l from generate_series(1,6) l'::text) crosstab(esp text, octavo text, noveno text, decimo text, primero text, segundo text, tercero text);
            ");
//dd($dt);
        if(isset($dt['preview_excel'])){
            Excel::create('Estadisticas', function($excel) use($matutina, $vespertina,$nocturna, $distancia, $retiradosm,$retiradosv, $retiradosd, $retiradosn, $nasignados, $otros, $date,$consolidado) {
                $excel->sheet('Lista', function($sheet) use($matutina,$vespertina,$nocturna, $distancia, $retiradosm,$retiradosv, $retiradosd, $retiradosn, $nasignados, $otros, $date,$consolidado) {
                    $sheet->loadView('reportes.tablexl')
                    ->with('matutina', $matutina)
                    ->with('nocturna', $nocturna)
                    ->with('vespertina', $vespertina)
                    ->with('distancia', $distancia)
                    ->with('retiradosm', $retiradosm)
                    ->with('retiradosv', $retiradosv)
                    ->with('retiradosd', $retiradosd)
                    ->with('retiradosn', $retiradosn)
                    ->with('nasignados', $nasignados)
                    ->with('otros', $otros)
                    ->with('date', $date)
                    ->with('consolidado', $consolidado);
                });
            })->export('xls');
        }
        if(isset($dt['preview'])){
            return view("reportes.index")
            ->with('matutina', $matutina)
            ->with('vespertina', $vespertina)
            ->with('nocturna', $nocturna)
            ->with('distancia', $distancia)
            ->with('retiradosm', $retiradosm)
            ->with('retiradosv', $retiradosv)
            ->with('retiradosd', $retiradosd)
            ->with('retiradosn', $retiradosn)
            ->with('nasignados', $nasignados)
            ->with('otros', $otros)
            ->with('date', $date)
            ->with('consolidado', $consolidado);
        }





    }

    public function estadistica_xsl() {
        $anl=Session::get('anl_id');
        $date = Carbon::now();
        $date = $date->format('d-m-Y');

        $matutina = DB::select("
            SELECT crosstab.esp,
            crosstab.octavo,
            crosstab.noveno,
            crosstab.decimo,
            crosstab.primero,
            crosstab.segundo,
            crosstab.tercero
            FROM crosstab('select es.esp_descripcion,m.cur_id,count(e.id) as cant 
            from matriculas m, 
            estudiantes e, 
            especialidades es, 
            cursos c
            where m.est_id=e.id
            and   m.esp_id=es.id
            and   m.cur_id=c.id
            and   m.jor_id=1
            and   m.mat_estado=1
            and   m.anl_id=$anl
            group by es.esp_descripcion, m.cur_id
            order by es.esp_descripcion asc, m.cur_id asc 
            '::text, 'select l from generate_series(1,6) l'::text) crosstab(esp text, octavo text, noveno text, decimo text, primero text, segundo text, tercero text);
            ");
        $vespertina = DB::select("
            SELECT crosstab.esp,
            crosstab.octavo,
            crosstab.noveno,
            crosstab.decimo,
            crosstab.primero,
            crosstab.segundo,
            crosstab.tercero
            FROM crosstab('select es.esp_descripcion,m.cur_id,count(e.id) as cant 
            from matriculas m, 
            estudiantes e, 
            especialidades es, 
            cursos c
            where m.est_id=e.id
            and   m.esp_id=es.id
            and   m.cur_id=c.id
            and   m.jor_id=4
            and   m.mat_estado=1
            and   m.anl_id=$anl
            group by es.esp_descripcion, m.cur_id
            order by es.esp_descripcion asc, m.cur_id asc 
            '::text, 'select l from generate_series(1,6) l'::text) crosstab(esp text, octavo text, noveno text, decimo text, primero text, segundo text, tercero text);
            ");

        $nocturna = DB::select("
            SELECT crosstab.esp,
            crosstab.octavo,
            crosstab.noveno,
            crosstab.decimo,
            crosstab.primero,
            crosstab.segundo,
            crosstab.tercero
            FROM crosstab('select es.esp_descripcion,m.cur_id,count(e.id) as cant 
            from matriculas m, 
            estudiantes e, 
            especialidades es, 
            cursos c
            where m.est_id=e.id
            and   m.esp_id=es.id
            and   m.cur_id=c.id
            and   m.jor_id=2
            and   m.mat_estado=1
            and   m.anl_id=$anl
            group by es.esp_descripcion, m.cur_id
            order by es.esp_descripcion asc, m.cur_id asc 
            '::text, 'select l from generate_series(1,6) l'::text) crosstab(esp text, octavo text, noveno text, decimo text, primero text, segundo text, tercero text);

            ");
        $distancia = DB::select("
            SELECT crosstab.esp,
            crosstab.octavo,
            crosstab.noveno,
            crosstab.decimo,
            crosstab.primero,
            crosstab.segundo,
            crosstab.tercero
            FROM crosstab('select es.esp_descripcion,m.cur_id,count(e.id) as cant 
            from matriculas m, 
            estudiantes e, 
            especialidades es, 
            cursos c
            where m.est_id=e.id
            and   m.esp_id=es.id
            and   m.cur_id=c.id
            and   m.jor_id=3
            and   m.mat_estado=1
            and   m.anl_id=$anl
            group by es.esp_descripcion, m.cur_id
            order by es.esp_descripcion asc, m.cur_id asc 
            '::text, 'select l from generate_series(1,6) l'::text) crosstab(esp text, octavo text, noveno text, decimo text, primero text, segundo text, tercero text);            
            ");
        $retiradosm = DB::select("
            SELECT crosstab.esp,
            crosstab.octavo,
            crosstab.noveno,
            crosstab.decimo,
            crosstab.primero,
            crosstab.segundo,
            crosstab.tercero
            FROM crosstab('select es.esp_descripcion,m.cur_id,count(e.id) as cant 
            from matriculas m, 
            estudiantes e, 
            especialidades es, 
            cursos c
            where m.est_id=e.id
            and   m.esp_id=es.id
            and   m.cur_id=c.id
            and   m.jor_id=1
            and   m.mat_estado=2
            and   m.anl_id=$anl
            group by es.esp_descripcion, m.cur_id
            order by es.esp_descripcion asc, m.cur_id asc 
            '::text, 'select l from generate_series(1,6) l'::text) crosstab(esp text, octavo text, noveno text, decimo text, primero text, segundo text, tercero text);            
            ");
        $retiradosv = DB::select("
            SELECT crosstab.esp,
            crosstab.octavo,
            crosstab.noveno,
            crosstab.decimo,
            crosstab.primero,
            crosstab.segundo,
            crosstab.tercero
            FROM crosstab('select es.esp_descripcion,m.cur_id,count(e.id) as cant 
            from matriculas m, 
            estudiantes e, 
            especialidades es, 
            cursos c
            where m.est_id=e.id
            and   m.esp_id=es.id
            and   m.cur_id=c.id
            and   m.jor_id=4
            and   m.mat_estado=2
            and   m.anl_id=$anl
            group by es.esp_descripcion, m.cur_id
            order by es.esp_descripcion asc, m.cur_id asc 
            '::text, 'select l from generate_series(1,6) l'::text) crosstab(esp text, octavo text, noveno text, decimo text, primero text, segundo text, tercero text);            
            ");

        $retiradosd = DB::select("
            SELECT crosstab.esp,
            crosstab.octavo,
            crosstab.noveno,
            crosstab.decimo,
            crosstab.primero,
            crosstab.segundo,
            crosstab.tercero
            FROM crosstab('select es.esp_descripcion,m.cur_id,count(e.id) as cant 
            from matriculas m, 
            estudiantes e, 
            especialidades es, 
            cursos c
            where m.est_id=e.id
            and   m.esp_id=es.id
            and   m.cur_id=c.id
            and   m.jor_id=3
            and   m.mat_estado=2
            and   m.anl_id=$anl            
            group by es.esp_descripcion, m.cur_id
            order by es.esp_descripcion asc, m.cur_id asc 
            '::text, 'select l from generate_series(1,6) l'::text) crosstab(esp text, octavo text, noveno text, decimo text, primero text, segundo text, tercero text);
            ");
        $retiradosn = DB::select("
           SELECT crosstab.esp,
           crosstab.octavo,
           crosstab.noveno,
           crosstab.decimo,
           crosstab.primero,
           crosstab.segundo,
           crosstab.tercero
           FROM crosstab('select es.esp_descripcion,m.cur_id,count(e.id) as cant 
           from matriculas m, 
           estudiantes e, 
           especialidades es, 
           cursos c
           where m.est_id=e.id
           and   m.esp_id=es.id
           and   m.cur_id=c.id
           and   m.jor_id=2
           and   m.mat_estado=2
           and   m.anl_id=$anl            
           group by es.esp_descripcion, m.cur_id
           order by es.esp_descripcion asc, m.cur_id asc 
           '::text, 'select l from generate_series(1,6) l'::text) crosstab(esp text, octavo text, noveno text, decimo text, primero text, segundo text, tercero text);
            ");

$consolidado=DB::select("
            SELECT crosstab.esp,
            crosstab.octavo,
            crosstab.noveno,
            crosstab.decimo,
            crosstab.primero,
            crosstab.segundo,
            crosstab.tercero
            FROM crosstab('select es.esp_descripcion,m.cur_id,count(e.id) as cant 
            from matriculas m, 
            estudiantes e, 
            especialidades es, 
            cursos c
            where m.est_id=e.id
            and   m.esp_id=es.id
            and   m.cur_id=c.id
            and   m.mat_estado=1
            and   m.anl_id=$anl
            group by es.esp_descripcion, m.cur_id
            order by es.esp_descripcion asc, m.cur_id asc 
            '::text, 'select l from generate_series(1,6) l'::text) crosstab(esp text, octavo text, noveno text, decimo text, primero text, segundo text, tercero text);
            ");

        $otros = DB::select("
           SELECT count(*) AS cant
           FROM matriculas
           WHERE matriculas.mat_estado = 0
           AND matriculas.anl_id=$anl
           UNION ALL
           SELECT count(*) AS cant
           FROM matriculas
           WHERE matriculas.mat_estado = 3
           AND matriculas.anl_id=$anl
           UNION ALL
           SELECT count(*) AS cant
           FROM matriculas
           WHERE matriculas.mat_estado = 4
           AND matriculas.anl_id=$anl
           ;            
            ");
        $nopc = Matriculas::where('mat_paralelo', 'NINGUNO')
                ->where('esp_id', '<>', 7)
                ->where('esp_id', '<>', 8)
                ->where('mat_estado', 1)
                ->where('anl_id',$anl)                
                ->get();
        $nopt = Matriculas::where('mat_paralelot', 'NINGUNO')
                ->where('esp_id', '<>', 7)
                ->where('esp_id', '<>', 8)
                ->where('mat_estado', 1)
                ->where('anl_id',$anl)                
                ->get();
        $nasignados = [count($nopc), count($nopt)];

        Excel::create('Estadisticas', function($excel) use($matutina, $vespertina,$nocturna, $distancia, $retiradosm,$retiradosv, $retiradosd, $retiradosn, $nasignados, $otros, $date,$consolidado) {
            $excel->sheet('Lista', function($sheet) use($matutina,$vespertina,$nocturna, $distancia, $retiradosm,$retiradosv, $retiradosd, $retiradosn, $nasignados, $otros, $date,$consolidado) {
                $sheet->loadView('reportes.tablexl')
                        ->with('matutina', $matutina)
                        ->with('nocturna', $nocturna)
                        ->with('vespertina', $vespertina)
                        ->with('distancia', $distancia)
                        ->with('retiradosm', $retiradosm)
                        ->with('retiradosv', $retiradosv)
                        ->with('retiradosd', $retiradosd)
                        ->with('retiradosn', $retiradosn)
                        ->with('nasignados', $nasignados)
                        ->with('otros', $otros)
                        ->with('date', $date)
                        ->with('consolidado', $consolidado);
            });
        })->export('xls');

    }

    public function horarios_docentes() {
        $anl_id = Session::get('anl_id');
        $horarios = DB::select("SELECT u.id,u.name, u.usu_apellidos, j.jor_descripcion,m.mtr_descripcion ,sum(ah.horas)
FROM asg_horario_profesores ah,
users u,
jornadas j,
cursos c,
materias m
where ah.usu_id=u.id
and ah.jor_id=j.id
and ah.cur_id=c.id
and ah.mtr_id=m.id
and ah.anl_id=$anl_id
and ah.suc_id=1
group by u.id,u.name, u.usu_apellidos, j.jor_descripcion, m.mtr_descripcion, j.id, m.mtr_descripcion
order by u.usu_apellidos, j.id, m.mtr_descripcion
");
        return view("reportes.horarios")->with('horarios', $horarios);
    }

    public function votaciones() {
        $permisos = $this->permisos($this->mod_id);
        $date = getdate();
        $fecha = ($date['mday']) . "-" . $date['mon'] . "-" . $date['year'];
        $anl = AnioLectivo::where('id', '=', Session::get('anl_id'))->get();
        $votos['a'] = DB::select("select count(*) as cant from votaciones where lista='A' and anl_id=" . $anl[0]['id']);
        $votos['b'] = DB::select("select count(*) as cant from votaciones where lista='B' and anl_id=" . $anl[0]['id']);
        $votos['c'] = DB::select("select count(*) as cant from votaciones where lista='C' and anl_id=" . $anl[0]['id']);
        $votos['n'] = DB::select("select count(*) as cant from votaciones where lista='N' and anl_id=" . $anl[0]['id']);
        return view('reportes.listas')
                        ->with('votos', $votos)
                        ->with('anl', $anl[0])
                        ->with('fecha', $fecha)
                        ->with('permisos', $permisos)
        ;
    }

    public function reset_v() {
        $permisos = $this->permisos($this->mod_id);
        $date = getdate();
        $fecha = ($date['mday']) . "-" . $date['mon'] . "-" . $date['year'];
        $anl = AnioLectivo::where('id', '=', Session::get('anl_id'))->get();
        //dd($anl);
        $result = DB::select("delete from votaciones where anl_id=" . $anl[0]['id']);
        $votos['a'] = DB::select("select count(*) as cant from votaciones where lista='A' and anl_id=" . $anl[0]['id']);
        $votos['b'] = DB::select("select count(*) as cant from votaciones where lista='B' and anl_id=" . $anl[0]['id']);
        $votos['c'] = DB::select("select count(*) as cant from votaciones where lista='C' and anl_id=" . $anl[0]['id']);
        $votos['n'] = DB::select("select count(*) as cant from votaciones where lista='N' and anl_id=" . $anl[0]['id']);
        if ($result) {
            Flash::success('Reseteo Completo');
        } else {
            Flash::error('No se pudo resetear');
        }
        return view('reportes.listas')
                        ->with('votos', $votos)
                        ->with('anl', $anl[0])
                        ->with('fecha', $fecha)
                        ->with('permisos', $permisos)
        ;
    }

    public function retirados(Request $rq) {

$dt=($rq->all());

        $anl=Session::get('anl_id');
        $anl_bgu=Session::get('periodo_id');
        $anl_select = AnioLectivo::where('id', '=', $anl)->get();
        $estudiantes = DB::select("select * from matriculas m,
            especialidades e,
            estudiantes es,
            cursos c,
            jornadas j 
            where m.est_id=es.id
            and   m.esp_id=e.id
            and m.cur_id=c.id
            and m.jor_id=j.id 
            and m.mat_estado=2
            and (m.anl_id=$anl or m.anl_id=$anl_bgu)
            order by m.jor_id,e.esp_descripcion,m.cur_id,m.mat_paralelo,es.est_apellidos ");
        $inscritos = DB::select("select * from matriculas m,
            especialidades e,
            estudiantes es,
            cursos c,
            jornadas j 
            where m.est_id=es.id
            and   m.esp_id=e.id
            and m.cur_id=c.id
            and m.jor_id=j.id 
            and (m.mat_estado<>1 and m.mat_estado<>2  )
            and (m.anl_id=$anl or m.anl_id=$anl_bgu)
            order by m.jor_id,e.esp_descripcion,m.cur_id,m.mat_paralelo,es.est_apellidos ");

        if(isset($dt['btn_xls'])){
            Excel::create('Retirados_inscritos', function($excel) use($estudiantes,$inscritos,$anl_select) {
                $excel->sheet('Lista', function($sheet) use($estudiantes,$inscritos,$anl_select) {
                    $sheet->loadView('reportes.retirados_excel')
                    ->with('estudiantes', $estudiantes)
                    ->with('anl_select', $anl_select)
                    ->with('inscritos', $inscritos)
                    ;
                });
            })->export('xls');

        }else{
            return view('reportes.retirados')
            ->with('estudiantes', $estudiantes)
            ->with('anl_select', $anl_select)
            ->with('inscritos', $inscritos);
            
        }





    }


    public function reporte_pago_dirigente(){
        $resp="";
        return view("reportes.reporte_pago_dirigente")
        ->with("resp",$resp)
        ;
        
    }
    public function buscar_pagos_por_dirigente(Request $req){

        $anl=Session::get('anl_id');
        $data=$req->all();
        //$desde=$data['desde'];
        $mes_act=$data['hasta'];
        $op=$req->all()['dir_cor'];
        //  $mes_act=10;
  


if($op==5){ //si es tecnico
        $dir=DB::select("SELECT u.id,u.esp_id,u.usu_apellidos,u.name
            FROM asg_horario_profesores hp 
            JOIN users u ON hp.usu_id=u.id
            WHERE (hp.mtr_id=1 or hp.mtr_id=2)
                        AND hp.anl_id=$anl
                        AND u.usu_estado=0
                        GROUP BY u.id,u.esp_id,u.usu_apellidos,u.name
                        ORDER BY u.usu_apellidos
                         ");
}else{

        $dir=DB::select("SELECT u.name,u.usu_apellidos,u.id 
            FROM asg_dirigentes ad 
            JOIN users u ON ad.usu_id=u.id
            WHERE ad.tipo=$op
            GROUP BY u.name,u.usu_apellidos,u.id ORDER BY u.usu_apellidos");
}


$resp="";
$n=0;
foreach ($dir as $d) {
    $n++;
    $op_m=0;
    $op_v=0;
    $op_n=0;
    $op_s=0;

//**MATUTINA**////
    $tnpg_m=0;$tpg_m=0;$j=1;
    $desc_m="";$par_m=""; 
    if($op==5){ //Si es técnico
      if($cur_m=DB::select("SELECT u.id,u.esp_id,hp.jor_id,hp.cur_id,hp.paralelo,c.cur_descripcion
            FROM asg_horario_profesores hp 
            JOIN users u ON hp.usu_id=u.id
                        JOIN cursos c ON hp.cur_id=c.id
                        WHERE (hp.mtr_id=1 or hp.mtr_id=2)
                        AND hp.anl_id=$anl
                        AND u.usu_estado=0
                        AND u.id=$d->id
                        AND hp.jor_id=$j
                        GROUP BY u.id,u.esp_id,hp.jor_id,hp.cur_id,hp.paralelo,c.cur_descripcion
                        ORDER BY hp.cur_id

                         "))
      {

            foreach ($cur_m as $cm) {
                $desc_m.=$cm->cur_descripcion.'('.$cm->paralelo.')  ';
                if($pagos_m=DB::select("SELECT op.estado, count(*) FROM ordenes_pension op 
                    JOIN matriculas m ON op.mat_id=m.id 
                    WHERE m.anl_id=$anl 
                    AND m.cur_id=".$cm->cur_id." 
                    AND m.jor_id=$j 
                    AND m.esp_id=$cm->esp_id 
                    AND m.mat_paralelot='".$cm->paralelo."' 
                    AND op.codigo<>'MTGM'
                    AND cast(op.mes as integer)<=$mes_act 
                    AND m.mat_estado=1
                    GROUP BY op.estado "))
                {
                    foreach ($pagos_m as $pm) {
                        if($pm->estado==0){
                            $tnpg_m+=$pm->count;
                        }
                        if($pm->estado>=1 ){
                            $tpg_m+=$pm->count;
                        }
                    }

                }
            }


      }
    }else{
        if($cur_m=DB::select("SELECT * FROM asg_dirigentes ad JOIN cursos c ON ad.cur_id=c.id WHERE ad.jor_id=$j AND ad.anl_id=$anl AND ad.tipo=$op AND ad.usu_id=".$d->id." order by c.id"))
        {
            foreach ($cur_m as $cm) {
                $desc_m.=$cm->cur_descripcion.'('.$cm->par_id.')  ';
                if($pagos_m=DB::select("SELECT op.estado, count(*) FROM ordenes_pension op JOIN matriculas m ON op.mat_id=m.id 
                    WHERE m.anl_id=$anl AND m.cur_id=".$cm->cur_id." 
                    AND m.jor_id=$j  
                    AND op.codigo<>'MTGM'  
                    AND m.mat_paralelo='".$cm->par_id."'
                    AND m.mat_estado=1  
                    AND cast(op.mes as integer)<=$mes_act 
                    GROUP BY op.estado order by op.estado"))
                {
                    foreach ($pagos_m as $pm) {
                        if($pm->estado==0){
                            $tnpg_m+=$pm->count;
                        }
                        if($pm->estado>=1 ){
                            $tpg_m+=$pm->count;
                        }
                    }

//                                        dd($tnpg_m.'-'.$tpg_m);

                }
            }
        }
    }
// //**VESPERTINA**////    
    $tnpg_v=0;$tpg_v=0;$j=4;
    $desc_v="";$par_v=""; 
    if($op==5){ //Si es técnico
      if($cur_v=DB::select("SELECT u.id,u.esp_id,hp.jor_id,hp.cur_id,hp.paralelo,c.cur_descripcion
            FROM asg_horario_profesores hp 
            JOIN users u ON hp.usu_id=u.id
                        JOIN cursos c ON hp.cur_id=c.id
                        WHERE (hp.mtr_id=1 or hp.mtr_id=2)
                        AND hp.anl_id=$anl
                        AND u.usu_estado=0
                        AND u.id=$d->id
                        AND hp.jor_id=$j
                        GROUP BY u.id,u.esp_id,hp.jor_id,hp.cur_id,hp.paralelo,c.cur_descripcion
                        ORDER BY hp.cur_id "))

      {

            foreach ($cur_v as $cv) {
                $desc_v.=$cv->cur_descripcion.'('.$cv->paralelo.')  ';
                if($pagos_v=DB::select("
                            SELECT op.estado, count(*) FROM ordenes_pension op 
                            JOIN matriculas m ON op.mat_id=m.id 
                            WHERE m.anl_id=$anl 
                            AND m.cur_id=".$cv->cur_id." 
                            AND m.jor_id=$j 
                            AND m.esp_id=$cv->esp_id 
                            AND m.mat_paralelot='".$cv->paralelo."' 
                            AND op.codigo<>'MTGV'
                            AND m.mat_estado=1
                            AND cast(op.mes as integer)<=$mes_act  
                            GROUP BY op.estado
                    "))
                {

                    foreach ($pagos_v as $pv) {
                        if($pv->estado==0){
                            $tnpg_v+=$pv->count;
                        }
                        if($pm->estado>=1 ){
                            $tpg_v+=$pv->count;
                        }
                    }

                }
            }


      }


    }else{

        if($cur_v=DB::select("SELECT * FROM asg_dirigentes ad JOIN cursos c ON ad.cur_id=c.id WHERE ad.jor_id=$j AND ad.anl_id=$anl AND ad.tipo=$op AND ad.usu_id=".$d->id." order by c.id"))
        {
            foreach ($cur_v as $cv) {
                $desc_v.=$cv->cur_descripcion.'('.$cv->par_id.')  ';
                if($pagos_v=DB::select("SELECT op.estado, count(*) FROM ordenes_pension op 
                    JOIN matriculas m ON op.mat_id=m.id 
                    WHERE m.anl_id=$anl 
                    AND m.cur_id=".$cv->cur_id." 
                    AND m.jor_id=$j 
                    AND op.codigo<>'MTGV'  
                    AND m.mat_paralelo='".$cv->par_id."' 
                    AND m.mat_estado=1  
                    AND cast(op.mes as integer)<=$mes_act
                    GROUP BY op.estado order by op.estado"))
                {

                    foreach ($pagos_v as $pv) {
                        if($pv->estado==0){
                            $tnpg_v+=$pv->count;
                        }
                        if($pv->estado>=1 ){
                            $tpg_v+=$pv->count;
                        }
                    }

                }
            }
        }
}
// //**NOCTURNA**////    
    $tnpg_n=0;$tpg_n=0;$j=2;
    $desc_n="";$par_n=""; 
    if($op==5){ //Si es técnico
      if($cur_n=DB::select("SELECT u.id,u.esp_id,hp.jor_id,hp.cur_id,hp.paralelo,c.cur_descripcion
            FROM asg_horario_profesores hp 
            JOIN users u ON hp.usu_id=u.id
                        JOIN cursos c ON hp.cur_id=c.id
                        WHERE (hp.mtr_id=1 or hp.mtr_id=2)
                        AND hp.anl_id=$anl
                        AND u.usu_estado=0
                        AND u.id=$d->id
                        AND hp.jor_id=$j
                        GROUP BY u.id,u.esp_id,hp.jor_id,hp.cur_id,hp.paralelo,c.cur_descripcion
                        ORDER BY hp.cur_id "))

      {

            foreach ($cur_n as $cn) {
                $desc_n.=$cn->cur_descripcion.'('.$cn->paralelo.')  ';
                if($pagos_n=DB::select("
                            SELECT op.estado, count(*) FROM ordenes_pension op 
                            JOIN matriculas m ON op.mat_id=m.id 
                            WHERE m.anl_id=$anl 
                            AND m.cur_id=".$cn->cur_id." 
                            AND m.jor_id=$j 
                            AND m.esp_id=$cn->esp_id 
                            AND m.mat_paralelot='".$cn->paralelo."' 
                            AND op.codigo<>'MTGN'
                            AND m.mat_estado=1
                            AND cast(op.mes as integer)<=$mes_act  
                            GROUP BY op.estado                    
                 "))

                {
                    foreach ($pagos_n as $pn) {
                        if($pn->estado==0){
                            $tnpg_n+=$pn->count;
                        }
                        if($pn->estado>=1 ){
                            $tpg_n+=$pn->count;
                        }
                    }

                }
            }

      }

    }else{    
        if($cur_n=DB::select("SELECT * FROM asg_dirigentes ad JOIN cursos c ON ad.cur_id=c.id WHERE ad.jor_id=$j AND ad.anl_id=$anl AND ad.tipo=$op AND ad.usu_id=".$d->id." order by c.id" ))
        {
            foreach ($cur_n as $cn) {
                $par_org=$cn->par_id;
                $tmpar=substr($cn->par_id,1,2);
                if($tmpar=='BS'){
                    $txt_esp='AND m.esp_id=8';
                    $cn->par_id=substr($cn->par_id,0,1);
                }elseif($tmpar=='BG'){
                    $txt_esp='AND m.esp_id=7';
                    $cn->par_id=substr($cn->par_id,0,1);
                }else{
                    $txt_esp='AND m.esp_id<>7 AND m.esp_id<>8';
                }

                $desc_n.=$cn->cur_descripcion.'('.$par_org.')  ';
                if($pagos_n=DB::select("SELECT op.estado, count(*) FROM ordenes_pension op JOIN matriculas m ON op.mat_id=m.id 
                    WHERE m.anl_id=$anl AND m.cur_id=".$cn->cur_id." 
                    AND m.jor_id=$j AND op.codigo<>'MTGN' 
                    AND m.mat_paralelo='".$cn->par_id."'
                    $txt_esp
                    AND m.mat_estado=1
                    AND cast(op.mes as integer)<=$mes_act
                    GROUP BY op.estado order by op.estado "))
                {
                    foreach ($pagos_n as $pn) {
                        if($pn->estado==0){
                            $tnpg_n+=$pn->count;
                        }
                        if($pn->estado>=1 ){
                            $tpg_n+=$pn->count;
                        }
                    }
                }
            }



        }  
    }  
// //**SEMIPRE**////    
    $tnpg_s=0;$tpg_s=0;$j=3;
    $desc_s="";$par_s=""; 
    if($op==5){ //Si es técnico
      if($cur_s=DB::select("SELECT u.id,u.esp_id,hp.jor_id,hp.cur_id,hp.paralelo,c.cur_descripcion
            FROM asg_horario_profesores hp 
            JOIN users u ON hp.usu_id=u.id
                        JOIN cursos c ON hp.cur_id=c.id
                        WHERE (hp.mtr_id=1 or hp.mtr_id=2)
                        AND hp.anl_id=$anl
                        AND u.usu_estado=0
                        AND u.id=$d->id
                        AND hp.jor_id=$j
                        GROUP BY u.id,u.esp_id,hp.jor_id,hp.cur_id,hp.paralelo,c.cur_descripcion
                        ORDER BY hp.cur_id "))
      {

            foreach ($cur_s as $cs) {
                $desc_s.=$cs->cur_descripcion.'('.$cs->paralelo.')  ';
                if($pagos_s=DB::select("
                            SELECT op.estado, count(*) FROM ordenes_pension op 
                            JOIN matriculas m ON op.mat_id=m.id 
                            WHERE m.anl_id=$anl 
                            AND m.cur_id=".$cs->cur_id." 
                            AND m.jor_id=$j 
                            AND m.esp_id=$cs->esp_id 
                            AND m.mat_paralelot='".$cs->paralelo."' 
                            AND op.codigo<>'MTGS'
                            AND m.mat_estado=1
                            AND cast(op.mes as integer)<=$mes_act  
                            GROUP BY op.estado                    
                 "))

                {
                    foreach ($pagos_s as $ps) {
                        if($ps->estado==0){
                            $tnpg_s+=$ps->count;
                        }
                        if($ps->estado>=1 ){
                            $tpg_s+=$ps->count;
                        }
                    }                    
                }
            }

      }

    }else{        
        if($cur_s=DB::select("SELECT * FROM asg_dirigentes ad JOIN cursos c ON ad.cur_id=c.id WHERE ad.jor_id=$j AND ad.anl_id=$anl AND ad.tipo=$op AND ad.usu_id=".$d->id." order by c.id"))
        {

            foreach ($cur_s as $cs) {
                $par_org=$cs->par_id;
                $tmpar=substr($cs->par_id,1,2);
                if($tmpar=='BS'){
                    $txt_esp='AND m.esp_id=8';
                    $cs->par_id=substr($cs->par_id,0,1);
                }elseif($tmpar=='BG'){
                    $txt_esp='AND m.esp_id=7';
                    $cs->par_id=substr($cs->par_id,0,1);
                }else{
                    $txt_esp='AND m.esp_id<>7 AND m.esp_id<>8';
                }
                $desc_s.=$cs->cur_descripcion.'('.$par_org.')  ';
                if($pagos_s=DB::select("SELECT op.estado, count(*) FROM ordenes_pension op JOIN matriculas m ON op.mat_id=m.id 
                    WHERE m.anl_id=$anl AND m.cur_id=".$cs->cur_id." 
                    AND m.jor_id=$j AND op.codigo<>'MTGS' 
                    $txt_esp
                    AND m.mat_estado=1
                    AND m.mat_paralelo='".$cs->par_id."' 
                    AND cast(op.mes as integer)<=$mes_act  
                    GROUP BY op.estado order by op.estado"))
                {
                    foreach ($pagos_s as $ps) {
                        if($ps->estado==0){
                            $tnpg_s+=$ps->count;
                        }
                        if($ps->estado>=1 ){
                            $tpg_s+=$ps->count;
                        }
                    }                    

                }
            }
        }    
}


        $tnp=($tnpg_m+$tnpg_v+$tnpg_n+$tnpg_s);
        $tp=($tpg_m+$tpg_v+$tpg_n+$tpg_s);

    
if(($tnp+$tp)==0){
    $tg=$tp*100;
}else{
    $tg=$tp*100/($tnp+$tp);
}
$tx_tp="";
switch ($op) {
    case 0:$tx_tp='Dirigente';break;
    case 1:$tx_tp='Coordinador';break;
    case 2:$tx_tp='Inspector';break;
    case 3:$tx_tp='DECE';break;
    case 4:$tx_tp='Secretaría';break;
    case 5:$tx_tp='Docente/Técnico';break;
}
//$dtm=explode("-",$desc_m);
if($op==0){
    $txm=$desc_m;
    $txv=$desc_v;
    $txn=$desc_n;
    $txs=$desc_s;

}else{
    $txm='';
    if(strlen($desc_m)>0){
        $txm="<i class='btn btn-info btn-xs fa fa-arrow-circle-right btn_cursos' title='$desc_m'  data-toggle='modal' data-target='.cursos_modal'   ></i> ";
    }
    $txv='';
    if(strlen($desc_v)>0){
        $txv="<i class='btn btn-info btn-xs fa fa-arrow-circle-right btn_cursos' title='$desc_v'  data-toggle='modal' data-target='.cursos_modal'   ></i> ";
    }
    $txn='';
    if(strlen($desc_n)>0){
        $txn="<i class='btn btn-info btn-xs fa fa-arrow-circle-right btn_cursos' title='$desc_n'  data-toggle='modal' data-target='.cursos_modal'   ></i> ";
    }
    $txs='';
    if(strlen($desc_s)>0){
        $txs="<i class='btn btn-info btn-xs fa fa-arrow-circle-right btn_cursos' title='$desc_s'  data-toggle='modal' data-target='.cursos_modal'   ></i> ";
    }

}
    $resp.="<tr>
    <td>$n</td>
    <td>$tx_tp</td>
    <td>$d->usu_apellidos $d->name</td>
    <td>$txm</td>
    <td>$txv</td>
    <td>$txn</td>
    <td>$txs</td>
    <td>
        ".number_format($tg,2)." %<progress value='$tg' max='100'></progress>
    </td>
    <tr>";

}
        return view("reportes.reporte_pago_dirigente")
        ->with("resp",$resp)
        ;
 }

    public function reporte_gen_encuestas(){
        //dd();
        $rst=DB::select("select r.grp_id,
            g.grp_descripcion,
            g.grp_valoracion,
            sum(porcentage),
            count(*) as n_user,
            sum(porcentage)/count(*) as prom 
            from enc_resultados r 
            join enc_grupos g on r.grp_id=g.grp_id 
            group by r.grp_id,g.grp_descripcion,g.grp_valoracion
            order by r.grp_id ");

        return view('enc_registros.rep_general')
        ->with('rst', $rst)
        ;

    }
    public function reporte_encuestas(){
        $encuestas=EncEncabezado::all();
        //dd($encuestas);
        return view("reportes.reporte_encuestas")
        ->with('enc',$encuestas)
         ;
        
    }
    public function reporte_ind_encuestas($usu_id){

        $us=$usu_id;
        $preguntas = DB::select("select g.grp_id,g.grp_descripcion,p.prg_pregunta,g.grp_valoracion,re.respuesta 
from enc_preguntas p
left join enc_registro_encuestas re on re.prg_id=p.prg_id
join enc_encabezado e on p.enc_id=e.enc_id
join enc_grupos g on p.grp_id=g.grp_id
where e.enc_id=1
and re.usu_id=$us
order by g.grp_id,p.prg_id ");

        return view('enc_registros.edit')
        ->with('preguntas', $preguntas)
        ->with('usu_id', $usu_id)
        ;        
    }




}
