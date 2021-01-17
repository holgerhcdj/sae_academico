<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAsignaHorariosRequest;
use App\Http\Requests\UpdateAsignaHorariosRequest;
use App\Repositories\AsignaHorariosRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\AnioLectivo;
use App\Models\Especialidades;
use App\Models\Cursos;
use App\Models\Jornadas;
use App\Models\Sucursales;
use App\Models\Materias;
use App\Models\Usuarios;
use App\Models\AsignaHorarios;
use App\Models\MateriasCursos;
use Illuminate\Support\Facades\DB;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Session;
    
class AsignaHorariosController extends AppBaseController {

    /** @var  AsignaHorariosRepository */
    private $asignaHorariosRepository;
    private $anl;
    private $anl_bgu;
    public function __construct(AsignaHorariosRepository $asignaHorariosRepo) {
        $this->asignaHorariosRepository = $asignaHorariosRepo;
        $this->anl=Session::get('anl_id');
        $this->anl_bgu=Session::get('periodo_id');

    }

    public function index(Request $request){
        $this->asignaHorariosRepository->pushCriteria(new RequestCriteria($request));
        $asignaHorarios = $this->asignaHorariosRepository->all();
        return view('asigna_horarios.index')
                        ->with('asignaHorarios', $asignaHorarios);
        
    }

