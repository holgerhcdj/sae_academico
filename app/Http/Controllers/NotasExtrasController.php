<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNotasExtrasRequest;
use App\Http\Requests\UpdateNotasExtrasRequest;
use App\Repositories\NotasExtrasRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\AnioLectivo;
use App\Models\Cursos;
use App\Models\Jornadas;
use App\Models\Especialidades;
use App\Models\Sucursales;
use App\Models\Matriculas;
use App\Models\Estudiantes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Auditoria;

class NotasExtrasController extends AppBaseController
{
    /** @var  NotasExtrasRepository */
    private $notasExtrasRepository;

    public function __construct(NotasExtrasRepository $notasExtrasRepo)
    {
        $this->notasExtrasRepository = $notasExtrasRepo;
    }

    /**
     * Display a listing of the NotasExtras.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $jor = Jornadas::all();
        $esp = Especialidades::all();
        $estudiantes = array();
        $anl_select = AnioLectivo::where('anl_selected', '=', 1)->get();
        return view('notas_extras.index')
                        ->with('estudiantes', $estudiantes)
                        ->with('esp', $esp)
                        ->with('jor', $jor)
                        ->with('anl_select', $anl_select);

    }

    public function buscar($dt){
        $data=explode('&',$dt);
        $anl = AnioLectivo::where('anl_selected', '=', 1)->get();
        $anl_id = $anl[0]['id'];
        $data[3]=strtoupper($data[3]);


        if(trim(strlen($data[3]))>0){
            $dt = DB::select("select * from matriculas m, estudiantes e
            where m.est_id=e.id
            and m.anl_id=$anl_id
            and m.cur_id=6
            and (e.est_cedula like '%$data[3]%' or e.est_apellidos like '%$data[3]%' or e.est_nombres like '%$data[3]%')
            ");
        }else{
            $dt = DB::select("select * from matriculas m, estudiantes e
            where m.est_id=e.id
            and m.anl_id=$anl_id
            and m.jor_id=$data[0]
            and m.esp_id=$data[1]
            and m.cur_id=6
            and m.mat_paralelot='$data[2]' order by e.est_apellidos" );
        }

         return response()->json($dt);
    }

    public function search_note($id){
        $dt = DB::select("select * from reg_notas_extras where est_id=$id");
        return response()->json($dt);
    }    

    public function guarda_nota($dt)
    {
           $dat=explode('&',$dt); 
           $usu = Auth::user();
           $anl = AnioLectivo::where('anl_selected', '=', 1)->get();
           $anl_id = $anl[0]['id'];
           $input=[
            'est_id'=>$dat[0],      
            'anl_id'=>$anl_id,              
            'emi_id'=>1,      
            'f_registro'=>date('d/m/Y'),      
            'cert_primaria'=>$dat[12],      
            'par_estudiantil'=>$dat[13],      
            'ex_enes'=>$dat[14],      
            'responsable'=>$usu->name,      
            'obs'=>$dat[15],      
            'n2'=>$dat[1],      
            'n3'=>$dat[2],      
            'n4'=>$dat[3],      
            'n5'=>$dat[4],      
            'n6'=>$dat[5],      
            'n7'=>$dat[6],      
            'n8'=>$dat[7],      
            'n9'=>$dat[8],      
            'n10'=>$dat[9],      
            'n11'=>$dat[10],      
            'n12'=>$dat[11]
        ];
           $dt = DB::select("select * from reg_notas_extras where est_id=$dat[0] and anl_id=$anl_id");
           if(isset($dt[0])){
            //Modificar
            $id=$dt[0]->id;
            $notasExtras = $this->notasExtrasRepository->update($input, $id);
            $datos = implode("-", array_flatten($notasExtras['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"Requerimientos","acc"=>"Modificar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        

           }else{
            //Insertar
            $notasExtras=$this->notasExtrasRepository->create($input);
            $datos = implode("-", array_flatten($notasExtras['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"Requerimientos","acc"=>"Insertar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        

           }
    return 0;
    }

    public function create(){
        //return 1;
        //  $data=explode('&',$dt);
        //  $estudiantes=[];

        //  Excel::create('Calificaciones', function($excel) use($estudiantes) {
        //     $excel->sheet('Matriz', function($sheet) use($estudiantes) {
        //         $sheet->loadView('reportes.calif');
        //     });
        // })->export('xls');     

         //return response()->json($data);

        //return $data;

    }

    public function store(CreateNotasExtrasRequest $request)
    {
         $input = $request->all();
         $data=explode("&",$input['datos_busqueda']);
        $anl = AnioLectivo::where('anl_selected', '=', 1)->get();
        $anl_id = $anl[0]['id'];
        $dt = DB::select("select e.est_cedula,e.est_apellidos,e.est_nombres,rn.* from matriculas m join estudiantes e
            on (
                m.est_id=e.id 
                and m.anl_id=$anl_id
                and m.jor_id=$data[0]
                and m.esp_id=$data[1]
                and m.cur_id=6
                and m.mat_paralelot='$data[2]' 
            )
            left join reg_notas_extras rn on(
                rn.est_id=e.id
            ) order by e.est_apellidos"  );
        //return view('reportes.calif')->with('est',$dt);

         Excel::create('Calificaciones', function($excel) use($dt) {
            $excel->sheet('Hoja1', function($sheet) use($dt) {
                $w=7;
                $y=(13+count($dt));                
            $sheet->setAutoSize(array(
                     'T','J'
            ));
            $sheet->setWidth(array(
                'A'     =>  5,
                'B'     =>  40,
                'C'     =>  15,
                'D'     =>  $w,
                'E'     =>  $w,
                'F'     =>  $w,
                'G'     =>  $w,
                'H'     =>  $w,
                'I'     =>  $w,
                'K'     =>  $w,
                'L'     =>  $w,
                'M'     =>  $w,
                'N'     =>  $w,
                'O'     =>  $w,
                'P'     =>  $w,
                'Q'     =>  $w,
                'R'     =>  $w,
                'S'     =>  $w,
            ));
            $sheet->setHeight(12, 40);
            $sheet->setFontSize(8);    
            $sheet->cells('A1:T13', function($cells) {
                $cells->setBackground('#F4F4F4');
                $cells->setAlignment('center');
                $cells->setValignment('center');                   
                $cells->setFont(array(
                    'family'     => 'Arial',
                    'bold'       =>  true
                ));                
            });

            $sheet->cells('C14:C100', function($cells) {
                $cells->setAlignment('center');
            });
            $sheet->cells('P14:S100', function($cells) {
                $cells->setAlignment('center');
            });

            $sheet->setColumnFormat(array(
                'D14:I100' => '0.000',
            ));
            $sheet->setColumnFormat(array(
                'K14:O100' => '0.000',
            ));
            $sheet->setBorder('A12:T'.$y, 'thin', "D8572C");
            $sheet->setBorder('A4', 'thin', "D8572C");
            $sheet->setBorder('A11', 'thin', "D8572C");
            $sheet->loadView('reportes.calif')->with('est',$dt);
            });
        })->export('xls');     

    }

    /**
     * Display the specified NotasExtras.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $notasExtras = $this->notasExtrasRepository->findWithoutFail($id);

        if (empty($notasExtras)) {
            Flash::error('Notas Extras not found');

            return redirect(route('notasExtras.index'));
        }

        return view('notas_extras.show')->with('notasExtras', $notasExtras);
    }

    /**
     * Show the form for editing the specified NotasExtras.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $notasExtras = $this->notasExtrasRepository->findWithoutFail($id);

        if (empty($notasExtras)) {
            Flash::error('Notas Extras not found');

            return redirect(route('notasExtras.index'));
        }

        return view('notas_extras.edit')->with('notasExtras', $notasExtras);
    }

    /**
     * Update the specified NotasExtras in storage.
     *
     * @param  int              $id
     * @param UpdateNotasExtrasRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNotasExtrasRequest $request)
    {
        $notasExtras = $this->notasExtrasRepository->findWithoutFail($id);

        if (empty($notasExtras)) {
            Flash::error('Notas Extras not found');

            return redirect(route('notasExtras.index'));
        }
        $notasExtras = $this->notasExtrasRepository->update($request->all(), $id);
        $datos = implode("-", array_flatten($notasExtras['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"Requerimientos","acc"=>"Modificar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        

        Flash::success('Notas Extras updated successfully.');

        return redirect(route('notasExtras.index'));
    }

    /**
     * Remove the specified NotasExtras from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $notasExtras = $this->notasExtrasRepository->findWithoutFail($id);

        if (empty($notasExtras)) {
            Flash::error('Notas Extras not found');

            return redirect(route('notasExtras.index'));
        }

        $this->notasExtrasRepository->delete($id);
        $datos = implode("-", array_flatten($notasExtras['attributes']));
                            $aud= new Auditoria();
                            $data=["mod"=>"Requerimientos","acc"=>"Eliminar","dat"=>$datos,"doc"=>"NA"];
                            $aud->save_adt($data);        

        Flash::success('Notas Extras deleted successfully.');

        return redirect(route('notasExtras.index'));
    }
}
