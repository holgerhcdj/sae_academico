@extends('layouts.app')
@section('content')
<?php  
$f=date('Y-m-d');
?>
    <section class="content-header">
        <h1>
            Docente {{$user[0]->usu_apellidos.' '.$user[0]->name}}
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
{!! Form::open(['route' => 'segSemanalDocentes.store']) !!}
            {!! Form::hidden('doc_id',$user[0]->id, ['class' => 'form-control']) !!}
            {!! Form::hidden('cap_id',Auth::user()->id,['class' => 'form-control']) !!}
        <table class="">
            <tr>
                <th colspan="2">Fecha</th>
                <th>Nivel Inicial</th>
                <th>Tema-Textos Bíblicos</th>
                <th>Respuesta</th>
                <th>Nivel Final</th>
                <th></th>
            </tr>
            <tr>
                <td colspan="2">
                    {!! Form::date('fecha',$f, ['class' => 'form-control']) !!}
                </td>
                <td>
                    {!! Form::select('nivel',['0'=>'0','1'=>'1','2'=>'2','3'=>'3'],null, ['class' => 'form-control']) !!}
                </td>
                <td style="width:50% ">
                    {!! Form::text('textos_biblicos', null, ['class' => 'form-control']) !!}
                </td>
                <td>
                    {!! Form::text('respuesta', null, ['class' => 'form-control']) !!}
                </td>
                <td>
                    {!! Form::select('nivel_final',['0'=>'0','1'=>'1','2'=>'2','3'=>'3'],null, ['class' => 'form-control']) !!}
                </td>
                <td>
                    <button class="btn btn-primary">+</button>
                </td>
            </tr>
        </table>
{!! Form::close() !!}
<br>
                @include('seg_semanal_docentes.table')

                    <a href="{!! route('seguimientoCapDocentes.index') !!}" class="btn btn-primary">Salir</a>
                </div>
            </div>
        </div>
    </div>
@endsection
