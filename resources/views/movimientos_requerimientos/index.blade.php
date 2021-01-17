@extends('layouts.app')

@section('content')

<?php
if($op==0){
    ?>
    <div class="panel panel-warning">
        <div class="panel-heading" style="font-size:25px;text-align:center;  ">
            Emitidos o Recibidos
            <h1 class="pull-right">
             <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{{ route('requerimiento/create',['id'=>$usu_id]) }}">Nuevo</a>
         </h1>    
     </div>
 </div>
    <?php
}else{
    ?>
    <div class="panel panel-info">
        <div class="panel-heading" style="font-size:25px;text-align:center;  ">
            Recibidos como copia para revisión
     </div>
 </div>
 <?php
}
?>

    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary" style="margin-top:-25px ">
            <div class="box-body">
                    @include('movimientos_requerimientos.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

