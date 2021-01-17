<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDetalleRequest;
use App\Http\Requests\UpdateDetalleRequest;
use App\Repositories\DetalleRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Auditoria;

class DetalleController extends AppBaseController
{
    /** @var  DetalleRepository */
    private $detalleRepository;

    public function __construct(DetalleRepository $detalleRepo)
    {
        $this->detalleRepository = $detalleRepo;
    }

    /**
     * Display a listing of the Detalle.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->detalleRepository->pushCriteria(new RequestCriteria($request));
        $detalles = $this->detalleRepository->all();

        return view('detalles.index')
            ->with('detalles', $detalles);
    }

    /**
     * Show the form for creating a new Detalle.
     *
     * @return Response
     */
    public function create()
    {
        return view('detalles.create');
    }

    /**
     * Store a newly created Detalle in storage.
     *
     * @param CreateDetalleRequest $request
     *
     * @return Response
     */
    public function store(CreateDetalleRequest $request)
    {
        $input = $request->all();

        $detalle = $this->detalleRepository->create($input);

        Flash::success('Detalle saved successfully.');

        return redirect(route('detalles.index'));
    }

    /**
     * Display the specified Detalle.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $detalle = $this->detalleRepository->findWithoutFail($id);

        if (empty($detalle)) {
            Flash::error('Detalle not found');

            return redirect(route('detalles.index'));
        }

        return view('detalles.show')->with('detalle', $detalle);
    }

    /**
     * Show the form for editing the specified Detalle.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $detalle = $this->detalleRepository->findWithoutFail($id);

        if (empty($detalle)) {
            Flash::error('Detalle not found');

            return redirect(route('detalles.index'));
        }

        return view('detalles.edit')->with('detalle', $detalle);
    }

    /**
     * Update the specified Detalle in storage.
     *
     * @param  int              $id
     * @param UpdateDetalleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDetalleRequest $request)
    {
        $detalle = $this->detalleRepository->findWithoutFail($id);

        if (empty($detalle)) {
            Flash::error('Detalle not found');

            return redirect(route('detalles.index'));
        }

        $detalle = $this->detalleRepository->update($request->all(), $id);

        Flash::success('Detalle updated successfully.');

        return redirect(route('detalles.index'));
    }

    /**
     * Remove the specified Detalle from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $detalle = $this->detalleRepository->findWithoutFail($id);

        if (empty($detalle)) {
            Flash::error('Detalle not found');

            return redirect(route('detalles.index'));
        }

        $this->detalleRepository->delete($id);

        Flash::success('Detalle deleted successfully.');

        return redirect(route('detalles.index'));
    }
}
