<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFichaDeceRequest;
use App\Http\Requests\UpdateFichaDeceRequest;
use App\Repositories\FichaDeceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use Session;

class FichaDeceController extends AppBaseController
{
    /** @var  FichaDeceRepository */
    private $fichaDeceRepository;
    private $anl;
    public function __construct(FichaDeceRepository $fichaDeceRepo)
    {
        $this->anl = Session::get('anl_id');
        $this->fichaDeceRepository = $fichaDeceRepo;
    }

    /**
     * Display a listing of the FichaDece.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $fichaDeces = [];
        if(isset($request->all()['search'])){
           $fichaDeces=DB::select(" select *,fd.estado,m.id as mat_id from matriculas m
                join estudiantes e on m.est_id=e.id
                left join ficha_dece fd on m.id=fd.mat_id
                join jornadas j on m.jor_id=j.id
                join especialidades ep on m.esp_id=ep.id
                join cursos c on m.cur_id=c.id
                where m.anl_id=$this->anl
                and e.est_apellidos like '%".strtoupper($request->all()['buscar'])."%'
             ");
        }

        return view('ficha_deces.index')
            ->with('fichaDeces', $fichaDeces);
    }

    /**
     * Show the form for creating a new FichaDece.
     *
     * @return Response
     */
    public function create()
    {
        return view('ficha_deces.create');
    }

    /**
     * Store a newly created FichaDece in storage.
     *
     * @param CreateFichaDeceRequest $request
     *
     * @return Response
     */
    public function store(CreateFichaDeceRequest $request)
    {
        
        $input = $request->all();

        if(isset($input['m_si'])){
                $input['m_si']=0;
        }else{
            $input['m_si']=1;
        }

        if(isset($input['p_si'])){
                $input['p_si']=0;
        }else{
            $input['p_si']=1;
        }

         if(isset($input['rp_si'])){
                $input['rp_si']=0;
        }else{
            $input['rp_si']=1;
        }

        if(isset($input['sb_agua'])){
                $input['sb_agua']=0;
        }else{
            $input['sb_agua']=1;
        }

         if(isset($input['sb_electricidad'])){
                $input['sb_electricidad']=0;
        }else{
            $input['sb_electricidad']=1;
        }

        if(isset($input['sb_alcantarillado'])){
                $input['sb_alcantarillado']=0;
        }else{
            $input['sb_alcantarillado']=1;
        }

         if(isset($input['sb_telefono'])){
                $input['sb_telefono']=0;
        }else{
            $input['sb_telefono']=1;
        }

        if(isset($input['sb_internet'])){
                $input['sb_internet']=0;
        }else{
            $input['sb_internet']=1;
        }

        if(isset($input['sb_azfaltado'])){
                $input['sb_azfaltado']=0;
        }else{
            $input['sb_azfaltado']=1;
        }

        if(isset($input['sa_si'])){
                $input['sa_si']=0;
        }else{
            $input['sa_si']=1;
        }

        if(isset($input['es_discapacidad'])){
                $input['es_discapacidad']=0;
        }else{
            $input['es_discapacidad']=1;
        }
        // dd($input);

        $fichaDece = $this->fichaDeceRepository->create($input);
        Flash::success('Ficha Dece saved successfully.');
        return redirect(route('fichaDeces.index'));
    }

