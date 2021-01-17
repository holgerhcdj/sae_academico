<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductosRequest;
use App\Http\Requests\UpdateProductosRequest;
use App\Repositories\ProductosRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\ProTipo;
use App\Models\Auditoria;
use App\Models\ErpDivision;
use DB;
use PDF;
use App\Repositories\MovimientosRepository;
use DNS1D;
use DNS2D;

class ProductosController extends AppBaseController
{
    /** @var  ProductosRepository */
    private $productosRepository;
    private $movimientosRepository;

    public function __construct(ProductosRepository $productosRepo,MovimientosRepository $movimientosRepo)
    {
        $this->productosRepository = $productosRepo;
        $this->movimientosRepository = $movimientosRepo;
    }

    /**
     * Display a listing of the Productos.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $dt=$request->all();
        $productos=[];
        if(isset($dt['btn_buscar'])=='buscar'){

            //dd($dt['div_id']);

            $productos=DB::select("SELECT *,(SELECT d.div_descripcion FROM movimientos m JOIN erp_division d ON m.div_id=d.div_id 
                WHERE m.proid=p.proid AND m.div_id=$dt[div_id] ORDER BY m.movid DESC LIMIT 1 ) as division FROM productos p JOIN pro_tipo t ON p.tpid=t.tpid 

                ");

        }elseif(isset($dt['btn_limpiar'])=='limpiar'){

            try {
                $rst=DB::select("TRUNCATE movimientos;");
                //archivos_inventario
                        try {
                            $rst=DB::select("TRUNCATE productos CASCADE;");
                                    try {
                                        $rst=DB::select("TRUNCATE archivos_inventario;");
                                    } catch (\Illuminate\Database\QueryException $e) {
                                        Flash::error( $e->getMessage() );
                                    }
                        } catch (\Illuminate\Database\QueryException $e) {
                            Flash::error( $e->getMessage() );
                        }
            } catch (\Illuminate\Database\QueryException $e) {
                Flash::error( $e->getMessage() );
            }

            
        }

        $div=ErpDivision::pluck('div_descripcion','div_id');
        return view('productos.index')
        ->with('productos', $productos)
        ->with('div', $div);

    }

    /**
     * Show the form for creating a new Productos.
     *
     * @return Response
     */
    public function create()
    {

        $tp_prod=ProTipo::pluck('descripcion','tpid');
        $div=ErpDivision::pluck('div_descripcion','div_id');
        $div->put('0','Seleccione');
        
        return view('productos.create')
        ->with("tp_prod",$tp_prod)
        ->with("div",$div);
    }

    /**
     * Store a newly created Productos in storage.
     *
     * @param CreateProductosRequest $request
     *
     * @return Response
     */
    public function store(CreateProductosRequest $request)
    {
        $input = $request->all();
        $productos = $this->productosRepository->create($input);
        $datos['proid']=$productos->proid;
        $datos['div_id']=$input['div_id'];
        $datos['movfecha']=date('Y-m-d');
        $datos['movtipo']=0;// 0 Ingreso - 1 Egreso
        $datos['mov']=1;//Cantidad 
        $datos['movtpdoc']='0';
        $datos['movnumdoc']='0';
        $datos['movvalorunit']='0';
        $datos['procaracteristicas']='0';
        $datos['proserie']='0';
        $datos['observaciones']='Primer Ingreso';
        $datos['movestado']=0;
        $movimientos = $this->movimientosRepository->create($datos);

        // $aud= new Auditoria();
        //          $data=["mod"=>"Productos","acc"=>"Crear","dat"=>$productos,"doc"=>"NA"];
        //          $aud->save_adt($data);

        Flash::success('Productos guardados correctamente');
        return redirect(route('productos.index'));
    }

    /**
     * Display the specified Productos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $rst=DB::select("SELECT * FROM productos WHERE proid=$id");

                            $resp="<table style='width:100%' border='0'>

                                        <tr><th colspan='3' style='text-align:center' >FUNDACIÓN VIDA NUEVA</th></tr>
                                        <tr>
                                            <th rowspan='3'><img src='data:image/png;base64, ".DNS2D::getBarcodePNG('163213', 'QRCODE',6,6)." '  alt='barcode' /></th>
                                            <th>Codigo:</th><th>".$rst[0]->pro_codigo."</th>
                                        </tr>
                                        <tr>
                                           <th>Serie:</th><th>".$rst[0]->pro_serie."</th>
                                        </tr>
                                        <tr>
                                           <th>Marca:</th><th>".$rst[0]->pro_marca."</th>
                                        </tr>
                                        <tr>
                                           <th colspan='3'>".$rst[0]->pro_descripcion."</th>
                                        </tr>

                            </table>";

                         $pdf=PDF::loadHTML($resp)->setPaper([0, 0, 250, 400], 'landscape');
                         return $pdf->stream();

    }

    /**
     * Show the form for editing the specified Productos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $productos = $this->productosRepository->findWithoutFail($id);
        $tp_prod=ProTipo::pluck('descripcion','tpid');
        $div=ErpDivision::pluck('div_descripcion','div_id');
        $div->put('0','Seleccione');

        $mov=DB::select("SELECT * FROM movimientos WHERE proid=$id order by movid desc limit 1 ");
        $dv=0;
        if(!empty($mov)){
            $dv=$mov[0]->div_id;
        }

        return view('productos.edit')->with('productos', $productos)
                ->with("tp_prod",$tp_prod)
                ->with("div",$div)
                ->with("dv",$dv)
                ;
    }

    /**
     * Update the specified Productos in storage.
     *
     * @param  int              $id
     * @param UpdateProductosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProductosRequest $request)
    {
        $input=$request->all();
        //$productos = $this->productosRepository->findWithoutFail($id);
        $productos = $this->productosRepository->update($input, $id);

        $mov=DB::select("SELECT * FROM movimientos where proid=$id order by movid desc limit 1 ");

        $datos['proid']=$id;
        $datos['div_id']=$input['div_id'];
        $datos['movfecha']=date('Y-m-d');
            $datos['movtipo']=$mov[0]->movtipo;// 0 Ingreso - 1 Egreso
            $datos['mov']=$mov[0]->mov;//Cantidad 
            $datos['movtpdoc']=$mov[0]->movtpdoc;
            $datos['movnumdoc']=$mov[0]->movnumdoc;
            $datos['movvalorunit']=$mov[0]->movvalorunit;
            $datos['procaracteristicas']=$productos->pro_caracteristicas;
            $datos['proserie']=$productos->pro_serie;
            $datos['observaciones']=$productos->pro_obs;
            $datos['movestado']=0;

        if($input['div_id']!=$mov[0]->div_id){
            $movimientos = $this->movimientosRepository->create($datos);
        }else{
            $movimientos = $this->movimientosRepository->update($datos,$mov[0]->movid);
        }
        $aud= new Auditoria();
                 $data=["mod"=>"Productos","acc"=>"Modificar","dat"=>$productos,"doc"=>"NA"];
                 $aud->save_adt($data);
        Flash::success('Productos updated successfully.');
        return redirect(route('productos.index'));

    }

    /**
     * Remove the specified Productos from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $productos = $this->productosRepository->findWithoutFail($id);
        if (empty($productos)) {
            Flash::error('Productos not found');
            return redirect(route('productos.index'));
        }
        $this->productosRepository->delete($id);
        $aud= new Auditoria();
                 $data=["mod"=>"Productos","acc"=>"Eliminar","dat"=>$productos,"doc"=>"NA"];
                 $aud->save_adt($data);
        Flash::success('Productos deleted successfully.');
        return redirect(route('productos.index'));
    }
}
