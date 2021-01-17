<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUsuariosRequest;
use App\Http\Requests\UpdateUsuariosRequest;
use App\Repositories\UsuariosRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Usuarios;
use App\Models\Especialidades;
use App\Models\Departamentos;
use App\Models\Auditoria;
use Auth;

class UsuariosController extends AppBaseController {

    /** @var  UsuariosRepository */
    private $usuariosRepository;

    public function __construct(UsuariosRepository $usuariosRepo) {
        $this->usuariosRepository = $usuariosRepo;
//        $this->middleware('guest')->except('logout');
    }

    /**
     * Display a listing of the Usuarios.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) {
        $dat=$request->all();
            if(isset($dat['usu_estado'])){
                $est=$dat['usu_estado'];
            }else{
                $est=0;
            }

            $users=DB::select("SELECT u.*,d.descripcion,g.* FROM users u 
                JOIN departamentos d ON u.usu_perfil=d.id
                JOIN erp_gerencia g ON d.ger_id=g.ger_id
                WHERE u.usu_estado=$est
                ORDER By u.usu_apellidos ASC
                ");

         $prm=Auth::user()->AsignaPermisos->where('mod_id',7)->first();
         $pr=explode('&',$prm->permisos_especiales);
         $departamentos =DB::select("SELECT d.id,concat(g.ger_codigo,' / ',d.descripcion) as departamento from departamentos d join erp_gerencia g on d.ger_id=g.ger_id order By g.ger_descripcion,d.descripcion ");
         //dd($pr);//1->Agregar,2->Editar,3->Cambiar Clave,3->Asignar Horario,4->Asignar Cursos,5->ërmisos,6->Ver
        return view('usuarios.index')
        ->with('usuarios',$users)
        ->with('pr',$pr)
        ->with('dep',$departamentos)
        ;

    }

    /**
     * Show the form for creating a new Usuarios.
     *
     * @return Response
     */
    public function create() {
        $especialidades = Especialidades::where('id', '<>', 7)->where('id', '<>', 8)->orderBy('esp_descripcion','ASC')->pluck('esp_descripcion', 'id');
        $departamentos =Departamentos::orderBy('descripcion','ASC')->pluck('descripcion', 'id');
        return view('usuarios.create')->with("especialidades",$especialidades)->with('departamentos',$departamentos);
    }

    /**
     * Store a newly created Usuarios in storage.
     *
     * @param CreateUsuariosRequest $request
     *
     * @return Response
     */
    public function store(CreateUsuariosRequest $request) {
        $input = $request->all();
//        dd($input);
        $input['password'] = bcrypt($request['password']);
        if(isset($input['jor1'])){
                $input['jor1']=1;
        }else{
                $input['jor1']=0;
        }
        if(isset($input['jor2'])){
                $input['jor2']=1;
        }else{
                $input['jor2']=0;
        }
        if(isset($input['jor3'])){
                $input['jor3']=1;
        }else{
                $input['jor3']=0;
        }
        if(isset($input['jor4'])){
                $input['jor4']=1;
        }else{
                $input['jor4']=0;
        }
        
       $rules = array(
            'email' => 'required|unique:users,email',
        );

        $v = Validator::make($input, $rules);
        if ($v->fails()) {
            Flash::error("Este Correo Electronico ya esta registrado por otro usuario");
            return $this->create();
        } else {
            $usuarios = $this->usuariosRepository->create($input);
                $prm=DB::select("select * from asg_perfil_departamentos where dep_id=$input[usu_perfil]"); 
                foreach ($prm as $p){
                    $this->asigna_nuevos_permisos($usuarios->id,$p);
                }
                 $aud= new Auditoria();
                 $data=["mod"=>"Usuarios","acc"=>"insertar","dat"=>$usuarios,"doc"=>"NA"];
                 $aud->save_adt($data);        
            Flash::success('Usuarios saved successfully.');
            return redirect(route('usuarios.index'));
        }


    }

