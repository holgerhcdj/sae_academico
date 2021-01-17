<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAsgJornadasLaborablesRequest;
use App\Http\Requests\UpdateAsgJornadasLaborablesRequest;
use App\Repositories\AsgJornadasLaborablesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\DB;

class AsgJornadasLaborablesController extends AppBaseController
{
    /** @var  AsgJornadasLaborablesRepository */
    private $asgJornadasLaborablesRepository;

    public function __construct(AsgJornadasLaborablesRepository $asgJornadasLaborablesRepo)
    {
        $this->asgJornadasLaborablesRepository = $asgJornadasLaborablesRepo;
    }

    /**
     * Display a listing of the AsgJornadasLaborables.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->asgJornadasLaborablesRepository->pushCriteria(new RequestCriteria($request));
        $asgJornadasLaborables = $this->asgJornadasLaborablesRepository->all();

        return view('asg_jornadas_laborables.index')
            ->with('asgJornadasLaborables', $asgJornadasLaborables);
    }

    /**
     * Show the form for creating a new AsgJornadasLaborables.
     *
     * @return Response
     */
    public function create()
    {
        return view('asg_jornadas_laborables.create');
    }

    /**
     * Store a newly created AsgJornadasLaborables in storage.
     *
     * @param CreateAsgJornadasLaborablesRequest $request
     *
     * @return Response
     */
    public function store(CreateAsgJornadasLaborablesRequest $request)
    {
        $input = $request->all();

        $input['asg_jrl_usuid']=$input['usuarios'];
        $input['asg_jrl_anl']=2;
        $input['asg_jrl_jor']=$input['jrl_id'];
        // $input['asg_jrl_desde']=$input['jrl_desde'];
        // $input['asg_jrl_hasta']=$input['jrl_hasta'];

        $input['asg_jrl_obs']=null;
        $input['asg_jrl_estado']=0;
        isset($input['asg_jrl_lun'])=='on'?$input['asg_jrl_lun']=1:$input['asg_jrl_lun']=0;
        isset($input['asg_jrl_mar'])=='on'?$input['asg_jrl_mar']=1:$input['asg_jrl_mar']=0;
        isset($input['asg_jrl_mie'])=='on'?$input['asg_jrl_mie']=1:$input['asg_jrl_mie']=0;
        isset($input['asg_jrl_jue'])=='on'?$input['asg_jrl_jue']=1:$input['asg_jrl_jue']=0;
        isset($input['asg_jrl_vie'])=='on'?$input['asg_jrl_vie']=1:$input['asg_jrl_vie']=0;
        isset($input['asg_jrl_sab'])=='on'?$input['asg_jrl_sab']=1:$input['asg_jrl_sab']=0;
        isset($input['asg_jrl_dom'])=='on'?$input['asg_jrl_dom']=1:$input['asg_jrl_dom']=0;

        isset($input['asg_jrl_alm'])=='on'?$input['asg_jrl_alm']=1:$input['asg_jrl_alm']=0;

        $asgJornadasLaborables = $this->asgJornadasLaborablesRepository->create($input);
        // Flash::success('Asg Jornadas Laborables saved successfully.');
        return redirect(route('jornadasLaborables.show',$input['asg_jrl_jor']));
    }

    /**
     * Display the specified AsgJornadasLaborables.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $asgJornadasLaborables = $this->asgJornadasLaborablesRepository->findWithoutFail($id);
        return view('asg_jornadas_laborables.show')->with('asgJornadasLaborables', $asgJornadasLaborables);
    }

    /**
     * Show the form for editing the specified AsgJornadasLaborables.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $asgJornadasLaborables = $this->asgJornadasLaborablesRepository->findWithoutFail($id);

        if (empty($asgJornadasLaborables)) {
            Flash::error('Asg Jornadas Laborables not found');

            return redirect(route('asgJornadasLaborables.index'));
        }

        return view('asg_jornadas_laborables.edit')->with('asgJornadasLaborables', $asgJornadasLaborables);
    }

    /**
     * Update the specified AsgJornadasLaborables in storage.
     *
     * @param  int              $id
     * @param UpdateAsgJornadasLaborablesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAsgJornadasLaborablesRequest $request)
    {
        $asgJornadasLaborables = $this->asgJornadasLaborablesRepository->findWithoutFail($id);

        if (empty($asgJornadasLaborables)) {
            Flash::error('Asg Jornadas Laborables not found');

            return redirect(route('asgJornadasLaborables.index'));
        }
        $asgJornadasLaborables = $this->asgJornadasLaborablesRepository->update($request->all(), $id);
        Flash::success('Asg Jornadas Laborables updated successfully.');
        return redirect(route('asgJornadasLaborables.index'));
    }

    /**
     * Remove the specified AsgJornadasLaborables from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        dd($id);
        $asgJornadasLaborables = $this->asgJornadasLaborablesRepository->findWithoutFail($id);
        if (empty($asgJornadasLaborables)) {
            Flash::error('Asg Jornadas Laborables not found');
            return redirect(route('asgJornadasLaborables.index'));
        }
        $this->asgJornadasLaborablesRepository->delete($id);
        Flash::success('Asg Jornadas Laborables deleted successfully.');
        return redirect(route('asgJornadasLaborables.index'));
    }
}
