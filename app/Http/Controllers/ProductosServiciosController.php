<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductosServiciosRequest;
use App\Http\Requests\UpdateProductosServiciosRequest;
use App\Repositories\ProductosServiciosRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use App\Models\Gerencias;

class ProductosServiciosController extends AppBaseController
{
    /** @var  ProductosServiciosRepository */
    private $productosServiciosRepository;

    public function __construct(ProductosServiciosRepository $productosServiciosRepo)
    {
        $this->productosServiciosRepository = $productosServiciosRepo;
    }

    /**
     * Display a listing of the ProductosServicios.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $productosServicios = DB::select("select * from productos_servicios p join erp_gerencia g on p.ger_id=g.ger_id ");
        return view('productos_servicios.index')
            ->with('productosServicios', $productosServicios);
    }

    /**
     * Show the form for creating a new ProductosServicios.
     *
     * @return Response
     */
    public function create()
    {
        $ger=Gerencias::pluck("ger_descripcion","ger_id");
        return view('productos_servicios.create')
        ->with("ger",$ger)
        ;
    }

    /**
     * Store a newly created ProductosServicios in storage.
     *
     * @param CreateProductosServiciosRequest $request
     *
     * @return Response
     */
    public function store(CreateProductosServiciosRequest $request)
    {
        $input = $request->all();


        if( isset($input['cli_id']) ){

            $cli_id=$input['cli_id'];

            if($input['cli_id']==0){
                //Inserta Cliente
                    $dt['cli_fecha']=date('Y-m-d');//Fecha de registro
                    $dt['cli_tipo']=0;
                    $dt['cli_categoria']='A';
                    $dt['cli_codigo']='0';
                    $dt['cli_apellidos']=$input['cli_apellidos'];
                    $dt['cli_nombres']=$input['cli_nombres'];
                    $dt['cli_ced_ruc']=$input['cli_ced_ruc'];
                    $dt['cli_raz_social']=$input['cli_apellidos'].' '.$input['cli_nombres'];
                    $dt['cli_retencion']=0;
                    $dt['cli_cup_maximo']=0;
                    $dt['cli_nacionalidad']='Ecuatoriana';
                    $dt['cli_direccion']=$input['cli_direccion'];
                    $dt['cli_telefono']=$input['cli_telefono'];
                    $dt['cli_email']=$input['cli_email'];

                $cli=DB::select("INSERT INTO erp_i_cliente (
                    cli_fecha,
                    cli_tipo,
                    cli_categoria,
                    cli_codigo,
                    cli_apellidos, 
                    cli_nombres,
                    cli_ced_ruc,
                    cli_raz_social,
                    cli_retencion,
                    cli_cup_maximo, 
                    cli_nacionalidad,
                    cli_direccion,
                    cli_telefono,
                    cli_email )values(
                    '$dt[cli_fecha]',
                    '$dt[cli_tipo]',
                    '$dt[cli_categoria]',
                    '$dt[cli_codigo]',
                    '$dt[cli_apellidos]',
                    '$dt[cli_nombres]',
                    '$dt[cli_ced_ruc]',
                    '$dt[cli_raz_social]',
                    '$dt[cli_retencion]',
                    '$dt[cli_cup_maximo]',
                    '$dt[cli_nacionalidad]',
                    '$dt[cli_direccion]',
                    '$dt[cli_telefono]',
                    '$dt[cli_email]' ) returning cli_id ");
                $cli_id=$cli[0]->cli_id;
            }




            $prod=DB::select("SELECT * FROM productos_servicios WHERE pro_id=".$input['pro_id']);

            $ger_id=$prod[0]->ger_id;
            $fecha=date('Y-m-d');
            $numero=$this->secuencial($input['pro_id']);
            $enc_fac=DB::select("INSERT INTO erp_factura (
            cli_id,
            ger_id,
            fac_fecha_emision, 
            fac_numero
            )VALUES(
            '$cli_id',
            '$ger_id',
            '$fecha',
            '$numero') returning fac_id ");

            $fac_id=$enc_fac[0]->fac_id;
            $pro_id=$input['pro_id'];
            $cnt=$input['dfc_cantidad'];
            $pu=$input['dfc_precio_unit'];
            $pt=$input['dfc_precio_total'];

            DB::select("INSERT INTO erp_det_factura 
                (fac_id,
                pro_id,
                dfc_cantidad,
                dfc_precio_unit,
                dfc_precio_total
                )VALUES(
                '$fac_id',
                '$pro_id',
                '$cnt',
                '$pu',
                '$pt'  ) ");

            $rqst= new Request();

            return $this->reporte_ventas($rqst);

        }else{

            $productosServicios = $this->productosServiciosRepository->create($input);
            Flash::success('Productos Servicios saved successfully.');
            return redirect(route('productosServicios.index'));

        }

    }


    public function secuencial($pro){

        $res=DB::select("SELECT f.fac_numero FROM erp_factura f JOIN erp_det_factura df ON  f.fac_id=df.fac_id where df.pro_id=$pro order by 1 ");
        $tx='';
        if(empty($res)){
            $n=1;
        }else{
            $n=($res[0]->fac_numero+1);
        }


        if ($n>0 && $n<10) {
            $tx='000000';
        }elseif($n>=10 && $n<100){
            $tx='00000';
        }elseif($n>=100 && $n<1000){
            $tx='0000';
        }elseif($n>=1000 && $n<10000){
            $tx='000';
        }elseif($n>=10000 && $n<100000){
            $tx='00';
        }elseif($n>=100000 && $n<1000000){
            $tx='0';
        }elseif($n>=1000000 && $n<10000000){
            $tx='';
        }

        return $tx.$n;

    }

    /**
     * Display the specified ProductosServicios.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $productosServicios = $this->productosServiciosRepository->findWithoutFail($id);

        if (empty($productosServicios)) {
            Flash::error('Productos Servicios not found');

            return redirect(route('productosServicios.index'));
        }

        return view('productos_servicios.show')->with('productosServicios', $productosServicios);
    }

    /**
     * Show the form for editing the specified ProductosServicios.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $productosServicios = $this->productosServiciosRepository->findWithoutFail($id);

        if (empty($productosServicios)) {
            Flash::error('Productos Servicios not found');

            return redirect(route('productosServicios.index'));
        }

        return view('productos_servicios.edit')->with('productosServicios', $productosServicios);
    }

    /**
     * Update the specified ProductosServicios in storage.
     *
     * @param  int              $id
     * @param UpdateProductosServiciosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProductosServiciosRequest $request)
    {
        $productosServicios = $this->productosServiciosRepository->findWithoutFail($id);

        if (empty($productosServicios)) {
            Flash::error('Productos Servicios not found');

            return redirect(route('productosServicios.index'));
        }

        $productosServicios = $this->productosServiciosRepository->update($request->all(), $id);

        Flash::success('Productos Servicios updated successfully.');

        return redirect(route('productosServicios.index'));
    }

    /**
     * Remove the specified ProductosServicios from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $productosServicios = $this->productosServiciosRepository->findWithoutFail($id);

        if (empty($productosServicios)) {
            Flash::error('Productos Servicios not found');

            return redirect(route('productosServicios.index'));
        }

        $this->productosServiciosRepository->delete($id);

        Flash::success('Productos Servicios deleted successfully.');

        return redirect(route('productosServicios.index'));
    }

    public function busca_cliente(Request $rq){
        $dt=$rq->all();
        $ruc=strtoupper($dt['ruc']);
        
        $cli=DB::select("SELECT * FROM erp_i_cliente where cli_apellidos like '%$ruc%' or cli_ced_ruc like '%$ruc%' ");
        $rst="";
        $x=1;
        foreach ($cli as $c) {
            $x++;
            $cliente=$c->cli_id.'*&'.$c->cli_ced_ruc.'*&'.$c->cli_apellidos.'*&'.$c->cli_nombres.'*&'.$c->cli_telefono.'*&'.$c->cli_email.'*&'.$c->cli_direccion;
            $rst.="<tr>
                        <td>$x</td>
                        <td>$c->cli_ced_ruc</td>
                        <td>$c->cli_apellidos $c->cli_nombres</td>
                        <td> <i class='btn btn-success fa fa-check btn_check' data-dismiss='modal' data='$cliente' ></i> </td>
                  </tr>";
        }
        if($rst==""){
            $rst.="<tr><th class='bg-warning'>No Existen Datos  <i class='btn btn-success fa fa-file pull-right' id='btn_nuevo_cliente' data-dismiss='modal' > Crear Nuevo</i> </th></tr> ";

        }

        return Response()->json($rst);

    }

    public function reporte_ventas(Request $rq){

        $dt=$rq->all();
        if(isset($dt['btn_buscar'])){

            if(empty($dt['cliente'])){

                $ventas=DB::select("SELECT * FROM erp_factura f 
                    join erp_i_cliente c on f.cli_id=c.cli_id  
                    join erp_gerencia g on g.ger_id=f.ger_id
                    join erp_det_factura df on df.fac_id=f.fac_id
                    join productos_servicios ps on ps.pro_id=df.pro_id
                    WHERE f.fac_fecha_emision between '$dt[desde]' and '$dt[hasta]'  ");

            }else{

                $ventas=DB::select("SELECT * FROM erp_factura f 
                    join erp_i_cliente c on f.cli_id=c.cli_id  
                    join erp_gerencia g on g.ger_id=f.ger_id
                    join erp_det_factura df on df.fac_id=f.fac_id
                    join productos_servicios ps on ps.pro_id=df.pro_id
                    WHERE f.fac_fecha_emision BETWEEN '$dt[desde]' AND '$dt[hasta]'  AND (c.cli_apellidos like '%$dt[cliente]%' or c.cli_nombres like '%$dt[cliente]%' or c.cli_ced_ruc like '%$dt[cliente]%' ) ");

            }


        }else{
            $ventas = [];
        }

            return view("productos_servicios.reporte_ventas")
            ->with("ventas",$ventas)
            ;

    }
    public function reporte_ventas_ticket($fac_id){

        $venta=DB::select("SELECT * FROM erp_factura f 
            join erp_i_cliente c on f.cli_id=c.cli_id  
            join erp_gerencia g on g.ger_id=f.ger_id
            join erp_det_factura df on df.fac_id=f.fac_id
            join productos_servicios ps on ps.pro_id=df.pro_id
            where f.fac_id=$fac_id
            ");     

        return view("productos_servicios.reporte_ventas_ticket")
        ->with("venta",$venta[0]);


    }




}
