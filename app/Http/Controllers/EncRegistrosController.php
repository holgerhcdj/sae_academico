<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEncRegistrosRequest;
use App\Http\Requests\UpdateEncRegistrosRequest;
use App\Repositories\EncRegistrosRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class EncRegistrosController extends AppBaseController
{
    /** @var  EncRegistrosRepository */
    private $encRegistrosRepository;

    public function __construct(EncRegistrosRepository $encRegistrosRepo)
    {
        $this->encRegistrosRepository = $encRegistrosRepo;
    }

    /**
     * Display a listing of the EncRegistros.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        // $this->encRegistrosRepository->pushCriteria(new RequestCriteria($request));
        // $encRegistros = $this->encRegistrosRepository->all();

        $encuesta=DB::select('select * from enc_encabezado order by enc_numero ');
        return view('enc_registros.index')
            ->with('encRegistros', $encuesta);

    }

    /**
     * Show the form for creating a new EncRegistros.
     *
     * @return Response
     */
    public function create()
    {

        return view('enc_registros.create');
    }

    /**
     * Store a newly created EncRegistros in storage.
     *
     * @param CreateEncRegistrosRequest $request
     *
     * @return Response
     */
    public function store(CreateEncRegistrosRequest $request)
    {
        $input = $request->all();

        $encRegistros = $this->encRegistrosRepository->create($input);

        Flash::success('Enc Registros saved successfully.');

        return redirect(route('encRegistros.index'));
    }

    /**
     * Display the specified EncRegistros.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function finalizar_encuesta(Request $req){
        $dt=$req->all();
        //dd($dt);
        $us=Auth::user()->id;
        $preguntas=DB::select("select * from enc_preguntas p
            join enc_registro_encuestas re on p.prg_id=re.prg_id 
            where re.usu_id=$us
            and p.enc_id=$dt[enc_id]
            ");
        foreach ($preguntas as $p) {
            DB::select("update enc_registro_encuestas set reg_estado=1 where reg_id=".$p->reg_id);

        }        

        return redirect(route('encRegistros.index'));

    }


    public function show($id)
    {
//dd('ok');
        $encabezado=DB::select("select * from enc_encabezado where enc_id=$id");
        $preguntas = DB::select("select * from enc_preguntas p
                                    join enc_grupos g on p.grp_id=g.grp_id
                                    where p.enc_id=$id");
        // $preguntas = DB::table('enc_preguntas as p')
        // ->join('enc_grupos as g', 'p.grp_id', '=', 'g.grp_id')
        // ->orderBy('p.grp_id')
        // ->paginate(10)
        // ;
        return view('enc_registros.show')
        ->with('preguntas', $preguntas)
        ->with('encabezado', $encabezado[0])
        ;
    }

    public function busca_registro_encuesta(Request $req){
        $dt=$req->all();
        $us=Auth::user()->id;
        $preg=DB::select("select * from enc_registro_encuestas where prg_id=$dt[prg_id] and usu_id=$us " );
        return Response()->json($preg);
    }
    public function registra_encuesta(Request $req){
        $dt=$req->all();
        $us=Auth::user()->id;

        $preg=DB::select("select * from enc_registro_encuestas where prg_id=$dt[prg_id] and usu_id=$us " );
        if(!empty($preg)){
            DB::select("delete from enc_registro_encuestas where prg_id=$dt[prg_id] and usu_id=$us  ");
        }
        $rg=DB::select("insert into enc_registro_encuestas (prg_id,usu_id,respuesta)values($dt[prg_id],$us,'$dt[respuesta]') returning reg_id  ");

        return $rg[0]->reg_id;
    }

    /**
     * Show the form for editing the specified EncRegistros.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $us=Auth::user()->id;
        $preguntas = DB::select("select g.grp_id,g.grp_descripcion,p.prg_pregunta,g.grp_valoracion,re.respuesta 
from enc_preguntas p
left join enc_registro_encuestas re on re.prg_id=p.prg_id
join enc_encabezado e on p.enc_id=e.enc_id
join enc_grupos g on p.grp_id=g.grp_id
where e.enc_id=1
and re.usu_id=$us
order by g.grp_id,p.prg_id ");

        return view('enc_registros.edit')->with('preguntas', $preguntas);
    }

    /**
     * Update the specified EncRegistros in storage.
     *
     * @param  int              $id
     * @param UpdateEncRegistrosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEncRegistrosRequest $request)
    {
        $encRegistros = $this->encRegistrosRepository->findWithoutFail($id);

        if (empty($encRegistros)) {
            Flash::error('Enc Registros not found');

            return redirect(route('encRegistros.index'));
        }

        $encRegistros = $this->encRegistrosRepository->update($request->all(), $id);

        Flash::success('Enc Registros updated successfully.');

        return redirect(route('encRegistros.index'));
    }

    /**
     * Remove the specified EncRegistros from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $encRegistros = $this->encRegistrosRepository->findWithoutFail($id);

        if (empty($encRegistros)) {
            Flash::error('Enc Registros not found');

            return redirect(route('encRegistros.index'));
        }

        $this->encRegistrosRepository->delete($id);

        Flash::success('Enc Registros deleted successfully.');

        return redirect(route('encRegistros.index'));
    }


    public function registra_totales_encuesta(Request $req)
    {
        $data=($req->all());
        $rst=DB::select(" SELECT * from  enc_resultados where grp_id=$data[g] and usu_id=$data[u] ");
        if(empty($rst)){
            DB::select("INSERT INTO enc_resultados (grp_id,usu_id,porcentage)values( $data[g],$data[u],$data[v] )");
        }else{
            DB::select("UPDATE enc_resultados set porcentage=$data[v] where rst_id=".$rst[0]->rst_id);
        }
        return 0;

    }








}
