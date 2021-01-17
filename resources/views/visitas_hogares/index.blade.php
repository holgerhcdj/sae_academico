@extends('layouts.app')

@section('content')
<?php

if(isset($_POST['buscar']))
{
   $d=$_POST['desde'];
   $h=$_POST['hasta'];
}else{
   $d=date('Y-m-d');
   $h=date('Y-m-d');
}
?>

<section class="content-header">
        <h1 style="text-align: center; background: white; margin: 8px">Visitas Hogares</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="" href="{!! route('visitasHogares.create') !!}">Nuevo</a>
    </h1>    
    
<div>
    <form action="buscar_estudiantes" method="POST">
        {{csrf_field()}}
        <table>
            <tr>
                <td><input type="text" name="estudiantes" class="form-control" placeholder="Estudiante"></td>

                <td><h4 style="margin-left: 10px; font-weight: bold">Tipo de Visita:</h4></td>
                <td><select name="tvisita" class="form-control">
                    <option value="">Todos</option>
                    <option value="0">Regular</option>
                    <option value="1">Especial</option>
                </select></td>

                <td><h4 style="margin-left: 10px; font-weight: bold">Desde:</h4></td>
                <td><input type="date" name="desde" class="form-control" value="{{$d}}"></td>
                <td><h4 style="margin-left: 25px;font-weight: bold">Hasta:</h4></td>
                <td><input type="date" name="hasta" class="form-control" value="{{$h}}"></td>
                <td><input type="submit" name="buscar" class="btn btn-primary" value="Buscar" style="margin-left: 4px"></td>
            </tr>
        </table>    
    </form>
</div>
</section>

    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('visitas_hogares.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

