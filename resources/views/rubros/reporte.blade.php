@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Reporte de Recaudacion de Rubros</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
            <form action="{!! route('pagoRubros.edit') !!}" method="POST" id='frm_data'>
                <input type="hidden" name="_token" value="{{ csrf_token()}}">
                <input type="hidden" name="rub_id" id="rub_id" value="" />
                <div class="form-group col-sm-2">
                    {!! Form::label('jor_id', 'Jornada:') !!}
                    {!! Form::select('jor_id',$jor,null,['class'=>'form-control']) !!}    
                </div>                
                <div class="form-group col-sm-2">
                    {!! Form::label('cur_id', 'Curso:') !!}
                    {!! Form::select('cur_id',$cur,null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group col-sm-2">
                    {!! Form::label('par_id', 'Paralelo:') !!}
                    {!! Form::select('par_id',[
                '0'=>'Todos',
                'A'=>'A',
                'B'=>'B',
                'C'=>'C',
                'D'=>'D',
                'E'=>'E',
                'F'=>'F',
                'G'=>'G',
                'H'=>'H',
                'I'=>'I'],null,['class'=>'form-control']) !!}    
                </div>
                <div class="input-group">
                    <button style="margin-top:25px" class="btn btn-warning " type="submit" name="search" >
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Jornada</th>
                        <th>Curso</th>
                        <th>Estudiante</th>
                        <th>Racaudado</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection
