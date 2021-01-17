@extends('layouts.app')

@section('content')

<div class="panel panel-info">
    <div class="panel-heading" style="font-size:25px;text-align:center;  ">
        REPORTE DE REQUERIMIENTOS
    </div>
  </div>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary" style="margin-top:-25px;">
            <div class="box-body">
                    @include('requerimientos.table')
            </div>
        </div>
    </div>
@endsection

