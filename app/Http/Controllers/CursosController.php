<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCursosRequest;
use App\Http\Requests\UpdateCursosRequest;
use App\Repositories\CursosRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\DB;
use Response;
use App\Models\Auditoria;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Session;

class CursosController extends AppBaseController {

    private $cursosRepository;
    private $anl;
    public function __construct(CursosRepository $cursosRepo) {
        $this->anl = Session::get('anl_id');
        $this->cursosRepository = $cursosRepo;
    }
    public function index(Request $request) {
        $this->cursosRepository->pushCriteria(new RequestCriteria($request));
        $op = $request->all();
        if (count($op) == 0) {
            $cursos = DB::select("select * from cursos order by id");
            return view('cursos.index')
                            ->with('cursos', $cursos)
                            ->with('op', 0)
            ;
        } elseif ($op['op'] == 1) {
            $cursos = $this->cursosRepository->all();
            return view('cursos.index')
                            ->with('cursos', $cursos)
                            ->with('op',1)
            ;
        }
    }

    /**
     * Show the form for creating a new Cursos.
     *
     * @return Response
     */
    public function create() {
        return view('cursos.create');
    }

    /**
     * Store a newly created Cursos in storage.
     *
     * @param CreateCursosRequest $request
     *
     * @return Response
     */
    public function store(CreateCursosRequest $request) {
        $input = $request->all();

        $cursos = $this->cursosRepository->create($input);
                 $aud= new Auditoria();
                 $data=["mod"=>"Cursos","acc"=>"Insertar","dat"=>$cursos,"doc"=>"NA"];
                 $aud->save_adt($data);        

        Flash::success('Curso Guardado Correctamente.');

        return redirect(route('cursos.index'));
    }

