<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateModulosRequest;
use App\Http\Requests\UpdateModulosRequest;
use App\Repositories\ModulosRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Auditoria;

class ModulosController extends AppBaseController
{
    /** @var  ModulosRepository */
    private $modulosRepository;

    public function __construct(ModulosRepository $modulosRepo)
    {
        $this->modulosRepository = $modulosRepo;
    }

    /**
     * Display a listing of the Modulos.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->modulosRepository->pushCriteria(new RequestCriteria($request));
        $modulos = $this->modulosRepository->all();

        return view('modulos.index')
            ->with('modulos', $modulos);
    }

    /**
     * Show the form for creating a new Modulos.
     *
     * @return Response
     */
    public function create()
    {
        return view('modulos.create');
    }

    /**
     * Store a newly created Modulos in storage.
     *
     * @param CreateModulosRequest $request
     *
     * @return Response
     */
    public function store(CreateModulosRequest $request)
    {
        $input = $request->all();

        $modulos = $this->modulosRepository->create($input);

        Flash::success('Modulos saved successfully.');

        return redirect(route('modulos.index'));
    }

    /**
     * Display the specified Modulos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $modulos = $this->modulosRepository->findWithoutFail($id);

        if (empty($modulos)) {
            Flash::error('Modulos not found');

            return redirect(route('modulos.index'));
        }

        return view('modulos.show')->with('modulos', $modulos);
    }

    /**
     * Show the form for editing the specified Modulos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $modulos = $this->modulosRepository->findWithoutFail($id);

        if (empty($modulos)) {
            Flash::error('Modulos not found');

            return redirect(route('modulos.index'));
        }

        return view('modulos.edit')->with('modulos', $modulos);
    }

    /**
     * Update the specified Modulos in storage.
     *
     * @param  int              $id
     * @param UpdateModulosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateModulosRequest $request)
    {
        $modulos = $this->modulosRepository->findWithoutFail($id);

        if (empty($modulos)) {
            Flash::error('Modulos not found');

            return redirect(route('modulos.index'));
        }

        $modulos = $this->modulosRepository->update($request->all(), $id);

        Flash::success('Modulos updated successfully.');

        return redirect(route('modulos.index'));
    }

    /**
     * Remove the specified Modulos from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $modulos = $this->modulosRepository->findWithoutFail($id);

        if (empty($modulos)) {
            Flash::error('Modulos not found');

            return redirect(route('modulos.index'));
        }

        $this->modulosRepository->delete($id);

        Flash::success('Modulos deleted successfully.');

        return redirect(route('modulos.index'));
    }
}
