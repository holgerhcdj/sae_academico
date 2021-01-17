<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProTipoRequest;
use App\Http\Requests\UpdateProTipoRequest;
use App\Repositories\ProTipoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Auditoria;
use Response;

class ProTipoController extends AppBaseController
{
    /** @var  ProTipoRepository */
    private $proTipoRepository;

    public function __construct(ProTipoRepository $proTipoRepo)
    {
        $this->proTipoRepository = $proTipoRepo;
    }

    /**
     * Display a listing of the ProTipo.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->proTipoRepository->pushCriteria(new RequestCriteria($request));
        $proTipos = $this->proTipoRepository->all();

        return view('pro_tipos.index')
            ->with('proTipos', $proTipos);
    }

    /**
     * Show the form for creating a new ProTipo.
     *
     * @return Response
     */
    public function create()
    {
        return view('pro_tipos.create');
    }

    /**
     * Store a newly created ProTipo in storage.
     *
     * @param CreateProTipoRequest $request
     *
     * @return Response
     */
    public function store(CreateProTipoRequest $request)
    {
        $input = $request->all();

        $proTipo = $this->proTipoRepository->create($input);
        $aud= new Auditoria();
                 $data=["mod"=>"ProTipo","acc"=>"Crear","dat"=>$proTipo,"doc"=>"NA"];
                 $aud->save_adt($data);

        Flash::success('Pro Tipo saved successfully.');

        return redirect(route('proTipos.index'));
    }

    /**
     * Display the specified ProTipo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $proTipo = $this->proTipoRepository->findWithoutFail($id);

        if (empty($proTipo)) {
            Flash::error('Pro Tipo not found');

            return redirect(route('proTipos.index'));
        }

        return view('pro_tipos.show')->with('proTipo', $proTipo);
    }

    /**
     * Show the form for editing the specified ProTipo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $proTipo = $this->proTipoRepository->findWithoutFail($id);

        if (empty($proTipo)) {
            Flash::error('Pro Tipo not found');

            return redirect(route('proTipos.index'));
        }

        return view('pro_tipos.edit')->with('proTipo', $proTipo);
    }

    /**
     * Update the specified ProTipo in storage.
     *
     * @param  int              $id
     * @param UpdateProTipoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProTipoRequest $request)
    {
        $proTipo = $this->proTipoRepository->findWithoutFail($id);

        if (empty($proTipo)) {
            Flash::error('Pro Tipo not found');

            return redirect(route('proTipos.index'));
        }

        $proTipo = $this->proTipoRepository->update($request->all(), $id);
        $aud= new Auditoria();
                 $data=["mod"=>"ProTipo","acc"=>"Modificar","dat"=>$proTipo,"doc"=>"NA"];
                 $aud->save_adt($data);

        Flash::success('Pro Tipo updated successfully.');

        return redirect(route('proTipos.index'));
    }

    /**
     * Remove the specified ProTipo from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $proTipo = $this->proTipoRepository->findWithoutFail($id);

        if (empty($proTipo)) {
            Flash::error('Pro Tipo not found');

            return redirect(route('proTipos.index'));
        }

        $this->proTipoRepository->delete($id);
        $aud= new Auditoria();
                 $data=["mod"=>"ProTipo","acc"=>"Eliminar","dat"=>$proTipo,"doc"=>"NA"];
                 $aud->save_adt($data);

        Flash::success('Pro Tipo deleted successfully.');

        return redirect(route('proTipos.index'));
    }
}
