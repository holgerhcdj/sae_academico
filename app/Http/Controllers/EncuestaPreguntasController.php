<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEncuestaPreguntasRequest;
use App\Http\Requests\UpdateEncuestaPreguntasRequest;
use App\Repositories\EncuestaPreguntasRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class EncuestaPreguntasController extends AppBaseController
{
    /** @var  EncuestaPreguntasRepository */
    private $encuestaPreguntasRepository;

    public function __construct(EncuestaPreguntasRepository $encuestaPreguntasRepo)
    {
        $this->encuestaPreguntasRepository = $encuestaPreguntasRepo;
    }

    /**
     * Display a listing of the EncuestaPreguntas.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->encuestaPreguntasRepository->pushCriteria(new RequestCriteria($request));
        $encuestaPreguntas = $this->encuestaPreguntasRepository->all();

        return view('encuesta_preguntas.index')
            ->with('encuestaPreguntas', $encuestaPreguntas);
    }

    /**
     * Show the form for creating a new EncuestaPreguntas.
     *
     * @return Response
     */
    public function create()
    {
        return view('encuesta_preguntas.create');
    }

    /**
     * Store a newly created EncuestaPreguntas in storage.
     *
     * @param CreateEncuestaPreguntasRequest $request
     *
     * @return Response
     */
    public function store(CreateEncuestaPreguntasRequest $request)
    {
        $input = $request->all();

        $encuestaPreguntas = $this->encuestaPreguntasRepository->create($input);

        Flash::success('Encuesta Preguntas saved successfully.');

        return redirect(route('encuestaPreguntas.index'));
    }

    /**
     * Display the specified EncuestaPreguntas.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $encuestaPreguntas = $this->encuestaPreguntasRepository->findWithoutFail($id);

        if (empty($encuestaPreguntas)) {
            Flash::error('Encuesta Preguntas not found');

            return redirect(route('encuestaPreguntas.index'));
        }

        return view('encuesta_preguntas.show')->with('encuestaPreguntas', $encuestaPreguntas);
    }

    /**
     * Show the form for editing the specified EncuestaPreguntas.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $encuestaPreguntas = $this->encuestaPreguntasRepository->findWithoutFail($id);

        if (empty($encuestaPreguntas)) {
            Flash::error('Encuesta Preguntas not found');

            return redirect(route('encuestaPreguntas.index'));
        }

        return view('encuesta_preguntas.edit')->with('encuestaPreguntas', $encuestaPreguntas);
    }

    /**
     * Update the specified EncuestaPreguntas in storage.
     *
     * @param  int              $id
     * @param UpdateEncuestaPreguntasRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEncuestaPreguntasRequest $request)
    {
        $encuestaPreguntas = $this->encuestaPreguntasRepository->findWithoutFail($id);

        if (empty($encuestaPreguntas)) {
            Flash::error('Encuesta Preguntas not found');

            return redirect(route('encuestaPreguntas.index'));
        }

        $encuestaPreguntas = $this->encuestaPreguntasRepository->update($request->all(), $id);

        Flash::success('Encuesta Preguntas updated successfully.');

        return redirect(route('encuestaPreguntas.index'));
    }

    /**
     * Remove the specified EncuestaPreguntas from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $encuestaPreguntas = $this->encuestaPreguntasRepository->findWithoutFail($id);

        if (empty($encuestaPreguntas)) {
            Flash::error('Encuesta Preguntas not found');

            return redirect(route('encuestaPreguntas.index'));
        }

        $this->encuestaPreguntasRepository->delete($id);

        Flash::success('Encuesta Preguntas deleted successfully.');

        return redirect(route('encuestaPreguntas.index'));
    }
}
