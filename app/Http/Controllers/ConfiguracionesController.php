<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateConfiguracionesRequest;
use App\Http\Requests\UpdateConfiguracionesRequest;
use App\Repositories\ConfiguracionesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\DB;
use App\Models\Auditoria;

class ConfiguracionesController extends AppBaseController
{
    /** @var  ConfiguracionesRepository */
    private $configuracionesRepository;

    public function __construct(ConfiguracionesRepository $configuracionesRepo)
    {
        $this->configuracionesRepository = $configuracionesRepo;
    }

    public function index(Request $request)
    {
         $configuraciones = DB::select("select * from erp_configuraciones where tipo=1");
         return view('configuraciones.index')
             ->with('configuraciones', $configuraciones);
    }

    public function create()
    {

        return view('configuraciones.create');
    }

    public function store(CreateConfiguracionesRequest $request)
    {
        $input = $request->all();
        $configuraciones = $this->configuracionesRepository->create($input);
        $aud= new Auditoria();
                 $data=["mod"=>"Configuraciones","acc"=>"Crear","dat"=>$configuraciones,"doc"=>"NA"];
                 $aud->save_adt($data);
        Flash::success('Configuraciones saved successfully.');
        return redirect(route('configuraciones.index'));
    }

    public function show($id)
    {
        $configuraciones = $this->configuracionesRepository->findWithoutFail($id);

        if (empty($configuraciones)) {
            Flash::error('Configuraciones not found');

            return redirect(route('configuraciones.index'));
        }

        return view('configuraciones.show')->with('configuraciones', $configuraciones);
    }

    /**
     * Show the form for editing the specified Configuraciones.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $configuraciones = $this->configuracionesRepository->findWithoutFail($id);

        if (empty($configuraciones)) {
            Flash::error('Configuraciones not found');

            return redirect(route('configuraciones.index'));
        }

        return view('configuraciones.edit')->with('configuraciones', $configuraciones);
    }

    /**
     * Update the specified Configuraciones in storage.
     *
     * @param  int              $id
     * @param UpdateConfiguracionesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateConfiguracionesRequest $request)
    {
        $configuraciones = $this->configuracionesRepository->findWithoutFail($id);

        if (empty($configuraciones)) {
            Flash::error('Configuraciones not found');

            return redirect(route('configuraciones.index'));
        }

        $configuraciones = $this->configuracionesRepository->update($request->all(), $id);
        $aud= new Auditoria();
                 $data=["mod"=>"Configuraciones","acc"=>"Modificar","dat"=>$configuraciones,"doc"=>"NA"];
                 $aud->save_adt($data);

        Flash::success('Configuraciones updated successfully.');

        return redirect(route('configuraciones.index'));
    }

    /**
     * Remove the specified Configuraciones from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $configuraciones = $this->configuracionesRepository->findWithoutFail($id);

        if (empty($configuraciones)) {
            Flash::error('Configuraciones not found');

            return redirect(route('configuraciones.index'));
        }

        $this->configuracionesRepository->delete($id);
        $aud= new Auditoria();
                 $data=["mod"=>"Configuraciones","acc"=>"Eliminar","dat"=>$configuraciones,"doc"=>"NA"];
                 $aud->save_adt($data);

        Flash::success('Configuraciones deleted successfully.');

        return redirect(route('configuraciones.index'));
    }

    public function actualizar_perfiles(Request $req){
        $dep=$req->all()['dep'];
        $rst=DB::select("select * from users where usu_perfil=$dep"); 
        $prm=DB::select("select * from asg_perfil_departamentos where dep_id=$dep"); 
        foreach ($rst as $r) {
            $this->elimina_permisos_usuario($r->id);
            foreach ($prm as $p) {
                $this->asigna_nuevos_permisos($r->id,$p);
            }
        }
        return 0;
    }

    public function asigna_nuevos_permisos($us,$prm){
        DB::select("INSERT INTO asg_permisos(
            usu_id,
            mod_id,
            new,
            edit,
            del,
            show,
            grupo,
            especial,
            permisos_especiales)
            VALUES 
            ( $us,
            $prm->mod_id,
            $prm->new,
            $prm->edit,
            $prm->del,
            $prm->show,
            $prm->grupo,
            $prm->especial,
            null )
            ");
        return 0;
    }

    public function elimina_permisos_usuario($us){
        DB::select("delete from asg_permisos where usu_id=$us");
        return 0;
    }

///FACTURACION ELECTRÓNICA

    public function credenciales(){
        $gerencias=DB::select("SELECT * from erp_gerencia where ger_estado=0");
        return view('facturacion_electronica.credenciales')
        ->with('gerencias',$gerencias)
        ;
    }

    public function create_update_credenciales(Request $rq){
        $data=$rq->all();

        


    }



}
