<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePagoRubrosRequest;
use App\Http\Requests\UpdatePagoRubrosRequest;
use App\Repositories\PagoRubrosRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Auditoria;
use App\Models\Jornadas;
use App\Models\Cursos;
use Illuminate\Support\Facades\DB;
use App\Models\AnioLectivo;
use Illuminate\Support\Facades\Session;

class PagoRubrosController extends AppBaseController
{
    /** @var  PagoRubrosRepository */
    private $pagoRubrosRepository;
    private $anlid;
    private $anl_bgu;
    public function __construct(PagoRubrosRepository $pagoRubrosRepo)
    {
        $anl = AnioLectivo::find(Session::get('anl_id'));
        $this->anlid = $anl['id'];
        $this->anl_bgu = Session::get('periodo_id');
        $this->pagoRubrosRepository = $pagoRubrosRepo;
    }

    /**
     * Display a listing of the PagoRubros.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $datos=$request->all();
        $anl=$this->anlid;

        if(isset($datos['search']) || isset($datos['search_impr'])){
            if($datos['esp_id']==7){
                $anl=$this->anl_bgu;
            }
            if($datos['par_id']=='0'){
                $sql_par=" ";
            }else{
                $sql_par=" and m.mat_paralelo='$datos[par_id]'";
            }
            if($datos['cur_id']=='0'){
                $sql_cur=" ";
            }else{
                $sql_cur=" and m.cur_id=$datos[cur_id]";
            }
            if($datos['jor_id']=='0'){
                $sql_jor=" ";
            }else{
                $sql_jor=" and m.jor_id=$datos[jor_id]";
            }

            $pagoRubros=DB::select("select j.jor_descripcion,
                                        m.jor_id,
                                        c.cur_descripcion,
                                        m.mat_paralelo,
                                        m.id,
                                        e.est_apellidos,
                                        e.est_nombres,
                                        pr.rub_id,
                                        pr.pgr_tipo,
                                        sum(pr.pgr_monto) as pago
                                        from matriculas m 
                                        join jornadas j on j.id=m.jor_id
                                        join cursos c on c.id=m.cur_id
                                        join estudiantes e on e.id=m.est_id
                                        left join pago_rubros pr on pr.per_id=m.id and pr.rub_id=$datos[rub_id]
                                        where m.anl_id=$anl
                                        $sql_jor 
                                        $sql_cur
                                        $sql_par
                                                      
                                        and m.mat_estado=1
                                        group by j.jor_descripcion,
                                        m.jor_id,
                                        c.cur_descripcion,
                                        m.mat_paralelo,
                                        m.id,
                                        e.est_apellidos,
                                        e.est_nombres,
                                        pr.rub_id,
                                        pr.pgr_tipo   
                                        order by e.est_apellidos  ");

        }else{
            // $this->pagoRubrosRepository->pushCriteria(new RequestCriteria($request));
            $pagoRubros = [];
        }
        $jornadas=Jornadas::orderBy("jor_descripcion","ASC")->pluck("jor_descripcion","id");
         $cursos=Cursos::orderBy("cur_descripcion","ASC")->pluck("cur_descripcion","id");
         $cursos->put("0","Todos");
         $rubro=DB::select("select * from rubros where rub_id=".$datos['rub_id']);      


         if(isset($datos['search_impr'])){
            return view("pago_rubros.rep_pago_cursos")
            ->with('pagoRubros',$pagoRubros)
            ->with("rubro",$rubro)           ;
         }

        return view('pago_rubros.index')
            ->with('pagoRubros',$pagoRubros)
            ->with("jor",$jornadas)
            ->with("cur",$cursos)
            ->with("rubro",$rubro);
    }

    /**
     * Show the form for creating a new PagoRubros.
     *
     * @return Response
     */
    public function create()
    {
        return view('pago_rubros.create');
    }


