@extends('layouts.app')

@section('content')
<?php
function seg_a_dhms($fechaInicial,$fechaFinal) { 
$seg = strtotime($fechaFinal) - strtotime($fechaInicial);

    $d = floor($seg / 86400);
    $h = floor(($seg - ($d * 86400)) / 3600);
    $m = floor(($seg - ($d * 86400) - ($h * 3600)) / 60);
    $s = $seg % 60; 
return $d." dia/s ".$h." hrs ".$m." min "; 
}
if(empty($req[0]->fecha_finalizacion)){
$fa=date('Y-m-d');
$ha=date('H:i:s');
}else{
$fa=$req[0]->fecha_finalizacion;
$ha=$req[0]->hora_final;

}
$tt= seg_a_dhms($req[0]->fecha_registro.' '.$req[0]->hora_registro,$fa." ".$ha);

?>

<div class="panel panel-info">
    <div class="panel-heading" style="font-size:25px;text-align:center;  ">
      Ruta del Requerimiento No:  {{ $req[0]->codigo }}
      <?php

        if ($req[0]->estado == 0) {
            $estado = 'ACTIVO';
        } else if ($req[0]->estado == 1) {
            $estado = 'FINALIZADO';
        } else {
            $estado = 'ANULADO';
        }      
        ?>

      <label style="float:right; ">{{$estado}}</label>
    </div>
    <div class="panel-body" style="font-size:15px;">
      <label>
        Inicio :  {{$req[0]->fecha_registro}} {{$req[0]->hora_registro}}
      </label>
      <label style="margin-left:20%">      
        Finalización : {{$req[0]->fecha_finalizacion}} {{$req[0]->hora_final}}
      </label> 
      <label style="float:right;">      
        Tiempo Transcurrido : {{$tt}}
      </label> 

    </div>
  </div>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('requerimientos.table_rutas')
                    <a href="{!! route('requerimientos.index') !!}" class="btn btn-success">Atras</a>
                </div>
            </div>
        </div>
    </div>
@endsection
