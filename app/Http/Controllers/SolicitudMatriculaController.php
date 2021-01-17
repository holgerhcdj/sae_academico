<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSolicitudMatriculaRequest;
use App\Http\Requests\UpdateSolicitudMatriculaRequest;
use App\Repositories\SolicitudMatriculaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class SolicitudMatriculaController extends AppBaseController
{
    /** @var  SolicitudMatriculaRepository */
    private $solicitudMatriculaRepository;

    public function __construct(SolicitudMatriculaRepository $solicitudMatriculaRepo)
    {
        $this->solicitudMatriculaRepository = $solicitudMatriculaRepo;
    }

    /**
     * Display a listing of the SolicitudMatricula.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->solicitudMatriculaRepository->pushCriteria(new RequestCriteria($request));
        $solicitudMatriculas = $this->solicitudMatriculaRepository->all();

        return view('solicitud_matriculas.index')
            ->with('solicitudMatriculas', $solicitudMatriculas);
    }

    /**
     * Show the form for creating a new SolicitudMatricula.
     *
     * @return Response
     */
    public function create()
    {
        return view('solicitud_matriculas.create');
    }

    /**
     * Store a newly created SolicitudMatricula in storage.
     *
     * @param CreateSolicitudMatriculaRequest $request
     *
     * @return Response
     */
    public function store(CreateSolicitudMatriculaRequest $request)
    {
        $input = $request->all();

        $solicitudMatricula = $this->solicitudMatriculaRepository->create($input);

        Flash::success('Solicitud Matricula saved successfully.');

        return redirect(route('solicitudMatriculas.index'));
    }

    /**
     * Display the specified SolicitudMatricula.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $solicitudMatricula = $this->solicitudMatriculaRepository->findWithoutFail($id);

        if (empty($solicitudMatricula)) {
            Flash::error('Solicitud Matricula not found');

            return redirect(route('solicitudMatriculas.index'));
        }

        return view('solicitud_matriculas.show')->with('solicitudMatricula', $solicitudMatricula);
    }

    /**
     * Show the form for editing the specified SolicitudMatricula.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $solicitudMatricula = $this->solicitudMatriculaRepository->findWithoutFail($id);

        if (empty($solicitudMatricula)) {
            Flash::error('Solicitud Matricula not found');

            return redirect(route('solicitudMatriculas.index'));
        }

        return view('solicitud_matriculas.edit')->with('solicitudMatricula', $solicitudMatricula);
    }

    /**
     * Update the specified SolicitudMatricula in storage.
     *
     * @param  int              $id
     * @param UpdateSolicitudMatriculaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSolicitudMatriculaRequest $request)
    {
        $solicitudMatricula = $this->solicitudMatriculaRepository->findWithoutFail($id);

        if (empty($solicitudMatricula)) {
            Flash::error('Solicitud Matricula not found');

            return redirect(route('solicitudMatriculas.index'));
        }

        $solicitudMatricula = $this->solicitudMatriculaRepository->update($request->all(), $id);

        Flash::success('Solicitud Matricula updated successfully.');

        return redirect(route('solicitudMatriculas.index'));
    }

    /**
     * Remove the specified SolicitudMatricula from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $solicitudMatricula = $this->solicitudMatriculaRepository->findWithoutFail($id);

        if (empty($solicitudMatricula)) {
            Flash::error('Solicitud Matricula not found');

            return redirect(route('solicitudMatriculas.index'));
        }

        $this->solicitudMatriculaRepository->delete($id);

        Flash::success('Solicitud Matricula deleted successfully.');

        return redirect(route('solicitudMatriculas.index'));
    }
}
