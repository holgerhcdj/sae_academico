<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRegistroAsistenciaRequest;
use App\Http\Requests\UpdateRegistroAsistenciaRequest;
use App\Repositories\RegistroAsistenciaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegistroAsistenciaController extends AppBaseController
{
    /** @var  RegistroAsistenciaRepository */
    private $registroAsistenciaRepository;

    public function __construct(RegistroAsistenciaRepository $registroAsistenciaRepo)
    {
        $this->registroAsistenciaRepository = $registroAsistenciaRepo;
    }

    /**
     * Display a listing of the RegistroAsistencia.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $dat=$request->all();
        $registroAsistencias=[];
         if(isset($dat['btn_buscar'])){
        $d=$dat['desde'];
        $h=$dat['hasta'];
        $registroAsistencias = DB::select("select t.*,u.usu_apellidos,u.name from timbradas t 
            left join users u on u.codigo=t.codigo
            where t.fecha between '$d' and '$h' 
            order by u.usu_apellidos 
            ");
            //$registroAsistencias = DB::select("select * from users order by usu_apellidos");
         }
         return view('registro_asistencias.index')
                ->with('registroAsistencias', $registroAsistencias);
        
    }

    /**
     * Show the form for creating a new RegistroAsistencia.
     *
     * @return Response
     */
    public function create()
    {
        return view('registro_asistencias.create');
    }

    /**
     * Store a newly created RegistroAsistencia in storage.
     *
     * @param CreateRegistroAsistenciaRequest $request
     *
     * @return Response
     */
    public function store(CreateRegistroAsistenciaRequest $request)
    {
        $usu = Auth::user();
       $input = $request->all();
       if($request->hasFile('archivo')){
        $file=$request->file('archivo');
        $name=date('his').'-timb.'.$file->getClientOriginalExtension();
        $file->move(public_path().'/timbradas/',$name);
       }
        $archivo = fopen('timbradas/'.$name, "r");
        $c=0;
        while (($datos = fgetcsv($archivo, ",")) == true) 
        {
            if($c>0 && !empty($datos[0])){
                     $input['codigo']=$datos[0];
                     $tm=explode(" ",$datos[2]);
                     $f=explode("/",$tm[0]);
                     $fecha=$f[2]."-".$f[1]."-".$f[0];
                     $input['fecha']=$fecha;
                     $input['hora']=$tm[1];
                     $input['tipo']=0;
                     $input['motivo']=null;
                     $input['responsable']=$usu->usu_apellidos.' '.$usu->name;
                     $input['estado']=0;
                     if(!$tmb=DB::select("select * from timbradas where codigo=$datos[0] and fecha='$fecha' and hora='$tm[1]' ")){
                        $this->registroAsistenciaRepository->create($input);
                     }
            }
            $c++;
        }
        fclose($archivo);

        return redirect(route('registroAsistencias.index'));



    }

    /**
     * Display the specified RegistroAsistencia.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $registroAsistencia = $this->registroAsistenciaRepository->findWithoutFail($id);

        if (empty($registroAsistencia)) {
            Flash::error('Registro Asistencia not found');
            return redirect(route('registroAsistencias.index'));
        }

        return view('registro_asistencias.show')->with('registroAsistencia', $registroAsistencia);
    }

    /**
     * Show the form for editing the specified RegistroAsistencia.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $registroAsistencia = $this->registroAsistenciaRepository->findWithoutFail($id);

        if (empty($registroAsistencia)) {
            Flash::error('Registro Asistencia not found');

            return redirect(route('registroAsistencias.index'));
        }

        return view('registro_asistencias.edit')->with('registroAsistencia', $registroAsistencia);
    }

    /**
     * Update the specified RegistroAsistencia in storage.
     *
     * @param  int              $id
     * @param UpdateRegistroAsistenciaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRegistroAsistenciaRequest $request)
    {
        $registroAsistencia = $this->registroAsistenciaRepository->findWithoutFail($id);

        if (empty($registroAsistencia)) {
            Flash::error('Registro Asistencia not found');

            return redirect(route('registroAsistencias.index'));
        }

        $registroAsistencia = $this->registroAsistenciaRepository->update($request->all(), $id);

        Flash::success('Registro Asistencia updated successfully.');

        return redirect(route('registroAsistencias.index'));
    }

    /**
     * Remove the specified RegistroAsistencia from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $registroAsistencia = $this->registroAsistenciaRepository->findWithoutFail($id);

        if (empty($registroAsistencia)) {
            Flash::error('Registro Asistencia not found');

            return redirect(route('registroAsistencias.index'));
        }

        $this->registroAsistenciaRepository->delete($id);

        Flash::success('Registro Asistencia deleted successfully.');

        return redirect(route('registroAsistencias.index'));
    }
}
