<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAuditoriaRequest;
use App\Http\Requests\UpdateAuditoriaRequest;
use App\Repositories\AuditoriaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\DB;
use Response;
use App\Models\Usuarios;

class AuditoriaController extends AppBaseController
{
    /** @var  AuditoriaRepository */
    private $auditoriaRepository;
    public function __construct(AuditoriaRepository $auditoriaRepo)
    {
        $this->auditoriaRepository = $auditoriaRepo;
    }

    public function cmb_usuarios(){
        $users=Usuarios::orderBy("username","ASC")->pluck("username","id");
        $users->put('0','Todos los Usuarios');
        return $users;

    }


    public function index(Request $request)
    {
        $from=date('Y-m-d');
        $to=date('Y-m-d');
        $auditorias = DB::select("select * from erp_auditoria where adt_date between '$from' and '$to' ");
        $usuarios=$this->cmb_usuarios();
        return view('auditorias.index')
            ->with('auditorias', $auditorias)
            ->with('usuarios', $usuarios)
            ;

    }


    public function adt_search(Request $request)
    
    {
        dd('ok');
        $from=$request->all()['from'];
        $to=$request->all()['to'];
        $usuarios=$this->cmb_usuarios();
        $auditorias = DB::select("select * from erp_auditoria where adt_date between '$from' and '$to' 
            and usu_login=''
            ");
        
        return view('auditorias.index')
            ->with('auditorias', $auditorias)->with('usuarios', $usuarios);

    }    

    /**
     * Show the form for creating a new Auditoria.
     *
     * @return Response
     */
    public function create()
    {
        return view('auditorias.create');
    }

    /**
     * Store a newly created Auditoria in storage.
     *
     * @param CreateAuditoriaRequest $request
     *
     * @return Response
     */
    public function store(CreateAuditoriaRequest $request)
    {
        $input = $request->all();

        $auditoria = $this->auditoriaRepository->create($input);

        Flash::success('Auditoria saved successfully.');

        return redirect(route('auditorias.index'));
    }

    /**
     * Display the specified Auditoria.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $auditoria = $this->auditoriaRepository->findWithoutFail($id);
        if (empty($auditoria)) {
            Flash::error('Auditoria not found');
            return redirect(route('auditorias.index'));
        }
        return view('auditorias.show')->with('auditoria', $auditoria);
    }

    /**
     * Show the form for editing the specified Auditoria.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $auditoria = $this->auditoriaRepository->findWithoutFail($id);
        if (empty($auditoria)) {
            Flash::error('Auditoria not found');
            return redirect(route('auditorias.index'));
        }

        $auditoria=DB::select("");

        return view('auditorias.edit')->with('auditoria', $auditoria);
    }

    /**
     * Update the specified Auditoria in storage.
     *
     * @param  int              $id
     * @param UpdateAuditoriaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAuditoriaRequest $request)
    {
        $auditoria = $this->auditoriaRepository->findWithoutFail($id);

        if (empty($auditoria)) {
            Flash::error('Auditoria not found');

            return redirect(route('auditorias.index'));
        }

        $auditoria = $this->auditoriaRepository->update($request->all(), $id);

        Flash::success('Auditoria updated successfully.');

        return redirect(route('auditorias.index'));
    }

    /**
     * Remove the specified Auditoria from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $auditoria = $this->auditoriaRepository->findWithoutFail($id);

        if (empty($auditoria)) {
            Flash::error('Auditoria not found');

            return redirect(route('auditorias.index'));
        }

        $this->auditoriaRepository->delete($id);

        Flash::success('Auditoria deleted successfully.');

        return redirect(route('auditorias.index'));
    }
}
