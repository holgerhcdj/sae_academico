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

<script>
    /*
    function validar_busqueda(){
        // $("input[name=desde]").val();
        // $("input[name=hasta]").val();
        // if($("input[name=hasta]").val(); < $("input[name=desde]").val();){
        //     alert("La fecha puesta en 'Hasta' es menor que en 'Desde' ");
        // }
    }
*/

$(function(){
   $("#tbl_head").hide();
})    

$(document).on("click","#btn_print",function(){
    $('.frm_acciones').hide();
    $("#tbl_head").show();
    window.print();
        //$('.frm_acciones').show();
    })    
</script>
<style>
/* cuando vayamos a imprimir ... */
@media print{
  *{ -webkit-print-color-adjust: exact; }
  html{ background: none; padding: 0; }
  body{ box-shadow: none; margin: 0; }
}
@page { margin: 0;}
/*.txt_notas{
    width:30px; 
    border:none;
text-align:center; */
}    
</style>
    <section class="content-header">
        <h1 style="text-align: center; background: white; margin: 5px">Novedades de Inspección</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-bottom: 5px" href="{!! route('novedadesInspeccions.create') !!}">Nuevo</a>
        </h1>

<div>
    <form action="buscar_novedades" method="POST" onsubmit='return validar_busqueda()'>
        {{csrf_field()}}
        <table>
            <tr>
                <td><input type="text" style="width:250px " name="nov_estudiantes" class="form-control" placeholder="Nombres/Apellidos del Estudiante"></td>
                <td><h4 style="margin-left: 10px; font-weight: bold">Desde:</h4></td>
                <td><input type="date" style="width:150px " name="desde" class="form-control" value="{{$d}}"></td>
                <td><h4 style="margin-left: 25px;font-weight: bold">Hasta:</h4></td>
                <td><input type="date" style="width:150px " name="hasta" class="form-control" value="{{$h}}"></td>
                <td>
                    {!! Form::select('novedad',[
                    ''=>'Novedad',
                    'MAL UNIFORMADO'=>'MAL UNIFORMADO',
                    'FUGA INTERNA'=>'FUGA INTERNA',
                    'FUGA EXTERNA'=>'FUGA EXTERNA',
                    'MAL COMPORTAMIENTO DENTRO DEL AULA'=>'MAL COMPORTAMIENTO DENTRO DEL AULA',
                    'MAL COMPORTAMIENTO FUERA DEL AULA'=>'MAL COMPORTAMIENTO FUERA DEL AULA',
                    'MAL COMPORTAMIENTO ENTRE COMPANIEROS'=>'MAL COMPORTAMIENTO ENTRE COMPANIEROS',
                    'MAL COMPORTAMIENTO CON EL DOCENTE'=>'MAL COMPORTAMIENTO CON EL DOCENTE',
                    'MAL COMPORTAMIENTO CON LAS AUTORIDADES'=>'MAL COMPORTAMIENTO CON LAS AUTORIDADES',
                    'DANIO A LA INFRAESTRUCTURA GRAFITIS'=>'DANIO A LA INFRAESTRUCTURA GRAFITIS',
                    'DANIO A LA INFRAESTRUCTURA ROTURA DE VIDRIOS'=>'DANIO A LA INFRAESTRUCTURA ROTURA DE VIDRIOS',
                    'DANIO A LA INFRAESTRUCTURA DE PUERTAS'=>'DANIO A LA INFRAESTRUCTURA DE PUERTAS',
                    'DANIO A LA INFRAESTRUCTURA DE BATERIAS SANITARIAS'=>'DANIO A LA INFRAESTRUCTURA DE BATERIAS SANITARIAS',
                    'DANIO A LA INFRAESTRUCTURA ROTURA DE BALDOSAS'=>'DANIO A LA INFRAESTRUCTURA ROTURA DE BALDOSAS',
                    'DANIO A LA INFRAESTRUCTURA TACHOS DE BASURA EXTERNOS'=>'DANIO A LA INFRAESTRUCTURA TACHOS DE BASURA EXTERNOS',
                    'DANIO A LA INFRAESTRUCTURA ROTURA DE CIELO RAZO'=>'DANIO A LA INFRAESTRUCTURA ROTURA DE CIELO RAZO',
                    ],null, ['class' => 'form-control','maxlength'=>35]) !!}
                </td>
    </form>
                <td><input type="submit" name="buscar" class="btn btn-primary" value="Buscar" style="margin-left: 4px"></td>
                <td>
                    <i class="btn btn-info fa fa-print" id="btn_print"> Imprimir</i>
                </td>
            </tr>
        </table>    
</div>

    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('novedades_inspeccions.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

