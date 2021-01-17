<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDepartamentosRequest;
use App\Http\Requests\UpdateDepartamentosRequest;
use App\Repositories\DepartamentosRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Auditoria;
use Auth;
use DB;
use App\Models\Gerencias;
class DepartamentosController extends AppBaseController
{
    /** @var  DepartamentosRepository */
    private $departamentosRepository;

    public function __construct(DepartamentosRepository $departamentosRepo)
    {
        $this->departamentosRepository = $departamentosRepo;
    }

    /**
     * Display a listing of the Departamentos.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $departamentos = DB::select("SELECT * FROM departamentos d JOIN erp_gerencia g ON g.ger_id=d.ger_id ");

        return view('departamentos.index')
            ->with('departamentos', $departamentos);
    }

    /**
     * Show the form for creating a new Departamentos.
     *
     * @return Response
     */
    public function create()
    {
        $ger=Gerencias::pluck("ger_descripcion","ger_id");
        return view('departamentos.create')
        ->with("ger",$ger)
        ;
    }

    /**
     * Store a newly created Departamentos in storage.
     *
     * @param CreateDepartamentosRequest $request
     *
     * @return Response
     */
    public function store(CreateDepartamentosRequest $request)
    {
        $input = $request->all();
        if(isset($input['departamento_id'])){
            $dep_id=$input['departamento_id'];
            $mod_id=$input['mod_id'];
            $md=DB::select("select * from modulos where id=$mod_id ");
            $grupo=$md[0]->mod_grupo;
            //$permisos_especiales=null;
            $new=0;
            $edit=0;
            $del=0;
            $show=0;
            $especial=0;

            if(isset($input['new'])){
                $new=$input['new'];
            }
            if(isset($input['edit'])){
                $edit=$input['edit'];
            }
            if(isset($input['del'])){
                $del=$input['del'];
            }
            if(isset($input['show'])){
                $show=$input['show'];
            }
            if(isset($input['especial'])){
                $especial=$input['especial'];
            }

            DB::select("INSERT INTO asg_perfil_departamentos(
            dep_id,
            mod_id,
            new,
            edit,
            del,
            show,
            grupo,
            especial,
            permisos_especiales)
            VALUES 
            ( $dep_id,
            $mod_id,
            $new,
            $edit,
            $del,
            $show,
            $grupo,
            $especial,
            null )
            ");

             $aud= new Auditoria();
             $data=["mod"=>"Departamentos","acc"=>"Insertar","dat"=>$dep_id.'-'.$mod_id.'-'.$new.'-'.$edit.'-'.$del.'-'.$show.'-'.$grupo.'-'.$especial,"doc"=>"NA"];
             $aud->save_adt($data);        
            return redirect(route('departamentos.show',$dep_id));

        }else{
            $departamentos = $this->departamentosRepository->create($input);
            $aud= new Auditoria();
            $data=["mod"=>"Departamentos","acc"=>"Insertar","dat"=>$departamentos,"doc"=>"NA"];
            $aud->save_adt($data);        
            return redirect(route('departamentos.index'));
        }

    }

    /**
     * Display the specified Departamentos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $departamentos = $this->departamentosRepository->findWithoutFail($id);//Todos los modulos menos los usuarios
        $modulos = DB::select(" select * from modulos m where not exists(
            select * from asg_perfil_departamentos a 
            where m.id=a.mod_id
            and a.dep_id=$id)
            and m.id<>7 
            order by m.menu,m.submenu ");
        $permisos = DB::select("select a.*,m.menu,m.submenu from asg_perfil_departamentos a, modulos m
                                where a.mod_id=m.id
                                and   a.dep_id=$id 
                                order by a.grupo,mod_id ");        
        $pas=DB::select("select con_valor2 from erp_configuraciones where con_id=24");        //Recuperamos la clave de la configuracion
        return view('departamentos.show')
        ->with('modulos', $modulos)
        ->with('permisos', $permisos)
        ->with('departamentos', $departamentos)
        ->with('pas', $pas[0]->con_valor2)
        ;

    }

    /**
     * Show the form for editing the specified Departamentos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $departamentos = $this->departamentosRepository->findWithoutFail($id);

        if (empty($departamentos)) {
            Flash::error('Departamentos not found');

            return redirect(route('departamentos.index'));
        }
        $ger=Gerencias::pluck("ger_descripcion","ger_id");
        return view('departamentos.edit')
        ->with('ger', $ger)
        ->with('departamentos', $departamentos)
        ;
    }

    /**
     * Update the specified Departamentos in storage.
     *
     * @param  int              $id
     * @param UpdateDepartamentosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDepartamentosRequest $request)
    {

//dd($request->all());

        $departamentos = $this->departamentosRepository->findWithoutFail($id);
        if (empty($departamentos)) {
            Flash::error('Departamentos not found');
            return redirect(route('departamentos.index'));
        }
        $departamentos = $this->departamentosRepository->update($request->all(), $id);
                 $aud= new Auditoria();
                 $data=["mod"=>"Departamentos","acc"=>"Modificar","dat"=>$departamentos,"doc"=>"NA"];
                 $aud->save_adt($data);        
        Flash::success('Departamentos updated successfully.');
        return redirect(route('departamentos.index'));
    }

    /**
     * Remove the specified Departamentos from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //dd($id);
        $asg=DB::select("select * from asg_perfil_departamentos where id=$id");
        DB::select("delete from asg_perfil_departamentos where id=$id");
                  $aud= new Auditoria();
                  $data=["mod"=>"Departamentos","acc"=>"Eliminar","dat"=>$asg[0]->dep_id.'-'.$asg[0]->mod_id.'-'.$asg[0]->new.'-'.$asg[0]->edit.'-'.$asg[0]->del.'-'.$asg[0]->show.'-'.$asg[0]->grupo.'-'.$asg[0]->especial,"doc"=>"NA"];
                  $aud->save_adt($data);        
        return redirect(route('departamentos.show',$asg[0]->dep_id));
    }
}