    public function create(Request $request) {

        $asignaHorarios = AsignaHorarios::where('usu_id', $request->usu_id)->get();
        $usr = Usuarios::find($request->usu_id);
        $cursos = Cursos::orderBy('id', 'ASC')->pluck('cur_descripcion', 'id');
        $jornadas = Jornadas::orderBy('jor_descripcion', 'ASC')->pluck('jor_descripcion', 'id');
        $periodos=AnioLectivo::where('periodo',1)->orderBy('id','DESC')->pluck('anl_descripcion','id');
        $materias = Materias::where('mtr_tipo',0)
                ->orderBy('mtr_descripcion', 'ASC')
                ->pluck('mtr_descripcion', 'id') ;
        $anl_id = $this->anl;
        $anl_bgu = $this->anl_bgu;
        $usu_id = $usr->id;
//Matutitna
        $mt = DB::select("
 SELECT *
   FROM crosstab('
    select 
    ah.horas,
    ah.dia,
    m.mtr_descripcion || ''&'' || c.cur_descripcion || ''&'' || ah.paralelo || ''&'' || ah.id
from asg_horario_profesores ah, cursos c, materias m
where ah.cur_id=c.id
and ah.mtr_id=m.id
and ah.anl_id=$anl_id
and ah.usu_id=$usu_id
and ah.suc_id=1
and ah.jor_id=1
group by ah.horas,ah.dia,m.mtr_descripcion,c.cur_descripcion,ah.paralelo, ah.id
order by 1
'::text, 'select l from generate_series(1,6) l'::text) crosstab(horas text, lun text, mar text, mie text, jue text, vie text, sab text);            
 ");
//Nocturna
        $noc = DB::select("
 SELECT *
   FROM crosstab('
    select 
    ah.horas,
    ah.dia,
    m.mtr_descripcion || ''&'' || c.cur_descripcion || ''&'' || ah.paralelo || ''&'' || ah.id || ''&'' || ah.esp_id
from asg_horario_profesores ah, cursos c, materias m
where ah.cur_id=c.id
and ah.mtr_id=m.id
and ah.anl_id=$anl_id
and ah.usu_id=$usu_id
and ah.suc_id=1
and ah.jor_id=2
group by ah.horas,ah.dia,m.mtr_descripcion,c.cur_descripcion,ah.paralelo, ah.id
order by 1
'::text, 'select l from generate_series(1,6) l'::text) crosstab(horas text, lun text, mar text, mie text, jue text, vie text,sab text);            
 ");
//Semi P
    $sp = DB::select("
 SELECT *
   FROM crosstab('
    select 
    ah.horas,
    ah.dia,
    m.mtr_descripcion || ''&'' || c.cur_descripcion || ''&'' || ah.paralelo || ''&'' || ah.id || ''&'' || ah.esp_id
from asg_horario_profesores ah, cursos c, materias m
where ah.cur_id=c.id
and ah.mtr_id=m.id
and ah.anl_id=$anl_id
and ah.usu_id=$usu_id
and ah.suc_id=1
and ah.jor_id=3
group by ah.horas,ah.dia,m.mtr_descripcion,c.cur_descripcion,ah.paralelo, ah.id
order by 1
'::text, 'select l from generate_series(1,6) l'::text) crosstab(horas text, lun text, mar text, mie text, jue text, vie text,sab text);            
 ");
    //Vespertina
    $vp = DB::select("
 SELECT *
   FROM crosstab('
    select 
    ah.horas,
    ah.dia,
    m.mtr_descripcion || ''&'' || c.cur_descripcion || ''&'' || ah.paralelo || ''&'' || ah.id
from asg_horario_profesores ah, cursos c, materias m
where ah.cur_id=c.id
and ah.mtr_id=m.id
and ah.anl_id=$anl_id
and ah.usu_id=$usu_id
and ah.suc_id=1
and ah.jor_id=4
group by ah.horas,ah.dia,m.mtr_descripcion,c.cur_descripcion,ah.paralelo, ah.id
order by 1
'::text, 'select l from generate_series(1,6) l'::text) crosstab(horas text, lun text, mar text, mie text, jue text, vie text,sab text);            
 ");
        //Nocturna BGU

    $n_bgu = DB::select("
 SELECT *
   FROM crosstab('
    select 
    ah.horas,
    ah.dia,
    m.mtr_descripcion || ''&'' || c.cur_descripcion || ''&'' || ah.paralelo || ''&'' || ah.id || ''&'' || ah.esp_id
from asg_horario_profesores ah, cursos c, materias m
where ah.cur_id=c.id
and ah.mtr_id=m.id
and ah.usu_id=$usu_id
and ah.suc_id=1
and ah.jor_id=2
and ah.anl_id=$anl_bgu
and ah.esp_id=7

group by ah.horas,ah.dia,m.mtr_descripcion,c.cur_descripcion,ah.paralelo, ah.id
order by 1
'::text, 'select l from generate_series(1,6) l'::text) crosstab(horas text, lun text, mar text, mie text, jue text, vie text,sab text);            
 ");

        //Semi-Pre BGU
    $sp_bgu = DB::select("
 SELECT *
   FROM crosstab('
    select 
    ah.horas,
    ah.dia,
    m.mtr_descripcion || ''&'' || c.cur_descripcion || ''&'' || ah.paralelo || ''&'' || ah.id || ''&'' || ah.esp_id
from asg_horario_profesores ah, cursos c, materias m
where ah.cur_id=c.id
and ah.mtr_id=m.id
and ah.usu_id=$usu_id
and ah.suc_id=1

and ah.jor_id=3
and ah.anl_id=$anl_bgu
and ah.esp_id=7

group by ah.horas,ah.dia,m.mtr_descripcion,c.cur_descripcion,ah.paralelo, ah.id
order by 1
'::text, 'select l from generate_series(1,6) l'::text) crosstab(horas text, lun text, mar text, mie text, jue text, vie text,sab text);            
 ");

        return view('asigna_horarios.create')
                        ->with('anl', $this->anl)
                        ->with('cursos', $cursos)
                        ->with('jornadas', $jornadas)
                        ->with('materias', $materias)
                        ->with('usr', $usr)
                        ->with('asignaHorarios', $asignaHorarios)
                        ->with('mt', $mt)
                        ->with('noc', $noc)
                        ->with('sp', $sp)
                        ->with('vp', $vp)
                        ->with('periodos', $periodos)
                        ->with('n_bgu', $n_bgu)
                        ->with('sp_bgu', $sp_bgu)

        ;
    }

    public function destroy($id) {
        $asignaHorarios = $this->asignaHorariosRepository->findWithoutFail($id);
        if (empty($asignaHorarios)) {
            Flash::error('Horario asignado no existe');
            return redirect(route('asignaHorarios.index'));
        }
        $this->asignaHorariosRepository->delete($id);
                 $aud= new Auditoria();
                 $data=["mod"=>"Asigna Horarios","acc"=>"Eliminar","dat"=>$asignaHorarios,"doc"=>"NA"];
                 $aud->save_adt($data);        

        return redirect(route('asignaHorarios.create', $asignaHorarios->toArray()));
    }

    public function store(CreateAsignaHorariosRequest $request) {
        $datos = $request->all();
        //dd($datos);
        $h_asg = DB::select("SELECT * FROM asg_horario_profesores
            where anl_id =$datos[anl_id]
            and usu_id=$datos[usu_id]
            and suc_id=1
            and jor_id=$datos[jor_id]
            and horas=$datos[horas]
            and dia=$datos[dia]   ");

        if (count($h_asg) > 0) {
            $sms='Horario ya esta asignado';
        } else {
            $sms='';
            $asignaHorarios = $this->asignaHorariosRepository->create($datos);
                 $aud= new Auditoria();
                 $data=["mod"=>"Asigna Horarios","acc"=>"Crear","dat"=>$asignaHorarios,"doc"=>"NA"];
                 $aud->save_adt($data);        
        }
        return redirect(route('asignaHorarios.create', $datos));
    }

public function show($id) {
    $usr=DB::select("SELECT * FROM users WHERE id=$id");
    $resp=[];
    $resp=json_encode($resp);
    return view('asigna_horarios.show')
    ->with("usr",$usr[0])
    ->with("resp",$resp)
    ->with("tp",1)
    ;
}

    public function show2(Request $req) {
$id=$req->all()['usrid'];
$tp=$req->all()['tipo'];
$usr=DB::select("SELECT * FROM users WHERE id=$id");
$resp=[];
        $j=1;
        while ($j<=4) {
            $c=1;
            while ($c<=6) {

                if($dat=DB::select("select * from asg_dirigentes where anl_id=".$this->anl." and tipo=$tp and usu_id=$id and jor_id=$j and cur_id=$c and par_id='A' ")){
                  array_push($resp,$dat[0]->dirid."//A&".$c."&".$j);
                }
                if($dat=DB::select("select * from asg_dirigentes where anl_id=".$this->anl." and tipo=$tp and usu_id=$id and jor_id=$j and cur_id=$c and par_id='B' ")){
                  array_push($resp,$dat[0]->dirid."//B&".$c."&".$j);
                }
                if($dat=DB::select("select * from asg_dirigentes where anl_id=".$this->anl." and tipo=$tp and usu_id=$id and jor_id=$j and cur_id=$c and par_id='C' ")){
                    array_push($resp,$dat[0]->dirid."//C&".$c."&".$j);
                }
                if($dat=DB::select("select * from asg_dirigentes where anl_id=".$this->anl." and tipo=$tp and usu_id=$id and jor_id=$j and cur_id=$c and par_id='D' ")){
                    array_push($resp,$dat[0]->dirid."//D&".$c."&".$j);
                }
                if($dat=DB::select("select * from asg_dirigentes where anl_id=".$this->anl." and tipo=$tp and usu_id=$id and jor_id=$j and cur_id=$c and par_id='E' ")){
                    array_push($resp,$dat[0]->dirid."//E&".$c."&".$j);
                }
                if($dat=DB::select("select * from asg_dirigentes where anl_id=".$this->anl." and tipo=$tp and usu_id=$id and jor_id=$j and cur_id=$c and par_id='F' ")){
                    array_push($resp,$dat[0]->dirid."//F&".$c."&".$j);
                }
                if($dat=DB::select("select * from asg_dirigentes where anl_id=".$this->anl." and tipo=$tp and usu_id=$id and jor_id=$j and cur_id=$c and par_id='G' ")){
                    array_push($resp,$dat[0]->dirid."//G&".$c."&".$j);
                }
                if($dat=DB::select("select * from asg_dirigentes where anl_id=".$this->anl." and tipo=$tp and usu_id=$id and jor_id=$j and cur_id=$c and par_id='H' ")){
                    array_push($resp,$dat[0]->dirid."//H&".$c."&".$j);
                }


//BGU-BASICA-FLEXIBLE

                if($dat=DB::select("select * from asg_dirigentes where anl_id=".$this->anl." and tipo=$tp and usu_id=$id and jor_id=$j and cur_id=$c and par_id='ABS' ")){
                    array_push($resp,$dat[0]->dirid."//ABS&".$c."&".$j);
                }
                if($dat=DB::select("select * from asg_dirigentes where anl_id=".$this->anl." and tipo=$tp and usu_id=$id and jor_id=$j and cur_id=$c and par_id='BBS' ")){
                    array_push($resp,$dat[0]->dirid."//BBS&".$c."&".$j);
                }
                if($dat=DB::select("select * from asg_dirigentes where anl_id=".$this->anl." and tipo=$tp and usu_id=$id and jor_id=$j and cur_id=$c and par_id='CBS' ")){
                    array_push($resp,$dat[0]->dirid."//CBS&".$c."&".$j);
                }

                if($dat=DB::select("select * from asg_dirigentes where anl_id=".$this->anl." and tipo=$tp and usu_id=$id and jor_id=$j and cur_id=$c and par_id='ABG' ")){
                    array_push($resp,$dat[0]->dirid."//ABG&".$c."&".$j);
                }
                if($dat=DB::select("select * from asg_dirigentes where anl_id=".$this->anl." and tipo=$tp and usu_id=$id and jor_id=$j and cur_id=$c and par_id='BBG' ")){
                    array_push($resp,$dat[0]->dirid."//BBG&".$c."&".$j);
                }
                if($dat=DB::select("select * from asg_dirigentes where anl_id=".$this->anl." and tipo=$tp and usu_id=$id and jor_id=$j and cur_id=$c and par_id='CBG' ")){
                    array_push($resp,$dat[0]->dirid."//CBG&".$c."&".$j);
                }


                $c++;
            }
            $j++;
        }

        // $j=2;//2 y 3
        // $c=4;

                if($dat=DB::select("select * from asg_dirigentes where anl_id=".$this->anl." and tipo=$tp and usu_id=$id and jor_id=$j and cur_id=$c and par_id='ABG' ")){
                    array_push($resp,$dat[0]->dirid."//ABG&".$c."&".$j);
                }



        $resp=json_encode($resp);
        return view('asigna_horarios.show')
        ->with("usr",$usr[0])
        ->with("resp",$resp)
        ->with("tp",$tp)
        ;
    }

    public function asigna_coordinador(Request $req) {

        $dat=$req->all();
        $op=$dat['op'];

        if($op==0){
          $anl_id=$this->anl;
          $usu_id=$dat['u'];
          $cur_id=$dat['c'];
          $par_id=$dat['p'];
          $jor_id=$dat['j'];
          $tipo=$dat['tp'];;//0 Dirigente 1 Coordinador 2 Inspector

            DB::select("DELETE FROM asg_dirigentes 
                WHERE anl_id=$anl_id 
                and cur_id=$cur_id 
                and par_id='$par_id' 
                and jor_id=$jor_id 
                and  tipo=$tipo  " );

            $asg=DB::select("INSERT INTO 
                asg_dirigentes (anl_id,usu_id,cur_id,par_id,jor_id,tipo)
                VALUES(
                $anl_id,
                $usu_id,
                $cur_id,
                '$par_id',
                $jor_id,
                $tipo
                ) RETURNING dirid");

            $aud= new Auditoria();
                  $data=["mod"=>"AsignaHorarios","acc"=>"Crear","dat"=>$asg[0]->dirid,"doc"=>"NA"];
                  $aud->save_adt($data);
        }else{
            $asg=DB::select("DELETE FROM asg_dirigentes WHERE dirid=".$dat['did']);
            $aud= new Auditoria();
                 $data=["mod"=>"AsignaHorarios","acc"=>"Eliminar","dat"=>$asg,"doc"=>"NA"];
                 $aud->save_adt($data);
        }

        return Response()->json($asg[0]->dirid);

    }

    public function busca_coordinador(Request $req) {

        $dat=$req->all();

       if($resp=DB::select("select * from asg_dirigentes 
            where anl_id=".$this->anl."
            and tipo=1
            and usu_id=$dat[u]
            and jor_id=$dat[j]
            and cur_id=$dat[c]
            and par_id='$dat[p]' 
            " 
       )){
        return Response()->json($resp[0]->dirid);
       }else{
        return 0;
       }



    }


    public function edit($id) {
        $asignaHorarios = $this->asignaHorariosRepository->findWithoutFail($id);

        if (empty($asignaHorarios)) {
            Flash::error('Asigna Horarios not found');

            return redirect(route('asignaHorarios.index'));
        }

        return view('asigna_horarios.edit')->with('asignaHorarios', $asignaHorarios);
    }

    /**
     * Update the specified AsignaHorarios in storage.
     *
     * @param  int              $id
     * @param UpdateAsignaHorariosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAsignaHorariosRequest $request) {
        $asignaHorarios = $this->asignaHorariosRepository->findWithoutFail($id);

        if (empty($asignaHorarios)) {
            Flash::error('Asigna Horarios not found');

            return redirect(route('asignaHorarios.index'));
        }

        $asignaHorarios = $this->asignaHorariosRepository->update($request->all(), $id);
                 $aud= new Auditoria();
                 $data=["mod"=>"Asigna Horarios","acc"=>"Modificar","dat"=>$asignaHorarios,"doc"=>"NA"];
                 $aud->save_adt($data);        

        Flash::success('Asigna Horarios updated successfully.');

        return redirect(route('asignaHorarios.index'));
    }

    /**
     * Remove the specified AsignaHorarios from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
}
