<?php

namespace App\Http\Controllers;
use App\Models\AnioLectivo;
use Illuminate\Support\Facades\DB;
use Auth;
use Session;
class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $us=(Auth::user()->id);
        $esp=(Auth::user()->esp_id);
        $prf=(Auth::user()->usu_perfil);
        $anl=Session::get('anl_id');
        $anl_bgu=Session::get('periodo_id');
        $sql_cursos="and m.mat_paralelo=ah.paralelo";

        if($prf==3){//Si es Docente Tecnico
            $sql_cursos="and m.esp_id=$esp and m.mat_paralelot=ah.paralelo ";
        }

        $cursos=DB::select("select ah.anl_id,ah.jor_id,ah.cur_id,ah.paralelo,
           (select count(*) from matriculas m where m.anl_id=ah.anl_id and m.jor_id=ah.jor_id and m.cur_id=ah.cur_id and m.mat_estado=1  $sql_cursos )
           from asg_horario_profesores ah
           where ah.usu_id=$us
           and (ah.anl_id=$anl or ah.anl_id=$anl_bgu)
           group by ah.jor_id,ah.cur_id,ah.paralelo,ah.anl_id ");
//dd($cursos);
        $nest=0;
        foreach ($cursos as $c) {
            $nest+=$c->count;
        }


        return view('home')
        ->with('cursos',$cursos)
        ->with('nest',$nest);
        ;
    }
}
