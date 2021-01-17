<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGerenciasRequest;
use App\Http\Requests\UpdateGerenciasRequest;
use App\Repositories\GerenciasRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class GerenciasController extends AppBaseController
{
    /** @var  GerenciasRepository */
    private $gerenciasRepository;

    public function __construct(GerenciasRepository $gerenciasRepo)
    {
        $this->gerenciasRepository = $gerenciasRepo;
    }

    /**
     * Display a listing of the Gerencias.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->gerenciasRepository->pushCriteria(new RequestCriteria($request));
        $gerencias = $this->gerenciasRepository->all();

        return view('gerencias.index')
            ->with('gerencias', $gerencias);
    }

    /**
     * Show the form for creating a new Gerencias.
     *
     * @return Response
     */
    public function create()
    {
        return view('gerencias.create');
    }

    /**
     * Store a newly created Gerencias in storage.
     *
     * @param CreateGerenciasRequest $request
     *
     * @return Response
     */
    public function store(CreateGerenciasRequest $request)
    {
        $input = $request->all();

        $gerencias = $this->gerenciasRepository->create($input);

        Flash::success('Gerencias saved successfully.');

        return redirect(route('gerencias.index'));
    }

    /**
     * Display the specified Gerencias.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $gerencias = $this->gerenciasRepository->findWithoutFail($id);

        if (empty($gerencias)) {
            Flash::error('Gerencias not found');

            return redirect(route('gerencias.index'));
        }

        return view('gerencias.show')->with('gerencias', $gerencias);
    }

    /**
     * Show the form for editing the specified Gerencias.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $gerencias = $this->gerenciasRepository->findWithoutFail($id);

        if (empty($gerencias)) {
            Flash::error('Gerencias not found');

            return redirect(route('gerencias.index'));
        }

        return view('gerencias.edit')->with('gerencias', $gerencias);
    }

    /**
     * Update the specified Gerencias in storage.
     *
     * @param  int              $id
     * @param UpdateGerenciasRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGerenciasRequest $request)
    {
        $gerencias = $this->gerenciasRepository->findWithoutFail($id);

        if (empty($gerencias)) {
            Flash::error('Gerencias not found');

            return redirect(route('gerencias.index'));
        }

        $gerencias = $this->gerenciasRepository->update($request->all(), $id);

        Flash::success('Gerencias updated successfully.');

        return redirect(route('gerencias.index'));
    }

    /**
     * Remove the specified Gerencias from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $gerencias = $this->gerenciasRepository->findWithoutFail($id);

        if (empty($gerencias)) {
            Flash::error('Gerencias not found');

            return redirect(route('gerencias.index'));
        }

        $this->gerenciasRepository->delete($id);

        Flash::success('Gerencias deleted successfully.');

        return redirect(route('gerencias.index'));
    }
}
