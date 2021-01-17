@extends('layouts.app')

@section('content')
<?php
isset($_POST['btn_buscar'])?$fd=$_POST['desde']:$fd=date('Y-m-d');
isset($_POST['btn_buscar'])?$fh=$_POST['hasta']:$fh=date('Y-m-d');
?>
    <section class="content-header">
        <h1 class="bg-primary text-center">Reporte de Asistencias </h1>
        <br>
        <table style="border:solid 1px #ccc ">
            <tr>
                <td>Desde:&nbsp;</td>
                <td>
                    <form action="registroAsistencias.index" method="POST"  >
                        {{ csrf_field() }}
                        <input type="date" name="desde" value="{{$fd}}" class="form-control" >
                    </td>
                    <td>Hasta:&nbsp;</td>
                    <td>
                        <input type="date" name="hasta" value="{{$fh}}" class="form-control">
                    </td>
                    <td>
                        <button type="submit" name="btn_buscar" value="buscar" class="btn btn-primary">Buscar</button>
                    </form>
                </td>

                <td style="padding-left:100px " >
                 <form action="registroAsistencias.store" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="file" name="archivo" class="pull-right" style="width:200px; " >
                </td>
                <td>
                    <button type="submit" name="btn_subir" class="btn btn-primary">Subir</button>
                </form>
                    
                </td>
            </tr>
        </table>
        
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('registro_asistencias.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

