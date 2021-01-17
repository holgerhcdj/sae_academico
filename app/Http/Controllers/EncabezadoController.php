<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEncabezadoRequest;
use App\Http\Requests\UpdateEncabezadoRequest;
use App\Repositories\EncabezadoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Auditoria;

class EncabezadoController extends AppBaseController
{
    /** @var  EncabezadoRepository */
    private $encabezadoRepository;

    public function __construct(EncabezadoRepository $encabezadoRepo)
    {
        $this->encabezadoRepository = $encabezadoRepo;
    }

    /**
     * Display a listing of the Encabezado.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->encabezadoRepository->pushCriteria(new RequestCriteria($request));
        $encabezados = $this->encabezadoRepository->all();

        return view('encabezados.index')
            ->with('encabezados', $encabezados);
    }

    /**
     * Show the form for creating a new Encabezado.
     *
     * @return Response
     */
    public function create()
    {
        return view('encabezados.create');
    }

    /**
     * Store a newly created Encabezado in storage.
     *
     * @param CreateEncabezadoRequest $request
     *
     * @return Response
     */
    public function store(CreateEncabezadoRequest $request)
    {
        $input = $request->all();

        $encabezado = $this->encabezadoRepository->create($input);

        Flash::success('Encabezado saved successfully.');

        return redirect(route('encabezados.index'));
    }

    /**
     * Display the specified Encabezado.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $encabezado = $this->encabezadoRepository->findWithoutFail($id);

        if (empty($encabezado)) {
            Flash::error('Encabezado not found');

            return redirect(route('encabezados.index'));
        }

        return view('encabezados.show')->with('encabezado', $encabezado);
    }

    /**
     * Show the form for editing the specified Encabezado.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $encabezado = $this->encabezadoRepository->findWithoutFail($id);

        if (empty($encabezado)) {
            Flash::error('Encabezado not found');

            return redirect(route('encabezados.index'));
        }

        return view('encabezados.edit')->with('encabezado', $encabezado);
    }

    /**
     * Update the specified Encabezado in storage.
     *
     * @param  int              $id
     * @param UpdateEncabezadoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEncabezadoRequest $request)
    {
        $encabezado = $this->encabezadoRepository->findWithoutFail($id);

        if (empty($encabezado)) {
            Flash::error('Encabezado not found');

            return redirect(route('encabezados.index'));
        }

        $encabezado = $this->encabezadoRepository->update($request->all(), $id);

        Flash::success('Encabezado updated successfully.');

        return redirect(route('encabezados.index'));
    }

    /**
     * Remove the specified Encabezado from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $encabezado = $this->encabezadoRepository->findWithoutFail($id);

        if (empty($encabezado)) {
            Flash::error('Encabezado not found');

            return redirect(route('encabezados.index'));
        }

        $this->encabezadoRepository->delete($id);

        Flash::success('Encabezado deleted successfully.');

        return redirect(route('encabezados.index'));
    }
}
