<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEspecialidadesRequest;
use App\Http\Requests\UpdateEspecialidadesRequest;
use App\Repositories\EspecialidadesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Materias;
use Laracasts\Flash\Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Auditoria;

class EspecialidadesController extends AppBaseController {

    /** @var  EspecialidadesRepository */
    private $especialidadesRepository;

    public function __construct(EspecialidadesRepository $especialidadesRepo) {
        $this->especialidadesRepository = $especialidadesRepo;
    }

    /**
     * Display a listing of the Especialidades.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) {
        $op = $request->all();
        $this->especialidadesRepository->pushCriteria(new RequestCriteria($request));
        $especialidades = $this->especialidadesRepository->findWhere([['id','<>',7],['id','<>',8]]);
        //$especialidades = $this->especialidadesRepository->all();
        return view('especialidades.index')
                        ->with('especialidades', $especialidades)
                        ->with('op', $op)
        ;
    }

    /**
     * Show the form for creating a new Especialidades.
     *
     * @return Response
     */
    public function create() {
        return view('especialidades.create');
    }

    /**
     * Store a newly created Especialidades in storage.
     *
     * @param CreateEspecialidadesRequest $request
     *
     * @return Response
     */
    public function store(CreateEspecialidadesRequest $request) {
        $input = $request->all();

        $especialidades = $this->especialidadesRepository->create($input);
                 $aud= new Auditoria();
                 $data=["mod"=>"Especialidades","acc"=>"Insertar","dat"=>$especialidades,"doc"=>"NA"];
                 $aud->save_adt($data);        

        Flash::success('Especialidad Guardada Correctamente.');

        return redirect(route('especialidades.index'));
    }

    /**
     * Display the specified Especialidades.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id) {
        $especialidades = $this->especialidadesRepository->findWithoutFail($id);
        if (empty($especialidades)) {
            Flash::error('Especialidades not found');
            return redirect(route('especialidades.index'));
        }

        return view('especialidades.show')->with('especialidades', $especialidades);
    }

    /**
     * Show the form for editing the specified Especialidades.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id) {
        $especialidades = $this->especialidadesRepository->findWithoutFail($id);

        if (empty($especialidades)) {
            Flash::error('Especialidades not found');

            return redirect(route('especialidades.index'));
        }

        return view('especialidades.edit')->with('especialidades', $especialidades);
    }

    /**
     * Update the specified Especialidades in storage.
     *
     * @param  int              $id
     * @param UpdateEspecialidadesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEspecialidadesRequest $request) {
        $especialidades = $this->especialidadesRepository->findWithoutFail($id);

        if (empty($especialidades)) {
            Flash::error('Especialidades not found');

            return redirect(route('especialidades.index'));
        }

        $especialidades = $this->especialidadesRepository->update($request->all(), $id);
                 $aud= new Auditoria();
                 $data=["mod"=>"Especialidades","acc"=>"Modificar","dat"=>$especialidades,"doc"=>"NA"];
                 $aud->save_adt($data);        

        Flash::success('Especialidad Editada Correctamente.');

        return redirect(route('especialidades.index'));
    }

    /**
     * Remove the specified Especialidades from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id) {
        $especialidades = $this->especialidadesRepository->findWithoutFail($id);

        if (empty($especialidades)) {
            Flash::error('Especialidades not found');

            return redirect(route('especialidades.index'));
        }

        $this->especialidadesRepository->delete($id);
                 $aud= new Auditoria();
                 $data=["mod"=>"Especialidades","acc"=>"Eliminar","dat"=>$especialidades,"doc"=>"NA"];
                 $aud->save_adt($data);        

        Flash::success('Especialidades Eliminada Correctamente.');

        return redirect(route('especialidades.index'));
    }

}
