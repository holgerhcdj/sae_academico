@extends('layouts.app')

@section('content')
<?php
if(isset($_POST['btn_buscar'])){
$d=$_POST['desde'];
$h=$_POST['hasta'];
}else{
$d=date('Y-m-d');  
$h=date('Y-m-d');  
}
?>
    <section class="content-header">
        <h1>
            REPORTE GENERAL DE PAGO DE RUBROS 
        </h1>
        <form action="rub_rep_gen" method="POST">
          {{csrf_field()}}
          <table>
            <tr>
              <th>Desde:</th>
              <td><input type="date" name="desde" id="desde" value="{{$d}}" ></td>
              <th>Hasta:</th>
              <td><input type="date" name="hasta" id="hasta" value="{{$h}}" ></td>
              <td>
                <button class="btn btn-primary" name="btn_buscar"><i class="fa fa-search"></i> Buscar</button>
              </td>
            </tr>
          </table>
          
        </form>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
              <table class="table">
                <tr>
                  <th>No</th>
                  <th>Fecha</th>
                  <th>Rubro</th>
                  <th>Estudiante</th>
                  <th>Monto</th>
                  <th>Responsable</th>
                </tr>
              <?php $x=1?>
              @foreach($pagos as $p)
                  <tr>
                    <td>{{$x++}}</td>
                    <td>{{$p->pgr_fecha}}</td>
                    <td>{{$p->rub_descripcion}}</td>
                    <td>{{$p->est_apellidos.' '.$p->est_nombres}}</td>
                    <td align="right">{{number_format($p->pgr_monto,2)}}</td>
                    <td>{{$p->usu_apellidos.' '.$p->name}}</td>
                  </tr>
              @endforeach
              </table>

               </div>
           </div>
       </div>
   </div>
@endsection