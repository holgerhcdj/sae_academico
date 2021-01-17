<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMovimientosRequest;
use App\Http\Requests\UpdateMovimientosRequest;
use App\Repositories\MovimientosRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use App\Models\Productos;
use App\Models\ErpDivision;
use App\Models\Auditoria;
use Excel;

class MovimientosController extends AppBaseController
{
    /** @var  MovimientosRepository */
    private $movimientosRepository;

    public function __construct(MovimientosRepository $movimientosRepo)
    {
        $this->movimientosRepository = $movimientosRepo;
    }

    /**
     * Display a listing of the Movimientos.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $movimientos=DB::select(
            "select * from movimientos m
            join productos p on m.proid=p.proid
            join erp_division d on m.div_id=d.div_id"
        );


        return view('movimientos.index')
            ->with('movimientos', $movimientos);
    }

    /**
     * Show the form for creating a new Movimientos.
     *
     * @return Response
     */
    public function create()
    {

 $pro=Productos::pluck('pro_descripcion','proid');
 $div=ErpDivision::pluck('div_descripcion','div_id');




        return view('movimientos.create')
        ->with("pro",$pro)
        ->with("div",$div);
    }

    /**
     * Store a newly created Movimientos in storage.
     *
     * @param CreateMovimientosRequest $request
     *
     * @return Response
     */
    public function store(CreateMovimientosRequest $request)
    {
        $input = $request->all();

        $movimientos = $this->movimientosRepository->create($input);
        $aud= new Auditoria();
                 $data=["mod"=>"Movimientos","acc"=>"Crear","dat"=>$movimientos,"doc"=>"NA"];
                 $aud->save_adt($data);

        Flash::success('Movimientos saved successfully.');

        return redirect(route('movimientos.index'));
    }

    /**
     * Display the specified Movimientos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {

        $movimientos=DB::select(
            "select * from movimientos m
            join productos p on m.proid=p.proid
            join erp_division d on m.div_id=d.div_id"
        );

        return view('movimientos.show')->with('movimientos', $movimientos[0]);
    }

    /**
     * Show the form for editing the specified Movimientos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $movimientos = $this->movimientosRepository->findWithoutFail($id);

        $pro=Productos::pluck('pro_descripcion','proid');
        $div=ErpDivision::pluck('div_descripcion','div_id');

        return view('movimientos.edit')
        ->with('movimientos', $movimientos)
        ->with("pro",$pro)
        ->with("div",$div);
    }

    /**
     * Update the specified Movimientos in storage.
     *
     * @param  int              $id
     * @param UpdateMovimientosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMovimientosRequest $request)
    {
        $movimientos = $this->movimientosRepository->findWithoutFail($id);

        if (empty($movimientos)) {
            Flash::error('Movimientos not found');

            return redirect(route('movimientos.index'));
        }

        $movimientos = $this->movimientosRepository->update($request->all(), $id);
        $aud= new Auditoria();
                 $data=["mod"=>"Movimientos","acc"=>"Modificar","dat"=>$movimientos,"doc"=>"NA"];
                 $aud->save_adt($data);

        Flash::success('Movimientos updated successfully.');

        return redirect(route('movimientos.index'));
    }


    public function destroy($id)
    {
        $movimientos = $this->movimientosRepository->findWithoutFail($id);
        if (empty($movimientos)) {
            Flash::error('Movimientos not found');
            return redirect(route('movimientos.index'));
        }
        $this->movimientosRepository->delete($id);
        $aud= new Auditoria();
                 $data=["mod"=>"Movimientos","acc"=>"Eliminar","dat"=>$movimientos,"doc"=>"NA"];
                 $aud->save_adt($data);

        Flash::success('Movimientos deleted successfully.');
        return redirect(route('movimientos.index'));
    }

    public function subir_inventario(){

      $archivo=DB::select("SELECT * FROM archivos_inventario order by ai_id");
        return view('movimientos.subir_inventario')
        ->with("archivo",$archivo)
        ;
    }

    public function cargar_inventario(Request $rq){
        $dt=$rq->all();

      $nmxs=($dt['archivo']->getClientOriginalName());
      $archivo=DB::select("SELECT * FROM archivos_inventario where ai_archivo='$nmxs' ");
      if(empty($archivo)){

                Excel::load($dt['archivo'], function($reader) {
                            foreach ($reader->get() as $key => $row) {
                              foreach ($row as $rw) {
                                $tp_id=2;
                                $pord=DB::select("INSERT INTO productos (
                                  tpid, 
                                  pro_descripcion, 
                                  pro_medida, 
                                  pro_marca, 
                                  pro_tipo, 
                                  pro_unidad, 
                                  pro_serie, 
                                  pro_codigo, 
                                  pro_estado,
                                  pro_caracteristicas,
                                  pro_color,
                                  pro_valor,
                                  pro_obs                        
                                  )VALUES(
                                  '$tp_id',
                                  '$rw[descripcion]',
                                  '0',
                                  '$rw[marca]',
                                  '$rw[descripcion]',
                                  'UNIDAD',
                                  '$rw[serie]',
                                  '$rw[codigo]',
                                  '0',
                                  '$rw[caracteristicas]',
                                  '$rw[color]',
                                  '$rw[valor_unitario]',
                                  '$rw[observaciones]') returning proid ");

                      //$div=DB::select("select * from erp_division where div_descripcion='$rw[laboratorio]' ");
                                $div_aux=DB::select("SELECT * FROM erp_division WHERE div_codigo='$rw[cod_laboratorio]' ");
                                $gerid=1;
                                if(empty($div_aux)){

                                  try {

                                    $div= DB::select("INSERT INTO erp_division 
                                      ( div_codigo, 
                                      div_descripcion, 
                                      ger_id, 
                                      div_siglas, 
                                      estado )values
                                      ( '$rw[cod_laboratorio]', 
                                      '$rw[laboratorio]', 
                                      '$gerid', 
                                      null,
                                      0) returning div_id ");

                                    $div_id=$div[0]->div_id;

                                  } catch (\Illuminate\Database\QueryException $e) {
                                    dd($e);
                                  }

                                }else{
                                  $div_id=$div_aux[0]->div_id;
                                }

                                $datos['proid']=$pord[0]->proid;
                                $datos['div_id']=$div_id;
                                $datos['movfecha']=date('Y-m-d');
                                $datos['movtipo']=0;
                                $datos['mov']=$rw['cantidad'];
                                $datos['movtpdoc']=0;
                                $datos['movnumdoc']='0';
                                $datos['movvalorunit']=$rw['valor_unitario'];
                                $datos['procaracteristicas']=$rw['caracteristicas'];
                                $datos['proserie']=$rw['serie'];
                                $datos['observaciones']=$rw['observaciones'];
                                $datos['movestado']=0;

                                $movimientos = $this->movimientosRepository->create($datos);


                              }

                            }
                          });


                          DB::select("INSERT INTO archivos_inventario(
                            ai_codigo, 
                            ai_archivo, 
                            ai_fecha, 
                            ai_hora)
                            VALUES (
                            '000',
                            '$nmxs',
                            '".date('Y-m-d')."',
                            '".date('H:s')."'
                            );
                    ");

            }else{
              Flash::error('Archivo ya fue registrado');
            }

              $productos=[];
              $div=ErpDivision::pluck('div_descripcion','div_id');
              return view('productos.index')
              ->with('productos', $productos)
              ->with('div', $div);
    }
}
