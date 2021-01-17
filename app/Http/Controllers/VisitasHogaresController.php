<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVisitasHogaresRequest;
use App\Http\Requests\UpdateVisitasHogaresRequest;
use App\Repositories\VisitasHogaresRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Estudiantes;
use App\Models\Matriculas;
use DB;
use Session;

class VisitasHogaresController extends AppBaseController
{
    /** @var  VisitasHogaresRepository */
    private $visitasHogaresRepository;

    public function __construct(VisitasHogaresRepository $visitasHogaresRepo)
    {
        $this->visitasHogaresRepository = $visitasHogaresRepo;
    }

    /**
     * Display a listing of the VisitasHogares.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $visitasHogares = [];

        return view('visitas_hogares.index')
            ->with('visitasHogares', $visitasHogares);
    }

    /**
     * Show the form for creating a new VisitasHogares.
     *
     * @return Response
     */
    public function create()
    {
        $anl = Session::get('anl_id');

        $estudiantes = Estudiantes::
        join('matriculas', 'matriculas.est_id', '=', 'estudiantes.id')
        ->where('matriculas.anl_id', '=', $anl)
        ->where('matriculas.mat_estado', '=', 1)
        ->select('estudiantes.est_apellidos','estudiantes.est_nombres','matriculas.id')
        ->orderBy('estudiantes.est_apellidos')
        ->get()->pluck('full_name', 'id');

        $estudiantes->put('0','Elija un Estudiante');


        return view('visitas_hogares.create')
        ->with('estudiantes', $estudiantes);
    }

    /**
     * Store a newly created VisitasHogares in storage.
     *
     * @param CreateVisitasHogaresRequest $request
     *
     * @return Response
     */
    public function store(CreateVisitasHogaresRequest $request)
    {
        $input = $request->all();
        $file_route = '';
        // if ($request->hasfile('img_casa')) {
        //     $img = $request->file('img_casa');
        //     $file_route = 'Prueba.' . $img->getClientOriginalExtension();
        //     Storage::disk('img_visitas')->put($file_route, file_get_contents($img->getRealPath()));
        // }


        $visitasHogares = $this->visitasHogaresRepository->create($input);
        Flash::success('Visitas Hogares saved successfully.');
        return redirect(route('visitasHogares.index'));
    }

