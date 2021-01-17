<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRegDisciplinaRequest;
use App\Http\Requests\UpdateRegDisciplinaRequest;
use App\Repositories\RegDisciplinaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Jornadas;
use App\Models\Cursos;
use App\Models\Especialidades;
use App\Models\Materias;
use App\Models\Auditoria;
use App\Models\AnioLectivo;
use Session;


class RegDisciplinaController extends AppBaseController
{
    /** @var  RegDisciplinaRepository */
    private $regDisciplinaRepository;
    private $anl;
    private $anl_bgu;
    public function __construct(RegDisciplinaRepository $regDisciplinaRepo)
    {
        $this->regDisciplinaRepository = $regDisciplinaRepo;
        $this->anl = Session::get('anl_id');
        $this->anl_bgu = Session::get('periodo_id');
    }

    /**
     * Display a listing of the RegDisciplina.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $dt=$request->all();
        $jor=Jornadas::orderBy('id','ASC')->pluck('jor_descripcion','id');
        $esp=Especialidades::where('id',10)
        ->orWhere('id',7)
        ->orWhere('id',8)
        ->orderBy('esp_descripcion','DESC')->pluck('esp_descripcion','id');
        $cur=Cursos::pluck('cur_descripcion','id');

        $regDisciplinas = [];
        return view('reg_disciplinas.index')
            ->with('regDisciplinas', $regDisciplinas)
            ->with('jor', $jor)
            ->with('esp', $esp)
            ->with('cur', $cur)
            ;
    }

    /**
     * Show the form for creating a new RegDisciplina.
     *
     * @return Response
     */
    public function create(Request $req)
    {
        $dt=$req->all();
        $result='';
        
        if(isset($dt['btn_buscar'])){
            $audt=new Auditoria();
            $anl=$this->anl;
             $jor=$dt['jor_id'];
             $esp=$dt['esp_id'];
             $p=$dt['parcial'];
             if($esp==7){
                $anl=$this->anl_bgu;
             }
             if($esp==10){
                $esp=0;
             }
             $cur=$dt['cur_id'];
             $par=$dt['paralelo'];
             $estado=1;
             $est=$audt->buscador_estudiantes([$anl,$jor,$esp,$cur,$par,$estado]);
             $result="";
             $x=0;
             foreach ($est as $e) {

//***************BUSCO COMPORTAMIENTO**************/////////////
                    $disciplina=DB::select("SELECT * FROM reg_disciplina WHERE mat_id=$e->mat_id AND mtr_id=3 AND dsc_parcial=$p AND dsc_tipo=0 ");
                    $dsc_id=0;
                    $dsa="";$dsb="";$dsc="";$dsd="";
                    if(!empty($disciplina)){
                        $dsc_id=$disciplina[0]->dsc_id;
                        switch ($disciplina[0]->dsc_nota) {
                            case 'A': $dsa="selected";$dsb="";$dsc="";$dsd="";  break;
                            case 'B': $dsa="";$dsb="selected";$dsc="";$dsd="";  break;
                            case 'C': $dsa="";$dsb="";$dsc="selected";$dsd="";  break;
                            case 'D': $dsa="";$dsb="";$dsc="";$dsd="selected";  break;
                        }
                    }
///////////////**********************/////////////////////////

                $x++;
                $result.="<tr>
                    <td>$x</td>
                    <td>$e->est_apellidos  $e->est_nombres</td>
                    <td>
                        <select name='dsc_nota' class='form-control tx_comprtamiento' mat_id='$e->mat_id' dsc_id='$dsc_id' >
                            <option value='0'></option>
                            <option $dsa value='A'>A</option>
                            <option $dsb value='B'>B</option>
                            <option $dsc value='C'>C</option>
                            <option $dsd value='D'>D</option>
                            option
                        </select>
                    </td>

                </tr>";
             }

        }else{
            $p=$dt['p'];
        }
        $jornada=Jornadas::orderBy('id','ASC')->pluck('jor_descripcion','id');
        $especialidad=Especialidades::where('id',10)
        ->orWhere('id',7)
        ->orWhere('id',8)
        ->orderBy('esp_descripcion','DESC')->pluck('esp_descripcion','id');
        $curso=Cursos::pluck('cur_descripcion','id');
        return view('reg_disciplinas.create')
        ->with('jor',$jornada)
        ->with('cur',$curso)
        ->with('esp',$especialidad)
        ->with('result',$result)
        ->with('p',$p)
        ;
    }


    public function store(CreateRegDisciplinaRequest $request)
    {
        $input = $request->all();

        $regDisciplina = $this->regDisciplinaRepository->create($input);

        Flash::success('Reg Disciplina saved successfully.');

        return redirect(route('regDisciplinas.index'));
    }

    /**
     * Display the specified RegDisciplina.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $regDisciplina = $this->regDisciplinaRepository->findWithoutFail($id);

        if (empty($regDisciplina)) {
            Flash::error('Reg Disciplina not found');

            return redirect(route('regDisciplinas.index'));
        }

        return view('reg_disciplinas.show')->with('regDisciplina', $regDisciplina);
    }

    /**
     * Show the form for editing the specified RegDisciplina.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $regDisciplina = $this->regDisciplinaRepository->findWithoutFail($id);

        if (empty($regDisciplina)) {
            Flash::error('Reg Disciplina not found');

            return redirect(route('regDisciplinas.index'));
        }

        return view('reg_disciplinas.edit')->with('regDisciplina', $regDisciplina);
    }

    /**
     * Update the specified RegDisciplina in storage.
     *
     * @param  int              $id
     * @param UpdateRegDisciplinaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRegDisciplinaRequest $request)
    {
        $regDisciplina = $this->regDisciplinaRepository->findWithoutFail($id);

        if (empty($regDisciplina)) {
            Flash::error('Reg Disciplina not found');

            return redirect(route('regDisciplinas.index'));
        }

        $regDisciplina = $this->regDisciplinaRepository->update($request->all(), $id);

        Flash::success('Reg Disciplina updated successfully.');

        return redirect(route('regDisciplinas.index'));
    }

    /**
     * Remove the specified RegDisciplina from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $regDisciplina = $this->regDisciplinaRepository->findWithoutFail($id);

        if (empty($regDisciplina)) {
            Flash::error('Reg Disciplina not found');

            return redirect(route('regDisciplinas.index'));
        }

        $this->regDisciplinaRepository->delete($id);

        Flash::success('Reg Disciplina deleted successfully.');

        return redirect(route('regDisciplinas.index'));
    }
}
