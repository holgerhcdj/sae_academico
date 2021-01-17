@extends('layouts.app')
@section('content')
<style>
    table tr th, table tr td{
        padding:5px; 
        border:solid 1px burlywood; 
    }
</style>
<section class="content-header">
    <section class="content-header">
        <h1 style="text-align:center; background:tan; border-radius:2px;  ">
            REPORTE DE CARGA HORARIA / PROFESOR /SEMANA
        </h1>
    </section>
</section>
<div class="content">
    <div class="box box-primary">
        <div class="box-body">
            <div class="form-group">
                <table border="1">
                    <thead>
                        <tr>
                            <th>Docente</th>
                            <th>Jornada</th>
                            <th>Horas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($horarios as $h)
                        <tr>                    
                            <td><?php echo strtoupper($h->usu_apellidos) . " " . strtoupper($h->name) ?></td>
                            <td>{{$h->jor_descripcion}}</td>
                            <td>{{$h->sum}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
