<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSeguimientoAccionesDeceRequest;
use App\Http\Requests\UpdateSeguimientoAccionesDeceRequest;
use App\Repositories\SeguimientoAccionesDeceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class SeguimientoAccionesDeceController extends AppBaseController
{
    /** @var  SeguimientoAccionesDeceRepository */
    private $seguimientoAccionesDeceRepository;

    public function __construct(SeguimientoAccionesDeceRepository $seguimientoAccionesDeceRepo)
    {
        $this->seguimientoAccionesDeceRepository = $seguimientoAccionesDeceRepo;
    }

    /**
     * Display a listing of the SeguimientoAccionesDece.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->seguimientoAccionesDeceRepository->pushCriteria(new RequestCriteria($request));
        $seguimientoAccionesDeces = $this->seguimientoAccionesDeceRepository->all();

        return view('seguimiento_acciones_deces.index')
            ->with('seguimientoAccionesDeces', $seguimientoAccionesDeces);
    }

    /**
     * Show the form for creating a new SeguimientoAccionesDece.
     *
     * @return Response
     */
    public function create()
    {
        return view('seguimiento_acciones_deces.create');
    }

    /**
     * Store a newly created SeguimientoAccionesDece in storage.
     *
     * @param CreateSeguimientoAccionesDeceRequest $request
     *
     * @return Response
     */
    public function store(CreateSeguimientoAccionesDeceRequest $request)
    {
        $input = $request->all();

        $seguimientoAccionesDece = $this->seguimientoAccionesDeceRepository->create($input);

        Flash::success('Seguimiento Acciones Dece saved successfully.');

        return redirect(route('seguimientoAccionesDeces.index'));
    }

    /**
     * Display the specified SeguimientoAccionesDece.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $seguimientoAccionesDece = $this->seguimientoAccionesDeceRepository->findWithoutFail($id);

        if (empty($seguimientoAccionesDece)) {
            Flash::error('Seguimiento Acciones Dece not found');

            return redirect(route('seguimientoAccionesDeces.index'));
        }

        return view('seguimiento_acciones_deces.show')->with('seguimientoAccionesDece', $seguimientoAccionesDece);
    }

    /**
     * Show the form for editing the specified SeguimientoAccionesDece.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $seguimientoAccionesDece = $this->seguimientoAccionesDeceRepository->findWithoutFail($id);

        if (empty($seguimientoAccionesDece)) {
            Flash::error('Seguimiento Acciones Dece not found');

            return redirect(route('seguimientoAccionesDeces.index'));
        }

        return view('seguimiento_acciones_deces.edit')->with('seguimientoAccionesDece', $seguimientoAccionesDece);
    }

    /**
     * Update the specified SeguimientoAccionesDece in storage.
     *
     * @param  int              $id
     * @param UpdateSeguimientoAccionesDeceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSeguimientoAccionesDeceRequest $request)
    {
        $seguimientoAccionesDece = $this->seguimientoAccionesDeceRepository->findWithoutFail($id);

        if (empty($seguimientoAccionesDece)) {
            Flash::error('Seguimiento Acciones Dece not found');

            return redirect(route('seguimientoAccionesDeces.index'));
        }

        $seguimientoAccionesDece = $this->seguimientoAccionesDeceRepository->update($request->all(), $id);

        Flash::success('Seguimiento Acciones Dece updated successfully.');

        return redirect(route('seguimientoAccionesDeces.index'));
    }

    /**
     * Remove the specified SeguimientoAccionesDece from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy(Request $rq)
    {
        $id=$rq->all()['accid'];
         $seguimientoAccionesDece = $this->seguimientoAccionesDeceRepository->findWithoutFail($id);
         $sgid=$seguimientoAccionesDece->segid;
        // if (empty($seguimientoAccionesDece)) {
        //     Flash::error('Seguimiento Acciones Dece not found');
        //    return redirect(route('seguimientoAccionesDeces.index'));
        // }
        $this->seguimientoAccionesDeceRepository->delete($id);

        // Flash::success('Seguimiento Acciones Dece deleted successfully.');
        //return redirect(route('seguimientoAccionesDeces.index'));
        return redirect(route('seguimientoDeces.edit',$sgid));
    }
}
