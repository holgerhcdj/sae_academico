<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSancionadosRequest;
use App\Http\Requests\UpdateSancionadosRequest;
use App\Repositories\SancionadosRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Usuarios;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Session;
use DB;


class SancionadosController extends AppBaseController
{
    /** @var  SancionadosRepository */
    private $sancionadosRepository;
    private $anl;
    private $anl_bgu;

    public function __construct(SancionadosRepository $sancionadosRepo)
    {
        $this->sancionadosRepository = $sancionadosRepo;
        $this->anl = Session::get('anl_id');
        $this->anl_bgu = Session::get('periodo_id');
    }

    /**
     * Display a listing of the Sancionados.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $d=$request->all();
        $sancionados =[];
        if(isset($d['buscar'])){
            //$sancionados = $this->sancionadosRepository->all();
            $d['est']=strtoupper($d['est']);
            $sancionados = DB::select("SELECT *,m.id as mat_id from matriculas m 
                JOIN estudiantes e on e.id=m.est_id 
                JOIN jornadas j on j.id=m.jor_id 
                JOIN especialidades es on es.id=m.esp_id 
                JOIN cursos c on c.id=m.cur_id 
                WHERE (m.anl_id=$this->anl or m.anl_id=$this->anl_bgu) 
                and (e.est_cedula like '%$d[est]%'  or e.est_apellidos like '%$d[est]%'  ) ");
        }
        return view('sancionados.index')
            ->with('sancionados', $sancionados);
    }

    /**
     * Show the form for creating a new Sancionados.
     *
     * @return Response
     */

    // public function crear($mat_id)
    // {
    //     dd($mat_id);
    //     return view('sancionados.create')
    //     ->with('mat_id',$mat_id)
    //     ;
    // }

    public function create(Request $rq)
    {
        $dt=$rq->all();
        $usuarios=Usuarios::where('usu_estado',0)->orderBy('usu_apellidos')->get()->pluck('full_name', 'id');
        return view('sancionados.create')
        ->with('dt',$dt)
        ->with('usuarios',$usuarios)
        ;
    }

    /**
     * Store a newly created Sancionados in storage.
     *
     * @param CreateSancionadosRequest $request
     *
     * @return Response
     */
    public function store(CreateSancionadosRequest $request)
    {
        $input = $request->all();

        $sancionados = $this->sancionadosRepository->create($input);

        Flash::success('Sancionados saved successfully.');

        return redirect(route('sancionados.index'));
    }

    /**
     * Display the specified Sancionados.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $snc=DB::select("SELECT * from sancionados s join users u on u.id=s.usu_id 
            where s.mat_id=$id ");

        $est=DB::select("SELECT *,m.id as mat_id from matriculas m 
            join estudiantes e on e.id=m.est_id where m.id=$id 
            ");

        // $sancionados = $this->sancionadosRepository->findWithoutFail($id);
        return view('sancionados.show')
        ->with('snc', $snc)
        ->with('est', $est[0])
        ;
    }

    /**
     * Show the form for editing the specified Sancionados.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $sancionados = $this->sancionadosRepository->findWithoutFail($id);
        $usuarios=Usuarios::where('usu_estado',0)->orderBy('usu_apellidos')->get()->pluck('full_name', 'id');
        if (empty($sancionados)) {
            Flash::error('Sancionados not found');
            return redirect(route('sancionados.index'));
        }
        return view('sancionados.edit')
        ->with('sancionados', $sancionados)
        ->with('usuarios', $usuarios)
        ;
    }

    /**
     * Update the specified Sancionados in storage.
     *
     * @param  int              $id
     * @param UpdateSancionadosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSancionadosRequest $request)
    {
        $sancionados = $this->sancionadosRepository->findWithoutFail($id);
        if (empty($sancionados)) {
            Flash::error('Sancionados not found');
            return redirect(route('sancionados.index'));
        }
        $sancionados = $this->sancionadosRepository->update($request->all(), $id);
        return redirect(route('sancionados.show',$sancionados->mat_id));
    }

    /**
     * Remove the specified Sancionados from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $sancionados = $this->sancionadosRepository->findWithoutFail($id);

        if (empty($sancionados)) {
            Flash::error('Sancionados not found');

            return redirect(route('sancionados.index'));
        }

        $this->sancionadosRepository->delete($id);

        Flash::success('Sancionados deleted successfully.');

        return redirect(route('sancionados.index'));
    }
}
