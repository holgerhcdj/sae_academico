<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePermisosVacacionesRequest;
use App\Http\Requests\UpdatePermisosVacacionesRequest;
use App\Repositories\PermisosVacacionesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Usuarios;
use Illuminate\Support\Facades\DB;

class PermisosVacacionesController extends AppBaseController
{
    /** @var  PermisosVacacionesRepository */
    private $permisosVacacionesRepository;

    public function __construct(PermisosVacacionesRepository $permisosVacacionesRepo)
    {
        $this->permisosVacacionesRepository = $permisosVacacionesRepo;
    }

    /**
     * Display a listing of the PermisosVacaciones.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $permisosVacaciones = DB::select("select * from permisos_vacaciones pv 
            join users u on u.id=pv.usuid 
            order by pv.f_desde ");
        return view('permisos_vacaciones.index')
            ->with('permisosVacaciones', $permisosVacaciones);
    }

    /**
     * Show the form for creating a new PermisosVacaciones.
     *
     * @return Response
     */
    public function create()
    {

        $usuarios = Usuarios::where('usu_estado', 0)->get()->pluck('full_name', 'id');
        return view('permisos_vacaciones.create')
        ->with('usuarios',$usuarios)
        ;
    }

    /**
     * Store a newly created PermisosVacaciones in storage.
     *
     * @param CreatePermisosVacacionesRequest $request
     *
     * @return Response
     */
    public function store(CreatePermisosVacacionesRequest $request)
    {
        $input = $request->all();
        //dd($input);
        $permisosVacaciones = $this->permisosVacacionesRepository->create($input);
        Flash::success('Permisos Vacaciones saved successfully.');
        return redirect(route('permisosVacaciones.index'));
    }

    /**
     * Display the specified PermisosVacaciones.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {

        $permisosVacaciones = DB::select("select * from permisos_vacaciones pv 
            join users u on u.id=pv.usuid 
                        WHERE pv.pmid=".$id);

        return view('permisos_vacaciones.show')
        ->with('permisosVacaciones', $permisosVacaciones)
        ;
    }

    /**
     * Show the form for editing the specified PermisosVacaciones.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $permisosVacaciones = $this->permisosVacacionesRepository->findWithoutFail($id);
        $usuarios = Usuarios::where('usu_estado', 0)->get()->pluck('full_name', 'id');
        if (empty($permisosVacaciones)) {
            Flash::error('Permisos Vacaciones not found');

            return redirect(route('permisosVacaciones.index'));
        }

        return view('permisos_vacaciones.edit')->with('permisosVacaciones', $permisosVacaciones)->with('usuarios',$usuarios);
    }

    /**
     * Update the specified PermisosVacaciones in storage.
     *
     * @param  int              $id
     * @param UpdatePermisosVacacionesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePermisosVacacionesRequest $request)
    {
        $permisosVacaciones = $this->permisosVacacionesRepository->findWithoutFail($id);

        if (empty($permisosVacaciones)) {
            Flash::error('Permisos Vacaciones not found');

            return redirect(route('permisosVacaciones.index'));
        }

        $permisosVacaciones = $this->permisosVacacionesRepository->update($request->all(), $id);

        Flash::success('Permisos Vacaciones updated successfully.');

        return redirect(route('permisosVacaciones.index'));
    }

    /**
     * Remove the specified PermisosVacaciones from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $permisosVacaciones = $this->permisosVacacionesRepository->findWithoutFail($id);

        if (empty($permisosVacaciones)) {
            Flash::error('Permisos Vacaciones not found');

            return redirect(route('permisosVacaciones.index'));
        }

        $this->permisosVacacionesRepository->delete($id);

        Flash::success('Permisos Vacaciones deleted successfully.');

        return redirect(route('permisosVacaciones.index'));
    }
}
