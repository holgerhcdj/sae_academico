<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEvaluacionPreguntasRequest;
use App\Http\Requests\UpdateEvaluacionPreguntasRequest;
use App\Repositories\EvaluacionPreguntasRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class EvaluacionPreguntasController extends AppBaseController
{
    /** @var  EvaluacionPreguntasRepository */
    private $evaluacionPreguntasRepository;

    public function __construct(EvaluacionPreguntasRepository $evaluacionPreguntasRepo)
    {
        $this->evaluacionPreguntasRepository = $evaluacionPreguntasRepo;
    }

    /**
     * Display a listing of the EvaluacionPreguntas.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->evaluacionPreguntasRepository->pushCriteria(new RequestCriteria($request));
        $evaluacionPreguntas = $this->evaluacionPreguntasRepository->all();

        return view('evaluacion_preguntas.index')
            ->with('evaluacionPreguntas', $evaluacionPreguntas);
    }

    /**
     * Show the form for creating a new EvaluacionPreguntas.
     *
     * @return Response
     */
    public function create()
    {
        return view('evaluacion_preguntas.create');
    }

    /**
     * Store a newly created EvaluacionPreguntas in storage.
     *
     * @param CreateEvaluacionPreguntasRequest $request
     *
     * @return Response
     */
    public function store(CreateEvaluacionPreguntasRequest $request)
    {
        $input = $request->all();

        $evaluacionPreguntas = $this->evaluacionPreguntasRepository->create($input);

        Flash::success('Evaluacion Preguntas saved successfully.');

        return redirect(route('evaluacionPreguntas.index'));
    }

    /**
     * Display the specified EvaluacionPreguntas.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $evaluacionPreguntas = $this->evaluacionPreguntasRepository->findWithoutFail($id);

        if (empty($evaluacionPreguntas)) {
            Flash::error('Evaluacion Preguntas not found');

            return redirect(route('evaluacionPreguntas.index'));
        }

        return view('evaluacion_preguntas.show')->with('evaluacionPreguntas', $evaluacionPreguntas);
    }

    /**
     * Show the form for editing the specified EvaluacionPreguntas.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $evaluacionPreguntas = $this->evaluacionPreguntasRepository->findWithoutFail($id);

        if (empty($evaluacionPreguntas)) {
            Flash::error('Evaluacion Preguntas not found');

            return redirect(route('evaluacionPreguntas.index'));
        }

        return view('evaluacion_preguntas.edit')->with('evaluacionPreguntas', $evaluacionPreguntas);
    }

    /**
     * Update the specified EvaluacionPreguntas in storage.
     *
     * @param  int              $id
     * @param UpdateEvaluacionPreguntasRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEvaluacionPreguntasRequest $request)
    {
        $evaluacionPreguntas = $this->evaluacionPreguntasRepository->findWithoutFail($id);

        if (empty($evaluacionPreguntas)) {
            Flash::error('Evaluacion Preguntas not found');

            return redirect(route('evaluacionPreguntas.index'));
        }

        $evaluacionPreguntas = $this->evaluacionPreguntasRepository->update($request->all(), $id);

        Flash::success('Evaluacion Preguntas updated successfully.');

        return redirect(route('evaluacionPreguntas.index'));
    }

    /**
     * Remove the specified EvaluacionPreguntas from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $evaluacionPreguntas = $this->evaluacionPreguntasRepository->findWithoutFail($id);

        if (empty($evaluacionPreguntas)) {
            Flash::error('Evaluacion Preguntas not found');

            return redirect(route('evaluacionPreguntas.index'));
        }

        $this->evaluacionPreguntasRepository->delete($id);

        Flash::success('Evaluacion Preguntas deleted successfully.');

        return redirect(route('evaluacionPreguntas.index'));
    }
}
