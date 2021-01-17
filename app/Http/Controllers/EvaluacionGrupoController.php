<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEvaluacionGrupoRequest;
use App\Http\Requests\UpdateEvaluacionGrupoRequest;
use App\Repositories\EvaluacionGrupoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class EvaluacionGrupoController extends AppBaseController
{
    /** @var  EvaluacionGrupoRepository */
    private $evaluacionGrupoRepository;

    public function __construct(EvaluacionGrupoRepository $evaluacionGrupoRepo)
    {
        $this->evaluacionGrupoRepository = $evaluacionGrupoRepo;
    }

    /**
     * Display a listing of the EvaluacionGrupo.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->evaluacionGrupoRepository->pushCriteria(new RequestCriteria($request));
        $evaluacionGrupos = $this->evaluacionGrupoRepository->all();

        return view('evaluacion_grupos.index')
            ->with('evaluacionGrupos', $evaluacionGrupos);
    }

    /**
     * Show the form for creating a new EvaluacionGrupo.
     *
     * @return Response
     */
    public function create()
    {
        return view('evaluacion_grupos.create');
    }

    /**
     * Store a newly created EvaluacionGrupo in storage.
     *
     * @param CreateEvaluacionGrupoRequest $request
     *
     * @return Response
     */
    public function store(CreateEvaluacionGrupoRequest $request)
    {
        $input = $request->all();

        $evaluacionGrupo = $this->evaluacionGrupoRepository->create($input);

        Flash::success('Evaluacion Grupo saved successfully.');

        return redirect(route('evaluacionGrupos.index'));
    }

    /**
     * Display the specified EvaluacionGrupo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $evaluacionGrupo = $this->evaluacionGrupoRepository->findWithoutFail($id);

        if (empty($evaluacionGrupo)) {
            Flash::error('Evaluacion Grupo not found');

            return redirect(route('evaluacionGrupos.index'));
        }

        return view('evaluacion_grupos.show')->with('evaluacionGrupo', $evaluacionGrupo);
    }

    /**
     * Show the form for editing the specified EvaluacionGrupo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $evaluacionGrupo = $this->evaluacionGrupoRepository->findWithoutFail($id);

        if (empty($evaluacionGrupo)) {
            Flash::error('Evaluacion Grupo not found');

            return redirect(route('evaluacionGrupos.index'));
        }

        return view('evaluacion_grupos.edit')->with('evaluacionGrupo', $evaluacionGrupo);
    }

    /**
     * Update the specified EvaluacionGrupo in storage.
     *
     * @param  int              $id
     * @param UpdateEvaluacionGrupoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEvaluacionGrupoRequest $request)
    {
        $evaluacionGrupo = $this->evaluacionGrupoRepository->findWithoutFail($id);

        if (empty($evaluacionGrupo)) {
            Flash::error('Evaluacion Grupo not found');

            return redirect(route('evaluacionGrupos.index'));
        }

        $evaluacionGrupo = $this->evaluacionGrupoRepository->update($request->all(), $id);

        Flash::success('Evaluacion Grupo updated successfully.');

        return redirect(route('evaluacionGrupos.index'));
    }

    /**
     * Remove the specified EvaluacionGrupo from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $evaluacionGrupo = $this->evaluacionGrupoRepository->findWithoutFail($id);

        if (empty($evaluacionGrupo)) {
            Flash::error('Evaluacion Grupo not found');

            return redirect(route('evaluacionGrupos.index'));
        }

        $this->evaluacionGrupoRepository->delete($id);

        Flash::success('Evaluacion Grupo deleted successfully.');

        return redirect(route('evaluacionGrupos.index'));
    }
}