    /**
     * Display the specified Cursos.
     *
     * @param  int $id
     *
     * @return Response
     */

public function dirigentes_asignados($id,$p,$j,$tp){

        if($d=DB::select("select a.dirid,u.usu_apellidos ||' '|| u.name as usuario 
            from asg_dirigentes a 
            join users u on a.usu_id=u.id 
            where cur_id=$id 
            and a.tipo=$tp
            and par_id='$p'  
            and jor_id=$j
            and anl_id=".$this->anl."  ORDER BY a.dirid  "))
        {
            $dt[0]=$d[0]->dirid;
            $dt[1]=$d[0]->usuario; 
        }else{ 
            $dt[0]=0;
            $dt[1]=""; 
        }

        return $dt;


}

    public function show($curid) {
$data=explode("&",$curid);
$id=$data[0];
$tp=$data[1];
        $cursos = $this->cursosRepository->findWithoutFail($id);
        $users = Usuarios::where('usu_estado','0')->get();

    ///**A***////
            $p='A';
            $d=$this->dirigentes_asignados($id,$p,1,$tp);
            $dt['idm'.$p]=$d[0];$dt['um'.$p]=$d[1]; //ID de la asisganacion y el nombre del asignado
            $d=$this->dirigentes_asignados($id,$p,4,$tp);
            $dt['idv'.$p]=$d[0];$dt['uv'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,2,$tp);
            $dt['idn'.$p]=$d[0];$dt['un'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,3,$tp);
            $dt['ids'.$p]=$d[0];$dt['us'.$p]=$d[1]; 

            $p='B';
            $d=$this->dirigentes_asignados($id,$p,1,$tp);
            $dt['idm'.$p]=$d[0];$dt['um'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,4,$tp);
            $dt['idv'.$p]=$d[0];$dt['uv'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,2,$tp);
            $dt['idn'.$p]=$d[0];$dt['un'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,3,$tp);
            $dt['ids'.$p]=$d[0];$dt['us'.$p]=$d[1]; 

            $p='C';
            $d=$this->dirigentes_asignados($id,$p,1,$tp);
            $dt['idm'.$p]=$d[0];$dt['um'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,4,$tp);
            $dt['idv'.$p]=$d[0];$dt['uv'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,2,$tp);
            $dt['idn'.$p]=$d[0];$dt['un'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,3,$tp);
            $dt['ids'.$p]=$d[0];$dt['us'.$p]=$d[1]; 

            $p='D';
            $d=$this->dirigentes_asignados($id,$p,1,$tp);
            $dt['idm'.$p]=$d[0];$dt['um'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,4,$tp);
            $dt['idv'.$p]=$d[0];$dt['uv'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,2,$tp);
            $dt['idn'.$p]=$d[0];$dt['un'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,3,$tp);
            $dt['ids'.$p]=$d[0];$dt['us'.$p]=$d[1]; 

            $p='E';
            $d=$this->dirigentes_asignados($id,$p,1,$tp);
            $dt['idm'.$p]=$d[0];$dt['um'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,4,$tp);
            $dt['idv'.$p]=$d[0];$dt['uv'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,2,$tp);
            $dt['idn'.$p]=$d[0];$dt['un'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,3,$tp);
            $dt['ids'.$p]=$d[0];$dt['us'.$p]=$d[1]; 

            $p='F';
            $d=$this->dirigentes_asignados($id,$p,1,$tp);
            $dt['idm'.$p]=$d[0];$dt['um'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,4,$tp);
            $dt['idv'.$p]=$d[0];$dt['uv'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,2,$tp);
            $dt['idn'.$p]=$d[0];$dt['un'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,3,$tp);
            $dt['ids'.$p]=$d[0];$dt['us'.$p]=$d[1]; 

            $p='G';
            $d=$this->dirigentes_asignados($id,$p,1,$tp);
            $dt['idm'.$p]=$d[0];$dt['um'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,4,$tp);
            $dt['idv'.$p]=$d[0];$dt['uv'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,2,$tp);
            $dt['idn'.$p]=$d[0];$dt['un'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,3,$tp);
            $dt['ids'.$p]=$d[0];$dt['us'.$p]=$d[1]; 

            $p='H';
            $d=$this->dirigentes_asignados($id,$p,1,$tp);
            $dt['idm'.$p]=$d[0];$dt['um'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,4,$tp);
            $dt['idv'.$p]=$d[0];$dt['uv'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,2,$tp);
            $dt['idn'.$p]=$d[0];$dt['un'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,3,$tp);
            $dt['ids'.$p]=$d[0];$dt['us'.$p]=$d[1]; 

//BASICA Y BGU
            $p='ABS';
            $d=$this->dirigentes_asignados($id,$p,2,$tp);
            $dt['idn'.$p]=$d[0];$dt['un'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,3,$tp);
            $dt['ids'.$p]=$d[0];$dt['us'.$p]=$d[1]; 
            $p='BBS';
            $d=$this->dirigentes_asignados($id,$p,2,$tp);
            $dt['idn'.$p]=$d[0];$dt['un'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,3,$tp);
            $dt['ids'.$p]=$d[0];$dt['us'.$p]=$d[1]; 
            $p='CBS';
            $d=$this->dirigentes_asignados($id,$p,2,$tp);
            $dt['idn'.$p]=$d[0];$dt['un'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,3,$tp);
            $dt['ids'.$p]=$d[0];$dt['us'.$p]=$d[1]; 

            $p='ABG';
            $d=$this->dirigentes_asignados($id,$p,2,$tp);
            $dt['idn'.$p]=$d[0];$dt['un'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,3,$tp);
            $dt['ids'.$p]=$d[0];$dt['us'.$p]=$d[1]; 
            $p='BBG';
            $d=$this->dirigentes_asignados($id,$p,2,$tp);
            $dt['idn'.$p]=$d[0];$dt['un'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,3,$tp);
            $dt['ids'.$p]=$d[0];$dt['us'.$p]=$d[1]; 
            $p='CBG';
            $d=$this->dirigentes_asignados($id,$p,2,$tp);
            $dt['idn'.$p]=$d[0];$dt['un'.$p]=$d[1]; 
            $d=$this->dirigentes_asignados($id,$p,3,$tp);
            $dt['ids'.$p]=$d[0];$dt['us'.$p]=$d[1]; 

        return view('cursos.show')
        ->with('cursos', $cursos)
        ->with('dt', $dt)
        ->with('users', $users)
        ->with('tp', $tp)
        ;
    }

    /**
     * Show the form for editing the specified Cursos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id) {
        $cursos = $this->cursosRepository->findWithoutFail($id);

        if (empty($cursos)) {
            Flash::error('Cursos not found');

            return redirect(route('cursos.index'));
        }

        return view('cursos.edit')->with('cursos', $cursos);
    }

    /**
     * Update the specified Cursos in storage.
     *
     * @param  int              $id
     * @param UpdateCursosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCursosRequest $request) {
        $cursos = $this->cursosRepository->findWithoutFail($id);

        if (empty($cursos)) {
            Flash::error('Cursos not found');

            return redirect(route('cursos.index'));
        }

        $cursos = $this->cursosRepository->update($request->all(), $id);
                 $aud= new Auditoria();
                 $data=["mod"=>"Cursos","acc"=>"Update","dat"=>$cursos,"doc"=>"NA"];
                 $aud->save_adt($data);        

        Flash::success('Curso Editado Correctamente.');

        return redirect(route('cursos.index'));
    }

    /**
     * Remove the specified Cursos from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id) {
        $cursos = $this->cursosRepository->findWithoutFail($id);

        if (empty($cursos)) {
            Flash::error('Cursos not found');

            return redirect(route('cursos.index'));
        }

        $this->cursosRepository->delete($id);
                 $aud= new Auditoria();
                 $data=["mod"=>"Cursos","acc"=>"Eliminar","dat"=>$cursos,"doc"=>"NA"];
                 $aud->save_adt($data);        

        Flash::success('Curso Eliminado Correctamente.');

        return redirect(route('cursos.index'));
    }


    public function asg_dirgente(Request $req){
        $anl=$this->anl;
        $cur=$req->all()['cur'];
        $par=$req->all()['par'];
        $dirid=$req->all()['dirid'];
        $jor=$req->all()['jor'];
        $tp=$req->all()['tp'];
        $usu=$req->all()['usu'];

       if($usu==0){
            if($dirid>0){
                DB::select("DELETE FROM asg_dirigentes WHERE anl_id=$anl and cur_id=$cur and par_id='$par' and jor_id=$jor and  tipo=$tp  " );
            }
            return 0;
       }else{
            if($dirid>0){
                DB::select("DELETE FROM asg_dirigentes WHERE anl_id=$anl and cur_id=$cur and par_id='$par' and jor_id=$jor and  tipo=$tp  " );
            }
            $usr=DB::select("INSERT INTO asg_dirigentes (anl_id,usu_id,cur_id,par_id,jor_id,tipo)
                VALUES($anl,$usu,$cur,'$par',$jor,$tp) RETURNING dirid ");
            return Response()->json($usr[0]->dirid);
       }


    }

}