    /**
     * Display the specified Usuarios.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id) {

        $usuarios = DB::select("select u.id,u.name,u.usu_apellidos,d.descripcion,u.username,u.usu_foto from users u
            join departamentos d on u.usu_perfil=d.id
            and u.id=$id");
        $permisos = DB::select("select a.*,m.menu,m.submenu from asg_permisos a, modulos m, users u
                                where a.mod_id=m.id
                                and   a.usu_id=u.id
                                and   a.usu_id=$id 
                                order by a.grupo,mod_id ");
        $modulos = DB::select(" select * from modulos m where not exists(
            select * from asg_permisos a where m.id=a.mod_id
            and usu_id=$id) 
            order by menu,submenu ");


        return view('usuarios.show')
                        ->with('usuarios', $usuarios[0])
                        ->with('permisos', $permisos)
                        ->with('modulos', $modulos)
                        ;
    }

    /**
     * Show the form for editing the specified Usuarios.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id, Request $req) {

        $usuarios = $this->usuariosRepository->findWithoutFail($id);
        if (empty($usuarios)) {
            Flash::error('Usuarios not found');
            return redirect(route('usuarios.index'));
        }
        $departamentos =Departamentos::orderBy('descripcion','ASC')->pluck('descripcion', 'id');        
        $especialidades = Especialidades::where('id', '<>', 7)->where('id', '<>', 8)->orderBy('esp_descripcion', 'ASC')->pluck('esp_descripcion', 'id');
        return view('usuarios.edit')
                        ->with('usuarios', $usuarios)
                        ->with("especialidades",$especialidades)
                        ->with('departamentos',$departamentos)
                        ->with('op', $req['op'])
                        ;


    }

    /**
     * Update the specified Usuarios in storage.
     *
     * @param  int              $id
     * @param UpdateUsuariosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUsuariosRequest $request) {
        $dat = $request->all();
        $datos = [];
        $usuarios = $this->usuariosRepository->findWithoutFail($id);
        if (empty($usuarios)) {
            Flash::error('Usuarios not found');
            return redirect(route('usuarios.index'));
        }
        if ($dat['op'] == 2) {

            $datos['password'] = bcrypt($dat['password']);
            $usuarios = $this->usuariosRepository->update($datos, $id);
            Flash::success('Clave cambiada correctamente');
            return $this->edit($id, $request);

        } else {
            
        if(isset($dat['jor1'])){
                $dat['jor1']=1;
        }else{
                $dat['jor1']=0;
        }
        if(isset($dat['jor2'])){
                $dat['jor2']=1;
        }else{
                $dat['jor2']=0;
        }
        if(isset($dat['jor3'])){
                $dat['jor3']=1;
        }else{
                $dat['jor3']=0;
        }
        if(isset($dat['jor4'])){
                $dat['jor4']=1;
        }else{
                $dat['jor4']=0;
        }
            $usuarios = $this->usuariosRepository->update($dat, $id);
            if($dat['cambia_perfil']==1){
                $prm=DB::select("select * from asg_perfil_departamentos where dep_id=$dat[usu_perfil]"); 
                $this->elimina_permisos_usuario($id);
                foreach ($prm as $p){
                    $this->asigna_nuevos_permisos($id,$p);
                }
            }
            $aud= new Auditoria();
                 $data=["mod"=>"Usuarios","acc"=>"Modificar","dat"=>$usuarios,"doc"=>"NA"];
                 $aud->save_adt($data);        
            Flash::success('Actualización Correcta');
            return $this->edit($id, $request);
        }

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



    public function destroy($id) {
        $usuarios = $this->usuariosRepository->findWithoutFail($id);

        if (empty($usuarios)) {
            Flash::error('Usuarios not found');

            return redirect(route('usuarios.index'));
        }

        $this->usuariosRepository->delete($id);
                 $aud= new Auditoria();
                 $data=["mod"=>"Usuarios","acc"=>"Eliminar","dat"=>$usuarios,"doc"=>"NA"];
                 $aud->save_adt($data);        
        Flash::success('Usuarios deleted successfully.');

        return redirect(route('usuarios.index'));
    }


    public function dep_asignados(Request $rq){
        $id=$rq->all()['us'];

       $usuario=DB::select("SELECT * from users where id=$id");

       $asg_dep=DB::select("SELECT * FROM asg_users_departamentos ad 
        JOIN departamentos d ON ad.dep_id=d.id 
        JOIN erp_gerencia g ON g.ger_id=d.ger_id 
        WHERE ad.usu_id=$id ");
       $rst="";
       $x=0;
       foreach ($asg_dep as $d) {
        $x++;
           $rst.="
                    <div class='row'>
                        <div class='col-sm-2 cls_ids' data='$d->id' >$x</div>
                        <div class='col-sm-8'>$d->ger_codigo / $d->descripcion </div>
                        <div class='col-sm-2'> <i data='$d->aud_id' class='btn btn-danger fa fa-trash btn-xs btn_elimina_asg' ></i> </div>
                    </div>        
           ";
       }
       return Response()->json($rst);
    }

    public function asignar_departamento(Request $rq){
       $dt=$rq->all();
       $usu_id=$dt['us'];
       $dep_id=$dt['dp'];
       $rst="";
       try {
          $insert=DB::select("INSERT INTO asg_users_departamentos (usu_id,dep_id)values($usu_id,$dep_id) RETURNING aud_id ");
          $asg_dep=DB::select("SELECT * FROM asg_users_departamentos ad 
            JOIN departamentos d ON ad.dep_id=d.id 
            JOIN erp_gerencia g ON g.ger_id=d.ger_id 
            WHERE ad.aud_id=".$insert[0]->aud_id);
           $rst.="
                    <div class='row'>
                        <div class='col-sm-2 cls_ids' data='".$asg_dep[0]->id."' >--</div>
                        <div class='col-sm-8'> ".$asg_dep[0]->ger_codigo." / ".$asg_dep[0]->descripcion." </div>
                        <div class='col-sm-2'> <i data='".$asg_dep[0]->aud_id."' class='btn btn-danger fa fa-trash btn-xs btn_elimina_asg' ></i> </div>
                    </div>        
           ";
          return Response()->json($rst);
       } catch(\Illuminate\Database\QueryException $e){
        return Response()->json($e);
       }
    }

    public function elimina_asignar_departamento(Request $rq){
        $aud_id=$rq->all()['aud'];

        try {
            DB::select("DELETE from asg_users_departamentos where aud_id=$aud_id ");
            return 0;
        } catch(\Illuminate\Database\QueryException $e){
            return $e;
        }

    }

}
