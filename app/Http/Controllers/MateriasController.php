<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMateriasRequest;
use App\Http\Requests\UpdateMateriasRequest;
use App\Repositories\MateriasRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Materias;
use App\Models\AnioLectivo;
use Illuminate\Support\Facades\DB;
use Session;
use App\Models\Auditoria;

class MateriasController extends AppBaseController {

    /** @var  MateriasRepository */
    private $materiasRepository;
    private $anl;

    public function __construct(MateriasRepository $materiasRepo) {
        $this->materiasRepository = $materiasRepo;
        // $anl_select = AnioLectivo::where('anl_selected', '=', 1)->get();
        // return $this->anl=$anl_select[0]->id;

    }

    // public function anl_actual(){
    // }

    /**
     * Display a listing of the Materias.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) {
        
        $cursos=DB::select("select * from cursos");
        return view('materias.index')->with('cursos', $cursos);        


    }
    
        public function buscar(Request $request) {
        $datos = $request->all();
        //print_r($datos);
        $materias = Materias::where('mtr_tipo',$datos['tipo'])->get();
        return view('materias.index')
                        ->with('materias', $materias)
        ;
    }


    /**
     * Show the form for creating a new Materias.
     *
     * @return Response
     */
    public function create() {
        //$anl_select = AnioLectivo::where('anl_selected', '=', 1)->get();

        $this->anl=Session::get('anl_id');
        $anl_select = AnioLectivo::where('id', '=', $this->anl)->get();
        return view('materias.create')->with('anl_select',$anl_select);
    }

    /**
     * Store a newly created Materias in storage.
     *
     * @param CreateMateriasRequest $request
     *
     * @return Response
     */
    public function store(CreateMateriasRequest $request) {
        $input = $request->all();
        $materias = $this->materiasRepository->create($input);
                 $aud= new Auditoria();
                 $data=["mod"=>"Materias","acc"=>"Insertar","dat"=>$materias,"doc"=>"NA"];
                 $aud->save_adt($data);                    

        Flash::success('Materias saved successfully.');

        return redirect(route('materias.index'));
    }

    /**
     * Display the specified Materias.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(Request $request) {

        $this->anl=Session::get('anl_id');


        $req=$request->all();
        $curso=DB::select("select * from cursos where id=$req[cur_id]");
        $mtr_asg=DB::select("select *,ac.id as ac_id from asg_materias_cursos ac, materias m where ac.mtr_id=m.id and  ac.anl_id=$this->anl and ac.esp_id=10 and ac.cur_id=$req[cur_id] ");
        $materias=DB::select("select * from materias
                                where not exists(
                                select * from asg_materias_cursos where 
                                 anl_id=$this->anl 
                                  and suc_id=1
                                  and jor_id=1
                                  and esp_id=10
                                  and cur_id=$req[cur_id]
                                  and materias.id=mtr_id
                                  )
                                  and materias.id<>1
                                  and materias.id<>3
                                  and materias.mtr_tipo=0  
                                  order by mtr_descripcion");

        return view('materias.show')
        ->with('curso', $curso)
        ->with('materias', $materias)
        ->with('mtr_asg', $mtr_asg)
        ;
    }

    public function actualizar($dt){
        $dat=explode("&",$dt);
        $materias=Materias::find($dat[0]);
        $materias->mtr_descripcion=$dat[1];

        //var data=$("#mtrid").val()+"&"+$("#mtrdesc").val()+"&"+$("#mtrhoras").val()+"&"+$("#mtrbloq").val()+"&"+$("#asg_id").val();

        if($materias->save()){
            DB::select("update asg_materias_cursos set horas=$dat[2],bloques=$dat[3],estado=$dat[5] where id=$dat[4]");
                 $aud= new Auditoria();
                 $data=["mod"=>"Materias","acc"=>"Modificar","dat"=>$materias,"doc"=>"NA"];
                 $aud->save_adt($data);                    

            return 0;
        }else{
            return 1;
        }


    }

    public function edit($id) {
        $materias = $this->materiasRepository->findWithoutFail($id);

        if (empty($materias)) {
            Flash::error('Materias not found');

            return redirect(route('materias.index'));
        }

        return view('materias.edit')->with('materias', $materias);
    }

    /**
     * Update the specified Materias in storage.
     *
     * @param  int              $id
     * @param UpdateMateriasRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMateriasRequest $request) {
        $materias = $this->materiasRepository->findWithoutFail($id);

        if (empty($materias)) {
            Flash::error('Materias not found');

            return redirect(route('materias.index'));
        }

        $materias = $this->materiasRepository->update($request->all(), $id);
                 $aud= new Auditoria();
                 $data=["mod"=>"Materias","acc"=>"Update","dat"=>$materias,"doc"=>"NA"];
                 $aud->save_adt($data);                    

        Flash::success('Materias updated successfully.');

        return redirect(route('materias.index'));
    }

    /**
     * Remove the specified Materias from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id) {
        $materias = $this->materiasRepository->findWithoutFail($id);

        if (empty($materias)) {
            Flash::error('Materias not found');

            return redirect(route('materias.index'));
        }

        $this->materiasRepository->delete($id);
                 $aud= new Auditoria();
                 $data=["mod"=>"Materias","acc"=>"Eliminar","dat"=>$materias,"doc"=>"NA"];
                 $aud->save_adt($data);                    

        Flash::success('Materias deleted successfully.');

        return redirect(route('materias.index'));
    }

}
