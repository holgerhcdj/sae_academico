<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEncuestaGruposRequest;
use App\Http\Requests\UpdateEncuestaGruposRequest;
use App\Repositories\EncuestaGruposRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class EncuestaGruposController extends AppBaseController
{
    /** @var  EncuestaGruposRepository */
    private $encuestaGruposRepository;

    public function __construct(EncuestaGruposRepository $encuestaGruposRepo)
    {
        $this->encuestaGruposRepository = $encuestaGruposRepo;
    }

    /**
     * Display a listing of the EncuestaGrupos.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->encuestaGruposRepository->pushCriteria(new RequestCriteria($request));
        $encuestaGrupos = $this->encuestaGruposRepository->all();

        return view('encuesta_grupos.index')
            ->with('encuestaGrupos', $encuestaGrupos);
    }

    /**
     * Show the form for creating a new EncuestaGrupos.
     *
     * @return Response
     */
    public function create()
    {
        return view('encuesta_grupos.create');
    }

    /**
     * Store a newly created EncuestaGrupos in storage.
     *
     * @param CreateEncuestaGruposRequest $request
     *
     * @return Response
     */
    public function store(CreateEncuestaGruposRequest $request)
    {
        $input = $request->all();

        $encuestaGrupos = $this->encuestaGruposRepository->create($input);

        Flash::success('Encuesta Grupos saved successfully.');

        return redirect(route('encuestaGrupos.index'));
    }

    /**
     * Display the specified EncuestaGrupos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $encuestaGrupos = $this->encuestaGruposRepository->findWithoutFail($id);

        if (empty($encuestaGrupos)) {
            Flash::error('Encuesta Grupos not found');

            return redirect(route('encuestaGrupos.index'));
        }

        return view('encuesta_grupos.show')->with('encuestaGrupos', $encuestaGrupos);
    }

    /**
     * Show the form for editing the specified EncuestaGrupos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $encuestaGrupos = $this->encuestaGruposRepository->findWithoutFail($id);

        if (empty($encuestaGrupos)) {
            Flash::error('Encuesta Grupos not found');

            return redirect(route('encuestaGrupos.index'));
        }

        return view('encuesta_grupos.edit')->with('encuestaGrupos', $encuestaGrupos);
    }

    /**
     * Update the specified EncuestaGrupos in storage.
     *
     * @param  int              $id
     * @param UpdateEncuestaGruposRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEncuestaGruposRequest $request)
    {
        $encuestaGrupos = $this->encuestaGruposRepository->findWithoutFail($id);

        if (empty($encuestaGrupos)) {
            Flash::error('Encuesta Grupos not found');

            return redirect(route('encuestaGrupos.index'));
        }

        $encuestaGrupos = $this->encuestaGruposRepository->update($request->all(), $id);

        Flash::success('Encuesta Grupos updated successfully.');

        return redirect(route('encuestaGrupos.index'));
    }

    /**
     * Remove the specified EncuestaGrupos from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $encuestaGrupos = $this->encuestaGruposRepository->findWithoutFail($id);

        if (empty($encuestaGrupos)) {
            Flash::error('Encuesta Grupos not found');

            return redirect(route('encuestaGrupos.index'));
        }

        $this->encuestaGruposRepository->delete($id);

        Flash::success('Encuesta Grupos deleted successfully.');

        return redirect(route('encuestaGrupos.index'));
    }
}
