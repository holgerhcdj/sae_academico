<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdminNotasRequest;
use App\Http\Requests\UpdateAdminNotasRequest;
use App\Repositories\AdminNotasRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Jornadas;
use App\Models\Cursos;
use App\Models\Especialidades;
use App\Models\Materias;
use App\Models\Auditoria;
use App\Models\Usuarios;
use App\Models\Insumos;
use Illuminate\Support\Facades\DB;

class AdminNotasController extends AppBaseController
{
    /** @var  AdminNotasRepository */
    private $adminNotasRepository;

    public function __construct(AdminNotasRepository $adminNotasRepo)
    {
        $this->adminNotasRepository = $adminNotasRepo;
    }

    /**
     * Display a listing of the AdminNotas.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $f=date('Y-m-d');

        $adminNotas = DB::select("select  u.name,
u.usu_apellidos,
j.jor_descripcion,
es.esp_descripcion,
c.cur_descripcion,
m.mtr_descripcion,
an.* 
from admin_notas an 
join users u on an.usu_id=u.id
left join jornadas j on j.id=an.jor_id
left join especialidades es on es.id=an.esp_id
left join cursos c on c.id=an.cur_id
left join materias m on m.id=an.mtr_id
left join users doc on doc.id=an.doc_id
where an.adm_ffinal>='$f'
order by an.adm_ffinal
");
        return view('admin_notas.index')
            ->with('adminNotas', $adminNotas);
    }

    /**
     * Show the form for creating a new AdminNotas.
     *
     * @return Response
     */
    public function create()
    {
        $jor=Jornadas::orderby('jor_descripcion','asc')->pluck('jor_descripcion','id');
        $cur=Cursos::orderby('cur_descripcion','asc')->pluck('cur_descripcion','id');
        $esp=[];

        $mtr=Materias::where('esp_id','10')
                       ->where('id','<>','3')
                       ->where('id','<>','1')
                       ->orderby('mtr_descripcion','asc')->pluck('mtr_descripcion','id');
        $mod=Materias::where('esp_id','<>','10')->orderby('mtr_descripcion','asc')->pluck('mtr_descripcion','id');
        $doc=Usuarios::orderby('name','asc')->pluck('name','id');
        $ins=Insumos::where('tipo','I')->orderby('id','asc')->pluck('ins_descripcion','id');

        $jor->put("0","Todos");
        $cur->put("0","Todos");
        $mtr->put("0","Todas");
        $mod->put("0","Todos No Terminados");
        $doc->put("0","Todos");
        $ins->put("0","Todos");

        return view('admin_notas.create')
         ->with('jor', $jor)
         ->with('esp', $esp)
         ->with('cur', $cur)
         ->with('doc', $doc)
         ->with('mtr', $mtr)
         ->with('mod', $mod)
         ->with('ins', $ins)
         ;

    }

    /**
     * Store a newly created AdminNotas in storage.
     *
     * @param CreateAdminNotasRequest $request
     *
     * @return Response
     */
    public function store(CreateAdminNotasRequest $request)
    {
        
         $input = $request->all();
         //dd($input);
         $adminNotas = $this->adminNotasRepository->create($input);
         $aud= new Auditoria();
                 $data=["mod"=>"AdminNotas","acc"=>"Crear","dat"=>$adminNotas,"doc"=>"NA"];
                 $aud->save_adt($data);
         Flash::success('Admin Notas saved successfully.');
         return redirect(route('adminNotas.index'));
    }

    /**
     * Display the specified AdminNotas.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $adminNotas = $this->adminNotasRepository->findWithoutFail($id);
        if (empty($adminNotas)) {
            Flash::error('Admin Notas not found');
            return redirect(route('adminNotas.index'));
        }
        return view('admin_notas.show')->with('adminNotas', $adminNotas);
    }

    /**
     * Show the form for editing the specified AdminNotas.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $adminNotas = $this->adminNotasRepository->findWithoutFail($id);
        $jor=Jornadas::orderby('jor_descripcion','asc')->pluck('jor_descripcion','id');
        $cur=Cursos::orderby('cur_descripcion','asc')->pluck('cur_descripcion','id');
        $esp=Especialidades::orderby('esp_descripcion','asc')->pluck('esp_descripcion','id');
        $mtr=Materias::where('esp_id','10')
                       ->where('id','<>','3')
                       ->where('id','<>','1')
                       ->orderby('mtr_descripcion','asc')->pluck('mtr_descripcion','id');
        $mod=Materias::where('esp_id','<>','10')->orderby('mtr_descripcion','asc')->pluck('mtr_descripcion','id');
        $ins=Insumos::where('tipo','I')->orderby('id','asc')->pluck('ins_descripcion','id');
        $doc=Usuarios::orderby('name','asc')->pluck('name','id');
        $jor->put("0","Todos");
        $cur->put("0","Todos");
        $esp->put("0","Todos");
        $mtr->put("0","Todos");
        $mod->put("0","Todos No Terminados");
        $doc->put("0","Todos");
        $ins->put("0","Todos");
        return view('admin_notas.edit')
        ->with('adminNotas', $adminNotas)
         ->with('jor', $jor)
         ->with('esp', $esp)
         ->with('cur', $cur)
         ->with('doc', $doc)
         ->with('mtr', $mtr)
         ->with('mod', $mod)        
         ->with('ins', $ins)
        ;
    }

    /**
     * Update the specified AdminNotas in storage.
     *
     * @param  int              $id
     * @param UpdateAdminNotasRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAdminNotasRequest $request)
    {
        $adminNotas = $this->adminNotasRepository->findWithoutFail($id);

        if (empty($adminNotas)) {
            Flash::error('Admin Notas not found');

            return redirect(route('adminNotas.index'));
        }

        $adminNotas = $this->adminNotasRepository->update($request->all(), $id);
        $aud= new Auditoria();
                 $data=["mod"=>"AdminNotas","acc"=>"Modificar","dat"=>$adminNotas,"doc"=>"NA"];
                 $aud->save_adt($data);

        Flash::success('Admin Notas updated successfully.');

        return redirect(route('adminNotas.index'));
    }

    /**
     * Remove the specified AdminNotas from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    
    {
        $adminNotas = $this->adminNotasRepository->findWithoutFail($id);
        if (empty($adminNotas)) {
            Flash::error('Admin Notas not found');
            return redirect(route('adminNotas.index'));
        }
        $this->adminNotasRepository->delete($id);
        $aud= new Auditoria();
                 $data=["mod"=>"AdminNotas","acc"=>"Eliminar","dat"=>$adminNotas,"doc"=>"NA"];
                 $aud->save_adt($data);
        Flash::success('Admin Notas deleted successfully.');
        return redirect(route('adminNotas.index'));
    }

    public function busca_especialidades(Request $req){
        $dt=($req->all());
        if($dt['tp']==1){
            $esp=DB::select("select * from especialidades where (id=7 or id=8 or id=10)");
        }else{
            $esp=DB::select("select * from especialidades where (id<>7 and id<>8 and id<>10)");
        }
         $resp="<option value='0'>Todas</option>";
//         $resp="";
         foreach ($esp as $e) {
             $resp.="<option value='$e->id'>$e->esp_descripcion</option>";
         }
         return response()->json($resp);
    }


}