    /**
     * Display the specified FichaDece.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        // dd('ok');
$fexp=DB::select(
"select * from estudiantes e
join matriculas m on m.est_id=e.id
where e.id=$id 
"
);

$mat=DB::select(
"select * from matriculas m
join estudiantes e on e.id=m.est_id
join aniolectivo an on an.id=m.anl_id
join especialidades es on es.id=m.esp_id
join cursos c on c.id=m.cur_id
join jornadas j on j.id=m.jor_id
where e.id=$id 
"
);

$fcap=DB::select("
select * from matriculas m 
join seguimiento_capellania sc on m.id=sc.mat_id 
join users u on sc.usu_id=u.id 
where m.est_id=$id
");

$fnov=DB::select("
select * from matriculas m
join novedades_inspeccion ni on m.id=ni.mat_id
join users u on ni.usu_id=u.id  
where m.est_id=$id
");

$fsdc=DB::select("
select * from matriculas m
join seguimiendo_dece sd on m.id=sd.mat_id
join seg_acciones_dece ad on sd.segid=ad.segid
join users u on ad.usu_id=u.id  
where m.est_id=$id
");

$vth=DB::select("
select * from matriculas m
join visita_hogares vh on m.id=vh.mat_id
join estudiantes e on e.id=m.est_id
join users u on vh.usu_id=u.id  
where m.est_id=$id
");

        return view('ficha_deces.show')
        ->with('fexp', $fexp[0])
        ->with('mat', $mat)
        ->with('fcap', $fcap)
        ->with('fnov', $fnov)
        ->with('fsdc', $fsdc)
        ->with('vth', $vth);
    }


    public function edit($matid)
    {

            $estudiante=DB::select(" select *,m.id as mat_id from matriculas m
                join estudiantes e on m.est_id=e.id
                join jornadas j on m.jor_id=j.id
                join especialidades ep on m.esp_id=ep.id
                join cursos c on m.cur_id=c.id
                where m.id=$matid   ");
            $fichaDece = DB::select("select * from ficha_dece where mat_id=$matid");
            if(empty($fichaDece)){
                return view('ficha_deces.create')
                ->with('est',$estudiante[0])
                ->with('fichaDece',$fichaDece);
                
            }else{
                return view('ficha_deces.edit')
                ->with('est',$estudiante[0])
                ->with('fichaDece',$fichaDece[0]);

            }

    }

    /**
     * Update the specified FichaDece in storage.
     *
     * @param  int              $id
     * @param UpdateFichaDeceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFichaDeceRequest $request)
    {

     //   dd ('ok');
    $input = $request->all();

        if(isset($input['m_si'])){
                $input['m_si']=0;
        }else{
            $input['m_si']=1;
        }
        if(isset($input['p_si'])){
                $input['p_si']=0;
        }else{
            $input['p_si']=1;
        }

         if(isset($input['rp_si'])){
                $input['rp_si']=0;
        }else{
            $input['rp_si']=1;
        }

        if(isset($input['sb_agua'])){
                $input['sb_agua']=0;
        }else{
            $input['sb_agua']=1;
        }

         if(isset($input['sb_electricidad'])){
                $input['sb_electricidad']=0;
        }else{
            $input['sb_electricidad']=1;
        }

        if(isset($input['sb_alcantarillado'])){
                $input['sb_alcantarillado']=0;
        }else{
            $input['sb_alcantarillado']=1;
        }

         if(isset($input['sb_telefono'])){
                $input['sb_telefono']=0;
        }else{
            $input['sb_telefono']=1;
        }

        if(isset($input['sb_internet'])){
                $input['sb_internet']=0;
        }else{
            $input['sb_internet']=1;
        }

        if(isset($input['sb_azfaltado'])){
                $input['sb_azfaltado']=0;
        }else{
            $input['sb_azfaltado']=1;
        }

        if(isset($input['sa_si'])){
                $input['sa_si']=0;
        }else{
            $input['sa_si']=1;
        }

        if(isset($input['es_discapacidad'])){
                $input['es_discapacidad']=0;
        }else{
            $input['es_discapacidad']=1;
        }

        $fichaDece = $this->fichaDeceRepository->update($input, $id);

        Flash::success('Ficha Dece updated successfully.');

        return redirect(route('fichaDeces.index'));
    }

    public function destroy($id)
    {
        $fichaDece = $this->fichaDeceRepository->findWithoutFail($id);

        if (empty($fichaDece)) {
            Flash::error('Ficha Dece not found');

            return redirect(route('fichaDeces.index'));
        }

        $this->fichaDeceRepository->delete($id);

        Flash::success('Ficha Dece deleted successfully.');

        return redirect(route('fichaDeces.index'));
    }

    public function fichapdf($id)
    {
            $ficha=DB::select(" select *,m.id as mat_id from matriculas m
                join estudiantes e on m.est_id=e.id
                join jornadas j on m.jor_id=j.id
                join aniolectivo a on m.anl_id=a.id
                join especialidades ep on m.esp_id=ep.id
                join cursos c on m.cur_id=c.id
                join ficha_dece fd on fd.mat_id=m.id
                where fd.fc_id=$id   ");

        return view('ficha_deces.fichapdf')
        ->with('ficha',$ficha[0])
        ;
    }

    public function expediente_estudiantil(Request $req){
        $datos=$req->all();
        $exp=[];
        if (empty($datos['estudiante'])) {
           $exp=[];
        }else if(!empty($datos['estudiante'])){

             $exp=DB::select(
            "select * from estudiantes e
                where e.est_apellidos like '%".strtoupper($req->all()['estudiante'])."%'
                order by e.est_apellidos"
           );
        }

       return view('ficha_deces.expediente_estudiante')
       ->with('exp', $exp);
    
    }


}
