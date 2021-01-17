@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Sanciones de:  {{$est->est_apellidos.' '.$est->est_nombres}}
                    <a class="btn btn-primary pull-right" style="margin-top: -10px;" href="{!! route('sancionados.create',['mat_id'=>$est->mat_id]) !!}">Crear Sanción</a>
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    <table class="table">
                        <tr>
                            <th>#</th>
                            <th>F.Registro</th>
                            <th>Registrado por:</th>
                            <th>Motivo</th>
                            <th>Sanción</th>
                            <th>Desde</th>
                            <th>Hasta</th>
                            <th>Estado</th>
                            <th>...</th>
                        </tr>
                        <?php $x=1;?>
                    @foreach($snc as $s)
                    <tr>
                        <td>{{$x++}}</td>
                        <td>{!!$s->snc_fecha!!}</td>
                        <td>{!!$s->usu_apellidos.' '.$s->name!!}</td>
                        <td>{!!$s->snc_motivo!!}</td>
                        <td>
                            @if($s->snc_resolucion==0)
                            {{'Suspención de Clases'}}
                            @elseif($s->snc_resolucion==1)
                            {{'Cambio de Jornada'}}
                            @elseif($s->snc_resolucion==2)
                            {{'Trabajo Comunitario'}}
                            @elseif($s->snc_resolucion==3)
                            {{'Asistencia a Capellanía'}}
                            @endif
                        </td>
                        <td>{!!$s->snc_finicio!!}</td>
                        <td>{!!$s->snc_ffin!!}</td>
                        <td>
                            @if($s->snc_estado==0)
                            {{'Registrado'}}
                            @elseif($s->snc_estado==1)
                            {{'En ejecución'}}
                            @elseif($s->snc_estado==2)
                            {{'Anulado'}}
                            @elseif($s->snc_estado==3)
                            {{'Suspendido'}}
                            @elseif($s->snc_estado==3)
                            {{'Finalizado'}}
                            @endif
                        </td>
                        <td>
                            <div class='btn-group'>
                                <a href="{!! route('sancionadosSeguimientos.show', [$s->snc_id]) !!}" title="Seguimientos" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-list text-danger"> Seguimientos</i></a>
                                <a href="{!! route('sancionados.edit', [$s->snc_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-pencil text-primary"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
