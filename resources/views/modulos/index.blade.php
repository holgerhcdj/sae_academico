@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Modulos</h1>
        <h1 class="pull-right">
            @if(Auth::user()->id==1)
             <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('modulos.create') !!}">Nuevo</a>
            @endif
            
           
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('modulos.table')
            </div>
        </div>
    </div>
@endsection

