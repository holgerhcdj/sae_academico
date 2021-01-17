@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class='bg-light-blue text-center col-md-10' style='font-size:18px '>
            Administracion de Evaluaciones
        </div>
        <div class="col-md-2">
           <a class="btn btn-primary pull-right" style="margin-top:-5px;margin-bottom:3px  " href="{!! route('evaluaciones.create') !!}"><i class='fa fa-file'></i>  Nueva</a>
        </div>   
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('evaluaciones.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

