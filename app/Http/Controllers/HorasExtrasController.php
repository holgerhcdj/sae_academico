<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateHorasExtrasRequest;
use App\Http\Requests\UpdateHorasExtrasRequest;
use App\Repositories\HorasExtrasRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Usuarios;
use App\Models\AnioLectivo;
use Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class HorasExtrasController extends AppBaseController
{
    /** @var  HorasExtrasRepository */
    private $horasExtrasRepository;

    public function __construct(HorasExtrasRepository $horasExtrasRepo)
    {
        $this->horasExtrasRepository = $horasExtrasRepo;
    }

    /**
     * Display a listing of the HorasExtras.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $horasExtras = DB::select("select * from horas_extras he join users u on he.usuid=u.id ");
        return view('horas_extras.index')
            ->with('horasExtras', $horasExtras);
    }

    /**
     * Show the form for creating a new HorasExtras.
     *
     * @return Response
     */
    public function create()
    {
        $usuarios = Usuarios::where('usu_estado', 0)->orderBy('usu_apellidos')->get()->pluck('full_name', 'id');        
        $anios=AnioLectivo::pluck('anl_descripcion','id');
        $anl = Session::get('anl_id');
        return view('horas_extras.create')
        ->with('usuarios',$usuarios)
        ->with('anios',$anios)
        ->with('anl',$anl)
        ;
    }

    /**
     * Store a newly created HorasExtras in storage.
     *
     * @param CreateHorasExtrasRequest $request
     *
     * @return Response
     */
    public function store(CreateHorasExtrasRequest $request)
    {
        $input = $request->all();

        $horasExtras = $this->horasExtrasRepository->create($input);

        Flash::success('Horas Extras saved successfully.');

        return redirect(route('horasExtras.index'));
    }

    /**
     * Display the specified HorasExtras.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $horasExtras = $this->horasExtrasRepository->findWithoutFail($id);
        $usuarios = Usuarios::where('usu_estado', 0)->orderBy('usu_apellidos')->get()->pluck('full_name', 'id');        
        $anios=AnioLectivo::pluck('anl_descripcion','id');
        $anl = Session::get('anl_id');

        return view('horas_extras.show')
        ->with('horasExtras', $horasExtras)
        ->with('usuarios',$usuarios)
        ->with('anios',$anios)
        ->with('anl',$anl)

        ;
    }

    /**
     * Show the form for editing the specified HorasExtras.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $horasExtras = $this->horasExtrasRepository->findWithoutFail($id);
        $usuarios = Usuarios::where('usu_estado', 0)->orderBy('usu_apellidos')->get()->pluck('full_name', 'id');        
        $anios=AnioLectivo::pluck('anl_descripcion','id');
        $anl = Session::get('anl_id');

        return view('horas_extras.edit')
        ->with('horasExtras', $horasExtras)
        ->with('usuarios',$usuarios)
        ->with('anios',$anios)
        ->with('anl',$anl)
        
        ;
    }

    /**
     * Update the specified HorasExtras in storage.
     *
     * @param  int              $id
     * @param UpdateHorasExtrasRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateHorasExtrasRequest $request)
    {
        $horasExtras = $this->horasExtrasRepository->findWithoutFail($id);

        if (empty($horasExtras)) {
            Flash::error('Horas Extras not found');

            return redirect(route('horasExtras.index'));
        }

        $horasExtras = $this->horasExtrasRepository->update($request->all(), $id);

        Flash::success('Horas Extras updated successfully.');

        return redirect(route('horasExtras.index'));
    }

    /**
     * Remove the specified HorasExtras from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $horasExtras = $this->horasExtrasRepository->findWithoutFail($id);

        if (empty($horasExtras)) {
            Flash::error('Horas Extras not found');

            return redirect(route('horasExtras.index'));
        }

        $this->horasExtrasRepository->delete($id);

        Flash::success('Horas Extras deleted successfully.');

        return redirect(route('horasExtras.index'));
    }
}
