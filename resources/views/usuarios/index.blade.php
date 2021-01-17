@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">LISTA DE USUARIOS</h1>
        <h1 class="pull-right">
            @if($pr[0]==1)
            <a class="btn btn-primary pull-right" style="margin-top:0px;" href="{!! route('usuarios.create') !!}">Nuevo</a>
            @endif
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        @include('flash::message')
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('usuarios.table')
            </div>
        </div>
    </div>
@endsection

