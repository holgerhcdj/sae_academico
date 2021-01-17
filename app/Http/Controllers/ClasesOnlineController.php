<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClasesOnlineRequest;
use App\Http\Requests\UpdateClasesOnlineRequest;
use App\Repositories\ClasesOnlineRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Materias;
use App\Models\Cursos;
use App\Models\Especialidades;
use DB;
use Auth;

class ClasesOnlineController extends AppBaseController
{
    /** @var  ClasesOnlineRepository */
    private $clasesOnlineRepository;

    public function __construct(ClasesOnlineRepository $clasesOnlineRepo)
    {
        $this->clasesOnlineRepository = $clasesOnlineRepo;
    }

    /**
     * Display a listing of the ClasesOnline.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $usr=Auth::user()->id;
            $clasesOnlines=DB::select("SELECT * FROM clases_online co join users u on co.usu_id=u.id join materias m on co.mtr_id=m.id where u.id=$usr");
        if($usr==1 || $usr==22 || $usr==54 || $usr==93){
            $clasesOnlines=DB::select("SELECT * FROM clases_online co join users u on co.usu_id=u.id join materias m on co.mtr_id=m.id");
        }
        return view('clases_onlines.index')
            ->with('clasesOnlines', $clasesOnlines);
    }

    /**
     * Show the form for creating a new ClasesOnline.
     *
     * @return Response
     */
    public function create()
    {
        $usr=Auth::user();
        $mtr=Materias::where('mtr_tipo','0')
        ->where('id','<>',3)
        ->where('id','<>',2)
        ->orderBy('mtr_descripcion','ASc')
        ->pluck('mtr_descripcion','id')
        ;
        $cur=Cursos::all();

        return view('clases_onlines.create')
        ->with('mtr',$mtr)
        ->with('cur',$cur)
        ->with('usr',$usr)
        ;
    }

    /**
     * Store a newly created ClasesOnline in storage.
     *
     * @param CreateClasesOnlineRequest $request
     *
     * @return Response
     */
    public function store(CreateClasesOnlineRequest $request)
    {
        $input = $request->all();

        $clasesOnline = $this->clasesOnlineRepository->create($input);

        Flash::success('Clases Online saved successfully.');

        return redirect(route('clasesOnlines.index'));
    }

    /**
     * Display the specified ClasesOnline.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $clasesOnline = $this->clasesOnlineRepository->findWithoutFail($id);

        if (empty($clasesOnline)) {
            Flash::error('Clases Online not found');

            return redirect(route('clasesOnlines.index'));
        }

        return view('clases_onlines.show')->with('clasesOnline', $clasesOnline);
    }

    /**
     * Show the form for editing the specified ClasesOnline.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $clasesOnline = $this->clasesOnlineRepository->findWithoutFail($id);

        if (empty($clasesOnline)) {
            Flash::error('Clases Online not found');

            return redirect(route('clasesOnlines.index'));
        }



        $usr=Auth::user();
        $mtr=Materias::where('mtr_tipo','0')
        ->where('id','<>',3)
        ->where('id','<>',2)
        ->orderBy('mtr_descripcion','ASc')
        ->pluck('mtr_descripcion','id')
        ;
        $cur=Cursos::all();

        return view('clases_onlines.edit')
        ->with('mtr',$mtr)
        ->with('cur',$cur)
        ->with('usr',$usr)
        ->with('clasesOnline', $clasesOnline)
        ;
    }

    /**
     * Update the specified ClasesOnline in storage.
     *
     * @param  int              $id
     * @param UpdateClasesOnlineRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateClasesOnlineRequest $request)
    {
        $clasesOnline = $this->clasesOnlineRepository->findWithoutFail($id);

        if (empty($clasesOnline)) {
            Flash::error('Clases Online not found');

            return redirect(route('clasesOnlines.index'));
        }

        $clasesOnline = $this->clasesOnlineRepository->update($request->all(), $id);

        Flash::success('Clases Online updated successfully.');

        return redirect(route('clasesOnlines.index'));
    }

    /**
     * Remove the specified ClasesOnline from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $clasesOnline = $this->clasesOnlineRepository->findWithoutFail($id);

        if (empty($clasesOnline)) {
            Flash::error('Clases Online not found');

            return redirect(route('clasesOnlines.index'));
        }

        $this->clasesOnlineRepository->delete($id);

        Flash::success('Clases Online deleted successfully.');

        return redirect(route('clasesOnlines.index'));
    }
}
