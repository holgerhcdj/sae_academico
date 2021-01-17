@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            ENCUESTA DE CLIMA LABORAL / PERSONAL QUE HA INTERVENIDO
            <a class="btn btn-success" href="{{url('reporte_consolidado_encuesta')}}"><i class="fa fa-print"></i> REPORTE CONSOLIDADO</a>

        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    <table class="table" style="width:50% ">
                        <tr>
                            <th>No</th>
                            <th>Usuario</th>
                            <th>Respuestas /62</th>
                            <th></th>
                        </tr>
                        <?php $x=1;?>
                        @foreach($rep as $en)
                        <tr>
                            <td>{{$x++}}</td>
                            <td>{{$en->usu_apellidos .' '.$en->name}}</td>
                            <td>{{$en->count}}</td>
                            <td><a target="_blank" href="<?php echo url('/reporte_ind_encuestas/'.$en->usu_id.' ') ?>"  ><i class="btn btn-primary btn-xs fa fa-print"></i></a></td>
                        </tr>
                        @endforeach
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
