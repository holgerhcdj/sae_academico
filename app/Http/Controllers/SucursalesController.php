<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSucursalesRequest;
use App\Http\Requests\UpdateSucursalesRequest;
use App\Repositories\SucursalesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Auditoria;

class SucursalesController extends AppBaseController
{
    /** @var  SucursalesRepository */
    private $sucursalesRepository;

    public function __construct(SucursalesRepository $sucursalesRepo)
    {
        $this->sucursalesRepository = $sucursalesRepo;
    }

    /**
     * Display a listing of the Sucursales.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->sucursalesRepository->pushCriteria(new RequestCriteria($request));
        $sucursales = $this->sucursalesRepository->all();

        return view('sucursales.index')
            ->with('sucursales', $sucursales);
    }

    /**
     * Show the form for creating a new Sucursales.
     *
     * @return Response
     */
    public function create()
    {
        return view('sucursales.create');
    }

    /**
     * Store a newly created Sucursales in storage.
     *
     * @param CreateSucursalesRequest $request
     *
     * @return Response
     */
    public function store(CreateSucursalesRequest $request)
    {
        $input = $request->all();

        $sucursales = $this->sucursalesRepository->create($input);

        Flash::success('Sucursales saved successfully.');

        return redirect(route('sucursales.index'));
    }

    /**
     * Display the specified Sucursales.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $sucursales = $this->sucursalesRepository->findWithoutFail($id);

        if (empty($sucursales)) {
            Flash::error('Sucursales not found');

            return redirect(route('sucursales.index'));
        }

        return view('sucursales.show')->with('sucursales', $sucursales);
    }

    /**
     * Show the form for editing the specified Sucursales.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $sucursales = $this->sucursalesRepository->findWithoutFail($id);

        if (empty($sucursales)) {
            Flash::error('Sucursales not found');

            return redirect(route('sucursales.index'));
        }

        return view('sucursales.edit')->with('sucursales', $sucursales);
    }

    /**
     * Update the specified Sucursales in storage.
     *
     * @param  int              $id
     * @param UpdateSucursalesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSucursalesRequest $request)
    {
        $sucursales = $this->sucursalesRepository->findWithoutFail($id);

        if (empty($sucursales)) {
            Flash::error('Sucursales not found');

            return redirect(route('sucursales.index'));
        }

        $sucursales = $this->sucursalesRepository->update($request->all(), $id);

        Flash::success('Sucursales updated successfully.');

        return redirect(route('sucursales.index'));
    }

    /**
     * Remove the specified Sucursales from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $sucursales = $this->sucursalesRepository->findWithoutFail($id);

        if (empty($sucursales)) {
            Flash::error('Sucursales not found');

            return redirect(route('sucursales.index'));
        }

        $this->sucursalesRepository->delete($id);

        Flash::success('Sucursales deleted successfully.');

        return redirect(route('sucursales.index'));
    }
}
