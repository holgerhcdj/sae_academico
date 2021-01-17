<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateSegSemanalDocenteRequest;
use App\Http\Requests\UpdateSegSemanalDocenteRequest;
use App\Repositories\SegSemanalDocenteRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class SegSemanalDocenteController extends AppBaseController
{
    /** @var  SegSemanalDocenteRepository */
    private $segSemanalDocenteRepository;

    public function __construct(SegSemanalDocenteRepository $segSemanalDocenteRepo)
    {
        $this->segSemanalDocenteRepository = $segSemanalDocenteRepo;
    }

    /**
     * Display a listing of the SegSemanalDocente.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $dt=($request->all());
        $reporte=[];
        $cap=[];
        if(!empty($dt)){
            if($dt['tipo']=='0'){//SI ES SEGUIMINETO DE ESTUDIANTES
                        $reporte=DB::select("select *,sc.fecha as f_asist from seguimiento_capellania sc 
                    join matriculas m on sc.mat_id=m.id
                    join estudiantes e on m.est_id=e.id
                    join users u on sc.usu_id=u.id
                    join cursos c on m.cur_id=c.id
                    join jornadas j on m.jor_id=j.id
                    where sc.fecha between '$dt[desde]' and '$dt[hasta]'
                    and sc.estado=0
                    order by u.usu_apellidos 
               ");
                $cap=$this->num_estudiantes_capellan($dt['desde'],$dt['hasta']);

                $vl=1;

            }elseif ($dt['tipo']=='1') {
                $reporte=DB::select("select cp.usu_apellidos ||' '|| cp.name as capellan,
                    dc.usu_apellidos ||' '|| dc.name as docente, sg.fecha 
                    from seguimiento_semanal_docente sg 
                    join users cp on sg.cap_id=cp.id
                    join users dc on sg.doc_id=dc.id
                    WHERE sg.fecha between '$dt[desde]' and '$dt[hasta]'

                    ");
               $cap=$this->num_docentes_capellan($dt['desde'],$dt['hasta']);
                $vl=2;

            }elseif ($dt['tipo']=='2') {
                $reporte=DB::select("select *, u.usu_apellidos ||' '|| u.name as capellan, e.est_apellidos ||' '|| e.est_nombres as estudiante, vh.fecha as f_asist from visita_hogares vh 
                    join matriculas m on vh.mat_id=m.id
                    join estudiantes e on m.est_id=e.id
                    join users u on vh.usu_id=u.id
                    join cursos c on m.cur_id=c.id
                    join jornadas j on m.jor_id=j.id
                    where vh.fecha between '$dt[desde]' and '$dt[hasta]'
                    and vh.estado=0
                    order by u.usu_apellidos 

                    ");
               $cap=$this->num_visitas($dt['desde'],$dt['hasta']);
                $vl=3;
            }


            if($dt['op']==0){

                return view('seg_semanal_docentes.index')
                ->with('reporte',$reporte)
                ->with('cap',$cap)
                ->with('vl',$vl);

            }elseif($dt['op']==1){
                return view('seg_semanal_docentes.reporte_visita_estudiantes')
                ->with('reporte',$reporte)
                ->with('desde',$dt['desde'])
                ->with('hasta',$dt['hasta'])
                ->with('cap',$cap)
                ->with('vl',$vl);
            }

        }
                return view('seg_semanal_docentes.index')
                ->with('reporte',$reporte)
                ->with('cap',$cap)
                ->with('vl',0)
                ;


    }



public function num_estudiantes_capellan($fi,$ff){

    return DB::select("
                select u.usu_apellidos,u.name,count(*) from seguimiento_capellania sc 
                join matriculas m on sc.mat_id=m.id
                join estudiantes e on m.est_id=e.id
                join users u on sc.usu_id=u.id
                join cursos c on m.cur_id=c.id
                join jornadas j on m.jor_id=j.id
                where sc.fecha between '$fi' and '$ff'
                and sc.estado=0
                group by u.usu_apellidos,u.name
        ");

}

public function num_docentes_capellan($fi,$ff){

    return DB::select("
                select cp.usu_apellidos ||' '|| cp.name as capellan, count(*)
                from seguimiento_semanal_docente sg 
                join users cp on sg.cap_id=cp.id
                join users dc on sg.doc_id=dc.id
                WHERE sg.fecha between '$fi' and '$ff'
                group by capellan
        ");

}
public function num_visitas($fi,$ff){

    return DB::select("
                select u.usu_apellidos ||' '|| u.name as capellan,count(*) from visita_hogares vh 
                join matriculas m on vh.mat_id=m.id
                join estudiantes e on m.est_id=e.id
                join users u on vh.usu_id=u.id
                where vh.fecha between '$fi' and '$ff'
                and vh.estado=0
                group by capellan
        ");

}


    public function create()
    {
        return view('seg_semanal_docentes.create');
    }

    /**
     * Store a newly created SegSemanalDocente in storage.
     *
     * @param CreateSegSemanalDocenteRequest $request
     *
     * @return Response
     */
    public function store(CreateSegSemanalDocenteRequest $request)
    {
        $input = $request->all();
        $docid=$input['doc_id'];
        $segSemanalDocente = $this->segSemanalDocenteRepository->create($input);
        return redirect(route('segSemanalDocentes.show',$docid));
    }

    /**
     * Display the specified SegSemanalDocente.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($docid)
    {
        $user= DB::select("select * from users where id=".$docid);
        $segSemanalDocentes =DB::select('select * from seguimiento_semanal_docente where doc_id='.$docid);
        return view('seg_semanal_docentes.show')
        ->with("user",$user)
        ->with("segSemanalDocentes",$segSemanalDocentes)
        ;
    }

    /**
     * Show the form for editing the specified SegSemanalDocente.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $segSemanalDocente = $this->segSemanalDocenteRepository->findWithoutFail($id);

        if (empty($segSemanalDocente)) {
            Flash::error('Seg Semanal Docente not found');

            return redirect(route('segSemanalDocentes.index'));
        }

        return view('seg_semanal_docentes.edit')->with('segSemanalDocente', $segSemanalDocente);
    }

    /**
     * Update the specified SegSemanalDocente in storage.
     *
     * @param  int              $id
     * @param UpdateSegSemanalDocenteRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSegSemanalDocenteRequest $request)
    {
        $segSemanalDocente = $this->segSemanalDocenteRepository->findWithoutFail($id);

        if (empty($segSemanalDocente)) {
            Flash::error('Seg Semanal Docente not found');

            return redirect(route('segSemanalDocentes.index'));
        }

        $segSemanalDocente = $this->segSemanalDocenteRepository->update($request->all(), $id);

        Flash::success('Seg Semanal Docente updated successfully.');

        return redirect(route('segSemanalDocentes.index'));
    }

    /**
     * Remove the specified SegSemanalDocente from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $segSemanalDocente = $this->segSemanalDocenteRepository->findWithoutFail($id);
        //dd($segSemanalDocente);
        $docid=$segSemanalDocente->doc_id;
        $this->segSemanalDocenteRepository->delete($id);

        return redirect(route('segSemanalDocentes.show',[$docid]));
    }
}
