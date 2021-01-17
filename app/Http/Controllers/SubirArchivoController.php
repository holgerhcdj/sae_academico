<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\CreateRegNotasRequest;
use App\Http\Requests\UpdateRegNotasRequest;
use App\Repositories\RegNotasRepository;
use Illuminate\Support\Facades\Session;
use App\Models\AnioLectivo;
use Illuminate\Support\Facades\DB;
use Excel;
use Storage;

class SubirArchivoController extends Controller
{


    private $regNotasRepository;
    private $anl;
    private $anl_desc;
    public function __construct(RegNotasRepository $regNotasRepo) {

        $this->regNotasRepository = $regNotasRepo;
        $anl = AnioLectivo::find(Session::get('anl_id'));
        $this->anl = $anl['id'];
        $this->anl_desc = $anl['anl_descripcion'];
        //Si no funciona la variable de session revisar el archivo app\Http\Kernel.php
    }

    public function index(Request $req)
    {
        return view('reg_notas.subir_archivo');
    }

    public function store(Request $request)
    {
        //dd('ok');

        if($request->hasFile('notas')){

            $path = $request->file('notas')->getRealPath();
            $linea = 0;
            $archivo = fopen($path, "r");
            $cedula=null;
            $curso=null;
            $paralelo=null;
            $jornada=null;
            $materia=null;
            $quimestre=null;
            $parcial=null;
            $insumo=null;
            $nota=null;
            $cnt_nov=0;
            while (($datos = fgetcsv($archivo, ";")) == true) 
            {
                $linea++;
                $sms=0;
                $dt=explode(";",$datos[0]);
                if($linea>1 && $dt[12]!='Promedio' ){
                    if(strlen($dt[2])==9){
                        $cedula='0'.$dt[2];
                    }else{
                        $cedula=$dt[2];
                    }
                    $est=DB::select("select * from estudiantes where est_cedula='$cedula' ");
                    if(!empty($est)){
                        $mat=DB::select("select * from matriculas where est_id=".$est[0]->id." and anl_id=".$this->anl );
                        if(!empty($mat)){
                            $mat_id=$mat[0]->id;
                            DB::select("set client_encoding to 'latin1'");
                            $insumo=DB::select("select * from insumos where ins_descripcion='$dt[12]' ");
                            if(!empty($insumo)){
                                $ins=$insumo[0]->id;
                                $nota=$dt[13];
                                $materia=DB::select("select * from materias where mtr_descripcion='$dt[8]'  ");
                                if(!empty($materia)){
                                    $mtr=$materia[0]->id;

                                    $dtq=explode(" ",$dt[10]);
                                    $dtp=explode(" ",$dt[11]);

                                    if($dtq[0]=='Primer'){
                                        if($dtp[0]=='Primer'){$parcial=1;}
                                        if($dtp[0]=='Segundo'){$parcial=2;}
                                        if($dtp[0]=='Tercer'){$parcial=3;}
                                    }
                                    if($dtq[0]=='Segundo'){
                                        if($dtp[0]=='Primer'){$parcial=4;}
                                        if($dtp[0]=='Segundo'){$parcial=5;}
                                        if($dtp[0]=='Tercer'){$parcial=6;}
                                    }

                                    if($dt[9]=='SI'){
                                        $mtr_tec_id=$mtr;
                                        $mtr=1;
                                        $parcial=0;
                                    }else{
                                        $mtr_tec_id=0;
                                    }

                                    $data = ['mat_id' => $mat_id,
                                    'ins_id' => $ins,
                                    'nota' => $nota,
                                    'mtr_id' => $mtr,
                                    'periodo' => $parcial,//del 1 al 6
                                    'usu_id' => 1,
                                    'f_modific' => date('Y-m-d'),
                                    'disciplina' => 'A',
                                    'mtr_tec_id' => $mtr_tec_id
                                ];
                                         $this->regNotasRepository->create($data);

                                }else{
                                    $sms="Materia no existe ".$dt[8];
                                    DB::select("INSERT INTO novedades (modulo,novedad)VALUES('REG-NOTAS','$sms')");                      
                                }

                            }else{

                                $sms="Insumo no existe ".$dt[12];
                                DB::select("INSERT INTO novedades (modulo,novedad) VALUES ('REG-NOTAS','$sms') ");                      
                            }

                        }else{
                            $sms="Estudiante No esta Matriculado ".$cedula;
                            DB::select("INSERT INTO novedades (modulo,novedad)VALUES('REG-NOTAS','$sms')");                      
                        }

                    }else{
                        $sms="Estudiante No existe ".$cedula;
                        DB::select("INSERT INTO novedades (modulo,novedad)VALUES('REG-NOTAS','$sms')");                      

                    }



                }

            }
            fclose($archivo);
        }
        return redirect(route('subirNotas.show',$sms));

    }

    public function show($sms){
        // DB::select("TRUNCATE novedades RESTART IDENTITY CASCADE");
        $sms=DB::select("select * from novedades");

        return view('reg_notas.novedades')->with('sms',$sms);
    }


}
