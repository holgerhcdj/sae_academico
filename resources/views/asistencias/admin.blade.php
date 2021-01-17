@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Administrar Registro de Asistencias</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('asistencias.table')
            </div>
        </div>
    </div>
@endsection

