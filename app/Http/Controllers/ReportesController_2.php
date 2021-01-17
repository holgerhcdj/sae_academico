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

    public function previewestadistica() {
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

    public function retirados() {
        $anl=Session::get('anl_id');
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
and m.mat_estado<>1
and m.anl_id=$anl
order by m.jor_id,e.esp_descripcion,m.cur_id,m.mat_paralelo,es.est_apellidos ");
        return view('reportes.retirados')
                        ->with('estudiantes', $estudiantes)
                        ->with('anl_select', $anl_select);
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
        $op=$data=$req->all()['dir_cor'];
        //dd($op);

        if($op==5){//Técnico
                //Todos los docentes técnicos
            $dir=DB::select("SELECT u.name,u.usu_apellidos,u.id,u.esp_id,ad.paralelo
                FROM asg_horario_profesores ad 
                JOIN users u ON ad.usu_id=u.id
                WHERE ad.mtr_id=1
                GROUP BY u.name,u.usu_apellidos,u.id,u.esp_id,ad.paralelo  ");

        }else{

            $dir=DB::select("SELECT u.name,u.usu_apellidos,u.id 
                FROM asg_dirigentes ad 
                JOIN users u ON ad.usu_id=u.id
                WHERE ad.tipo=$op
                GROUP BY u.name,u.usu_apellidos,u.id ");
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
if($op==5){
    //AND op.mes='7' PARA SACAR DESDE HASTA
    $tnpg_m=0;$tpg_m=0;$j=1;
    $desc_m="";
    $par_m=$d->paralelo;     
    if($pagos_m=DB::select("SELECT op.estado, count(*) FROM ordenes_pension op 
                                JOIN matriculas m ON op.mat_id=m.id 
                                WHERE m.anl_id=$anl 
                                AND m.esp_id=$d->esp_id
                                AND m.jor_id=$j
                                AND (m.cur_id=4 OR m.cur_id=5 OR m.cur_id=6)
                                AND m.mat_paralelot='$par_m'  
                                GROUP BY op.estado "))
    {
        $desc_m="PRIMERO BT SEGUNDO BT TERCERO BT";
        $tnpg_m=($pagos_m[0]->count);
        $tpg_m=($pagos_m[1]->count);
    }


}else{
    $tnpg_m=0;$tpg_m=0;$j=1;
    $desc_m="";$par_m=""; 
    if($cur_m=DB::select("SELECT * FROM asg_dirigentes ad JOIN cursos c ON ad.cur_id=c.id WHERE ad.jor_id=$j AND ad.anl_id=$anl AND ad.usu_id=".$d->id))
    {
            $desc_m=$cur_m[0]->cur_descripcion;
            $par_m=$cur_m[0]->par_id; 
        if($pagos_m=DB::select("SELECT op.estado, count(*) FROM ordenes_pension op JOIN matriculas m ON op.mat_id=m.id 
            WHERE m.anl_id=$anl AND m.cur_id=".$cur_m[0]->cur_id." AND m.jor_id=$j  AND m.mat_paralelo='".$cur_m[0]->par_id."'  GROUP BY op.estado "))
           {
               $tnpg_m=($pagos_m[0]->count);
               $tpg_m=($pagos_m[1]->count);
           }
    }
}    
//**VESPERTINA**////    
if($op==5){
    $tnpg_v=0;$tpg_v=0;$j=4;
    $desc_v="";
    $par_v=$d->paralelo;     
    if($pagos_v=DB::select("SELECT op.estado, count(*) FROM ordenes_pension op 
                                JOIN matriculas m ON op.mat_id=m.id 
                                WHERE m.anl_id=$anl 
                                AND m.esp_id=$d->esp_id
                                AND m.jor_id=$j
                                AND (m.cur_id=4 OR m.cur_id=5 OR m.cur_id=6)
                                AND m.mat_paralelot='$par_v'  
                                GROUP BY op.estado "))
    {
        $desc_v="PRIMERO BT SEGUNDO BT TERCERO BT";
        $tnpg_v=($pagos_v[0]->count);
        $tpg_v=($pagos_v[1]->count);
    }


}else{

    $tnpg_v=0;$tpg_v=0;$j=4;
    $desc_v="";$par_v=""; 
    if($cur_v=DB::select("SELECT * FROM asg_dirigentes ad JOIN cursos c ON ad.cur_id=c.id WHERE ad.jor_id=$j AND ad.anl_id=$anl AND ad.usu_id=".$d->id))
    {
            $desc_v=$cur_v[0]->cur_descripcion;
            $par_v=$cur_v[0]->par_id; 
        if($pagos_v=DB::select("SELECT op.estado, count(*) FROM ordenes_pension op JOIN matriculas m ON op.mat_id=m.id 
            WHERE m.anl_id=$anl AND m.cur_id=".$cur_v[0]->cur_id." AND m.jor_id=$j  AND m.mat_paralelo='".$cur_v[0]->par_id."'  GROUP BY op.estado "))
           {
               $tnpg_v=($pagos_v[0]->count);
               $tpg_v=($pagos_v[1]->count);
           }
    } 
}
//**NOCTURNA**////    
if($op==5){

    $tnpg_n=0;$tpg_n=0;$j=2;
    $desc_n="";
    $par_n=$d->paralelo;     
    if($pagos_n=DB::select("SELECT op.estado, count(*) FROM ordenes_pension op 
                                JOIN matriculas m ON op.mat_id=m.id 
                                WHERE m.anl_id=2 
                                AND m.esp_id=1
                                AND m.jor_id=2
                                AND (m.cur_id=4 OR m.cur_id=5 OR m.cur_id=6)
                                AND m.mat_paralelot='A'  
                                GROUP BY op.estado "))
    {
       $desc_n="PRIMERO BT SEGUNDO BT TERCERO BT";
       $tnpg_n=($pagos_n[0]->count);
       $tpg_n=($pagos_n[1]->count);
    }


}else{

    $tnpg_n=0;$tpg_n=0;$j=2;
    $desc_n="";$par_n=""; 
    if($cur_n=DB::select("SELECT * FROM asg_dirigentes ad JOIN cursos c ON ad.cur_id=c.id WHERE ad.jor_id=$j AND ad.anl_id=$anl AND ad.usu_id=".$d->id))
    {
            $desc_n=$cur_n[0]->cur_descripcion;
            $par_n=$cur_n[0]->par_id; 
        if($pagos_n=DB::select("SELECT op.estado, count(*) FROM ordenes_pension op JOIN matriculas m ON op.mat_id=m.id 
            WHERE m.anl_id=$anl AND m.cur_id=".$cur_n[0]->cur_id." AND m.jor_id=$j  AND m.mat_paralelo='".$cur_n[0]->par_id."'  GROUP BY op.estado "))
           {
               $tnpg_n=($pagos_n[0]->count);
               $tpg_n=($pagos_n[1]->count);
           }
    } 
}       
//**SEMIPRE**////    
if($op==5){

    $tnpg_s=0;$tpg_s=0;$j=3;
    $desc_s="";
    $par_s=$d->paralelo;     
    if($pagos_s=DB::select("SELECT op.estado, count(*) FROM ordenes_pension op 
                                JOIN matriculas m ON op.mat_id=m.id 
                                WHERE m.anl_id=$anl 
                                AND m.esp_id=$d->esp_id
                                AND m.jor_id=$j
                                AND (m.cur_id=4 OR m.cur_id=5 OR m.cur_id=6)
                                AND m.mat_paralelot='$par_s'  
                                GROUP BY op.estado "))
    {
       $desc_s="PRIMERO BT SEGUNDO BT TERCERO BT";        
       $tnpg_s=($pagos_s[0]->count);
       $tpg_s=($pagos_s[1]->count);
    }

}else{
    $tnpg_s=0;$tpg_s=0;$j=3;
    $desc_s="";$par_s=""; 
    if($cur_s=DB::select("SELECT * FROM asg_dirigentes ad JOIN cursos c ON ad.cur_id=c.id WHERE ad.jor_id=$j AND ad.anl_id=$anl AND ad.usu_id=".$d->id))
    {
            $desc_s=$cur_s[0]->cur_descripcion;
            $par_s=$cur_s[0]->par_id; 
        if($pagos_s=DB::select("SELECT op.estado, count(*) FROM ordenes_pension op JOIN matriculas m ON op.mat_id=m.id 
            WHERE m.anl_id=$anl AND m.cur_id=".$cur_s[0]->cur_id." AND m.jor_id=$j  AND m.mat_paralelo='".$cur_s[0]->par_id."'  GROUP BY op.estado "))
           {
               $tnpg_s=($pagos_s[0]->count);
               $tpg_s=($pagos_s[1]->count);
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


    $resp.="<tr>
    <td>$n</td>
    <td>$d->usu_apellidos $d->name</td>
    <td>".$desc_m.' '.$par_m."</td>
    <td>".$desc_v.' '.$par_v."</td>
    <td>".$desc_n.' '.$par_n."</td>
    <td>".$desc_s.' '.$par_s."</td>
    <td>
        ".number_format($tg,2)." %<progress value='$tg' max='100'></progress>
    </td>
    <tr>";


}


        return view("reportes.reporte_pago_dirigente")
        ->with("resp",$resp)
        ;

    }



}
