<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRubrosRequest;
use App\Http\Requests\UpdateRubrosRequest;
use App\Repositories\RubrosRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Response;
use Auth;
use App\Models\Gerencias;

class RubrosController extends AppBaseController
{
    /** @var  RubrosRepository */
    private $rubrosRepository;
    private $mod_id = 28;
    private $anl;
    public function __construct(RubrosRepository $rubrosRepo)
    {
        $this->rubrosRepository = $rubrosRepo;
        $this->anl = Session::get('anl_id');
    }

    /**
     * Display a listing of the Rubros.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $usr=Auth::user();
        $ger=DB::select("(SELECT g.ger_id,g.ger_descripcion from asg_users_departamentos ud
            JOIN departamentos d ON ud.dep_id=d.id
            JOIN erp_gerencia g ON d.ger_id=g.ger_id
            WHERE ud.usu_id=$usr->id
            )
            union all
            ( select g.ger_id,g.ger_descripcion 
            from users u 
            join departamentos d on u.usu_perfil=d.id 
            JOIN erp_gerencia g ON d.ger_id=g.ger_id 
            where u.id=$usr->id
              )
              order by 2 ");

        $dt=$request->all();
        $est=0;
        $gr=$ger[0]->ger_id;
        if(isset($dt['rub_estado'])){
            $est=$dt['rub_estado'];
            $gr=$dt['ger_id'];
        }
        $permisos = $this->permisos($this->mod_id);
        $this->rubrosRepository->pushCriteria(new RequestCriteria($request));
        $rubros = DB::select("
            SELECT r.rub_id,
            r.rub_siglas,
            r.rub_descripcion,
            r.rub_grupo,
            r.rub_valor,
            r.rub_fecha_reg, 
            r.rub_fecha_max,
            r.rub_estado,
            r.usuario,
            r.rub_obs,
            r.rub_no,
            sum(p.pgr_monto)
            from rubros r left join pago_rubros p on r.rub_id=p.rub_id
            where r.rub_estado=$est
            and r.ger_id=$gr
            group by r.rub_id,
            r.rub_descripcion,
            r.rub_grupo,
            r.rub_valor,
            r.rub_fecha_reg, 
            r.rub_fecha_max,
            r.rub_estado,
            r.usuario,
            r.rub_obs  
            order by r.rub_no          
            ");
        return view('rubros.index')
            ->with('rubros', $rubros)
            ->with('permisos', $permisos)
            ->with('ger', $ger)
            ;
    }

    /**
     * Show the form for creating a new Rubros.
     *
     * @return Response
     */
    public function create()
    {
        $ger=Gerencias::pluck("ger_descripcion","ger_id");
        return view('rubros.create')
        ->with("ger",$ger)
        ;
    }

    /**
     * Store a newly created Rubros in storage.
     *
     * @param CreateRubrosRequest $request
     *
     * @return Response
     */
    public function store(CreateRubrosRequest $request)
    {
        $input = $request->all();
        $rst=DB::select("SELECT rub_no FROM rubros where ger_id=$input[ger_id] ORDER BY rub_no DESC limit 1");
        $no=1;
        if(!empty($rst)){
            $no=($rst[0]->rub_no+1);
        }
        $input['rub_no']=$this->codigo_numerico($no);
        $rubros = $this->rubrosRepository->create($input);
        return redirect(route('rubros.index'));
    }

    /**
     * Display the specified Rubros.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function codigo_numerico($n){
        $tx='';
        if($n>0 && $n<10){
            $tx='00000';
        }elseif($n>=10 && $n<100){
            $tx='0000';
        }elseif($n>=100 && $n<1000){
            $tx='000';
        }elseif($n>=1000 && $n<10000){
            $tx='00';
        }elseif($n>=10000 && $n<100000){
            $tx='0';
        }elseif($n>=100000 && $n<1000000){
            $tx='';
        }
        return $tx.$n;
    }

    public function crea_secuenciales(){

        $rst=DB::select("SELECT * FROM rubros ORDER BY rub_id");
        $c=0;
        foreach ($rst as $r){
            $c++;
            $no_rb=$this->codigo_numerico($c);

            DB::select("UPDATE rubros SET rub_no='$no_rb' WHERE rub_id=".$r->rub_id);

            $rst_d=DB::select("SELECT * FROM pago_rubros WHERE rub_id=".$r->rub_id." ORDER BY pgr_id");

            $x=0;
            foreach ($rst_d as $rd) {
                $x++;
                $no=$this->codigo_numerico($x);
                //dd($no); 
                DB::select("UPDATE pago_rubros SET pgr_num='$no' WHERE pgr_id=".$rd->pgr_id);
            }
            
        }

    }
    public function show($id)
    {

        $permisos = $this->permisos($this->mod_id);
        $rubros = $this->rubrosRepository->findWithoutFail($id);
        if (empty($rubros)) {
            Flash::error('Rubros not found');
            return redirect(route('rubros.index'));
        }
        return view('rubros.show')
        ->with('rubros', $rubros)
        ->with('permisos', $permisos);
    }

    /**
     * Show the form for editing the specified Rubros.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
//dd('okk');
        $rubros = $this->rubrosRepository->findWithoutFail($id);
        $ger=Gerencias::pluck("ger_descripcion","ger_id");
        if (empty($rubros)) {
            Flash::error('Rubros not found');
            return redirect(route('rubros.index'));
        }
        return view('rubros.edit')
        ->with('rubros', $rubros)
        ->with('ger', $ger)
        ;
    }

    /**
     * Update the specified Rubros in storage.
     *
     * @param  int              $id
     * @param UpdateRubrosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRubrosRequest $request)
    {
        $inp=$request->all();
        $rubros = $this->rubrosRepository->findWithoutFail($id);
        if($rubros->rub_estado==0 && $inp['rub_estado']==1){
            $inp['rub_obs']='Finalizado por '.Auth::user()->usu_apellidos.' '.Auth::user()->name;
            $inp['rub_fecha_max']=date('Y-m-d');
        }
        // if (empty($rubros)) {
        //     Flash::error('Rubros not found');
        //     return redirect(route('rubros.index'));
        // }

        $rubros = $this->rubrosRepository->update($inp, $id);

        Flash::success('Rubros updated successfully.');

        return redirect(route('rubros.index'));
    }

    /**
     * Remove the specified Rubros from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $rubros = $this->rubrosRepository->findWithoutFail($id);

        if (empty($rubros)) {
            Flash::error('Rubros not found');

            return redirect(route('rubros.index'));
        }

        $this->rubrosRepository->delete($id);

        Flash::success('Rubros deleted successfully.');

        return redirect(route('rubros.index'));
    }

    public function reporte(){
        $pagos=[];
        return view('rubros.reporte_general')->with('pagos',$pagos);
    }


    public function reporte_gen(Request $req){
        $dat=$req->all();
        $d=$dat['desde'];
        $h=$dat['hasta'];
        $pagos=DB::select("select e.est_apellidos,
e.est_nombres,
r.rub_descripcion,
pr.pgr_fecha,
u.name,
u.usu_apellidos,
pr.pgr_monto 
from pago_rubros pr 
join rubros r on pr.rub_id=r.rub_id
join matriculas m on m.id=pr.per_id
join estudiantes e on m.est_id=e.id
join jornadas j on j.id=m.jor_id
join cursos c on c.id=m.cur_id
join users u on u.id=pr.usu_id
where m.anl_id=$this->anl
and pgr_fecha between '$d' and '$h'
and pr.pgr_tipo=0
order by e.est_apellidos");
        return view('rubros.reporte_general')->with('pagos',$pagos);
    }


}
