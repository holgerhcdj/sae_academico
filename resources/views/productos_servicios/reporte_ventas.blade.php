@extends('layouts.app')

@section('content')
<?php
$fd=date('Y-m-d');
$fh=date('Y-m-d');
$cl="";
if(isset($_POST['btn_buscar'])=='btn_buscar'){
    $fd=$_POST['desde'];
    $fh=$_POST['hasta'];
    $cl=$_POST['cliente'];
}

?>
    <section class="content-header">

    <form action="reporte_ventas" method="POST" >
        {{csrf_field()}}
                    <h3 class='bg-primary text-center'>
                        Ventas Realizadas/Productos/Cliente
                    </h3>
                    <div class='col-md-3'>
                        <div class="input-group">
                          {!! Form::label('Cliente/C.C/Ruc:', 'Desde:',['class'=>'input-group-addon']) !!}
                          <input type="text" id="cliente" value="{{$cl}}" name='cliente' class='form-control'>
                      </div>
                  </div>
                    <div class='col-md-3'>
                        <div class="input-group">
                          {!! Form::label('desde', 'Desde:',['class'=>'input-group-addon']) !!}
                          <input type="date" id="desde" value="{{$fd}}" name='desde' class='form-control'>
                      </div>
                  </div>

                  <div class='col-md-3'>
                    <div class="input-group">
                      {!! Form::label('hasta', 'Hasta:',['class'=>'input-group-addon']) !!}
                      <input type="date" id="hasta" value="{{$fh}}" name='hasta' class='form-control'>
                  </div>
              </div>
              <button class='btn btn-primary' id="btn_buscar" name="btn_buscar" value="btn_buscar"><i class='fa fa-search'></i> Buscar</button>
    </form>    

    </section>
    <div class="content">

        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <table class='table'>
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Numero</th>
                            <th>Cliente</th>
                            <th>Producto</th>
                            <th>Total</th>
                            <th>...</th>
                        </tr>
                        <?php $x=1;$tot=0;?>
                        @foreach($ventas as $v)
                        <?php $tot+=$v->dfc_precio_total?>
                        <tr>
                            <td>{{$x++}}</td>
                            <td>{{$v->fac_fecha_emision}}</td>
                            <td>{{$v->fac_numero}}</td>
                            <td>{{$v->cli_apellidos.' '.$v->cli_nombres}}</td>
                            <td>{{$v->pro_descripcion}}</td>
                            <td>{{ number_format($v->dfc_precio_total,2) }} $</td>
                            <td>
                                <a href="{{url('/reporte_ventas/ticket/'.$v->fac_id)}}" target="_blank" class='btn btn-default btn-xs'>
                                    <i class='fa fa-file-pdf-o' style="color:brown "></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        <tr style="font-size:20px ">
                            <th colspan="5" class='text-right'>Total</th>
                            <th>{{number_format($tot,2)}} $</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection