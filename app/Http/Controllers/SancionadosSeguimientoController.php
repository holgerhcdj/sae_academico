<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSancionadosSeguimientoRequest;
use App\Http\Requests\UpdateSancionadosSeguimientoRequest;
use App\Repositories\SancionadosSeguimientoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Usuarios;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class SancionadosSeguimientoController extends AppBaseController
{
    /** @var  SancionadosSeguimientoRepository */
    private $sancionadosSeguimientoRepository;

    public function __construct(SancionadosSeguimientoRepository $sancionadosSeguimientoRepo)
    {
        $this->sancionadosSeguimientoRepository = $sancionadosSeguimientoRepo;
    }

    /**
     * Display a listing of the SancionadosSeguimiento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $this->sancionadosSeguimientoRepository->pushCriteria(new RequestCriteria($request));
        $sancionadosSeguimientos = $this->sancionadosSeguimientoRepository->all();
        return view('sancionados_seguimientos.index')
            ->with('sancionadosSeguimientos', $sancionadosSeguimientos);
    }

    /**
     * Show the form for creating a new SancionadosSeguimiento.
     *
     * @return Response
     */
    public function create(Request $req)
    {
        $dt=$req->all();
        $sanciones=DB::select("SELECT * FROM sancionados where snc_id=$dt[snc_id]");
        $usuarios=Usuarios::where('usu_estado',0)->orderBy('usu_apellidos')->get()->pluck('full_name', 'id');
        return view('sancionados_seguimientos.create')
        ->with('sanciones',$sanciones)
        ->with('dt',$dt)
        ->with('usuarios',$usuarios)
        ;
    }

    /**
     * Store a newly created SancionadosSeguimiento in storage.
     *
     * @param CreateSancionadosSeguimientoRequest $request
     *
     * @return Response
     */
    public function store(CreateSancionadosSeguimientoRequest $request)
    {

        $input = $request->all();
        $sancionadosSeguimiento = $this->sancionadosSeguimientoRepository->create($input);
        return redirect(route('sancionadosSeguimientos.show',$input['snc_id']));
    }

    /**
     * Display the specified SancionadosSeguimiento.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {

        $sancionados = DB::select("SELECT * FROM sancionados s 
            join matriculas m on s.mat_id=m.id
            join estudiantes e on m.est_id=e.id
            where s.snc_id=$id ");
        $sancionadosSeguimientos = DB::select("SELECT * from sancionados_seguimiento s join users u on u.id=s.usu_id where s.snc_id=$id");
        return view('sancionados_seguimientos.index')
        ->with('sancionadosSeguimientos', $sancionadosSeguimientos)
        ->with('sancionados', $sancionados[0])
        ->with('snc_id', $id)
        ;
    }

    /**
     * Show the form for editing the specified SancionadosSeguimiento.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $sancionadosSeguimientos = $this->sancionadosSeguimientoRepository->findWithoutFail($id);
        $usuarios=Usuarios::where('usu_estado',0)->orderBy('usu_apellidos')->get()->pluck('full_name', 'id');
        return view('sancionados_seguimientos.edit')
        ->with('sancionadosSeguimientos', $sancionadosSeguimientos)
        ->with('usuarios', $usuarios);
    }

    /**
     * Update the specified SancionadosSeguimiento in storage.
     *
     * @param  int              $id
     * @param UpdateSancionadosSeguimientoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSancionadosSeguimientoRequest $request)
    {
        $snc = $this->sancionadosSeguimientoRepository->findWithoutFail($id);
        $sancionadosSeguimiento = $this->sancionadosSeguimientoRepository->update($request->all(),$id);
        return redirect(route('sancionadosSeguimientos.show',$snc->snc_id));
    }

    /**
     * Remove the specified SancionadosSeguimiento from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $sancionadosSeguimiento = $this->sancionadosSeguimientoRepository->findWithoutFail($id);
        $this->sancionadosSeguimientoRepository->delete($id);
        return redirect(route('sancionadosSeguimientos.show',$sancionadosSeguimiento->snc_id));
    }
}
