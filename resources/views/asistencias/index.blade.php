@extends('layouts.app')
@section('scripts')
<script>
</script>
@endsection
@section('content')
<?php
if(isset($_POST['btn_buscar'])){
    $f=$_POST['fecha'];    
}else{
    $f=date("Y-m-d");    
}

?>
    <section class="content-header">
        <h1 class="text-center bg-primary">
            Registro de Asistencia General 
        </h1>
        <br>
        <div class="col-sm-8">
            <form action="buscar_asistencias" method="POST">
                {{csrf_field()}}
                <table>
                    <tr>
                        <td>
                            {!! Form::select('jor_id',$jor,null,['class'=>'form-control']) !!}    
                        </td>
                        <td>
                            {!! Form::select('esp_id',['10'=>'Cultural/General','7'=>'BGU','Básica Flexible'],null,['class'=>'form-control']) !!}    
                        </td>
                        <td>
                            {!! Form::date('fecha',$f,['class'=>'form-control']) !!}    
                        </td>
                        <td>
                            <button class="btn btn-primary" name="btn_buscar" value="btn_buscar">Buscar</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -15px;margin-bottom: 5px" href="{!! route('asistencias.create') !!}">Registrar</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        @include('flash::message')
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @include('asistencias.table')
            </div>
        </div>
    </div>
@endsection

