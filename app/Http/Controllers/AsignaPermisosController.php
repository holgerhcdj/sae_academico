<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAsignaPermisosRequest;
use App\Http\Requests\UpdateAsignaPermisosRequest;
use App\Repositories\AsignaPermisosRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Auditoria;

class AsignaPermisosController extends AppBaseController {

    /** @var  AsignaPermisosRepository */
    private $asignaPermisosRepository;

    public function __construct(AsignaPermisosRepository $asignaPermisosRepo) {
        $this->asignaPermisosRepository = $asignaPermisosRepo;
    }


    /**
     * Display a listing of the AsignaPermisos.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) {
        $this->asignaPermisosRepository->pushCriteria(new RequestCriteria($request));
        $asignaPermisos = $this->asignaPermisosRepository->all();

        return view('asigna_permisos.index')
                        ->with('asignaPermisos', $asignaPermisos);
    }

    /**
     * Show the form for creating a new AsignaPermisos.
     *
     * @return Response
     */
    public function create() {
        return view('asigna_permisos.create');
    }

    /**
     * Store a newly created AsignaPermisos in storage.
     *
     * @param CreateAsignaPermisosRequest $request
     *
     * @return Response
     */
    public function store(CreateAsignaPermisosRequest $request) {
        //dd($request->all());
        $modulos = \App\Models\Modulos::find($request->mod_id);

        if ($request->has('mod_id')) {
            $request->merge(['grupo' => $modulos->mod_grupo]);
        }
        if (!$request->has('new')) {
            $request->merge(['new' => 0]);
        }
        if (!$request->has('edit')) {
            $request->merge(['edit' => 0]);
        }
        if (!$request->has('del')) {
            $request->merge(['del' => 0]);
        }
        if (!$request->has('show')) {
            $request->merge(['show' => 0]);
        }
        if (!$request->has('especial')) {
            $request->merge(['especial' => 0]);
        }

        $input = $request->all();
        //dd($input);
        $asignaPermisos = $this->asignaPermisosRepository->create($input);
                 $aud= new Auditoria();
                 $data=["mod"=>"Asigna Permisos","acc"=>"Asignar","dat"=>$asignaPermisos,"doc"=>"NA"];
                 $aud->save_adt($data);        

        return redirect(route('usuarios.show',$request->usu_id));
    }

    /**
     * Display the specified AsignaPermisos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id) {
        $asignaPermisos = $this->asignaPermisosRepository->findWithoutFail($id);

        if (empty($asignaPermisos)) {
            Flash::error('Asigna Permisos not found');

            return redirect(route('asignaPermisos.index'));
        }

        return view('asigna_permisos.show')->with('asignaPermisos', $asignaPermisos);
    }

    /**
     * Show the form for editing the specified AsignaPermisos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id) {
        $asignaPermisos = $this->asignaPermisosRepository->findWithoutFail($id);

        if (empty($asignaPermisos)) {
            Flash::error('Asigna Permisos not found');

            return redirect(route('asignaPermisos.index'));
        }

        return view('asigna_permisos.edit')->with('asignaPermisos', $asignaPermisos);
    }

    /**
     * Update the specified AsignaPermisos in storage.
     *
     * @param  int              $id
     * @param UpdateAsignaPermisosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAsignaPermisosRequest $request) {
        $asignaPermisos = $this->asignaPermisosRepository->findWithoutFail($id);

        if (empty($asignaPermisos)) {
            Flash::error('Asigna Permisos not found');

            return redirect(route('asignaPermisos.index'));
        }

        $asignaPermisos = $this->asignaPermisosRepository->update($request->all(), $id);
                 $aud= new Auditoria();
                 $data=["mod"=>"Asigna Permisos","acc"=>"Modificar","dat"=>$asignaPermisos,"doc"=>"NA"];
                 $aud->save_adt($data);        

        Flash::success('Asigna Permisos updated successfully.');

        return redirect(route('asignaPermisos.index'));
    }

    /**
     * Remove the specified AsignaPermisos from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id) {
        $asignaPermisos = $this->asignaPermisosRepository->findWithoutFail($id);
        $this->asignaPermisosRepository->delete($id);
                 $aud= new Auditoria();
                 $data=["mod"=>"Asigna Permisos","acc"=>"Eliminar","dat"=>$asignaPermisos,"doc"=>"NA"];
                 $aud->save_adt($data);        

        return redirect(route('usuarios.show',$asignaPermisos->usu_id));
    }

}
