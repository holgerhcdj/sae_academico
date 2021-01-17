<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJornadasRequest;
use App\Http\Requests\UpdateJornadasRequest;
use App\Repositories\JornadasRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Auditoria;

class JornadasController extends AppBaseController
{
    /** @var  JornadasRepository */
    private $jornadasRepository;

    public function __construct(JornadasRepository $jornadasRepo)
    {
        $this->jornadasRepository = $jornadasRepo;
    }

    /**
     * Display a listing of the Jornadas.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        
        $this->jornadasRepository->pushCriteria(new RequestCriteria($request));
        $jornadas = $this->jornadasRepository->all();

        return view('jornadas.index')
            ->with('jornadas', $jornadas);
    }

    /**
     * Show the form for creating a new Jornadas.
     *
     * @return Response
     */
    public function create()
    {
        return view('jornadas.create');
    }

    /**
     * Store a newly created Jornadas in storage.
     *
     * @param CreateJornadasRequest $request
     *
     * @return Response
     */
    public function store(CreateJornadasRequest $request)
    {
        $input = $request->all();

        $jornadas = $this->jornadasRepository->create($input);
        $aud= new Auditoria();
                 $data=["mod"=>"Jornadas","acc"=>"Crear","dat"=>$jornadas,"doc"=>"NA"];
                 $aud->save_adt($data);

        Flash::success('Jornadas saved successfully.');

        return redirect(route('jornadas.index'));
    }

    /**
     * Display the specified Jornadas.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $jornadas = $this->jornadasRepository->findWithoutFail($id);
        if (empty($jornadas)) {
            Flash::error('Jornadas not found');

            return redirect(route('jornadas.index'));
        }

        return view('jornadas.show')->with('jornadas', $jornadas);
    }

    /**
     * Show the form for editing the specified Jornadas.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $jornadas = $this->jornadasRepository->findWithoutFail($id);
        
        if (empty($jornadas)) {
            Flash::error('Jornadas not found');

            return redirect(route('jornadas.index'));
        }

        return view('jornadas.edit')->with('jornadas', $jornadas);
    }

    /**
     * Update the specified Jornadas in storage.
     *
     * @param  int              $id
     * @param UpdateJornadasRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateJornadasRequest $request)
    {
        $jornadas = $this->jornadasRepository->findWithoutFail($id);
        $aud= new Auditoria();
                 $data=["mod"=>"Jornadas","acc"=>"Modificar","dat"=>$jornadas,"doc"=>"NA"];
                 $aud->save_adt($data);

        if (empty($jornadas)) {
            Flash::error('Jornadas not found');

            return redirect(route('jornadas.index'));
        }

        $jornadas = $this->jornadasRepository->update($request->all(), $id);

        Flash::success('Jornadas updated successfully.');

        return redirect(route('jornadas.index'));
    }

    /**
     * Remove the specified Jornadas from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $jornadas = $this->jornadasRepository->findWithoutFail($id);

        if (empty($jornadas)) {
            Flash::error('Jornadas not found');

            return redirect(route('jornadas.index'));
        }

        $this->jornadasRepository->delete($id);

        Flash::success('Jornadas deleted successfully.');

        return redirect(route('jornadas.index'));
    }
}
