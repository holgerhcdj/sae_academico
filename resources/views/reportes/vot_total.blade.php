@extends('layouts.app')
@section('content')
<style>
    table tr th, table tr td{
        padding:5px; 
        border:solid 1px burlywood; 
    }
    .total{
        font-family:Arial;
        font-size:25px;
        font-weight:bolder;
        background:#fc7700;
        color:white;
        padding:5px;
        border-radius:5px; 
        text-align:center; 
    }
    .lista{
        font-family:Arial;
        font-size:25px;        
        text-align:center; 
    }
    .form-group{
        text-align:center; 
    }
</style>

<section class="content-header">
    <section class="content-header">
        <h1 style="text-align:center; background:tan; border-radius:2px;">
            REPORTE TOTAL VOTACIONES VIDA NUEVA AÑO LECTIVO {{$anl->anl_descripcion}} 
        </h1>
        <h2>{{"Fecha ".$fecha}}</h2>
    </section>
</section>
<div class="content">
    <div class="box box-primary">
        <a class="btn btn-success" href="rpt_votacion">REPORTE TOTAL</a>
        <div class="box-body">
            <table>
                <thead>
                <th>No</th>
                <th>Lista</th>
                <th>Cedula</th>
                <th>Jornada</th>
                <th>Curso</th>
                <th>Paralelo</th>
                <th>Estudiante</th>
                <th>Fecha y Hora</th>
                </thead>
                <?php $n=1;?>
            @foreach($votos as $v)
            <tr>
                <td>{{$n++}}</td>
                <td>{{$v->lista}}</td>
                <td>{{$v->est_cedula}}</td>
                <td>{{$v->jor_descripcion}}</td>
                <td>{{$v->cur_descripcion}}</td>
                <td>{{$v->mat_paralelo}}</td>
                <td>{{$v->est_apellidos ." ".$v->est_nombres}}</td>
                <td>{{$v->fecha}}</td>
            </tr>
            @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
