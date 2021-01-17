<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSugerenciasRequest;
use App\Http\Requests\UpdateSugerenciasRequest;
use App\Repositories\SugerenciasRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SugerenciasController extends AppBaseController
{
    /** @var  SugerenciasRepository */
    private $sugerenciasRepository;

    public function __construct(SugerenciasRepository $sugerenciasRepo)
    {
        $this->sugerenciasRepository = $sugerenciasRepo;
    }

    /**
     * Display a listing of the Sugerencias.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $usr=Auth::user()->id;

        $sugerencias = DB::select("select s.*,u.usu_apellidos,u.name from sugerencias s
            join users u on u.id=s.usu_id where u.id=$usr order by f_registro");
        return view('sugerencias.index')
            ->with('sugerencias', $sugerencias);
    }

    /**
     * Show the form for creating a new Sugerencias.
     *
     * @return Response
     */
    public function create()
    {
        return view('sugerencias.create');
    }

    /**
     * Store a newly created Sugerencias in storage.
     *
     * @param CreateSugerenciasRequest $request
     *
     * @return Response
     */
    public function store(CreateSugerenciasRequest $request)
    {
        $input = $request->all();

        $sugerencias = $this->sugerenciasRepository->create($input);

        Flash::success('Sugerencias saved successfully.');

        return redirect(route('sugerencias.index'));
    }

    /**
     * Display the specified Sugerencias.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $sugerencias = $this->sugerenciasRepository->findWithoutFail($id);

        if (empty($sugerencias)) {
            Flash::error('Sugerencias not found');

            return redirect(route('sugerencias.index'));
        }

        return view('sugerencias.show')->with('sugerencias', $sugerencias);
    }

    /**
     * Show the form for editing the specified Sugerencias.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {

        $sugerencias = $this->sugerenciasRepository->findWithoutFail($id);
        if (empty($sugerencias)) {
            Flash::error('Sugerencias not found');

            return redirect(route('sugerencias.index'));
        }

        return view('sugerencias.edit')->with('sugerencias', $sugerencias);
    }

    /**
     * Update the specified Sugerencias in storage.
     *
     * @param  int              $id
     * @param UpdateSugerenciasRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSugerenciasRequest $request)
    {
        // 'usu_id',
        // 'revisado',
        // 'asunto',
        // 'f_registro',
        // 'f_vista',
        // 'detalle',
        // 'estado',
        // 'contestacion'
        $data=$request->all();
        //$usr=Auth::user()->name.' '.Auth::user()->usu_apellidos;
        $usr=Auth::user()->id;

        if($usr==84){
            $input['f_vista']=date('Y-m-d');
            $input['revisado']=$data['revisado'];
            $input['contestacion']=$data['contestacion'];
            $input['estado']=1;
        }else{
            $input['asunto']=$data['asunto'];
            $input['detalle']=$data['detalle'];
        }
           



        $sugerencias = $this->sugerenciasRepository->update($input, $id);
        Flash::success('Sugerencias updated successfully.');

        return redirect(route('sugerencias.index'));
    }

    /**
     * Remove the specified Sugerencias from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $sugerencias = $this->sugerenciasRepository->findWithoutFail($id);

        if (empty($sugerencias)) {
            Flash::error('Sugerencias not found');

            return redirect(route('sugerencias.index'));
        }

        $this->sugerenciasRepository->delete($id);

        Flash::success('Sugerencias deleted successfully.');

        return redirect(route('sugerencias.index'));
    }
}
