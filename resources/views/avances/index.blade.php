@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Avances</h1>

        <form action="avances.index" method="POST">
            {{csrf_field()}}
            <div class="row">
                <div class="col-xs-7">
                    <div class="input-group">
                        <select name="estado" id="estado" class="form-control">
                            <option value="0">Activo</option>
                            <option value="2">Finalizado</option>
                        </select>
                        <span class="input-group-btn">
                            <button type="submit" name="btn_search" value="btn_search" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </span>
                        <span class="input-group-btn">
                            <a class="btn btn-primary pull-right" style="margin-left:100px" href="{!! route('avances.create') !!}">Nuevo</a>
                        </span>
                    </div>
                </div>
            </div>
        </form>

    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('avances.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

