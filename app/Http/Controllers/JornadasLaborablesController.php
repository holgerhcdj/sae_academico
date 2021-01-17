<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJornadasLaborablesRequest;
use App\Http\Requests\UpdateJornadasLaborablesRequest;
use App\Repositories\JornadasLaborablesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Usuarios;
use Response;
use Illuminate\Support\Facades\DB;

class JornadasLaborablesController extends AppBaseController
{
    /** @var  JornadasLaborablesRepository */
    private $jornadasLaborablesRepository;

    public function __construct(JornadasLaborablesRepository $jornadasLaborablesRepo)
    {
        $this->jornadasLaborablesRepository = $jornadasLaborablesRepo;
    }

    /**
     * Display a listing of the JornadasLaborables.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->jornadasLaborablesRepository->pushCriteria(new RequestCriteria($request));
        $jornadasLaborables = $this->jornadasLaborablesRepository->all();

        return view('jornadas_laborables.index')
            ->with('jornadasLaborables', $jornadasLaborables);
    }

    /**
     * Show the form for creating a new JornadasLaborables.
     *
     * @return Response
     */
    public function create()
    {
        return view('jornadas_laborables.create');
    }

    /**
     * Store a newly created JornadasLaborables in storage.
     *
     * @param CreateJornadasLaborablesRequest $request
     *
     * @return Response
     */
    public function store(CreateJornadasLaborablesRequest $request)
    {
        $input = $request->all();
        isset($input['jrl_lun'])=='on'?$input['jrl_lun']=1:$input['jrl_lun']=0;
        isset($input['jrl_mar'])=='on'?$input['jrl_mar']=1:$input['jrl_mar']=0;
        isset($input['jrl_mie'])=='on'?$input['jrl_mie']=1:$input['jrl_mie']=0;
        isset($input['jrl_jue'])=='on'?$input['jrl_jue']=1:$input['jrl_jue']=0;
        isset($input['jrl_vie'])=='on'?$input['jrl_vie']=1:$input['jrl_vie']=0;
        isset($input['jrl_sab'])=='on'?$input['jrl_sab']=1:$input['jrl_sab']=0;
        isset($input['jrl_dom'])=='on'?$input['jrl_dom']=1:$input['jrl_dom']=0;

        $jornadasLaborables = $this->jornadasLaborablesRepository->create($input);

        Flash::success('Jornadas Laborables saved successfully.');

        return redirect(route('jornadasLaborables.index'));
    }

    /**
     * Display the specified JornadasLaborables.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        //dd($id);

        $jornadasLaborables = $this->jornadasLaborablesRepository->findWithoutFail($id);
        $usuarios = Usuarios::where('usu_estado', 0)->get()->pluck('full_name', 'id');
        $asg_jor=DB::select("SELECT * FROM asigna_jornadas_laborables ajl JOIN users u ON ajl.asg_jrl_usuid=u.id 
            where asg_jrl_jor=$id
            order by u.usu_apellidos

            ");
        return view('jornadas_laborables.show')
        ->with('jornadasLaborables', $jornadasLaborables)
        ->with('usuarios',$usuarios)
        ->with('asg_jor',$asg_jor)
        ;
    }

    /**
     * Show the form for editing the specified JornadasLaborables.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $jornadasLaborables = $this->jornadasLaborablesRepository->findWithoutFail($id);

        if (empty($jornadasLaborables)) {
            Flash::error('Jornadas Laborables not found');

            return redirect(route('jornadasLaborables.index'));
        }

        return view('jornadas_laborables.edit')->with('jornadasLaborables', $jornadasLaborables);
    }

    /**
     * Update the specified JornadasLaborables in storage.
     *
     * @param  int              $id
     * @param UpdateJornadasLaborablesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateJornadasLaborablesRequest $request)
    {
        $input=$request->all();
        $jornadasLaborables = $this->jornadasLaborablesRepository->findWithoutFail($id);

        isset($input['jrl_lun'])=='on'?$input['jrl_lun']=1:$input['jrl_lun']=0;
        isset($input['jrl_mar'])=='on'?$input['jrl_mar']=1:$input['jrl_mar']=0;
        isset($input['jrl_mie'])=='on'?$input['jrl_mie']=1:$input['jrl_mie']=0;
        isset($input['jrl_jue'])=='on'?$input['jrl_jue']=1:$input['jrl_jue']=0;
        isset($input['jrl_vie'])=='on'?$input['jrl_vie']=1:$input['jrl_vie']=0;
        isset($input['jrl_sab'])=='on'?$input['jrl_sab']=1:$input['jrl_sab']=0;
        isset($input['jrl_dom'])=='on'?$input['jrl_dom']=1:$input['jrl_dom']=0;

        $jornadasLaborables = $this->jornadasLaborablesRepository->update($input, $id);
        Flash::success('Jornadas Laborables updated successfully.');
        return redirect(route('jornadasLaborables.index'));
    }

    /**
     * Remove the specified JornadasLaborables from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy(Request $req)
    {

        $id=$req->all()['asg_jrl_id'];
        $asg_jor=DB::select("select * from asigna_jornadas_laborables where asg_jrl_id=".$id);
        DB::select("delete from asigna_jornadas_laborables where asg_jrl_id=".$id);
        return redirect(route('jornadasLaborables.show',$asg_jor[0]->asg_jrl_jor ));
    }



    // public function elimina(){
    //     dd('ok');
    // }

}
