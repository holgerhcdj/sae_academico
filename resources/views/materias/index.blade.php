@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1 class="pull-left">Materias</h1>

    <form action="materias.buscar" method="POST">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <div class="form-group col-sm-4">
            <div class="input-group">
                <select class="form-control" id="tipo" name="tipo" >
                        <option value="0">CULTURAL</option>
                        <option value="1">TÉNICO</option>
                    </select>                    
                <span class="input-group-btn">
                    <input class="btn btn-primary " type="submit" name="search"  value="Buscar" />                    
                </span>
            </div>   
        </div>
    </form>            
    <h1 class="pull-right">
        <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('materias.create') !!}">Nuevo</a>
    </h1>
</section>
<div class="content">
    <div class="clearfix"></div>
    @include('flash::message')
    <div class="clearfix"></div>
    
    <div class="box box-primary">
        <div class="box-body">
            @include('materias.table')
        </div>
    </div>
</div>
@endsection

