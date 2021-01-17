<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateErpDivisionRequest;
use App\Http\Requests\UpdateErpDivisionRequest;
use App\Repositories\ErpDivisionRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Auditoria;
use App\Models\Gerencias;
use Response;
use DB;

class ErpDivisionController extends AppBaseController
{
    /** @var  ErpDivisionRepository */
    private $erpDivisionRepository;

    public function __construct(ErpDivisionRepository $erpDivisionRepo)
    {
        $this->erpDivisionRepository = $erpDivisionRepo;
    }

    /**
     * Display a listing of the ErpDivision.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $erpDivisions = DB::select("SELECT * FROM erp_division d join erp_gerencia g on d.ger_id=g.ger_id");

        return view('erp_divisions.index')
            ->with('erpDivisions', $erpDivisions);
    }

    /**
     * Show the form for creating a new ErpDivision.
     *
     * @return Response
     */
    public function create()
    {
        $ger=Gerencias::pluck('ger_descripcion','ger_id');
        return view('erp_divisions.create')
        ->with('ger',$ger)
        ;
    }

    /**
     * Store a newly created ErpDivision in storage.
     *
     * @param CreateErpDivisionRequest $request
     *
     * @return Response
     */
    public function store(CreateErpDivisionRequest $request)
    {
        $input = $request->all();

        $erpDivision = $this->erpDivisionRepository->create($input);
        $aud= new Auditoria();
                 $data=["mod"=>"ErpDivision","acc"=>"Crear","dat"=>$erpDivision,"doc"=>"NA"];
                 $aud->save_adt($data);

        Flash::success('Erp Division saved successfully.');

        return redirect(route('erpDivisions.index'));
    }

    /**
     * Display the specified ErpDivision.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $erpDivision = $this->erpDivisionRepository->findWithoutFail($id);

        if (empty($erpDivision)) {
            Flash::error('Erp Division not found');

            return redirect(route('erpDivisions.index'));
        }

        return view('erp_divisions.show')->with('erpDivision', $erpDivision);
    }

    /**
     * Show the form for editing the specified ErpDivision.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $erpDivision = $this->erpDivisionRepository->findWithoutFail($id);
        $ger=Gerencias::pluck('ger_descripcion','ger_id');
        if (empty($erpDivision)) {
            Flash::error('Erp Division not found');

            return redirect(route('erpDivisions.index'));
        }

        return view('erp_divisions.edit')
        ->with('erpDivision', $erpDivision)
        ->with('ger',$ger)
        ;
    }

    /**
     * Update the specified ErpDivision in storage.
     *
     * @param  int              $id
     * @param UpdateErpDivisionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateErpDivisionRequest $request)
    {
        $erpDivision = $this->erpDivisionRepository->findWithoutFail($id);

        if (empty($erpDivision)) {
            Flash::error('Erp Division not found');

            return redirect(route('erpDivisions.index'));
        }

        $erpDivision = $this->erpDivisionRepository->update($request->all(), $id);
        $aud= new Auditoria();
                 $data=["mod"=>"ErpDivision","acc"=>"Modificar","dat"=>$erpDivision,"doc"=>"NA"];
                 $aud->save_adt($data);

        Flash::success('Erp Division updated successfully.');

        return redirect(route('erpDivisions.index'));
    }

    /**
     * Remove the specified ErpDivision from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $erpDivision = $this->erpDivisionRepository->findWithoutFail($id);

        if (empty($erpDivision)) {
            Flash::error('Erp Division not found');

            return redirect(route('erpDivisions.index'));
        }

        $this->erpDivisionRepository->delete($id);
        $aud= new Auditoria();
                 $data=["mod"=>"ErpDivision","acc"=>"Eliminar","dat"=>$erpDivision,"doc"=>"NA"];
                 $aud->save_adt($data);

        Flash::success('Erp Division deleted successfully.');

        return redirect(route('erpDivisions.index'));
    }
}