    public function genera_codigo($rb){
//DD($rb);
        $pgr=DB::select("SELECT pgr_num FROM pago_rubros WHERE rub_id=$rb ORDER BY pgr_num desc limit 1");
        $n=1;
        if(isset($pgr[0])){
            $n=($pgr[0]->pgr_num)+1;
        }
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

    public function store(CreatePagoRubrosRequest $request)
    {

        $usu = Auth::user();//El usuario autentificado

        $input['rub_id']=$request['datos'][0];
        $input['per_id']=$request['datos'][1];
        $input['usu_id']=$usu->id;
        $input['pgr_fecha']=date('Y-m-d');
        $input['pgr_monto']=$request['datos'][2];
        $input['pgr_forma_pago']=$request['datos'][3];
        $input['pgr_banco']=$request['datos'][4];
        $input['pgr_fecha_efectiviza']=date('Y-m-d');
        $input['pgr_documento']=$request['datos'][5];
        $input['pgr_tipo']=0;
        $input['pgr_estado']=0;
        $input['pgr_obs']=$request['datos'][6];

        $input['pgr_num']= $this->genera_codigo($input['rub_id']);

        $pagoRubros = $this->pagoRubrosRepository->create($input);

        $pagos=DB::select("select * from pago_rubros where rub_id=".$input['rub_id']." and per_id=".$input['per_id']);
        return response()->json($pagos);        
    }

    /**
     * Display the specified PagoRubros.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {

        $rubro=DB::select("select * from rubros where rub_id=$id");
        $prubros=DB::select("select j.jor_descripcion,m.jor_id,count(*) as nest,sum(p.pgr_monto) as v from pago_rubros p 
            join matriculas m on p.per_id=m.id 
            join jornadas j on m.jor_id=j.id
            where p.rub_id=$id
            group by m.jor_id,j.jor_descripcion");
        return view('pago_rubros.show_fields')
        ->with('rubro', $rubro)
        ->with('prubros', $prubros);
    }

    /**
     * Show the form for editing the specified PagoRubros.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pagoRubros = $this->pagoRubrosRepository->findWithoutFail($id);
        if (empty($pagoRubros)) {
            Flash::error('Pago Rubros not found');
            return redirect(route('pagoRubros.index'));
        }
        return view('pago_rubros.edit')->with('pagoRubros', $pagoRubros);
    }

    /**
     * Update the specified PagoRubros in storage.
     *
     * @param  int              $id
     * @param UpdatePagoRubrosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePagoRubrosRequest $request)
    {
        $pagoRubros = $this->pagoRubrosRepository->findWithoutFail($id);

        if (empty($pagoRubros)) {
            Flash::error('Pago Rubros not found');

            return redirect(route('pagoRubros.index'));
        }

        $pagoRubros = $this->pagoRubrosRepository->update($request->all(), $id);

        Flash::success('Pago Rubros updated successfully.');

        return redirect(route('pagoRubros.index'));
    }

    /**
     * Remove the specified PagoRubros from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
     public function destroy(Request $req)
    {
         $id=$req->all()['pgr_id'];
         $pagoRubros = $this->pagoRubrosRepository->findWithoutFail($id);
         $this->pagoRubrosRepository->delete($id);
         $pagos=DB::select("select * from pago_rubros where rub_id=".$pagoRubros->rub_id." and per_id=".$pagoRubros->per_id);
         return response()->json($pagos);
    }

    public function imprimir(Request $req){
        $dat=$req->all();
        $rubro=DB::select("select * from rubros where rub_id=".$dat['rub_id']);
        $pagos=DB::select("select * from pago_rubros where rub_id=$dat[rub_id] and per_id=".$dat['per_id'] );
        $estudiante=DB::select("select * from matriculas m 
                                join estudiantes e on m.est_id=e.id 
                                join cursos c on m.cur_id=c.id 
                                join jornadas j on m.jor_id=j.id 
                                join especialidades ep on m.esp_id=ep.id 
                                where m.id=".$dat['per_id']);
        
        return view("rubros.imp_pago")
        ->with("rubro",$rubro)
        ->with("pagos",$pagos)
        ->with("estudiante",$estudiante)
        ;

    }
    public function reporte(){
        $jornadas=Jornadas::orderBy("jor_descripcion","ASC")->pluck("jor_descripcion","id");
        $cursos=Cursos::orderBy("cur_descripcion","ASC")->pluck("cur_descripcion","id");
        return view("rubros.reporte")
        ->with("jor",$jornadas)
        ->with("cur",$cursos);
    }
    
    public function excluye_pago(Request $req){
        $dat=$req->all();

    if($dat['op']==1){
        $usu = Auth::user();//El usuario autentificado
        $input['rub_id']=$dat['rbid'];
        $input['per_id']=$dat['matid'];
        $input['usu_id']=$usu->id;
        $input['pgr_fecha']=date('Y-m-d');
        $input['pgr_monto']=0;
        $input['pgr_forma_pago']=10;//Excluido de pago
        $input['pgr_banco']=null;
        $input['pgr_fecha_efectiviza']=null;
        $input['pgr_documento']=null;
        $input['pgr_tipo']=1;//Excluido o manual
        $input['pgr_estado']=0;
        $input['pgr_obs']=null;
        $pagoRubros = $this->pagoRubrosRepository->create($input);
        return response()->json($pagoRubros->pgr_id); 
    }else{
        $pagado=DB::select("select pgr_id from pago_rubros where per_id=$dat[matid] and rub_id=$dat[rbid] and pgr_tipo=1 ");
        $this->pagoRubrosRepository->delete($pagado[0]->pgr_id);
        return 0;
    }


    }

    public function reporte_cursos($datos){
        // dd($datos);

        // $jornadas=Jornadas::orderBy("jor_descripcion","ASC")->pluck("jor_descripcion","id");
        // $cursos=Cursos::orderBy("cur_descripcion","ASC")->pluck("cur_descripcion","id");
         //return view("pago_rubros.rep_pago_cursos");
        // ->with("jor",$jornadas)
        // ->with("cur",$cursos);

    }



}