    /**
     * Display the specified VisitasHogares.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $anl = Session::get('anl_id');

        $estudiantes = Estudiantes::
        join('matriculas', 'matriculas.est_id', '=', 'estudiantes.id')
        ->where('matriculas.anl_id', '=', $anl)
        ->where('matriculas.mat_estado', '=', 1)
        ->select('estudiantes.est_apellidos','estudiantes.est_nombres','matriculas.id')
        ->orderBy('estudiantes.est_apellidos')
        ->get()->pluck('full_name', 'id');

        $estudiantes2=DB::select(
                "select * from visita_hogares vh 
                join matriculas m on vh.mat_id=m.id
                join estudiantes e on m.est_id=e.id
                where vh.vstid=$id "
            );

        return view('visitas_hogares.show')
        ->with('visitasHogares', $estudiantes2[0])
        ->with('estudiantes', $estudiantes);

    }

    /**
     * Show the form for editing the specified VisitasHogares.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $visitasHogares = DB::select("select * from visita_hogares v 
            join matriculas m on v.mat_id=m.id
            join jornadas j on m.jor_id=j.id
            join especialidades e on m.esp_id=e.id
            join cursos c on m.cur_id=c.id
            join estudiantes es on m.est_id=es.id
            where v.vstid=$id");
        $anl = Session::get('anl_id');

        $estudiantes = Estudiantes::
        join('matriculas', 'matriculas.est_id', '=', 'estudiantes.id')
        ->where('matriculas.anl_id', '=', $anl)
        ->where('matriculas.mat_estado', '=', 1)
        ->select('estudiantes.est_apellidos','estudiantes.est_nombres','matriculas.id')
        ->orderBy('estudiantes.est_apellidos')
        ->get()->pluck('full_name', 'id');

        return view('visitas_hogares.edit')
        ->with('visitasHogares', $visitasHogares[0])
        ->with('estudiantes', $estudiantes);
    }

    /**
     * Update the specified VisitasHogares in storage.
     *
     * @param  int              $id
     * @param UpdateVisitasHogaresRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVisitasHogaresRequest $request)
    {
        $visitasHogares = $this->visitasHogaresRepository->findWithoutFail($id);
         $file_route = '';
         $data=$request->all();


         if($request->file('img_casa')){
             $file = $request->file('img_casa');
             //$name=time().$file->getClientOriginalName();
             $name=time().'.'.$file->getClientOriginalExtension();
             $file->move(public_path().'/img_visitas/',$name);
         }
         $data['img_casa']=$name;
         $visitasHogares = $this->visitasHogaresRepository->update($data, $id);
         Flash::success('Visitas Hogares updated successfully.');
         return redirect(route('visitasHogares.index'));
    }

    /**
     * Remove the specified VisitasHogares from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $visitasHogares = $this->visitasHogaresRepository->findWithoutFail($id);

        if (empty($visitasHogares)) {
            Flash::error('Visitas Hogares not found');

            return redirect(route('visitasHogares.index'));
        }

        $this->visitasHogaresRepository->delete($id);

        Flash::success('Visitas Hogares deleted successfully.');

        return redirect(route('visitasHogares.index'));
    }

    public function busqueda(Request $datos){
        $a=$datos->all();
        $anl = Session::get('anl_id');
        //dd($a);
        if($datos->ajax()){
            $est=DB::select("SELECT *,m.id as mtr_id FROM estudiantes e
                JOIN matriculas m ON e.id=m.est_id 
                JOIN jornadas j ON j.id=m.jor_id 
                JOIN especialidades es ON es.id=m.esp_id 
                JOIN cursos c ON c.id=m.cur_id 
                WHERE e.est_apellidos 
                LIKE '%".strtoupper($a['est'])."%' 
                AND m.mat_estado=1
                AND m.anl_id=".$anl."

            ");
            $resp="";
            $x=0;
            foreach ($est as $e) {
                $x++;
                $mtr=$e->jor_descripcion." / ".$e->esp_descripcion." / ".$e->cur_descripcion." / ".$e->mat_paralelo;
                $resp.="<tr>
                            <td>$x</td>
                            <td class='es_nombres' >$e->est_apellidos $e->est_nombres</td>
                            <td class='es_jornadas' >$mtr</td>
                            <td><i class='btn btn-primary fa fa-check btn_select'   data='$e->mtr_id'  data-dismiss='modal'  ></i></td>
                       </tr>";
            }

            return response()->json($resp);

        }else{

            if(!empty($a['estudiantes'])){
                $estudiantes2=DB::select(
                    "select * from visita_hogares vh 
                    join matriculas m on vh.mat_id=m.id
                    join estudiantes e on m.est_id=e.id
                    where e.est_apellidos like '%".strtoupper($a['estudiantes'])."%' "
                );
            }else{

                if ($a['tvisita']=='') {
                    $txt="";
                }else{
                    $txt="and vh.tipo=".$a['tvisita'];
                }

                $estudiantes2=DB::select(
                    "select * from visita_hogares vh 
                    join matriculas m on vh.mat_id=m.id
                    join estudiantes e on m.est_id=e.id
                    where vh.fecha between '".$a['desde']."' and '".$a['hasta']."'
                    $txt
                    "
                );
            }
            return view('visitas_hogares.index')
            ->with('visitasHogares', $estudiantes2);
        }
    }

public function buscar_visita_hogares(Request $req){
    $dat=$req->all();
    $visita=DB::select("select * from visita_hogares where mat_id=".$dat['matid']);

    return Response()->json((count($visita)+1));
}



}
